<?php
 
  //generate verification code :

  $string = substr(str_shuffle(abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ),0, 1) . substr(str_shuffle(aBcEeFgHiJkLmNoPqRstUvWxYz0123456789),0, 31);
  $code = substr($string, 0, 6);
  $arr = array('code' => $code);
  echo json_encode($arr);
  
?>
