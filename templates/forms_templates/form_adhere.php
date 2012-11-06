			
			<form id="subscription_form" class="<?php echo $this->getCssClass($form_id);?>" action="<?php echo $this->get_confirmationpage_url($form_id) ?>" method="post"> 
			<?php foreach ($additionalsinputs_data as $group) : ?>
				<?php $index = 0; ?>
				<fieldset class="fielset_form"><legend>
				<?php $numfielset = (int) $group[$index]["fieldset"]; 
				switch ($numfielset) {
				case -1 : 
					_e("Informations générales","ws"); ?></legend><div class="general_form">
				<?php break;					
				default : 
					echo $group[$index]["label"]; ?></legend><div class="custom_form"> 
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
						<?php if($input["order"] != 0){?>
							<label><?php echo $input["label"];?> <?php if (($input["hide"] == 0 )&&($input["label"] != "")) { ?> : <?php if ($input["required"] == 1 ) { echo '*';}?><?php } ?> </label>
							<?php $this->getFormType($input,0); ?>
						<?php } ?>
					</div>
				<?php } endforeach; ?>
				<?php $index++; ?>
				</div>
				</fieldset>

	<?php endforeach; ?>
					<input id="buttonSend" type="submit" value="<?php _e("Envoyer","ela"); ?>" name="submit" />
				</form>