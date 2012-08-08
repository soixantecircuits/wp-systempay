<div class="ws_warp">
		<div class="page_title"><h1><?php _e("Edit Form","ws"); ?></h1></div>
		<form method="POST" action="?page=<?php echo $this->editPageName; ?>&WS_action=update&WS_id=<?php echo $_GET["WS_id"];?>">
			<input type="text"  class="big_input" name="form[name]" value="<?php echo $form_to_update["form_data"]->form_name ;?>"/>
			<input type="text"  class="big_input" name="form[css_class]" value="<?php echo $form_to_update["form_data"]->form_css_class ;?>"/>
			<br/>
		<!--Formals inputs -->
			<div class="plateformes">
				<p class="plateformes_label"><?php _e("Plateforms","ws"); ?> : </p>
				<select class="plateformes_select" name="form[plateforme]" id="ws_plateforme">
					<?php foreach($this->WS->getSavedInputs() as $key=>$formals_inputs) : ?>
						<?php if ($form_to_update["form_data"]->form_plateforme == $key) : ?>
							<option value="<?php echo $key ;?>" selected><?php echo $key;?></option>
						<?php else : ?>
							<option value="<?php echo $key ;?>"><?php echo $key;?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="cb"></div>
			<div id="tabs">
				<ul class='subsubsub'>
					<li><a href="#tabs-1"><?php _e("Mandatorys Configurations","ws"); ?></a> | </li>
					<li><a href="#tabs-2"><?php _e("Optionals Configurations","ws"); ?></a> | </li>
					<li><a href="#tabs-3"><?php _e("Customer Informations Inputs","ws"); ?> | </a></li>
					<li><a href="#tabs-4"><?php _e("ws Configuration","ws"); ?> | </a></li>
					<li><a href="#tabs-5"><?php _e("Customizable Inputs","ws"); ?></a></li>
				</ul>
			<?php require_once("ws_inputs_tabs.php"); ?>
				<div id="tabs-5">
						<div class="page_title"><h2><?php _e("Customizable Inputs","ws"); ?></h2></div>
						<div id="ws_customer_inputs">
							<table>
								<thead class="table_head">
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
									<?php $index=500; ?>
									<?php foreach($form_to_update["inputs_data"] as $group):?>
										<?php foreach ($group as $input) :
												(int)($input->input_fieldset);
												if ($input->input_fieldset>-1) : ?>
												<tr id="row_<?php echo $index; ?>" class="<?php echo ($index%2==0) ? 'even' : 'odd';?>">										
													<td class="delete_row short"><input type="button" class="button" value="-" onClick="WS_deleteRow(<?php echo $index; ?>);"/></td>
													<td class="large label"><input type="text" name="inputs[<?php echo $index; ?>][label]"  value="<?php echo $input->input_label; ?>"/></td>
													<td class="large"><input type="text" name="inputs[<?php echo $index; ?>][name]"  value="<?php echo $input->input_name; ?>"/></td>			
													<td class="short"><input type="text" name="inputs[<?php echo $index; ?>][value]" value="<?php echo $input->input_value; ?>"/></td>	
													<td class="short"><input type="text" name="inputs[<?php echo $index; ?>][order]" value="<?php echo $input->input_order; ?>"/></td>
													<td class="short"><input type="text" name="inputs[<?php echo $index; ?>][fieldset]" value="<?php echo $input->input_fieldset; ?>"/></td>
													<?php $hidden=(bool)($input->input_hide); ?>
													<?php $checked=($hidden)?"checked":""; ?>
													<td><input type="checkbox" name="inputs[<?php echo $index; ?>][hide]" value="1" <?php echo $checked; ?>/></td>
													<?php $required=(bool)($input->input_required); ?>
													<?php $checked=($required)?"checked":""; ?>
													<td><input type="checkbox" name="inputs[<?php echo $index; ?>][required]" value="1" <?php echo $checked; ?>/></td>
													<td class="short"><input type="text" name="inputs[<?php echo $index; ?>][class]" value="<?php echo $input->input_class; ?>"/></td>
													<td>
														<SELECT name="inputs[<?php echo $index; ?>][type]" size="1">
															<?php foreach ($this->select_types as $value) {
																$selected=($input->input_type==$value)?"selected":"" ;
																echo "<OPTION ".$selected.">".$value."</OPTION>";
															}?>
														</SELECT>
													</td>
													<td class="large"><input type="text" name="inputs[<?php echo $index; ?>][options]" value="<?php echo $input->input_options; ?>"/></td>
												</tr>
												<?php $index++; ?>
										<?php endif; ?> 
									  <?php endforeach; ?>
									<?php endforeach; ?>

									</tr>
								</tbody>
							</table>
							<input type="button" id="addRow" class="button" value="+" onClick="WS_addRow();"/>
							<div class="cb"></div> 
						</div>
					</div>
				</div>
			<div class="cb"></div>
			<input type="submit" class="button" id="submit" value="<?php _e('Save','ws'); ?>" />
		</form>
	</div>

