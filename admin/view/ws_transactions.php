<div class="ws_warp">
	<div class="page_title"><h1><?php _e("Transactions","ws"); ?></h1></div>
	<table class="transactions">
		<tr class="table_head">
			<th><?php _e("Command id"); ?></th>
			<th><?php _e("Plateforme"); ?></th>
			<th><?php _e("Statut"); ?></th>
			<th><?php _e("Info"); ?></th>
			<th><?php _e("Date"); ?></th>
			<th><?php _e("Currency"); ?></th>
			<th><?php _e("Amount"); ?></th>
			<th><?php _e("Customer Name"); ?></th>
			<th><?php _e("Customer Address"); ?></th>
			<th><?php _e("Customer Phone"); ?></th>
			<th><?php _e("Customer Cell phone"); ?></th>
			<th><?php _e("Customer Email"); ?></th>
			<th><?php _e("Customer Country"); ?></th>
			<th> </th>
		</tr>
	<?php
		$count=0;
		foreach ($transactions as $transaction_data) : $count++;?>
		<tr class="<?php echo ($count%2==0) ? 'even' : 'odd';?>">
			<td><?php echo $transaction_data->transaction_order_id;?></td>
			<td><?php echo $transaction_data->transaction_plateforme;?></td>
			<td><?php echo $transaction_data->transaction_command_statut;?></td>
			<td><?php echo $transaction_data->transaction_command_info;?></td>
			<td><?php echo $transaction_data->transaction_command_date;?></td>
			<td><?php echo $transaction_data->transaction_command_currency;?></td>
			<td><?php echo $transaction_data->transaction_command_amount;?></td>
			<td><?php echo $transaction_data->transaction_customer_name;?></td>
			<td><?php echo $transaction_data->transaction_customer_address;?></td>
			<td><?php echo $transaction_data->transaction_customer_phone;?></td>
			<td><?php echo $transaction_data->transaction_customer_cellphone;?></td>
			<td><?php echo $transaction_data->transaction_customer_email;?></td>
			<td><?php echo $transaction_data->transaction_customer_country;?></td>
			<td><a class="button" href="?page=<?php echo $this->transactionDetailsPageName;?>&transaction_id=<?php echo $transaction_data->transaction_id; ?>"><?php _e("Details","ws"); ?></a></td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>