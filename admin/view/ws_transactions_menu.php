<div class="ws_warp">
  <div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><div class="page_title"><h1><?php _e("Transactions menu","ws"); ?></h1></div>
  <div class="cb"></div>
  <div class="alert alert-info"><p><?php _e('If the desired group does not appear, please make a new transaction (step needed is when you are redirect the payment platform, no need to go further).<br/> If the problem persist, go to the table SQL transactions, look transaction_form_id corresponding to the desired form and just change the "transaction_form_name" of one of its transactions.',"WS"); ?></p></div>
  <table class="table wp-list-table widefat fixed pages" >
    <thead>
      <tr>
        <th><?php _e("ID", "ws"); ?></th>
        <th><?php _e("Nom", "ws"); ?></th>
        <th><?php _e("Total transactions", "ws"); ?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($groupeList as $groupe) :?>
      <tr>
        <td>
          <p class="transaction_form_id"><?php echo $groupe->transaction_form_id;?></p>
        </td>
        <td class="post-title page-title column-title">
          <a href="?page=<?php echo $this->_transactionsPageName;?>&WS_id=<?php echo $groupe->transaction_form_id; ?>">
            <?php echo $groupe->transaction_form_name;?>
          </a>
        </td>
        <td class="post-title page-title column-title">
          <a href="?page=<?php echo $this->_transactionsPageName;?>&WS_id=<?php echo $groupe->transaction_form_id; ?>">
            <?php echo $groupe->transaction_total;?>
          </a>
        </td>
      </tr>
    <?php endforeach;?>
    </tbody>
  </table>
</div>