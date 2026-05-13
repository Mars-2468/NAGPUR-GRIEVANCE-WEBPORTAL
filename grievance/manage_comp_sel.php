<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);

require_once('Smarty.class.php');

$tpl = new Smarty();

//echo "<pre>";print_r($_POST);echo "</pre>";die();



if (isset($_SESSION['uid'])) {

	//session_regenerate_id();

	require_once('get_services.php');

	$obj = new get_services($_SESSION['uid']);

	require_once('connection.php');

	$conn = getconnection();
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

	$sql = "select grievance_id,app_type_id,person_name,park_name,email,hno,address,ward_id,street_id,mobile,cat3_id,comp_desc,grievance_origin_id,grievance_status_id,date_regd,file_no,endorsement,mcat3_id,file_url,grievance_at_emp_level from grievances where grievance_id='" . $_POST['grievance_id'] . "' and ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		$field_info = mysqli_fetch_fields($rs);

		$row = mysqli_fetch_assoc($rs);

		foreach ($field_info as $fi => $f)

			$data1[$f->name] = $row[$f->name];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

		$grievance_at_emp_level= $row['grievance_at_emp_level'];
		//echo $grievance_at_emp_level;

	$sql = "select * from category3_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {

		$cat3_list[$row['cs_id']] = $row['comp_desc'];
	}

	$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$emp_list[$row['emp_id']]['emp_id'] = $row['emp_id'];

			$emp_list[$row['emp_id']]['emp_name'] = $row['emp_name'];

			$emp_list[$row['emp_id']]['emp_dept'] = $row['emp_dept'];

			$emp_list[$row['emp_id']]['emp_desg'] = $row['emp_desg'];

			$emp_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$emp_list[$row['emp_id']]['emp_id'] = $row['emp_id'];

			$emp_list[$row['emp_id']]['emp_name'] = $row['emp_name'];

			$emp_list[$row['emp_id']]['emp_dept'] = $row['emp_dept'];

			$emp_list[$row['emp_id']]['emp_desg'] = $row['emp_desg'];

			$emp_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

		// 		die('testing');

	$sql = "select ward_id,ward_desc from ward_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$ward_list[$row['ward_id']] = $row['ward_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select street_id,street_desc from street_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$street_list[$row['street_id']] = $row['street_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select desg_id,desg_desc from desg_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$desg_list[$row['desg_id']] = $row['desg_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select grievance_origin_id,grievance_origin_desc from grievance_origin_mst";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$grievance_origin_list[$row['grievance_origin_id']] = $row['grievance_origin_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	if (isset($_POST['grievance_id'])) {

		$sql = "select app_type_id,mcat3_id,cat3_id,app_type_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id,date_regd,grievance_at_emp_level from grievances where grievance_id='" . $_POST['grievance_id'] . "' and ulbid='" . $_SESSION['ulbid'] . "'";

		if ($rs = mysqli_query($conn, $sql)) {

			$field_info = mysqli_fetch_fields($rs);

			$row = mysqli_fetch_assoc($rs);

			foreach ($field_info as $fi => $f)

				$data1[$f->name] = $row[$f->name];
		} else

			printf("Errormessage: %s\n", mysqli_error($conn));

		$sql = "select transaction_id,emp_id,DATE_FORMAT(alloted_date, '%Y-%m-%d') AS alloted_date,gt.disposed_date,gt.disposal_status,gt.disposal_remarks,app_type_id,rca,ca,gt.dept_id,g.grievance_at_emp_level,g.comp_desc,g.comp_subject from grievances g, grievances_transactions gt where  g.grievance_id=gt.grievance_id and gt.grievance_id='" . $_POST['grievance_id'] . "' and disposal_status IN('2','11','6','5','10') order by transaction_id DESC LIMIT 1"; // modified on 19-07-2024  added DESC LIMIT 1

		if ($rs = mysqli_query($conn, $sql)) {

			$transaction_id = 0;

			while ($row = mysqli_fetch_assoc($rs)) {

				$data2[$row['transaction_id']]['emp_id'] = $row['emp_id'];				

				$data2[$row['transaction_id']]['alloted_date'] = $row['alloted_date'];

				$data2[$row['transaction_id']]['disposed_date'] = $row['disposed_date'];

				$data2[$row['transaction_id']]['disposal_status'] = $row['disposal_status'];

				$data2[$row['transaction_id']]['disposal_remarks'] = $row['disposal_remarks'];
				$data2[$row['transaction_id']]['comp_desc'] = $row['comp_desc'];
				$data2[$row['transaction_id']]['comp_subject'] = $row['comp_subject'];
				$data2[$row['transaction_id']]['dept_id'] = $row['dept_id'];

				$data2[$row['transaction_id']]['rca'] = $row['rca'];

				$data2[$row['transaction_id']]['ca'] = $row['ca'];

				$transaction_id = $row['transaction_id'];

				$dept_id = $data2[$row['transaction_id']]['dept_id'];

				$Level1_emp_id = $data2[$row['transaction_id']]['emp_id'];

				$app_type_id = $row['app_type_id'];
			}

			$tpl->assign('data2', $data2);
			$tpl->assign('emp_current_lvl', $emp_current_lvl);
			$tpl->assign('Level1_emp_id', $Level1_emp_id);
			$tpl->assign('transaction_id', $transaction_id);
			$tpl->assign('dept_id', $dept_id);
		}

		$tpl->assign('grievance_id', $_POST['grievance_id']);
		$tpl->assign('emp_lvl', $emp_lvl);
		
		$tpl->assign('data1', $data1);

		if ($grievance_at_emp_level == 'L1') {
			$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "' and dept_id = '" . $dept_id . "'";
		}
		else{
			$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";
		}
			if ($rs = mysqli_query($conn, $sql)) {

				while ($row = mysqli_fetch_assoc($rs))

					$dept_list[$row['dept_id']] = $row['dept_desc'];
			} else

				printf("Errormessage: %s\n", mysqli_error($conn));

		if ($app_type_id == '1') {

			$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('2','9','4','5','6') ORDER BY FIELD (grievance_status_id, 2,5,9,6,4)";

			$sql = "select grievance_status_id from grievances where grievance_id='" . $_POST['grievance_id'] . "'";

			$rs = mysqli_query($conn, $sql);

			$row = mysqli_fetch_assoc($rs);

			$status = $row['grievance_status_id'];
			
			if ($status == '11' && in_array($data1['grievance_at_emp_level'],['L1','L2','L3'])) {
//13,11,12
				$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('10','12','11','13')";
			
			}else if ($status == '11' && in_array($data1['grievance_at_emp_level'],['L4'])) {

				$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('12','5')";
			
			}else if(($status == '6' || $status == '2') && in_array($data1['grievance_at_emp_level'],['L1','L2','L3'])){
				
				$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('2','5','9')";
			
			}else if(($status == '6' || $status == '2') && in_array($data1['grievance_at_emp_level'],['L4'])){
			//echo "<pre>";print_r($status);echo "</pre>";die('sss');	
				$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('2','5','9',6)";
			}

			$sql = "select cs_id,cs_desc as comp_desc from cs_mst";
		} else {

			$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('2','5','9','6','4')";

			//	$sql ="select cs_id,comp_desc from category3_mst where ulbid='".$_SESSION['ulbid']."'";

			$sql = "select cs_id, cs_desc as comp_desc from standard_services";
		}

		$rs = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_assoc($rs)) {

			$cs_list[$row['cs_id']] = $row['comp_desc'];
		}

		$tpl->assign('cs_list', $cs_list);

		if ($rs = mysqli_query($conn, $sql_status)) {

			while ($row = mysqli_fetch_assoc($rs))
				$grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
		} else

			printf("Errormessage: %s\n", mysqli_error($conn));
	}

	if (isset($_POST['escalate_page'])) {

		$sql = "select * from grievances_transactions where grievance_id ='" . $_POST['grievance_id'] . "' and emp_id='" . $_SESSION['emp_id'] . "' order by transaction_id DESC limit 1";
		$rsesc = mysqli_query($conn, $sql);
		$trns_row  = mysqli_fetch_assoc($rsesc);
		$trns_id = $trns_row['transaction_id'];
		$tpl->assign('transaction_id', $trns_id);
	}

	mysqli_free_result($rs);

	mysqli_close($conn);

	$tpl->assign('app_type_id', $_POST['app_type_id']);

	$tpl->assign('ward_list', $ward_list);

	$tpl->assign('street_list', $street_list);

	$tpl->assign('desg_list', $desg_list);

	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('emp_list', $emp_list);

	$tpl->assign('grievance_origin_list', $grievance_origin_list);

	$tpl->assign('grievance_status_list', $grievance_status_list);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);
	$flash = get_flash();		
	$tpl->assign("flash", $flash);  
	$tpl->display('manage_comp_sel.tpl');
	
} else {

		echo "<script>window.location='index.php';</script>";
}


