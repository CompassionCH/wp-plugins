<?php

/*
 * Plugin Name: Compassion Connector to Odoo
 * Description: Both Odoo connectors cannot be active at the same time and must be activated <strong>after</strong> "Compassion Letters"
 * Version:     10.0.1
 * Author:      Compassion Suisse | J. Kläy
 */
defined('ABSPATH') || die();


require_once 'vendor/autoload.php';

use GuzzleHttp\Client as JsonRpcClient;

class CompassionOdooConnector {

    private $odoo_host = ODOO_HOST;
    private $odoo_db = ODOO_DB;
    private $odoo_user = ODOO_USER;
    private $odoo_password = ODOO_PASSWORD;
    private $uid;
    private $models;

    public function __construct() {
        // Initialize JSON-RPC client for authentication
        $common = new JsonRpcClient(['base_uri' => $this->odoo_host]);

        // Authentication request
        $response = $common->post('/jsonrpc', [
            'json' => [
                'jsonrpc' => '2.0',
                'params' => [
                    'service' => 'common',
                    'method' => 'authenticate',
                    'args' => [
                        $this->odoo_db,
                        $this->odoo_user,
                        $this->odoo_password,
                        null,
                    ],
                ],
            ]
        ]);

        // Handle response
        if ($response->getStatusCode() !== 200) {
            error_log('Error during Odoo authentication: ' . $response->getBody());
            return;
        }

        $result = json_decode($response->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('JSON decoding error: ' . json_last_error_msg());
            return;
        }

        if (!empty($result['error'])) {
            error_log('Error in Odoo response: ' . $result['error']['message']);
            return;
        }

        $this->uid = $result['result'] ?? null;
        $this->models = $common; // Initialize client for "object" endpoint
    }

    /**
     * Functions for sending via JSON-RPC to Odoo
     */
    public function reserveChild($local_id): void
    {
        global $wpdb;
        // Retrieve the child in Odoo by local_id
        $wished_hold_type = 'No Money Hold';
        $child_search = $this->call_method('compassion.child', 'search_read', [
            [
                ['local_id', '=', $local_id]
            ],
            ['fields' => ['id']]
        ]);
        if (empty($child_search)) {
            error_log('error getting child by local_id');
            return;
        }
        $child_id = $child_search[0]['id'];

        $hold_ids = $this->getHoldByChildId($child_id);

        if (!is_null($hold_ids)) {
            foreach ($hold_ids as $index => $hold) {
                $hold_id = $hold['id'];

                // Set the expiration date (8 days for margin)
                $date = new DateTime('8 days');
                $expiration_date = $date->format('Y-m-d H:i:s');

                // Update in Odoo
                $this->call_method('compassion.hold', 'write', [
                    [$hold_id],
                    [
                        'type' => $wished_hold_type,
                        'expiration_date' => $expiration_date,
                    ]
                ]);

                // Read again to verify the updated type
                $updated_holds = $this->getHoldByChildId($child_id);
                $final_hold_type = $updated_holds[$index]['type'];

                // Reservation in WordPress
                if ($wished_hold_type === $final_hold_type) {
                    $posts_id = $this->getPostsIdByLocalId($local_id);
                    foreach ($posts_id as $post_id) {
                        $querystr = "UPDATE $wpdb->postmeta 
                            SET meta_value = 'true' 
                            WHERE post_id = $post_id AND meta_key = '_child_reserved'";
                        $res = $wpdb->query($querystr);
                        if (!$res) {
                            error_log('error setting child reservation metadata to true');
                        }

                        $expiration_date_wp = (new DateTime('7 days'))->format('Y-m-d');
                        $querystr = "UPDATE $wpdb->postmeta 
                            SET meta_value = '$expiration_date_wp' 
                            WHERE post_id = $post_id AND meta_key = '_child_reserved_expiration'";
                        $res = $wpdb->query($querystr);
                        if (!$res) {
                            error_log('error setting child reservation expiration date');
                        }
                    }
                } else {
                    error_log('error changing child hold type in odoo');
                }
            }
        } else {
            error_log('error getting hold id from odoo');
        }
    }

    public function getHoldByChildId($child_id) {
        return $this->call_method('compassion.hold', 'search_read', [
            [
                ['child_id', '=', $child_id]
            ],
            ['fields' => ['hold_id', 'type']]
        ]);
    }

    public function getPostsIdByLocalId($local_id): array
    {
        global $wpdb;
        $querystr = "SELECT post_id FROM compassion_postmeta WHERE meta_value = '$local_id'";
        $res = $wpdb->get_results($querystr);
        $a = [];
        foreach ($res as $row) {
            $a[] = $row->post_id;
        }
        return $a;
    }

    /**
     * Sending raw donation to Odoo.
     */
    public function send_donation_info($donnation_infos) {
        return $this->call_method('account.move', 'process_wp_confirmed_donation', array($donnation_infos));
    }

    /**
     * Generic function to call any method on Odoo
     * @param $model   string: the name of odoo model
     * @param $method  string: the name of the method
     * @param $params  array:  parameters to the odoo function
     * @return mixed   the result of the method
     */
    public function call_method(string $model, string $method, array $params): mixed
    {
        $response = $this->models->post("/jsonrpc", [
            'json' => [
                'jsonrpc' => '2.0',
                'params' => [
                    'service' => 'object',
                    'method' => 'execute_kw',
                    'args' => [
                        $this->odoo_db,
                        $this->uid,
                        $this->odoo_password,
                        $model,
                        $method,
                        $params
                    ],
                ],
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            error_log('Error calling Odoo method: ' . $response->getBody());
            return false;
        }

        $result = json_decode($response->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('JSON decoding error: ' . json_last_error_msg());
            return false;
        }

        if (!empty($result['error'])) {
            error_log('Error in Odoo response: ' . $result['error']['message']);
            return false;
        }

        return $result['result'] ?? false;
    }
}
