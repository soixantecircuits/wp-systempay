<div class="ws_warp">
    <div id="icon-edit" class="icon32 icon32-posts-event"></div>
    <div class="page_title">
      <h1><?php _e("Edit form", "ws"); ?></h1>
    </div>
    <br/><br/>
    <div class="cb"></div>
    <form method="POST" class="form-inline" action="?page=<?php echo $this->_editPageName; ?>&WS_action=update&WS_id=<?php echo $_GET["WS_id"];?>">
      <input type="submit" class="btn btn-success" id="submit_top" value="<?php _e('Save', 'ws'); ?>" />
      <input type="text"  class="" name="form[name]" value="<?php echo $form_to_update["form_data"]->form_name ;?>"/>
      <input type="text"  class="" name="form[css_class]" value="<?php echo $form_to_update["form_data"]->form_css_class ;?>"/>
        <select class="plateformes_select" name="form[plateforme]" id="ws_plateforme">
          <?php foreach($this->WS->getSavedInputs() as $key => $formals_inputs) : ?>
            <?php if ($form_to_update["form_data"]->form_plateforme == $key) : ?>
              <option value="<?php echo $key ;?>" selected><?php echo $key;?></option>
            <?php else : ?>
              <option value="<?php echo $key ;?>"><?php echo $key;?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      <div class="cb"></div>
      <div id="tabs">

        <ul class='nav nav-tabs subsubsub'>
          <li><a href="#tabs-1"><?php _e("Mandatorys Configurations", "ws"); ?></a></li>
          <li><a href="#tabs-2"><?php _e("Optionals Configurations", "ws"); ?></a></li>
          <li><a href="#tabs-3"><?php _e("Customer Informations Inputs", "ws"); ?></a></li>
          <li><a href="#tabs-4"><?php _e("Customizable Inputs", "ws"); ?></a></li>
          <li><a href="#tabs-5"><?php _e("Option (Mail, etc.)", "ws"); ?></a></li>
        </ul>
        <div class="cb"></div>
        <?php require_once("ws_inputs_tabs.php"); ?>
      <div class="cb"></div>
      <input type="submit" class="btn btn-success" id="submit" value="<?php _e('Save', 'ws'); ?>" />
    </form>
  </div>