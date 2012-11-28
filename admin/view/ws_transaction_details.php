<div class="ws_warp">
	<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><div class="page_title"><h1><?php _e("Details of the transaction", "ws"); ?></h1></div>
	<div class="cb"></div>
	<h2><?php _e("Transaction Identification", "ws"); ?></h2>
	<table class="wp-list-table widefat fixed pages">
		<thead>
			<th><?php _e("Order Id"); ?></th>
			<th><?php _e("Platform"); ?></th>
			<th><?php _e("Certificate"); ?></th>
		</thead>
		<tbody>
			<td><p> <?php echo $transaction_data->transaction_order_id;?></p></td>
			<td><p> <?php echo $transaction_data->transaction_plateforme;?></p></td>
			<td><p> <?php echo $transaction_data->transaction_command_certificat;?></p></td>
		</tbody>
	</table>
	<h2><?php _e("Transaction Statut", "ws"); ?></h2>
	<table class="wp-list-table widefat fixed pages">
		<thead>
			<th><?php _e("Statut"); ?></th>
			<th><?php _e("Statut details"); ?></th>
			<th><?php _e("Authentification"); ?></th>
			<th><?php _e("3D Secure"); ?></th>
		</thead>
		<tbody>
			<td><p><?php echo $transaction_data->transaction_command_statut;?></p></td>
			<td><p><?php echo $transaction_data->transaction_command_extrastatut;?></p></td>
			<td><p><?php echo $transaction_data->transaction_command_auth;?></p></td>
			<td><p><?php echo $transaction_data->transaction_command_3dsecure;?></p></td>
		</tbody>	
	</table>
	<h2><?php _e("Transaction Information", "ws"); ?></h2>
	<table class="wp-list-table widefat fixed pages">		
		<thead>
			<th><?php _e("Date", "ws"); ?></th>
			<th><?php _e("Amount", "ws"); ?></th>
			<th><?php _e("Currency", "ws"); ?></th>
			<th><?php _e("Infos", "ws"); ?></th>
		</thead>
		<tbody>
			<td><p><?php echo $transaction_data->transaction_command_date;?></p></td>
			<td><p><?php echo $transaction_data->transaction_command_amount;?></p></td>
			<td><p><?php echo $transaction_data->transaction_command_currency;?></p></td>
			<td><p><?php echo $transaction_data->transaction_command_info;?></p></td>
		</tbody>

	</table>
	<h2><?php _e("Customer Information", "ws"); ?></h2>
	<table class="wp-list-table widefat fixed pages">		
		<thead>
			<th><?php _e("Customer Name", "ws"); ?></th>
			<th><?php _e("Customer Card Number", "ws"); ?></th>
			<th><?php _e("Customer Address", "ws"); ?></th>
			<th><?php _e("Customer Zip", "ws"); ?></th>
			<th><?php _e("Customer City", "ws"); ?></th>
			<th><?php _e("Customer Country", "ws"); ?></th>
			<th><?php _e("Customer Phone", "ws"); ?></th>
			<th><?php _e("Customer Cell Phone", "ws"); ?></th>
			<th><?php _e("Customer Email", "ws"); ?></th>
		</thead>
		<tbody>
			<td><p><?php echo $transaction_data->transaction_customer_name;?></p></td>
			<td><p><?php echo $transaction_data->transaction_command_cardnumber;?></p></td>
			<td><p><?php echo $transaction_data->transaction_customer_address;?></p></td>
			<td><p><?php echo $transaction_data->transaction_customer_zip;?></p></td>
			<td><p><?php echo $transaction_data->transaction_customer_city;?></p></td>
			<td><p><?php echo $transaction_data->transaction_customer_country;?></p></td>
			<td><p><?php echo $transaction_data->transaction_customer_phone;?></p></td>
			<td><p><?php echo $transaction_data->transaction_customer_cellphone;?></p></td>
			<td><p><?php echo $transaction_data->transaction_customer_email;?></p></td>	
		</tbody>
	
	</table>
	<div class="transaction_detail_box">
		<h2><?php _e("Additional Information", "ws"); ?></h2>
		<?php $other_infos = json_decode($transaction_data->transaction_otherinfos_json);
			(empty($other_infos))?_e("No additionnal input", "ws"):"";
			foreach ($other_infos as $info) :?>
				<p><strong><?php echo $info->label; ?> :</strong> <?php echo $info->value; ?></p>
		<?php endforeach;?>
	</div>
</div>