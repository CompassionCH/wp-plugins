<?php
/*
 * Plugin Name: Compassion Child Import REST API
 * Version:     0.0.2
 * Author:      giftGRUEN GmbH / adaptations Compassion Suisse | Adapted to REST API
 */
defined('ABSPATH') || die();

require_once(__DIR__ . '/vendor/autoload.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');


/**
 * Adds quotes around a child's number.
 */
function addQuotes($childNumber) {
    return "'" . $childNumber . "'";
}

class ChildOdooImport {

    public function __construct() {
        ini_set('max_execution_time', 1200); // 20 minutes
    }

    public function getCountryIdByCode($country_code, $lang='fr') {
        global $wpdb;
        if ($country_code == 'ID') {
            $country_code = 'IO';
        }
        $results = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '$country_code' AND meta_key = '_cmb_country_code'");
        foreach ($results as $row) {
            $post_lang = $wpdb->get_var(
                "SELECT language_code FROM compassion_icl_translations WHERE element_type = 'post_location' AND element_id = $row->post_id"
            );
            if ($post_lang == $lang)
                return $row->post_id;
        }
        return false;
    }

    public function importChild($child) {
        global $sitepress;
        global $wpdb;

        // Check if the child already exists
        $check_if_exists = $wpdb->get_results("SELECT post_id FROM compassion_postmeta pm INNER JOIN compassion_posts p ON p.ID = pm.post_id WHERE pm.meta_value = '".$child['number']."' AND pm.meta_key = '_child_number' AND p.post_status != 'trash' ");
        if (sizeof($check_if_exists) >= 1) {
            error_log('******* Child is already online ********  : ' . sizeof($check_if_exists));
            return 1;
        }

        if ($child['first_name'] != '' && $child['desc'] != '' && $child['number'] != '') {

            // Inserting the child in French
            $childId = wp_insert_post([
                'post_type'    => 'child',
                'post_title'   => ucwords(strtolower($child['first_name'])),
                'post_content' => $child['desc'],
                'post_status'  => 'publish'
            ]);

            // Creating German and Italian translations
            $child_trid = $sitepress->get_element_trid($childId);
            $deId = wp_insert_post([
                'post_type'    => 'child',
                'post_title'   => ucwords(strtolower($child['first_name'])),
                'post_content' => $child['desc_de'],
                'post_status'  => 'publish'
            ]);
            $itId = wp_insert_post([
                'post_type'    => 'child',
                'post_title'   => ucwords(strtolower($child['first_name'])),
                'post_content' => $child['desc_it'],
                'post_status'  => 'publish'
            ]);
            $sitepress->set_element_language_details($deId, 'post_child', $child_trid, 'de');
            $sitepress->set_element_language_details($itId, 'post_child', $child_trid, 'it');

            // Determining the country from the number
            $country_code = substr($child['number'], 0, 2);
            $countryId = $this->getCountryIdByCode($country_code, 'fr');

            // Adding metadata in French
            update_post_meta($childId, '_child_name', ucwords(strtolower($child['first_name'])));
            update_post_meta($childId, '_child_country', $countryId);
            update_post_meta($childId, '_child_birthday', strtotime($child['birthday']));
            update_post_meta($childId, '_child_gender', (strtolower($child['gender']) == 'f') ? 'girl' : 'boy');
            update_post_meta($childId, '_child_start_date', strtotime($child['start_date']));
            update_post_meta($childId, '_child_description', $child['desc']);
            update_post_meta($childId, '_child_project', $child['project']);
            update_post_meta($childId, '_child_number', $child['number']);
            update_post_meta($childId, '_child_reserved', 'false');
            update_post_meta($childId, '_child_reserved_expiration', '9000-01-01');

            // Adding metadata in German
            $countryId = $this->getCountryIdByCode($country_code, 'de');
            update_post_meta($deId, '_child_name', ucwords(strtolower($child['first_name'])));
            update_post_meta($deId, '_child_country', $countryId);
            update_post_meta($deId, '_child_birthday', strtotime($child['birthday']));
            update_post_meta($deId, '_child_gender', (strtolower($child['gender']) == 'f') ? 'girl' : 'boy');
            update_post_meta($deId, '_child_start_date', strtotime($child['start_date']));
            update_post_meta($deId, '_child_description', $child['desc_de']);
            update_post_meta($deId, '_child_project', $child['project_de']);
            update_post_meta($deId, '_child_number', $child['number']);
            update_post_meta($deId, '_child_reserved', 'false');
            update_post_meta($deId, '_child_reserved_expiration', '9000-01-01');

            // Adding metadata in Italian
            $countryId = $this->getCountryIdByCode($country_code, 'it');
            update_post_meta($itId, '_child_name', ucwords(strtolower($child['first_name'])));
            update_post_meta($itId, '_child_country', $countryId);
            update_post_meta($itId, '_child_birthday', strtotime($child['birthday']));
            update_post_meta($itId, '_child_gender', (strtolower($child['gender']) == 'f') ? 'girl' : 'boy');
            update_post_meta($itId, '_child_start_date', strtotime($child['start_date']));
            update_post_meta($itId, '_child_description', $child['desc_it']);
            update_post_meta($itId, '_child_project', $child['project_it']);
            update_post_meta($itId, '_child_number', $child['number']);
            update_post_meta($itId, '_child_reserved', 'false');
            update_post_meta($itId, '_child_reserved_expiration', '9000-00-00');

            // Processing images
            $child['fifu_url'] = str_replace('w_150', 'g_face,c_thumb,w_320,h_420,z_0.6', $child['cloudinary_url']);
            $child['portrait_url'] = str_replace('w_150', 'g_face,c_crop,w_180,h_180,z_0.9', $child['cloudinary_url']);
            update_post_meta($childId, 'fifu_image_url', $child['fifu_url']);
            update_post_meta($deId, 'fifu_image_url', $child['fifu_url']);
            update_post_meta($itId, 'fifu_image_url', $child['fifu_url']);
            update_post_meta($childId, '_child_portrait', $child['portrait_url']);
            update_post_meta($deId, '_child_portrait', $child['portrait_url']);
            update_post_meta($itId, '_child_portrait', $child['portrait_url']);

            if ($childId && $deId && $itId) {
                error_log("Child " . $child['first_name'] . " imported successfully.");
                return 1;
            }
            return 0;
        }
        return 0;
    }

    public function deleteChildren($children) {
        global $wpdb;
        $query = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_child_number' AND meta_value IN (%s)";
        $result_query = $wpdb->get_results(sprintf($query, implode(",", array_map("addQuotes", $children))));
        $post_ids = array();
        foreach ($result_query as $row) {
            $post_ids[] = $row->post_id;
        }
        if ($post_ids) {
            $wpdb->query(sprintf("DELETE FROM compassion_posts WHERE ID IN (%s)", implode(",", $post_ids)));
            $wpdb->query(sprintf("DELETE FROM compassion_postmeta WHERE post_id IN (%s)", implode(",", $post_ids)));
        }
        $picturePath = ABSPATH . 'wp-content/uploads/child-import/*';
        $files = glob($picturePath);
        foreach ($files as $file) {
            if (is_file($file) && in_array(substr(basename($file), 0, 11), $children))
                unlink($file);
        }
        return true;
    }

    public function deleteAllChildren() {
        $this->deleteChildren($this->getChildrenCodesWithoutReserved());
    }

    public function getChildrenCodesWithoutReserved() {
        global $wpdb;
        $querystr = "SELECT DISTINCT meta_key, meta_value
                     FROM compassion_postmeta
                     WHERE post_id IN (
                        SELECT compassion_postmeta.post_id
                        FROM compassion_posts
                        JOIN compassion_postmeta ON compassion_posts.ID = compassion_postmeta.post_id
                        WHERE compassion_posts.post_type = 'child'
                          AND compassion_postmeta.meta_key = '_child_reserved'
                          AND compassion_postmeta.meta_value = 'false'
                        UNION
                        SELECT compassion_postmeta.post_id
                        FROM compassion_posts
                        JOIN compassion_postmeta ON compassion_posts.ID = compassion_postmeta.post_id
                        WHERE compassion_posts.post_type = 'child'
                          AND compassion_postmeta.meta_key = '_child_reserved_expiration'
                          AND compassion_postmeta.meta_value < now()
                     )
                     AND meta_key = '_child_number'";
        $res = $wpdb->get_results($querystr);
        $codes = array();
        foreach ($res as $row) {
            $codes[] = $row->meta_value;
        }
        return $codes;
    }
}

/**
 * Callback to add a child via the REST API.
 * Expected: a JSON containing a "child" key with all the data.
 */
function child_import_add_child_handler(WP_REST_Request $request) {
    error_log("child_import_add_child_handler: Starting request processing.");

    $params = $request->get_json_params();
    error_log("Received JSON parameters: " . print_r($params, true));

    if (!isset($params['child'])) {
        error_log("Error: The 'child' parameter is missing.");
        return new WP_Error('missing_parameter', 'The "child" parameter is required.', array('status' => 400));
    }

    $childarray = $params['child'];
    error_log("Received child data: " . print_r($childarray, true));

    if (sizeof($childarray) > 1 && isset($childarray['name']) && isset($childarray['local_id'])) {
        error_log("Cloudinary URL : " . $childarray['cloudinary_url']);
        error_log("Name : " . $childarray['name']);
        error_log("Local ID : " . $childarray['local_id']);
    } else {
        error_log("Child data not found or incorrect format: " . print_r($childarray, true));
        return new WP_Error('invalid_child', 'Invalid child data.', array('status' => 400));
    }

    $childOdooImport = new ChildOdooImport();
    $result = $childOdooImport->importChild($childarray);
    error_log("Result of importChild: " . print_r($result, true));

    if ($result) {
        if (function_exists('fifu_db_insert_attachment')) {
            fifu_db_insert_attachment();
        } else {
            error_log("The function fifu_db_insert_attachment() is not defined, skipping this step.");
        }
        update_option('fifu_fake_created', true, 'no');
        error_log("Child imported successfully.");
        return rest_ensure_response(array('success' => true));
    }

    error_log("Child import failed.");
    return rest_ensure_response(array('success' => false));
}


/**
 * Callback to delete children via the REST API.
 * Expected: a JSON containing a "children" key with an array of child codes.
 */
function child_import_delete_children_handler(WP_REST_Request $request) {
    $params = $request->get_json_params();
    if ( !isset($params['children']) ) {
        return new WP_Error('missing_parameter', 'The "children" parameter is required.', array('status' => 400));
    }
    $children_codes = $params['children'];
    $childImport = new ChildOdooImport();
    $result = $childImport->deleteChildren($children_codes);
    return rest_ensure_response(array('success' => $result));
}

/**
 * Callback to delete all children via the REST API.
 */
function child_import_delete_all_children_handler(WP_REST_Request $request) {
    $childImport = new ChildOdooImport();
    $childImport->deleteAllChildren();
    return rest_ensure_response(array('success' => true));
}

/**
 * Registering REST API routes.
 */
function child_import_register_rest_routes() {
    register_rest_route('child-import/v1', '/add-child', array(
        'methods'             => 'POST',
        'callback'            => 'child_import_add_child_handler',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
    register_rest_route('child-import/v1', '/delete-children', array(
        'methods'             => 'DELETE',
        'callback'            => 'child_import_delete_children_handler',
        'permission_callback' => function() {
            return current_user_can('delete_posts');
        }
    ));
    register_rest_route('child-import/v1', '/delete-all-children', array(
        'methods'             => 'DELETE',
        'callback'            => 'child_import_delete_all_children_handler',
        'permission_callback' => function() {
            return current_user_can('delete_posts');
        }
    ));
}
add_action('rest_api_init', 'child_import_register_rest_routes');
