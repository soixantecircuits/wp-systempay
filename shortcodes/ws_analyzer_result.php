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
    $Updater = new WSSystempayTransactionUpdater();
    $Updater->updateTransaction();
    $Updater->showResult();
}
?>