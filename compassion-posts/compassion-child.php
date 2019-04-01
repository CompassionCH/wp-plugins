<?php


class CompassionChildren
{
    public function __construct()
    {
        add_action('init', array($this, 'init'), 0);
        add_filter('cmb2_admin_init', array($this, 'child_settings'));
        add_filter('views_edit-child', array($this, 'modified_views_so_15799171'));
        add_filter('display_post_states', array($this, 'child_post_states'), 10, 2 );
    }

    /**
     * Called by init action.
     */
    public function init()
    {
        $this->register_post_type_child();
        $this->register_ajax_recommend_child();
    }

    public function register_post_type_child() {
        $labels = array(
            'name'                  => _x( 'Kind', 'Post Type General Name', 'compassion-posts' ),
            'singular_name'         => _x( 'Kind', 'Post Type Singular Name', 'compassion-posts' ),
            'menu_name'             => __( 'Kinder', 'compassion-posts' ),
            'name_admin_bar'        => __( 'Kinder', 'compassion-posts' ),
            'archives'              => __( 'Kinder', 'compassion-posts' ),
            'parent_item_colon'     => __( 'Parent:', 'compassion-posts' ),
            'all_items'             => __( 'Alle Kinder', 'compassion-posts' ),
            'add_new_item'          => __( 'Neues Kind eintragen', 'compassion-posts' ),
            'add_new'               => __( 'Neu', 'compassion-posts' ),
            'new_item'              => __( 'Neues Kind', 'compassion-posts' ),
            'edit_item'             => __( 'Kind bearbeiten', 'compassion-posts' ),
            'update_item'           => __( 'Kind aktualisieren', 'compassion-posts' ),
            'view_item'             => __( 'Kind ansehen', 'compassion-posts' ),
            'search_items'          => __( 'Kind suchen', 'compassion-posts' ),
            'not_found'             => __( 'Nicht gefunden', 'compassion-posts' ),
            'not_found_in_trash'    => __( 'Nicht im Papierkorb gefunden', 'compassion-posts' ),
            'featured_image'        => __( 'Featured Image', 'compassion-posts' ),
            'set_featured_image'    => __( 'Set featured image', 'compassion-posts' ),
            'remove_featured_image' => __( 'Remove featured image', 'compassion-posts' ),
            'use_featured_image'    => __( 'Use as featured image', 'compassion-posts' ),
            'insert_into_item'      => __( 'Insert into item', 'compassion-posts' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'compassion-posts' ),
            'items_list'            => __( 'Items list', 'compassion-posts' ),
            'items_list_navigation' => __( 'Items list navigation', 'compassion-posts' ),
            'filter_items_list'     => __( 'Filter items list', 'compassion-posts' ),
        );
        $args = array(
            'label'                 => __( 'Kinder', 'compassion-posts' ),
            'description'           => __( '', 'compassion-posts' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
            'taxonomies'            => array( 'category' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'rewrite'            	=> array( 'slug' => 'children' ),
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'child', $args );
    }

    /**
     * Called by cmb2_admin_init action.
     */
    public function child_settings() {
        $prefix = '_child_';

        $countries = array(
            '' => __('Land wählen', 'compassion-posts')
        );

        $country_query = new WP_Query(array('post_type' => 'location', 'posts_per_page' => '-1'));
        while($country_query->have_posts()) {
            $country_query->the_post();

            $countries[get_the_id()] = get_the_title();
        }

        $cmb = new_cmb2_box( array(
            'id'			=>	$prefix.'settings',
            'title'			=>	'Zur Person',
            'object_types'	=>	array('child')
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Name', 'compassion-posts'),
            'type'			=>	'text',
            'id'			=>	$prefix . 'name'
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Kurzbeschreibung', 'compassion-posts'),
            'type'			=>	'wysiwyg',
            'id'			=>	$prefix . 'short_desc'
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Geburtstag', 'compassion-posts'),
            'type'			=>	'text_date_timestamp',
            'id'			=>	$prefix . 'birthday'
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Geschlecht', 'compassion-posts'),
            'type'			=>	'select',
            'id'			=>	$prefix . 'gender',
            'options' 		=> array(
                'girl' 		    => __('Mädchen', 'compassion'),
                'boy' 		    => __('Junge', 'compassion'),
            )
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Startdatum', 'compassion-posts'),
            'type'			=>	'text_date_timestamp',
            'id'			=>	$prefix . 'start_date'
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Beschreibung', 'compassion-posts'),
            'type'			=>	'wysiwyg',
            'id'			=>	$prefix . 'description'
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Über das Projekt', 'compassion-posts'),
            'type'			=>	'wysiwyg',
            'id'			=>	$prefix . 'project'
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Nummer', 'compassion-posts'),
            'type'			=>	'text',
            'id'			=>	$prefix . 'number'
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Land', 'compassion-posts'),
            'type'			=>	'select',
            'id'			=>	$prefix . 'country',
            'options' 		=> $countries
        ) );

        $cmb->add_field( array(
            'name'			=>	__('Portrait', 'compassion-posts'),
            'type'			=>	'file',
            'id'			=>	$prefix . 'portrait',
        ) );
    }

    /**
     * Called by the views_edit-child filter
     * @param $views
     * @return mixed
     */
    public function modified_views_so_15799171( $views )
    {

        if( isset( $views['draft'] ) )
            $views['draft'] = str_replace( 'Entwürfe ', 'Patenschaftsabschluss ', $views['draft'] );

        return $views;
    }

    /**
     * Called by the display_post_states filter
     * @param $post_states
     * @param $post
     * @return mixed
     */
    public function child_post_states( $post_states, $post )
    {

        if(get_post_type($post->ID) == 'child' && isset($post_states['draft']))
            $post_states['draft'] = __('Patenschaftsabschluss', 'compassion-posts');


        return $post_states;
    }

    /**
     * Get the id of a random child post.
     * The child is not reserved.
     */
    public static function get_random_child() {
        $args = array(
            'post_type'			=>	'child',
            'posts_per_page'	=>	'1',
            'orderby'			=>	'rand',
            'meta_query'        =>  array(
                array(
                    'key' => '_child_reserved',
                    'value' => 'false',
                    'compare' => 'LIKE')),
        );
        $child_posts = get_posts($args);
        foreach($child_posts as $post) {
            return $post->ID;
        }
        return false;
    }

    public function register_ajax_recommend_child() {
        add_action('wp_ajax_recommend_child', array($this, 'send_child_recommendation'));
        add_action('wp_ajax_nopriv_recommend_child', array($this, 'send_child_recommendation'));
    }

    /** Displays the button and form to recommend a child to a friend.
     * @param $child_id The id of child post. Used by the ajax endpoint.
     * @param $child_name The first name of the child. Used in the recommend button.
     */
    public static function recommend_child_button($child_id, $child_name) {
        include('templates/recommend_child_button.php');
    }

    /**
     * Called by ajax, to recommend a child to a friend.
     */
    public function send_child_recommendation() {
        function get_email_template($lang, $post_data, $child_id, $child_image)
        {
            ob_start();
            include('templates/recommend_child_email.php');
            return ob_get_clean();
        }

        $lang = apply_filters('wpml_current_language', NULL);
        $child_id = $_POST['child_id'];
        $child = get_post($child_id);
        $child_number = get_post_meta($child_id, '_child_number', true);
        $child_image = get_the_post_thumbnail($child_id);

        // Reserve child to prevent a failed recommendation.
        try {
            $odoo = new CompassionOdooConnector();
            $odoo->reserveChild($child_number);
            update_post_meta($child_id, '_child_reserved', 'true');
        } catch (Exception $e) {
            echo "Child could not be reserved";
            http_response_code(500);
            die();
        }

        try {
            $email = new PHPMailer();
            $email->isSMTP();                                      // Set mailer to use SMTP
            $email->Host = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
            $email->SMTPAuth = true;                               // Enable SMTP authentication
            $email->Username = 'apikey';                 // SMTP username
            $email->Password = SENDGRID_API_KEY; // SMTP password
            $email->Port = 587;
            $email->CharSet = 'UTF-8';
            $email->From = 'compassion@compassion.ch';
            $email->FromName = __('Compassion Schweiz', 'child-sponsor-lang');
            /* translators:  %1$s is the referer last name, %2$s is the child's name */
            $email->Subject = sprintf(__('%1$s vous propose de parrainer %2$s', 'compassion-posts'), $_POST['coordinates'], $child->post_title);
            $email->Body = get_email_template($lang, $_POST, $child_id, $child_image);
            $email->isHTML(true);
            $email->AddAddress($_POST['friend_email']);
            $email->addCustomHeader('X-SMTPAPI', '{"filters": {"subscriptiontrack" : {"settings" : {"enable" : 0}}}}');
            $email->Send();
        } catch (Exception $e) {
            echo "Message could not be sent";
            http_response_code(500);
            die();
        }

        // Content sent back. It replaces the button and form used to recommend a child to a friend.
        include('templates/recommend_child_success.php');

        die();
    }
}
