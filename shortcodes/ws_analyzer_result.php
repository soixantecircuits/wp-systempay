<?php
/**
 * WS_Add_Server_result Update the transaction result
 * 
 * @param empty
 * 
 * @return void 
 */

function WS_Add_Server_result()
{
    $ws = new WS();
    $Updater = new WSSystempayTransactionUpdater($ws);
    $Updater->updateTransaction();
    return $Updater->showResult();
}
?>