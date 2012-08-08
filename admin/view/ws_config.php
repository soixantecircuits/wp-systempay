<div class="ws_warp">
	<?php $generalConfig=$this->Manager->getGeneralConfig(); ?>
	<div class="page_title"><h1><?php _e("General Configurations","ws"); ?></h1></div>
	<form method="POST" action="?page=<?php echo $this->configPageName; ?>&WS_action=update" >
		<?php require_once("ws_config_inputs.php"); ?>
		<div class="submit">
			<input class="button" type="submit" value="<?php _e('Save','ws'); ?>" /><br/>
		</div>
	</form>
</div>