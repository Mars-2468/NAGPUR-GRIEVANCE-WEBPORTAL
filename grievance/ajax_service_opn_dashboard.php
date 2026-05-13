<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
	    ini_set('display_errors',0);
	    require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		$mergedulbs = 900;
		// Total received
		$abc = 'A';
		
		/*if($abc=='A')
				{
				
				 
				$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='2' and cat3_id !='0'";
				 
				}
				else if($abc=='U')
				{
				 if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where ulbid IN('208','210') and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
				        $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where ulbid='".$_SESSION['ulbid']."' and app_type_id='2' and cat3_id !='0'";
				
    				 }
    				 }
				else if($abc=='E')
				{
				 
				  $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and 
				 emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['total_received']=$row['date_regd'];
					
				 }
				 
				 	 if($data[2]['total_received']=='')
				{
				    $data[2]['total_received']=0;
				}
				// resolved with in sla
				
					if($abc=='A')
				{
				
				 
				 $sql="select count(grievance_id) as date_regd,app_type_id 
				from grievances  where 
				grievance_status_id IN('3','8','9') and app_type_id='2' and sla_status='1' and cat3_id !='0'";
				}
				else if($abc=='U')
				{
				    
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as date_regd,app_type_id 
				from grievances where 
				grievance_status_id IN('3','8','9') and ulbid IN('208','210') and app_type_id='2' and sla_status='1' and cat3_id !='0'";
    				 }
    				 else
    				 {
				 
				  $sql="select count(grievance_id) as date_regd,app_type_id 
				from grievances where 
				grievance_status_id IN('3','8','9') and ulbid='".$_SESSION['ulbid']."' and app_type_id='2' and sla_status='1' and cat3_id !='0'";
    				 }
				}
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['resolved_within_sla']=$row['date_regd'];
					
				 }
				 
				 if($data[2]['resolved_within_sla']=='')
				{
				    $data[2]['resolved_within_sla']=0;
				}
				// resolved beyond sla
				
					if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='U')
				{
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210')  and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
    				 }
    				 else
    				 {
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."'  and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
    				 }
				}
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['resolved_beyond_sla']=$row['date_regd'];
					
				 }
				 
				  if($data[2]['resolved_beyond_sla']=='')
				{
				    $data[2]['resolved_beyond_sla']=0;
				}
				 
				 // under progress with in sla
				 
				 if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='U')
				{
				 if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
    				 }
    				 else
    				 {
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
    				 }
				}
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['pending_with_sla']=$row['date_regd'];
					
				 }
				 
				 if($data[2]['pending_with_sla']=='')
				{
				    $data[2]['pending_with_sla']=0;
				}
				 
				 
				 // under progress beyond sla
				 
				 if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='U')
				{
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
    				 }
    				 else
    				 {
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
    				 }
				}
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['pending_beyond_sla']=$row['date_regd'];
					
				 }
				 
				 
				  if($data[2]['pending_beyond_sla']=='')
				{
				    $data[2]['pending_beyond_sla']=0;
				}
				 
				/********pending Approval**********	
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where grievance_status_id='1' and app_type_id='2' and cat3_id !='0'";
				
				}
				 if($abc=='U')
				{
				    
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='1' and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='2' and cat3_id !='0'";
    				 }
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='1' and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['pendingforapproval']=$row['pendingforapproval'];
				}
				
				if($data[2]['pendingforapproval']=='')
				{
				    $data[2]['pendingforapproval']=0;
				}
				
				
			/********end pending approval****/	
			
			
			/********Financial implications**********	
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances where grievance_status_id='6' and app_type_id='2' and cat3_id !='0'";
				
				}
				 if($abc=='U')
				{
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as fin,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='6' and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as fin,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='6' and app_type_id='2' and cat3_id !='0'";
    				 }
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='6' and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as fin,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='6' and app_type_id='2' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['fin']=$row['fin'];
				}
				
			if($data[2]['fin']=='')
				{
				    $data[2]['fin']=0;
				}
				
				
			/********end pending approval****/	
			
			
			
			
				/********Un resolved**********
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,standard_services c,ulbmst u where  g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and  grievance_status_id='4' and app_type_id='2' and cat3_id !='0'";
				
				}
				 if($abc=='U')
				{
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				   $sql="select count(grievance_id) as unresolved,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='4' and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as unresolved,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='4' and app_type_id='2' and cat3_id !='0'";
    				 }
		
		
				}
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='4' and app_type_id='2' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='4' and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['unresolved']=$row['unresolved'];
				}
				
				
					if($data[2]['unresolved']=='')
				{
				    $data[2]['unresolved']=0;
				}
			
				
				
			/********end pending approval****/
			
			
			
			
				/******** Rejected **********
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='2' and cat3_id !='0'";
				
				}
				 if($abc=='U')
				{
				
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				   $sql="select count(grievance_id) as rejected,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='10' and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
		$sql="select count(grievance_id) as rejected,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='10' and app_type_id='2' and cat3_id !='0'";
    				 }
		
		
				}
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='10' and app_type_id='2' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances g,ulbmst u,Districtmst d where  g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='10' and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['rejected']=$row['rejected'];
				}
					if($data[2]['rejected']=='')
				{
				    $data[2]['rejected']=0;
				}
			
				
				
			/********end pending approval****/
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			/** re-opened applicatons **
				
				if($abc=='A')
		          {
		                
		                $sql ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='11'  group by app_type_id";
		                $sql2 ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='12' group by app_type_id";
		            
		                
		                
		            }
		            else if($abc=='U')
		            {
		                 if($_SESSION['ulbid']==(int)$mergedulbs)
        				 {
        				   $sql ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='11' and ulbid IN('208','210') group by app_type_id";
    		                $sql2 ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='12' and ulbid IN('208','210') group by app_type_id";
        				 }
        				 else
        				 {
    		                $sql ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='11' and ulbid='".$_SESSION['ulbid']."' group by app_type_id";
    		                $sql2 ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='12' and ulbid='".$_SESSION['ulbid']."' group by app_type_id";
        				 }
		                
		            }
		            else if($abc=='E')
				        {
				        }
				        else if($abc=='R')
		                {
		                }
		                
		                $rs= mysqli_query($conn,$sql);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened[$row['app_type_id']]['count']=$row['count'];
		                }
		                $rs= mysqli_query($conn,$sql2);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed[$row['app_type_id']]['count']=$row['count'];
		                }*/
		                $sql ="select * from totalcomplaints_dashboard where type='2'";
		                $rs= mysqli_query($conn,$sql);
		                $data[2] = mysqli_fetch_assoc($rs);
		                
		               
				 
				 
			      	
				 
				 
				 
		
?>

<div class="boxed">
                <!-- Title Bart Start -->
                <!-- <h4>Total Number of Complaints</h4>-->
               <div class="bash_heading row  m-b20"> Total Number of Services  </div> 
                <!-- Title Bart End -->
                <div >
				
                <div class="row dashboard-stats">
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa fa-cloud-download text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services.php?aptid=1&status=0&user_type={$user_type}&sla=0">{$data[1].total_received}</a></p>-->
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                         <?php if($abc=='U'){
                                        
                                        
                                           echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['totalReceived']."</a>";
                                        
                                           // echo "<a href='tot_received.php?aptid=2&status=0&sla=0&user_type=".$abc."' target='_blank'>".$data[2]['total_received']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=0&sla=0&user_type=".$abc."' target='_blank'>".$data[2]['totalReceived']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=2&name=".$_SESSION['uid']."' target='_blank'>".$data[2]['totalReceived']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        
                                        
                                        
                                       
                                    </p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Received</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
                                    <i class="fa fa-minus-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first">{if $data[1].pending_apprval eq ''}0{else}<a href="pending_approval.php?grievance_status_id=1&aptid=1">{$data[1].pending_apprval}</a>{/if}</p>-->
                        <p class="size-h1 no-margin countdown_first"> 
                        
                        
                        
                        
                                        <?php if($abc=='U')
                                        {
                                                
                                            echo "<a href='tot_received.php?aptid=2&status=1&sla=0&user_type=".$abc."' target='_blank''>".$data[2]['pendingApproval']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                            echo $data[2]['pendingforapproval'];
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=1&app_type_id=2&name=".$_SESSION['uid']."' target='_blank'>".$data[2]['pendingApproval']."</a>";
                                        }
                                        
                                        ?>
                        
                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Pending for Approval</span><br>
                                   <span class="percent"> (<?php echo $data[2]['pendingPercent'];?> % )</span>
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
                                    <i class="fa fa-check-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!-- <p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=1&user_type={$user_type}">{$data[1].resolved_withinsla}</a></p>-->
               <p class="size-h1 no-margin countdown_first">
                   
                   
                                         <?php if($abc=='U')
                                         {
                                        
                                        
                                        echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['compInSla']."</a>";
                                        
                                        
                                           // echo "<a href='tot_received.php?aptid=2&status=2&sla=1&user_type=".$abc."'>".$data[2]['resolved_within_sla']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                             echo "<a href='tot_received.php?aptid=2&status=2&sla=1&user_type=".$abc."'>".$data[2]['compInSla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=2&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['compInSla']."</a>";
                                        }
                                        
                                        ?>
                                        
                   
                   
                   
                   
                   </p>                   
                                    <p class="text-muted no-margin"><span style="color:#000;">Completed with in SLA</span><br>
                                    <span class="percent">(<?php echo $data[2]['compInSlapercent'];?> % )</span>
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                       
                        
                        <div class="col-md-4 col-sm-6" style="clear:both;">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
                                    <i class="fa text-large stat-icon "><img src="images/Beyond-icon.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=2&user_type={$user_type}">{$data[1].resolved_beyond_sla}</a></p>-->
                     <p class="size-h1 no-margin countdown_first">
                         
                         
                         <?php if($abc=='U'){
                                        
                                        echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['compbeyondSla']."</a>";
                                        
                                            //echo "<a href='tot_received.php?aptid=2&status=2&sla=2&user_type=".$abc."'>".$data[2]['resolved_beyond_sla']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=2&sla=2&user_type=".$abc."'>".$data[2]['compbeyondSla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['compbeyondSla']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        
                         
                         
                         
                         </p>                
                                    <p class="text-muted no-margin"><span style="color:#000;">Completed Beyond SLA</span><br>
                                    <span class="percent">(<?php echo $data[2]['compbeyondSlaPercent'];?> %)</span>
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
                                    <i class="fa fa-refresh text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=2&sla=1&user_type={$user_type}">{$data[1].pending_within_sla}</a></p>-->
    <p class="size-h1 no-margin countdown_first">
        
        
        <?php if($abc=='U'){
                                        
                                        
                                        echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['PendinginSla']."</a>";
                                        
                                        
                                        
                                           // echo "<a href='tot_received.php?aptid=2&status=3&sla=1&user_type=".$abc."'>".$data[2]['pending_with_sla']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=3&sla=1&user_type=".$abc."'>".$data[2]['PendinginSla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['PendinginSla']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        
        
        
        
        
        </p>                                
                                    
                                    <p class="text-muted no-margin"><span style="color:#000;">Under Progress with in SLA</span><br>
                                    <span class="percent">(<?php echo $data[2]['PendinginSlaPercent'];?> %)</span>
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                       
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-vimeo">
                                    <i class="fa text-large stat-icon"><img src="images/under-pro.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=2&sla=2&user_type={$user_type}">{$data[1].pending_be_sla}</a></p>-->
         <p class="size-h1 no-margin countdown_first">
             
             
             
              <?php if($abc=='U'){
                                        
                                        
                                         echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['PendingBeyondSla']."</a>";
                                        
                                            //echo "<a href='tot_received.php?aptid=2&status=3&sla=2&user_type=".$abc."'>".$data[2]['pending_beyond_sla']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=3&sla=2&user_type=".$abc."'>".$data[2]['PendingBeyondSla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['PendingBeyondSla']."</a>";
                                        }
                                        
                                        ?>
                                        
             
             
             
             </p>                            
                                    <p class="text-muted no-margin"><span style="color:#000;">Under Progress Beyond SLA</span><br>
                                    <span class="percent">(<?php echo $data[2]['PendingBeyondSlaPercent'];?> %)</span>
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        
                         <div class="col-md-4 col-sm-6" style="clear:both;">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa fa-inr text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                        <?php if($abc=='U'){
                                        
                                            echo "<a href='tot_received.php?aptid=2&status=6&sla=2&user_type=".$abc."'>".$data[2]['financialImplication']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=6&sla=2&user_type=".$abc."'>".$data[2]['financialImplication']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['financialImplication']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Financial Implication</span><br>
                                    <span class="percent">(<?php echo $data[2]['financialImplicationPercent'];?> %)</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-danger">
                                    <i class="fa fa-folder-open text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"><?php echo $reopened[2]['reopenedUnderprogress'];?></p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened under progress</span>
                                    <br>
                                   <span class="percent"> (<?php echo $reopened[2]['reopenedUnderprogressPercent'];?> %)</span>
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa  text-large stat-icon "> <img src="images/reopen_comp.png"></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"><?php echo $reopened_completed[2]['reopenedCompleted'];?></p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened completed</span>
                                    <br>
                                   <span class="percent"> (<?php echo $reopened_completed[2]['reopenedCompletedPercent'];?> %)</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        
                         <div class="col-md-4 col-sm-6" style="clear:both">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
                                    <i class="fa fa-times-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                         <?php if($abc=='U'){
                                        
                                            echo "<a href='tot_received.php?aptid=2&status=10&sla=2&user_type=".$abc."'>".$data[2]['rejected']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=10&sla=2&user_type=".$abc."'>".$data[2]['rejected']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=10&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['rejected']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Rejected</span>
                                    <br>
                                    <span class="percent">(<?php echo $data[2]['rejectedPercent'];?> %)</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
                                    <i class="fa fa-thumbs-down text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                        
                                         <?php if($abc=='U'){
                                        
                                        
                                           echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['unResolved']."</a>";
                                        
                                            //echo "<a href='tot_received.php?aptid=2&status=11&sla=2&user_type=".$abc."'>".$data[2]['unresolved']."</a>";
                                        }
                                        else if($abc=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=11&sla=2&user_type=".$abc."'>".$data[2]['unResolved']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=11&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['unResolved']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Un Resolved</span>
                                    <br>
                                    <span class="percent">(<?php echo $data[2]['unResolvedPercent'];?> %)</span>
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                         
                        
                        
                        
                         
                        
                       
                        
                        
                        

                            
                    </div>
                
                
                
				</div>
			</div>
		</div>
				
				
			</div><!-- /.tab-pane -->
			
			<?php mysqli_close($conn); ?>