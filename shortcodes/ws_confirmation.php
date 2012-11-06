<?php
function add_WS_confirmation($atts, $content) {
	wp_enqueue_style( 'WS_confirmation_css', WP_PLUGIN_URL .'/wp-systempay/css/shortcodes/ws_confirmation.css');
	$WS = new WSTools();
	$WSConfirmation= new WSConfirmation;
	$form_id = $_GET[$WS->get_GET_key_confirmation_formid()];
	$method = $_GET["WS_method"];
	//if we are on the save tansaction Method
	if(!empty($method)) 
	{
			switch($method) 
			{
				case $WS->get_method_saveTransaction() :
					if (!empty($form_id)){
						$WSConfirmation->saveTransaction($form_id,$_POST,$WSConfirmation->get_confirmation_form_id());
					}
				break;
			}
	}
	//if we are on the Confirmation page
	else {
		if (!empty($form_id)) {
			$return_url= $WS->get_confirmationpage_url($form_id)."&WS_method=".$WS->get_method_saveTransaction();
			echo $WSConfirmation->getConfirmationById($form_id,$_POST,$return_url);
		}
	}
}
?>