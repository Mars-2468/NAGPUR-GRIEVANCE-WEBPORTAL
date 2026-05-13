<?php
error_reporting(0);
require_once('connection.php');
$conn=getconnection();


$sql = "select * from ulbmst where ulbid = '001' " ;

//$sql ="select * from ulbmst where ulbid != '500' ";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    
     
     /**** total received ******/
   
   
   
    
     $sql1="SELECT count(grievance_id) as received,app_type_id FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$row['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and c.cs_id = '32' ";
    
        $res1=mysqli_query($conn,$sql1);
        $row1=mysqli_fetch_assoc($res1);
        $received = $row1['received'];
    
    
   echo $sql2 = "update complaints_cat_count set Door_to_door_Collection = '".$received."' where ulbid = '".$row['ulbid']."' and status = '1' " ;
       $result=mysqli_query($conn,$sql2);
    
    
    
    
        
  /*****  pending for approval *******/
  
  
  
  
  $sqll1="SELECT count(grievance_id) as approval,app_type_id FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$row['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and c.cs_id = '32' and grievance_status_id='1'";
    
        $res11=mysqli_query($conn,$sqll1);
        $row11=mysqli_fetch_assoc($res11);
        $approval = $row11['approval'];
    
    
       
       $sql2 = "update complaints_cat_count set Door_to_door_Collection = '".$approval."' where ulbid = '".$row['ulbid']."' and status = '2' " ;
       $result=mysqli_query($conn,$sql2);
  
  
  
    
     
  
  /************  completed within sla and beyond sla  ***************/
  
  
		               
		               
		               $comp_completed_withinsla=0;
		               $comp_completed_beyondsla=0;
		               
		               
        		  $sql5="select g.grievance_id,app_type_id,cat3_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,
				  ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and 
				  g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','10','4','9')  and gt.disposal_status !=5 and 
				  g.ulbid='".$row['ulbid']."' and g.app_type_id='1' and cat3_id = '32' ";
        			  
        		 $res5=mysqli_query($conn,$sql5);
        		 while($row5 = mysqli_fetch_assoc($res5))
				 {
				     if($row5['target'] <= $row5['target_days'])
					 {
					     $comp_completed_withinsla +=1;
					 }
					 else
					 {
					    $comp_completed_beyondsla +=1;
					 }
					 
				 } 
  
    
     $sql21 = "update complaints_cat_count set Door_to_door_Collection = '".$comp_completed_withinsla."' where ulbid = '".$row['ulbid']."' and status = '3' " ;
       $result21=mysqli_query($conn,$sql21);
    
     
        $sql31 = "update complaints_cat_count set Door_to_door_Collection = '".$comp_completed_beyondsla."' where ulbid = '".$row['ulbid']."' and status = '4' " ;
       $result31=mysqli_query($conn,$sql31);
    
    
    
    
  
  
   
      /******* Under progress with in SLA and beyond SLA   ****************************/
        	
        	$comp_pending_withinsla=0;
        	$comp_pending_beyondsla=0;
        		
        		
        		                         // complaint 
        		  
        		$sql7="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(NOW(),date_regd) AS target,ccm.cutt_off_time as target_days from grievances g , 
				 grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
				 g.grievance_status_id NOT IN('3','6','8','10','4','11','9') and gt.disposal_status !=5 and g.ulbid='".$row['ulbid']."' and app_type_id='1'
				 and cat3_id = '32' ";
        		
                    	 $res7=mysqli_query($conn,$sql7);
            		     while($row7 = mysqli_fetch_assoc($res7))
    				     {
        				     if($row7['target'] <= $row7['target_days'])
        					 {
        					    $comp_pending_withinsla +=1;
        					 }
        					 else
        					 {
        					    $comp_pending_beyondsla +=1;
        					 }
    					 
    				      }
      
    
     $sql41 = "update complaints_cat_count set Door_to_door_Collection = '".$comp_pending_withinsla."' where ulbid = '".$row['ulbid']."' and status = '5' " ;
       $result41=mysqli_query($conn,$sql41);
    
     
        $sql42 = "update complaints_cat_count set Door_to_door_Collection = '".$comp_pending_beyondsla."' where ulbid = '".$row['ulbid']."' and status = '6' " ;
       $result42=mysqli_query($conn,$sql42);
    
    
    
     
    /********** Finacial implications ****************/ 
        			
        		
        $sql9="select count(g.grievance_id) as fin_implication,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g ,
        grievances_transactions gt,comp_cutofdays_map c,ulbmst u where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid=u.ulbid and 
        g.grievance_status_id IN('6')  and  gt.disposal_status !=5 and g.ulbid='".$row['ulbid']."' and cat3_id = '32' ";
        		
        	$res9 = mysqli_query($conn,$sql9);
        	$row9 = mysqli_fetch_assoc($res9);
        	$fin_count = $row9['fin_implication'];
        	
        	
   echo $sql91 = "update complaints_cat_count set Door_to_door_Collection = '".$fin_count."' where ulbid = '".$row['ulbid']."' and status = '7' " ;
       $result91=mysqli_query($conn,$sql91);    	
        	
        	
        	
        	
      /********** Rejected ****************/ 
    
    
     $sql51="SELECT count(grievance_id) as rejected,app_type_id FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$row['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id = '10' and cat3_id = '32'";
			    
    $res51=mysqli_query($conn,$sql51);
    $row51=mysqli_fetch_assoc($res51);
    $rejected = $row51['rejected'];
    
    
    
    
    $sql52 = "update complaints_cat_count set Door_to_door_Collection = '".$rejected."' where ulbid = '".$row['ulbid']."' and status = '8' " ;
       $result52=mysqli_query($conn,$sql52);
       
       
       
       
      /********** Reopen ****************/  
       
    
    
    
    $sql64="SELECT count(grievance_id) as tot_reopen,app_type_id FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$row['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id = '11' and cat3_id = '32'";
			    
    $res64=mysqli_query($conn,$sql64);
    $row64=mysqli_fetch_assoc($res64);
    $reopen = $row64['tot_reopen'];
    
    
    
    $sql65 = "update complaints_cat_count set Door_to_door_Collection = '".$reopen."' where ulbid = '".$row['ulbid']."' and status = '9' " ;
       $result65=mysqli_query($conn,$sql65);
       
       
    
}  
    
mysqli_close($conn);



?>