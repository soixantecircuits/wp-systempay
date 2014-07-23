<?php
class WSSystempay
{

    private $_options_prefixe;
    public  $CurrenciesManager;

    public function __construct($options_prefixe){
        $this->options_prefixe = $options_prefixe;
        $this->CurrenciesManager = new SystempayCurrenciesManager();
    }

    public function systemPay_GetTransId()
    {
        // Dans cet exemple la valeur du compteur est stocké dans un fichier count.txt,incrémenté de 1 et remis à zéro si la valeur est superieure à 899999
        // ouverture/lock 

        $option_name = $this->options_prefixe.'systempay_transid' ;
        $newvalue    = 0;
        if (!($last_id = get_option($option_name))) { 
            update_option($option_name, $newvalue);
        }
        // lecture/incrémentation
        $count = (int)$last_id;
        $count++;
        if (($count < 0) || ($count > 899999)) {
            $count = 0;
        }
        update_option($option_name, $count);
        $trans_id = sprintf("%06d", $count);
        return($trans_id);
    }

    public function systempay_GetSignature($field, $key)
    {
        ksort($field); // tri des paramétres par ordre alphabétique
        $contenu_signature = "";
        foreach ($field as $nom => $valeur) {
            $isEmpty = $this->valueIsEmpty($valeur);
            if ((substr($nom, 0, 5) == 'vads_') && !$isEmpty) {
                $contenu_signature .= $valeur."+";
            }
        }

        $contenu_signature .= $key; // On ajoute le certificat à la fin de la chaîne.
        $signature = sha1($contenu_signature);

        if(WP_DEBUG === true){
            error_log($contenu_signature);
        }

        return($signature);
    }

    public function WS_GetSignature($merged_configurations, $merged_inputs, $order_id, $trans_id) 
    {
        $certificate = null;
        $fields      = array();
        foreach ($merged_configurations as $configuration) {
            $fields[$configuration["name"]] = $configuration["value"];
        }

        foreach ($merged_inputs as $groupe) {
            foreach ($groupe as $input) {
                $fields[$input["name"]] = $input["value"];
            }
        }

        //modifications
        if ($fields["vads_ctx_mode"] == "TEST" ) {
            $certificate = $fields["certificate_test"];
        } else {
            $certificate=$fields["certificate_production"];
        }
        $fields["vads_amount"]   = floatval($fields["vads_amount"]);
        $fields["vads_order_id"] = $order_id;
        $fields["vads_trans_id"] = $trans_id;

        if (isset($certificate)&&(!empty($certificate))) {
            return $this->systemPay_GetSignature($fields, $certificate);
        } else {
            _e("<br/>Warning : the certificate is missing/empty<br/>", "ws");
        }
    }

    public function systemPay_GetTransDate()
    {
        return gmdate("YmdHis", time());
    }

    private function valueIsEmpty($value)
    {
        if (empty($value) || $value == "" || $value == " ") {
            return true;
        }
        return false;
    }
}
?>