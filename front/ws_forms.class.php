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
        $themes_form_template = "/plugins/wp-systempay/templates/forms_templates";
        if (file_exists(get_stylesheet_directory().$themes_form_template."/styles.css") ) {
        		wp_enqueue_style('WS_template_css', get_bloginfo("stylesheet_directory").$themes_form_template."/styles.css");
        } else {
        		wp_enqueue_style('WS_template_css', plugins_url( '../css/templates/styles.css', __FILE__ ));
      	}
        wp_enqueue_script('wp_footer', plugins_url( '../inc/jquery.validate.min.js', __FILE__ ));
        $WS_data   = parent::getFormArrayById($form_id);
        $form_data = $WS_data["form_data"];
        $additionalsinputs_data = $WS_data["inputs_data"];

        $additionalsinputs_data = $this->prepare_data($additionalsinputs_data);

        if ($template) {
            if (file_exists(get_stylesheet_directory().$themes_form_template."/".$template) ) {
                $path = get_stylesheet_directory().$themes_form_template."/".$template ;
            } else if (file_exists(dirname(__FILE__)."/../templates/forms_templates/".$template) ) {
                $path = dirname(__FILE__)."/../templates/forms_templates/".$template; 
            } else {
                //Should throw a warning
                $path = dirname(__FILE__)."/../templates/forms_templates/default_form.php";  
            }
        } else {
            if (file_exists(get_stylesheet_directory().$themes_form_template."/default_form.php") ) {
                $path = get_stylesheet_directory().$themes_form_template."/default_form.php";
            } else {
                $path = dirname(__FILE__)."/../templates/forms_templates/default_form.php"; 
            }       
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
            "var validatorForm = jQuery('.".$form_data["form_css_class"]."').validate({
              errorClass: 'error',
              validClass: 'valid',
              rules: {
                ".$rules."
                }
              });
//            jQuery('#vads_amount').rules('add', {
//                minlength: 1,
//                number: true
//            });
          jQuery.extend(jQuery.validator.messages, {
            required: '".esc_attr(__('This field is requiered', 'ws'))."',
            email: '".esc_attr(__('Your email is not valid', 'ws'))."',
            number: '".esc_attr(__('This is not a number', 'ws'))."'
          });
        ");

        if (file_exists($path)) {
            ob_start(); 
            include_once $path;
            $form_render = ob_get_clean(); 
            return $form_render;
        } else {
            return __("No template file found", "ws");
        }
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
    }
    
    public function getFormType($input, $placeholder=false)
    {
        switch ($input["type"]) {
        case "textarea" : ?> 
            <?php  $required = ($input["required"] == 1)?"required":"";?> 
            <textarea class="textarea-<?php echo $input["name"];?>" class="<?php echo $input["class"] ; ?> <?php echo $required ?>" name="<?php echo $input['name']; ?>"  rows="5" cols="60"><?php echo $input["value"] ;?></textarea>
      <?php 
            break;
        case "radio" : ?> 
            <?php
            $value = $input["value"];
            $options = split(";", $input["options"]);
            $index = 0;
            ?>
            <?php
            foreach ($options as $option) : ?>
                <?php
                $type       = ($input["hide"])?"hidden":"radio";
                $optionegal = split("=", $option);
                $checked    = ($optionegal[1] == $value)? "checked" : "";
                ?>
                <label class = 'radio <?php echo $input["class"];?>'>
                  <input id = "radio-<?php echo $input["name"] ; ?>" class="form-radio <?php echo $input["class"] ; ?>" type = "<?php echo $type ?>" name = "<?php echo $input["name"] ; ?>" value = "<?php echo $optionegal[1]; ?>" <?php echo $checked;?>>
                  <?php echo $optionegal[0] ?>
                </label>
              <?php
                $index++; 
            endforeach; ?>
       <?php   
            break;
        case "checkbox" : 
            $values  = split(";", $input["value"]);         
            $values  = str_replace(" ", "", $values);
            $options = split(";", $input["options"]);
            $index = 0; ?>
            <?php
            foreach ($options as $option) :
                      $type = ($input["hide"]==1)?"hidden":"checkbox";
                      $optionegal = split("=", $option);
                      $checked = ($values[$index] == '1')?"checked":"";
                  ?>
                  <label class="checkbox <?php echo $input["class"];?>">
                  <input class="form-checkbox <?php echo $input["class"] ; ?>" type="<?php echo $type; ?>" name="<?php echo $input['name'];?>[]" <?php  echo $checked;?> value="<?php echo $optionegal[1] ; ?>">
                  <?php echo $optionegal[0] ; ?>
                  </label>
              <?php $index++; 
            endforeach; ?>
        <?php
            break;
        case "text" :?>
            <input id="text-<?php echo $input["name"] ; ?>" <?php if($placeholder):echo 'placeholder="'.$input["label"].'"'; endif; ?> class="<?php echo $input["class"] ; ?> general_input <?php if ($input["required"] == 1 ) { echo 'required';}?>" <?php if ($input["hide"] == 1 ) { echo 'type="hidden"';} else { echo 'type="text"';} ?> name="<?php echo $input["name"] ; ?>" value="<?php echo $input["value"] ;?>" />
      <?php 
            break;
        case "amountentry" :
            break;
        case "numeric" :
            $required  = ($input["required"] == 1) ? "required" : "";
            $class     = $input["class"].' general_input '.$required;
            $type      = ($input["hide"]==1) ? "hidden" : "number";
            $name      = ($input["name"] =="") ? "numeric" : $input["name"]; ?>
            <input id="text-<?php echo $input["name"] ; ?>" <?php if($placeholder):echo 'placeholder="'.$input["label"].'"'; endif; ?> class="<?php echo $class ; ?>" type="<?php echo $type; ?>" name="<?php echo $name;?>" value="<?php echo $input["value"] ;?>" />
            <?php $this->addRule("numeric", $name); 
            break;
        case "select" : ?>
            <select name="<?php echo $input["name"];?>" class="<?php echo $input["class"] ; ?>">
            <?php
            $value = $input["value"];
            $options = split(";", $input["options"]);
            foreach ($options as $option) :
                $optionegal = split("=", $option);
                $selected    = ($optionegal[1] == $value)? "selected" : "";
                ?>
                <option value="<?php echo $optionegal[1] ?>" <?php echo $selected ?>><?php echo $optionegal[0] ?></option>
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
                } else {?>
                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php
                }?>
            <?php 
            endforeach;?>
            </select>
            <?php 
            break;
        case "email": 
            $required = ($input["required"] == 1)?"required":"";
            $type = ($input["hide"]==1)?"hidden":"eamil"; ?>
            <input id="text-<?php echo $input["name"] ; ?>" <?php if($placeholder):echo 'placeholder="'.$input["label"].'"'; endif; ?> class="general_input email <?php echo $required;?> <?php echo $input["class"] ; ?>" type="<?php echo $type; ?>" name="<?php echo $input["name"] ; ?>" value="<?php echo $input["value"] ;?>" />
            <?php
            $this->addRule("email", $input["name"]);
            break;
        }
    }
}
?>