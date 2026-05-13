<?php
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
ini_set('include_path', ini_get('include_path') . ':/home/vmaxsdmg/php');
require_once('Smarty.class.php');
$tpl = new Smarty();
session_start();
require_once('sms_conf.php');
require_once('send_sms.php');

if (isset($_SESSION['uid'])) {


	session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	$conn->set_charset("utf8");


	if (isset($_REQUEST['gid'])) {
		$gid = $_REQUEST['gid'];
	} else {
		$gid = $_SESSION['gid'];
	}
	if ($_REQUEST['aptid'] == '1') {
		$sql = "select c.cs_desc as comp_desc ,g.grievance_id as file_no,g.date_regd,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) AS cutt_of_time from cs_mst c, grievances g,comp_cutofdays_map ccm where c.cs_id=g.cat3_id and g.cat3_id=ccm.cs_id and g.grievance_id=?";

		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$gid = $gid;
		$query = $conn->prepare($sql);
		$query->bind_param("i", $gid);
	} else {

		$sql = "select c.cs_desc as comp_desc ,c.fine_per_day,c.telugu_description,g.date_regd,c.cutt_off_time as cutt_of_time from standard_services c, grievances g where c.cs_id=g.mcat3_id  and g.grievance_id=?";

		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$gid = $gid;
		$query = $conn->prepare($sql);
		$query->bind_param("i", $gid);
	}
	$query->execute();
	$rs = $query->get_result();

	$row = $rs->fetch_assoc();

	// If ulb is miryalaguda set telugu description

	if ($_SESSION['ulbid'] == '085') {
		$data2['comp_desc'] = $row['telugu_description'];
	} else {
		$data2['comp_desc'] = $row['comp_desc'];
	}


	$data2['fine_per_day'] = $row['fine_per_day'];
	$data2['ref_no'] = $gid;
	$data2['date'] = date('d-m-Y', strtotime($row['date_regd']));
	$data2['cutt_of_time'] = $row['cutt_of_time'];


	$sql = "select u.ulbnametelugu ,u.pincode,ut.ulb_type_desctelugu,d.distnametelugu from ulbmst u , ulb_type ut,Districtmst d where u.distid=d.distid and u.ulb_type=ut.ulb_type_id and u.ulbid=?";


	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$query = $conn->prepare($sql);
	$query->bind_param("s", $ulbid);
	$query->execute();
	$rs = $query->get_result();


	$row = $rs->fetch_assoc();

	$ulb_det['ulbnametelugu'] = $row['ulbnametelugu'];
	$ulb_det['ulb_type_desctelugu'] = $row['ulb_type_desctelugu'];
	if ($ulbid == '208' || $ulbid == '210') {
		$ulb_det['ulbnametelugu'] = 'మీర్ పేట్';
		$ulb_det['ulb_type_desctelugu'] = 'నగరపాలక సంస్థ';
	}
	$ulb_det['distnametelugu'] = $row['distnametelugu'];
	$ulb_det['pincode'] = $row['pincode'];

	$sql = "select * from grievances where grievance_id=?";

	$gid = $gid;
	$query = $conn->prepare($sql);
	$query->bind_param("i", $gid);
	$query->execute();
	$rs = $query->get_result();




	$data = $rs->fetch_assoc();
	if ($_REQUEST['aptid'] == '1') {
		$sql = "select cutt_off_time from comp_cutofdays_map where cs_id='" . $data['cat3_id'] . "'";
	} else {
		// $sql ="SELECT cutt_of_time as cutt_off_time FROM `category3_mst` where cs_id='".$data['cat3_id']."'";
		$sql = "SELECT cutt_off_time as cutt_off_time FROM `standard_services` where cs_id='" . $data['cat3_id'] . "'";
	}

	$rs1 = mysqli_query($conn, $sql);
	$row1 =  mysqli_fetch_assoc($rs1);
	$disposabledays = $row1['cutt_off_time'] + $num_days_toadd;

	//echo $data['cutt_of_time'];

	/*	if(strtotime($data['cutt_of_time']) < strtotime('today'))
			{
			
			 $num_days_toadd=$data2['cutt_of_time'];
			
			$data['cutt_of_time']=date('d-m-Y',strtotime($data2['date'] . " +".$num_days_toadd." day"));
			}
			else{
				$data['cutt_of_time']=date('d-m-Y',strtotime($data['cutt_of_time']));
			}
			//echo $data['cutt_of_time'];
			
			if($_REQUEST['aptid']=='1')
			{
			$data['cutt_of_time']=date('d-m-Y',strtotime($data['cutt_of_time']));
			//$data['cutt_of_time']=1;
			}
			//echo $data['cutt_of_time'];*/

	$data['cutt_of_time'] = date('d-m-Y', strtotime($data2['date'] . " +" . $disposabledays . " day"));

	$sql5 = "select emp_id from grievances_transactions where grievance_id=$gid";
	$rs = mysqli_query($conn, $sql5);
	$result = mysqli_fetch_assoc($rs);
	if (is_numeric($result['emp_id'])) {
		$sql1 = "SELECT emp_id,emp_dept as dept_id,emp_desg,emp_mobile,emp_name FROM emp_mst WHERE  emp_id='" . mysqli_real_escape_string($conn, strip_tags($result['emp_id'])) . "'";
	} else {
		$sql1 = "SELECT emp_id,emp_dept as dept_id,emp_desg,emp_mobile,emp_name  FROM emp_mst_od WHERE  emp_id='" . mysqli_real_escape_string($conn, strip_tags($result['emp_id'])) . "'";
	}
	// $rs = mysqli_query($conn,$sql1);
	$nr = mysqli_num_rows($rs);
	//if($nr <= 0)
	//{
	// $sql1="SELECT emp_id,emp_dept as dept_id,emp_desg,emp_mobile,emp_name  FROM emp_mst_od WHERE  emp_id='".mysqli_real_escape_string($conn,strip_tags($result['emp_id']))."'";
	$rs = mysqli_query($conn, $sql1);
	$nr = mysqli_num_rows($rs);
	if ($nr > 0) {
		$status_const = "Under progress";
	}
	$row1 = mysqli_fetch_assoc($rs);
	//}
	// else
	//{
	// $status_const="Under progress";
	// $row1 = mysqli_fetch_assoc($rs);
	// }


	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('empdata', $row1);
	$tpl->assign('apptype_id', $_REQUEST['aptid']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('ulb_det', $ulb_det);
	$tpl->assign('data2', $data2);
	$tpl->assign('data', $data);
	$tpl->assign('service_sel', $_POST['service_id']);
	$tpl->assign('section_sel', $_POST['section_id']);
	$tpl->assign('subject_list', $subject_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('corp_receive_print.tpl');
} else {



	echo "<script>window.location='index.php';</script>";
}
?>