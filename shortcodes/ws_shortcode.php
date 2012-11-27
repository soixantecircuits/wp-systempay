<?php
/**
 * WS_Add_result add result to the database 
 */
function WS_Add_payform($atts, $content) 
{ 
    extract(
        shortcode_atts(
            array(
              'id' => '',
              "template"=>'',
              'name' => ''),
            $atts
        )
    );
    $form_id = $id;
    $WS = new WS();
    $WSForms = new WSForms($WS);
    if (!empty($name)) {
        if (!empty($template)) {
            return $WSForms->getFormByName($name, $template);
        } else {
            return $WSForms->getFormByName($name, false);
        }
    } else if (!empty($form_id)) {
        if (!empty($template)) {
            return $WSForms->getFormById($form_id, $template);
        } else {
            return $WSForms->getFormById($form_id, false);
        }
    }
}
?>