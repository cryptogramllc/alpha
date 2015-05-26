<?php
    
    mysql_connect('54.69.118.223', 'pictouser', 'jammer121');
	mysql_select_db('mydb'); 
	
	
	$sql = mysql_query('SELECT * FROM `Flights`');
	$cabin_array = array('economy', 'world', 'business', 'first');		    

	while($row = mysql_fetch_array($sql)){
		$class_type = rand(0,3);
		$class = $cabin_array[$class_type];	 
		$id = $row['id'];
	   
	    mysql_query("UPDATE `Flights` SET `CABIN` = '$class' WHERE `id` = '$id'") or die(mysql_error());   	
	}
    	    

     /*
$peak_array = array('peak', 'offpeak'); 
     for($i = 2015; $i <= 2016; $i++){
             for($j = 1; $j <= 12; $j++){
             	    for($k = 1; $k <= 31; $k++){
             	    	$inbound =  rand(0, 5);
             	    	$outbound =  rand(0, 5);
             	    	$peak_type = rand(0,1);
             	    	$peak = $peak_array[$peak_type];
             	    	$month = $j  < 10 ? '0'. $j : $j;
             	    	$day = $k  < 10 ? '0'. $k : $k;
             	    	$year  = $i;
             	    	$dateString = $year.'-'.$month.'-'.$day;
             	    	$date =  strtotime($dateString);
			            $month = date("F", $date);
			            $dateStamp = date('Y-m-d', $date);
				 		mysql_query("INSERT INTO `Flights`(`IN`, `OUT`, `MONTH`, `YEAR`, `TYPE`, `DATE`) VALUES ('$inbound', '$outbound', '$month', '$year', '$peak', '$dateStamp')") or die(mysql_error()); 
/* 				 		echo $inbound." : ".$outbound." : ".$month." : ".$year." : ".$peak." : ".$dateStamp.'<br />'; 
				 		 	
            	    }
             }
     }
*/
      


?>