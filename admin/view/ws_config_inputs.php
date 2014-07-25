<?php
$generalConfig = $this->get_Manager()->getGeneralConfig();
$form_id = $_GET["WS_id"];
if (!empty($form_id)) {
    $generalConfig = $this->_WSTools->mergeWSConfigs($form_id);
}
?>
<div class="tabbable tabs-left" id="vtabs">
    <ul class="nav nav-tabs">
        <li><a href="#vtabs-1"><?php _e("Mail setup", "ws");?></a></li>
        <li><a href="#vtabs-2"><?php _e("Billing format", "ws");?></a></li>
        <li><a href="#vtabs-3"><?php _e("Mail template", "ws");?></a></li>
        <li><a href="#vtabs-4"><?php _e("Page setup", "ws");?></a></li>
    </ul>
<div id="vtabs-1">
    <div class="email_choice">
        <h4><?php _e("Set your prefered method to send email", "ws")?></h4>
        <p><?php _e("Email sender information:", "ws"); ?></p>
        <div class="input-prepend">
            <span class="add-on"><?php _e("From / name", "ws"); ?></span>
            <input type="text" class="span2" placeholder="email server" id="smtp_smtp" name="generalconfig[email][setup][from]" value="<?php echo $generalConfig->email->setup->from; ?>" />
        </div>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Email", "ws"); ?></span>
            <input type="email" class="span2" placeholder="port" id="smtp_smtp" name="generalconfig[email][setup][email]" value="<?php echo $generalConfig->email->setup->email; ?>" />
        </div>
        <p><?php _e("Email Transport used:", "ws"); ?></p>
        <?php 
        $transports = array("smtp"=>"SMTP", "sendmail"=>"Send Mail"); 
        foreach ($transports as $key => $value) {
            $selected = ($key == $generalConfig->email->transport) ? "checked" : " ";
            ?>
            <label class="radio">
                <input type="radio" name="generalconfig[email][transport]" value="<?php echo $key; ?>" <?php echo $selected; ?> /><?php _e($value, "ws"); ?>
            </label>
            <?php 
        }
        ?>
      </div>
    <!-- SMTP -->
      <div class="smtp form-inline">
        <h4><?php _e("SMTP", "ws"); ?></h4>

        <div class="input-prepend">
            <span class="add-on"><?php _e("Address", "ws"); ?></span>
            <input type="text" class="span2" placeholder="email server" id="smtp_smtp" name="generalconfig[email][smtp][smtp]" value="<?php echo $generalConfig->email->smtp->smtp; ?>" />
        </div>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Port", "ws"); ?></span>
            <input type="text" class="span2" placeholder="port" id="smtp_smtp" name="generalconfig[email][smtp][port]" value="<?php echo $generalConfig->email->smtp->port; ?>" />
        </div>
            <div class="input-prepend input-append">
                <span class="add-on"><?php _e("TLS", "ws"); ?></span>
                <span class="add-on"><input type="checkbox" id="smtp_tls" name="generalconfig[email][smtp][tls]" value="1" <?php  checked($generalConfig->email->smtp->tls,true); ?>/>
            </span>
            </div>
        <br/><br/>
        <div class="input-prepend">
            <span class="add-on">@</span>
            <input class="span2" placeholder="mail@domain.com" type="text" id="smtp_username" name="generalconfig[email][smtp][username]" value="<?php echo $generalConfig->email->smtp->username; ?>" />
        </div>    
        <div class="input-prepend">
            <span class="add-on">password</span>
            <input class="span2" placeholder="password" type="password" id="smtp_password" name="generalconfig[email][smtp][password]" value="<?php echo $generalConfig->email->smtp->password; ?>" />
        </div>
      </div>
    <!-- SendMail -->
      <div class="sendmail">
        <h4><?php _e("SendMail", "ws"); ?></h4>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Path", "ws"); ?></span>
            <input placeholder="/usr/sbin/sendmail" type="text" id="smtp_smtp" name="generalconfig[email][sendmail][path]" value="<?php echo $generalConfig->email->sendmail->path; ?>" />
        </div>
      </div>
      <br/><br/>
  </div>
  <div id="vtabs-2">
  <!-- Format order -->
      <div class="sendmail">
        <h4><?php _e("Custom order format", "ws"); ?></h4>
        <div class="input-prepend input-append">
            <span class="add-on"><?php _e("Name", "ws"); ?></span>
            <input placeholder = "<?php _e("Simple name", "ws");?>" type="text" id="order_format_name" name="generalconfig[order_format][name]" value="<?php echo $generalConfig->order_format->name; ?>" />
            <span class="add-on"><?php _e("Format : time-name-trans_id", "ws"); ?></span>
        </div>
      </div>
    </div>  
    <div id="vtabs-3">
      <div class="sendmail">
        <h4><?php _e("Custom settings", "ws"); ?></h4>
        <label class="checkbox inline">
          <input type="checkbox" name="generalconfig[email][setup][active][thanks]" id="inlineCheckbox1" value="1" <?php checked($generalConfig->email->setup->active->thanks,true);?>> <?php _e("Send mail for thanking", "ws");?>
        </label>
        <label class="checkbox inline">
          <input type="checkbox" name="generalconfig[email][setup][active][tax]" id="inlineCheckbox2" value="1" <?php  checked($generalConfig->email->setup->active->tax,true);?>> <?php _e("Send mail for tax receipt", "ws");?>
        </label>
        <label class="checkbox inline">
          <input type="checkbox" name="generalconfig[email][setup][active][admin]" id="inlineCheckbox3" value="1" <?php  checked($generalConfig->email->setup->active->admin,true);?>> <?php _e("Send mail to admin", "ws");?>
        </label>
        <br/><br/>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Email success Title", "ws"); ?></span>
            <input placeholder = "<?php _e("Title of successful email", "ws");?>" type="text" id="email_success_title" name="generalconfig[email][setup][title_success]" value="<?php echo $generalConfig->email->setup->title_success; ?>" />
        </div><div class="clear-fix"></div><br/>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Email error Title", "ws"); ?></span>
            <input placeholder = "<?php _e("Title of error email", "ws");?>" type="text" id="email_error_title" name="generalconfig[email][setup][title_error]" value="<?php echo $generalConfig->email->setup->title_error; ?>" />
        </div><div class="clear-fix"></div><br/>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Message success return", "ws"); ?></span>
            <input placeholder = "<?php _e("Message for successful payment", "ws");?>" type="text" id="msg_success_title" name="generalconfig[email][setup][msg_success]" value="<?php echo $generalConfig->email->setup->msg_success; ?>" />
        </div><div class="clear-fix"></div><br/>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Message error return", "ws"); ?></span>
            <input placeholder = "<?php _e("Message for error during payment", "ws");?>" type="text" id="msg_error_title" name="generalconfig[email][setup][msg_error]" value="<?php echo $generalConfig->email->setup->msg_error; ?>" />
        </div><div class="clear-fix"></div><br/>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Email admin", "ws"); ?></span>
            <input placeholder = "<?php _e("Email of this payment account manager", "ws");?>" type="text" id="email_admin" name="generalconfig[email][setup][email_admin]" value="<?php echo $generalConfig->email->setup->email_admin; ?>" />
        </div><div class="clear-fix"></div><br/>
      </div>
  </div>
  <div id="vtabs-4">
    <div class="sendmail">
        <h4><?php _e("Custom pages", "ws"); ?></h4>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Confirmation page", "ws"); ?></span>
            <?php 
            $page_name = "confirm";
            $id = $generalConfig->pages->$page_name->id;
            print_page_list($page_name, $id);?>
            <?php $permalink = get_permalink( $id ); ?>
            <a class="btn btn-info" title="<?php echo get_the_title($id);?>" href="<?php echo $permalink;?>" target="_blank"><?php _e("Voir la page", "ws");?></a>
        </div><div class="clear-fix"></div><br/>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Return page", "ws"); ?></span>
            <?php
            $page_name = "return";
            $id = $generalConfig->pages->$page_name->id;
            print_page_list($page_name, $id);?>
            <?php $permalink = get_permalink( $id ); ?>
            <a class="btn btn-info" title="<?php echo get_the_title($id);?>" href="<?php echo $permalink;?>" target="_blank"><?php _e("Voir la page", "ws");?></a>
        </div><div class="clear-fix"></div><br/>
        <div class="input-prepend">
            <span class="add-on"><?php _e("Analysis page", "ws"); ?></span>
            <?php
            $page_name = "analysis";
            $id = $generalConfig->pages->$page_name->id;
            print_page_list($page_name, $generalConfig->pages->$page_name->id);?>
            <?php $permalink = get_permalink( $id ); ?>
            <a class="btn btn-info" title="<?php echo get_the_title($id);?>" href="<?php echo $permalink;?>" target="_blank"><?php _e("Voir la page", "ws");?></a>
        </div>
    </div>
  </div>
</div>