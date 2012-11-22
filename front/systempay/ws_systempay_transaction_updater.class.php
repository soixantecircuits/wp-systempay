<?php
/**  WSSystempayTransactionUpdater extends WSSystempayAnalyzer
*
* @return void
* 
*/

class WSSystempayTransactionUpdater extends WSSystempayAnalyzer 
{

    public $message;

    /** updateTransaction update the transaction
    * 
    * 
    * @return void
    * 
    */
    public function updateTransaction()
    {
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
                $this->message = __("Everything is fine", "ws");
                return true;
            endif;

            $to_email = $this->get_cust_email($order_id);
            if (!empty($to_email)) :
                $this->message = $this->sendMail($order_id, $to_email);
            else :
                $this->message = __("Email invalide/vide", "ws");
            endif;
        else:
            $this->message = __("Numéro de commande vide", "ws");
        endif;

        return $this->message;
    }


    public function sendMail($order_id,$to_email)
    {
        if ($this->get_or_post("vads_result") == "00") {
            $content = $this->get_success_mail();
            $subject = __("Votre transaction sur Systempay c'est bien déroulée", "ws");
        } else {
            $content = $this->get_error_mail();
            $subject = __("Une erreur c'est produite lors de votre transaction sur systempay", "ws");
        }
        return $this->useSwiftMailer($order_id, $to_email, $subject, $content);
    }

    private function useSwiftMailer($order_id, $to_email, $subject, $content)
    {
        //use the swiftMailer library to send the mail.
        $form_id     = $this->get_form_id($order_id);
        $emailConfig = $this->getFormWSConfig($form_id)->email;
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
        $Email->setFrom(array($SMTPEmail => $FromName));
        $Email->setBody($content, 'text/html');
        //send it
        if ($Mailer->send($Email) == 1) {
            return __("Un e-mail vient de vous être envoyé, merci beaucoup et à bientôt.", "ws");
        } else {
            return __("Erreur lors de l'envoi de l'e-mail.", "ws");
        }
    }


    public function get_success_mail()
    {
        ob_start(); 
        include_once dirname(__FILE__)."/../../templates/emails_templates/success_email.php";
        $mail = ob_get_clean(); 
        return $mail;
    }

    public function get_error_mail()
    {
        ob_start(); 
        $order_id = $this->get_or_post("vads_order_id");
        include_once dirname(__FILE__)."/../../templates/emails_templates/error_email.php";
        $mail = ob_get_clean(); 
        return $mail;
    }

}
?>