<?php
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
	$sql="select emp_dept,disposal_status,DATEDIFF(disposed_date,date_regd) days_taken,count(grievances.grievance_id) num_comp from grievances,grievances_transactions,emp_mst where grievances_transactions.emp_id=emp_mst.emp_id and grievances_transactions.grievance_id=grievances.grievance_id and disposal_status in(3,4) and grievances.ulbid=? group by emp_dept,disposal_status,days_taken";
	
	
                 $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 //$rs = $query->get_result();
	
	
	
	
	if($rs = $query->get_result())
	{
		while($row = $rs->fetch_assoc())
		{
			switch(true)
			{
				case ($row['days_taken'] < 7 ):
					$data[$row['emp_dept']][$row['disposal_status']]['lt_7']+=$row['num_comp'];
					$data[$row['emp_dept']][$row['disposal_status']]['tot']+=$row['num_comp'];
					$tot[$row['disposal_status']]['lt_7']+=$row['num_comp'];
					$tot[$row['disposal_status']]['tot']+=$row['num_comp'];
					break;
				case ($row['days_taken'] < 15 ):
					$data[$row['emp_dept']][$row['disposal_status']]['lt_15']+=$row['num_comp'];
					$data[$row['emp_dept']][$row['disposal_status']]['tot']+=$row['num_comp'];
					$tot[$row['disposal_status']]['lt_15']+=$row['num_comp'];
					$tot[$row['disposal_status']]['tot']+=$row['num_comp'];
					break;
				case ($row['days_taken'] < 30 ):
					$data[$row['emp_dept']][$row['disposal_status']]['lt_30']+=$row['num_comp'];
					$data[$row['emp_dept']][$row['disposal_status']]['tot']+=$row['num_comp'];
					$tot[$row['disposal_status']]['lt_30']+=$row['num_comp'];
					$tot[$row['disposal_status']]['tot']+=$row['num_comp'];
					break;
				case ($row['days_taken'] >= 30 ):
					$data[$row['emp_dept']][$row['disposal_status']]['gt_30']+=$row['num_comp'];
					$data[$row['emp_dept']][$row['disposal_status']]['tot']+=$row['num_comp'];
					$tot[$row['disposal_status']]['gt_30']+=$row['num_comp'];
					$tot[$row['disposal_status']]['tot']+=$row['num_comp'];
					break;	
			}
		}
	}
	

		if($_SESSION['user_type']=='A')
		{
			$sql="select dept_id,dept_desc from dept_mst where ulbid=?";
			
			
			     $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 
		}	
		else
		{
			$sql="select dept_id,dept_desc from dept_mst where ulbid=?";
			     $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 
		}	
		
		         $query->execute();
        		// $rs = $query->get_result();
		if($rs = $query->get_result())
		{
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
	
		$conn->close();			
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('dept_list',$dept_list);

		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('user_dept',$_SESSION['user_dept']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('rep_redressed_dept_abs.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>	