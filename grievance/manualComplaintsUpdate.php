<?php


		
	
        $conn= mysqli_connect("127.0.0.1", "municipa_csms", "ipDa6sS!cQuv", 'municipa_csms') or die(mysqli_connect_error());
        
       $sql ="SELECT * FROM `grievances` WHERE `grievance_status_id` = 2 AND `ulbid` LIKE '207' and DATE(date_regd) <= '2020-12-31' and app_type_id='1'";
       exit;
       $rs = mysqli_query($conn,$sql);
       while($row = mysqli_fetch_assoc($rs))
       {
           $sql ="SELECT * FROM `grievances_transactions` where grievance_id='".$row['grievance_id']."'";
           $rs2 = mysqli_query($conn,$sql);
           $row2 = mysqli_fetch_assoc($rs2);
           $stop_date = date('Y-m-d H:i:s', strtotime($row2['alloted_date'] . ' +1 day'));
           echo $row2['grievance_id']. "-".$row2['alloted_date']."-".$stop_date;
           echo "<br>";
           
           echo $sql ="update grievances_transactions set disposal_status='9' , disposed_date='".$stop_date."',ManualCompletedStatus='3',updated_by='Boduppal' where grievance_id='".$row['grievance_id']."'";
           echo "<br>";
           echo $sql2 = "update grievances set grievance_status_id='9', ManualCompletedStatus='3',sla_status='1' where grievance_id='".$row['grievance_id']."'";
           echo "<br>";
           mysqli_query($conn,$sql);
            mysqli_query($conn,$sql2);
           
       }
	      
	    
	
?>