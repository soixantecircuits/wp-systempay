<?php
/**
 * WS_Add_result add result to the database 
 */
function WS_Add_result($atts, $content)
{
    $ws = new WS();
    $ResultManager = new WSSystempayAnalyzer($ws);
    return $ResultManager->showResult();
}
?>