<?php
require "config.php";
//include('responsible_sms.php');
?><?php
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors', 0);
	ini_set('include_path', ini_get('include_path') . ':/home/vmaxsdmg/php');
	require_once('Smarty.class.php');

	$app_type_id = $_REQUEST['app_type_id'];
	$origin_id = $_REQUEST['originid'];

	$tpl = new Smarty();

//echo "<pre>";print_r();die();

	if (isset($_SESSION['uid'])) {


		//session_regenerate_id();
		require_once('get_services.php');
		$obj = new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn = getconnection();

		$grievances_trns=$_SESSION['grievances_trns'];

		if ($_REQUEST['status'] == 0) {

			if ($_REQUEST['originid'] == '3') {

				$sql = "select count(grievance_id) as count,ulbid from grievances  where app_type_id=? and cat3_id !=? and 
		         (grievance_origin_id=? or grievance_origin_id=?) group by ulbid";
				$app_type_id = 1;
				$cat3_id = 0;
				//15-06-2024 $grievance_origin_id1 = 1;
				$grievance_origin_id1 = 3;
				$grievance_origin_id3 = 3;
				$query = $conn->prepare($sql);
				$query->bind_param("iiii", $app_type_id, $cat3_id, $grievance_origin_id1, $grievance_origin_id3);
			} else {
				
				$sql = "select count(distinct g.grievance_id) as count,g.ulbid from grievances g,". $grievances_trns ." gt, ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and 
				u.distid=d.distid and  grievance_status_id in(1,2,3,6,8,9,11,12,13) and app_type_id=? and cat3_id!=? and 
		                grievance_origin_id=?  group by ulbid ";
//echo $sql;exit;	
				
				if($_SESSION['user_type']=='E'){
					$sql = "select count(distinct g.grievance_id) as count,g.ulbid from grievances g,". $grievances_trns ." gt, ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and 
					u.distid=d.distid and  grievance_status_id in(1,2,3,6,8,9,11,12,13) and app_type_id=? and cat3_id!=? and 
		                grievance_origin_id=? and gt.emp_id=? group by ulbid ";
				}
				
				
//echo "<pre>";print_r($_SESSION);echo "</pre>";die();
					
				$app_type_id = 1;
				$cat3_id = 0;
				$grievance_origin_id = $_REQUEST['originid'];
				$query = $conn->prepare($sql);
				if($_SESSION['user_type']=='E'){
					$query->bind_param("iiii", $app_type_id, $cat3_id, $grievance_origin_id,$_SESSION['emp_id']);
				}else{
					$query->bind_param("iii", $app_type_id, $cat3_id, $grievance_origin_id);
				}
			}



			if ($_SESSION['user_type'] == 'R') {

				if ($_REQUEST['originid'] == '3') {


					$sql = "select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
        	       u.distid=d.distid and app_type_id=? and d.rdma=? and cat3_id !=? and 
        	       (grievance_origin_id=? or grievance_origin_id=?) group by g.ulbid order by ulbname";
					$app_type_id = 1;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$cat3_id = 0;
					$grievance_origin_id1 = 1;
					$grievance_origin_id2 = 3;
					$query = $conn->prepare($sql);
					$query->bind_param("isiii", $app_type_id, $rdma, $cat3_id, $grievance_origin_id1, $grievance_origin_id2);
				} else {



					$sql = "select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
        	       u.distid=d.distid and app_type_id=? and d.rdma=? and cat3_id !=? and 
        	       grievance_origin_id like ? group by g.ulbid order by ulbname";
					$app_type_id = 1;
					$rdma = $_SESSION['uid'];
					$cat3_id = 0;
					$grievance_origin_id = '%' . $_REQUEST['originid'] . '%';

					$query = $conn->prepare($sql);
					$query->bind_param("isiis", $app_type_id, $rdma, $cat3_id, $grievance_origin_id);
				}
			}
		} else if ($_REQUEST['app_type_id'] == 2) {
			if ($_REQUEST['status'] == 0) {
				$sql = "select count(grievance_id) as count,ulbid from grievances  where app_type_id=? and cat3_id !=? group by ulbid";
				$app_type_id = 2;
				$cat3_id = 0;
				$query = $conn->prepare($sql);
				$query->bind_param("ii", $app_type_id, $cat3_id);

				if ($_SESSION['user_type'] == 'R') {


					$sql = "select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid 
        	            and u.distid=d.distid and app_type_id=? and d.rdma=? and cat3_id !=? group by g.ulbid order 
        	            by ulbname";
					$app_type_id = 2;
					$cat3_id = 0;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$query = $conn->prepare($sql);
					$query->bind_param("isi", $app_type_id, $rdma, $cat3_id);
				}
			}
			if ($_REQUEST['status'] == 1) {


				$sql = "select count(grievance_id) as count,ulbid from grievances  where  
        	        app_type_id=? and grievance_status_id=? and cat3_id !=? group by ulbid";
				$app_type_id = 2;
				$grievance_status_id = 1;
				$cat3_id = 0;
				$query = $conn->prepare($sql);
				$query->bind_param("ii", $app_type_id, $grievance_status_id, $cat3_id);

				if ($_SESSION['user_type'] == 'R') {

					$sql = "select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d 
        	            where g.ulbid=u.ulbid and u.distid=d.distid and  app_type_id=? and grievance_status_id=? 
        	            and cat3_id !=? and d.rdma=? group by g.ulbid";
					$app_type_id = 2;
					$grievance_status_id = 1;
					$cat3_id = 0;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$query = $conn->prepare($sql);
					$query->bind_param("iiis", $app_type_id, $grievance_status_id, $cat3_id, $rdma);
				}
			}
			if ($_REQUEST['status'] == 2) {

				$sql = "select count(grievance_id) as count,ulbid from grievances where 
        	        (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and 
        	        app_type_id=? and sla_status=? and cat3_id !=? group by ulbid";
				$grievance_status_id1 = 3;
				$grievance_status_id2 = 8;
				$grievance_status_id3 = 9;
				$app_type_id = 2;
				$sla_status = 1;
				$cat3_id = 0;
				$query = $conn->prepare($sql);
				$query->bind_param("iiiiii", $grievance_status_id1, $grievance_status_id2, $grievance_status_id3, $app_type_id, $sla_status, $cat3_id);
				if ($_SESSION['user_type'] == 'R') {

					$sql = "select count(grievance_id) as count,g.ulbid  from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and 
        	            app_type_id=? and d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
					$grievance_status_id1 = 3;
					$grievance_status_id2 = 8;
					$grievance_status_id3 = 9;
					$app_type_id = 2;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$sla_status = 1;
					$cat3_id = 0;
					$query = $conn->prepare($sql);
					$query->bind_param(
						"iiiisii",
						$grievance_status_id1,
						$grievance_status_id2,
						$grievance_status_id3,
						$app_type_id,
						$rdma,
						$sla_status,
						$cat3_id
					);
				}
			}
			if ($_REQUEST['status'] == 3) {


				$sql = "select count(grievance_id) as count,ulbid from grievances where 
        	        (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and 
        	        app_type_id=? and sla_status=? and cat3_id !=? group by ulbid";
				$grievance_status_id1 = 3;
				$grievance_status_id2 = 8;
				$grievance_status_id3 = 9;
				$app_type_id = 2;

				$sla_status = 2;
				$cat3_id = 0;
				$query = $conn->prepare($sql);
				$query->bind_param(
					"iiiiii",
					$grievance_status_id1,
					$grievance_status_id2,
					$grievance_status_id3,
					$app_type_id,
					$sla_status,
					$cat3_id
				);



				if ($_SESSION['user_type'] == 'R') {


					$sql = "select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and(grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and 
        	            app_type_id=? and d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
					$grievance_status_id1 = 3;
					$grievance_status_id2 = 8;
					$grievance_status_id3 = 9;
					$app_type_id = 2;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$sla_status = 2;
					$cat3_id = 0;
					$query = $conn->prepare($sql);
					$query->bind_param(
						"iiiisii",
						$grievance_status_id1,
						$grievance_status_id2,
						$grievance_status_id3,
						$app_type_id,
						$rdma,
						$sla_status,
						$cat3_id
					);
				}
			}
			if ($_REQUEST['status'] == 4) {


				$sql = "select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	        app_type_id=? and sla_status=? and cat3_id !=? group by ulbid";
				$grievance_status_id = 2;
				$app_type_id = 2;
				$sla_status = 1;
				$cat3_id = 0;
				$query = $conn->prepare($sql);
				$query->bind_param("iiii", $grievance_status_id, $app_type_id, $sla_status, $cat3_id);
				if ($_SESSION['user_type'] == 'R') {


					$sql = "select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	            app_type_id=? and d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
					$grievance_status_id = 2;
					$app_type_id = 2;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$sla_status = 1;
					$cat3_id = 0;
					$query = $conn->prepare($sql);
					$query->bind_param("iisii", $grievance_status_id, $app_type_id, $rdma, $sla_status, $cat3_id);
				}
			}
			if ($_REQUEST['status'] == 5) {


				$sql = "select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	        app_type_id=? and sla_status=? and cat3_id !=? group by ulbid";
				$grievance_status_id = 2;
				$app_type_id = 2;

				$sla_status = 2;
				$cat3_id = 0;
				$query = $conn->prepare($sql);
				$query->bind_param("iiii", $grievance_status_id, $app_type_id, $sla_status, $cat3_id);

				if ($_SESSION['user_type'] == 'R') {


					$sql = "select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	            app_type_id=? and d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
					$grievance_status_id = 2;
					$app_type_id = 2;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$sla_status = 2;
					$cat3_id = 0;
					$query = $conn->prepare($sql);
					$query->bind_param("iisii", $grievance_status_id, $app_type_id, $rdma, $sla_status, $cat3_id);
				}
			}
			if ($_REQUEST['status'] == 6) {
				$sql = "select count(g.grievance_id) as count,g.ulbid from grievances  where app_type_id=? and 
        	        grievance_status_id=? and cat3_id !=? group by ulbid";
				$app_type_id = 2;
				$grievance_status_id = 6;
				$cat3_id = 0;
				$query = $conn->prepare($sql);
				$query->bind_param("iii", $app_type_id, $grievance_status_id, $cat3_id);
				if ($_SESSION['user_type'] == 'R') {
					$sql = "select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id=? and grievance_status_id=? and d.rdma=? and sla_status=?
        	            and cat3_id !=? group by ulbid";
					$app_type_id = 2;
					$grievance_status_id = 6;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$sla_status = 2;
					$cat3_id = 0;
					$query = $conn->prepare($sql);
					$query->bind_param("iisii", $app_type_id, $grievance_status_id, $rdma, $sla_status, $cat3_id);
				}
			}

			/** rejected ***/

			if ($_REQUEST['status'] == 10) {



				$sql = "select count(grievance_id) as count,ulbid from grievances where app_type_id=? and grievance_status_id=? 
        	         and cat3_id !=? group by ulbid";
				$app_type_id = 2;
				$grievance_status_id = 10;

				$cat3_id = 0;
				$query = $conn->prepare($sql);
				$query->bind_param("iii", $app_type_id, $grievance_status_id, $cat3_id);

				if ($_SESSION['user_type'] == 'R') {


					$sql = "select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id=? and grievance_status_id=? and d.rdma=? and cat3_id !=?
        	            group by g.ulbid";
					$app_type_id = 2;
					$grievance_status_id = 10;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$cat3_id = 0;
					$query = $conn->prepare($sql);
					$query->bind_param("iisi", $app_type_id, $grievance_status_id, $rdma, $cat3_id);
				}
			}

			/*** un resolvable  ***/


			if ($_REQUEST['status'] == 11) {

				$sql = "select count(grievance_id) as count,ulbid from grievances  where app_type_id=? 
        	        and grievance_status_id=? group by ulbid";
				$app_type_id = 2;
				$grievance_status_id = 4;
				$query = $conn->prepare($sql);
				$query->bind_param("ii", $app_type_id, $grievance_status_id);



				if ($_SESSION['user_type'] == 'R') {


					$sql = "select count(grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id=? and grievance_status_id=? and d.rdma=? and cat3_id !=?
        	            group by g.ulbid";
					$app_type_id = 2;
					$grievance_status_id = 4;
					$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
					$cat3_id = 0;
					$query = $conn->prepare($sql);
					$query->bind_param("iisi", $app_type_id, $grievance_status_id, $rdma, $cat3_id);
				}
			}
		}


		$query->execute();
		$rs = $query->get_result();
		//echo "<pre>";print_r($rs);echo "</pre>";die();
		$data=[];
		$tot=0;
		while ($row = $rs->fetch_assoc()) {

			$data[$row['ulbid']]['count'] += $row['count'];
			$tot += $row['count'];
		}

//echo "<pre>";print_r($data);echo "</pre>";die();
//echo $tot;exit;

		$tpl->assign('tot', $tot);
		$tpl->assign('resolved_beyond_sla', $resolved_beyond_sla);


		if ($_REQUEST['status'] == 0 || $_REQUEST['status'] == 1 || $_REQUEST['status'] == 2 || $_REQUEST['status'] == 6 || $_REQUEST['status'] == 10 || $_REQUEST['status'] == 11) {


			$query->execute();
			$rs = $query->get_result();
			while ($row = $rs->fetch_assoc()) {

				$data[$row['ulbid']]['count'] = $row['count'];
				$total += $row['count'];
			}
		}
		$tpl->assign('total', $total);



		$sql = "select u.* from ulbmst u,Districtmst d where u.distid=d.distid";
		$query = $conn->prepare($sql);
		if ($_SESSION['user_type'] == 'R') {

			$sql .= " and d.rdma=?";
			$query = $conn->prepare($sql);
			$rdma = htmlspecialchars(strip_tags($_SESSION['uid']));
			$query->bind_param("s", $rdma);
		}


		$query->execute();
		$rs = $query->get_result();
		while ($row = $rs->fetch_assoc()) {

			$ulb_list[$row['ulbid']] = $row['ulbname'];
		}

		$conn->close();
		$tpl->assign('apptypes', array('1' => 'Complaints', '2' => 'Services'));
		$tpl->assign('status_desc', array('0' => 'Total Received', '1' => 'Pending For Approval', '2' => 'Completed Within SLA', '3' => 'Completed Beyond SLA', '4' => 'Pending Within SLA', '5' => 'Pending Beyond SLA', '6' => 'Financial Implication', '10' => 'Rejected', '11' => 'Un Resolvable'));
		$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
		$tpl->assign('status', $_REQUEST['status']);
		$tpl->assign('ulb_list', $ulb_list);
		$tpl->assign('ulb_list1', $ulb_list1);
		$tpl->assign('preg', $_POST['regionid']);
		$tpl->assign('pulb', $_POST['ulbid']);
		$tpl->assign('pdist', $_POST['distid']);
		$tpl->assign('region_list', $region_list);
		$tpl->assign('dist_list', $dist_list);

		$tpl->assign('feedback_count', $feedback_count);
		$tpl->assign('online_applications', $online_applications);
		$tpl->assign('tot_complaints', $tot_complaints);
		$tpl->assign('res_complaints', $res_complaints);
		$tpl->assign('res_services', $res_services);
		$tpl->assign('datalist', $datalist);
		$tpl->assign('ulb_list', $ulb_list);
		$tpl->assign('origin_rep', $origin_rep);
		$tpl->assign('origin_list', $origin_list);

		$tpl->assign('tanker_enable_status', $tanker_enable_status);
		$tpl->assign('map', $map);
		$tpl->assign('pic', $pic);
		$tpl->assign('data', $data);
		$tpl->assign('data1', $data1);
		$tpl->assign('ulbid', $_SESSION['ulbid']);
		$tpl->assign('origin_id', $_REQUEST['originid']);
		$tpl->assign('user_type', $_SESSION['user_type']);
		$tpl->assign('banner', $_SESSION['banner']);
		$tpl->assign('logo', $_SESSION['logo']);
		$tpl->assign('services', $obj->services);
		$tpl->assign('main_icons', $obj->main_icons);
		$tpl->assign('uname', $_SESSION['user_name']);
		$tpl->assign('uid', $_SESSION['uid']);
		$tpl->display('cdma_ulbwise_origin_rep.tpl');
	} else {

		echo "<script>window.location='index.php';</script>";
	}
	?>