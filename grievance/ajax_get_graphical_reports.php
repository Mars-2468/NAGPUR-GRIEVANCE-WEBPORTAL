<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('get_services.php');
$obj = new get_services($_SESSION['uid']);
require_once('connection.php');
$conn = getconnection();


$report_id = $_POST['report_id'];

if ($report_id == 1 || $report_id == 6) {

	$sql = "select * from cs_mst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$cs_list[$row['cs_id']] = $row['cs_desc'];
		$ratings[$row['cs_id']][1]['rating_no'] = 0;
		$ratings[$row['cs_id']][2]['rating_no'] = 0;
		$ratings[$row['cs_id']][3]['rating_no'] = 0;
		$ratings[$row['cs_id']][4]['rating_no'] = 0;
		$ratings[$row['cs_id']][5]['rating_no'] = 0;
	}



	$sql = $conn->prepare("select count(r.grievance_id) as count,c.cs_id,rating_no from rating_mst r , grievances g , cs_mst c where g.grievance_id = r.grievance_id and 
			c.cs_id = g.cat3_id group by g.cat3_id, rating_no");



	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$ratings[$row['cs_id']][$row['rating_no']]['rating_no'] = $row['count'];
	}
}
if ($report_id == 2) {

	$sql = "select * from cs_mst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$cs_list[$row['cs_id']] = $row['cs_desc'];
		$ratings[$row['cs_id']]['avg_rating'] = 0;
	}



	$sql = $conn->prepare("select AVG(r.rating_no) as count,c.cs_id from rating_mst r , grievances g , cs_mst c where g.grievance_id = r.grievance_id and 
			c.cs_id = g.cat3_id group by g.cat3_id");



	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$ratings[$row['cs_id']]['avg_rating'] = $row['count'];
	}
} else if ($report_id == 3) {

	$total_resolved = 0;
	$total_pending = 0;


	$sql = "select count(grievance_id) as count from grievances where grievance_status_id=9";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$total = $row['count'];
	}

	$sql = "select count(grievance_id) as count from rating_mst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$total_feedback_resolved = $row['count'];
	}


	$total_feedback_pending = $total - $total_feedback_resolved;
} else if ($report_id == 5) {

	$total_resolved = 0;
	$total_pending = 0;

	$sql = "select count(grievance_id) as count,grievance_status_id  from grievances where app_type_id ='1' group by  grievance_status_id";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data[$row['grievance_status_id']]['count'] = $row['count'];
	}

	$total_resolved = $data[9]['count'];
	$total_pending = $data[2]['count'];
	$data[1]['fin'] = $data[6]['count'];
	$reopened_completed_tot[1][13]['count'] = $data[13]['count'];
} else if ($report_id == 7) {

	$sql = "SELECT count(`grievance_id`) as count , cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id FROM `grievances` g, cs_mst c, category_mst cm where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id   group by cat3_id order by count DESC";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$comp_details[$row['cat3_id']]['count'] = $row['count'];
		$tot[$row['cat3_id']]['total'] += $row['count'];


		$comp_details[$row['cat3_id']]['cat_id'] = $row['cat_id'];
		$comp_details[$row['cat3_id']]['sub_cat_id'] = $row['sub_cat_id'];
		$max_comp_details[$row['cat3_id']]['count'] += $row['count'];
		$max_comp_details[$row['cat3_id']]['cat3_id'] = $row['cat3_id'];
	}

	$column = array_column($max_comp_details, 'count');
	array_multisort($column, SORT_DESC, $max_comp_details);

	$max_comp_details = array_slice($max_comp_details, 0, 10);

	$sql = "select * from cs_mst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$cs_list[$row['cs_id']] = $row['cs_desc'];
	}
} else if ($report_id == 9) {

	$sql = "SELECT count(`grievance_id`) as count , ward_id as cat3_id,description,cm.cat_id,c.sub_cat_id FROM `grievances` g, cs_mst c, category_mst cm where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id group by ward_id order by count DESC";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$comp_details[$row['cat3_id']]['count'] = $row['count'];
		$tot[$row['cat3_id']]['total'] += $row['count'];


		$comp_details[$row['cat3_id']]['cat_id'] = $row['cat_id'];
		$comp_details[$row['cat3_id']]['sub_cat_id'] = $row['sub_cat_id'];
		$max_comp_details[$row['cat3_id']]['count'] += $row['count'];
		$max_comp_details[$row['cat3_id']]['cat3_id'] = $row['cat3_id'];
	}

	$column = array_column($max_comp_details, 'count');
	array_multisort($column, SORT_DESC, $max_comp_details);

	$max_comp_details = array_slice($max_comp_details, 0, 10);

	$sql = "select * from ward_mst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$cs_list[$row['ward_id']] = $row['ward_desc'];
	}
}



?>


<p></p>

<div class="row">
	<div class="col-md-12">


		<?php if ($report_id == 5) {

			include('piechart.php');
		} else if ($report_id == 1 || $report_id == 6) {

			include('citizen_satisfaction_chart.php');
		} else if ($report_id == 2) {

			include('citizen_avg_satisfaction_chart.php');
		} else if ($report_id == 3) {

			include('citizen_satisfaction_received_chart.php');
		} else if ($report_id == 7) {

			include('top10_grievance_chart.php');
		} else if ($report_id == 9) {

			include('top10_grievance_zone_chart.php');
		}
		?>

	</div>

</div>



</div>
</div>
</div>


</div>

<?php
mysqli_close($conn);
?>