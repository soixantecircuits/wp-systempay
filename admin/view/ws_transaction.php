<div class="ws_warp">
	<div class="page_title"><h1><?php _e("Transactions","ws"); ?></h1></div>
	<table>
		<tr>
			<th><?php _e("Label"); ?></th>
			<th><?php _e("Name"); ?></th>
			<th><?php _e("Value"); ?></th>
		</tr>
		<tr>
			<td><?php _e("Customer Name"); ?></td>
			<td></td>
			<td><?php echo $transaction_data->transaction_customer_name;?></td>
		</tr>
		<tr>
			<td><?php _e("Customer Address"); ?></td>
			<td></td>
			<td><?php echo $transaction_data->transaction_customer_address;?></td>
		</tr>
		<tr>
			<td><?php _e("Customer Phone"); ?></td>
			<td></td>
			<td><?php echo $transaction_data->transaction_customer_phone;?></td>
		</tr>
		<tr>
			<td><?php _e("Customer Cell phone"); ?></td>
			<td><?php echo $transaction_data->transaction_customer_cellphone;?></td>
		</tr>
		<tr>
			<td><?php _e("Customer Email"); ?></td>
			<td></td>
			<td><?php echo $transaction_data->transaction_customer_email;?></td>
		</tr>
		<tr>
			<td><?php _e("Customer Country"); ?></td>
			<td></td>
			<td><?php echo $transaction_data->transaction_customer_country;?></td>
			
		</tr>
		<tr>
		<?php $other_infos=json_decode($transaction_data->transaction_otherinfos_json); ?>
		
				<?php foreach ($other_infos as $key => $value) : ?>
					<tr>
						<td></td>
						<td><?php echo $key; ?></td>
						<td><?php echo $value; ?></td>	
					</tr>
		<?php   endforeach;?>
			</td>
		</tr>
	</table>
</div>