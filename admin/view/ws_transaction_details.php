<div class="ws_warp">
	<div class="page_title"><h1><?php _e("Transactions","ws"); ?></h1></div>
		<!--
			<th><?php _e("Detail order"); ?></th>
			<th><?php _e("Coordinated"); ?></th>
			<th><?php _e("Informations"); ?></th>
		-->

	<div class="transaction_detail_box">
		<h2><?php _e("Transaction Identification","ws"); ?></h2>
		<p><strong><?php _e("Order Id"); ?> :</strong> <?php echo $transaction_data->transaction_order_id;?></p>
		<p><strong><?php _e("Platform"); ?> :</strong> <?php echo $transaction_data->transaction_plateforme;?></p>
		<p><strong><?php _e("Certificate"); ?> :</strong> <?php echo $transaction_data->transaction_command_certificat;?></p>
		
	</div>
	<div class="transaction_detail_box">
		<h2><?php _e("Transaction Statut","ws"); ?></h2>
		<p><strong><?php _e("Statut"); ?> :</strong> <?php echo $transaction_data->transaction_command_statut;?></p>
		<p><strong><?php _e("Statut details"); ?> :</strong> <?php echo $transaction_data->transaction_command_extrastatut;?></p>
		<p><strong><?php _e("Authentification"); ?> :</strong> <?php echo $transaction_data->transaction_command_auth;?></p>
		<p><strong><?php _e("3D Secure"); ?> :</strong> <?php echo $transaction_data->transaction_command_3dsecure;?></p>
	</div>
	<div class="transaction_detail_box">
		<h2><?php _e("Transaction Information","ws"); ?></h2>
		<p><strong><?php _e("Date"); ?> :</strong> <?php echo $transaction_data->transaction_command_date;?></p>
		<p><strong><?php _e("Amount"); ?> :</strong> <?php echo $transaction_data->transaction_command_amount;?></p>
		<p><strong><?php _e("Currency"); ?> :</strong> <?php echo $transaction_data->transaction_command_currency;?></p>
		<p><strong><?php _e("Info"); ?> :</strong> <?php echo $transaction_data->transaction_command_info;?></p>
	</div>
	<div class="transaction_detail_box">
		<h2><?php _e("Customer Information","ws"); ?></h2>
		<p><strong><?php _e("Customer Name"); ?> :</strong> <?php echo $transaction_data->transaction_customer_name;?></p>
		<p><strong><?php _e("Customer Card Number"); ?> :</strong> <?php echo $transaction_data->transaction_command_cardnumber;?></p>
		<p><strong><?php _e("Customer Address"); ?> :</strong> <?php echo $transaction_data->transaction_customer_address;?></p>
		<p><strong><?php _e("Customer Country"); ?> :</strong> <?php echo $transaction_data->transaction_customer_country;?></p>
		<p><strong><?php _e("Customer Phone"); ?> :</strong> <?php echo $transaction_data->transaction_customer_phone;?></p>
		<p><strong><?php _e("Customer Cell phone"); ?> :</strong> <?php echo $transaction_data->transaction_customer_cellphone;?></p>
		<p><strong><?php _e("Customer Email"); ?> :</strong> <?php echo $transaction_data->transaction_customer_email;?></p>		
	</div>
	<div class="transaction_detail_box">
		<h2><?php _e("Additional Information","ws"); ?></h2>
		<?php $other_infos=json_decode($transaction_data->transaction_otherinfos_json);
			(empty($other_infos))?_e("Empty","ws"):"";
			foreach ($other_infos as $info) :?>
				<p><strong><?php echo $info["label"]; ?> :</strong> <?php echo $info["value"]; ?></p>
		<?php endforeach;?>
	</div>
</div>