<?php
/*
Plugin Name: WP-systempay
Plugin URI: http://asso-ela.com/
Description: WP-Systempay allow you to create totally modular forms wich will manage the confirmation page ,save transactions and send confirmation mails.
Version: 1.0
Author: Soixante Circuits : Schobben Thomas, Gabriel Delatre
Author URI: http://soixantecircuits.fr/
License: GPL
*/

/*---------------------------------------------------------------
-----------------------------SWIFT_MAILER--------------------------*/
	require_once(dirname(__FILE__)."/inc/swift_mailer/lib/swift_required.php");
/*---------------------------------------------------------------
-----------------------------CLASSES--------------------------*/
	//SYSTEMPAY CLASSES
		require_once(dirname(__FILE__)."/front/systempay/ws_systempay_currencies.class.php");
	//WS CLASSES
		require_once(dirname(__FILE__)."/front/ws_countries.class.php");
		require_once(dirname(__FILE__)."/front/ws_gateways.class.php");
		require_once( dirname(__FILE__) . '/front/ws.class.php' );
		require_once(dirname(__FILE__)."/front/ws_tools.class.php");
	//FRONT
		require_once(dirname(__FILE__)."/front/systempay/ws_systempay_methods.class.php");
		require_once(dirname(__FILE__)."/front/systempay/ws_systempay_results.class.php");
		require_once(dirname(__FILE__)."/front/systempay/ws_systempay_analyzer.class.php");
		require_once(dirname(__FILE__)."/front/systempay/ws_systempay_transaction_updater.class.php");
		require_once(dirname(__FILE__)."/front/ws_forms.class.php");
		require_once(dirname(__FILE__)."/front/ws_confirmation.class.php");
		require_once(dirname(__FILE__)."/admin/wscontroller.class.php");
	//BACKOFFICE
		if (is_admin())
		{
			require_once( dirname(__FILE__) . '/ajax/wsajax.class.php' );
			require_once( dirname(__FILE__) . '/admin/classes/wssetup.class.php' );
			require_once( dirname(__FILE__) . '/admin/classes/wsdeactive.class.php' );
			require_once( dirname(__FILE__) . '/admin/classes/wsmanager.class.php' );
		}

/*---------------------------------------------------------------
-----------------------------SHORTCODES--------------------------*/
	require_once(dirname(__FILE__) ."/shortcodes/ws_confirmation.php");
	require_once(dirname(__FILE__) ."/shortcodes/ws_shortcode.php");
	require_once(dirname(__FILE__) ."/shortcodes/ws_result.php");
	require_once(dirname(__FILE__) ."/shortcodes/ws_analyzer_result.php");

/*---------------------------------------------------------------
-----------------------------HOOKS--------------------------*/

//FUNCTIONS FOR THE ACTIVATIONS HOOKS
	function WS_deactive(){
		$WSDeactive= new WSDeactive();
		$WSDeactive->deactive();
	}
	function WS_install() {
	  $WSSetup = new WSSetup();
	  $WSSetup->install();
	}
//ACTIVATION HOOK
	register_activation_hook(__FILE__, "WS_install");
	register_deactivation_hook(__FILE__, 'WS_deactive' );
//FUNCTIONS USED WHEN INIT
	function WSStart(){
		$WSController = new WSController();
	}
	function myplugin_language_call() {
	  load_plugin_textdomain( 'WS', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
//IMPORT HOOKS
	require_once(dirname(__FILE__) . '/hooks/ws_hooks.php' );


?>
