<?php
require_once('connection.php');
$conn=getconnection();

//$sql ="select * from ulbmst where ulbid = '002' ";



$sql ="select * from ulbmst";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    
    
    	/** Under progress with in SLA and beyond SLA**/
        	
        	$comp_pending_withinsla=0;
        	$comp_pending_beyondsla=0;
        		
        		
        		              
        		              // complaint 
        		  
        		 $sql7="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(NOW(),date_regd) AS target,ccm.cutt_off_time as target_days from grievances g , 
				 grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
				 g.grievance_status_id IN('2') and gt.disposal_status !=5 and g.ulbid='".$row['ulbid']."' and app_type_id='1'";
        		
                    	 $res7=mysqli_query($conn,$sql7);
            		     while($row7 = mysqli_fetch_assoc($res7))
    				     {
        				     if($row7['target'] <= $row7['target_days'])
        					 {
        					    $comp_pending_withinsla +=1;
        					    $sql ="update  grievances set sla_status='1' where grievance_id='".$row7['grievance_id']."'";
        					    mysqli_query($conn,$sql);
        					 }
        					 else
        					 {
        					    $comp_pending_beyondsla +=1;
        					    $sql ="update  grievances set sla_status='2' where grievance_id='".$row7['grievance_id']."'";
        					    mysqli_query($conn,$sql);
        					 }
    					 
    				      }
    				      
    				      
    				      // services
    				      
    				      
    				           $serv_pending_beyondsla=0; 
    				           $serv_pending_withinsla=0;
    				            
            			$sql8="select g.grievance_id,app_type_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,DATEDIFF(NOW(),date_regd) AS target 
				from grievances g , grievances_transactions gt,category3_mst c,ulbmst u where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and
				g.grievance_status_id IN('2')  and  gt.disposal_status !=5 and g.ulbid='".$row['ulbid']."' and app_type_id='2'";
            				      
    				      
    				      $res8=mysqli_query($conn,$sql8);
            		     while($row8 = mysqli_fetch_assoc($res8))
    				     {
        				     if($row8['target'] <= $row8['target_days'])
        					 {
        					    $serv_pending_withinsla +=1;
        					    $sql ="update  grievances set sla_status='1' where grievance_id='".$row8['grievance_id']."'";
        					    mysqli_query($conn,$sql);
        					 }
        					 else
        					 {
        					    $serv_pending_beyondsla +=1;
        					    $sql ="update  grievances set sla_status='2' where grievance_id='".$row8['grievance_id']."'";
        					    mysqli_query($conn,$sql);
        					 }
    					 
    				     }
    				      
    				      		 
        		 
        $qry="update dashboard_count set under_progress_sla = '".$comp_pending_withinsla."' , under_pro_be_sla = ".$comp_pending_beyondsla." where ulbid = '".$row['ulbid']."' and app_type_id='1'";			      
    	   $result=mysqli_query($conn,$qry);
    	    
    	     $qry1="update dashboard_count set  under_progress_sla='".$serv_pending_withinsla."' , under_pro_be_sla = ".$serv_pending_beyondsla." where  ulbid = '".$row['ulbid']."' and app_type_id='2'";			      
    	   $result1=mysqli_query($conn,$qry1);
    	   
    	   
    	   
    	   
    	  }

mysqli_close($conn);



?>