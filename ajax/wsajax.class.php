<?php
add_action('wp_ajax_load_inputs', array('WSAjax', 'getJSONInputs'));

class WSAjax 
{
    public function loadinputs_newform_ajax()
    {
  ?>
        <script type="text/javascript" >
          jQuery(document).ready(function($) {
            datas = {
                action: 'load_inputs',
                WS_plateforme: jQuery('#ws_plateforme').val()
                <?php
                if (isset($_GET["WS_id"])) : ?>
                    ,WS_id : <?php echo $_GET["WS_id"]; ?>
                <?php 
                endif;
                ?>
            };
            WS_admin_ajax_load_inputs(datas);
          });
        </script>
        <?php 
    }

    public function loadinputs_editform_ajax()
    {
  ?>
      <script type="text/javascript" >
        jQuery(document).ready(function($) {
          datas = {
              action: 'load_inputs'
              ,WS_plateforme: jQuery('#ws_plateforme').val()
              <?php if (isset($_GET["WS_id"])) : ?>
                ,WS_id : <?php echo $_GET["WS_id"]; ?>
              <?php endif; ?>
          };
          WS_admin_ajax_load_inputs(datas);
        });
      </script>
      <?php 
    }


    function getJSONInputs() 
    {
        include dirname(__FILE__)."/../admin/classes/inputstojson.php";
        $systempay = new WS();
        $WSTools = new WSTools($systempay);
        $WS_plateformes = $systempay->getSavedInputs();

        //seek for the good plateforme
        foreach ($WS_plateformes as $key => $value) {
            if ($key == $_POST["WS_plateforme"]) {
                $WS_configurations     = $value["formals_configs"];
                $WS_additionals_inputs = $value["additionals_configs"];
                $WS_customer_inputs    = $value["customer_infos"];
            }
        }

        //if we are on the update mode
        if (isset($_POST["WS_id"])) {
            $form_to_update = $WSTools->getFormObjectById($_POST["WS_id"]);
            if ($form_to_update["form_data"]->form_plateforme == $_POST["WS_plateforme"]) {
                inputsToJSON($form_to_update, $WS_configurations, $WS_additionals_inputs, $WS_customer_inputs);
            } else {
                inputsToJSON(false, $WS_configurations, $WS_additionals_inputs, $WS_customer_inputs);
            }
            //if we are on the "new form " mode
        } else {
            inputsToJSON(false, $WS_configurations, $WS_additionals_inputs, $WS_customer_inputs);
        }
        die();
    }

}
?>