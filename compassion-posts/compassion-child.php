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
        $this->register_shortcode_insert_children();
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

        if( isset( $views['trash'] ) )
            $views['trash'] = str_replace( 'Entwürfe ', 'Patenschaftsabschluss ', $views['trash'] );

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

        if(get_post_type($post->ID) == 'child' && isset($post_states['trash']))
            $post_states['trash'] = __('Patenschaftsabschluss', 'compassion-posts');


        return $post_states;
    }

    /**
     * Get the id of a random child post.
     */
    public static function get_random_child() {
        $args = array(
            'post_type'			=>	'child',
            'posts_per_page'	=>	'1',
            'orderby'			=>	'rand'
        );
        $child_posts = get_posts($args);
        foreach($child_posts as $post) {
            return $post->ID;
        }
        return false;
    }

    public function register_shortcode_insert_children() {
        add_shortcode( 'insert_childs', array($this, 'display_children_shortcode'));
        if(function_exists('shortcode_ui_register_for_shortcode')) {
            $args = array(
                'label' => __('Insert children', 'compassion-posts'),
                'listItemImage' => 'dashicons-groups',
                'attrs' => array(
                    array(
                        'label' => __('Number', 'compassion-posts'),
                        'attr' => 'number',
                        'description' => __('Number of children to display.'),
                        'type' => 'number',
                    ),
                    array(
                        'label' => __('Gender', 'compassion-posts'),
                        'attr' => 'gender',
                        'description' => __('The gender of the children to display.'),
                        'type' => 'select',
                        'options' => array(
                            array('value' => 'any', 'label' => __('Any gender', 'compassion-posts')),
                            array('value' => 'girl', 'label' => __('Girl', 'compassion-posts')),
                            array('value' => 'boy', 'label' => __('Boy', 'compassion-posts')),
                        ),
                    ),
                    array(
                        'label' => __('Age group', 'compassion-posts'),
                        'attr' => 'age',
                        'description' => __('The age group of the children to display. for any age, just remove the age range in the shortcode once created'),
                        'type' => 'select',
                        'options' => array(
                            array('value' => '0-3', 'label' => __('0 to 3 years old' , 'compassion-posts')),
                            array('value' => '4-6', 'label' => __('4 to 6 years old', 'compassion-posts')),
                            array('value' => '7-10', 'label' => __('7 to 10 years old', 'compassion-posts')),
                            array('value' => '11-14', 'label' => __('11 to 14 years old', 'compassion-posts')),
                            array('value' => '15-', 'label' => __('15 and older', 'compassion-posts')),
                        ),
                    ),
                    array(
                        'label' => __('Country', 'compassion-posts'),
                        'attr' => 'country',
                        'description' => __('The country where the children to display live.'),
                        'type'     => 'post_select',
                        'query'    => array( 'post_type' => 'location' ),
                        'multiple' => true,
                    ),
                ),
            );
            shortcode_ui_register_for_shortcode('insert_childs', $args);
        }
    }

    /**
     * Shortcode to display a filtered selection of children.
     * @param $atts The attributes passed to the shortcode.
     *      There are 4 valid attributes:
     *       - 'number' : The number of children to display.
     *       - 'gender' : One of 'boy', 'girl' or 'any'.
     *       - 'age' : The age interval of the children as {min age}-{max-age]. For examples:
     *              - "3-5" : only children that are at least 3 years old and less than 6 years old.
     *              - "-10" : only children less than 11 years old.
     *              - "6-" : only children that are at least 6 years old.
     *              - "-" : children of all age.
     *       - 'countries' : The ids of the countries where the children live. The ids are separated by comma.
     *          The ids reference posts of type location which describe the countries.
     * @param $content
     * @return false|string
     */
    public function display_children_shortcode($atts, $content ) {

        // query also in archive-child

        $a = shortcode_atts(array(
            'number' => 3,
            'gender' => 'any',
            'age' => '-',
            'country' => '',
        ), $atts);

        $posts_per_page = $a['number'];
        $args = array(
            'post_type' => 'child',
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
            'orderby' => 'rand',
        );

        $meta_query = array(
            'relation' => 'AND',
        );

        $gender = $a['gender'];
        if ($gender == 'boy' || $gender == 'girl') {
            array_push($meta_query, array(
                'key' => '_child_gender',
                'value' => $gender,
                'compare' => 'LIKE'));
        }

        $age_ranges = explode('-', $a['age']);
        if ($age_ranges[0] != '') {
            $birthday_end = time() - (365 * 24 * 60 * 60 * ($age_ranges[0] + 1));
            array_push($meta_query, array(
                'key' => '_child_birthday',
                'value' => $birthday_end,
                'compare' => '<',
                'type' => 'numeric'));

        }
        if ($age_ranges[1] != '') {
            $birthday_start = time() - (365 * 24 * 60 * 60 * ($age_ranges[1] + 1));
            array_push($meta_query, array(
                'key' => '_child_birthday',
                'value' => $birthday_start,
                'compare' => '>',
                'type' => 'numeric'));
        }

        if ($a['country'] != '') {
            $ids = explode(',', $a['country']);
            array_push($meta_query, array(
                'key' => '_child_country',
                'value' => $ids,
                'compare' => 'in'));
        }


        if (count($meta_query) > 1) {
            $args['meta_query'] = $meta_query;
        }
        $query = new WP_Query( $args );

        ob_start();

        echo '<div class="row">';
        if ($query->have_posts()) :
            while ($query->have_posts()): $query->the_post();
                get_template_part('template-parts/content', 'child-teaser');
            endwhile;
        else:
            get_template_part('template-parts/content', 'none');
        endif;
        echo '</div>';

        wp_reset_query();

        return ob_get_clean();
    }
}
