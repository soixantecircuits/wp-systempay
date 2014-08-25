<?php
/**
 * Add action hooks
 * 
 */

add_action('init', 'WS_Start');
add_action('init', 'ws_register_shortcodes');
add_action('init', 'ws_register_taxonomy');
add_action('plugins_loaded', 'WS_Language_call');
add_action( 'wp', 'custom_theme_admin' );

/**
 * load_custom_wp_admin_style
 * 
 * load the the admin CSS
 * 
 */

function load_custom_wp_admin_style($hook)
{
    if (('toplevel_page_WS_main' !== $hook) && (strlen(strstr($hook, "admin_page_WS_edit"))<=0) && (strlen(strstr($hook, "ws-sytempay"))<=0) && (strlen(strstr($hook, "admin_page_WS_transactions"))<=0) )
          return;
    wp_enqueue_style('WS_adminCSS', plugins_url('../css/admin/ws_admin.css', __FILE__) );
    wp_enqueue_style('bootstrap', plugins_url('../css/admin/bootstrap.min.css', __FILE__) );
    wp_enqueue_style('bootstrap', plugins_url('../css/admin/bootstrap-theme.min.css', __FILE__) );
    wp_enqueue_style('chosen', plugins_url('../css/admin/chosen.css', __FILE__) );
}

function custom_theme_admin(){
    if (is_admin() && !is_front_page()) {
        add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style', 200);
    }
}

/**
 * WS_load_datatables
 * 
 * load the the admin script
 * 
 */
 
function WS_load_admin_scripts()
{
    if (is_admin() && !is_front_page()) {
        //jquery UI
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-widget' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'jquery-ui-tabs' );

        wp_enqueue_script('jquery_chosen', plugins_url('../inc/chosen.jquery.min.js', __FILE__) );
        wp_enqueue_script('bootstrap', plugins_url('../inc/bootstrap.min.js', __FILE__) );
        wp_enqueue_script('WS_script', plugins_url('../inc/script.js', __FILE__), array('jquery') );
    }
}

/**
 * WS_load_datatables
 * 
 * load the datatables
 * 
 */
function WS_load_datatables() {
    if ( is_admin() && !is_front_page()) {
        wp_enqueue_script('jquery_ui_tabs', plugins_url('../inc/jquery.datatables.min.js', __FILE__) );
    }
}

function ws_register_taxonomy(){
    $labels = array(
        'name'              => _x( 'Genres', 'taxonomy general name' ),
        'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Genres' ),
        'all_items'         => __( 'All Genres' ),
        'parent_item'       => __( 'Parent Genre' ),
        'parent_item_colon' => __( 'Parent Genre:' ),
        'edit_item'         => __( 'Edit Genre' ),
        'update_item'       => __( 'Update Genre' ),
        'add_new_item'      => __( 'Add New Genre' ),
        'new_item_name'     => __( 'New Genre Name' ),
        'menu_name'         => __( 'Genre' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'genre' ),
    );

    register_taxonomy( 'genre', array( 'post' ), $args );
}


function ws_register_shortcodes() {
    //shortcodes
    add_shortcode("wp-systempay-confirmation", "WS_Add_confirmation");
    add_shortcode("wp-systempay-result", "WS_Add_result");
    add_shortcode("wp-systempay-server-result", "WS_Add_Server_result");
    /*NEED TO REMOVE THAT DEPRECATED*/
    add_shortcode("payform", "WS_Add_payform");
    /*NEED TO REMOVE THAT DEPRECATED*/
    add_shortcode("wp-systempay", "WS_Add_payform");
    
}