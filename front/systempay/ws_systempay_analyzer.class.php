<?php
/**
 *
 */

/*---------------------------------------------------------------
-----------------------------SWIFT_MAILER--------------------------*/
require_once WPSYSTEMPAY_PATH."inc/swift_mailer/lib/swift_required.php";

class WSSystempayAnalyzer extends WSTools
{
  public $message;
  protected $SystempayResults;
  protected $systempay_results_array;

  public function __construct($systempay)
  {
    parent::__construct($systempay);
    $this->set_results_array();
    $this->message = "";
  }

  public function set_results_array()
  {
    $this->SystempayResults        = new WSSystempayResults();
    $this->systempay_results_array = $this->SystempayResults->get_results();
  }


  public function get_or_post($key)
  {
    if (isset($_GET[$key])) {
      return $_GET[$key];
    } else if (isset($_POST["vads_result"])) {
      return $_POST[$key];
    }
    return false;
  }

  public function get_vads_result()
  {
    $vads_result = $this->get_or_post("vads_result");
    if (!empty($vads_result)) {
      $vads_results_array = $this->systempay_results_array["results"];
      return $vads_results_array[$vads_result];
    }
    return false;
  }

  public function get_vads_extra_results()
  {
    $result       = $this->get_or_post("vads_result");
    $extra_result = $this->get_or_post("vads_extra_result");
    if (!empty($extra_result)&&!empty($result)) :
      switch($result):
        case "30" :
          $extra_results_array = $this->systempay_results_array["extra_results_30"];
          return $extra_results_array[$extra_result];
          break;
        default :
          $extra_results_array = $this->systempay_results_array["extra_results_default"];
          return $extra_results_array[$extra_result];
          break;
      endswitch;
    endif;
    return false;
  }

  public function get_vads_auth()
  {
    $vads_auth = $this->get_or_post("vads_auth_result");
    if (!empty($vads_auth)) {
      $vads_auths_array = $this->systempay_results_array["auth_results"];
      return $vads_auths_array[$vads_auth];
    }
    return false;
  }

  public function get_vads_warranty_result()
  {
    $vads_warranty_result = $this->get_or_post("vads_warranty_result");
    if (!empty($vads_warranty_result)) {
      $warranty_results_array = $this->systempay_results_array["warranty_results"];
      return $warranty_results_array[$vads_warranty_result];
    }
    return false;
  }

  public function get_template_return()
  {
    $themes_email_template = "/plugins/wp-systempay/templates/return_templates";
    ob_start();
    if (file_exists(get_stylesheet_directory().$themes_email_template."/return.php")) {
      include_once get_stylesheet_directory().$themes_email_template."/return.php";
    } else {
      include_once dirname(__FILE__)."/../../templates/return_templates/return.php";
    }
    $content = ob_get_clean();
    return $content;
  }

  public function showResult()
  {
    $form_id       = $this->get_form_id($this->get_or_post("vads_order_id"));
    $messageConfig = $this->getFormWSConfig($form_id)->message;


    $this->message = $this->get_vads_result();
    $reason = $this->get_vads_extra_results();
    $template = ($messageConfig->template->use) ? $this->get_template_return() : "";

    return "<p>".$this->message."<br/>".$reason."</p>".$template;
  }

  public function get_cust_email($order_id)
  {
    global $wpdb;
    $mail = $wpdb->get_row("SELECT transaction_customer_email FROM ".$this->getSystempay()->get_transactions_table_name()." WHERE transaction_order_id = '".$order_id."'", "ARRAY_N");
    return $mail[0];
  }

  public function get_form_id($order_id)
  {
    global $wpdb;
    $formid = $wpdb->get_var("SELECT transaction_form_id FROM ".$this->getSystempay()->get_transactions_table_name()." WHERE transaction_order_id = '".$order_id."'");
    return $formid;
  }


  public function get_amount($order_id)
  {
    global $wpdb;
    $amount     = $wpdb->get_row("SELECT transaction_command_currency, transaction_command_amount FROM ".$this->getSystempay()->get_transactions_table_name()." WHERE transaction_order_id = '".$order_id."'", "ARRAY_N");
    $the_amount = array( "amount"=>$amount[1],"currency"=>$amount[0]);
    return $the_amount;
  }

  public function get_date($order_id)
  {
    global $wpdb;
    $the_date = $wpdb->get_row("SELECT transaction_command_date FROM ".$this->getSystempay()->get_transactions_table_name()." WHERE transaction_order_id = '".$order_id."'", "ARRAY_N");
    return $the_date[0];
  }

  public function useSwiftMailer($order_id, $to_email, $subject, $content)
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
        if ($emailConfig->smtp->tls) {
          $transport = Swift_SmtpTransport::newInstance($smtp, $port, 'tls');
        } else {
          $transport = Swift_SmtpTransport::newInstance($smtp, $port);
        }
        $transport->setUsername($SMTPEmail);
        $transport->setPassword($SMTPPassword);
        break;
      case "sendmail":
        if($emailConfig->sendmail->path != ""){
          $transport = Swift_SendmailTransport::newInstance($emailConfig->sendmail->path);
        } else {
          $transport = Swift_SendmailTransport::newInstance("/usr/sbin/sendmail -bs");
        }
        break;
      default :
        /**
         * We use the default Unix system
         *
         */
        $transport = Swift_SendmailTransport::newInstance("/usr/sbin/sendmail -bs");
        break;
    endswitch;

    $Mailer = Swift_Mailer::newInstance($transport);
    //create the email
    $Email = Swift_Message::newInstance();
    $Email->setSubject($subject);

    if($emailConfig->setup->active->tax) {
      $Email->setTo($to_email);
    }

    if($emailConfig->setup->active->admin){
      $bccEmail = ($emailConfig->setup->email_admin != "") ? $emailConfig->setup->email_admin : get_bloginfo("admin_email");
      $Email->setBcc($bccEmail);
    }


    $email_admin = ($emailConfig->setup->email != "") ? $emailConfig->setup->email : get_bloginfo("admin_email");
    $name = ($emailConfig->setup->email != "") ? $emailConfig->setup->name : get_bloginfo("name");
    $Email->setFrom(array($email_admin => $name));
    $Email->setBody($content, 'text/html');
    //send it
    if($emailConfig->setup->active->tax || $emailConfig->setup->active->admin ) {
      if ($Mailer->send($Email, $failures) != 0) {
        if($emailConfig->setup->active->tax){
          if ($emailConfig->setup->msg_success != "") {
            return __($emailConfig->setup->msg_success, "ws");
          } else {
            return __("An email has been sent, you will get it soon. Thank you very much.", "ws");
          }
        } else {
          return __("Thank you very much.", "ws");
        }
      } else {
        $error = print_r($failures, true);
        if ($emailConfig->setup->msg_error != "") {
          return __($emailConfig->setup->msg_error, "ws")." ".$error;
        } else {
          return __("An error occured while sending the confirmation email.", "ws")." ".$error;
        }
      }
    }
  }
}