<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('get_services.php');
$obj = new get_services($_SESSION['uid']);
require_once('connection.php');
$conn = getconnection();
error_reporting(0);

if ($_POST['zone_id'] != 'all') {

    $where = 'where g.ward_id="' . $_POST['zone_id'] . '"';
    $where1 = 'where g.ward_id="' . $_POST['zone_id'] . '"';
} else {
    $where1 = '';
    $where = '';
}

$sql = "SELECT count(grievance_id) as count,grievance_status_id,w.ward_desc,w.color FROM `grievances` g join ward_mst w on g.ward_id=w.ward_id $where GROUP by grievance_status_id";
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
    $data['count'][$row['grievance_status_id']] = $row['count'] ?? 0;
    if ($where) {
        $data['count']['zone'] = $row['ward_desc'];
        $data['count']['color'] = $row['color'];
    } else {
        $data['count']['zone'] = 'All';
        $data['count']['color'] = '#00AEEF';
    }
}
$sql1 = "SELECT count(grievance_id) as count,grievance_status_id,sla_status FROM `grievances`  $where GROUP by sla_status";
$rs1 = mysqli_query($conn, $sql1);
while ($row1 = mysqli_fetch_assoc($rs1)) {

    $data['count1'][$row1['sla_status']] = $row1['count'] ?? 0;
}
$sql2 = "SELECT count(g.grievance_id) as rating,g.ward_id FROM `grievances` g join rating_mst r on g.grievance_id=r.grievance_id $where ";
$rs2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_assoc($rs2)) {
    if ($_POST['zone_id'] != 'all') {
        $data['rating'][$row2['ward_id']] = $row2['rating'] ?? 0;
    } else {
        $data['rating']['all'] = $row2['rating'] ?? 0;
    }
}

?>
<table class="table table-bordered ">
    <thead>
        <tr class="boxed title-bar text-white" style="background:<?php echo  $data['count']['color'] ?>">
            <th colspan="" style="text-align:center">ZONE</th>
            <th style="text-align:center"><?php echo  $data['count']['zone'] ?> </th>
        </tr>
    </thead>
    <tr>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Total Received </td>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>;text-align:center;"><strong><?php echo ($data['count'][9] + $data['count'][2] + $data['count'][13] + $data['count'][11] + $data['count'][12] +  $data['count'][6] + $data['count'][10]); ?></strong></td>
    </tr>
    <tr>
        <!--04-07-2024 <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Resolved </td> -->
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Total Resolved </td>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>;text-align:center"><strong><?php echo ($data['count'][9] + $data['count'][6] + $data['count'][12]); ?></strong></td>
    </tr>
    <tr>
        <!--04-07-2024 <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Inprocess</td> -->
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Total Inprocess</td>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>;text-align:center"><strong><?php echo $data['count'][2] + $data['count'][11] ?? 0 ?></strong></td>
    </tr>
    <tr>
        <!--04-07-2024 <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Financial Implication</td> -->
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Total Financial Implications</td>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>;text-align:center"><strong><?php echo ($data['count'][6]) ?? 0 ?></strong></td>
    </tr>
    <tr>
        <!--04-07-2024  <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Reopened</td> -->
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Total Reopened</td>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>;text-align:center"><strong><?php echo $data['count'][13] + $data['count'][11] + $data['count'][12] ?? 0 ?></strong></td>
    </tr>
    <tr>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Reopened Completed</td>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>;text-align:center"><strong><?php echo $data['count'][12] ?? 0 ?></strong></td>
    </tr>
    <tr>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>"> Reopened UnderProcess</td>
        <td style="border:1px solid <?php echo  $data['count']['color'] ?>;text-align:center"><strong><?php echo $data['count'][11] ?? 0 ?></strong></td>
    </tr>
    <!-- <tr> <td style="border:1px solid <?php echo  $data['count']['color'] ?>">  Delayed</td> <td style="border:1px solid <?php echo  $data['count']['color'] ?>"><?php echo  $data['count1'][2] ?? 0 ?></td> </tr> -->
    
    <!--<tr> <td style="border:1px solid <?php echo  $data['count']['color'] ?>">  Rejected</td> <td style="border:1px solid <?php echo  $data['count']['color'] ?>"><?php echo $data['count'][10] ?? 0 ?></td>  </tr>
                  
    <tr> <td style="border:1px solid <?php echo  $data['count']['color'] ?>">Zone Rating</td> <td style="border:1px solid <?php echo  $data['count']['color'] ?>"><?php echo $data['rating'][$_POST['zone_id']] ?? 0; ?></td>  </tr>-->
</table>




<?php
mysqli_close($conn);
?>