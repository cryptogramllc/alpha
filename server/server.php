<?php

  
  // $string = substr(str_shuffle(abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ),0, 1) . substr(str_shuffle(aBcEeFgHiJkLmNoPqRstUvWxYz0123456789),0, 31);
  // $code = substr($string, 0, 6);
  // $arr = array('code' => $code);
  // echo json_encode($arr);
  

  $type = $_POST['type'];
  $type();

  function sign_in(){
      mysql_connect('54.69.118.223', 'pictouser', 'jammer121'); 
      mysql_select_db('mydb');
      
      $mobile = $_POST['mobile'];
      
      $string = substr(str_shuffle(abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ),0, 1) . substr(str_shuffle(aBcEeFgHiJkLmNoPqRstUvWxYz0123456789),0, 31);
      $ver_code = substr($string, 0, 6);
     
  } 


  function register(){
       mysql_connect('54.69.118.223', 'pictouser', 'jammer121'); 
       mysql_select_db('mydb');
       
       // postdata
       $fullname = $_POST['name'];
       $email = hash('sha256', $_POST['email']);
       $phone = $_POST['mobile'];
       $password = hash('sha256', $_POST['password']);
       $confirm = hash('sha256', $_POST['confirm']);
       $avatar = $_POST['avatar'];

      //generate verification code :
       $string = substr(str_shuffle(abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ),0, 1) . substr(str_shuffle(aBcEeFgHiJkLmNoPqRstUvWxYz0123456789),0, 31);
       $ver_code = substr($string, 0, 6);
      
       mysql_query("INSERT INTO `users`(`name`, `email`, `phone`, `password`, `verification_code`, `avatar`) VALUES('$fullname', '$email', '$phone', '$password', '$ver_code', '$avatar')");
     
     
	 // mysql_query()
     

      

  }


















?>
