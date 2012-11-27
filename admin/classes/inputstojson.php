<?php
function inputsToJSON($form_to_update, $WS_formals_inputs, $WS_additionals_inputs, $WS_customer_inputs) {
    //set the inputs with the datas from database .
    if (!empty($form_to_update)) {
        if (!empty($WS_formals_inputs)) {
            $WS_formals_inputs = mergeConfigurations($WS_formals_inputs, $form_to_update);
        }
        if (!empty($WS_additionals_inputs)) {
            $WS_additionals_inputs = mergeConfigurations($WS_additionals_inputs, $form_to_update);
        }
        if (!empty($WS_customer_inputs)) {
            $WS_customer_inputs = mergeInputs($WS_customer_inputs, $form_to_update);
        }
    }

    $data = array(
      "formals_infos"=>$WS_formals_inputs,
      "additionals_infos"=>$WS_additionals_inputs,
      "customer_infos"=>$WS_customer_inputs
    );
    echo json_encode($data);
}

function mergeInputs($inputs_to_update, $form_from_sql){
    $array_to_update = array();
    foreach ($inputs_to_update as $input_to_update) {
        foreach ($form_from_sql["inputs_data"][0] as $input_saved) {
            if ($input_to_update["name"] == $input_saved->input_name) {
                $input_to_update["label"]    = $input_saved->input_label;
                $input_to_update["value"]    = $input_saved->input_value;
                $input_to_update["hide"]     = $input_saved->input_hide;
                $input_to_update["required"] = $input_saved->input_required;
                $input_to_update["class"]    = $input_saved->input_class;
                $input_to_update["order"]    = $input_saved->input_order;
                $input_to_update["type"]     = $input_saved->input_type;
                $input_to_update["amount"]   = $input_saved->input_amount;
                $input_to_update["fieldset"] = $input_saved->input_fieldset;
                $input_to_update["options"]  = $input_saved->input_options;
            }
        }
        array_push($array_to_update, $input_to_update);
    }
    if (!empty($inputs_to_update)) {
        return $array_to_update;
    }
    return false;
}

function mergeConfigurations($configs_to_update, $form_from_sql){
    $array_to_update=array();
    $saved_inputs = array();
    foreach ($configs_to_update as $config_to_update) {
        foreach ($form_from_sql["configurations_data"] as $config_saved) {
            if ($config_to_update["name"] == $config_saved->configuration_name) {
                $config_to_update["label"] = $config_saved->configuration_label;
                $config_to_update["value"] = $config_saved->configuration_value;
                $config_to_update["hide"]  = $config_saved->configuration_hide;
                array_push($array_to_update, $config_to_update);
                $saved_inputs[$config_to_update["name"]] = $config_to_update["value"];
            }
        }
    }
    //if a new input has been added in gateways.class
    foreach ($configs_to_update as $config_to_update) {
        if (!array_key_exists($config_to_update["name"], $saved_inputs)) {
            array_push($array_to_update, $config_to_update);
        }
    }

    if (!empty($configs_to_update)) {
        return $array_to_update;
    }
    return false;
}
?>