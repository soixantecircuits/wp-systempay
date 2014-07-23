<?php
/**
 * Class WS
 * 
 * 
 */ 

class WS 
{
    protected $form_table_name;
    protected $mainPage_title;
    protected $mainPage_slug;
    protected $inputs_table_name;
    protected $configurations_table_name;
    protected $transactions_table_name;
    protected $resultPage_slug;
    protected $resultPage_title;
    protected $resultPage_id;
    protected $confirmationpage_slug;
    protected $confirmationpage_title;
    protected $confirmationpage_id;
    protected $resultServerPage_slug;
    protected $resultServerPage_title;
    protected $resultServerPage_id;
    protected $options_prefixe;
    protected $GET_key_confirmation_formid;
    protected $GET_key_confirmation_previouspage;
    protected $method_saveTransaction;
    protected $confirmation_form_id;
    protected $inline_js;
    protected $Gateways;
    protected $saved_inputs;
    protected $countryList;
    protected $Systempay;
    protected $SystempayResults;
    protected $systempay_results;
    protected $WSconfig_table_name;
    protected $generalconfig_table_name;



    public function __construct()
    {
        $this->setAttributes();
        $this->Systempay = new WSSystempay($this->options_prefixe);
        $this->set_saved_inputs();
        $this->set_countriesList();
        add_action('wp_footer', array(&$this, 'output_inline_js'), 25);
    }

    public function get_mainPage_title()
    {
        return $this->mainPage_title;
    }
    
    public function get_mainPage_slug()
    {
        return $this->mainPage_slug; 
    }
    
    public function get_resultPage_slug()
    {
        return $this->resultPage_slug;
    }
    
    public function get_resultPage_title()
    {
        return $this->resultPage_title;
    }
    
    public function get_resultServerPage_slug()
    {
        return $this->resultServerPage_slug;    
    }
    
    public function get_resultServerPage_title()
    {
        return $this->resultServerPage_title;
    }

    public function get_WSconfig_table_name()
    {
        return $this->WSconfig_table_name;
    }

    public function get_generalconfig_table_name()
    {
        return $this->generalconfig_table_name;
    }

    public function setResultServerPage_id($the_page_id)
    {
        $this->resultServerPage_id = $the_page_id;
    }
                
    public function setResultPage_id($the_page_id)
    {
        $this->resultPage_id = $the_page_id;
    }

    public function setConfirmationpage_id($the_page_id)
    {
        $this->confirmationpage_id = $the_page_id;
    }
        
    public function setMainPage_id($the_page_id)
    {
        $this->mainPage_id = $the_page_id;
    }
     
    public function add_admin_js()
    {
        add_action('admin_footer', array(&$this, 'output_inline_js'), 25);
    }

    private function setAttributes()
    {
        global $wpdb;
        $this->form_table_name           = $wpdb->prefix . "payform_forms";
        $this->inputs_table_name         = $wpdb->prefix . "payform_inputs";
        $this->configurations_table_name = $wpdb->prefix . "payform_configurations";
        $this->generalconfig_table_name  = $wpdb->prefix . "payform_generalconfig";
        $this->transactions_table_name   = $wpdb->prefix . "payform_transactions";
        $this->WSconfig_table_name       = $wpdb->prefix . "payform_wsconfig";
        $this->mainPage_slug             = "wordpress-sytempay";
        $this->mainPage_title            = "Wordpress Sytempay";
        $this->confirmationpage_slug     = "confirmation-page";
        $this->confirmationpage_title    = "Confirmation Page";
        $this->resultPage_slug           = "transaction-page-result";
        $this->resultPage_title          = "Transaction Page Result";
        $this->resultServerPage_slug     = "transaction-serve-page-result";
        $this->resultServerPage_title    = "Transaction Server Page Result";
        $this->options_prefixe           = "ws_option_";
        $this->GET_key_confirmation_formid = "ws_form_id";
        $this->GET_key_confirmation_previouspage = "ws_previouspage";
        $this->method_saveTransaction = "saveTransaction";
        $this->confirmation_form_id = "ws_confirmation_form";
        $this->inline_js = "";
    }

    public function set_saved_inputs()
    {
        if ($this->get_resultPage_url() != '') {
            $this->Gateways     = new WSGateways($this->get_resultPage_url(), $this->Systempay->CurrenciesManager->getCurrencies());
            $this->saved_inputs = $this->Gateways->get_gateways();
        } else {
            add_action('admin_notices',  array($this, '_error_set_saved'));
        }
    }

    public function _error_set_saved()
    {
        echo '<div class="updated"><p>WP-Systempay:<br/>'.__("Sorry we could not find the requiered page, try to reinstall the plugin or setup the pages in the option tab", "ws").'</p></div>';
    }
    
    private function set_countriesList()
    {
        $this->Countries   = new WSCountries();
        $this->countryList = $this->Countries->get_countries();
    }

    public function getSystempayEl(){
        return $this->Systempay;
    }

    public function getCountries(){
        return $this->countryList;   
    }

    //get the manually saved inputs
    public function getSavedInputs() 
    {
        return $this->saved_inputs;
    }

    //get the name of the form table in the SQL database
    public function get_form_table_name() 
    {
        return $this->form_table_name;
    }

    //get the name of the additionals inputs table in the SQL database
    public function get_inputs_table_name() 
    {
        return $this->inputs_table_name;
    }

    //get the name of the formals inputs table in the SQL database
    public function get_configurations_table_name() 
    {
        return $this->configurations_table_name;
    }

    public function get_transactions_table_name()
    {
        return $this->transactions_table_name;
    }
    public function get_confirmationpage_slug()
    {
        return $this->confirmationpage_slug;
    }

    public function get_transactionPage_slug()
    {
        return $this->transactionPage_slug;
    }

    public function get_confirmationpage_title() 
    {
        return $this->confirmationpage_title;
    }

    public function get_transactionPage_title() 
    {
        return $this->transactionPage_title;
    }

    public function get_options_prefixe() 
    {
        return $this->options_prefixe;
    }

    public function get_GET_key_confirmation_formid()
    {
        return $this->GET_key_confirmation_formid;
    }

    public function get_GET_key_confirmation_previouspage()
    {
        return $this->GET_key_confirmation_previouspage;
    }

    public function get_method_saveTransaction()
    {
        return $this->method_saveTransaction;
    }

    public function get_confirmation_form_id()
    {
        return $this->confirmation_form_id;
    }

    function add_inline_js( $code )
    {
        $this->inline_js .= "\n" . $code . "\n";
    }
    
    function output_inline_js()
    {
        if ($this->inline_js) {
            echo "<!-- WS Javascript -->\n <script type='text/javascript'>";
            echo $this->inline_js ;
            echo "</script>";
            $this->inline_js = '';
        }
    }

    public function curPageURL()
    {
        return get_permalink($post->ID);
    }

    /**
    *   get the url of the confirmation page for the wanted form
    *   TODO : need to cleanup that function
    */

    public function get_confirmationpage_url($form_id)
    {
        (int)$form_id;
        $confirmationpage = get_page_by_title($this->confirmationpage_title);
        if (!is_object($confirmationpage)) {
            $confirmationpage = get_page_by_post_name($this->resultPage_slug);
            if (!is_object($resultPage)) {
                $form_config = $this->getFormWSConfig($form_id);
                $confirmationpage = get_page($form_config->pages->confirm->id);
            }
        }
        $permalink = get_permalink($confirmationpage->ID);
        if (!empty($form_id)) {
            $previous_get_key = $this->get_GET_key_confirmation_previouspage();
            $previous_page = $_GET[$previous_get_key];
            /*ToFix*/
            $mobile = isset($_GET["mobile"]) ? $_GET["mobile"] : false;
            if (empty($previous_page)) {
                if ($mobile) {
                    $permalink.="?".$this->get_GET_key_confirmation_formid()."=".$form_id."&".$previous_get_key."=".$this->curPageURL()."&mobile=true";
                }
                else {
                    $permalink.="?".$this->get_GET_key_confirmation_formid()."=".$form_id."&".$previous_get_key."=".$this->curPageURL();    
                }
                if(array_key_exists('protocole',$_REQUEST)){
                    $permalink.="&protocole=".$_REQUEST['protocole'];
                }
            } else {
                if ($mobile) {
                    $permalink.="?".$this->get_GET_key_confirmation_formid()."=".$form_id."&".$previous_get_key."=".$previous_page."&mobile=true";
                } else {
                    $permalink.="?".$this->get_GET_key_confirmation_formid()."=".$form_id."&".$previous_get_key."=".$previous_page;    
                }
                if(array_key_exists('protocole',$_REQUEST)){
                    $permalink.="&protocole=".$_REQUEST['protocole'];
                }
            }
        }
        return $permalink;
    }


    public function confirmationpage_url()
    {
        echo $this->get_confirmationpage_url();
    } 

    //get the url of the result page 
    public function get_resultPage_url($form_id = NULL)
    {
        $resultPage = get_page_by_title($this->resultPage_title);
        if (!is_object($resultPage)) {
            $resultPage = get_page_by_post_name($this->resultPage_slug);
            if (!is_object($resultPage)) {
                $form_config = $this->getFormWSConfig($_REQUEST["WS_id"]);
                $resultPage = get_page($form_config->pages->return->id);
            }
        }
        if (is_object($resultPage)) {
            $permalink = get_permalink($resultPage->ID);
            return $permalink;
        } else {
            return __("No link", "ws");
        }
    }
    
    //get the url of the result page 
    public function get_resultServerPage_url($form_id = NULL)
    {
        $resultPage = get_page_by_title($this->resultServerPage_title);
        if (!is_object($resultPage)) {
            $resultPage = get_page_by_post_name($this->resultServerPage_slug);
            if (!is_object($resultPage)) {
                $form_config = $this->getFormWSConfig($_REQUEST["WS_id"]);
                $resultPage = get_page($form_config->pages->analysis->id);
            }
        }
        
        if(is_object($resultPage)){
            $permalink = get_permalink($resultPage->ID);
            return $permalink;
        } else {
            return __("No link", "ws");
        }
    }

    public function getFormWSConfig($form_id)
    {
        global $wpdb;
        (int)($form_id);
        $WSconfig_data = $wpdb->get_var("SELECT WSconfig_json FROM ".$this->get_WSconfig_table_name()." WHERE WSconfig_form_id = ".$form_id);
        return json_decode($WSconfig_data);
    }


    public function resultPage_url()
    {
        echo $this->get_resultPage_url();
    } 
    
    public function resultServerPage_url()
    {
        echo $this->get_resultServerPage_url();
    } 
}
?>