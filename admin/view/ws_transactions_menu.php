<div class="ws_warp">
	<div class="ws_transactionwarp">
		<div class="page_title"><h1><?php _e("Transactions menu","ws"); ?></h1></div>
		<?php foreach ($formlist as $form) : $count++;?>
			<?php $jump=($count%6==0)?"<div class='cb'></div>":""; ?>
			<?php echo $jump; ?>
			<a class="ws_transacton_box button" href="?page=<?php echo $this->transactionsPageName;?>&WS_id=<?php echo $form->form_id; ?>">
					<h2><p class="transaction_form_name"> <?php echo $form->form_name;?></p></h3>
					<p class="transaction_form_id"><strong>ID:</strong> <?php echo $form->form_id;?></p>
			</a>
		<?php endforeach;?>
	</div>
</div>
