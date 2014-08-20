<?php
/**  WSSystempayTransactionUpdater extends WSSystempayAnalyzer
*
* @return void
* 
*/

class WSSystempayTransactionUpdater extends WSSystempayAnalyzer
{

    public $message;

    public function __construct($systempay)
    {
        parent::__construct($systempay);
        $this->set_results_array();
        $this->message = "";
    }

    /** updateTransaction update the transaction
    * 
    * 
    * @return void
    * 
    */
    public function updateTransaction()
    {
        if (WP_DEBUG === true) {
            error_log(print_r($_POST, true));
        }

        $order_id           = $this->get_or_post("vads_order_id");
        $payment_certificat = $this->get_or_post("vads_payment_certificate");
        $cardnumber         = $this->get_or_post("vads_card_number");

        if (!empty($order_id)) :
            global $wpdb;

            $where = array(
              "transaction_order_id" => $order_id
            );  

            $where_format = array(
              "%s"
            );

            $form_data = array(
              "transaction_command_statut" => mysqli::escape_string($this->get_vads_result()),
              "transaction_command_extrastatut" => mysqli::escape_string($this->get_vads_extra_results()),
              "transaction_command_auth" => mysqli::escape_string($this->get_vads_auth()),
              "transaction_command_3dsecure" => mysqli::escape_string($this->get_vads_warranty_result()),
              "transaction_command_certificat" => mysqli::escape_string($payment_certificat),
              "transaction_command_cardnumber" => mysqli::escape_string($cardnumber)
            );

            $data_formats = array(
              "%s",
              "%s",
              "%s",
              "%s",
              "%s",
              "%s"
            );

            $update = $wpdb->update($this->getSystempay()->get_transactions_table_name(), $form_data, $where, $data_formats, $where_format);

            /**
            * if we correctly update the transaction we return;
            */
            if ($update) :
                $this->message = __("Everything went well", "ws");
            else :
                if (WP_DEBUG === true) {
                    global $wpdb;
                    error_log($wpdb->last_error());
                }
            endif;

            $to_email = $this->get_cust_email($order_id);

            if (!empty($to_email)) :
                $this->message = $this->sendMail($order_id, $to_email);
            else :
                $this->message = __("Email is not valid, or empty", "ws");
                if (WP_DEBUG === true) {
                    error_log($this->message);
                }
            endif;
        else:
            $this->message = __("No order id", "ws");
            if (WP_DEBUG === true) {
                error_log($this->message);
            }
        endif;

        return $this->message;
    }


    public function sendMail($order_id, $to_email)
    {
        $form_id          = $this->get_form_id($order_id);      
        $emailConfig      = $this->getFormWSConfig($form_id)->email;
        if ($this->get_or_post("vads_result") == "00") {
            $content = $this->get_success_mail();
            if ($emailConfig->setup->title_success != "") {
                $subject = __($emailConfig->setup->title_success, "ws");
            } else {
                $subject = __("Your payement went well", "ws");
            }
        } else {
            $content = $this->get_error_mail();
            if ($emailConfig->setup->title_error != "") {
                $subject = __($emailConfig->setup->title_error, "ws");
            } else {
                $subject = __("An error occured while making the transaction with your Bank account", "ws");
            }
        }
        return $this->useSwiftMailer($order_id, $to_email, $subject, $content);
    }

    public function get_thanks_mail()
    {
        $themes_email_template = "/plugins/wp-systempay/templates/emails_templates";
        ob_start(); 
        if (file_exists(get_stylesheet_directory().$themes_email_template."/thanks_email.php")) {
            include_once get_stylesheet_directory().$themes_email_template."/thanks_email.php";
        } else {
            include_once dirname(__FILE__)."/../../templates/emails_templates/thanks_email.php";    
        }  
        $mail = ob_get_clean(); 
        return $mail;
    }

    public function get_success_mail()
    {
        $themes_email_template = "/plugins/wp-systempay/templates/emails_templates";
        ob_start(); 
        if (file_exists(get_stylesheet_directory().$themes_email_template."/success_email.php")) {
            include_once get_stylesheet_directory().$themes_email_template."/success_email.php";
        } else {
            include_once dirname(__FILE__)."/../../templates/emails_templates/success_email.php";    
        }  
        $mail = ob_get_clean(); 
        return $mail;
    }

    public function get_error_mail()
    {
        $themes_email_template = "/plugins/wp-systempay/templates/emails_templates";
        ob_start(); 
        $order_id = $this->get_or_post("vads_order_id");

        if (file_exists(get_stylesheet_directory().$themes_email_template."/error_email.php")) {
            include_once get_stylesheet_directory().$themes_email_template."/error_email.php";
        } else {
            include_once dirname(__FILE__)."/../../templates/emails_templates/error_email.php";
        }
        $mail = ob_get_clean(); 
        return $mail;
    }

}
?>