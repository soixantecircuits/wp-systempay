<div class="ws_warp">
	<?php $generalConfig = $this->get_Manager()->getGeneralConfig(); ?>
	<div id="icon-options-general" class="icon32"><br></div><div class="page_title"><h1><?php _e("General Configurations","ws"); ?></h1></div>
	<div class="cb"></div>
	<form method="POST" action="?page=<?php echo $this->configPageName; ?>&WS_action=update" >
		<?php require_once("ws_config_inputs.php"); ?>
		<div class="submit">
			<input class="btn btn-success" type="submit" value="<?php _e('Save','ws'); ?>" /><br/>
		</div>
	</form>
</div>