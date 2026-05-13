<?php
    require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		
		$threshold_date='2024-09-01';//$_SESSION['threshold_date'];
		
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));		
		
//echo "<pre>";print_r(!empty($_POST['search']));echo "</pre>";die();

		$department_id=$_POST['department_id'];
		$f_date =!empty($_POST['f_date'])? date('Y-m-d', strtotime($_POST['f_date'])):'';
		$t_date =!empty($_POST['t_date'])? date('Y-m-d', strtotime($_POST['t_date'])):'';		
		
	    if(isset($_POST['search']) && $department_id!=0 && $f_date!='' && $t_date!='')
	    {
			//var_dump($_POST['department_id']);die();			
			$sql="SELECT rating_no,count(emp_id)as empcnt FROM `hod_feedback_to_emp` where dept_id=? and date_format(ts,'%Y-%m-%d')>='".$threshold_date."' and ts between '".$f_date."' and '".$t_date."' group by rating_no";
			$query = $conn->prepare($sql);
			$query->bind_param("i",$department_id);
    	}else if(isset($_POST['search']) && $department_id!=0 && $f_date=='' && $t_date==''){
			//var_dump($_POST['department_id']);die();			
			$sql="SELECT rating_no,count(emp_id)as empcnt FROM `hod_feedback_to_emp` where dept_id=? and date_format(ts,'%Y-%m-%d')>='".$threshold_date."' group by rating_no";
			$query = $conn->prepare($sql);
			$query->bind_param("i",$department_id);
    	}else if(isset($_POST['search']) && $department_id==0 && $f_date!='' && $t_date!=''){
			//var_dump($_POST['department_id']);die();			
			$sql="SELECT rating_no,count(emp_id)as empcnt FROM `hod_feedback_to_emp` where date_format(ts,'%Y-%m-%d')>='".$threshold_date."' and ts between '".$f_date."' and '".$t_date."'  group by rating_no";
			$query = $conn->prepare($sql);			
    	}else{
			$sql="SELECT rating_no,count(emp_id)as empcnt FROM `hod_feedback_to_emp` where date_format(ts,'%Y-%m-%d')>='".$threshold_date."' group by rating_no;";
			$query = $conn->prepare($sql);
		}
							
		$query = $conn->prepare($sql);
					
		$query->execute();
		$rs = $query->get_result();
		$total_employees=0;
		if($rs->num_rows > 0 )
		{
			$field_info = $rs->fetch_fields();
			while($row =  $rs->fetch_assoc())
			{
				//echo "<pre>";print_r($row['sum']);echo "</pre>";die();
				if(!empty($row['rating_no'])){
					foreach($field_info as $fi => $f) {
						$data[$row['rating_no']][$f->name]=$row[$f->name];	
										
					}	
					$total_employees+=$data[$row['rating_no']]['empcnt'];
				}
			}
			//echo "<pre>";print_r($total_employees);echo "</pre>";die();
		}
		else
		{
			$tpl->assign('msg','Record not found');
		}    		

		$tpl->assign('fdate',$f_date);
		$tpl->assign('tdate',$t_date);					
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
		$sql->bind_param($bindIds, ...$deptlist);
		$sql->execute();
	
		$rs=$sql->get_result();
		$dept_list[0]='Select';
		while($row = $rs->fetch_assoc())
		{
			$dept_list[$row['dept_id']]=$row['dept_desc'];
		}	
		
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	    $tpl->assign('online_applications',$online_applications);
    	$tpl->assign('app_type_id',$_POST['app_type_id']);
		$tpl->assign('applicant_name',$_POST['applicant_name']);
		$tpl->assign('mobile',$_POST['mobile']);
		$tpl->assign('department_id',$_POST['department_id']);
		$tpl->assign('total_employees',$total_employees);
		
//echo "<pre>";print_r($data);echo "</pre>";die();
	
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('app_type_list',array('1'=>'Complaints','2'=>'Services'));
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('data',$data);
		$tpl->assign('dept_list',$dept_list);		

		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
	
		$tpl->display('corp_employee_rating_report.tpl');
	}
	else
	{
		
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>