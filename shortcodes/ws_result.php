<?php
/**
 * WS_Add_result add result to the database 
 */
function WS_Add_result($atts, $content)
{
    $ResultManager = new WSSystempayAnalyzer();
    $ResultManager->showResult();
}
?>