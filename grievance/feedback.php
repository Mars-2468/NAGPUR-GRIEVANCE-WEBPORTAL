<?php
require "config.php";
ini_set('display_errors', 0);

if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != 1) {
	$indexpage = "complaint_form.php";
	//header("location:$indexpage");
	echo "<script>window.location='$indexpage';</script>";
}

require_once('Smarty.class.php');
$tpl = new Smarty();
require_once('connection.php');
$conn = getconnection();
mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET names=utf8');
mysqli_query($conn, 'SET character_set_client=utf8');
mysqli_query($conn, 'SET character_set_connection=utf8');
mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

// 	echo $_SESSION['login_status'];
// 	echo $_SESSION['com_reg_mobile'];
// 	die();

//echo "<pre>";print_r($_SESSION);echo "</pre>";die();

if ($_SESSION['login_status'] == 1) {
	if (isset($_REQUEST['id']) || isset($_POST['ulbid'])) {


		if (isset($_REQUEST['id'])) {
			$ulbid = $_REQUEST['id'];
		}
		if (isset($_REQUEST['grievance_id'])) {
			$grievance_id = $_REQUEST['grievance_id'];
		}
		if ($_SESSION['login_status']) {
			$ulbid = $_SESSION['ulbid'];
		}
		
		$stmt = $conn->prepare("SELECT rating_status FROM rating_mst WHERE grievance_id = ?");
		$stmt->bind_param("i", $grievance_id);
		
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

	//echo "<pre>";print_r($grievance_id );echo "</pre>"; die();

		if($row['rating_status']==0){	
			$rating_options=[
				1=>1,
				2=>2,
				3=>3,
				4=>4,
				5=>5		
			];
		}else{
			$rating_options=[			
				4=>4,
				5=>5		
			];
		}
		
		

		$sql = "SELECT *  FROM  grievances G
			LEFT JOIN ward_mst W  ON W.ward_id = G.ward_id 
			LEFT JOIN street_mst S  ON S.street_id = G.street_id 
			LEFT JOIN cs_mst C  ON C.cs_id = G.cat3_id 

			where G.grievance_id = '" . $grievance_id . "' ";
		//ECHO $sql ; exit;
		$rs = mysqli_query($conn, $sql);
		$grievances = mysqli_fetch_assoc($rs);
		//echo "<pre>";	print_r($grievances );

		$sql = "SELECT *  FROM  feedback_sub_options  ";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {

			$sub_options[] = array(
				'sub_option_id'	=> $row['sub_option_id'],
				'description'	=> $row['description'],

			);
		}

		if (isset($_POST['save'])) {
			
			

			date_default_timezone_get('Asia/Calcutta');
			$date = date('Y-m-d H:i:s');

		/* 	$sql = "INSERT INTO `rating_mst`(`grievance_id`, `rating_no`, `comment_desc`, `ts`, `sub_option_id`,`imei_no`,`resolved_id`)
			  VALUES ('" . $_POST['grievance_id'] . "','" . $_POST['grievance_status_id'] . "','" . $_POST['description'] . "','" . $date . "','" . $_POST['grievance_sub_options'] . "','" . $_POST['mobile'] . "','" . $_POST['grievance_sub_options'] . "')  ON DUPLICATE KEY UPDATE comment_desc='" . mysqli_real_escape_string($conn, $_POST['description']) . "',resolved_id='" . $_POST['grievance_sub_options'] . "' "; //com_reg_mobile
		 */	
		 
		 $sql = "INSERT INTO `rating_mst`(`grievance_id`, `rating_no`, `comment_desc`, `ts`, `sub_option_id`,`imei_no`,`resolved_id`,`rating_given_by`,`rating_given_ref`)
		  VALUES ('" . $_POST['grievance_id'] . "','" . $_POST['grievance_status_id'] . "','" . $_POST['description'] . "','" . $date . "','" . $_POST['grievance_sub_options'] . "','" . $_POST['mobile'] . "','" . $_POST['grievance_sub_options'] . "','" . $_POST['mobile'] . "','citizen')  ON DUPLICATE KEY UPDATE comment_desc='" . mysqli_real_escape_string($conn, $_POST['description']) . "',resolved_id='" . $_POST['grievance_sub_options'] . "',rating_given_by='" . $_POST['mobile'] . "' ,rating_given_ref='citizen' ";
	 
		// echo "<pre>";	print_r($sql );echo "</pre>"; die();
	
			//echo $sql; exit;
			$insert_id = mysqli_query($conn, $sql);

			if ($insert_id) {

				$sql = "update grievances set feedback_status='1' where grievance_id='" . $_POST['grievance_id'] . "'";
				mysqli_query($conn, $sql);
				//exit;

				if ($_POST['grievance_sub_options'] == '11') {
					$_REQUEST['generic_id'] = $_POST['grievance_id'];
					$_REQUEST['rating_no'] = $_POST['grievance_status_id'];
					$_REQUEST['imei_no'] = $_POST['mobile'];
					$_REQUEST['comment_desc'] = $_POST['description'];

					$suboptionid = '13';

					$sql = "insert into reopen_transactions(grievance_id,imei_no,rating_no,comment_desc,sub_option_id)values('" . $_REQUEST['generic_id'] . "','" . $_REQUEST['imei_no'] . "','" . $_REQUEST['rating_no'] . "','" . mysqli_real_escape_string($conn, $_REQUEST['comment_desc']) . "','" . $suboptionid . "')";
					//exit;
					mysqli_query($conn, $sql);


					// checking weather grievance already reopened or not

					$sql = "select grievance_id from grievances_transactions where grievance_id='" . $_REQUEST['generic_id'] . "' and is_reopened_yn='1'";
					$rs = mysqli_query($conn, $sql);
					$nr_reopen = mysqli_num_rows($rs);


					$sql = "select * from grievances_transactions where grievance_id='" . $_REQUEST['generic_id'] . "' and disposal_status !='5'";
					$rs = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($rs);
					$trnxid = $row['transaction_id'] + 1;
					$sql = "insert into grievances_transactions (
						grievance_id,
						transaction_id,
						emp_id,
						dept_id,
						alloted_date,
						disposed_date,
						disposal_status,
						disposal_remarks,
						is_reopened_yn
						) values(
							'" . $_REQUEST['generic_id'] . "',
							'" . $trnxid . "',
							'" . $row['emp_id'] . "',
							'" . $row['dept_id'] . "',
							'" . date('Y-m-d H:i:s') . "',
							'" . date('Y-m-d H:i:s') . "',
							'13', 
							'" . mysqli_real_escape_string($conn, $_REQUEST['comment_desc']) . "','1')";

					mysqli_query($conn, $sql);
					$sql = "update grievances set grievance_status_id='13' where grievance_id='" . $_REQUEST['generic_id'] . "'";
					mysqli_query($conn, $sql);

					/* $sql ="update  grievances_transactions set is_reopened_yn='1' where grievance_id='".$_REQUEST['generic_id']."' and disposal_status ='9'";
								mysqli_query($conn,$sql);
								*/
					$comp_completed_withinsla = 0;
					$comp_completed_beyondsla = 0;
					/* WRITE BY  NAGARAJU */
					$sql = "select ulbid,cat3_id,street_id,ward_id from grievances where grievance_id='" . $_REQUEST['generic_id'] . "'";
					$rs = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($rs);
					$ulbid = $row['ulbid'];
					$cat3_id = $row['cat3_id'];
					$street_id = $row['street_id'];
					$ward_id = $row['ward_id'];

					$sql1 = "select * from emp_map where cs_id='" . $cat3_id . "' AND street_id='" . $street_id . "' AND ward_id='" . $ward_id . "' AND cs_type_id=1";
					$rs1 = mysqli_query($conn, $sql1);
					$row1 = mysqli_fetch_assoc($rs1);
					$emp_id2 = $row1['emp_id2'];

					/* GRIEVANCE UNDER PROGRESS */

					$sql = "select * from grievances_transactions where grievance_id='" . $_REQUEST['generic_id'] . "' ORDER BY transaction_id DESC LIMIT 1 ";
					$rs = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($rs);
					$trnxid = $row['transaction_id'] + 1;
					$sql = "insert into grievances_transactions (
							grievance_id,
							transaction_id,
							emp_id,
							dept_id,
							alloted_date,
							disposal_status,
							disposal_remarks,
							is_reopened_yn
							) values(
								'" . $_REQUEST['generic_id'] . "',
								'" . $trnxid . "',
								'" . $emp_id2 . "',
								'" . $row['dept_id'] . "',
								'" . date('Y-m-d H:i:s') . "',
								'11',
								'" . mysqli_real_escape_string($conn, $_REQUEST['comment_desc']) . "','1')";
					mysqli_query($conn, $sql);
					$sql = "update grievances set grievance_status_id='11', grievance_at_emp_level='L2' where grievance_id='" . $_REQUEST['generic_id'] . "'";
					mysqli_query($conn, $sql);
					/* ABIVE WRITE BY NAGARAJU */

					$sql = "select ulbid from grievances where grievance_id='" . $_REQUEST['generic_id'] . "'";
					$rs = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($rs);
					$ulbid = $row['ulbid'];


					$sql5 = "select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,
					ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and 
					g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','10','4','9')  and gt.disposal_status !=5 and 
					g.ulbid='" . $ulbid . "' and g.app_type_id='1' and grievance_id='" . $_REQUEST['generic_id'] . "'";

					$sql5 = "select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status, ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and gt.disposal_status IN('13') and gt.disposal_status !=5 and g.ulbid='" . $ulbid . "' and g.app_type_id='1' and g.grievance_id='" . $_REQUEST['generic_id'] . "' and transaction_id = (select MAX(transaction_id) from grievances_transactions where grievance_id='" . $_REQUEST['generic_id'] . "')";

					$res5 = mysqli_query($conn, $sql5);
					while ($row5 = mysqli_fetch_assoc($res5)) {
						if ($row5['target'] <= $row5['target_days']) {
							// getting completed with in sla count

							$sql = "select completed_sla from dashboard_count where ulbid='" . $ulbid . "' and app_type_id='1'";
							$rs = mysqli_query($conn, $sql);
							$row = mysqli_fetch_assoc($rs);
							$completed_sla = $row['completed_sla'] - 1;
							$sql = "update dashboard_count set completed_sla='" . $completed_sla . "' where ulbid='" . $ulbid . "' and app_type_id='1'";
							mysqli_query($conn, $sql);

							// checks for already reopened or not


							if ($nr_reopen > 0) // if already existed updating counts
							{
								$sql = "select reopened_completed,reopened from dashboard_count where ulbid='" . $ulbid . "' and app_type_id='1'";
								$rs = mysqli_query($conn, $sql);
								$row = mysqli_fetch_assoc($rs);
								$reopened_completed = $row['reopened_completed'] - 1;
								$reopened = $row['reopened'] + 1;
								$sql = "update dashboard_count set reopened_completed='" . $reopened_completed . "',reopened='" . $reopened . "' where ulbid='" . $ulbid . "' and app_type_id='1'";
								mysqli_query($conn, $sql);
							} else {
								$sql = "select reopened from dashboard_count where ulbid='" . $ulbid . "' and app_type_id='1'";
								$rs = mysqli_query($conn, $sql);
								$row = mysqli_fetch_assoc($rs);

								$reopened = $row['reopened'] + 1;
								$sql = "update dashboard_count set reopened='" . $reopened . "' where ulbid='" . $ulbid . "' and app_type_id='1'";
								mysqli_query($conn, $sql);
							}
						} else {
							$sql = "select completed_be_sla from dashboard_count where ulbid='" . $ulbid . "' and app_type_id='1'";
							$rs = mysqli_query($conn, $sql);
							$row = mysqli_fetch_assoc($rs);
							$completed_be_sla = $row['completed_be_sla'] - 1;
							$sql = "update dashboard_count set completed_be_sla='" . $completed_be_sla . "' where ulbid='" . $ulbid . "' and app_type_id='1'";
							mysqli_query($conn, $sql);

							// checks for already reopened or not


							if ($nr_reopen > 0) // if already existed updating counts
							{
								$sql = "select reopened_completed,reopened from dashboard_count where ulbid='" . $ulbid . "' and app_type_id='1'";
								$rs = mysqli_query($conn, $sql);
								$row = mysqli_fetch_assoc($rs);
								$reopened_completed = $row['reopened_completed'] - 1;
								$reopened = $row['reopened'] + 1;
								$sql = "update dashboard_count set reopened_completed='" . $reopened_completed . "',reopened='" . $reopened . "' where ulbid='" . $ulbid . "' and app_type_id='1'";
								mysqli_query($conn, $sql);
							} else {
								$sql = "select reopened from dashboard_count where ulbid='" . $ulbid . "' and app_type_id='1'";
								$rs = mysqli_query($conn, $sql);
								$row = mysqli_fetch_assoc($rs);

								$reopened = $row['reopened'] + 1;
								$sql = "update dashboard_count set reopened='" . $reopened . "' where ulbid='" . $ulbid . "' and app_type_id='1'";
								mysqli_query($conn, $sql);
							}
						}
					}
				}

				$tpl->assign('class', 'alert alert-success display-hide');
				$tpl->assign('msg', 'Successfully Inserted');
				$_SESSION['success_message'] = 'Inserted successfully';
				$url =  "check_comp_status.php?id=250";
				echo '<script type="text/javascript">window.location.href="' . $url . '"</script>';
				exit;
			}
		}


		mysqli_close($conn);
		$tpl->assign('ulbid', $ulbid);
		$tpl->assign('grievances', $grievances);
		$tpl->assign('sub_options', $sub_options);
		$tpl->assign('rating_options', $rating_options);
		$tpl->assign('ward_list', $ward_list);
		$tpl->assign('grievance_status_list', $grievance_status_list);
		$tpl->display('feedback.tpl');
	} else {
		//echo "hi"; exit;
		header('location:check_comp_status.php?id=250');
	}
}
?>