<?php

 class WSTools {
    
    private $_systempay;
    protected $arrayRules;

    public function __construct($systempay)
    {
        $this->arrayRules = array();
        $this->_systempay = $systempay;
    }

    public function getSystempay()
    {
        return $this->_systempay;
    }

    public function setSystempay($systempay)
    {   
        $this->_systempay = $systempay;
    }

    public function prepare_data($groupinputs)
    {
        $index_fieldset = 0;
        foreach ($groupinputs as $group) {
            $index_input = 0;
            foreach ($group as $input) {
                if (($input["name"] == "") && ($index_input > 0)) {
                    unset($groupinputs[$index_fieldset]);
                }
                $index_input++;
            }
            $index_fieldset++;
        }
        return $groupinputs;
    }

    /**Method used to transform the inputs from SQL to an array
    */
    public function inputsObjectToArray($inputs_object, $prefixe)
    {
        $inputs_array = array();
        if ($inputs_object) {
            foreach ($inputs_object as $input_object) {
                $object_to_array = (array) $input_object;
                $input_array=array();
                if ($prefixe) {
                    foreach ($input_object as $key=>$value ) {
                        $key = str_replace($prefixe, "", $key);
                        $input_array[$key] = $value;
                    }
                }
                array_push($inputs_array, $input_array);
            }
        }
        return $inputs_array;
    }

    /**Method used to transform the inputs from SQL to an array
    */
    public function inputsObjectToArrayArray($inputs_object, $prefixe)
    {
        $inputs_array = array();
        if ($inputs_object) {
            foreach ($inputs_object as $fielset_object) {
                $fieldset_array = array();
                foreach ($fielset_object as $input_object) {
                    $object_to_array = (array) $input_object;
                    $input_array=array();
                    if ($prefixe) {
                        foreach ($input_object as $key=>$value ) {
                            $key = str_replace($prefixe, "", $key);
                            $input_array[$key] = $value;
                        }
                    }
                    array_push($fieldset_array, $input_array);
                }
                array_push($inputs_array, $fieldset_array);
            }
        }
        return $inputs_array;
    }

    /**
    * get the form datas of the SQL database
    */
    public function getFormDataObjectById($form_id)
    {
        global $wpdb;
        (int)($form_id);
        $form_data = $wpdb->get_row("SELECT * FROM ".$this->getSystempay()->get_form_table_name()." WHERE form_id = ".$form_id);
        return $form_data;
    }
    public function getFormIdByName($name)
    {
        global $wpdb;
        $form_id = $wpdb->get_row("SELECT form_id FROM ".$this->getSystempay()->get_form_table_name()." WHERE form_name = '".$name."'","ARRAY_N");
        return $form_id[0];
    }
    /** get the formals inputs datas of the SQL database
    */
    public function getConfigurationsObjectById($form_id)
    {
        global $wpdb;
        (int)($form_id);
        $configurations_data = $wpdb->get_results("SELECT * FROM ".$this->getSystempay()->get_configurations_table_name()." WHERE configuration_form_id = ".$form_id);
        return $configurations_data;
    }

    public function getOrderString($form_id){
        global $wpdb;
        /**
         *   TODO  
         *   Need to add custom global config for each field
         */
        if (!empty($form_id)) {
            (int)($form_id);
            $generalconfig = json_decode(
                $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT WSconfig_json FROM ".$this->getSystempay()->get_WSconfig_table_name()." WHERE WSconfig_form_id = ".$form_id
                    )
                )
            );
            return $generalconfig->order_format->name;
        } else {
            /**
             * If we find nothing we return random char : 
             */
            return substr(md5(microtime()), rand(0,26), 5);    
        }
        
    }

    /**get the additionals inputs datas of the SQL database
    */
    public function getAdditionalsInputsObjectById($form_id)
    {
        global $wpdb;
        (int)($form_id);
        $fieldsets = $wpdb->get_results("SELECT DISTINCT input_fieldset FROM ".$this->getSystempay()->get_inputs_table_name()." WHERE input_form_id = ".$form_id." ORDER BY input_fieldset;");
        $groupes=array();
        foreach ($fieldsets as $fieldset) {
            $number = $fieldset->input_fieldset;
            $input_get = $wpdb->get_results("SELECT * FROM ".$this->getSystempay()->get_inputs_table_name()." WHERE input_form_id = ".$form_id." AND input_fieldset = ".$number." ORDER BY input_order;");
            array_push($groupes, $input_get);
        }
        return $groupes;
    }

    /**get the Form from the SQL database
    */
    public function getFormObjectById($form_id) 
    {
        $WS_form = array(
            "form_data"=> $this->getFormDataObjectById($form_id)
            ,"configurations_data"=> $this->getConfigurationsObjectById($form_id)
            ,"inputs_data"=> $this->getAdditionalsInputsObjectById($form_id)
        );
        return $WS_form;
    }

    /**Get the datas of your configurations with their form ID
    */
    public function getConfigurationsArrayById($form_id)
    {
        (int)($form_id);
        $inputs_object = $this->getConfigurationsObjectById($form_id);
        $inputs_array = $this->inputsObjectToArray($inputs_object, "configuration_");
        return $inputs_array;
    }
    /**Get the datas of your additionalsInputs with their form ID
    */
    public function getAdditionalsInputsArrayById($form_id)
    {
        (int)($form_id);
        $inputs_object = $this->getAdditionalsInputsObjectById($form_id);
        return $this->inputsObjectToArrayArray($inputs_object,"input_"); //colin
    }

    /**Get the datas of your form with his ID
    */
    public function getFormDataArrayById($form_id)
    {
        (int)($form_id);
        return (array)$this->getFormDataObjectById($form_id);
    }

    /** get the form in an array with his ID
    */
    public function getFormArrayById($form_id)
    {
        (int)($form_id);
        $WS_form = array(
            "form_data"=> $this->getFormDataArrayById($form_id),
            "configurations_data"=> $this->getConfigurationsArrayById($form_id, false),
            "inputs_data"=> $this->getAdditionalsInputsArrayById($form_id)
        );
        return $WS_form;
    }

    public function getElementByName($form_id,$needed_name)
    {
        $element = $this->getConfigurationByName($form_id, $needed_name);
        if (!empty($element)) {
            return $element;
        }
        $element = $this->getInputByName($form_id, $needed_name);
        if (!empty($element)) {
            return $element;
        }
        return false;
    }

    public function getInputByName($form_id, $needed_name)
    {
        $inputs_data = $this->getAdditionalsInputsArrayById($form_id);
        foreach ($inputs_data as $groupe) {
            foreach ($groupe as $input) {
                if ($input["name"]==$needed_name) {
                    return $input;
                }
            }
        }
    }

    public function getPlateforme($form_id)
    {
        $form = $this->getFormDataArrayById($form_id);
        return $form["form_plateforme"];
    }

    public function getCurrency($form_id)
    {
        switch ($this->getPlateforme($form_id)) {
        case 'systempay':
            $currency = $this->getConfigurationByName($form_id, "vads_currency");
            $numeric  = $currency["value"];
            return $this->getSystempay()->getSystempayEl()->CurrenciesManager->findCurrencyByNumCode($numeric);
            break;
        default:
            break;
        }
    }


    public function getConfigurationByName($form_id, $needed_name)
    {
        $configurations_data = $this->getConfigurationsArrayById($form_id);
        foreach ($configurations_data as $configuration) {
            if ($configuration["name"] == $needed_name) {
                return $configuration;
            }
        }
        return false;
    }

    public function getLastGeneralConfigId()
    {
        global $wpdb;
        $lastId = $wpdb->get_var($wpdb->prepare("SELECT generalconfig_id FROM ".$this->getSystempay()->get_generalconfig_table_name()." ORDER BY generalconfig_id DESC"));
        if (empty($lastId)) {
            return false;
        }
        return($lastId);
    }

    public function getGeneralConfig()
    {
        global $wpdb;
        $config_id = $this->getLastGeneralConfigId();
        if (!empty($config_id)) {
            (int)($config_id);
            return json_decode($wpdb->get_var($wpdb->prepare("SELECT generalconfig_json FROM ".$this->getSystempay()->get_generalconfig_table_name()." WHERE generalconfig_id='".$config_id."'")));
        }
        return false;
    }

    public function WSConfigExist($form_id)
    {
        global $wpdb;
        (int)($form_id);
        $WSconfig_data = $wpdb->get_var("SELECT WSconfig_id FROM ".$this->getSystempay()->get_WSconfig_table_name()." WHERE WSconfig_form_id = ".$form_id);
        if ($WSconfig_data != "") {
            return true;  
        } else {
            return false;
        }
        
    }
    
    public function getFormWSConfig($form_id)
    {
        global $wpdb;
        (int)($form_id);
        $WSconfig_data = $wpdb->get_var("SELECT WSconfig_json FROM ".$this->getSystempay()->get_WSconfig_table_name()." WHERE WSconfig_form_id = ".$form_id);
        return json_decode($WSconfig_data);
    }


    public function mergeWSConfigs($form_id)
    {
        $obj1 = $this->getGeneralConfig();
        $obj2 = $this->getFormWSConfig($form_id);
        return $obj_merged = (object) array_merge((array) $obj1,(array) $obj2 );
    }
}
?>