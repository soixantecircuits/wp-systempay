<?php
/**
 * Add action hooks
 * 
 */

add_action('init', 'WS_Start');
add_action('init', 'ws_register_shortcodes');
add_action('plugins_loaded', 'WS_Language_call');
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
    wp_enqueue_style('WS_adminCSS', WP_PLUGIN_URL .'/wp-systempay/css/admin/ws_admin.css');
    wp_enqueue_style('bootstrap', WP_PLUGIN_URL .'/wp-systempay/css/admin/bootstrap.min.css');
    wp_enqueue_style('chosen', WP_PLUGIN_URL .'/wp-systempay/css/admin/chosen.css');
}

if (is_admin() && !is_front_page()) {
    add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style', 200);
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
        wp_enqueue_script('jquery_ui_core', WP_PLUGIN_URL .'/wp-systempay/inc/jquery-ui/js/jquery.ui.core.js');
        wp_enqueue_script('jquery_ui_widget', WP_PLUGIN_URL .'/wp-systempay/inc/jquery-ui/js/jquery.ui.widget.js');
        wp_enqueue_script('jquery_ui_tabs', WP_PLUGIN_URL .'/wp-systempay/inc/jquery-ui/js/jquery.ui.tabs.js');
        wp_enqueue_script('jquery_chosen', WP_PLUGIN_URL .'/wp-systempay/inc/chosen.jquery.min.js');
        wp_enqueue_script('bootstrap', WP_PLUGIN_URL .'/wp-systempay/inc/bootstrap.min.js');
        wp_enqueue_script('WS_script', WP_PLUGIN_URL.'/wp-systempay/inc/script.js',array('jquery'));
    }
}

/**
 * WS_load_datatables
 * 
 * load the datatables
 * 
 */

function WS_load_datatables()
{
    if ( is_admin() && !is_front_page()) {
        wp_enqueue_script('jquery_ui_tabs', WP_PLUGIN_URL .'/wp-systempay/inc/jquery.datatables.min.js');
    }
}


function ws_register_shortcodes()
{
    //shortcodes
    add_shortcode("wp-systempay-confirmation", "WS_Add_confirmation");
    add_shortcode("wp-systempay-result", "WS_Add_result");
    add_shortcode("wp-systempay-server-result", "WS_Add_Server_result");
    /*NEED TO REMOVE THAT DEPRECATED*/
    add_shortcode("payform", "WS_Add_payform");
    /*NEED TO REMOVE THAT DEPRECATED*/
    add_shortcode("wp-systempay", "WS_Add_payform");
    
}


?>