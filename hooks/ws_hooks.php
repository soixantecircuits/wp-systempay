<?php 
//actions 
add_action('init', 'WSStart');
add_action('plugins_loaded', 'myplugin_language_call');


if (is_admin() && !is_front_page()) {
	wp_enqueue_style( 'WS_css', WP_PLUGIN_URL .'/wp-systempay/css/admin/WS_admin.css' );
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



//shortcodes

add_shortcode("wp-systempay-confirmation", "add_WS_confirmation");
add_shortcode("wp-systempay", "add_WS_shortcode");
add_shortcode("ws-result", "add_ws_result");
add_shortcode("ws-server-result", "add_ws_server_result");

?>