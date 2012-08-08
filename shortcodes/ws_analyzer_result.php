<?php 
function add_ws_server_result(){
	$Updater= new  WSSystempayTransactionUpdater();
	$Updater->updateTransaction();
	$Updater->showResult();
}

?>