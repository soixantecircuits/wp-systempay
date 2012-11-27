<form class="<?php echo $this->getCssClass($form_id);?>" method="POST" action="<?php echo $this->getSystempay()->get_confirmationpage_url($form_id); ?>">
<table class="wp-systempay">
<tr>
      <td class="general_label"><?php _e("Montant", "ws");?></td>
      <td><p class="alignleft"><input type="text" id="donation_box" value="50" name="vads_amount"/><strong class="currency">&#8364;</strong></p>
      </td>
    </tr>
</table>
<table class="wp-systempay">
<?php
  foreach ($additionalsinputs_data as $groupe) :?>
<?php foreach($groupe as $input): 
    (bool)($input["hide"]);
    if ((!empty($input["name"])) && (!$input["hide"])) : ?>
    <tr>
      <td class="general_label"><label for="<?php echo $input['name']; ?>"><?php echo $input['label']; ?></label></td>
      <td >
        <?php $this->getFormType($input,0); ?>
      </td>
    </tr>
  <?php endif; ?>
<?php   endforeach; ?>
<?php endforeach; ?>
  </table>
  <div class="wp-systempay submit-box">
     <input type="submit" class="wp-systempay-continue" value="<?php _e('Continue', "ws"); ?>" />
  </div>
</form>