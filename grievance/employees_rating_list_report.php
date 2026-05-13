<?php
    require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	$department_id=$_GET['department_id'];
	$rating_no=$_GET['rating_no'];
	$f_date =!empty($_GET['f_date'])? date('Y-m-d', strtotime($_GET['f_date'])):'';
	$t_date =!empty($_GET['t_date'])? date('Y-m-d', strtotime($_GET['t_date'])):'';		
	 
	//echo "<pre>";print_r($_POST);echo "</pre>";die();
	
	if($rating_no!=0){
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');		
	
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));		
		
	    if($department_id!=0 && $f_date!='' && $t_date!='')
	    {
			//var_dump($_GET['rating_no']);die();			
			$sql="SELECT emp_id,grievance_id,dept_id,rating_no FROM `hod_feedback_to_emp` where rating_no=? and dept_id=? and ts between '".$f_date."' and '".$t_date."'";
			$query = $conn->prepare($sql);
			$query->bind_param("ii",$rating_no,$department_id);
    	}else if($department_id!=0 && $f_date=='' && $t_date==''){
			//var_dump($_GET['department_id']);die();			
			$sql="SELECT emp_id,grievance_id,dept_id,rating_no FROM `hod_feedback_to_emp` where rating_no=? and dept_id=? ";
			$query = $conn->prepare($sql);
			$query->bind_param("ii",$rating_no,$department_id);
    	}else if($department_id==0 && $f_date!='' && $t_date!=''){
			//var_dump($_GET['department_id']);die();			
			$sql="SELECT emp_id,grievance_id,dept_id,rating_no FROM `hod_feedback_to_emp` where rating_no=? and ts between '".$f_date."' and '".$t_date."'";
			$query->bind_param("i",$rating_no);		
    	}else{
			//die('ddd');
			$sql="SELECT emp_id,grievance_id,dept_id,rating_no FROM `hod_feedback_to_emp` where rating_no=?";
			$query = $conn->prepare($sql);
			$query->bind_param("i",$rating_no);
		}
						
		$query->execute();
		$rs = $query->get_result();
		$total_employees=0;
		if($rs->num_rows > 0 )
		{
			$field_info = $rs->fetch_fields();
			while($row =  $rs->fetch_assoc())
			{
				//echo "<pre>";print_r($row['sum']);echo "</pre>";die();
				if(!empty($row['emp_id'])){
					foreach($field_info as $fi => $f) {
						$data[$row['emp_id']][$f->name]=$row[$f->name];												
					}	
					$total_employees+=$data[$row['rating_no']]['empcnt'];
				}
			}
			//echo "<pre>";print_r($data);echo "</pre>";die();
		}
		else
		{
			$tpl->assign('msg','Record not found');
		}    		

		$tpl->assign('fdate',$f_date);
		$tpl->assign('tdate',$t_date);
					
		   // echo "<pre>";print_r($data);echo "</pre>";die();
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql = $conn->prepare('SELECT dept_id,dept_desc FROM dept_mst');
		$sql->execute();	
		$rs=$sql->get_result();
		$dept_list[0]='Select';
		while($row = $rs->fetch_assoc())
		{
			$dept_list[$row['dept_id']]=$row['dept_desc'];
		}		
				
		$sql = $conn->prepare('SELECT emp_id,emp_name FROM emp_mst');
		$sql->execute();	
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$emp_list[$row['emp_id']]['emp_id']=$row['emp_id'];
			$emp_list[$row['emp_id']]['grievance_id']=$data[$row['emp_id']]['grievance_id'];
			$emp_list[$row['emp_id']]['emp_name']=$row['emp_name'];
			$emp_list[$row['emp_id']]['emp_dept']=$row['emp_dept'];
		}
		
		//echo "<pre>";print_r($dept_list);echo "</pre>";die();
		
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	    $tpl->assign('online_applications',$online_applications);
    	$tpl->assign('app_type_id',$_POST['app_type_id']);
		$tpl->assign('applicant_name',$_POST['applicant_name']);
		$tpl->assign('mobile',$_POST['mobile']);
		$tpl->assign('department_id',$_POST['department_id']);
		$tpl->assign('total_employees',$total_employees);
	    
	/*	$query->close();*/
		
//echo "<pre>";print_r($data);echo "</pre>";die();
	
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('app_type_list',array('1'=>'Complaints','2'=>'Services'));
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('data',$data);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('emp_list',$emp_list);		
		$tpl->assign('department_id',$department_id);		
		$tpl->assign('rating_no',$rating_no);		

		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
	
		$tpl->display('employees_rating_list_report.tpl');
	}
	else
	{			
		echo "<script>window.location='index.php';</script>";
		
	}
?>