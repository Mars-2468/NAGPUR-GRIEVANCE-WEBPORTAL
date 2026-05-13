<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		
		if($_REQUEST['aptid']=='2')
		{
		
				if($_REQUEST['aptid']=='2' && $_REQUEST['status']==0 && isset($_SESSION['ulbid']) && $_SESSION['user_type']=='U' )
					{
						// Ulb login Total Assigned services
					
					$sql="select g.*,c.*,g1.* from grievances g,category3_mst c,grievances_transactions g1 where g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and g1.disposal_status!='5' and g.grievance_id=g1.grievance_id and g1.emp_id='".$_REQUEST['emp_id']."' and c.dept_id='".$_REQUEST['dept_id']."'  order by date_regd DESC";
					}
					
					else if ($_REQUEST['aptid']=='2' && $_REQUEST['status']==3 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==1 && $_SESSION['user_type']=='U')
					{
						// Ulb login completed services with IN SLA
						
					 $sql="select g.*,c.dept_id,disposed_date,c.cutt_of_time,DATEDIFF(disposed_date,date_regd) AS target from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id  and g.grievance_status_id IN('3') and gt.disposal_status !=5 and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' order by date_regd DESC";
					}
					else if ($_REQUEST['aptid']=='2' && $_REQUEST['status']==3 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==2 && $_SESSION['user_type']=='U')
					{
						
						// Ulb login completed services beyond SLA
						
					
					 $sql="select g.*,c.dept_id,disposed_date,c.cutt_of_time,DATEDIFF(disposed_date,date_regd) AS target from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id  and g.grievance_status_id IN('3') and g.ulbid='".$_SESSION['ulbid']."' and gt.disposal_status !=5 and g.app_type_id='".$_REQUEST['aptid']."' order by date_regd DESC";
					
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==2 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==1  && $_SESSION['user_type']=='U')
					{
						// Ulb login under progress services with IN SLA
						
					 $sql="select g.*,c.dept_id,c.cutt_of_time,DATEDIFF(disposed_date,date_regd) AS target from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id  and g.grievance_status_id NOT IN('3','6') and g.ulbid='".$_SESSION['ulbid']."' and gt.disposal_status !=5 and g.app_type_id='".$_REQUEST['aptid']."' order by date_regd DESC";
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==2 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==2 && $_SESSION['user_type']=='U')
					{
						// Ulb login under progress services beyond SLA
						
					$sql="select g.*,c.dept_id,c.cutt_of_time,DATEDIFF(disposed_date,date_regd) AS target from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and  g.grievance_status_id NOT IN('3','6') and g.ulbid='".$_SESSION['ulbid']."'  and gt.disposal_status !=5 and g.app_type_id='".$_REQUEST['aptid']."' order by date_regd DESC";
					}
					
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==3 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==1)
					{
						////////// employee login Completed services With in SLA
						
						
					    $sql="select g.*,DATEDIFF(disposed_date,date_regd) AS target from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN('3') and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 order by date_regd DESC";
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==3 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==2)
					{
						////////// employee login Completed services beyond SLA
						
						
					    $sql="select g.*,c.cutt_of_time,DATEDIFF(disposed_date,date_regd) AS target from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN('3') and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 order by date_regd DESC";
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==2 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==1)
					{
						////////// employee login Under progress  services beyond SLA
						
						
					    $sql="select g.*,c.cutt_of_time,DATEDIFF(disposed_date,date_regd) AS target from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id NOT IN('3','6') and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 order by date_regd DESC";
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==2 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==2)
					{
						////////// employee login Under progress  services beyond SLA
						
						
					     $sql="select g.*,c.cutt_of_time,DATEDIFF(disposed_date,date_regd) AS target from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id NOT IN('3','6') and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 order by date_regd DESC";
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==0 && $_SESSION['user_type']=='E')
					{
						// Ulb login Total Assigned services
					 $sql="select g.*,c.cat_id from grievances g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id  and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' order by date_regd DESC";
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==500 && $_SESSION['user_type']=='U')
				{
					$sql="select g.*,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('6')  and  gt.disposal_status !=5 and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==500 && $_SESSION['user_type']=='E')
				{
					$sql="select g.grievance_id,app_type_id,date_regd  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('6')  and gt.emp_id='".$_SESSION['emp_id']."'  and  gt.disposal_status !=5 order by date_regd DESC";
				}
					
		}
		
		
		
		
		// in case of complaint
		
		
		
		if($_REQUEST['aptid']=='1')
		{
		
			
		
			if($_REQUEST['aptid']=='1' && $_REQUEST['status']==0 && isset($_SESSION['ulbid']) && $_SESSION['user_type']=='U')
				{
					// ulb login Total assigned complaints
				 $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c where g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' order by date_regd DESC";
				}
				else if ($_REQUEST['aptid']=='1' && $_REQUEST['status']==3 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==1 && $_SESSION['user_type']=='U')
				{
					// ulb login completed complaints with in sla
				 $sql="select g.*,c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and  g.grievance_status_id IN('3') and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.disposal_status !=5 order by date_regd DESC";
				}
				else if ($_REQUEST['aptid']=='1' && $_REQUEST['status']==3 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==2 && $_SESSION['user_type']=='U')
				{
					// ulb login completed complaints beyond sla
					
				
				
				$sql="select g.*,c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and  g.grievance_status_id IN('3') and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.disposal_status !=5 order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==2 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==1 && $_SESSION['user_type']=='U')
				{
					// ulb login under progress complaints with in sla
					
					
				 $sql="select g.*,c.cat_id,DATEDIFF(disposed_date,date_regd) AS target from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and  g.grievance_status_id NOT IN('3','6') and g.ulbid='".$_SESSION['ulbid']."'  and g.app_type_id='".$_REQUEST['aptid']."' and gt.disposal_status !=5 order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==2 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==2 && $_SESSION['user_type']=='U')
				{
					// ulb login under progress complaints beyond sla
					
				  $sql="select g.*,c.cat_id,DATEDIFF(disposed_date,date_regd) AS target from grievances g,complaint_ulbmap c,grievances_transactions gt  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and  g.grievance_status_id NOT IN('3','6') and g.ulbid='".$_SESSION['ulbid']."'  and g.app_type_id='".$_REQUEST['aptid']."' and gt.disposal_status !=5 order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==0 && isset($_SESSION['ulbid']) && $_SESSION['user_type']=='E')
				{
					////////// employee login Total Assigned complaints
					
				 $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==3 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==1)
				{
					////////// employee login Completed complaints With in SLA
					
					
				    $sql="select g.*,c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN('3') and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==3 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==2)
				{
					////////// employee login Completed complaints beyond SLA
					
					
				    $sql="select g.*,c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN('3') and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==2 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==1)
				{
					////////// employee login Under progress  complaints beyond SLA
					
					
				    $sql="select g.*,c.cat_id,DATEDIFF(disposed_date,date_regd) AS target from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id NOT IN('3','6') and g.ulbid='".$_SESSION['ulbid']."'  and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==2 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==2)
				{
					////////// employee login Under progress  complaints beyond SLA
					
					
				    $sql="select g.*,c.cat_id,DATEDIFF(disposed_date,date_regd) AS target from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id NOT IN('3','6') and g.ulbid='".$_SESSION['ulbid']."'  and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==0 && isset($_SESSION['ulbid']) && $_SESSION['user_type']=='E')
				{
					////////// employee login Total Assigned services
					
				 $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' and gt.emp_id='".$_SESSION['emp_id']."' order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==500 && $_SESSION['user_type']=='U')
				{
					$sql="select g.*,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('6')  and  gt.disposal_status !=5 and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['aptid']."' order by date_regd DESC";
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==500 && $_SESSION['user_type']=='E')
				{
					$sql="select g.grievance_id,app_type_id,date_regd  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('6')  and gt.emp_id='".$_SESSION['emp_id']."'  and  gt.disposal_status !=5 order by date_regd DESC";
				}
		
		}

		
		 
		
		
		
		if($rs=mysqli_query($conn,$sql))
		{
			$field_info = mysqli_fetch_fields($rs);
			while($row = mysqli_fetch_assoc($rs))
			{
				if($_REQUEST['aptid']==2  && $_REQUEST['sla']==1)
				{
				 if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] <= $row['cutt_of_time'])
					 {
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 }

				}
				else if($_REQUEST['aptid']==2 && $_REQUEST['sla']==2)
				{
					if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] > $row['cutt_of_time'])
					 {
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 }
				}
				
				else if($_REQUEST['aptid']==1  && $_REQUEST['sla']==1)
				{
					if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] <= 1)
					 {
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 }
				}
				else if($_REQUEST['aptid']==1 && $_REQUEST['sla']==2)
				{
					if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] > 1)
					 {
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 }
				}
				else if($_REQUEST['status']=='fin')
				{
					
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 
				}
				else if($_REQUEST['aptid']==1)
				{
					foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
				}
				else if($_REQUEST['aptid']==2)
				{
					foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
				}
			}
			
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
						
		
		$tpl->assign('data',$data);



		$sql="select ward_id,ward_desc from ward_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	

		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			

		$sql="select dept_id,dept_desc from dept_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
					
		$tpl->assign('dept_list',$dept_list);
		
		
		
		$sql="select cs_id,comp_desc from category3_mst where ulbid='".$_SESSION['ulbid']."'";
		
		if($_REQUEST['aptid']=='1')
		{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		}
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
					
		
		
		
		mysqli_close($conn);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('emp_dept_services.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>