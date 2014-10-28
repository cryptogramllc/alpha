<?php
 error_reporting(-1);
ini_set('display_errors', 'On');


  
  // $string = substr(str_shuffle(abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ),0, 1) . substr(str_shuffle(aBcEeFgHiJkLmNoPqRstUvWxYz0123456789),0, 31);
  // $code = substr($string, 0, 6);
  // $arr = array('code' => $code);
  // echo json_encode($arr);
  

  $type = $_POST['type'];
  $type();

  function signin(){
     


  } 


  function register(){
       mysql_connect('54.69.118.223', 'pictouser', 'jammer121'); 
       mysql_select_db('mydb');
     //postdata
   //  $fullname = $_POST['name'];
     //$email = hash('sha256', $_POST['email']);
    // $phone = $_POST['phone'];
    // $password = hash('sha256', $_POST['password']);
    // $confirm = hash('sha256', $_POST['confirm']);
      
     
     $name = ''; $type = ''; $size = ''; $error = '';
	  function compress_image($source_url, $destination_url, $quality) {

		$info = getimagesize($source_url);

    		if ($info['mime'] == 'image/jpeg')
        			$image = imagecreatefromjpeg($source_url);

    		elseif ($info['mime'] == 'image/gif')
        			$image = imagecreatefromgif($source_url);

   		elseif ($info['mime'] == 'image/png')
        			$image = imagecreatefrompng($source_url);

    		imagejpeg($image, $destination_url, $quality);
		return $destination_url;
	}



    		if ($_FILES["avatar"]["error"] > 0) {
        			$error = $_FILES["avatar"]["error"];
    		} 
    		else if (($_FILES["avatar"]["type"] == "image/gif") || 
			($_FILES["avatar"]["type"] == "image/jpeg") || 
			($_FILES["avatar"]["type"] == "image/png") || 
			($_FILES["avatar"]["type"] == "image/pjpeg")) {

        			$url = '/media/'. $email .'/avatar.jpg';

        			$filename = compress_image($_FILES["avatar"]["tmp_name"], $url, 80);
        			$buffer = file_get_contents($url);

        			/* Force download dialog... */
        			header("Content-Type: application/force-download");
        			header("Content-Type: application/octet-stream");
        			header("Content-Type: application/download");

			/* Don't allow caching... */
        			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

        			/* Set data type, size and filename */
        			header("Content-Type: application/octet-stream");
        			header("Content-Transfer-Encoding: binary");
        			header("Content-Length: " . strlen($buffer));
        			header("Content-Disposition: attachment; filename=$url");

        			/* Send our avatar... */
        			echo $buffer;
    		}else {
        			$error = "Uploaded image should be jpg or gif or png";
    		}


			

     //generate verification code :
	// $string = substr(str_shuffle(abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ),0, 1) . substr(str_shuffle(aBcEeFgHiJkLmNoPqRstUvWxYz0123456789),0, 31);
	// $ver_code = substr($string, 0, 6);







	 // mysql_query()
     

      

  }


















?>
