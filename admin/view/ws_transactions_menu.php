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
		<?php foreach ($formlist as $form) : $count++;?>
			<?php $jump=($count%6==0)?"<div class='cb'></div>":""; ?>
			<?php echo $jump; ?>
			<tr>
				<td class="post-title page-title column-title">
					<a href="?page=<?php echo $this->transactionsPageName;?>&WS_id=<?php echo $form->form_id; ?>">
						<strong><?php echo $form->form_name;?></strong>
					</a>
				</td>
				<td>
					<p class="transaction_form_id"><?php echo $form->form_id;?></p>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
