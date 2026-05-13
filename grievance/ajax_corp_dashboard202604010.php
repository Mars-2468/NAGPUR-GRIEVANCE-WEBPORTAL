<?php
	require_once  "config.php";
	
	ini_set('display_errors', 0);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

	date_default_timezone_set('Asia/Calcutta');
	//include('responsible_sms.php');
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	//$tpl->caching = true;
	//$tpl->cache_lifetime = 60;
	
	if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
			echo "<p>Error: You must be logged in to access this page.</p>";
		exit;
	}
		
	// designation wise filter

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if ($_POST['ty'] == 'designationwisefilter') {
			designation_wise_flter($_POST);
		}
	}
	
	$ward_id= !empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';
	
	function designation_wise_flter($RES)
	{
		$_SESSION['filterdesg'] = $RES['designation'];
		$dept_desg=explode(":",$RES['designation']);
		
		$_SESSION['employee_dept']=$dept_desg[0];
		$_SESSION['employee_desg']=$dept_desg[1];
		
		return $_SESSION['filterdesg'];
	}
	
	$selectedDesg = !empty($_SESSION['filterdesg'])?$_SESSION['filterdesg']:'';
	$selectedDept = !empty($_SESSION['employee_dept'])?$_SESSION['employee_dept']:'';
	$selectedDesgnation = !empty($_SESSION['employee_desg'])?$_SESSION['employee_desg']:'';
	
	//echo "<pre>";print_r($_SESSION);echo "</pre>";die();
	
	// year wise filter
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if ($_POST['ty'] == 'yearwisefilter') {
			year_wise_flter($_POST);
		}
	}
	
	function year_wise_flter($RES)
	{
		$_SESSION['filteryear'] = $RES['year'];
		return $_SESSION['filteryear'];
	}
		
	
	if(isset($_SESSION['uid']) )
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		//include('prepare_connection.php');
	
		//echo $_SESSION['ulbid'];
		/*if($_POST['setVillage'])
		{
		    $_SESSION['ulbid']=$_POST['ulbid'];		    
		   
		}*/
			
		
		/** counting total services **/		
	
		$sql = $conn->prepare("select count(cs_id) total_services,cs_type_id from category3_mst where ulbid=? group by cs_type_id");
	    	$sql->bind_param("s",$_SESSION['ulbid']);
	    	$sql->execute();
    		$rs = $sql->get_result();
			
		while($row = $rs->fetch_assoc())
		{
			$map[$row['cs_type_id']]['total_services']=$row['total_services'];
		}
	
	//echo "<pre>";print_r($_SESSION);echo "</pre>";die();	
	//echo "<pre>";print_r($_SESSION);echo "</pre>";die();
				
		/** assigned services **/
		$flag = 1; $cs_type_id = 2;
		
		$sql = $conn->prepare("select count(cs_id) total_services_mapped,cs_type_id from category3_mst where ulbid=? and cs_id IN(select cs_id from emp_map where ulbid=? and flag=? and cs_type_id=? group by cs_id) group by cs_type_id");
	    	$sql->bind_param("ssii",$_SESSION['ulbid'],$_SESSION['ulbid'],$flag,$cs_type_id);
	    	$sql->execute();
    		$rs = $sql->get_result();
			
		while($row = $rs->fetch_assoc())
		{
			$map[$row['cs_type_id']]['total_services_mapped']=$row['total_services_mapped'];
		}
		
		/**/
		
		/** services not assigned **/
		
		$sql = $conn->prepare("select count(cs_id) total_services_not_mapped,cs_type_id from category3_mst where ulbid=? and cs_id NOT IN(select cs_id from emp_map where ulbid=? and flag=? group by cs_id) group by cs_type_id");
	    	$sql->bind_param("ssi",$_SESSION['ulbid'],$_SESSION['ulbid'],$flag);
	    	$sql->execute();
    		$rs = $sql->get_result();
			
		while($row = $rs->fetch_assoc())
		{
			$map[$row['cs_type_id']]['total_services_not_mapped']=$row['total_services_not_mapped'];
		}
				
		$sql = $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
	    	$sql->bind_param("s",$_SESSION['ulbid']);
	    	$sql->execute();
    		$rs = $sql->get_result();
			$online_applications=[];
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql ="select COUNT(id) as feedback_count from `smart_idea_box` sib,ulbmst u,Districtmst d where u.ulbid=sib.ulbid and u.distid=d.distid  and sib.ulbid like ?";
		
		$ulbid = "%".$_SESSION['ulbid']."%";
		$sql2 = $conn->prepare($sql);
		$sql2->bind_param("s",$ulbid);
		if($_SESSION['user_type']=='R')
		{
		    $sql.=" and d.rdma='".$_SESSION['uid']."'";
		    $sql2 = $conn->prepare($sql);
		    $rdma = $_SESSION['uid'];
		    $sql2->bind_param("ss",$ulbid,$rdma);
		}
		
		$sql2->execute();
    		$rs = $sql2->get_result();
		$row = $rs->fetch_assoc();
		$feedback_count=$row['feedback_count'];
	
		//	print_r($online_applications);
				
		/*************** complaints *****************/
				
		$sql = $conn->prepare("select count(cs_id) total_services from complaint_ulbmap where ulbid=?");
	    	$sql->bind_param("s",$_SESSION['ulbid']);
	   	 $sql->execute();
    		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$map['total_complaints']=$row['total_services'];
		}
		
		/** complaints not assigned **/
	
		$sql = $conn->prepare("select count(cs_id) total_services_not_mapped from complaint_ulbmap where ulbid=? and cs_id NOT IN(select cs_id from emp_map where ulbid=? and flag=? and  cs_type_id=? group by cs_id)");
	    	$sql->bind_param("ssii",$_SESSION['ulbid'],$_SESSION['ulbid'],$flag,$cs_type_id);
	    	$sql->execute();
    		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$map['total_complaints_not_mapped']=$row['total_services_not_mapped'];
		}
		
		/** assigned complaints **/
				
		$sql = $conn->prepare("select count(cs_id) total_services_mapped from complaint_ulbmap where ulbid=? and cs_id IN(select cs_id from emp_map where ulbid=? and flag=? and cs_type_id=? group by cs_id)");
	    $sql->bind_param("ssii",$_SESSION['ulbid'],$_SESSION['ulbid'],$flag,$cs_type_id);
	    $sql->execute();
    	$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$map['total_complaints_mapped']=$row['total_services_mapped'];
		}
		
		/**/		
		
		$sql = $conn->prepare("select * from ulb_posters where ulbid=?");
	    $sql->bind_param("s",$_SESSION['ulbid']);
	    $sql->execute();
    	$rs = $sql->get_result();
		$pic='';
		while($row = $rs->fetch_assoc())
		{
			$pic= $row['image'];
		}		
		
		//echo $_SESSION['user_id'];
			
		$sql = $conn->prepare("select service_id from users_services where user_id= ?");
		
	    $sql->bind_param("s",$_SESSION['user_id']);
	    $sql->execute();
    	$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$assigned_services[$row['service_id']] = $row['service_id'];
		}

		$sql = $conn->prepare("select * from hod_emp_map where emp_id= ?");
		
	    $sql->bind_param("i",$_SESSION['emp_id']);
	    $sql->execute();
    	$rs = $sql->get_result();
		$num_rows_dept_map = $rs->num_rows;
		
		$sql = $conn->prepare("select * from ward_comm_map where emp_id= ?");
		
	    $sql->bind_param("i",$_SESSION['emp_id']);
	    $sql->execute();
    	$rs = $sql->get_result();
		$num_rows_ward_map = $rs->num_rows;
		
		//echo "<pre>";
		//print_r($assigned_services);		
	
		$sql = "SELECT COUNT(DISTINCT sc.warning_id) as warning_id,e.emp_name,d.dept_desc,sc.emp_id FROM `show_case_response_logs` as sc LEFT JOIN emp_mst as e ON e.emp_id=sc.emp_id LEFT JOIN emp_map as em ON em.emp_id=sc.emp_id RIGHT JOIN dept_mst as d ON e.emp_dept = d.dept_id where sc.row_number%5=0  and em.ward_id= ".$ward_id." and  date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";

		if (isset($_SESSION['filteryear'])) { 
			$sql .= "  and date_format(sc.date_regd,'%Y') = '" . $_SESSION['filteryear'] . "' ";
		}
		
		$rs2 = mysqli_query($conn, $sql);
		while ($row2 = mysqli_fetch_assoc($rs2)) {
			$showcause_id = $row2['warning_id'];
		}
		
		//echo "<pre>";print_r($sql);echo "</pre>";die();
		//warning notices
		
		$sql = "SELECT COUNT(DISTINCT warning_id) as warning_id FROM show_case_response_logs  as sc LEFT JOIN emp_mst as e ON e.emp_id=sc.emp_id LEFT JOIN emp_map as em ON em.emp_id=sc.emp_id Where  em.ward_id= ".$ward_id."  and date_format(date_regd, '%Y-%m-%d') >= date('2024-09-01')";
		
		if (isset($_SESSION['filteryear'])) { 
			$sql .= " and date_format(date_regd,'%Y') = '" . $_SESSION['filteryear'] . "' ";
		}
			
		$rs2 = mysqli_query($conn, $sql);
		while ($row2 = mysqli_fetch_assoc($rs2)) {
			$warning_id = $row2['warning_id'];
		}

		//echo "<pre>";print_r($warning_id);echo "</pre>";die();		
			
		$_SESSION['showcause_id'] = $showcause_id;
		$_SESSION['warning_id'] = $warning_id;	
			
		$conn->close();
	
		$tpl->assign('num_rows_dept_map',$num_rows_dept_map);
		$tpl->assign('num_rows_ward_map',$num_rows_ward_map);
	    $tpl->assign('assigned_services',$assigned_services);
		
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet','900'=>'Both'));
	    $tpl->assign('ulb',$_SESSION['ulbid']);
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('feedback_count',$feedback_count);
		$tpl->assign('online_applications',$online_applications);
			
		$tpl->assign('map',$map);
		$tpl->assign('pic',$pic);
		
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ajax_corp_dashboard.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
	}
