<?php
/*
   error_reporting(-1);
   ini_set('display_errors', 'On');

*/
// header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
require '../twilio-php-master/Services/Twilio.php';
mysql_connect('54.69.118.223', 'pictouser', 'jammer121');
mysql_select_db('mydb'); 


  // $string = substr(str_shuffle(abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ),0, 1) . substr(str_shuffle(aBcEeFgHiJkLmNoPqRstUvWxYz0123456789),0, 31);
  // $code = substr($string, 0, 6);
  // $arr = array('code' => $code);
  // echo json_encode($arr);

  

  $type = $_POST['type'];
  $type();

  function session_check(){
      session_start();
      if(isset($_SESSION['code'])){
        echo 'session_set';
      }
      else{
        echo 'fail'; 
      }
  }


  function status_check(){
           
      session_start();

      $code = $_SESSION['code'];
      $mobile = $_SESSION['mobile'];
      $sql = mysql_query("SELECT * FROM `users` WHERE  `phone` = '$mobile'");
      while($row = mysql_fetch_array($sql)){
          $status = $row['status'];
      }
              echo $status;
    
}
  function sign_in(){

      $mobile = $_POST['mobile'];
      
      $string = substr(str_shuffle(0123456789),0, 1)."-".substr(str_shuffle(0123456789),0, 31);
      $ver_code = substr($string, 0, 6);
      
      $result = mysql_query("SELECT * FROM `users` WHERE `phone` = '$mobile'");
      if(mysql_num_rows($result) == 0) {
      // row not found, do stuff...
         mysql_query("INSERT INTO `users`(`phone`, `verification_code`) VALUES ('$mobile', '$ver_code')");

      } else {
      // do other stuff...
         mysql_query("UPDATE `users` SET `verification_code`='$ver_code' WHERE `phone` = '$mobile' ");
      }
      

         $sid = "AC65f408f0dd0b97b2ca15ff6eeadfd310"; // Your Account SID from www.twilio.com/user/account
         $token = "34e70e70f3793e4fcdc635e6a35a0a7a"; // Your Auth Token from www.twilio.com/user/account

         $client = new Services_Twilio($sid, $token);
         $message = $client->account->messages->sendMessage(
         '441303570130', // From a valid Twilio number
         $mobile, // Text this number
         "ImJammin' - Your Verification Code is : $ver_code."
       );

       print $message->sid;

  } 


  function register(){
    session_start();
      
      
       
       // postdata
       $fullname = $_POST['name'];
       $mobile = $_SESSION['mobile'];
       $avatar = $_POST['avatar'];
       $code = $_SESSION['code'];
      
       $encrypt = hash('sha256', $_POST['mobile']);

       mysql_query("UPDATE `users` SET `name`='$fullname', `avatar`='$avatar', `encrypt` = '$encrypt', `status`='complete' WHERE `verification_code` = '$code'");
       $json = array('function' => 'complete');
       echo json_encode($json); 
  }


   function verify(){
    
      
     
      $code = $_POST['code'];
      $mobile = $_POST['mobile'];
      $result = mysql_query("SELECT * FROM `users` WHERE `phone` = '$mobile' AND `verification_code` = '$code'");
      if(mysql_num_rows($result) == 0) { echo 'fail'; }
      else { 
        session_start();

        $_SESSION['code'] = $code;
        $_SESSION['mobile'] = $mobile;
        // Extend cookie life time by an amount of your liking
        $cookieLifetime = 365 * 24 * 60 * 60; // A year in seconds
        setcookie(session_name(),session_id(),time()+$cookieLifetime);
        $json = array('function' => 'success');
        echo json_encode($json); 
      }
   }





   function search_library(){
      
     
      $obj = array('function' => 'load_search');
      $keyword = $_POST['keyword'];
      $query = mysql_query( "SELECT * FROM music_library WHERE artist LIKE '%$keyword%' OR song LIKE '%$keyword%' OR record_company LIKE '%$keyword%' OR Album LIKE '%$keyword%'"); 
      while($row = mysql_fetch_array($query)){
        $arr = array('info' => $row);
        array_push($obj, $arr);
      }

      echo json_encode($obj);

   }

  function get_contacts(){
      
      $obj = array('function' => 'load_contacts');

	//needs to be changed from 1 to user_id -------------------------------------
	//--------------------------------------------------------------------------
	// --------------------------------------------------------------------------
	// -----------------------------------------------------------|--------------
	//                                                            |
	//                                                            |
	//                                                            |    
	//                                                            |
	//                                                            v   
      $sql_contacts = mysql_query("SELECT * FROM users WHERE id = '1'");
      while($row = mysql_fetch_array($sql_contacts)){
        $friends = $row['friends'];
        $friends_array = explode(',', $friends);
        foreach ($friends_array as $friend){
           $sql_status = mysql_query("SELECT * FROM status_db WHERE user_id = '$friend'");
           while($status = mysql_fetch_array($sql_status)){

               // $status_quote = $status['status'];
               $status_user_id = $status['user_id'];
               $status_track_id = $status['track_id'];

               $user_sql = mysql_query("SELECT avatar,name FROM users WHERE id = '$status_user_id'");
               $user = mysql_fetch_array($user_sql);
               // $user_avatar = $user['avatar'];
               // $user_name = $user['name']; 
         
               $track_sql = mysql_query("SELECT artist, song FROM music_library WHERE id = '$status_track_id'");
               $track_info = mysql_fetch_array($track_sql);
               // $artist = $track_info['artist'];
               // $song = $track_info['song']; 

              $arr = array('status' => $status, 'user' => $user, 'track_info' => $track_info);
              array_push($obj, $arr);
           }
        }
      }
                echo json_encode($obj);
  }

  function get_user_status(){
    session_start();
    $mobile = $_SESSION['mobile'];
    $user_sql = mysql_query("SELECT * FROM `users` WHERE `phone` = '$mobile'");
    $user_row = mysql_fetch_array($user_sql);
    $user_id = $user_row['id'];
    $status_sql = mysql_query("SELECT * FROM `status_db` WHERE `user_id` = '$user_id'");

      if(mysql_num_rows($status_sql) == 0) {
          $arr = array('function' => 'load_new_status');
          
      } else {
      // do other stuff...

        $sql_user = mysql_query("SELECT avatar,name,encrypt FROM users WHERE id = '$user_id'");
        $user =  mysql_fetch_array($sql_user);

        $status_info = mysql_fetch_array($status_sql);
        $status_track_id = $status_info['track_id'];
      
        $track_sql = mysql_query("SELECT * FROM music_library WHERE id = '$status_track_id'");
        $track_info = mysql_fetch_array($track_sql);

        $arr = array('status_info' => $status_info, 'track_info' => $track_info, 'user' => $user, 'function' => 'load_user_status');
      }
    echo json_encode($arr);
  }


  function get_status(){
        $status = $_POST['status'];

        $sql_user = mysql_query("SELECT avatar,name,encrypt FROM users WHERE id = '$status'");
        $user =  mysql_fetch_array($sql_user);

        $sql_status = mysql_query("SELECT * FROM status_db WHERE user_id = '$status'"); 
        $status_info = mysql_fetch_array($sql_status);
        $status_track_id = $status_info['track_id'];
      
        $track_sql = mysql_query("SELECT * FROM music_library WHERE id = '$status_track_id'");
        $track_info = mysql_fetch_array($track_sql);

        $arr = array('status_info' => $status_info, 'track_info' => $track_info, 'user' => $user, 'function' => 'load_status');
        echo json_encode($arr);
  }
  function get_track(){
       $page = $_POST['page'];
       $track = parse_url($page);
       $query = $track['query'];
       parse_str($query);

       $track_sql = mysql_query("SELECT * FROM music_library WHERE id = '$t_id'");
       $track_info = mysql_fetch_array($track_sql);
       
       $arr = array('track' => $track_info, 'function' => 'load_track');
       echo json_encode($arr);
  }

 function get_chats(){
    session_start();
    $mobile = $_SESSION['mobile'];
    $sql = mysql_query("SELECT * FROM `users` WHERE  `phone` = '$mobile'");
    $row = mysql_fetch_array($sql);
    $user_id = $row['id'];
	//needs to be changed from 1 to user_id -----------------------------------
	//-------------------------------------------------------------------------
	// ------------------------------------------------------------------------
	//----------------------------------------------------------|--------------
   //                                                           |
   //                                                           |
   //                                                           |    
   //                                                           |
   //                                                           v   
   $sql_contacts = mysql_query("SELECT * FROM chats WHERE id = '1'");
    ///check if there are any chats!    
   if(mysql_num_rows($sql_contacts) == 0) {
          $arr = array('function' => 'no_chats');
   }
   else{

      while($row = mysql_fetch_array($sql_contacts)){
         

      }
   
   }
      echo json_encode($arr);

 }

function set_status(){
    session_start();
    $mobile = $_SESSION['mobile'];
    $track_id = intval($_POST['track_id']);
    $start =  $_POST['start'];
    $stop = $_POST['end'];
    $status = $_POST['status'];
    
   


    $user_sql = mysql_query("SELECT * FROM `users` WHERE `phone` = '$mobile'");
    $user_row = mysql_fetch_array($user_sql);
    $user_id = $user_row['id'];
    $user_key = $user_row['encrypt'];
    
    $status_sql = mysql_query("SELECT * FROM `status_db` WHERE `user_id` = '$user_id'");
    
    
    
    

      if(mysql_num_rows($status_sql) == 0) {
         // row not found, do stuff...
         mysql_query("INSERT INTO `status_db`(`track_id`, `start`, `stop`, `status`, `user_id`) VALUES ('$track_id', '$start', '$stop', '$status', '$user_id')");

      } else {
        // do other stuff...
        mysql_query("UPDATE `status_db` SET `track_id` ='$track_id', `start` = '$start', `stop` = '$stop', `status` = '$status' WHERE `user_id` = '$user_id'");

      } 
      
     $track_sql  = mysql_query("SELECT * FROM `music_library` WHERE `id`='$track_id'") or die(mysql_error());  
     $track_row = mysql_fetch_array($track_sql);
     $song = $track_row['file'];
     $start =  gmdate("H:i:s", $start);
     $stop =  gmdate("H:i:s", $stop);
     
     
     shell_exec("ffmpeg -i /var/www/html/media/$song -ss $start -t 00:00:20 -async 1 -strict -2 /var/www/html/user_status/$user_key.mp4"); 
 
    $arr = array('function' => 'status_complete');
    echo json_encode($arr);      
}





?>
