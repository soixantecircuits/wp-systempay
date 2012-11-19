<div class="ws_warp">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><div class="page_title"><h1>Manage your forms</h1></div>
		<div class="cb"></div>

		<div class="result_server_link">
			<div class="alert alert-info"><span class="label label-info"><?php _e("Info", "ws");?></span><?php _e("Link for server-side feedbacks:", "ws"); ?>
				<?php echo $this->WS->get_resultServerPage_url();?></div>
		</div>
		<table class="table table-striped wp-list-table widefat fixed pages">
			<thead>
				<tr>
					<th><?php _e("Name", "ws");?></th>
					<th><?php _e("ID", "ws");?></th>
					<th><?php _e("CSS class", "ws");?></th>
					<th><?php _e("Shortcode", "ws");?></th>
					<th></th>
				</tr>

			</thead>
			<tbody>
			<?php foreach ($this->_Manager->getFormsList() as $form) : $count++;?>
				<tr class="<?php echo ($count%2==0) ? 'even' : 'odd';?>">
					<td><a href="?page=<?php echo $this->_editPageName;?>&WS_action=edit&WS_id=<?php echo $form->form_id; ?>"><?php echo $form->form_name; ?></a></td>
					<td><?php echo $form->form_id; ?></td>
					<td><?php echo $form->form_css_class; ?></td>
					<td><div class="alert alert-info"><?php echo "[wp-systempay id=".$form->form_id." template='']" ?></div></td>
					<td class="action"><a class="btn btn-danger" href="?page=<?php echo $this->_mainPageName;?>&WS_action=delete&WS_id=<?php echo $form->form_id; ?>"><?php _e("Delete", "ws"); ?> <i class="icon-minus icon-white"></i></a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<a class="btn-primary btn" id="btn_newform" href="?page=<?php echo $this->_newFormPageName;?>"><?php _e("New form", "ws");?> <i class="icon-plus icon-white"></i></a>
</div>