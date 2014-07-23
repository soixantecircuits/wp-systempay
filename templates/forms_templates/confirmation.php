<?php

function getOptionName($input){

  switch ($input["type"]) {
    case 'radio' :
    case 'select':
      $options = split(";", $input["options"]);
      $value = $input["value"];
      foreach ($options as $option) :
          $optionegal = split("=", $option);
          if ($optionegal[1] == $value){
            $name = $optionegal[0];
          }
      endforeach;
      break;
    case 'checkbox':
      $options = split(";", $input["options"]);
      $space = 0;
      if(is_array($input['value'])){
          foreach ($input['value'] as $value) {
            foreach ($options as $option) :
                $optionegal = split("=", $option);
                if ($optionegal[1] == $value){
                  $virgule = ($space > 0) ?  ", " : "";
                  $name.=$virgule.$optionegal[0];
                  $space++;
                }
            endforeach;
          }
      }
      break;
    default:
      $name = $input['value'];
      break;
  }
  return $name;
}


if ($mobile && (count($_GET) > 0 || count($_POST) > 0) ) {
  $return_url .= "&mobile=true";
} else if($mobile && (count($_GET) == 0 || count($_POST) == 0) ){
  $return_url .= "?mobile=true";
}
if(array_key_exists('protocole',$_REQUEST)){
  if ($mobile || count($_GET) > 0 || count($_POST) > 0)
    $return_url .= "&protocole=".$_REQUEST['protocole'];
  else if (count($_GET) == 0 || count($_POST) == 0)
    $return_url .= "?protocole=".$_REQUEST['protocole'];
}

?>
<form method='POST' class='WS_confirmation' id='<?php echo $this->getSystempay()->get_confirmation_form_id();?>' action='<?php echo $return_url;?>'>
  <table>
    <tbody>
    <input type='hidden' name='<?php echo $amount_input_name;?>' value='<?php echo $correct_amount;?>'>
    <?php echo sprintf(__("The amount of your transaction is: %s", "ws"), $amount)." ".$this->getCurrency($form_id)->alpha3."<br/><br/>"; //to replace by currency ?>
    <?php _e("Please find bellow the information about your payement:", "ws");?><br/><br/> 
    <?php foreach ($additionalsinputs_data as $groupe) {
            foreach ($groupe as $additionalinput) {
                (bool)($additionalinput["hide"]);
                $value = (empty($additionalinput['value']))?" ":$additionalinput['value'];
                if ($additionalinput["type"] == "checkbox") {
                    foreach ($value as $val) {?>
                      <tr style='display:none;'><td><input type='hidden' name='<?php echo $additionalinput['name'];?>[]' value='<?php echo esc_attr($val); ?>'></tr></td>      
                <?php
                    }  
                } else { 
                ?>
                <tr style='display:none;'><td><input type='hidden' name='<?php echo $additionalinput['name'];?>' value='<?php echo esc_attr($value); ?>'></tr></td>
                <?php
                }
                if (!$additionalinput["hide"]) {
                    if ($additionalinput['value'] == '') {
                        $display = "none";
                    } else {
                        $display = "table-row";
                    }?>
                    <tr style='display:<?php echo $display;?>'><td widht='30%' class='confirmation_label'><?php echo $additionalinput['label']; ?>: </td><td width='70%' class='confirmation_value'>
                        <?php 
                            echo getOptionName($additionalinput);
                        ?>
                    </td></tr>
                    <?php
                }
            }
    }?>
    </tbody>
  </table>
  <div class='confirmation_buttons'>
  <?php echo $this->getCancelLink(); ?>
  <input type='submit' class='a-btn confirmation_button' id='confirm_confirm' value='<?php _e('Confirm', "ws");?>'>
  </div>
</form>