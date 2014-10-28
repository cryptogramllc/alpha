<?php
 
  //generate verification code :

  // $string = substr(str_shuffle(abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ),0, 1) . substr(str_shuffle(aBcEeFgHiJkLmNoPqRstUvWxYz0123456789),0, 31);
  // $code = substr($string, 0, 6);
  // $arr = array('code' => $code);
  // echo json_encode($arr);
  

  $type = $_POST['type'];

  $type();

  function signin(){

  } 


  function register(){
    
     $name = $_POST['name'];
     $email = hash('sha256', $_POST['email']);
     $phone = $_POST['phone'];
     $password = hash('sha256', $_POST['password']);
     $confirm = hash('sha256', $_POST['confirm']);
     $avatar = $_POST['avatar'];
    	

     



  }


















?>
