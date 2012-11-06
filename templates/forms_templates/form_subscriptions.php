			
			<form id="subscription_form" class="<?php echo $this->getCssClass($form_id);?>" action="<?php echo $this->get_confirmationpage_url($form_id) ?>" method="post"> 
			<?php foreach ($additionalsinputs_data as $group) : ?>
				<?php $index = 0; ?>
				<fieldset class="fielset_form"><legend>
				<?php $numfielset = (int) $group[$index]["fieldset"]; 
				//echo 'numfielset = '.$numfielset;
				switch ($numfielset) {
				case -1 : 
					_e("General information","ws"); ?></legend><div class="general_form">
				<?php break;					
				case 1 : 
					_e("Personnal information","ws"); ?></legend><div class="custom_form"> 
				<?php break; 
				case 2 : 
					_e("Subscribe to the magazine (4 editions per year)","ws"); ?></legend><div class="custom_form"> 
				<?php break; 				
				case 3 : 
					_e("Annuel membership to ELA (12 month long)","ws"); ?></legend><div class="custom_form"> 
				<?php break; 
				case 4 : 
					_e("Make a donation to ELA","ws"); ?></legend><div class="custom_form"> 
				<?php break; 
				} ?>
				<?php foreach($group as $input) : 
				if ($numfielset == -1) {?>
				<table>
				
				<tr>
					
					<td class="general_label" 
						<?php if ($input["hide"] == 1 ) { ?> style="display:none;" <?php } ?> >
						<p><label><?php echo $input["label"]; ?> <?php if ($input["hide"] == 0 ) { ?> : <?php if ($input["required"] == 1 ) { echo '*';} ?><?php } ?> 
						</label></p></td>
					<td>
					
					<?php $this->getFormType($input,0); ?>
					</td>
				</tr>
				</table>
				<?php } else { ?>
					<div class="item_form">
					<label><?php echo $input["label"];?> <?php if (($input["hide"] == 0 )&&($input["label"] != "")) { ?> : <?php if ($input["required"] == 1 ) { echo '*';}?><?php } ?> </label>
					<?php $this->getFormType($input,0); ?>
					</div>
				<?php } endforeach; ?>
				<?php $index++; ?>
				</div>
				</fieldset>

	<?php endforeach; ?>
					<input id="buttonSend" type="submit" value="<?php _e("Send","ws"); ?>" name="submit" />
				</form>