<?php
function cmpFieldset($a, $b)
{   
    if ($a[0]->input_fieldset == $b[0]->input_fieldset) {
        return 0;
    }
    return ($a[0]->input_fieldset > $b[0]->input_fieldset) ? 1 : -1;
}
?>
<div class="top-infos"><button id="addTable" class="btn btn-info"><?php _e("Add a fieldset", "ws"); ?> <i class="icon-plus-sign icon-white"></i></button></div>
<div id="ws_customizable_inputs">
<?php if(!isset($is_new_form) || $is_new_form == false) { ?>
  <?php //This is dumb value to go far away from previous field... to change ?>
      <?php usort($form_to_update["inputs_data"],"cmpFieldset"); ?>
      <?php foreach($form_to_update["inputs_data"] as $group):?>
          <?php $this->printTable($group); ?>
      <?php endforeach; ?>
       <div class="group visuallyhidden">
          <div class="fieldset_name ">
            <input class="" type="text" placeholder="<?php _e("Choose a nice fieldset name", "ws"); ?>" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][label]" value="<?php echo $input->input_label; ?>">
            <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][name]" value="">     
            <input class="hidden" type="text" name="inputs[<?php echo  $this->_rowIndexCustomInput; ?>][value]" value="">
            <input class="hidden order" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][order]" value="0">
            <input class="fieldset" type="text" name='inputs[<?php echo $this->_rowIndexCustomInput; ?>][fieldset]' value="1">
            <input class="hidden" type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][hide]" value="1" >
            <input class="hidden" type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][required]" value="1">
            <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][class]" value="">
            <select class="hidden" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][type]" size="1">
            <?php 
            foreach ($this->_select_types as $value) {
                    $selected = ($input->input_type == $value)?"selected":"" ;
                    echo "<OPTION ".$selected.">".$value."</OPTION>";
            }
            ?>
            </select>
            <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][options]" value="<?php echo $input->input_options; ?>"/>
          </div>
            <?php $this->_rowIndexCustomInput++; ?>
            <?php //end title?>
        <table class="table wp-list-table widefat fixed pages">
          <thead>
            <tr>
              <th class="short delete_row"> </th>
              <th class="large"><?php _e("Label", "ws"); ?></th>
              <th class="large"><?php _e("Name", "ws")?></th>
              <th class="large"><?php _e("Value", "ws")?></th>
              <th class="short"><?php _e("Order", "ws")?></th>
              <th class="short"><?php _e("Fieldset", "ws")?></th>
              <th class="short check"><?php _e("Hide", "ws")?></th>
              <th class="short check"><?php _e("Required", "ws")?></th>
              <th class="short"><?php _e("Class", "ws")?></th>
              <th class="short"><?php _e("Type", "ws")?></th>
              <th class="short"><?php _e("Options", "ws")?></th>
            </tr>
          </thead>
          <tbody id="ws_customizable_inputs_table">
            <tr id="row_499" class=''>
                <td class="delete_row short"><button class="btn btn-warning delete_row"><i class="icon-minus icon-white"></i></button></td>
                <td class="large"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][label]"  value="new input"></td>
                <td class="large"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][name]"  value=""></td>      
                <td class="short"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][value]" value=""></td>  
                <td class="short"><input type="text" class="order" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][order]" value="1"></td>
                <td class="short"><input type="text" class="fieldset" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][fieldset]" value="1"></td>
                <td class="short check"><input type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][hide]" value="1"></td>
                <td class="short check"><input type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][required]" value="1"></td>
                <td class="short"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][class]" value=""></td>
                <td class="short">
                <select name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][type]" size="1">
                  <?php foreach ($this->_select_types as $value) {
                    echo "<OPTION>".$value."</OPTION>";
                  }?>
                </select>
                </td>
                <td class="short"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][options]" value="<?php echo $input->input_options; ?>"></td>
            </tr>
          </tbody>
        </table>
        <button class="removeTable btn btn-danger"><?php _e("Remove the whole fieldset !", "ws");?> <i class="icon-trash icon-white"></i></button>
        <button class="addRow btn btn-primary"><?php _e("Add a field", "ws"); ?> <i class="icon-plus icon-white"></i></button>
    </div>
<?php } else { ?>
    <div class="group">
          <div class="fieldset_name ">
            <input class="" type="text" placeholder="<?php _e("Choose a nice fieldset name", "ws"); ?>" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][label]" value="<?php echo $input->input_label; ?>">
            <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][name]" value="">     
            <input class="hidden" type="text" name="inputs[<?php echo  $this->_rowIndexCustomInput; ?>][value]" value="">
            <input class="hidden order" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][order]" value="0">
            <input class="fieldset" type="text" name='inputs[<?php echo $this->_rowIndexCustomInput; ?>][fieldset]' value="1">
            <input class="hidden" type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][hide]" value="1" >
            <input class="hidden" type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][required]" value="1">
            <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][class]" value="">
            <select class="hidden" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][type]" size="1">
            <?php 
            foreach ($this->_select_types as $value) {
                    $selected = ($input->input_type == $value)?"selected":"" ;
                    echo "<OPTION ".$selected.">".$value."</OPTION>";
            }
            ?>
            </select>
            <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][options]" value="<?php echo $input->input_options; ?>"/>
          </div>
            <?php $this->_rowIndexCustomInput++; ?>
            <?php //end title?>
        <table class="table wp-list-table widefat fixed pages">
          <thead>
            <tr>
              <th class="short delete_row"> </th>
              <th class="large"><?php _e("Label", "ws"); ?></th>
              <th class="large"><?php _e("Name", "ws")?></th>
              <th class="large"><?php _e("Value", "ws")?></th>
              <th class="short"><?php _e("Order", "ws")?></th>
              <th class="short"><?php _e("Fieldset", "ws")?></th>
              <th class="short check"><?php _e("Hide", "ws")?></th>
              <th class="short check"><?php _e("Required", "ws")?></th>
              <th class="short"><?php _e("Class", "ws")?></th>
              <th class="short"><?php _e("Type", "ws")?></th>
              <th class="short"><?php _e("Options", "ws")?></th>
            </tr>
          </thead>
          <tbody id="ws_customizable_inputs_table">
            <tr id="row_499" class=''>
                <td class="delete_row short"><button class="btn btn-warning delete_row"><i class="icon-minus icon-white"></i></button></td>
                <td class="large"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][label]"  value="new input"></td>
                <td class="large"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][name]"  value=""></td>      
                <td class="short"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][value]" value=""></td>  
                <td class="short"><input type="text" class="order" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][order]" value="1"></td>
                <td class="short"><input type="text" class="fieldset" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][fieldset]" value="1"></td>
                <td class="short check"><input type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][hide]" value="1"></td>
                <td class="short check"><input type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][required]" value="1"></td>
                <td class="short"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][class]" value=""></td>
                <td class="short">
                <select name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][type]" size="1">
                  <?php foreach ($this->_select_types as $value) {
                    echo "<OPTION>".$value."</OPTION>";
                  }?>
                </select>
                </td>
                <td class="short"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][options]" value="<?php echo $input->input_options; ?>"></td>
            </tr>
          </tbody>
        </table>
        <button class="removeTable btn btn-danger"><?php _e("Remove the whole fieldset !", "ws");?> <i class="icon-trash icon-white"></i></button>
        <button class="addRow btn btn-primary"><?php _e("Add a field", "ws"); ?> <i class="icon-plus icon-white"></i></button>
    </div>
    <?php } ?>
</div>