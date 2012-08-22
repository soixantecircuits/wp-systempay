<h3><?php _e("Emails","ws"); ?></h3>
 	<div class="email_choice">
		<label><?php _e("Email Transport used","ws"); ?> : </label>
		<?php $transports=array("smtp"=>"SMTP","sendmail"=>"Send Mail"); 
			foreach ($transports as $key => $value) { 
				$selected=($key==$generalConfig->email->transport)?"checked":" ";
		?>
				<input type="radio" name="generalconfig[email][transport]" value="<?php echo $key; ?>" <?php echo $selected; ?> /><?php _e($value,"ws"); ?>
		<?php }
		?>
	</div>
<!-- SMTP -->

	<div class="smtp">
		<h4><?php _e("SMTP","ws"); ?></h4>
		<label for="smtp_SMTP"><?php _e("SMTP adress","ws"); ?></label>
		<input type="text" id="smtp_smtp" name="generalconfig[email][smtp][smtp]" value="<?php echo $generalConfig->email->smtp->smtp; ?>" /><br/>
		<label for="smtp_port"><?php _e("SMTP Port","ws"); ?></label>
		<input type="text" id="smtp_smtp" name="generalconfig[email][smtp][port]" value="<?php echo $generalConfig->email->smtp->port; ?>" /><br/>
		<label for="smtp_ssl"><?php _e("SSL","ws"); ?></label>
		<?php 	$smtp_ssl=(bool)($generalConfig->email->smtp->ssl); 
				$checked= ($smtp_ssl)?"checked":""; ?>
		<input type="checkbox" id="smtp_ssl" name="generalconfig[email][smtp][ssl]" value="1" <?php echo $checked; ?>/><br/>
		<label for="smtp_username"><?php _e("Username","ws"); ?></label>
		<input type="text" id="smtp_username" name="generalconfig[email][smtp][username]" value="<?php echo $generalConfig->email->smtp->username; ?>" /><br/>
		<label for="smtp_password"><?php _e("Password","ws"); ?></label>
		<input type="password" id="smtp_password" name="generalconfig[email][smtp][password]" value="<?php echo $generalConfig->email->smtp->password; ?>" /><br/>
		
	</div>
<!-- SendMail -->
	<div class="sendmail">
		<h4><?php _e("SendMail","ws"); ?></h4>
		<label for="smtp_SMTP"><?php _e("SendMail Path","ws"); ?></label>
		<input type="text" id="smtp_smtp" name="generalconfig[email][sendmail][path]" value="<?php echo $generalConfig->email->sendmail->path; ?>" /><br/>
	</div>