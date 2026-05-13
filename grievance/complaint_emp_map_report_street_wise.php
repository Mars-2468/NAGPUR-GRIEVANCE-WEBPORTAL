<?php 
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {


	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	//require_once('connection.php');
	$conn = getconnection();


	if (isset($_POST['submit'])) {


		$data = array();

		if (!empty($_POST['cs_id'])) {
			foreach ($_POST['cs_id'] as $key => $cs_id) {
				$data[] = $cs_id;
				$csid_list[$cs_id] = $cs_id;

				$sql = "select * from ward_mst where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "'  order by ward_id";
				$rs = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($rs)) {
					$ward_list[$cs_id][$row['ward_id']] = $row['ward_desc'];
				}

				$sql = "select * from street_mst where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and street_id NOT IN(select street_id from emp_map where cs_id='" . mysqli_real_escape_string($conn, $cs_id) . "' and ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and cs_type_id='1') order by ward_id";
				$rs = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($rs)) {
					$street_list[$cs_id][$row['ward_id']][$row['street_id']] = $row['street_desc'];
				}
			}
		}



		$sql = "select emp_id,emp_name,emp_mobile from emp_mst where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and delete_status='0' and emp_status='0'";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'] . "-" . $row['emp_mobile'];
		}


		$sql = "select emp_id,emp_name,emp_mobile from emp_mst_od where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and delete_status='0'";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'] . "-" . $row['emp_mobile'];
		}



		$sql = "select * from dept_mst where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' order by dept_id";

		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$dept_list[$row['dept_id']] = $row['dept_desc'];
		}

		/* $sql = "select * from category_mst where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' order by dept_id";

		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$cat_list[$row['cat_id']] = $row['description'];
		} */



		foreach ($_POST['cs_id'] as $key => $cs_id) {
			$sql = "select * from emp_map where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and flag='1' and cs_type_id='1' and cs_id='" . mysqli_real_escape_string($conn, $cs_id) . "'";

			$rs = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($rs)) {

				$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id'] = $emp_list[$row['emp_id']];
				$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id2'] = $emp_list[$row['emp_id2']];
				$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id3'] = $emp_list[$row['emp_id3']];
				$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id4'] = $emp_list[$row['emp_id4']];
				$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['dept_id'] = $dept_list[$row['dept_id']];
			}
		}

		//echo"<pre>";print_r($data2);echo"</pre>";die();

		foreach ($_POST['cs_id'] as $key => $cs_id) {

			$sql = "select * from ward_mst where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and ward_id IN(select ward_id from emp_map where cs_id='" . mysqli_real_escape_string($conn, $cs_id) . "' and ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and cs_type_id='1' and street_id !=0) order by ward_id";
			$rs = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($rs)) {
				$ward_list2[$cs_id][$row['ward_id']] = $row['ward_desc'];
			}

			$sql = "select * from street_mst where ulbid='" . $_SESSION['ulbid'] . "' and street_id IN(select street_id from emp_map where cs_id='" . mysqli_real_escape_string($conn, $cs_id) . "' and ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and cs_type_id='1') order by ward_id";
			$rs = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($rs)) {
				$street_list2[$cs_id][$row['ward_id']][$row['street_id']] = $row['street_desc'];
			}
		}



		$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$online_applications['trade_application'] = $row['trade_application'];
			$online_applications['water_tap_application'] = $row['water_tap_application'];
		}

		//	print_r($online_applications);

		$tpl->assign('online_applications', $online_applications);


		//print_r($data2);

		$tpl->assign('street_list', $street_list);
		$tpl->assign('ward_list2', $ward_list2);
		$tpl->assign('street_list2', $street_list2);
		$tpl->assign('csid_list', $csid_list);
		$tpl->assign('dept_list', $dept_list);
		$tpl->assign('emp_list', $emp_list);

		$tpl->assign('data', $data);
		$tpl->assign('data2', $data2);
		$tpl->assign('ward_list', $ward_list);
		$tpl->assign('cs_id_sel', $_POST['cs_id']);
		$tpl->assign('dept_id_sel', $_POST['dept_id']);
		$tpl->assign('emp_id_sel', $_POST['emp_id']);
		$tpl->assign('emp_id2_sel', $_POST['emp_id2']);
		$tpl->assign('emp_id3_sel', $_POST['emp_id3']);
		$tpl->assign('emp_id4_sel', $_POST['emp_id4']);
	}

	$errors = 0;
	if (isset($_POST['save'])) {


		for ($j = 0; $j < $_POST['cs_count']; $j++) {


			$cs_id = 'cs_id' . $j;

			for ($i = 0; $i < $_POST['file_count']; $i++) {

				$ward_id = "ward_id" . $i;
				$street_id = "street_id" . $i;
				$check = "check" . $i;



				if ($_POST[$street_id] != '') {
					$ward = explode("-", $_POST[$ward_id]);
					$street = explode("-", $_POST[$street_id]);

					if ($street[0] == $_POST[$cs_id]) {

						$sql = "insert into emp_map(street_id,ward_id,emp_id,emp_id2,emp_id3,emp_id4,cs_id,dept_id,ulbid,cs_type_id,flag) values ('" . mysqli_real_escape_string($conn, htmlspecialchars($street[2])) . "','" . mysqli_real_escape_string($conn, htmlspecialchars($street[1])) . "','" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['emp_id'])) . "','" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['emp_id2'])) . "','" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['emp_id3'])) . "','" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['emp_id4'])) . "','" . mysqli_real_escape_string($conn, htmlspecialchars($_POST[$cs_id])) . "','" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['dept_id'])) . "',  '" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "','1','1') ON DUPLICATE KEY UPDATE flag='1',emp_id='" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['emp_id'])) . "',emp_id2='" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['emp_id2'])) . "',emp_id3='" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['emp_id3'])) . "',emp_id4='" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['emp_id4'])) . "',dept_id='" . mysqli_real_escape_string($conn, htmlspecialchars($_POST['dept_id'])) . "'";

						if (mysqli_query($conn, $sql)) {
						} else {
							$errors++;
						}
					}
				}
			}
		}


		if ($errors > 0) {
			$tpl->assign('class', 'alert alert-danger display-hide');
			$tpl->assign('msg', 'Unable To Update Try Again..!');
		} else {
			$tpl->assign('class', 'alert alert-success display-hide');
			$tpl->assign('msg', 'Employees Mapped Successfully..!');
		}
	}

	$tpl->assign('data', $data);


	$sql = "select * from emp_map where cs_type_id='1' and ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$map_list[$row['ward_id']]['ward_id'] = $row['ward_id'];
		$map_list[$row['ward_id']]['dept_id'] = $row['dept_id'];
		$map_list[$row['ward_id']]['desg_id'] = $row['desg_id'];
		$map_list[$row['ward_id']]['emp_id'] = $row['emp_id'];
		$map_list[$row['ward_id']]['emp_id2'] = $row['emp_id2'];
		$map_list[$row['ward_id']]['cs_id'] = $row['cs_id'];
	}


	$tpl->assign('map_list', $map_list);


	/*$sql ="select c.cs_id,c.cs_desc as comp_desc from  cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid='".$_SESSION['ulbid']."' and cu.flag='1'";
		$rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $cs_list[$row['cs_id']]=$row['comp_desc'];
	       }
		$tpl->assign('cs_list',$cs_list);
	*/
	$sql = "SELECT cat_id,description FROM  `category_mst` ";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$cat_list[$row['cat_id']] = $row['description'];
	}

	$sql = "select c.cs_id,cs_desc,cam.cat_id,description from complaint_ulbmap c,cs_mst cm,category_mst cam where cam.cat_id=cm.cat_id and c.cs_id=cm.cs_id and c.ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' and flag='1' order by cs_id";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$cs_list[$row['description']][$row['cs_id']] = $row['cs_desc'] . " (" . $cat_list[$row['cat_id']] . ")";
		$cs_data[$row['cs_id']] = $row['cs_desc'] . " (" . $cat_list[$row['cat_id']] . ")";
	}

	$sql = "select * from dept_mst where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' order by dept_id";

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$dept_list[$row['dept_id']] = $row['dept_desc'];
	}
	$sql = "select emp_id,emp_name,emp_mobile from emp_mst where emp_dept='" . mysqli_real_escape_string($conn, $_POST['dept_id']) . "' and ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' and delete_status='0' and emp_status='0'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$emp_list[$row['emp_id']] = $row['emp_name'] . "-" . $row['emp_mobile'];
	}

	$sql = "select emp_id,emp_name,emp_mobile from emp_mst where emp_dept='" . mysqli_real_escape_string($conn, $_REQUEST['dept_id']) . "' and delete_status='0' and emp_status='0'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$emp_list2[$row['emp_id']] = $row['emp_name'] . "-" . $row['emp_mobile'];
	}

	$sql = "select * from desg_mst where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$desg_list[$row['desg_id']] = $row['desg_desc'];
	}

	$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);
	/*       
	 $sql="select cs.cs_desc,c.description,cu.cs_id from cs_mst cs,category_mst c,complaint_ulbmap cu where cs.cat_id=c.cat_id and cu.ulbid='".$_SESSION['ulbid']."'";
	       
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $cs_list1[$row['cs_desc']]=$row['description'];
	       }
	       
	        //print_r($cs_list1);
	  
	  
	  */

	mysqli_close($conn);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('cs_list1', $cs_list1);
	$tpl->assign('desg_list', $desg_list);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('cat_list', $cat_list);
	$tpl->assign('cs_data', $cs_data);

	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('services', $obj->services);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->display('complaint_emp_map_report_street_wise.tpl');
} else {
	header('location:index.php');
}
