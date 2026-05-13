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

		if($_GET['disposal_status']=='%')
			$disposal_status='2,3,4';
		else
			$disposal_status=$_GET['disposal_status'];

		$sql="select grievances_transactions.grievance_id grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id,date_regd,emp_dept from grievances,grievances_transactions,emp_mst where grievances.grievance_id=grievances_transactions.grievance_id and emp_mst.emp_id=grievances_transactions.emp_id and  disposal_status in(".$disposal_status.") and emp_dept like '".$_GET['dept_id']."' and grievances.ulbid='".$_SESSION['ulbid']."'";
		
		if($rs=mysqli_query($conn,$sql))
		{
			$field_info = mysqli_fetch_fields($rs);
			while($row = mysqli_fetch_assoc($rs))
			{
				foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
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

				mysqli_close($conn);	
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('rep_comp_dept.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>