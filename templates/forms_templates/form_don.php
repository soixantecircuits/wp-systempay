        <form id="form_don" method="POST" class="<?php echo $this->getCssClass($form_id);?>" action="<?php echo $this->get_confirmationpage_url($form_id); ?>">
        <!-- Le slide du don-->
            <div class="title_phase" id="don_phaseone">
                <p>1. <?php _e("Amount of your donation","ws"); ?> </p>
            </div>
            <div id="donbox">
              <div id="setMoney">
                <p class="alignleft"><input type="text" id="donbox_input" value="50" onKeyUp="donPage.CalculDeduction();" name="vads_amount"/><strong class="currency">&#8364;</strong></p>
                <p class="deduction"><?php _e("Amount after deduction","ws"); ?> : <strong id="firstDeductionIndicator">x,xx</strong> &#8364;</p><div class="clearfix"></div>
                <p><input type="button" onClick="donPage.MoneyInfo();" class="don_continuer" value="<?php _e('Continue',"ws"); ?>" /></p>
              </div>
              <div id="moneyInfo" >
                <input type="hidden" id="don_deduction" value="0"/>
                <p id="modify"><a href="javascript:donPage.SetMoney();"><?php _e("Change the amount","ws"); ?></a></p>
                <p><strong id="moneyIndicator">50</strong><strong>&#8364;</strong> - <?php _e("Amount after deduction","ws"); ?> <strong id="secondDeductionIndicator">17</strong><strong>&#8364;</strong></p>
              </div>
            </div>
            <div class="cb"></div>
            <br/>
            <div class="title_phase" id="don_phasetwo">
              <p>2. <?php _e("Infos","ws"); ?></p>
            </div>
            <div id="don_formulairebox">
              <div class="general_form">
                
              <?php foreach ($additionalsinputs_data as $groupe) : ?>
                  <table>
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
                         
                  </table><br>
                <?php endforeach; ?>
                  <div class="submit_box">
                   <input type="submit" class="don_continuer" value="<?php _e('Continue',"ws"); ?>" />
                  </div>
                </div>
            </div>
            
            <div class="cb"></div>
            <?php wp_reset_query(); ?>
            <div class="title_phase">
              <p>3.<?php _e('Conditions',"ws");?></p>
            </div>
        </form><br><br>