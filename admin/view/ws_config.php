<div class="ws_warp">
  <?php $generalConfig = $this->get_Manager()->getGeneralConfig(); ?>
  <div id="icon-options-general" class="icon32"><br></div><div class="page_title"><h1><?php _e("General Configurations","ws"); ?></h1></div>
  <div class="cb"></div>
  <form method="POST" class="form-inline " action="?page=<?php echo $this->_configPageName; ?>&WS_action=update" >
    <?php require_once("ws_config_inputs.php"); ?>
    
      <input class="btn btn-success" id='submit' type="submit" value="<?php _e('Save', 'ws'); ?>" /><br/>
    
  </form>
</div>