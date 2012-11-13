<?php

class WSConfirmation extends WSTools
{
    public function __construct($systempay)
    {
        parent::__construct($systempay);
    }

    //Merge the inputs and the $_POST
    public function mergePostAndConfiguration($inputs_data, $post_inputs)
    {
        $inputs_merged=array();
        foreach ($inputs_data as $input) {
            $change = false;
            foreach ($post_inputs as $key => $value) {
                if ($key == $input["name"]) {
                    $input["value"] = $value;
                    array_push($inputs_merged, $input);
                    $change=true;
                }
            }
            if (!$change) {
                array_push($inputs_merged, $input);
            }
        }
        return $inputs_merged;
    }

    public function splitMultipleOptions($options)
    {
        $options_formated = array();
        $options_array =split(";", $options); 
        foreach ($options_array as $option) : 
            array_push($options_formated, $this->splitOption($option));
        endforeach; 
        return $options_formated;
    }

    public function splitOption($option)
    {
        $options_splitted =split("=", $option);
        $value = $options_splitted[0];
        $amount = $options_splitted[1];
        $option_formated = array(
          "value"=>$value
          ,"amount"=>$amount
        );
        return $option_formated;
    }

    public function mergePostAndInputs($inputs_data, $post_inputs)
    {
        $inputs_merged=array();
        foreach ($inputs_data as $groupe) {
            $groupe_merged = array();
            foreach ($groupe as $input) {
                $change = false;
                foreach ($post_inputs as $key => $value) {
                    if ($key == $input["name"]) {
                        switch($input["type"]) {
                        case "checkbox":
                            $input["value"]="";
                            for ($i = 0, $c = count($value); $i < $c; $i++) {
                                $input["value"] .= $value[$i];
                                if ($i != ($c -1)) $input["value"]  .= ";"; //pas de point ';' à la dernière
                            }
                            $options        = $this->splitMultipleOptions($input["value"]);
                            $i              = 0;
                            $input["value"] = "";
                            foreach ($options as $option) {
                                $virgule = ($i>0)?", ":"";
                                $input["value"].=$virgule.$option["value"];
                                $i++;
                            }
                            break;
                        case "radio" :
                            $option         = $this->splitOption($value);
                            $input["value"] = $option["value"];
                            break;
                        case "select" :
                            $option         = $this->splitOption($value);
                            $input["value"] = $option["value"];
                            break;
                        default :
                            $input["value"] = $value;
                            break;
                        }
                        array_push($groupe_merged, $input);
                        $change=true;
                    }
                } 
                if (!$change && !empty($input["name"])) {
                    array_push($groupe_merged, $input);
                }
            }
            array_push($inputs_merged, $groupe_merged);
        }
        return $inputs_merged;
    }

    //use function on an input array
    public function useFunctionOnInputs($inputs_array, $form_id, $posts, $excludes)
    {
        $new_inputs_array = array();
        $plateforme = $this->getFormDataArrayById($form_id);
        $plateforme = ucfirst(strtolower($plateforme["form_plateforme"]));
        foreach ($inputs_array as $input_array) {
            $is_function = (bool) $input_array["function"];
            if ($is_function) {
                $function_name = $input_array["value"];
                $isExcluded    = $this->is_excluded($function_name, $excludes);
                if (method_exists($this->getSystempay()->Systempay, $function_name) && (!$isExcluded)) {
                    $input_array["value"] = $this->$plateforme->$function_name($form_id,$posts);
                }
            }
            array_push($new_inputs_array, $input_array);
        }
        return $new_inputs_array;
    }

    public function is_excluded($needed, $excludeds_array)
    {
        $is_excluded = array_search($needed, $excludeds_array);
        if ($is_excluded>-1) {
            $is_excluded+=1;
        }
        return (bool)($is_excluded);
    }

    //get an array of all the elements of the Confirmation Form
    public function getConfirmFormArrayById($form_id, $posts_inputs, $use_function) 
    {
        (int)($form_id);
        (bool)($use_function);
        $configurations = $this->getConfigurationsArrayById($form_id);
        $inputs         = $this->getAdditionalsInputsArrayById($form_id);
        if ($posts_inputs) {
            $merged_configurations = $this->mergePostAndConfiguration($configurations, $posts_inputs);
            $merged_inputs         = $this->mergePostAndInputs($inputs, $posts_inputs);
        } else {
            $merged_configurations = $configurations;
            $merged_inputs         = $inputs;
        }

        if (!$use_function) {
            $WS_form = array(
                "form_data"=> $this->getFormDataArrayById($form_id)
                ,"configurations_data"=> $merged_configurations
                ,"inputs_data"=> $merged_inputs
                ,"POST" => $_POST
            );
            return $WS_form;
        }
        $configurations_with_function = $this->useFunctionOnInputs($merged_configurations, $form_id, $posts_inputs, array("WS_GetSignature", "systemPay_GetTransId"));
        $WS_form = array(
          "form_data"=> $this->getFormDataArrayById($form_id)
          ,"configurations_data"=> $configurations_with_function
          ,"inputs_data"=> $merged_inputs
          ,"POST" => $_POST
        );  
        return $WS_form;
    } 

    private function getCancelLink()
    {
        return "<a class='confirmation_button a-btn' id='confirm_cancel' href='".$_GET[$this->get_GET_key_confirmation_previouspage()]."'>".__('Cancel', 'ws')."</a>";
    }

    /**
    * get the html code of the Confirmation Form
    */
    public function getConfirmationById($form_id, $posts, $return_url)
    {
        if (!empty($posts)) {
            //we get the confirm form array wich have been merged with $_POST and applied functions
            $confirmation_data = $this->getConfirmFormArrayById($form_id, $posts, false);
        }
        if (!empty($confirmation_data["form_data"]["form_id"])) :
            /** we get the form informations*/
            $form_data = $confirmation_data["form_data"];
            /** we get the formals inputs informations*/
            $configurations_data = $confirmation_data["configurations_data"];


            //we get the additionals inputs informations
            $additionalsinputs_data = $confirmation_data["inputs_data"];
            $plateforme             = $form_data["form_plateforme"];
            $amount_input_name      = $this->saved_inputs[$plateforme]["amount_input_name"];
            $amount                 = $this->getAmount($configurations_data, $additionalsinputs_data, $posts, $amount_input_name);
            switch ($plateforme) {
            case 'systempay':
                $correct_amount = floatval($amount)*100;
                break;
            default:
                $correct_amount=$amount;
                break;
            }
          
            $confirmation_html  = "<form method='POST' class='WS_confirmation' id='".$this->get_confirmation_form_id()."' action='".$return_url."'>";
            $confirmation_html .= "<table>";
            $confirmation_html .= "<input type='hidden' name='".$amount_input_name."' value='".$correct_amount."'/>";
            $confirmation_html .= __("The amount of your transaction is:", "ws")." ".$amount." ".$this->getCurrency($form_id)->alpha3."<br/><br/>"; //to replace by currency
            $confirmation_html .= __("Please find bellow the information about your payment:", "ws")."<br/><br/>"; 
            foreach ($additionalsinputs_data as $groupe) {
                foreach ($groupe as $additionalinput) {
                    (bool)($additionalinput["hide"]);
                    $value = (empty($additionalinput['value']))?" ":$additionalinput['value'];
                    $confirmation_html.="<tr style='display:none;'><td><input type='hidden' name='".$additionalinput['name']."' value='".$value."'/></tr></td>";
                    if (!$additionalinput["hide"]) {
                        if ($additionalinput['value'] == '') {
                            $display = "none";
                        } else {
                            $display = "table-row";
                        }
                        $confirmation_html.="<tr style='display:".$display.";'><td widht='30%' class='confirmation_label'>".$additionalinput['label']." : </td><td width='70%' class='confirmation_value'>".$additionalinput['value']." </td></tr>";
                    }
                }
            }

            $confirmation_html.= "</table>";
            $confirmation_html.= "<div class='confirmation_buttons'>";
            $confirmation_html.= $this->getCancelLink();
            $confirmation_html.= "<input type='submit' class='a-btn confirmation_button' id='confirm_confirm' value='".__('Confirm', "ws")."' />";
            $confirmation_html.= "</div>";
            $confirmation_html.= "</form>";
            return $confirmation_html;
        else :
            _e("The wanted confirmation WS is missing", "ws");
        endif;
    }

    public function getAmount($configurations_data, $inputs_data, $post_inputs, $amount_input_name)
    {
        $amount=0;
        foreach ($configurations_data as $configuration) {
            if ($configuration["name"] == $amount_input_name) {
                (float)($configuration["value"]);
                $amount+=$configuration["value"];
            }
        }

        foreach ($inputs_data as $groupe) {
            foreach ($groupe as $input) {
                foreach ($post_inputs as $key => $value) {
                    if ($key == $input["name"]) {
                        switch ($input["type"]) {
                        case "checkbox":
                            for ($i = 0, $c = count($value); $i < $c; $i++) {
                                $input["value"] = $input["value"].$value[$i];
                                if ($i != ($c -1)) $input["value"]  =$input["value"].";"; //pas de point ';' à la dernière
                            }
                            $options=$this->splitMultipleOptions($input["value"]);

                            foreach ($options as $option) {
                                $amount+=(float)($option["amount"]);
                            }
                            break;
                        case "radio" :
                            $option = $this->splitOption($value);
                            $amount+=(float)($option["amount"]);
                            break;
                        case "select" :
                            $option = $this->splitOption($value);
                            $amount+=(float)($option["amount"]);
                            break;
                        case "amountentry":
                            $amount=(float)($input["value"]);
                            break;
                        default:
                            $amount+=(float)($input["option"]);
                            break;
                        }
                    }
                } 
            }
        }
        return $amount;
    }


    public function saveTransaction($form_id, $datas, $confirmation_form_id)
    {
        if (empty($form_id)||empty($datas)||empty($confirmation_form_id)) {
            return;
        }
        global $wpdb;
        (int)$form_id;
        $form_data         = $this->getConfirmFormArrayById($form_id, $datas, true);
        $plateforme        = $form_data["form_data"]["form_plateforme"];
        $transactions_data = array();
        //creatE the datas to save for each plateforme
        $trans_id          = $this->getSystempay()->Systempay->systemPay_GetTransId();
        $order_id          = $this->generateOrderId("ELA", $trans_id);
        $amount            = floatval(mysql_real_escape_string($datas["vads_amount"]))/100;

        switch ($plateforme) {
        case "systempay" : 
            //set the transaction identification
            $transactions_data["transaction_form_id"]            = mysql_real_escape_string($form_id);
            $transactions_data["transaction_form_name"]          = mysql_real_escape_string($form_data["form_data"]["form_name"]);
            $transactions_data["transaction_order_id"]           = mysql_real_escape_string($order_id);
            $transactions_data["transaction_trans_id"]           = mysql_real_escape_string($trans_id); 
            $transactions_data["transaction_plateforme"]         = mysql_real_escape_string($plateforme);
            $transactions_data["transaction_command_certificat"] = __("En Attente", "ws");;
            //set the transaction status
            $transactions_data["transaction_command_statut"]     =__("En cours", "ws");
            $transactions_data["transaction_command_auth"]       =__("En Attente", "ws");
            $transactions_data["transaction_command_3dsecure"]   =__("En Attente", "ws");
            //set the transaction information
            $transactions_data["transaction_command_amount"]     = $amount;
            $transactions_data["transaction_command_currency"]   = mysql_real_escape_string($this->getCurrency($form_id)->alpha3);
            $infoone   = $this->getConfigurationByName($form_id, "vads_order_info");
            $infotwo   = $this->getConfigurationByName($form_id, "vads_order_info2");
            $infothree = $this->getConfigurationByName($form_id, "vads_order_info3");
            $infos     = $infoone["value"]." ".$infotwo["value"]." ".$infothree["value"];
            $transactions_data["transaction_command_info"]       = mysql_real_escape_string($infos);
            //set the customer infos
            $transactions_data["transaction_command_cardnumber"] = __("En Attente", "ws");
            $transactions_data["transaction_customer_name"]      = mysql_real_escape_string($datas["vads_cust_last_name"])." ".mysql_real_escape_string($datas["vads_cust_first_name"]);
            $transactions_data["transaction_customer_address"]   = mysql_real_escape_string($datas["vads_ship_to_street"])." ".mysql_real_escape_string($datas["vads_ship_to_street2"]);
            $transactions_data["transaction_customer_phone"]     = mysql_real_escape_string($datas["vads_cust_phone"]);
            $transactions_data["transaction_customer_cellphone"] = mysql_real_escape_string($datas["vads_cust_cell_phone"]);
            $transactions_data["transaction_customer_email"]     = mysql_real_escape_string($datas["vads_cust_email"]);
            $transactions_data["transaction_customer_country"]   = mysql_real_escape_string($datas["vads_cust_country"]);
            break;
        }
        //get the other infos and change them into json
        $inputs_data = $form_data["inputs_data"];
        $transactions_data["transaction_otherinfos_json"] = $this->createOtherInfosJson($inputs_data, $datas, $transactions_data);
        //insert the datas in the db
        $wpdb->show_errors(
            $insert = $wpdb->insert(
                $this->getSystempay()->get_transactions_table_name(),
                $transactions_data
            )
        );
        

        //if the insert is good , we go to the plateform
        if ($insert) {?>
            <div class='loading'>
              <img src='<?php echo WP_PLUGIN_URL;?>/wp-systempay/images/ajax-loader.gif'>
              <br/><p><?php _e("Please wait, you'll be redirected in a few moments.", "ws"); ?></p>
            </div>
        <?php //we create the hidden form
            $return_url = $this->getSystempay()->saved_inputs[$plateforme]["return_url"];
            $this->create_hidden_form($form_data, $confirmation_form_id, $return_url, $order_id, $trans_id, array("certificate_test", "certificate_test", "certificate_production", "vads_trans_id"));
            //we redirect to the plateforme page.
            parent::add_inline_js("jQuery('#".$confirmation_form_id."').submit();");
            //else we propose to retry or to cancel
        } else {
            _e("Error during the confirmation backup, please retry. If the problem persists, please contact the webmaster.", "ws");
            $form_id = $_GET[$this->getSystempay()->get_GET_key_confirmation_formid()];
            $return_url=$this->get_confirmationpage_url($form_id)."&WS_method=".$this->get_method_saveTransaction();
            $this->create_hidden_form($form_data, $confirmation_form_id, $return_url, $order_id, $trans_id, array("certificate_test","certificate_test", "certificate_production", "vads_trans_id"));
        }
    }

    private function createOtherInfosJson($inputs_data, $transactions_data)
    {
        $infos = array();
        foreach ($inputs_data as $groupe) {
            foreach ($groupe as $input) {
                $unique = true;
                foreach ($transactions_data as $transaction_data) {
                    if ($input["value"]==$transaction_data) {
                        $unique=false;
                    }
                }
                $info=array(
                  "label"=>$input["label"],
                  "value"=>$input["value"]
                );
                if ($unique == true) {
                    array_push($infos, $info);
                }
            }
        }

        foreach ($_POST as $key=>$value) {
            $unique = true;
            foreach ($infos as $info) {
                if ($value == $info["value"]) {
                    $unique=false;
                }
            }
            foreach ($transactions_data as $transaction_data) {
                if ($value==$transaction_data) {
                    $unique=false;
                }
            }
            $info=array(
              "label"=>$key
              ,"value"=>$value
            );
            if ($unique) {
                array_push($infos, $info);
            }   
        }
        return json_encode($infos);
    }

    private function create_hidden_form($confirmation_datas, $confirmation_form_id, $return_url, $order_id, $trans_id,$excludeds)
    {
        $form_data           = $confirmation_datas["form_data"];
        $plateforme          = $form_data["form_plateforme"];
        $configurations_data = $confirmation_datas["configurations_data"];
        $inputs_data         = $confirmation_datas["inputs_data"];
        echo "<form id='".$confirmation_form_id."' action='".$return_url."' method='post'>";
        //create unique inputs (transID,Order id);
        $this->createSpecialsInputs($plateforme, $order_id, $trans_id);
        foreach ($configurations_data as $configuration) {
            //know if the configuration is exluded or empty;
            $isEmpty    = $this->isemptyValue($configuration, "value");
            $isExcluded = $this->is_excluded($configuration["name"], $excludeds);
            if ((!$isExcluded)&&!($isEmpty)) {
              switch($plateforme) :
                case "systempay" :
                    //we prepare the signature and set it to the good input
                    if ($configuration["name"] == "signature") {
                        $signature = $this->getSystempay()->Systempay->WS_GetSignature($configurations_data, $inputs_data, $order_id, $trans_id);
                        echo "<input type='hidden' name='".$configuration["name"]."' value='".$signature."'/>";
                    //we set the amount to centimes 
                    } else if ($configuration["name"] == "vads_amount") {
                        $amount = floatval($configuration["value"]);
                        echo "<input type='hidden' name='".$configuration["name"]."' value='".$amount."'/>";
                    } else {
                        echo "<input type='hidden' name='".$configuration["name"]."' value='".$configuration["value"]."'/>";
                    }
                    break;
                default :
                    echo "<input type='hidden' name='".$configuration["name"]."' value='".$configuration["value"]."'/>";
                    break;
                endswitch;
            }
        }
        foreach ($inputs_data as $groupe) {
            foreach ($groupe as $input) {
                $isEmpty=$this->isemptyValue($input, "value");
                if (!$isEmpty) {
                    echo "<input type='hidden' name='".$input["name"]."' value='".$input["value"]."' />";
                }
            }
        }
        echo $this->getCancelLink();
        echo "<input type='submit' class='a-btn confirmation_button' id='confirm_confirm' value='".__("R&eacute;essayer", "ws")."' />";
        
        echo "</form>";
    }

    private function isemptyValue($value, $key)
    {
        if ( (empty($value[$key])) || ($value[$key] == "") || ($value[$key] == " ")) {
            return true;
        }
        return false;
    }

    private function generateOrderId($name, $trans_id)
    {
        $time=date("d-m-Y"); 
        return $time."-".$name."-".$trans_id;
    }

    private function createSpecialsInputs($plateforme, $order_id, $trans_id)
    {
        $order_id_name="";
        $trans_id_name="";
        switch($plateforme) {
        case "systempay" :
            $order_id_name="vads_order_id";
            $trans_id_name="vads_trans_id";
            break;
        }
        echo "<input type='hidden' value='".$order_id."' name='".$order_id_name."' />";
        echo "<input type='hidden' value='".$trans_id."' name='".$trans_id_name."' />";
    }
}
?>