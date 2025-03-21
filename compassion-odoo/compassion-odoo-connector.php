<?php

/*
 * Plugin Name: Compassion Connector to Odoo V10 only
 * Description: WARNING: only works with Odoo <strong>V10</strong>. Both Odoo connectors cannot be active at the same time and must be activated <strong>after</strong> "Compassion Letters"
 * Version:     10.0.1
 * Author:      Compassion Suisse | J. Kläy
 */
defined('ABSPATH') || die();


require_once 'vendor/autoload.php';

use JsonRpc\Client as JsonRpcClient;

class CompassionOdooConnector {

    private $odoo_host = ODOO_HOST;
    private $odoo_db = ODOO_DB;
    private $odoo_user = ODOO_USER;
    private $odoo_password = ODOO_PASSWORD;
    private $uid;
    private $models;

    public function __construct() {
        // Initialization of the JSON-RPC client for the "common" endpoint
        $common = new JsonRpcClient($this->odoo_host . '/jsonrpc/common');
        // Call of the authentication method
        $this->uid = $common->execute("authenticate", [
            $this->odoo_db,
            $this->odoo_user,
            $this->odoo_password,
            []
        ]);
        // Initialization of the JSON-RPC client for the "object" endpoint
        $this->models = new JsonRpcClient($this->odoo_host . '/jsonrpc/object');
    }

    /**
     * Functions for sending via JSON-RPC to Odoo
     */
    public function getPartnerById($partner_id) {
        $res = $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'res.partner',
            'search_read',
            [
                [
                    ['id', '=', $partner_id],
                ]
            ]
        ]);
        error_log(serialize($res));

        if ($res && isset($res->faultString)) {
            return false;
        }
        return $res;
    }

    public function reserveChild($local_id) {
        global $wpdb;
        // Retrieve the child in Odoo by local_id
        $wished_hold_type = 'No Money Hold';
        $child_search = $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'compassion.child',
            'search_read',
            [
                [
                    ['local_id', '=', $local_id]
                ],
                ['fields' => ['id']]
            ]
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
                $this->models->execute("execute_kw", [
                    $this->odoo_db,
                    $this->uid,
                    $this->odoo_password,
                    'compassion.hold',
                    'write',
                    [
                        [$hold_id],
                        [
                            'type' => $wished_hold_type,
                            'expiration_date' => $expiration_date,
                        ]
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
        return $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'compassion.hold',
            'search_read',
            [
                [
                    ['child_id', '=', $child_id]
                ]
            ],
            ['fields' => ['hold_id', 'type']]
        ]);
    }

    public function getPostsIdByLocalId($local_id) {
        global $wpdb;
        $querystr = "SELECT post_id FROM compassion_postmeta WHERE meta_value = '$local_id'";
        $res = $wpdb->get_results($querystr);
        $a = [];
        foreach ($res as $row) {
            $a[] = $row->post_id;
        }
        return $a;
    }

    public function searchPartnerByPartnerRefCity($partner_ref, $city) {
        $res = $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'res.partner',
            'search_read',
            [
                [
                    ['ref', '=', $partner_ref],
                    ['city', 'ilike', $city],
                ]
            ]
        ]);
        error_log(serialize($res));

        if ($res && isset($res->faultString)) {
            return false;
        }
        return $res;
    }

    public function searchContractByPartnerRefChildCode($partner_ref, $child_code) {
        $search_contracts = $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'recurring.contract',
            'search_count',
            [
                [
                    ['partner_id', '=', trim($partner_ref)],
                    ['child_code', '=', trim(strtoupper($child_code))],
                ]
            ]
        ]);

        if ($search_contracts > 0) {
            $search_contract = $this->models->execute("execute_kw", [
                $this->odoo_db,
                $this->uid,
                $this->odoo_password,
                'recurring.contract',
                'search_read',
                [
                    [
                        ['partner_id', '=', trim($partner_ref)],
                        ['child_code', '=', trim(strtoupper($child_code))],
                    ],
                    ['fields' => ['name', 'partner_codega', 'partner_id', 'child_code', 'reference']],
                    0, // offset
                    1, // limit
                    'create_date DESC ' // order
                ]
            ]);
            return $search_contract;
        }
        return false;
    }

    public function searchContractByPartnerLastNameChildCode($last_name, $child_code) {
        $search_contracts = $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'recurring.contract',
            'search_count',
            [
                [
                    ['partner_id.lastname', 'ilike', trim($last_name)],
                    ['child_code', '=', trim(strtoupper($child_code))],
                ]
            ]
        ]);

        if ($search_contracts > 0) {
            $search_contract = $this->models->execute("execute_kw", [
                $this->odoo_db,
                $this->uid,
                $this->odoo_password,
                'recurring.contract',
                'search_read',
                [
                    [
                        ['partner_id.lastname', 'ilike', trim($last_name)],
                        ['child_code', '=', trim(strtoupper($child_code))],
                    ],
                    ['fields' => ['name', 'partner_codega', 'partner_id', 'child_code', 'reference']],
                    0,
                    1,
                    'create_date DESC '
                ]
            ]);
            return $search_contract;
        }
        return false;
    }

    public function searchContractByPartnerEmailChildCode($email, $child_code) {
        $search_contracts = $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'recurring.contract',
            'search_count',
            [
                [
                    ['partner_id.email', 'ilike', trim($email)],
                    ['child_code', '=', trim(strtoupper($child_code))],
                ]
            ]
        ]);

        if ($search_contracts > 0) {
            $search_contract = $this->models->execute("execute_kw", [
                $this->odoo_db,
                $this->uid,
                $this->odoo_password,
                'recurring.contract',
                'search_read',
                [
                    [
                        ['partner_id.email', 'ilike', trim($email)],
                        ['child_code', '=', trim(strtoupper($child_code))],
                    ],
                    ['fields' => ['name', 'partner_codega', 'partner_id', 'child_code', 'reference']],
                    0,
                    1,
                    'create_date DESC '
                ]
            ]);
            return $search_contract;
        }
        return false;
    }

    public function searchPartnerByEmailNameCity($email, $last_name, $first_name, $city) {
        $search_partner = $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'res.partner',
            'search_count',
            [
                [
                    ['email', 'ilike', $email],
                    ['lastname', 'ilike', $last_name],
                    ['firstname', 'ilike', $first_name],
                    ['city', 'ilike', $city],
                    '|', ['active', '=', true], ['active', '=', false]
                ]
            ]
        ]);

        if ($search_partner == 1) {
            return $this->models->execute("execute_kw", [
                $this->odoo_db,
                $this->uid,
                $this->odoo_password,
                'res.partner',
                'search',
                [
                    [
                        ['email', 'ilike', $email],
                        ['lastname', 'ilike', $last_name],
                        ['firstname', 'ilike', $first_name],
                        ['city', 'ilike', $city],
                        '|', ['active', '=', true], ['active', '=', false]
                    ]
                ]
            ]);
        } else {
            $search_partner = $this->models->execute("execute_kw", [
                $this->odoo_db,
                $this->uid,
                $this->odoo_password,
                'res.partner',
                'search_count',
                [
                    [
                        ['email', 'ilike', $email],
                        ['lastname', 'ilike', $last_name],
                        ['firstname', 'ilike', $first_name],
                        '|', ['active', '=', true], ['active', '=', false]
                    ]
                ]
            ]);

            if ($search_partner == 1) {
                return $this->models->execute("execute_kw", [
                    $this->odoo_db,
                    $this->uid,
                    $this->odoo_password,
                    'res.partner',
                    'search',
                    [
                        [
                            ['email', 'ilike', $email],
                            ['lastname', 'ilike', $last_name],
                            ['firstname', 'ilike', $first_name],
                            '|', ['active', '=', true], ['active', '=', false]
                        ]
                    ]
                ]);
            } else {
                $search_partner = $this->models->execute("execute_kw", [
                    $this->odoo_db,
                    $this->uid,
                    $this->odoo_password,
                    'res.partner',
                    'search_count',
                    [
                        [
                            ['email', 'ilike', $email],
                            '|', ['active', '=', true], ['active', '=', false]
                        ]
                    ]
                ]);

                if ($search_partner == 1) {
                    return $this->models->execute("execute_kw", [
                        $this->odoo_db,
                        $this->uid,
                        $this->odoo_password,
                        'res.partner',
                        'search',
                        [
                            [
                                ['email', 'ilike', $email],
                                '|', ['active', '=', true], ['active', '=', false]
                            ]
                        ]
                    ]);
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public function createPartner($last_name, $first_name, $street, $zipcode, $city, $email, $country, $language) {
        $odoo_countries = array();
        $odoo_countries['Schweiz']     = 44;
        $odoo_countries['Suisse']      = 44;
        $odoo_countries['Deutschland'] = 58;
        $odoo_countries['Allemagne']   = 58;
        $odoo_countries['Österreich']  = 13;
        $odoo_countries['Autriche']    = 13;
        $odoo_countries['Frankreich']  = 76;
        $odoo_countries['France']      = 76;
        $odoo_countries['Italien']     = 110;
        $odoo_countries['Italie']      = 110;

        $new_partner = $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'res.partner',
            'create',
            [
                [
                    'customer'   => true,
                    'lastname'   => stripslashes(ucfirst(trim($last_name))),
                    'firstname'  => stripslashes(ucfirst(trim($first_name))),
                    'street'     => stripslashes(ucfirst(trim($street))),
                    'zip'        => stripslashes(trim($zipcode)),
                    'city'       => stripslashes(ucfirst(trim($city))),
                    'country_id' => $odoo_countries[$country],
                    'lang'       => str_replace('it_CH', 'it_IT', str_replace('_FR', '_CH', str_replace('de_CH', 'de_DE', trim($language)))),
                    'email'      => stripslashes(trim($email)),
                    'state'      => 'pending',
                ]
            ]
        ]);

        return $new_partner;
    }

    public function createInvoiceWithObjects($partner_id, $origin, $amount, $fund, $child_id, $pf_pm, $pf_payid, $pf_brand, $utm_source, $utm_medium, $utm_campaign) {
        $payment_mode = trim(($pf_pm != $pf_brand ? $pf_pm.' '.$pf_brand : $pf_brand));
        return $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            'account.invoice',
            'create_from_wordpress',
            [
                $partner_id, $origin, $amount, $fund, $child_id, $pf_payid, $payment_mode, $utm_source, $utm_medium, $utm_campaign
            ]
        ]);
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
    public function call_method($model, $method, $params) {
        return $this->models->execute("execute_kw", [
            $this->odoo_db,
            $this->uid,
            $this->odoo_password,
            $model,
            $method,
            $params
        ]);
    }
}
