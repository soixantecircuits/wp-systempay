<?php 
/**
* actions 
*/
add_action('init', 'WS_start');
add_action('plugins_loaded', 'WS_language_call');


if (is_admin() && !is_front_page()) {
    wp_enqueue_style( 'WS_css', WP_PLUGIN_URL .'/wp-systempay/css/admin/ws_admin.css');
}

//script and style
function WS_load_admin_scripts() {
  if( is_admin() && !is_front_page()) {
    wp_enqueue_script('WS_script', WP_PLUGIN_URL.'/wp-systempay/js/script.js');
  //jquery UI
  wp_enqueue_script( 'jquery_ui_core', WP_PLUGIN_URL .'/wp-systempay/inc/jquery-ui/js/jquery.ui.core.js' );
  wp_enqueue_script( 'jquery_ui_widget', WP_PLUGIN_URL .'/wp-systempay/inc/jquery-ui/js/jquery.ui.widget.js' );
  wp_enqueue_script( 'jquery_ui_tabs', WP_PLUGIN_URL .'/wp-systempay/inc/jquery-ui/js/jquery.ui.tabs.js' );
  }
}

function WS_load_datatables(){
  if( is_admin() && !is_front_page()) {
    wp_enqueue_script( 'jquery_ui_tabs', WP_PLUGIN_URL .'/wp-systempay/inc/jquery.datatables.min.js' );
  }
}

//shortcodes
add_shortcode("wp-systempay-confirmation", "add_WS_confirmation");
add_shortcode("payform", "add_WS_shortcode");
add_shortcode("wp-systempay-result", "add_ws_result");
add_shortcode("wp-systempay-server-result", "add_ws_server_result");
?>