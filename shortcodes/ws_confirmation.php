<?php
/**
 *  WS_Add_confirmation print the confirmation page
 * 
 * @return void
 * 
 */
function WS_Add_confirmation($atts, $content)
{
    wp_enqueue_style('WS_confirmation_css', WP_PLUGIN_URL .'/wp-systempay/css/shortcodes/ws_confirmation.css');
    if (file_exists(get_stylesheet_directory()."/wp-systempay/templates/forms_templates/styles.css") ) {
        wp_enqueue_style("WS_style", get_bloginfo("stylesheet_directory")."/wp-systempay/templates/forms_templates/styles.css");
    }
    $WS             = new WS();
    $WSConfirmation = new WSConfirmation($WS);
    $form_id        = $_GET[$WS->get_GET_key_confirmation_formid()];
    $method         = $_GET["WS_method"];
    $_POST          = stripslashes_deep($_POST);
    //if we are on the save tansaction Method
    if (!empty($method)) {
        switch($method) 
        {
        case $WS->get_method_saveTransaction() :
            if (!empty($form_id)) {
                $WSConfirmation->saveTransaction($form_id, $_POST, $WSConfirmation->getSystempay()->get_confirmation_form_id());
            }
            break;
        }
        //if we are on the Confirmation page
    } else {
        if (!empty($form_id)) {
            $return_url= $WS->get_confirmationpage_url($form_id)."&WS_method=".$WS->get_method_saveTransaction();
            return $WSConfirmation->getConfirmationById($form_id, $_POST, $return_url);
        }
    }
}
?>