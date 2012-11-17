      <!-- Mandatorys Configurations -->  
      <div id="tabs-1">
        <div id="ws_formals"> 
        <table class="wp-list-table table widefat fixed pages" >
          <thead>
            <tr>
              <th class="large"><?php _e("Label", "ws"); ?></th>
              <th class="large"><?php _e("Name", "ws"); ?></th>
              <th class="large"><?php _e("Value", "ws"); ?></th>
              <th class="short cut"><?php _e("Function ?", "ws"); ?></th>
              <th class="short cut"><?php _e("Hide", "ws"); ?></th>
              <th class="large"><?php _e("Description", "ws"); ?></th>           
            </tr>
          </thead>
          <tbody id="ws_formals_inputs_table" class="loading">
            <!--Div where we put the formals inputs for the selected plateforme with wsAjax.php-->
          </tbody>
        </table>  
        </div>
      </div>

      <!-- Optionals configurations -->
      <div id="tabs-2">
      <div id="ws_inputs">
        <table class="wp-list-table table widefat fixed pages">
            <thead>
            <tr>
              <th class="large"><?php _e("Label", "ws"); ?></th>
              <th class="large"><?php _e("Name", "ws"); ?></th>
              <th class="large"><?php _e("Value", "ws"); ?></th>
              <th class="short cut"><?php _e("Function ?", "ws"); ?></th>
              <th class="short cut"><?php _e("Hide", "ws"); ?></th>
              <th class="large"><?php _e("Description", "ws"); ?></th>
            </tr>
            </thead>
            <tbody id="ws_inputs_table">
            </tbody>
        </table>
      </div>
      </div>

      <!-- Customer Inputs -->
      <div id="tabs-3">
        <div id="ws_customer_inputs">
          <table class="wp-list-table table widefat fixed pages">
            <thead>
              <tr>
                <th class="large"><?php _e("Label", "ws"); ?></th>
                <th class="large"><?php _e("Name", "ws")?></th>
                <th class="large"><?php _e("Value", "ws")?></th>
                <th class="short"><?php _e("Order", "ws")?></th>
                <th class="short"><?php _e("Fieldset", "ws")?></th>
                <th class="short"><?php _e("Hide", "ws")?></th>
                <th class="short"><?php _e("Required", "ws")?></th>
                <th class="short"><?php _e("Class", "ws")?></th>
                <th class="short"><?php _e("Type", "ws")?></th>
                <th class="short"><?php _e("Options", "ws")?></th>
                <th class="large"><?php _e("Description", "ws")?></th>
              </tr>
            </thead>
            <tbody id="ws_customer_inputs_table">

            </tbody>
          </table>
        </div>
      </div>

      <div id="tabs-4">
        <?php require_once "ws_custom_inputs.php"; ?>        
      </div>  

      <div id="tabs-5">
        <?php require_once "ws_config_inputs.php"; ?>
      </div>

      

