<?php

/*
 * Plugin Name: Compassion Child Import from Odoo
 * Version:     0.0.2
 * Author:      giftGRUEN GmbH / adaptations Compassion Suisse | J.Kläy 11.07.2017
*/
defined('ABSPATH') || die();

require_once(__DIR__ . '/vendor/autoload.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

use \WPHelper as WP;

function addQuotes($childNumber) {
    return "'" . $childNumber . "'";
}


/**
 * Called on plugin activation.
 */
function child_import_activation() {
    child_import_check_dependencies();
}
register_activation_hook(__FILE__, 'child_import_activation');

function child_import_check_dependencies() {
    if(!class_exists('CompassionPosts')) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( sprintf(__( 'Please install and activate: %s.', 'compassion' ), 'compassion-posts'), 'Plugin dependency check', array( 'back_link' => true ) );
    }
}

class ChildOdooImport
{
    public function __construct()
    {
        ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
    }

    public function getCountryIdByCode($country_code, $lang='fr')
    {
        global $wpdb;

        $results = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '$country_code' AND meta_key = '_cmb_country_code'");
        foreach ($results as $row) {
            $post_lang = $wpdb->get_var(
                "SELECT language_code FROM compassion_icl_translations WHERE element_type = 'post_location' AND element_id = $row->post_id");
            if ($post_lang == $lang)
                return $row->post_id;
        }
        return false;
    }

    public function importChild($child)
    {
        global $sitepress;
        global $wpdb;

        $check_if_exists = $wpdb->get_results("SELECT post_id FROM compassion_postmeta pm INNER JOIN compassion_posts p ON p.ID = pm.post_id WHERE pm.meta_value = '".$child['number']."' AND pm.meta_key = '_child_number' AND p.post_status != 'trash' ");
        if(sizeof($check_if_exists)>=1) {
            error_log('******* Child is already online ********  : '.sizeof($check_if_exists));
            return 1;
        }
        
        if($child['first_name']!='' AND $child['desc']!='' AND $child['number']!='') {
            /**
             * Insert children
             */
                $childId = wp_insert_post([
                    'post_type' => 'child',
                    'post_title' => ucwords(strtolower($child['first_name'])),
                    'post_content' => $child['desc'],
                    'post_status' => 'publish'
                ]);
                $child_trid = $sitepress->get_element_trid($childId);
                $deId = wp_insert_post([
                    'post_type' => 'child',
                    'post_title' => ucwords(strtolower($child['first_name'])),
                    'post_content' => $child['desc_de'],
                    'post_status' => 'publish'
                ]);
                $itId = wp_insert_post([
                    'post_type' => 'child',
                    'post_title' => ucwords(strtolower($child['first_name'])),
                    'post_content' => $child['desc_it'],
                    'post_status' => 'publish'
                ]);
                $sitepress->set_element_language_details($deId, 'post_child', $child_trid, 'de');
                $sitepress->set_element_language_details($itId, 'post_child', $child_trid, 'it');

                $country_code = substr($child['number'], 0, 2);
                $countryId = $this->getCountryIdByCode($country_code, 'fr');

                update_post_meta($childId, '_child_name', ucwords(strtolower($child['first_name'])));
                update_post_meta($childId, '_child_country', $countryId);
                update_post_meta($childId, '_child_birthday', strtotime($child['birthday']));
                update_post_meta($childId, '_child_gender', ($child['gender'] == 'F' || $child['gender'] == 'f') ? 'girl' : 'boy');
                update_post_meta($childId, '_child_start_date', strtotime($child['start_date']));
                update_post_meta($childId, '_child_description', $child['desc']);
                update_post_meta($childId, '_child_project', $child['project']);
                update_post_meta($childId, '_child_number', $child['number']);
                update_post_meta($childId, '_child_reserved', 'false');
                update_post_meta($childId, '_child_reserved_expiration', '9000-01-01');

                $countryId = $this->getCountryIdByCode($country_code, 'de');
                update_post_meta($deId, '_child_name', ucwords(strtolower($child['first_name'])));
                update_post_meta($deId, '_child_country', $countryId);
                update_post_meta($deId, '_child_birthday', strtotime($child['birthday']));
                update_post_meta($deId, '_child_gender', ($child['gender'] == 'F' || $child['gender'] == 'f') ? 'girl' : 'boy');
                update_post_meta($deId, '_child_start_date', strtotime($child['start_date']));
                update_post_meta($deId, '_child_description', $child['desc_de']);
                update_post_meta($deId, '_child_project', $child['project_de']);
                update_post_meta($deId, '_child_number', $child['number']);
                update_post_meta($deId, '_child_reserved', 'false');
                update_post_meta($deId, '_child_reserved_expiration', '9000-01-01');

                $countryId = $this->getCountryIdByCode($country_code, 'it');
                update_post_meta($itId, '_child_name', ucwords(strtolower($child['first_name'])));
                update_post_meta($itId, '_child_country', $countryId);
                update_post_meta($itId, '_child_birthday', strtotime($child['birthday']));
                update_post_meta($itId, '_child_gender', ($child['gender'] == 'F' || $child['gender'] == 'f') ? 'girl' : 'boy');
                update_post_meta($itId, '_child_start_date', strtotime($child['start_date']));
                update_post_meta($itId, '_child_description', $child['desc_it']);
                update_post_meta($itId, '_child_project', $child['project_it']);
                update_post_meta($itId, '_child_number', $child['number']);
                update_post_meta($itId, '_child_reserved', 'false');
                update_post_meta($itId, '_child_reserved_expiration', '9000-00-00');

                $child['fifu_url'] = str_replace('w_150', 'g_face,c_thumb,w_320,h_420,z_0.6', $child['cloudinary_url']);
                $child['portrait_url'] = str_replace('w_150', 'g_face,c_crop,w_180,h_180,z_0.9', $child['cloudinary_url']);

                update_post_meta($childId, 'fifu_image_url', $child['fifu_url']);
                update_post_meta($deId, 'fifu_image_url', $child['fifu_url']);
                update_post_meta($itId, 'fifu_image_url', $child['fifu_url']);

                update_post_meta($childId, '_child_portrait', $child['portrait_url']);
                update_post_meta($deId, '_child_portrait', $child['portrait_url']);
                update_post_meta($itId, '_child_portrait', $child['portrait_url']);

            if($childId!='' AND $deId!='' AND $itId!='') {
                error_log("Child ".$child['first_name']." imported successfully.");
                return 1;
            }
            
            return 0;
            
        }

        return 0;
        
     }

    public function deleteChildren($children) {
        /**
         * $children: array of child codes
         */
        global $wpdb;
        $query = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_child_number' AND meta_value IN (%s)";
        $result_query = $wpdb->get_results(sprintf($query, implode(array_map("addQuotes", $children), ",")));

        $post_ids = array();
        foreach($result_query as $row) {
            array_push($post_ids, $row->post_id);
        }

        if ($post_ids) {
            $query = "DELETE FROM compassion_posts WHERE ID IN (%s)";
            $query_pm = "DELETE FROM compassion_postmeta WHERE post_id IN (%s)";
            $wpdb->query(sprintf($query, implode($post_ids, ",")));
            $wpdb->query(sprintf($query_pm, implode($post_ids, ",")));
            
        }

        $picturePath = ABSPATH . 'wp-content/uploads/child-import/*';
        $files = glob($picturePath);
        foreach($files as $file){
            if(is_file($file) and in_array(substr(basename($file), 0, 11), $children))
                unlink($file);
        }

//        foreach ($children as $child) {
//            $wpdb->query("DELETE FROM compassion_posts WHERE post_type = 'attachment' AND guid LIKE '%" . $child . "%';");
//        }

        return true;
    }
    
    public function deleteAllChildren() {
        $this->deleteChildren($this->getChildrenCodesWithoutReserved());
    }

    public function getChildrenCodesWithoutReserved() {
        global $wpdb;
        $querystr = "SELECT DISTINCT meta_key,
                                     meta_value
                     FROM compassion_postmeta
                     WHERE post_id IN
                         (SELECT compassion_postmeta.post_id
                          FROM compassion_posts
                          JOIN compassion_postmeta ON compassion_posts.ID = compassion_postmeta.post_id
                          WHERE compassion_posts.post_type = 'child'
                            AND compassion_postmeta.meta_key = '_child_reserved'
                            AND compassion_postmeta.meta_value = 'false'
                          UNION SELECT compassion_postmeta.post_id
                          FROM compassion_posts
                          JOIN compassion_postmeta ON compassion_posts.ID = compassion_postmeta.post_id
                          WHERE compassion_posts.post_type = 'child'
                            AND compassion_postmeta.meta_key = '_child_reserved_expiration'
                            AND compassion_postmeta.meta_value < now())
                       AND meta_key = '_child_number'";
        $res = $wpdb->get_results($querystr);

        $a = array();
        foreach ($res as $row) {
            array_push($a, $row->meta_value);
        }
        return $a;
    }
     
}


/**
 * XMLRPC Call to import new children in database. A CSV file must be placed beforehand in the plugin uploads folder
 * with name uploaded-file. Child photos must as well be present wp-content/uploads/child-import
 * @param $args (user, password)
 * @return mixed
 */
function child_import_addChild( $args ) {
    global $wp_xmlrpc_server;
    $wp_xmlrpc_server->escape( $args );

    $username  = $args[0];
    $password  = $args[1];
    $childarray = $args[2];
    if(sizeof($childarray)>1 AND isset($childarray['name']) AND isset($childarray['local_id'])) {
	error_log('Cloudinary URL : '.$childarray['cloudinary_url']);
	error_log('Name : '.$childarray['name']);
	error_log('Local ID : '.$childarray['local_id']);
    } else {
	error_log('array not found');
        return false;
    }

    if ( !$user = $wp_xmlrpc_server->login($username, $password) )
        return $wp_xmlrpc_server->error;

    error_log('########## start to import ###########');

    $childOdooImport = new ChildOdooImport();
    if($childOdooImport->importChild($childarray)) {
        fifu_db_insert_attachment();
        update_option('fifu_fake_created', true, 'no');
        return '1';
    }
    return '0';
    
};

/**
 * XMLRPC Call to delete given children (by child code).
 * @param $args (user, password, children_codes)
 */
function child_import_deleteChildren($args){
    global $wp_xmlrpc_server;
    $wp_xmlrpc_server->escape( $args );

    $username  = $args[0];
    $password  = $args[1];

    if ( !$user = $wp_xmlrpc_server->login($username, $password) )
        return $wp_xmlrpc_server->error;

    $childImport = new ChildOdooImport();
    return $childImport->deleteChildren($args[2]);
}

/**
 * XMLRPC Call to delete all children
 * @param $args (user, password)
 */
function child_import_deleteAllChildren($args){
    global $wp_xmlrpc_server;
    $wp_xmlrpc_server->escape( $args );

    $username  = $args[0];
    $password  = $args[1];

    if ( !$user = $wp_xmlrpc_server->login($username, $password) )
        return $wp_xmlrpc_server->error;

    $childImport = new ChildOdooImport();
    return $childImport->deleteAllChildren();
}



function child_import_odoo_xmlrpc_methods($methods) {
    $methods['child_import.addChild'] = 'child_import_addChild';
    $methods['child_import.deleteChildren'] = 'child_import_deleteChildren';
    $methods['child_import.deleteAllChildren'] = 'child_import_deleteAllChildren';
    return $methods;
};

add_filter('xmlrpc_methods', 'child_import_odoo_xmlrpc_methods');
