<div class="ws_warp">
  <div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><div class="page_title"><h1><?php _e("Transactions","ws"); ?>  </h1></div>
  <div class="cb"></div>
  <table id="transactions_table" class="table wp-list-table widefat fixed pages">
    <thead>
      <tr>
        <th><?php _e("id", "ws"); ?></th>
        <th><?php _e("Date", "ws"); ?></th>
        <th><?php _e("Statut", "ws"); ?></th>
        <th class="amount"><?php _e("Amount", "ws"); ?></th>
        <th><?php _e("Name", "ws"); ?></th>
        <th><?php _e("Address", "ws"); ?></th>
        <th><?php _e("Zip", "ws"); ?></th>
        <th><?php _e("City", "ws"); ?></th>
        <th><?php _e("Phone", "ws"); ?></th>
        <th><?php _e("Email", "ws"); ?></th>
        <th class="action"><?php _e("Actions", "ws"); ?></th>
      </tr>
    </thead>
    <tbody>
    <?php
      function selectByIdOrURL($array, $data) {
          foreach($array as $row) {
              if($row['label'] == $data || $row['url'] == $data) return $row;
          }
          return NULL;
      }
      $count=0;
      foreach ($transactions as $transaction_data) : $count++;?>
      <tr class="<?php echo ($count%2==0) ? 'even' : 'odd';?>">
        <?php $infos = json_decode($transaction_data->transaction_otherinfos_json);?>
        <td><?php echo $transaction_data->transaction_order_id;?></td>
        <td><?php echo $transaction_data->transaction_command_date;?></td>
        <td><?php echo $transaction_data->transaction_command_statut;?></td>
        <td class="amount"><?php echo $transaction_data->transaction_command_amount.' '.$transaction_data->transaction_command_currency;?></td>
        <td><?php echo $transaction_data->transaction_customer_name;?></td>
        <td><?php echo $transaction_data->transaction_customer_address;?></td>
        <td><?php echo $transaction_data->transaction_customer_zip;?></td>
        <td><?php echo $transaction_data->transaction_customer_city;?></td>
        <td><?php if (!empty($transaction_data->transaction_customer_cellphone)) {
                      echo $transaction_data->transaction_customer_cellphone;
                  }
                  elseif (!empty($transaction_data->transaction_customer_phone)) {
                      echo $transaction_data->transaction_customer_phone;
                  } ?></td>
        <td><a href="mailto:<?php echo $transaction_data->transaction_customer_email; ?>"><?php echo $transaction_data->transaction_customer_email;?></a></td>
        <td class="action"><a class="btn btn-infos" href="?page=<?php echo $this->_transactionDetailsPageName;?>&transaction_id=<?php echo $transaction_data->transaction_id; ?>"><?php _e("Details", "ws"); ?></a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
  <?php 
    $options = '
          "sPaginationType": "full_numbers"
          ,"bLengthChange": false
          ,"iDisplayLength": 20
          ,"oLanguage": {
              "oPaginate": {
              "sNext": "&#155;"
             ,"sPrevious": "&#139;"
             ,"sLast": "&#155;&#155;"
             ,"sFirst": "&#139;&#139;"
            }
          }';
    $this->WS->add_inline_js("jQuery('#transactions_table').dataTable({".$options."});")
  ?>