<?php
     mysql_connect('54.69.118.223', 'pictouser', 'jammer121');
	mysql_select_db('mydb'); 
		    
   

    $function = $_POST['functionType'];
    $function();
   
 
    function flightFinder(){
		$departDate = $_POST['departDate'];
		$returnDate = $_POST['returnDate'];

		$sql_depart = mysql_query("SELECT * FROM `Flights` WHERE `DATE` LIKE '%$departDate%'");
		$sql_return = mysql_query("SELECT * FROM `Flights` WHERE `DATE` LIKe '%$returnDate%'");

		$depart_info  = mysql_fetch_array($sql_depart);
		$return_info  = mysql_fetch_array($sql_return);
		
		$flyTo = $_POST['flyTo'];
		$flyFrom = $_POST['flyFrom'];

		$inbound = $return_info['IN'];
		$outbound = $depart_info['OUT'];   

		$in_avail = $inbound > 0 ? 'true' : 'false';
		$out_avail = $outbound > 0 ? 'true' : 'false';
        
   
		$depart_date =  strtotime($depart_info['DATE']);
		$depart_month = date("F", $depart_date);
		$depart_year = date('Y', $depart_date);


		$return_date =  strtotime($return_info['DATE']);
		$return_month = date("F", $return_date);
		$return_year = date('Y', $return_date);

         
		$month_sql_depart = mysql_query("SELECT * FROM `Flights` WHERE `MONTH` = '$depart_month' AND `YEAR` = '$depart_year'") or die(mysql_error());
        $month_sql_return = mysql_query("SELECT * FROM `Flights` WHERE `MONTH` = '$return_month' AND `YEAR` = '$return_year'") or die(mysql_error());

        
        $depart_array = array();
        while($depart_row_info = mysql_fetch_array($month_sql_depart)){
              array_push($depart_array, $depart_row_info);
        }

        $return_array = array();
        while($return_row_info = mysql_fetch_array($month_sql_return)){
			  array_push($return_array, $return_row_info);
        }

		$array = array('in_avail' => $in_avail, 'out_avail' => $out_avail, 'departMonth' => $depart_array, 'returnMonth' => $return_array, 'flyTo' => $flyTo, 'flyFrom' => $flyFrom);
        echo json_encode($array);    
   }



   

    // $peak_array = ['peak', 'offpeak']; 

    // for($i = 2015; $i <= 2016; $i++){
    //         for($j = 1; $j <= 12; $j++){
    //         	    for($k = 1; $k <= 31; $k++){
    //         	    	$inbound =  rand(0, 5);
    //         	    	$outbound =  rand(0, 5);
    //         	    	$peak_type = rand(0,1);
    //         	    	$peak = $peak_array[$peak_type];
    //         	    	$month = $j  < 10 ? '0'. $j : $j;
    //         	    	$day = $k  < 10 ? '0'. $k : $k;
    //         	    	$year  = $i;
    //         	    	$date = $year.'-'.$month.'-'.$day;
				// 		mysql_query("INSERT INTO `FLIGHTS` (`INBOUND`, `OUTBOUND`, `TYPE`, `DATE`) VALUES ('$inbound', '$outbound', '$peak', '$date')") or die(mysql_error());  	
    //         	    }
    //         }
    // }
      




    //  for($i = 1; $i < 13; $i++){
    //        $rand =  rand(0, 30);
    //        $month = ($i <= 9 ? '0'. $i : $i);
    //        $year = '2015';
    //        mysql_query("INSERT INTO FLIGHTS (`PEAK`, `OFFPEAK`, `MONTH`, `YEAR`) VALUES ('$rand', '$rand', '$month', '$year')") or die(mysql_error());
    //  }

   // function alter(){
   //     $sql = mysql_query("SELECT * FROM `flights`") or die(mysql_error());
   //     while($row = mysql_fetch_array($sql)){
   //           //$month = calendar($row['month']);
   //           //echo $month;
   //            $date =  strtotime($row['DATE']);
   //            $month = date("F", $date);
   //            $id = $row['id']; 
   //            echo $id . ': '. $month . '</br>';
            
   //            mysql_query("UPDATE `FLIGHTS` SET `month` = '$month' WHERE `id` =  '$id'") or die(mysql_error());  
   //      }         
    
       // mysql_query("UPDATE `FLIGHTS` SET `month` = '$month'") or die(mysql_error());  	

    // $peak_array = ['peak', 'offpeak']; 

    // for($i = 2015; $i <= 2016; $i++){
    //         for($j = 1; $j <= 12; $j++){
    //         	    for($k = 1; $k <= 31; $k++){
    //         	    	$inbound =  rand(0, 5);
    //         	    	$outbound =  rand(0, 5);
    //         	    	$peak_type = rand(0,1);
    //         	    	$peak = $peak_array[$peak_type];
    //         	    	$month = $j  < 10 ? '0'. $j : $j;
    //         	    	$day = $k  < 10 ? '0'. $k : $k;
    //         	    	$year  = $i;
    //         	    	$date = $year.'-'.$month.'-'.$day;
				// 		mysql_query("INSERT INTO `FLIGHTS` (`INBOUND`, `OUTBOUND`, `TYPE`, `DATE`) VALUES ('$inbound', '$outbound', '$peak', '$date')") or die(mysql_error());  	
    //         	    }
    //         }
    // }
      




    //  for($i = 1; $i < 13; $i++){
    //        $rand =  rand(0, 30);
    //        $month = ($i <= 9 ? '0'. $i : $i);
    //        $year = '2015';
    //        mysql_query("INSERT INTO FLIGHTS (`PEAK`, `OFFPEAK`, `MONTH`, `YEAR`) VALUES ('$rand', '$rand', '$month', '$year')") or die(mysql_error());
    //  }
   //}
?>