<div class="ws_warp">
	<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><div class="page_title"><h1><?php _e("Transactions menu","ws"); ?></h1></div>
	<div class="cb"></div>
	<table class="wp-list-table widefat fixed pages" >
		<thead>
			<tr>
				<th><?php _e("Nom"); ?></th>
				<th><?php _e("ID"); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($groupeList as $groupe) :?>
			<tr>
				<td class="post-title page-title column-title">
					<a href="?page=<?php echo $this->transactionsPageName;?>&WS_id=<?php echo $groupe->transaction_form_id; ?>">
						<strong><?php echo $groupe->transaction_form_name;?></strong>
					</a>
				</td>
				<td>
					<p class="transaction_form_id"><?php echo $groupe->transaction_form_id;?></p>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div class="updated"><p><?php _e('If the desired group does not appear, please make a new transaction (step needed is to redirect the payment platform, no need to go further).<br/> If the problem persist, go to the table SQL transactions, look transaction_form_id corresponding to the desired form and just change the "transaction_form_name" of one of its transactions.',"WS"); ?></p></div>
</div>
