<?php
require "config.php";
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once('connection.php');

date_default_timezone_set('Asia/Kolkata');
$conn = getconnection();

// ================= SAFE SESSION =================

$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
$app_type_id = 1;
$selectedYear = $_SESSION['filteryear'] ?? '';
$threshold_date = '';
$grievances_trns = $_SESSION['grievances_trns'];
$ward_id = $_SESSION['zone_id'];
$zone_id = $_SESSION['ward_id'];

//echo "<pre>";print_r($_SESSION);echo "</pre>";die();

// ================= FUNCTIONS =================
function getSumCount($conn, $where, $params, $types, $join = '') {
    $query = "
        SELECT COALESCE(SUM(cnt),0) as total FROM (
            SELECT COUNT(DISTINCT g.grievance_id) as cnt
            FROM grievances g
            $join
            WHERE g.cat3_id != 0 		
            $where	
            GROUP BY g.cat3_id
        ) as sub
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    return $res['total'] ?? 0;
}

function percent($value, $total) {
    return ($total > 0) ? number_format(($value / $total) * 100, 2) : 0;
}

// ================= BASE FILTER =================
$whereBase = " AND g.ulbid=? AND g.app_type_id=?";
$paramsBase = [$ulbid, $app_type_id];
$typesBase  = "si";

if (!empty($selectedYear)) {
    $whereBase .= " AND YEAR(g.date_regd)=? ";
    $paramsBase[] = $selectedYear;
    $typesBase .= "i";
}

if (!empty($ward_id)) {
    $whereBase .= " AND g.ward_id=? ";
    $paramsBase[] = $ward_id;
    $typesBase .= "i";
}

// ================= COUNTS =================

// Total Received
$data['total_received'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id IN (2,3,5,6,8,9,10,11,12,13)",
    $paramsBase,
    $typesBase
);

// Today Received
$stmt = $conn->prepare("
    SELECT COUNT(DISTINCT grievance_id) as cnt 
    FROM grievances 
    WHERE cat3_id!=0 AND DATE(date_regd)=? AND ulbid=? AND app_type_id=? AND ward_id=?
");
$today = date('Y-m-d');
$stmt->bind_param("ssii", $today, $ulbid, $app_type_id,$ward_id);
$stmt->execute();
$data['daily_received'] = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

// Resolved
$data['resolved_within_sla'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id IN (3,8,9) AND g.sla_status='1' ",
    $paramsBase,
    $typesBase
);

$data['resolved_beyond_sla'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id IN (3,8,9) AND g.sla_status='2' ",
    $paramsBase,
    $typesBase
);

// Total Resolved
$data['total_resolved'] = $data['resolved_within_sla'] + $data['resolved_beyond_sla'];

// JOIN TABLE
$joinGT = "INNER JOIN $grievances_trns gt ON g.grievance_id=gt.grievance_id ";

// Under Progress
$data['under_progress_with_sla'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id=2 AND gt.disposal_status=2 AND g.sla_status='1' ",
    $paramsBase,
    $typesBase,
    $joinGT
);

$data['under_progress_beyond_sla'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id=2 AND gt.disposal_status=2 AND g.sla_status='2' ",
    $paramsBase,
    $typesBase,
    $joinGT
);

// Financial
$data['fin'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id=6",
    $paramsBase,
    $typesBase
);

// Reopened
$data['reopened_count'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id=13",
    $paramsBase,
    $typesBase,
    $joinGT
);

$data['reopened_completed'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id=12 ",
    $paramsBase,
    $typesBase
);

$data['reopened_under_progress'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id=11 ",
    $paramsBase,
    $typesBase
);

// Transfer
$data['Transfered'] = getSumCount(
    $conn,
    $whereBase . " AND g.grievance_status_id IN (5,10) ",
    $paramsBase,
    $typesBase
);

// Escalated
$stmt = $conn->prepare("
    SELECT COUNT(DISTINCT g.grievance_id) as cnt 
    FROM grievances g
    INNER JOIN {$grievances_trns} gt 
    ON g.grievance_id = gt.grievance_id 
    AND gt.is_escalated = 1
	WHERE g.ulbid=? 
    AND g.app_type_id=? 
    AND g.ward_id=?
");
$stmt->bind_param("sii", $ulbid, $app_type_id,$ward_id);
$stmt->execute();
$data['Escalated'] = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

// Default 0
foreach ($data as $k => $v) {
    if (empty($data[$k])) $data[$k] = 0;
}
?>

<!-- ================= HTML ================= -->
<style>


.myshadow {
	-webkit-box-shadow: 2px 5px 16px 7px rgba(102, 102, 102, 0.5);
	-moz-box-shadow: 2px 5px 16px 7px rgba(102, 102, 102, 0.5);
	box-shadow: 2px 5px 16px 7px rgba(102, 102, 102, 0.5);
	border-radius: 10px;
	overflow: hidden;
}


.myshadow123 {
    box-shadow: 2px 5px 16px 7px rgba(102,102,102,0.5);
    border-radius: 10px;
    overflow: hidden;
}
.card {
    padding: 10px;
    margin: 10px;
    background: #fff;
    border-radius: 10px;
    text-align: center;
}
.row { display: flex; flex-wrap: wrap; }
.col { width: 43%; margin:1%; }
</style>
<style>
/* GRID LAYOUT */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 equal columns */
    gap: 15px;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 576px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

/* CARD */
.dashboard-card {
    display: flex;
    height: 120px; /* 👈 FIXED HEIGHT = equal boxes */
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0px 6px 18px rgba(0,0,0,0.25);
    background: #e0e0e0;
    transition: 0.3s ease;
    cursor: pointer;
	margin:10px;
}

/* HOVER */
.dashboard-card:hover {
    transform: translateY(-6px) scale(1.02);
}

/* LEFT (equal ratio) */
.card-left {
    flex: 1; /* 1 part */
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 32px;
}

/* RIGHT (equal ratio) */
.card-right {
    flex: 2; /* 2 parts */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #e6e6e6;
    padding: 10px;
    text-align: center;
}

/* TEXT */
.card-right h2 {
    margin: 0;
    font-size: 22px;
    color: #0d6efd;
}

.card-right p {
    margin: 0;
    font-size: 13px;
}

/* COLORS */
.bg-green { background: #1e8449; }
.bg-red { background: #c82333; }
.bg-blue { background: #3498db; }
.bg-cyan { background: #17a2b8; }
.bg-yellow { background: #e0a800; }
.bg-teal { background: #20c997; }
</style>

<div class="container overflow-hidden text-center">

	<div class="bash_heading row m-b20">
		<div class="d-flex justify-content-end align-items-center">
				<style>
				.form-control2 {
						display: block;
						height: 34px;
						padding: 6px 12px;
						font-size: 14px;
						line-height: 1.42857143;
						color: #555;
						background-color: #fff;
						background-image: none;
						border: 1px solid #ccc;
						border-radius: 4px;
						-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
						box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
						-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
						-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
						transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
					}
				</style>
				<div >						
					&nbsp;&nbsp;&nbsp;						
					<h6 id="yearLabel" style="padding-right: 10px;">Year:</h6>
				</div>
				<div>
					<select id="yearSelect" name="year" class="form-control" onchange="getSelectedYear()">
						<option value="0">-All Report-</option>
						<option value="2026" <?php if ($selectedYear == '2026') echo 'selected'; ?>>2026</option>
						<option value="2025" <?php if ($selectedYear == '2025') echo 'selected'; ?>>2025</option>
						<option value="2024" <?php if ($selectedYear == '2024') echo 'selected'; ?>>2024</option>
						<option value="2023" <?php if ($selectedYear == '2023') echo 'selected'; ?>>2023</option>
					</select>
					<input type="hidden" id="yearSelectHidden" name="year" value="" />	
				</div>
			
		</div>
	</div>

  <div class="row gy-2">
    <div class="col-4">
		<div class="dashboard-card">
			<div class="card-left bg-green">
				✔
			</div>
			<div class="card-right">
				<h2><?php 				
					echo "<a href='corp_rep_comp_dept_abs_comp.php?active=tr-totresolved' >" . $data['total_received'] . "</a>";
				?>
				</h2>
				<p>Total Received Grievances</p>
			</div>
		</div>
	</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-red">
            👍
        </div>
        <div class="card-right">
            <h2><?php
				echo "<a href='corp_tot_received.php?aptid=1&status=111&sla=0&user_type=" . $_SESSION['user_type'] . "'>" . $data['daily_received'] . "</a>";
			?></h2>
            <p>Today's Received Grievances
            <small style="color:red;">(Do Not Add Received Block)</small></p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-cyan">
            ⏳
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=tr-totresolved' >" . $data['total_resolved'] . "</a>";
			?></h2>
            <p>Total Resolved Grievances
            <small>(<?php echo percent($data['total_resolved'],$data['total_received']); ?> %)</small></p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-yellow">
            ✔
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=cmp-wthin-sla' >" . $data['resolved_within_sla'] . "</a>";
			?></h2>
            <p>Completed within SLA Grievances</p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-cyan">
            ⏳
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=cmp-bnd-sla' >" . $data['resolved_beyond_sla'] . "</a>";
			?></h2>
            <p>Completed Beyond SLA Grievances</p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-blue">
            ⏳
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=tr-totpending'>" . $data['under_progress_with_sla'] . "</a>";
			?></h2>
            <p>Total Under Progress Within SLA Grievances</p>
        </div>
    </div>
</div>
<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-blue">
            ⏳
        </div>
        <div class="card-right">
            <h2><?php 			
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=tr-totpending'>" . $data['under_progress_beyond_sla'] . "</a>";
			?></h2>
            <p>Total Under Progress Beyond SLA Grievances</p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-blue">
            ⏳
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=tr-totresolved-fin'>" . $data['fin'] . "</a>";
			?></h2>
            <p>Total Financial Implications</p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-red">
            🔄
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=tr-totpending-reopen-total'>" . $data['reopened_count'] . "</a>";
			?></h2>
            <p>Total Reopened Grievances</p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-green">
            📁
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=tr-totpending-reopen-completed' >" . $data['reopened_completed'] . "</a>";
			?></h2>
            <p>Total Reopened Completed Grievances</p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-red">
            📂
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_rep_comp_dept_abs_comp.php?active=tr-totpending-reopen-under-progress'>" . $data['reopened_under_progress']  . "</a>";
			?></h2>
            <p>Total Reopened Under Progress Grievances</p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-cyan">
            📋
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_tot_received.php?aptid=1&status=201&sla=0'>" . $data['Transfered'] . "</a>";
			?></h2>
            <p>Total Transferred Grievances</p>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="dashboard-card">
        <div class="card-left bg-teal">
            🚩
        </div>
        <div class="card-right">
            <h2><?php 
				echo "<a href='corp_escaleted_grievance_rep.php' >" . $data['Escalated'] . "</a>";
			?></h2>
            <p>Total Escalated Grievances</p>
        </div>
    </div>
</div>
	
  </div>
  
  			
			<div class="row p-3">

				<div class="col-md-4 col-sm-6">
					<section class="panel panel-box myshadow">
						<?php include 'corp_piechart.php'; ?>
					</section>
				</div>

				<div class="col-md-4 col-sm-6">
					<section class="panel panel-box myshadow">
						<?php include 'corp_completed_within_sla_piechart.php'; ?>
					</section>
				</div>

				<div class="col-md-4 col-sm-6">
					<section class="panel panel-box myshadow">
						<?php include 'corp_pending_complaints_piechart.php'; ?>
					</section>
				</div>
				
			</div>
			
</div>

<script>

function animateCount(el, end) {
    let start = 0;
    let duration = 800;
    let step = Math.ceil(end / 40);

    let counter = setInterval(function () {
        start += step;
        if (start >= end) {
            el.innerText = end;
            clearInterval(counter);
        } else {
            el.innerText = start;
        }
    }, 20);
}

document.querySelectorAll(".dashboard-card").forEach(function(card){
    card.addEventListener("mouseenter", function(){

        let el = card.querySelector(".count");

        if (!el.classList.contains("counted")) {
            let value = parseInt(el.getAttribute("data-count"));
            animateCount(el, value);
            el.classList.add("counted"); // prevent repeat
        }

    });
});

</script>

<script src="js/jquery-tso.min.js"></script>
	<script type="text/javascript">
		function getSelectedYear() {
			//alert('hi');
			var yearSelect = document.getElementById('yearSelect');
			var selectedYear = yearSelect.options[yearSelect.selectedIndex].value;
			var yearSelectHidden = document.getElementById('yearSelectHidden');
			var dashData = document.getElementById('dashData');

			// Set the value of hidden input
			yearSelectHidden.value = selectedYear;
			var ty = 'yearwisefilter';
			// Make AJAX request
			$.ajax({
				type: "POST",
				url: "ajax_corp_dashboard.php",
				data: {
					year: selectedYear,
					ty: ty
				},
				success: function(response) {
					// Update dashData div with response
					//alert('hi');
					location.reload();
				},
				error: function(xhr, status, error) {
					//alert('hi');
					console.error("Error:", error);
				}
			});
		}
		
		function getSelectedDesignation() {
			//alert('hi');
			var designationSelect = document.getElementById('designationSelect');
			var selectedDesg = designationSelect.options[designationSelect.selectedIndex].value;
			var designationSelectHidden = document.getElementById('designationSelectHidden');
			var dashData = document.getElementById('dashData');
//alert(selectedDesg);
			// Set the value of hidden input
			designationSelectHidden.value = selectedDesg;
			var ty = 'designationwisefilter';
			// Make AJAX request
			$.ajax({
				type: "POST",
				url: "ajax_corp_dashboard.php",
				data: {
					designation: selectedDesg,
					ty: ty
				},
				success: function(response) {
					// Update dashData div with response
					//alert(response);
					location.reload();
				},
				error: function(xhr, status, error) {
					//alert('hi');
					console.error("Error:", error);
				}
			});
		}
	</script>
	
<?php mysqli_close($conn); ?>