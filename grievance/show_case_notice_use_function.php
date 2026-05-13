<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
require_once('connection.php');
error_reporting(0);
$conn = getconnection();
require_once('Smarty.class.php');
$tpl = new Smarty();

//exit;
// $grievances_id1='14218';
$sql = "SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2' AND `grievance_at_emp_level`!='L4'";
// $sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2' and grievance_id='".$grievances_id1."'";
$base_url = "https://tinyurl.com/2s3mn29p";
echo "<br>";
// selecting the grievanes from the the above query 
//  $sql = "SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2' and sla_status = 2  and is_test_done = '0' ";
$rs = mysqli_query($conn, $sql);
// while ($row = mysqli_fetch_assoc($rs)) {
//    echo $row['grievance_id']; echo ' | ';
//    echo $row['grievance_at_emp_level']; echo '<br>';
// }
// exit;
while ($row = mysqli_fetch_assoc($rs)) {
	$grievances_id = $row['grievance_id'];
	$cs_id = $row['cat3_id'];
	$date_regd = $row['date_regd'];
    $Level = $row['grievance_at_emp_level'];
	$sql = "SELECT * FROM `comp_cutofdays_map` WHERE `cs_id` = '" . $cs_id . "'";
	$rs2 = mysqli_query($conn, $sql);
	$row2  = mysqli_fetch_assoc($rs2);

	$disposable_days = $row2['cutt_off_time'];
	if (!empty($disposable_days)) {
		$Date = date('Y-m-d H:i:s');
		$cutoffdays = round($row2['cutt_off_time'] * 24 * 60);
        if(in_array($Level,['L2','L3'])){
		$endTime = strtotime("+" . $cutoffdays . " minutes", strtotime($row['cutt_of_time']));
        }else{
            $endTime = strtotime("+" . $cutoffdays . " minutes", strtotime($row['date_regd']));
        }
        echo $Level. '<br>'.$row['date_regd'].'<br>';
		echo $disposed_date1 = date('Y-m-d H:i:s', $endTime);
	} else {
	}

	 $disposed_date = strtotime($disposed_date1);

	 $todayDate = strtotime(date('Y-m-d H:i:s'));

	echo "<br>";
	if ($disposed_date < $todayDate) {
       
		echo $sql = "update grievances set sla_status = '2', cutt_of_time='" . $disposed_date1 . "' where grievance_id = '" . $row['grievance_id'] . "'";
		mysqli_query($conn, $sql);
		echo "<br>";
	}
}
// exit;
$sql = "select * from cs_mst";
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
	$cs_list[$row['cs_id']] = $row['cs_desc'];
}
?><br><?php echo $row['grievance_id'];
// echo $sql = "SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2' AND sla_status = 2 AND is_test_done = '0' AND grievance_id='" . $grievances_id1 . "'";
echo $sql = "SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2' and sla_status = 2  and is_test_done = '0' ";
$rs = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($rs)) {
    $grievances_id = $row['grievance_id'];
    if ($row['grievance_at_emp_level'] == 'L1') {
        grievance_at_emp_level1($row, $grievances_id, $cs_list);
    } else if ($row['grievance_at_emp_level'] == 'L2') {
        grievance_at_emp_level2($row, $grievances_id, $cs_list);
    } else if ($row['grievance_at_emp_level'] == 'L3') {
        grievance_at_emp_level3($row, $grievances_id, $cs_list);
    }
}
$conn->close();
// Function to Employee Level1
function grievance_at_emp_level1($row, $grievances_id, $cs_list)
{
    global $conn, $base_url; // Use global connection and base_url
    echo "from L1 to L2 <br>";
    $grievances_id = $row['grievance_id'];
    $disposed_date = strtotime(date('Y-m-d H:i:s', strtotime($row['cutt_of_time'])));
    date_default_timezone_set('Asia/Calcutta');
    $todayDate = strtotime(date('Y-m-d H:i:s'));
    echo date('Y-m-d H:i:s',$disposed_date);
    echo "gg";
    echo date('Y-m-d H:i:s', $todayDate);
    if ($disposed_date < $todayDate) {
        echo $sql = "update grievances set sla_status = '2', grievance_at_emp_level='L2' where grievance_id = '" . $row['grievance_id'] . "'";
        mysqli_query($conn, $sql);
        $sql = "select * from emp_map em, emp_mst e where em.emp_id=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1'";
        $rs2 = mysqli_query($conn, $sql);
        $emp1 = mysqli_fetch_assoc($rs2);

        $sql = "select * from emp_map em, emp_mst e where em.emp_id2=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1'";
        $rs2 = mysqli_query($conn, $sql);
        $emp2 = mysqli_fetch_assoc($rs2);

        $sql = "select * from `grievances_transactions` WHERE `grievance_id` = '" . $row['grievance_id'] . "'  order by transaction_id desc limit 1";
        $rs3 = mysqli_query($conn, $sql);
        $row3 = mysqli_fetch_assoc($rs3);
        $trnsid = $row3['transaction_id'] + 1;

        $sql = "SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '" . $grievances_id . "' and disposal_status=2 and emp_id='" . $emp1['emp_id'] . "' order by transaction_id desc limit 1";
        $rs2 = mysqli_query($conn, $sql);
        $preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);

        $sql = "update `grievances_transactions` set disposal_status='5' , is_escalated ='1' , disposed_date='" . date('Y-m-d H:i:s') . "' WHERE `grievance_id` = '" . $row['grievance_id'] . "'  AND `disposal_status` = 2";
        if (mysqli_query($conn, $sql)) {
            $sql = "insert into grievances_transactions(grievance_id,transaction_id,emp_id,dept_id,desg_id,alloted_date,disposed_date,disposal_status,disposal_remarks,update_status,updated_by,origin_id)values('" . $row['grievance_id'] . "','" . $trnsid . "','" . $emp2['emp_id2'] . "','" . $emp2['dept_id'] . "','" . $emp2['desg_id'] . "','" . date('Y-m-d H:i:s') . "','0000-00-00 00:00:00','2','Auto Allotted','2','System','1')";

            if (mysqli_query($conn, $sql)) {
                $emp_id1 = $emp1['emp_id'];
                $notice_Date = date('Y-m-d H:i:s');
                $sql = "SELECT COUNT(*) as count FROM show_case_response_logs WHERE emp_id = '" . $emp_id1 . "' and notice_status='1'";
                $rs3 = mysqli_query($conn, $sql);
                $row3 = mysqli_fetch_assoc($rs3);

                if ($row3['count'] >= 5) {
                    echo $sms = "Show Cause Notice: Dear " . substr($emp1['emp_name'], 0, 29) . ", A show cause notice has been issued due to dormancy in your performance. You are required to provide a satisfactory explanation for this lapse in your duties. Click here " . $base_url . " , NMCGOV";
                    $mobile = $emp1['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707172259486051441";
                    $message = str_replace(' ','%20',$sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End Show Cause Notice**************/

                    $alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));

                    echo $sms = "Warning Alert: Sir, since you have not addressed Grievance no. " . $row['grievance_id'] . " dt " . $alloted_date . " regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " within allotted time period, it has been escalated to " . substr($emp2['emp_name'], 0, 29) . ". Regards: NMCGOV";
                    $mobile = $emp1['emp_mobile'];

                    //$notice_Date = date('Y-m-d H:i:s');
                    // $mobile = '8484972066';
                    $templateId = "1707172259480812947";
                    $message = str_replace(' ','%20',$sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End Warning Alert**************/

                    echo $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . $row['mobile'] . " , regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved " . $base_url . " Regards- Citizen Service Monitoring Cell, NMCGOV";
                    $mobile = $emp2['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707171326612386383";
                    $message = str_replace(' ','%20',$sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End SMS For Employee**************/

                    $sql = "update show_case_response_logs set notice_status='0' where emp_id = '" . $emp_id1 . "' and notice_status = '1'";
                    mysqli_query($conn, $sql);

                    $sql = "insert into show_case_response_logs(grievance_id,emp_id,notice_status,is_test_done,datetime)values('" . $row['grievance_id'] . "','" . $emp_id1 . "','1','1','" . $notice_Date . "')";
                    mysqli_query($conn, $sql);

                    $sql = "select * from `show_case_emp_count` WHERE `emp_id` = '" . $emp_id1 . "'  order by showcase_count desc limit 1";
                    $rs = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_assoc($rs);
                    $show_caseid = $row['showcase_count'] + 1;

                    $sql = "insert into show_case_emp_count(emp_id,showcase_count,datetime)values('" . $emp_id1 . "','" . $show_caseid . "','" . $notice_Date . "')";
                    //mysqli_query($conn, $sql);

                    $sql = "insert into sms_response_logs(grievance_id,mobile,sms_content,response_content,datetime)values('" . $row['grievance_id'] . "','" . $mobile . "','" . $message . "'," . $result . ",'" . $notice_Date . "')";

                    mysqli_query($conn, $sql);
                } else {
                    $alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));

                    echo $sms = "Warning Alert: Sir, since you have not addressed Grievance no. " . $row['grievance_id'] . " dt " . $alloted_date . " regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " within allotted time period, it has been escalated to " . substr($emp2['emp_name'], 0, 29) . ". Regards: NMCGOV";
                    $mobile = $emp1['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707172259480812947";
                    $message = str_replace(' ','%20',$sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server

                   echo $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . $row['mobile'] . " , regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved " . $base_url . " Regards- Citizen Service Monitoring Cell, NMCGOV";

                    $mobile = $emp2['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707171326612386383";
                    $message = str_replace(' ','%20',$sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********sms strarts**************/

                    $sql = "insert into show_case_response_logs(grievance_id,emp_id,notice_status,is_test_done,datetime)values('" . $row['grievance_id'] . "','" . $emp_id1 . "','1','1','" . $notice_Date . "')";
                    mysqli_query($conn, $sql);

                    $sql = "insert into sms_response_logs(grievance_id,mobile,sms_content,response_content,datetime)values('" . $row['grievance_id'] . "','" . $mobile . "','" . $message . "'," . $result . ",'" . $notice_Date . "')";
                    mysqli_query($conn, $sql);
                }
                // exit;
            }
        }
    } else {
        echo "in sla with level 1 employee";
    }
}
// Function to Employee Level2
function grievance_at_emp_level2($row, $grievances_id, $cs_list) {
    global $conn, $base_url; // Use global connection and base_url
    $grievances_id = $row['grievance_id'];
    echo "<br> from L2 to L3 <br>";
    $sql = "select * from emp_map em, emp_mst e where em.emp_id2=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
    $rs2 = mysqli_query($conn, $sql);
    $emp1 = mysqli_fetch_assoc($rs2);
    /** get allotted date ***/

    echo $sql = "SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '" . $grievances_id . "' and disposal_status=2 and emp_id='" . $emp1['emp_id2'] . "' order by transaction_id desc limit 1";
    $rs2 = mysqli_query($conn, $sql);
    $preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);
    // get allotted date 

    echo "<br> check 1 <br>";
    $sql = "SELECT * FROM `level_disposabledays_map` WHERE `cs_id` LIKE '" . $row['cat3_id'] . "'";
    $rs2 = mysqli_query($conn, $sql);
    $disposabledays = mysqli_fetch_assoc($rs2);
    $total_disposable_days =  $disposabledays['L2'];

    echo "<br> check 2 <br>";

    $cutoffdays = round($total_disposable_days * 24 * 60);

    $endTime = strtotime("+" . $cutoffdays . " minutes", strtotime($preveious_employee_allotteddate['alloted_date']));

    $disposed_date = date('Y-m-d H:i:s', $endTime);

    $disposed_date = strtotime($disposed_date);
    $todayDate = strtotime(date('Y-m-d H:i:s'));

    echo $disposed_date . "<br>";
    echo $todayDate . "<br>";
    echo date('Y-m-d H:i:s', $disposed_date);
    echo "gg";
    echo date('Y-m-d H:i:s', $todayDate);

    echo "<br> check 3 <br>";

    if ($disposed_date < $todayDate) {
        $sql = "update grievances set sla_status = '2', grievance_at_emp_level='L3' where grievance_id = '" . $row['grievance_id'] . "'";
        mysqli_query($conn, $sql);

        echo "<br> check 4 <br>";

        echo $sql = "select * from emp_map em, emp_mst e where em.emp_id3=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
        $rs2 = mysqli_query($conn, $sql);
        $emp2 = mysqli_fetch_assoc($rs2);

        /*** close ***/
        echo "<br> check 5 <br>";

        echo $sql = "select * from `grievances_transactions` WHERE `grievance_id` = '" . $row['grievance_id'] . "'  order by transaction_id desc limit 1";
        $rs3 = mysqli_query($conn, $sql);
        $row3 = mysqli_fetch_assoc($rs3);
        $trnsid = $row3['transaction_id'] + 1;

        echo "<br> check 6 <br>";
        
        echo $sql = "update `grievances_transactions` set disposal_status='5', is_escalated ='1' , disposed_date='" . date('Y-m-d H:i:s') . "' WHERE `grievance_id` = '" . $row['grievance_id'] . "'  AND `disposal_status` = 2";

        if (mysqli_query($conn, $sql)) {
            echo "<br> check 7 <br>";
            $sql = "insert into grievances_transactions(grievance_id,transaction_id,emp_id,dept_id,
            desg_id,alloted_date,disposed_date,disposal_status,disposal_remarks,update_status,updated_by,origin_id)values('" . $row['grievance_id'] . "','" . $trnsid . "','" . $emp2['emp_id3'] . "','" . $emp2['dept_id'] . "','" . $emp2['desg_id'] . "','" . date('Y-m-d H:i:s') . "','0000-00-00 00:00:00','2','Auto Allotted','2','System','1')";
            echo "<br> check 8 <br>";
            if (mysqli_query($conn, $sql)) {
                echo "<br> check final <br>";

                $emp_id2 = $emp2['emp_id2'];
                $notice_Date = date('Y-m-d H:i:s');
                $sql = "SELECT COUNT(*) as count FROM show_case_response_logs WHERE emp_id = '" . $emp_id2 . "' and notice_status='1'";
                $rs3 = mysqli_query($conn, $sql);
                $row3 = mysqli_fetch_assoc($rs3);
    
                if ($row3['count'] >= 5) {
                    echo $sms = "Show Cause Notice: Dear " . substr($emp1['emp_name'], 0, 29) . ", A show cause notice has been issued due to dormancy in your performance. You are required to provide a satisfactory explanation for this lapse in your duties. Click here " . $base_url . " , NMCGOV";
                    $mobile = $emp1['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707172259486051441";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End Show Cause Notice**************/

                    $alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));

                    echo $sms = "Warning Alert: Sir, since you have not addressed Grievance no. " . $row['grievance_id'] . " dt " . $alloted_date . " regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " within allotted time period, it has been escalated to " . substr($emp2['emp_name'], 0, 29) . ". Regards: NMCGOV";
                    $mobile = $emp1['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707172259480812947";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End Warning Alert**************/

                    echo $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . substr($row['mobile'], 0, 29) . ", regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to  " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved  " . $base_url . " Regards- Citizen Service Monitoring Cell, NMCGOV";
                    $mobile = $emp2['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707171326612386383";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End SMS For Employee**************/

                    $sql = "update show_case_response_logs set notice_status='0' where emp_id = '" . $emp_id2 . "' and notice_status = '1'";
                    mysqli_query($conn, $sql);
                    
                    $sql = "insert into show_case_response_logs(grievance_id,emp_id,notice_status,is_test_done,datetime)values('" . $row['grievance_id'] . "','" . $emp_id2 . "','1','1','" . $notice_Date . "')";
                    mysqli_query($conn, $sql);

                    $sql = "select * from `show_case_emp_count` WHERE `emp_id` = '" . $emp_id2 . "'  order by showcase_count desc limit 1";
                    $rs = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($rs);
                    $show_caseid = $row['showcase_count'] + 1;

                    $sql = "insert into show_case_emp_count(emp_id,showcase_count,datetime)values('" .$emp_id2 . "','" . $show_caseid . "','" . $notice_Date . "')";
                    //mysqli_query($conn, $sql);

                    $sql = "insert into sms_response_logs(grievance_id,mobile,sms_content,response_content,datetime)values('" . $row['grievance_id'] . "','" . $mobile . "','" . $message . "'," .$result . ",'" . $notice_Date . "')";
                    mysqli_query($conn, $sql);
                }

                else{
                    $alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));

                    echo $sms = "Warning Alert: Sir, since you have not addressed Grievance no. ". $row['grievance_id'] ." dt " . $alloted_date . " regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " within allotted time period, it has been escalated to " . substr($emp2['emp_name'], 0, 29) . ". Regards: NMCGOV";
                    $mobile = $emp1['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707172259480812947";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End Warning Alert**************/

                    echo $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . substr($row['mobile'], 0, 29) . ", regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to  " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved  " . $base_url . " Regards- Citizen Service Monitoring Cell, NMCGOV";
                    $mobile = $emp2['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707171326612386383";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End SMS For Employee**************/

                    $sql = "insert into show_case_response_logs(grievance_id,emp_id,notice_status,is_test_done,datetime)values('" . $row['grievance_id'] . "','" . $emp_id2 . "','1','1','" . $notice_Date . "')";
                    mysqli_query($conn, $sql);

                    $sql = "insert into sms_response_logs(grievance_id,mobile,sms_content,response_content,datetime)values('" . $row['grievance_id'] . "','" . $mobile . "','" . $message . "'," .$result . ",'" . $notice_Date . "')";
                    mysqli_query($conn, $sql);
                }
                // exit;
            }
        }
    } else {
        echo "in sla with level 2";
    }
}

// Function to Employee Level3
function grievance_at_emp_level3($row, $grievances_id, $cs_list)
{
    global $conn, $base_url; // Use global connection and base_url
    echo "from L3 to L4";
    $grievances_id = $row['grievance_id'];
    echo $sql = "select * from emp_map em, emp_mst e where em.emp_id3=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
    $rs2 = mysqli_query($conn, $sql);
    $emp1 = mysqli_fetch_assoc($rs2);
    /** get allotted date ***/

    ?><br><?php echo $sql = "SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '" . $grievances_id . "' and disposal_status=2 and emp_id='" . $emp1['emp_id3'] . "' order by transaction_id desc limit 1";
    $rs2 = mysqli_query($conn, $sql);
    $preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);
    ?><br><?php echo $preveious_employee_allotteddate['alloted_date'];
    // get allotted date 

    $sql = "SELECT * FROM `level_disposabledays_map` WHERE `cs_id` LIKE '" . $row['cat3_id'] . "'";
    $rs2 = mysqli_query($conn, $sql);
    $disposabledays = mysqli_fetch_assoc($rs2);
    $total_disposable_days =  $disposabledays['L3'];

    $cutoffdays = round($total_disposable_days * 24 * 60);

    $endTime = strtotime("+" . $cutoffdays . " minutes", strtotime($preveious_employee_allotteddate['alloted_date']));

    $disposed_date = date('Y-m-d H:i:s', $endTime);

    /*$disposed_date = date('Y-m-d H:i:s', strtotime($row['date_regd']. ' + '.$total_disposable_days.' days'));*/
    $disposed_date = strtotime($disposed_date);
    $todayDate = strtotime(date('Y-m-d H:i:s'));

    echo $disposed_date . "<br>";
    echo $todayDate . "<br>";
    echo date('Y-m-d H:i:s', $disposed_date);
    echo "gg";
    echo date('Y-m-d H:i:s', $todayDate);

    echo "<br> check 9 <br>";

    if ($disposed_date < $todayDate) {
        $sql = "update grievances set sla_status = '2', grievance_at_emp_level='L4', is_test_done = '1' where grievance_id = '" . $row['grievance_id'] . "'";
        mysqli_query($conn, $sql);

        /** getting present employee details and next level employee details ***/

        echo "<br> check 10 <br>";

        $sql = "select * from emp_map em, emp_mst e where em.emp_id4=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
        $rs2 = mysqli_query($conn, $sql);
        $emp2 = mysqli_fetch_assoc($rs2);

        /*** close ***/
        echo "<br> check 11 <br>";

        $sql = "select * from  `grievances_transactions` WHERE `grievance_id` = '" . $row['grievance_id'] . "'  order by transaction_id desc limit 1";
        $rs3 = mysqli_query($conn, $sql);
        $row3 = mysqli_fetch_assoc($rs3);
        $trnsid = $row3['transaction_id'] + 1;

        echo "<br> check 12 <br>";

        // Transfering grievance to level 4 employee

        $sql = "update `grievances_transactions` set disposal_status='5' , is_escalated ='1' ,disposed_date='" . date('Y-m-d H:i:s') . "' WHERE `grievance_id` = '" . $row['grievance_id'] . "'  AND `disposal_status` = 2";

        /** close allotted date ***/

        if (mysqli_query($conn, $sql)) {
            echo "<br> check 13 <br>";

            $sql = "insert into grievances_transactions(grievance_id,transaction_id,emp_id,dept_id,desg_id,alloted_date,disposed_date,disposal_status,disposal_remarks,update_status,updated_by,origin_id)values('" . $row['grievance_id'] . "','" . $trnsid . "','" . $emp2['emp_id4'] . "','" . $emp2['dept_id'] . "','" . $emp2['desg_id'] . "','" . date('Y-m-d H:i:s') . "','0000-00-00 00:00:00','2','Auto Allotted','2','System','1')";

            echo "<br> check 13 <br>";
            if (mysqli_query($conn, $sql)) {
                echo "<br> check final <br>";

                // Get employee ID for L3
                $emp_id3 = $emp1['emp_id3'];
                $sql = "SELECT COUNT(*) as count FROM show_case_response_logs WHERE emp_id = '" . $emp_id3 . "' and notice_status='1'";
                $rs3 = mysqli_query($conn, $sql);
                $row3 = mysqli_fetch_assoc($rs3);

                if ($row3['count'] >= 5) {
                    // Create SMS content
                    $sms = "Show Cause Notice: Dear " . substr($emp1['emp_name'], 0, 29) . ", A show cause notice has been issued due to dormancy in your performance. You are required to provide a satisfactory explanation for this lapse in your duties. Click here " . $base_url . " , NMCGOV";
                    $mobile = $emp1['emp_mobile'];
                    $notice_Date = date('Y-m-d H:i:s');
                    // $mobile = '8484972066';
                    $templateId = "1707172259486051441";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End Show Cause Notice**************/

                    $alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));

                    $sms = "Warning Alert: Sir, since you have not addressed Grievance no. " . $row['grievance_id'] . " dt " . $alloted_date . " regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " within allotted time period, it has been escalated to " . substr($emp2['emp_name'], 0, 29) . ". Regards: NMCGOV";
                    $mobile = $emp1['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707172259480812947";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End Warning Alert**************/

                    $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . $row['mobile'] . " , regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved " . $base_url . " Regards- Citizen Service Monitoring Cell, NMCGOV";
                    $mobile = $emp2['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707171326612386383";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End SMS For Employee**************/

                    $sql = "update show_case_response_logs set notice_status='0' where emp_id = '" . $emp_id3 ."' and grievance_id = '" . $row['grievance_id'] . "' and notice_status='1'";
                    mysqli_query($conn, $sql);

                    $sql = "insert into show_case_response_logs(grievance_id,emp_id,notice_status,is_test_done,datetime)values('" . $row['grievance_id'] . "','" . $emp_id3 . "','1','1','" . $notice_Date . "')";
                    mysqli_query($conn, $sql);

                    $sql = "select * from `show_case_emp_count` WHERE `emp_id` = '" . $emp_id3 . "'  order by showcase_count desc limit 1";
                    $rs = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($rs);
                    $show_caseid = $row['showcase_count'] + 1;
                    
                    $sql = "insert into sms_response_logs(grievance_id,mobile,sms_content,response_content,datetime)values('" . $row['grievance_id'] . "','" . $mobile . "','" . $message . "'," . $result . ",'" . $notice_Date . "')";
                    //mysqli_query($conn, $sql);

                    $sql = "insert into show_case_emp_count(emp_id,showcase_count,datetime)values('" . $emp_id3 . "','" . $show_caseid . "','" . $notice_Date . "')";
                    mysqli_query($conn, $sql);

                } else {
                    // send sms to L3 employee
                    $alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));

                    $sms = "Warning Alert: Sir, since you have not addressed Grievance no. " . $row['grievance_id'] . " dt " . $alloted_date . " regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " within allotted time period, it has been escalated to " . substr($emp2['emp_name'], 0, 29) . ". Regards: NMCGOV";
                    $mobile = $emp1['emp_mobile'];
                    $notice_Date = date('Y-m-d H:i:s');
                    // $mobile = '8484972066';
                    $templateId = "1707172259480812947";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End Warning Alert**************/
                    
                    $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . $row['mobile'] . " , regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved " . $base_url . " Regards- Citizen Service Monitoring Cell, NMCGOV";
                    $mobile = $emp2['emp_mobile'];
                    // $mobile = '8484972066';
                    $templateId = "1707171326612386383";
                    $message = str_replace(' ', '%20', $sms);
                    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                    $post = curl_init();
                    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    /*********End SMS For Employee**************/
                    
                    $sql = "insert into show_case_response_logs(grievance_id,emp_id,notice_status,is_test_done,datetime)values('" . $row['grievance_id'] . "','" . $emp_id3 . "','1','1','" . $notice_Date . "')";
                    mysqli_query($conn, $sql);

                    $sql = "insert into sms_response_logs(grievance_id,mobile,sms_content,response_content,datetime)values('" . $row['grievance_id'] . "','" . $mobile . "','" . $message . "'," . $result . ",'" . $notice_Date . "')";
                    mysqli_query($conn, $sql);
                }
                // exit;
            }
        }
    } else {
        echo "in sla with level 3";
    }
}
?>
