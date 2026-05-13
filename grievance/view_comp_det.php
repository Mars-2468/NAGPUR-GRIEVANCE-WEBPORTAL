<?php
require "config.php";
ini_set('display_errors', 0);

require_once('Smarty.class.php');
$tpl = new Smarty();
require_once('connection.php');
$conn = getconnection();

/* 03-07-2024 if (!isset($_SESSION['com_reg_mobile'])) {
	header('Location: https://egovmars.in/csms/complaint_form.php');
}*/
// echo $_SESSION['com_reg_mobile'];

// die();
/*03-07-2024 if(!isset($_SESSION['login_status']) && $_SESSION['login_status'] != 1){
	    $indexpage="complaint_form.php";
			 //header("location:$indexpage");
		echo "<script>window.location='$indexpage';</script>";
	}*/

mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET names=utf8');
mysqli_query($conn, 'SET character_set_client=utf8');
mysqli_query($conn, 'SET character_set_connection=utf8');
mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET collation_connection=utf8_general_ci');
if (isset($_REQUEST['id']) || isset($_POST['ulbid'])) {

	if (isset($_REQUEST['id'])) {
		$ulbid = $_REQUEST['id'];
	}

	$sql = "select open_comp_banner from users where ulbid='" . $ulbid . "'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$banner = $row['open_comp_banner'];

	if (isset($_GET['grievance_id'])) {
		$sql = "select update_image,file_url,grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id,date_regd from grievances where  grievance_id =" . $_GET['grievance_id'];
		if ($rs = mysqli_query($conn, $sql)) {

			$row = mysqli_fetch_assoc($rs);
			$field_info = mysqli_fetch_fields($rs);
			foreach ($field_info as $fi => $f)
				$data[$f->name] = $row[$f->name];
			if ($row['grievance_status_id'] <> 1) {
				$sql1 = "select file_url,transaction_id,emp_id,alloted_date,disposed_date,disposal_status,disposal_remarks,is_escalated,updated_by from grievances_transactions where  grievance_id =" . $_GET['grievance_id'] . " order by transaction_id asc";
				if ($rs1 = mysqli_query($conn, $sql1)) {
					$field_info = mysqli_fetch_fields($rs1);
					while ($row1 = mysqli_fetch_assoc($rs1)) {
						foreach ($field_info as $fi => $f)
							$data['transactions'][$row1['transaction_id']][$f->name] = $row1[$f->name];
					}
				}
			}
		} else
			printf("Errormessage: %s\n", mysqli_error($conn));

		$tpl->assign('data', $data);
	}
	//print_r($data);	
	$sql = "select ward_id,ward_desc from ward_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$ward_list[$row['ward_id']] = $row['ward_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "select street_id,street_desc from street_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$street_list[$row['street_id']] = $row['street_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select grievance_status_id,grievance_status_desc from grievance_status_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select grievance_origin_id,grievance_origin_desc from grievance_origin_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$grievance_origin_list[$row['grievance_origin_id']] = $row['grievance_origin_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "select dept_id,dept_desc from dept_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select desg_id,desg_desc from desg_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$desg_list[$row['desg_id']] = $row['desg_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = 'select emp_id,emp_name,emp_code,emp_dept,emp_desg,emp_mobile from emp_mst';
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$empt_list[$row['emp_id']]['emp_name'] = $row['emp_name'];
			$empt_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
			$empt_list[$row['emp_id']]['emp_dept'] = $dept_list[$row['emp_dept']];
			$empt_list[$row['emp_id']]['emp_desg'] = $desg_list[$row['emp_desg']];
			$empt_list[$row['emp_id']]['emp_code'] = $desg_list[$row['emp_name']];
		}
	} else {
		printf("Errormessage: %s\n", mysqli_error($conn));
	}
	$sql = 'select emp_id,emp_code,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od';
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$empt_list[$row['emp_id']]['emp_name'] = $row['emp_name'];
			$empt_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
			$empt_list[$row['emp_id']]['emp_dept'] = $dept_list[$row['emp_dept']];
			$empt_list[$row['emp_id']]['emp_desg'] = $desg_list[$row['emp_desg']];
		}
	} else {
		printf("Errormessage: %s\n", mysqli_error($conn));
	}

	// 		mysqli_close($conn);
	// 		echo "<pre>";
	// 		print_r($empt_list);
	// 		die();
	$tpl->assign('banner', $banner);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('street_list', $street_list);
	$tpl->assign('grievance_status_list', $grievance_status_list);
	$tpl->assign('grievance_origin_list', $grievance_origin_list);
	$tpl->assign('empt_list', $empt_list);

	$tpl->display('view_comp_det.tpl');
} else {
	//03-07-2024 header('location:https://egovmars.in/csms/');
	header('location:https://www.nmcnagpur.gov.in/grievance/');
}
