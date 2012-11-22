<?php

class WSForms extends WSTools  
{
    public function __construct($systempay)
    {
        parent::__construct($systempay);
    }
  
    public function getFormByName($name, $template)
    { 
        $form_id = $this->getFormIdByName($name);
        $this->getFormById($form_id, $template);
    }
    //get the HTML for the form wanted
    public function getFormById($form_id, $template)
    { 
        (int)($form_id);
        if(file_exists(get_stylesheet_directory()."/wp-systempay/templates/forms_templates/styles.css") ) {
        		wp_enqueue_style(get_stylesheet_directory()."/wp-systempay/templates/forms_templates/styles.css");
        } else {
        		wp_enqueue_style('WS_template_css', WP_PLUGIN_URL .'/wp-systempay/css/templates/styles.css');
      	}
        wp_enqueue_script('wp_footer', WP_PLUGIN_URL .'/wp-systempay/inc/jquery.validate.min.js');
        $WS_data   = parent::getFormArrayById($form_id);
        $form_data = $WS_data["form_data"];
        $additionalsinputs_data = $WS_data["inputs_data"];
        if ($template) {
            if ( file_exists(get_stylesheet_directory()."/wp-systempay/templates/forms_templates/".$template) ) {
                $path = get_stylesheet_directory()."/wp-systempay/templates/forms_templates/".$template ;
            } else {
                $path = dirname(__FILE__)."/../templates/forms_templates/".$template; 
            }       
        } else {
            $path = dirname(__FILE__)."/../templates/forms_templates/default_form.php";
        }

        if (file_exists($path)) {
            include_once $path;
        } else {
            _e("No template file found", "ws");
        }

        $rules = '';
        
        //echo $this->getFormIdByName("form_adhere");
        for ($i = 0 ; $i < sizeof($this->arrayRules); ++$i) {
            $value = '';
            switch ($this->arrayRules[$i][0]) {
            case 'numeric' :
                $value = "number: true";
                break;
            case 'email' :
                $value = 'email: true';
                break;
            }
            $end = ($i<sizeof($this->arrayRules)-1)?"},":"}";
            $rules = $rules.$this->arrayRules[$i][1].': {'.$value.$end;
        }

        $this->getSystempay()->add_inline_js(
            "jQuery('.".$form_data["form_css_class"]."').validate({
              rules: {
                ".$rules."
                }
              });
          jQuery.extend(jQuery.validator.messages, {
            required: '".__('This field is requiered', 'ws')."',
            email: '".__('Your email is not valid', 'ws')."',
            number: '".__('This is not a number', 'ws')."'
          });
        ");
    }
    
    public function getCssClass($form_id)
    {
        (int)($form_id);
        $WS_data   = parent::getFormArrayById($form_id);
        $form_data = $WS_data["form_data"];
        return $form_data["form_css_class"];
    }

    public function addRule($type, $value)
    {
        array_push($this->arrayRules, array($type,$value));
        //print_r($this->arrayRules);
    }
    
    public function getFormType($input)
    {
        switch ($input["type"]) {
        case "textarea" : ?> 
            <?php  $required = ($input["required"] == 1)?"required":"";?> 
            <textarea class="textarea-<?php echo $input["name"];?>" class="<?php echo $input["class"] ; ?> <?php echo $required ?>" name="<?php echo $input['name']; ?>"  rows="5" cols="60"><?php echo $input["value"] ;?></textarea>
      <?php 
            break;
        case "radio" : ?> 
            <?php
            $values = split(";", $input["value"]); 
            $values = str_replace(" ", "", $values);
            $options =split(";", $input["options"]);
            $index = 0;
            ?>
            <ul>
            <?php
            foreach ($options as $option) : ?>
                <?php
                $type    = ($input["hide"])?"hidden":"radio";
                $checked = ($values[$index] == '1')?"checked":"";?>
                <?php 
                $optionegal = split("=", $option); ?>
                <li class="<?php echo $input["class"] ; ?>">
                  <input id="radio-<?php echo $input["name"] ; ?>" class="form-radio" type="<?php echo $type ?>" name="<?php echo $input["name"] ; ?>" value="<?php echo $option ?>" <?php  echo $checked;?>/><?php echo $optionegal[0] ?>
                </li>
              <?php
                $index++; 
            endforeach; ?>
            </ul>
       <?php   
            break;
        case "checkbox" : 
            $values = split(";", $input["value"]);         
            $values = str_replace(" ", "", $values);
            $options =split(";", $input["options"]);
            $index = 0; ?>
            <ul>
            <?php
            foreach ($options as $option) :
                $optionegal =split("=", $option);?>
                <li class="<?php echo $input["class"] ; ?>">
                  <?php 
                      $type = ($input["hide"]==1)?"hidden":"checkbox";
                      $checked = ($values[$index] == '1')?"checked":"";
                  ?>
                  <input type="<?php echo $type; ?>" name="<?php echo $input['name'];?>[]" <?php  echo $checked;?> value="<?php echo $option ; ?>"><?php echo $optionegal[0] ; ?>
                </li>
              <?php $index++; 
            endforeach; ?>
            </ul>         
        <?php
            break;
        case "text" :?>
            <input id="text-<?php echo $input["name"] ; ?>" class="<?php echo $input["class"] ; ?> general_input <?php if ($input["required"] == 1 ) { echo 'required';}?>" <?php if ($input["hide"] == 1 ) { echo 'type="hidden"';} else { echo 'type="text"';} ?> name="<?php echo $input["name"] ; ?>" value="<?php echo $input["value"] ;?>" />
      <?php 
            break;
        case "amountentry" :
            break;
        case "numeric" :
            $required  = ($input["required"] == 1) ? "required" : "";
            $class     = $input["class"].' general_input '.$required;
            $type      = ($input["hide"]==1) ? "hidden" : "text";
            $name      = ($input["name"] =="") ? "numeric" : $input["name"]; ?>
            <input id="text-<?php echo $input["name"] ; ?>" class="<?php echo $class ; ?>" type="<?php echo $type; ?>" name="<?php echo $name;?>" value="<?php echo $input["value"] ;?>" />
            <?php $this->addRule("numeric", $name); 
            break;
        case "select" : ?>
            <select name="<?php echo $input["name"];?>" class="<?php echo $input["class"] ; ?>">
            <?php
            $options =split(";", $input["options"]);
            foreach ($options as $option) :
                $optionegal =split("=", $option); ?>
                <option value="<?php echo $option ?>"><?php echo $optionegal[0] ?></option>
            <?php
            endforeach; ?>
            </select>
        <?php
            break;
        case "countrieslist": ?>
            <select name="<?php echo $input["name"];?>" class="<?php echo $input["class"] ; ?>">
            <?php 
            foreach ($this->getSystempay()->getCountries() as $key => $value) :
                if ($input["value"] == $value) {?>
                    <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
            <?php 
                } else { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php
                } ?>
            <?php 
            endforeach; ?>
            </select>
            <?php 
            break;
        case "email": 
            $required = ($input["required"] == 1)?"required":"";
            $type = ($input["hide"]==1)?"hidden":"text"; ?>
            <input id="text-<?php echo $input["name"] ; ?>" class="general_input email <?php echo $required;?> <?php echo $input["class"] ; ?>" type="<?php echo $type; ?>" name="<?php echo $input["name"] ; ?>" value="<?php echo $input["value"] ;?>" />
            <?php
            $this->addRule("email", $input["name"]);
            break;
        }
    }
}
?>