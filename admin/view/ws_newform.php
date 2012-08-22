<div class="ws_warp">
		<div id="icon-edit" class="icon32 icon32-posts-event"><br></div><div class="page_title"><h1><?php _e("New Form","ws"); ?></h1></div>
		<div class="cb"></div>
		<form method="POST" action="?page=<?php echo $this->newFormPageName; ?>&WS_action=insert">
			<input id="form_name" class="big_input" type="text"  name="form[name]" value="form_name"/>
			<input id="css_class" class="big_input" type="text"  name="form[css_class]" value="ws_css_class"/>
			
			<br/>
			<div class="plateformes">
				<p class="plateformes_label"><?php _e("Plateforms","ws"); ?> : </p>
				<select class="plateformes_select" name="form[plateforme]" id="ws_plateforme">
					<?php foreach($this->WS->getSavedInputs() as $key=>$formals_inputs) : ?>
						<option value="<?php echo $key ;?>"><?php echo $key;?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="cb"></div>
			<div id="tabs">
				<ul class='subsubsub'>
					<li><a href="#tabs-1"><?php _e("Mandatorys Configurations","ws"); ?></a></li>
					<li><a href="#tabs-2"><?php _e("Optionals Configurations","ws"); ?></a></li>
					<li><a href="#tabs-3"><?php _e("Customer Informations Inputs","ws"); ?></a></li>
					<li><a href="#tabs-4"><?php _e("ws configuration","ws"); ?></a></li>
					<li><a href="#tabs-5"><?php _e("Customizable Inputs","ws"); ?></a></li>
				</ul>
				<div class="cb"></div>
			<?php require_once("ws_inputs_tabs.php"); ?>
				<div id="tabs-5">
					<h2><?php _e("Customizable Inputs","ws"); ?></h2>
					<div id="ws_customizable_inputs">
						<table class="wp-list-table widefat fixed pages">
							<thead>
								<tr>
									<th class="short"> </th>
									<th class="large"><?php _e("Label","ws"); ?></th>
									<th class="large"><?php _e("Name","ws")?></th>
									<th class="large"><?php _e("Value","ws")?></th>
									<th class="short"><?php _e("Order","ws")?></th>
									<th class="short"><?php _e("Fieldset","ws")?></th>
									<th class="short"><?php _e("Hide","ws")?></th>
									<th class="short"><?php _e("Required","ws")?></th>
									<th class="short"><?php _e("Class","ws")?></th>
									<th class="short"><?php _e("Type","ws")?></th>
									<th class="short"><?php _e("Options","ws")?></th>
								</tr>
							</thead>
							<tbody id="ws_customizable_inputs_table">
							<?php $selectOptions=array("text","select","option","checkbox","textarea","countrylist","numeric","amountentry"); ?>
								<tr id="row_499" class=''>
										<td class="delete_row short"><input type="button" class="button" value="-" onClick="WS_deleteRow(499);"/></td>
										<td class="large label"><input type="text" name="inputs[499][label]"  value="new input"/></td>
										<td class="large"><input type="text" name="inputs[499][name]"  value=""/></td>			
										<td class="short"><input type="text" name="inputs[499][value]" value=""/></td>	
										<td class="short"><input type="text" name="inputs[499][order]" value="0"/></td>
										<td class="short"><input type="text" name="inputs[499][fieldset]" value="1"/></td>
										<td><input type="checkbox" name="inputs[499][hide]" value="1"/></td>
										<td><input type="checkbox" name="inputs[499][required]" value="1"/></td>
										<td class="short"><input type="text" name="inputs[499][class]" value=""/></td>
										<td>
										<SELECT name="inputs[499][type]" size="1">
											<?php foreach ($this->select_types as $value) {
												echo "<OPTION>".$value."</OPTION>";
											}?>
										</SELECT>
										</td>
										<td class="short"><input type="text" name="inputs[499][options]" value="<?php echo $input->input_options; ?>"/></td>
								</tr>
							</tbody>
						</table>
						<input type="button" id="addRow" class="button" value="+" onClick="WS_addRow();"/>
						<div class="cb"></div> 
					</div>
				</div>
			</div>
			<div class="cb"></div>
			<input type="submit" class="button" id="submit" value="<?php _e('Save','ws'); ?>"/>
		</form>
</div>
