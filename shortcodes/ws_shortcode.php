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
            echo $WSForms->getFormByName($name, $template);
        } else {
            echo $WSForms->getFormByName($name, false);
        }
    } else if (!empty($form_id)) {
        if (!empty($template)) {
            echo $WSForms->getFormById($form_id, $template);
        } else {
            echo $WSForms->getFormById($form_id, false);
        }
    }
}
?>