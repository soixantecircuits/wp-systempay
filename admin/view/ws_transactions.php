<div class="ws_warp">
	<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><div class="page_title"><h1><?php _e("Transactions","ws"); ?></h1></div>
	<div class="cb"></div>
	<table id="transactions_table" class="wp-list-table widefat fixed pages">
		<thead>
			<tr>
				<th><?php _e("Command id","WS"); ?></th>
				<th><?php _e("Plateforme","WS"); ?></th>
				<th><?php _e("Statut","WS"); ?></th>
				<th><?php _e("Info","WS"); ?></th>
				<th><?php _e("Date","WS"); ?></th>
				<th><?php _e("Currency","WS"); ?></th>
				<th><?php _e("Amount","WS"); ?></th>
				<th><?php _e("Customer Name","WS"); ?></th>
				<th><?php _e("Customer Address","WS"); ?></th>
				<th><?php _e("Customer Phone","WS"); ?></th>
				<th><?php _e("Customer Cell phone","WS"); ?></th>
				<th><?php _e("Customer Email","WS"); ?></th>
				<th><?php _e("Customer Country","WS"); ?></th>
				<th><?php _e("Actions","WS"); ?></th>
			</tr>
		</thead>
		<tbody>
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
		</tbody>
	</table>
</div>
	<?php 
		$options = '
					"sPaginationType": "full_numbers"
					, "bLengthChange": false
			        ,"iDisplayLength": 20
					,"oLanguage": {
					  "oPaginate": {
					    "sNext": "&#155;"
					    ,"sPrevious": "&#139;"
					    ,"sLast": "&#155;&#155;"
					    ,"sFirst": "&#139;&#139;"
					  }
					}
					';
		$WS->add_inline_js("jQuery('#transactions_table').dataTable({".$options."});")
	?>