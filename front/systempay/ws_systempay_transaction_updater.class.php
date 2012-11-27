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

        $order_id = $this->get_or_post("vads_order_id");
        $payment_certificat = $this->get_or_post("vads_payment_certificate");
        $cardnumber = $this->get_or_post("vads_card_number");

        if (!empty($order_id)) :
            global $wpdb;

            $where = array(
              "transaction_order_id" => $order_id
            );  

            $where_format = array(
              "%s"
            );

            $form_data = array(
              "transaction_command_statut" => mysql_real_escape_string($this->get_vads_result())
              ,"transaction_command_extrastatut" => mysql_real_escape_string($this->get_vads_extra_results())
              ,"transaction_command_auth" => mysql_real_escape_string($this->get_vads_auth())
              ,"transaction_command_3dsecure" => mysql_real_escape_string($this->get_vads_warranty_result())
              ,"transaction_command_certificat" => mysql_real_escape_string($payment_certificat)
              ,"transaction_command_cardnumber" => mysql_real_escape_string($cardnumber)
            );

            $data_formats = array(
              "%s"
              ,"%s"
              ,"%s"
              ,"%s"
              ,"%s"
              ,"%s"
            );

            $update = $wpdb->update($this->transactions_table_name, $form_data, $where, $data_formats, $where_format);

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

    private function useSwiftMailer($order_id, $to_email, $subject, $content)
    {
        //use the swiftMailer library to send the mail.
        $form_id          = $this->get_form_id($order_id);
        $emailConfig      = $this->getFormWSConfig($form_id)->email;
        switch ($emailConfig->transport) :
        case "smtp" : 
            $SMTPEmail    = $emailConfig->smtp->username;
            $SMTPPassword = $emailConfig->smtp->password;
            $FromName     = get_bloginfo('name'); //displayed name
            //create the transport
            $smtp         = $emailConfig->smtp->smtp;
            $port         = $emailConfig->smtp->port;
            if ($emailConfig->smtp->ssl) {
                $transport = Swift_SmtpTransport::newInstance($smtp, $port, 'ssl');
            } else {
                $transport = Swift_SmtpTransport::newInstance($smtp, $port);
            }
            $transport->setUsername($SMTPEmail);
            $transport->setPassword($SMTPPassword);
            break;
        case "sendmail":
            $transport = Swift_SendmailTransport::newInstance($emailConfig->sendmail->path);
            break;
        default :
            $transport=null;
            break;
        endswitch;

        $Mailer = Swift_Mailer::newInstance($transport);
        //create the email
        $Email = Swift_Message::newInstance();
        $Email->setSubject($subject);
        $Email->setTo($to_email);
        
        ($emailConfig->setup->email_admin) ? $bccEmail = $emailConfig->setup->email_admin : $email_admin = get_bloginfo("admin_email");
        $Email->setBcc($bccEmail);

        ($emailConfig->setup->email != "") ? $email_admin = $emailConfig->setup->email : $email_admin = get_bloginfo("admin_email");
        ($emailConfig->setup->email != "") ? $name = $emailConfig->setup->name : $name = get_bloginfo("name");
        $Email->setFrom(array($email_admin => $name));

        $Email->setBody($content, 'text/html');
        //send it
        if ($Mailer->send($Email) == 1) {
            if ($emailConfig->setup->msg_success != "") {
                return __($emailConfig->setup->msg_success, "ws");
            } else {
                return __("An email has been sent, you will get it soon. Thank you very much.", "ws");    
            }
        } else {
            if ($emailConfig->setup->msg_error != "") {
                return __($emailConfig->setup->msg_error, "ws");
            } else {
                return __("An error occured while sending the email.", "ws");
            }
        }
    }


    public function get_success_mail()
    {
        ob_start(); 

        if (file_exists(get_stylesheet_directory()."/wp-systempay/templates/emails_templates/success_email.php")) {
            include_once get_stylesheet_directory()."/wp-systempay/templates/emails_templates/success_email.php";
        } else {
            include_once dirname(__FILE__)."/../../templates/emails_templates/success_email.php";    
        }
        
        $mail = ob_get_clean(); 
        return $mail;
    }

    public function get_error_mail()
    {
        ob_start(); 
        $order_id = $this->get_or_post("vads_order_id");

        if (file_exists(get_stylesheet_directory()."/wp-systempay/templates/emails_templates/error_email.php")) {
            include_once get_stylesheet_directory()."/wp-systempay/templates/emails_templates/error_email.php";
        } else {
            include_once dirname(__FILE__)."/../../templates/emails_templates/error_email.php";
        }
    
        $mail = ob_get_clean(); 
        return $mail;
    }

}
?>