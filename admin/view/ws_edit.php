<?php
function cmpFieldset($a, $b)
{		
		if ($a->input_fieldset == $b->input_fieldset) {
        return 0;
    }
    return ($a->input_fieldset > $b->input_fieldset) ? 1 : -1;
}
?>

<div class="ws_warp">
		<div id="icon-edit" class="icon32 icon32-posts-event"><br></div>
		<div class="page_title"><h1><?php _e("Edit Form","ws"); ?></h1></div>
		<br>
		<div class="cb"></div>
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
				<div class="cb"></div>
			<?php require_once("ws_inputs_tabs.php"); ?>
				<div id="tabs-5">
						<h2><?php _e("Customizable Inputs","ws"); ?></h2>
						<div id="ws_customizable_inputs">
							<?php //This is dumb value to go far away from previous field... to change ?>
									<?php usort($form_to_update["inputs_data"],"cmpFieldset"); ?>
									<?php foreach($form_to_update["inputs_data"] as $group):?>
											<?php $this->printTable($group); ?>
									<?php endforeach; ?>
						</div>
					</div>
				</div>
			<div class="cb"></div>
			<input type="submit" class="button" id="submit" value="<?php _e('Save','ws'); ?>" />
		</form>
	</div>

