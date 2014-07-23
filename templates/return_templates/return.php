<?php
  if(isMobile()){
    $prepend = "?mobile=true";
  }
  if($this->get_or_post("vads_result") == "00"){
    $message = __("Back to the donation page", "ws");
  } else {
    $message = __("Let's try another time.", "ws");
  }

?>
<a class="don_continuer" href="http://ela-asso.com/soutenez-ela/dons-en-ligne/<?php echo $prepend ?>"><?php echo $message;?></a>
