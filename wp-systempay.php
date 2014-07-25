<?php
/**
Plugin Name: wp-systempay
Plugin URI: http://soixantecircuits.fr/
Description: WP-Systempay allow you to create totally modular forms wich will manage the confirmation page ,save transactions and send confirmation mails.
Version: 1.0
Author: Soixante Circuits : Schobben Thomas, Gabriel Delatre
Author URI: http://soixantecircuits.fr/
License: GPL
*/

define( 'WPSYSTEMPAY_PATH', plugin_dir_path(__FILE__) );

require_once dirname(__FILE__)."/admin/helper.php";
/*---------------------------------------------------------------
-----------------------------CLASSES--------------------------*/
//SYSTEMPAY CLASSES
require_once dirname(__FILE__)."/front/systempay/ws_systempay_currencies.class.php";
//WS CLASSES
require_once dirname(__FILE__)."/front/ws_countries.class.php";
require_once dirname(__FILE__)."/front/ws_gateways.class.php";
require_once dirname(__FILE__)."/front/ws.class.php";
require_once dirname(__FILE__)."/front/ws_tools.class.php";
//FRONT
require_once dirname(__FILE__)."/front/systempay/ws_systempay_methods.class.php";
require_once dirname(__FILE__)."/front/systempay/ws_systempay_results.class.php";
require_once dirname(__FILE__)."/front/systempay/ws_systempay_analyzer.class.php";
require_once dirname(__FILE__)."/front/systempay/ws_systempay_transaction_updater.class.php";
require_once dirname(__FILE__)."/front/ws_forms.class.php";
require_once dirname(__FILE__)."/front/ws_confirmation.class.php";
require_once dirname(__FILE__)."/admin/wscontroller.class.php";
//BACKOFFICE
    
if (is_admin()) {
    include_once dirname(__FILE__)."/ajax/wsajax.class.php";
    include_once dirname(__FILE__)."/admin/classes/wssetup.class.php";
    include_once dirname(__FILE__)."/admin/classes/wsdeactive.class.php";
    include_once dirname(__FILE__)."/admin/classes/wsmanager.class.php";
}

/**---------------------------------------------------------------
-----------------------------SHORTCODES--------------------------*/
  require_once dirname(__FILE__) ."/shortcodes/ws_confirmation.php";
  require_once dirname(__FILE__) ."/shortcodes/ws_shortcode.php";
  require_once dirname(__FILE__) ."/shortcodes/ws_result.php";
  require_once dirname(__FILE__) ."/shortcodes/ws_analyzer_result.php";

/**---------------------------------------------------------------
-----------------------------HOOKS--------------------------*/

/**
 * Desactivate the plugin
 * 
 * @return void
 */
function WS_deactive()
{
    $systempay = new WS();
    $WSDeactive= new WSDeactive($systempay);
    $WSDeactive->deactive();
}

/**
 * Install the plugin
 * 
 * @return void
 */
function WS_install()
{
    $systempay = new WS();
    $WSSetup = new WSSetup($systempay);
    $WSSetup->install();
}

/**
 * Install the plugin
 * 
 * @return void
 */
function WS_update()
{
    $systempay = new WS();
    $WSSetup = new WSSetup($systempay);
    $WSSetup->update();
}

function WS_Should_update()
{
    add_action('admin_notices', 'should_update_message');
}
function should_update_message()
{
    $url = "?page=WS_main&WS_action=updatedb";
    echo '<div class="updated"><p>WP-Systempay:<br/>'.sprintf(__("Hey, they've been update on database, you should run the <a href='%s'>update script now</a> ! Thanks", "ws"), $url).'</p></div>';
}




/**
 * Then action with update scrip :
 * Execute your upgrade logic here
 * 
 * 
 * Then update the version value
 * 
 * update_option(MYPLUGIN_VERSION_KEY, $new_version);
 */

register_activation_hook(__FILE__, "WS_install");
register_deactivation_hook(__FILE__, 'WS_deactive');

/**
 * Here start the plugins
 * 
 * @return void
 */
function WS_Start()
{
    $WSController = new WSController();
}

/**
 * Register the domain language file
 * 
 * @return void
 */
function WS_Language_call()
{
    load_plugin_textdomain('ws', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

/**
 * Check for last version of db schema
 * 
 * @return void
 */
function WS_Update_Db_check()
{
    global $wp_systempay_db_version;
    if (get_site_option('wp_systempay_db_version') != $wp_systempay_db_version) {
        WS_Should_update();
    }
}
add_action('plugins_loaded', 'WS_Update_Db_check');

//IMPORT HOOKS
require_once dirname(__FILE__) . '/hooks/ws_hooks.php';


?>