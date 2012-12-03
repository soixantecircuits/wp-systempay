<?php

class WSGateways{
    private $_gateways;
    private $_Payfrom;
    private $_return_url;
    private $_systempayCurrencies;


    public function __construct($result_page_url, $systempayCurrencies)
    {
        $this->return_url = $result_page_url;
        $this->createSystempayCurrencies($systempayCurrencies);
        $this->createGateways();
    }

    public function get_gateways()
    {
        return $this->_gateways;
    }

    public function createSystempayCurrencies($systempayCurrencies)
    {
        $array_currencies = array();
        foreach ($systempayCurrencies as $currency) {
            $array_currencies[$currency->alpha3] = $currency->num;
        }
        $this->_systempayCurrencies = $array_currencies;
    }

    public function createGateways()
    {
        $documentation = "https://systempay.cyberpluspaiement.com/html/Doc/2.2_Guide_d_implementation_formulaire_Paiement_V2.pdf";
        $SystempayCurrencies = new SystempayCurrenciesManager();
        $this->_gateways      = array(
            "systempay"=> array(
              "return_url" => "https://paiement.systempay.fr/vads-payment/"
              ,"amount_input_name" =>"vads_amount"
              ,"formals_configs"=> array(
                        array( 
                          "name"=>"vads_currency"
                          ,"label"=>__("currency", "ws")
                          ,"value" => "978"
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("currency", "ws")
                          ,"admin_type"=>"select"
                          ,"admin_options"=>json_encode($this->_systempayCurrencies)
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_amount"
                          ,"label"=>__("amount", "ws")
                          ,"value" => "0"
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("Amount of the order expressed in the normal.Example : 10.5 euros = 10.5 euros", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_site_id"
                          ,"label"=>__("site_id")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("Identifiant Boutique à récupérer dans le Back office Payzen", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"certificate_test"
                          ,"label"=>__("certificate test")
                          ,"value" => "" //here is the name of the function
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("To get from the Payzen BackOffice. Please note this certificate is different depending on the mode TEST or PRODUCTION.The certificate is needed by the function systemPay_GetSignature() .", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"certificate_production"
                          ,"label"=>__("certificate production")
                          ,"value" => "" //here is the name of the function
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("To get from the Payzen BackOffice. Please note this certificate is different depending on the mode TEST or PRODUCTION.The certificate is needed by the function systemPay_GetSignature() .", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_ctx_mode"
                          ,"label"=>__("operation mode", "ws")
                          ,"value" => "TEST" //here is the name of the function
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("operation mode . Value = TEST or PRODUCTION", "ws")
                          ,"admin_type"=>"radio"
                          ,"admin_options"=>json_encode(array("TEST"=>"TEST","PRODUCTION"=>"PRODUCTION"))
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_version"
                          ,"label"=>__("version", "ws")
                          ,"value" => "V2" //here is the name of the function
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("this parametre MUST BE 'V2'", "ws")
                          ,"admin_type"=>"immutable"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"signature"
                          ,"label"=>__("signature", "ws")
                          ,"value" => "WS_GetSignature"
                          ,"function" =>1
                          ,"hide"=>true
                          ,"description"=>__("calculated by the function systempay_GetSignature() / ws_GetSignature from the class ws", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_trans_date"
                          ,"label"=>__("transaction date", "ws")
                          ,"value" => "systemPay_GetTransDate"
                          ,"function" =>1
                          ,"hide"=>true
                          ,"description"=>__("date of the transaction exprimée sous la forme YYMMDDHHMMSS on the time zone UTC=0", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_trans_id"
                          ,"label"=>__("transaction id", "ws")
                          ,"value" => "systemPay_GetTransId"
                          ,"function" =>1
                          ,"hide"=>true
                          ,"description"=>__("unique id of the transaction", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )

                        ,array( 
                          "name"=>"vads_page_action"
                          ,"label"=>__("page action", "ws")
                          ,"value" => "PAYMENT"
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("this parameter MUST BE PAYMENT", "ws")
                          ,"admin_type"=>"immutable"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_action_mode"
                          ,"label"=>"action mode"
                          ,"value" => "INTERACTIVE"
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>sprintf(__("This parameter is valued at INTERACTIVE if the entry is made on the card payment platform. See <a href='%s'>documentation</a>", "ws"), $documentation)
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_payment_config"
                          ,"label"=>__("payment config", "ws")
                          ,"value" => "SINGLE"
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>sprintf(__("This parameter is valued at SINGLE for a unitary payment , MULTI for payement in several times. See <a href='%s'>documentation</a>", "ws"), $documentation)
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
              )
              ,"additionals_configs" => array(
                        array(
                          "name"=>"vads_redirect_success_timeout"
                          ,"label"=>__("redirect success timeout", "ws")
                          ,"value" => "0"
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("This parameter sets the delay before client reroute on the site merchant in the case of a successful payment. This period is expressed in seconds and must bebetween 0 and 300 seconds.", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array(
                          "name"=>"vads_redirect_success_message"
                          ,"label"=>__("redirect success message", "ws")
                          ,"value" => __("The payement has been made, you'll be redirected to the website soon.", "ws")
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("This parameter specifies the message to wait before redirecting to the sitemerchant in the case of a successful payment.", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array(
                          "name"=>"vads_redirect_error_timeout"
                          ,"label"=>__("redirect error timeout", "ws")
                          ,"value" => "0"
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("Same that success timeout but in case of error.", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array(
                          "name"=>"vads_redirect_error_message"
                          ,"label"=>__("redirect error message", "ws")
                          ,"value" => __("Sorry, it has been an error during the payement. Please try again later. We did not charge you for this operation.", "ws")
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("Same that success message but in case of error.", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array(
                          "name"=>"redirect_success_message"
                          ,"label"=>__("redirect success timeout", "ws")
                          ,"value" => __("You'll be redirected soon.", "ws")
                          ,"function" =>false
                          ,"hide"=>true
                          ,"description"=>__("This parameter specifies the message to wait before redirecting to the sitemerchant in the case of a successful payment.", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_language"
                          ,"label"=>__("language", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>12
                          ,"description"=>__("customer's language", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_capture_delay"
                          ,"label"=>__("capture delay", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>13
                          ,"description"=>__("This parameter defines the time for giving bank in days. After vacuum payment platform takes a default value defined in the back office 'management tool box'", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_contrib"
                          ,"label"=>__("contribution name", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>14
                          ,"description"=>__("the name used when paying contributions (joomla, oscommerce ...)", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_order_info"
                          ,"label"=>__("order_info", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>16
                          ,"description"=>__("Free optional fields that may for example be used to store a summary of order", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_order_info2"
                          ,"label"=>__("order_info", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>17
                          ,"description"=>__("Free optional fields that may for example be used to store a summary of order", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_order_info3"
                          ,"label"=>__("order_info", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>18
                          ,"description"=>__("Free optional fields that may for example be used to store a summary of order", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_payment_cards"
                          ,"label"=>__("payment_cards", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>19
                          ,"description"=>__("Lists the types of cards offer to the user, separated by ';'. Default value EMPTY is recommended", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_return_mode"
                          ,"label"=>__("return mode", "ws")
                          ,"value" => "GET"
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>20
                          ,"description"=>__("NONE , GET or POST", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_url_success"
                          ,"label"=>__("url success", "ws")
                          ,"value" => $this->_return_url
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>21
                          ,"description"=>__("URL where the customer is redirected if successful payment,after pressing the button 'return to the store'", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                          
                        )
                        ,array( 
                          "name"=>"vads_url_referral"
                          ,"label"=>__("url_referral", "ws")
                          ,"value" => $this->_return_url
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>22
                          ,"description"=>__("URL where the customer is redirected in case of refusal of authorization 02 'contact the card issuer' after pressing the button 'return to the store. '", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_url_refused"
                          ,"label"=>__("url refused", "ws")
                          ,"value" => $this->_return_url
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>23
                          ,"description"=>__("URL where the customer is redirected in case of refusal for any other cause that the refusal to allow the pattern 02", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_url_cancel"
                          ,"label"=>__("url cancel", "ws")
                          ,"value" => $this->_return_url
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>24
                          ,"description"=>__("URL where the customer is redirected if it presses 'cancel and return to the store ' before payment is made.", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_url_error"
                          ,"label"=>__("url error", "ws")
                          ,"value" => $this->_return_url
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>25
                          ,"description"=>__("URL where the customer is redirected if an error processing internal", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )
                        ,array( 
                          "name"=>"vads_url_return"
                          ,"label"=>__("url return")
                          ,"value" => $this->_return_url
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>26
                          ,"description"=>__("Where URL is redirected by default the client after pressing the button to return to the shop ', if the URL corresponding to the scenarios seen above are not filled.", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""                        
                        )
                        ,array( 
                          "name"=>"vads_contracts"
                          ,"label"=>__("contract", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>27
                          ,"description"=>__("Optional parameter to specify for each network acceptance, merchant to use the contract. The formalism of the parameter is: Network 1 = contratNetwork1; network2 = contratNetwork2; network3 = contratNetwork3", "ws")
                          ,"admin_type"=>"texte"
                          ,"admin_options"=>""
                          ,"admin_value"=>""
                        )                             
              )
              ,"customer_infos" => array(
                        array( 
                          "name"=>"vads_cust_title"
                          ,"label"=>__("Title", "ws")
                          ,"value" => "1;0"
                          ,"function" =>false
                          ,"hide"=>false
                          ,"required"=>false
                          ,"order"=>1
                          ,"description"=>__("Customer's social title", "ws")
                          ,"type"=>"radio"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>"Mme = 0 ; Mr = 0"
                          ,"class"=>"radio_align"
                          ,"required"=>true
                        )
                        ,array( 
                            "name"=>"vads_cust_first_name"
                            ,"label"=>__("Firstname", "ws")
                            ,"value" => ""
                            ,"order"=>2
                            ,"hide"=>false
                            ,"required"=>false
                            ,"description"=>__("Customer's name", "ws")
                            ,"type"=>"text"
                            ,"amount"=>0
                            ,"fieldset"=>-1
                            ,"options"=>""
                            ,"class"=>""
                            ,"required"=>true
                        )
                        ,array( 
                            "name"=>"vads_cust_last_name"
                            ,"label"=>__("Lastname", "ws")
                            ,"value" => ""
                            ,"order"=>3
                            ,"hide"=>false
                            ,"required"=>false
                            ,"description"=>__("Customer's name", "ws")
                            ,"type"=>"text"
                            ,"amount"=>0
                            ,"fieldset"=>-1
                            ,"options"=>""
                            ,"class"=>""
                            ,"required"=>true
                        ),array( 
                          "name"=>"vads_cust_address"
                          ,"label"=>__("Address", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>false
                          ,"required"=>false
                          ,"order"=>5
                          ,"description"=>__("Customer's address", "ws")
                          ,"type"=>"text"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>false
                        )
                        ,array( 
                          "name"=>"vads_ship_to_street"
                          ,"label"=>__("Shipping address", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>4
                          ,"description"=>__("Customer's address", "ws")
                          ,"type"=>"text"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>true
                        )
                        ,array( 
                          "name"=>"vads_ship_to_street2"
                          ,"label"=>__("Shipping address (rest)", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>true
                          ,"required"=>false
                          ,"order"=>5
                          ,"description"=>__("Customer's address", "ws")
                          ,"type"=>"text"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>false
                        )
                        ,array( 
                          "name"=>"vads_cust_city"
                          ,"label"=>__("city", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>false
                          ,"required"=>false
                          ,"order"=>6
                          ,"description"=>__("Customer's city", "ws")
                          ,"type"=>"text"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>true
                        )                   
                        ,array( 
                          "name"=>"vads_cust_zip"
                          ,"label"=>__("zip", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>false
                          ,"required"=>false
                          ,"order"=>7
                          ,"description"=>__("Customer's zip", "ws")
                          ,"type"=>"text"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>true
                        )
                        ,array(
                          "name"=>"vads_cust_country"
                          ,"label"=>__("country", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>false
                          ,"required"=>false
                          ,"order"=>8
                          ,"description"=>__("Customer's country", "ws")
                          ,"type"=>"countrieslist"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>true
                        )
                        ,array( 
                          "name"=>"vads_cust_cell_phone"
                          ,"label"=>__("cell phone", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>false
                          ,"required"=>false
                          ,"order"=>9
                          ,"description"=>__("Customer's cell phone", "ws")
                          ,"type"=>"numeric"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>false
                        )
                        ,array( 
                          "name"=>"vads_cust_phone"
                          ,"label"=>__("phone", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>false
                          ,"required"=>false
                          ,"order"=>10
                          ,"description"=>__("Customer's phone", "ws")
                          ,"type"=>"numeric"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>false
                        )
                        ,array( 
                          "name"=>"vads_cust_email"
                          ,"label"=>__("email", "ws")
                          ,"value" => ""
                          ,"function" =>false
                          ,"hide"=>false
                          ,"required"=>false
                          ,"order"=>11
                          ,"description"=>__("Customer's email", "ws")
                          ,"type"=>"email"
                          ,"amount"=>0
                          ,"fieldset"=>-1
                          ,"options"=>""
                          ,"class"=>""
                          ,"required"=>true
                        )
              )
            )
            ,"none"=> array(
                  "return_url" => ""
                  ,"formals_configs"=> array()
                  ,"additionals_configs" => array()
                  ,"customer_infos" => array()
            )
          );
    }
}
?>