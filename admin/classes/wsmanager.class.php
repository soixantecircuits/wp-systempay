<?php
class WSManager extends WSTools
{

    public function __construct($systempay)
    {
        parent::__construct($systempay);
    }
    
    public function getFormsList() 
    {
        global $wpdb;
        $WS_forms = $wpdb->get_results("SELECT * FROM ".$this->getSystempay()->get_form_table_name());
        return $WS_forms;
    }

    public function getTransactionGroupes()
    {
        global $wpdb;
        $WS_forms = $wpdb->get_results($wpdb->prepare( "SELECT transaction_form_name, transaction_form_id, count(*) as transaction_total FROM ".$this->getSystempay()->get_transactions_table_name()." WHERE transaction_form_name IS NOT NULL GROUP BY transaction_form_id;"));
        return $WS_forms;
    }

    public function getLastFormId() 
    {
        global $wpdb;
        $lastId = $wpdb->get_var($wpdb->prepare( "SELECT form_id FROM ".$this->getSystempay()->get_form_table_name()." ORDER BY form_id DESC"));  
        if (empty($lastId)) {
            return 1;
        }
        return($lastId);
    }

    public function deleteForm($form_id)
    {
        //DELETE configurations
        global $wpdb;
        //DELETE INPUTS 
        $query = $wpdb->query( 
            $wpdb->prepare( 
                "DELETE form.*,config.*,input.*, wsconfig.* FROM ".$this->getSystempay()->get_form_table_name()." AS form"
                    ." LEFT JOIN ".$this->getSystempay()->get_configurations_table_name()." AS config ON config.configuration_form_id = form.form_id"
                    ." LEFT JOIN ".$this->getSystempay()->get_inputs_table_name()." AS input ON input.input_form_id = form.form_id"
                    ." LEFT JOIN ".$this->getSystempay()->get_WSconfig_table_name()." AS wsconfig ON WSconfig.WSconfig_form_id = form.form_id"
                    ." WHERE form.form_id = "
                .$form_id
            )
        );
    }

    public function newForm($form, $inputs, $configurations, $WS_config)
    { 
        global $wpdb;
        //FORMS
        //prepare form          
        $inputs         = stripslashes_deep($inputs);
        $form           = stripslashes_deep($form);
        $configurations = stripslashes_deep($configurations);
        $WS_config      = stripslashes_deep($WS_config);

        $form_data = array(
             "form_name" => $form["name"]
            ,"form_css_class" => $form["css_class"]
            ,"form_plateforme"=> $form["plateforme"]
        );

        

        //insert forms
        $wpdb->insert(
            $this->getSystempay()->get_form_table_name(), 
            $form_data
        );
        $form_id = $wpdb->insert_id;
        
        //INPUTS
        foreach ($inputs as $input) 
        {
            //prepare input
            $inputs_data = array(
                    "input_form_id" => $form_id
                    ,"input_label" => $input["label"]
                    ,"input_name" => $input["name"]
                    ,"input_value" => $input["value"]
                    ,"input_order" => $input["order"]
                    ,"input_hide" => $input["hide"]
                    ,"input_required" => $input["required"]
                    ,"input_class" => $input["class"]
                    ,"input_type" => $input["type"]
                    ,"input_fieldset" => $input["fieldset"]
                    ,"input_options" => $input["options"]
            );
            //insert input
            $wpdb->insert(
                $this->getSystempay()->get_inputs_table_name(), 
                $inputs_data
            );
        }
        
        //configurations
        foreach ($configurations as $configuration) {
            $configurations_data = array(
                    "configuration_form_id" => $form_id
                    ,"configuration_label" => $configuration["label"]
                    ,"configuration_name" => $configuration["name"]
                    ,"configuration_value" => $configuration["value"]
                    ,"configuration_function" => $configuration["function"]
                    ,"configuration_hide" => $configuration["hide"]
                    ,"configuration_required" => $configuration["required"]
                    ,"configuration_class" => $configuration["class"]
            );
            //insert input
            $wpdb->insert(
                $this->getSystempay()->get_configurations_table_name(), 
                $configurations_data
            );
        }
        //WS Config
        $this->insertWSConfigs($form_id, $WS_config);
        
        return $form_id;
    }

    public function updateForm($form_id, $form, $inputs, $configurations, $WS_config)
    { 
        global $wpdb;
        //FORMS

        //prepare form  
        $inputs         = stripslashes_deep($inputs);
        $form           = stripslashes_deep($form);
        $configurations = stripslashes_deep($configurations);
        $WS_config      = stripslashes_deep($WS_config);


        $where = array(
          "form_id" => $form_id
        );  
        $where_format = array(
          "%d"
        );

        $form_data = array(
             "form_name" => $form["name"],
             "form_css_class" => $form["css_class"],
             "form_plateforme"=> $form["plateforme"]
        );
        $data_formats = array(
             "%s",
             "%s",
             "%s"
        );
        $wpdb->update( 
            $this->getSystempay()->get_form_table_name(),
            $form_data,
            $where,
            $data_formats,
            $where_format
        );
      
        //Update WSConfig
        $WSConfigExist = $this->WSConfigExist($form_id);
        if (!$WSConfigExist) {
            $this->insertWSConfigs($form_id, $WS_config);
        } else {
            $this->updateWSConfigs($form_id, $WS_config);
        }

        if (isset($configurations) && count($configurations) > 0) {
            //UPDATE configurations (delete all then insert them)
            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM ".$this->getSystempay()->get_configurations_table_name()." WHERE configuration_form_id = ".
                    $form_id
                )
            );

            foreach ($configurations as $configuration) {
                $configurations_data = array(
                    "configuration_form_id" => $form_id
                    ,"configuration_label" => $configuration["label"]
                    ,"configuration_name" => $configuration["name"]
                    ,"configuration_value" => $configuration["value"]
                    ,"configuration_function" => $configuration["function"]
                    ,"configuration_hide" => $configuration["hide"]
                    ,"configuration_required" => $configuration["required"]
                    ,"configuration_class" => $configuration["class"]
                );
                    //insert input
                $wpdb->insert(
                    $this->getSystempay()->get_configurations_table_name(), 
                    $configurations_data
                );
            }
        }

        if (isset($inputs) && count($inputs) > 0) {
            //UPDATE INPUTS (delete all then insert them) - DIRTY HACK, to modify
            $wpdb->query( 
                $wpdb->prepare( 
                    "DELETE FROM ".$this->getSystempay()->get_inputs_table_name()." WHERE input_form_id = ".
                    $form_id
                )
            );

            foreach ($inputs as $input) {
                $inputs_data = array(
                    "input_form_id" => $form_id
                    ,"input_label" => $input["label"]
                    ,"input_name" => $input["name"]
                    ,"input_value" => $input["value"]
                    ,"input_order" => $input["order"]
                    ,"input_hide" => $input["hide"]
                    ,"input_required" => $input["required"]
                    ,"input_class" => $input["class"]
                    ,"input_type" => $input["type"]
                    ,"input_fieldset" => $input["fieldset"]
                    ,"input_options" => $input["options"]
                );
                //insert input
                $wpdb->insert(
                    $this->getSystempay()->get_inputs_table_name(), 
                    $inputs_data
                );
            }
        }
    }

    public function insertWSConfigs($form_id, $WS_config)
    {
        global $wpdb;
        //WSCONFIG
        $WSconfig_data = array(
            "WSconfig_form_id" => $form_id
            ,"WSconfig_json"=>json_encode($WS_config)
        );

        //insert input
        $wpdb->insert(
            $this->getSystempay()->get_WSconfig_table_name(),
            $WSconfig_data
        );
    }

    public function updateWSConfigs($form_id, $WS_config){
        global $wpdb;
        //prepare form  
        $where = array(
            "WSconfig_form_id" => $form_id
        );  
        $where_format = array(
            "%d"
        );
        $WSconfig_data = array(
            "WSconfig_form_id" => $form_id,
            "WSconfig_json"=>json_encode($WS_config)
        );

        $data_formats = array(
             "%d",
             "%s"
        );

        $wpdb->update(
            $this->getSystempay()->get_WSconfig_table_name(),
            $WSconfig_data,
            $where,
            $data_formats,
            $where_format
        );
    }

    public function getTransactions()
    {
        global $wpdb;
        $transactions_object = $wpdb->get_results("SELECT * FROM ".$this->getSystempay()->get_transactions_table_name());
        return $transactions_object;
    }

    public function getTransactionsByIdForm($id)
    {
          global $wpdb;
          $transactions_object = $wpdb->get_results("SELECT * FROM ".$this->getSystempay()->get_transactions_table_name()." WHERE transaction_form_id = ".$id);
          return $transactions_object;
    }

    public function getTransactionByIdTransaction($id)
    {
          global $wpdb;
          $transaction_object = $wpdb->get_row("SELECT * FROM ".$this->getSystempay()->get_transactions_table_name()." WHERE transaction_id = ".$id);
          return $transaction_object;
    }

    public function getInputsById($id) {
          global $wpdb;
          $transaction_object = $wpdb->get_results("SELECT * FROM ".$this->getSystempay()->get_inputs_table_name()." WHERE input_form_id = ".$id);
          return $transaction_object;
    }

    public function updateGeneralConfig()
    {
        global $wpdb;
        $last_id = $this->getLastGeneralConfigId();
        (int)($last_id);
        $where = array(
            "generalconfig_id" => $last_id
        );  
        $where_format = array(
            "%d"
        );

        $config_data = array(
            "generalconfig_json" => json_encode($_POST["generalconfig"])
        );
        $data_formats = array(
            "%s"
        );

        $wpdb->update(
            $this->getSystempay()->get_generalconfig_table_name(),
            $config_data,
            $where,
            $data_formats,
            $where_format
        );
    } 

    public function updatedb()
    {
        //ob_start();
        $this->renameTable();
        $this->insertDbOption();
        $this->addfield();    
    
        global $wp_systempay_db_version;        
        update_option("wp_systempay_db_version", $wp_systempay_db_version);
        //trigger_error(ob_get_contents(),E_USER_ERROR);
        wp_redirect( admin_url()."admin.php?page=WS_main" ); exit;
    }

    public function renameTable(){
        $wsConfigTable = $this->getSystempay()->get_WSconfig_table_name();
        $installed_ver = get_option("wp_systempay_db_version");
        
        if (version_compare($installed_ver,  "1.1.3", "<")) {
            global $wpdb;
            $ws_rename = "RENAME TABLE ".$wpdb->prefix."payform_payformconfig TO ".$this->getSystempay()->get_WSconfig_table_name().";";
            //create process
            $res = $wpdb->query($ws_rename);
            $ws_rename = "ALTER TABLE ".$this->getSystempay()->get_WSconfig_table_name()." CHANGE payformconfig_id WSconfig_id INTEGER".
                         ", CHANGE payformconfig_form_id WSconfig_form_id INTEGER".
                         ", CHANGE payformconfig_json WSconfig_json TEXT;";
            //create process   
            $res = $wpdb->query($ws_rename);
        }
    }

    public function addfield()
    {
        $transaction_table = $this->getSystempay()->get_transactions_table_name();

        $installed_ver = get_option("wp_systempay_db_version");
        
        if (version_compare($installed_ver,  "1.1.1", "<")) {
            $ws_add_shipping = "ALTER TABLE $transaction_table ADD
              transaction_customer_shipping_address VARCHAR(200);";
            //create process
            global $wpdb;
            $res = $wpdb->query($ws_add_shipping);
        }
        
        if (version_compare($installed_ver, "1.1.2", "<")) {
            $ws_add_shipping = "ALTER TABLE $transaction_table
                                ADD (
                                      transaction_customer_city VARCHAR(200),
                                      transaction_customer_zip VARCHAR(200)
                                    );";
            global $wpdb;
            $res = $wpdb->query($ws_add_shipping);  
        }      
        
    }

    /**
     * update the DB for new input
     * 
     * @return void
     * 
     * */
    private function insertDbOption() 
    {
        $installed_ver = get_option("wp_systempay_db_version");
        if (version_compare($installed_ver,  "1.1.1", "<")) {
            global $wpdb;
            //prepare input
            
            $form_to_update = $wpdb->get_results("SELECT input_form_id FROM ".$this->getSystempay()->get_inputs_table_name()." GROUP BY input_form_id");

            foreach ($form_to_update as $key => $value) {
                $data_to_update = array( 
                            "input_form_id"=>$value->input_form_id,    
                            "input_name"=>"vads_cust_address",
                            "input_label"=>__("Address", "ws"),
                            "input_value" => "",
                            "input_hide"=>false,
                            "input_required"=>false,
                            "input_order"=>5,
                            "input_type"=>"text",
                            "input_fieldset"=>-1,
                            "input_options"=>"",
                            "input_class"=>""
                          );

                $wpdb->insert(
                    $this->getSystempay()->get_inputs_table_name(), 
                    $data_to_update
                );                    
            }
        }
    }
}
?>