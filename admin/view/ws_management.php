<div class="ws_warp">
		<div class="result_server_link">
			<?php $link = $this->WS->get_resultServerPage_url(); 
			if (isset($link)) { ?> <a href="<?php echo $link; ?>"><?php echo $link; ?></a> <?php } 
			else { _e("No link","ws"); }?>
			
		</div>
		<div class="page_title"><h1>Manage your forms</h1></div>
		<table class="manager">
			<tr class="table_head">
				<th><p><?php _e("Name","ws");?></p></th>
				<th><?php _e("ID","ws");?></th>
				<th><?php _e("css_classe","ws");?></th>
				<th><?php _e("Shortcode","ws");?></th>
				<th></th>
			</tr>
			<?php foreach ($this->Manager->getFormsList() as $form) : $count++;?>
			<tr class="<?php echo ($count%2==0) ? 'even' : 'odd';?>">
				<td><p><a href="?page=<?php echo $this->editPageName;?>&WS_action=edit&WS_id=<?php echo $form->form_id; ?>"><?php echo $form->form_name; ?></a></p></td>
				<td><p><?php echo $form->form_id; ?></p></td>
				<td><p><?php echo $form->form_css_class; ?></p></td>
				<td><p><?php echo "[wp-systempay id=".$form->form_id." template='']" ?></p></td>
				<td><a class ="button" href="?page=<?php echo $this->mainPageName;?>&WS_action=delete&WS_id=<?php echo $form->form_id; ?>">delete</a></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<a class="button" id="btn_newform" href="?page=<?php echo $this->newFormPageName;?>">new Form</a>
</div>
