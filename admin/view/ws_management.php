<div class="ws_warp">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><div class="page_title"><h1>Manage your forms</h1></div>
		<div class="cb"></div>

		<div class="result_server_link">
			<p><?php _e("Link for server-side feedbacks:", "WS"); ?>
				<?php $link = $this->WS->get_resultServerPage_url(); 
				if (isset($link)) { ?> <a href="<?php echo $link; ?>"><?php echo $link; ?></a> <?php } 
				else { _e("No link","WS"); }?>
			</p>
		</div>
		<table class="wp-list-table widefat fixed pages">
			<thead>
				<tr>
					<th><p><?php _e("Name","ws");?></p></th>
					<th><?php _e("ID","ws");?></th>
					<th><?php _e("css_classe","ws");?></th>
					<th><?php _e("Shortcode","ws");?></th>
					<th></th>
				</tr>
			</thead>
			<?php foreach ($this->Manager->getFormsList() as $form) : $count++;?>
			<tbody>
				<tr class="<?php echo ($count%2==0) ? 'even' : 'odd';?>">
					<td><p><a href="?page=<?php echo $this->editPageName;?>&WS_action=edit&WS_id=<?php echo $form->form_id; ?>"><?php echo $form->form_name; ?></a></p></td>
					<td><p><?php echo $form->form_id; ?></p></td>
					<td><p><?php echo $form->form_css_class; ?></p></td>
					<td><p><?php echo "[wp-systempay id=".$form->form_id." template='']" ?></p></td>
					<td><a class ="button" href="?page=<?php echo $this->mainPageName;?>&WS_action=delete&WS_id=<?php echo $form->form_id; ?>">delete</a></td>
				</tr>
			</tbody>
			<?php endforeach; ?>
		</table>
		<a class="button" id="btn_newform" href="?page=<?php echo $this->newFormPageName;?>">new Form</a>
</div>
