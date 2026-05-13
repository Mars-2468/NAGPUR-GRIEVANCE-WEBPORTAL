
<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once('get_services.php');
$obj = new get_services($_SESSION['uid']);
require_once('connection.php');
$conn = getconnection();

$grievances_trns=$_SESSION['grievances_trns'];
// Total received

/** counting grievence origing wise report**/
$app_type_id = 1;
$disposal_status = 5;
if ($_SESSION['user_type'] == 'A') {
    echo $sql = $conn->prepare("SELECT count(grievance_id) as count , grievance_origin_id from grievances g,cs_mst c, ulbmst u where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.app_type_id=?  group by grievance_origin_id");
    $sql->bind_param("i", $app_type_id);
} else if ($_SESSION['user_type'] == 'R') {
    $sql = $conn->prepare("SELECT count(grievance_id) as count , grievance_origin_id from grievances g,cs_mst c, ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and g.cat3_id=c.cs_id and g.app_type_id=? and d.rdma=?  group by grievance_origin_id");
    $sql->bind_param("is", $app_type_id, $_SESSION['uid']);
} else if ($_SESSION['user_type'] == 'U') {
	
	if(in_array($_SESSION['uid'],$all_mayor_dmayor_users)){
		$sql = $conn->prepare("SELECT count(distinct g.grievance_id) as count , grievance_origin_id from grievances g,".$grievances_trns." gt where g.grievance_id=gt.grievance_id and app_type_id=? and ulbid=? and user_id=? group by grievance_origin_id");
	    $sql->bind_param("iss", $app_type_id, $_SESSION['ulbid'],$_SESSION['uid']);
	}else{	
		$sql = $conn->prepare("SELECT count(distinct g.grievance_id) as count , grievance_origin_id from grievances g,".$grievances_trns." gt  where g.grievance_id=gt.grievance_id and grievance_status_id in(1,2,3,6,8,9,11,12,13) and app_type_id=? and ulbid=? and cat3_id!=0 group by grievance_origin_id ");
		$sql->bind_param("is", $app_type_id, $_SESSION['ulbid']);
	}
	
} else if ($_SESSION['user_type'] == 'E') {
	
	$bsql="SELECT count(distinct g.grievance_id) as count , grievance_origin_id from grievances g,".$grievances_trns." gt where g.grievance_id=gt.grievance_id and g.grievance_status_id in(1,2,3,6,8,9,11,12,13) and app_type_id=? and ulbid=? and  emp_id=?  group by grievance_origin_id";
	
    $sql = $conn->prepare($bsql);
    $sql->bind_param("isi", $app_type_id, $_SESSION['ulbid'], $_SESSION['emp_id']);
}
$sql->execute();
$rs = $sql->get_result();
//echo $sql;
 $origin_rep=[];
$origin_rep['total_received']=0;
while ($row = $rs->fetch_assoc()) {

    $origin_rep[$row['grievance_origin_id']]['count'] = $row['count'];
    $origin_rep['total_received'] += $row['count'];
}

//print_r($origin_rep);
//echo $rs->num_rows;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="tab-pane" id="tab_3">
    <div class="">
        <div class="boxed">
            <!-- Title Bart Start -->
            <!-- <h4>Total Number of Complaints</h4>-->
            <div class="bash_heading row m-b20"> Complaints Origin Wise Report </div>
            <!-- Title Bart End -->
            <div>

                <div class="row dashboard-stats">
                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-success">
                                <i class="fa fa-cloud-download text-large stat-icon "></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">

                                    <?php //echo "<a href='services1.php?status=0&aptid=1&user_type=".$_SESSION['user_type']."'>".$origin_rep['total_received']."</a>"; 
                                    ?>

                                    <?php if ($_SESSION['user_type'] == 'U') {
                                        echo "<a href='cat_origin.php?originid=0&app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "' target='_blank'>" . $origin_rep['total_received'] . "</a>";
                                    } else if ($_SESSION['user_type'] == 'E') {
                                        echo $origin_rep['total_received'];
                                    } else {
                                        echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=1&name=" . $_SESSION['uid'] . "' target='_blank'>" . $origin_rep['total_received'] . "</a>";
                                    }
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">From All Sources</span></p>
                            </div>
                        </section>
                    </div>


                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-lovender">
                                <i class="fa fa-globe text-large stat-icon "></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">


                                    <?php //echo "<a href='cat_origin.php?originid=0'>".$origin_rep[0]['count']."</a>"; 
                                    ?>
                                    <?php echo "<a href='cdma_ulbwise_origin_rep.php?originid=1&app_type_id=1&status=0' target='_blank'>" . ($origin_rep[0]['count'] + $origin_rep[1]['count']) . "</a>"; ?>


                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">NMC Website</span></p>
                            </div>
                        </section>
                    </div>

                    <!--24-05-2024 <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-info">
                                <i class="fa fa-phone-square text-large stat-icon "></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">-->
                    <!--<p class="size-h1 no-margin countdown_first"> <?php //echo "<a href='cat_origin.php?originid=2'>".$origin_rep[2]['count']."</a>"; 
                                                                        ?></p>-->
                    <!--24-05-2024<p class="size-h1 no-margin countdown_first"> <?php echo "<a href='cdma_ulbwise_origin_rep.php?originid=2&status=0' target='_blank'>" . $origin_rep[2]['count'] . "</a>"; ?></p>
                                <p class="text-muted no-margin"><span style="color:#000;">Received via Call</span></p>
                            </div>
                        </section>
                    </div> -->

                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-info">
                                <i class="fa fa-phone-square text-large stat-icon "></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                    // Check if $origin_rep[2]['count'] is set and not empty, otherwise display 0
                                    $count = isset($origin_rep[2]['count']) && !empty($origin_rep[2]['count']) ? $origin_rep[2]['count'] : 0;

                                    if ($_SESSION['user_type'] == 'U') {
                                        if($count == 0){
                                            echo $count;
                                        }
                                        else{
                                            echo "<a href='cdma_ulbwise_origin_rep.php?originid=2&app_type_id=1&status=0' target='_blank'>" . $count . "</a>";
                                        }
                                    } else if ($_SESSION['user_type'] == 'E') {
                                        echo $count;
                                    } else {
                                        echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=1&name=" . $_SESSION['uid'] . "' target='_blank'>" . $count . "</a>";
                                    }
                                    ?>
                                </p>
                                <!--08-07-2024 <p class="text-muted no-margin"><span style="color:#000;">Received Via Call</span></p> -->
                                <p class="text-muted no-margin"><span style="color:#000;">Received Via Call/SMS/Social Media</span></p>
                            </div>
                        </section>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-vimeo">
                                <i class="fa fa-desktop text-large stat-icon "></i>
                            </div>
                            <!--22/5/24 <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first"> 
                                    <?php

                                    //$counterCount = $origin_rep[3]['count'];

                                    //echo "<a href='cat_origin.php?originid=3'>".$counterCount."</a>";
                                    if ($_SESSION['user_type'] == 'A') {
                                        //echo "<a href='cdma_ulbwise_origin_rep.php?originid=3&status=0' target='_blank'>" . $counterCount . "</a>";
                                    } else {
                                        //echo "<a href='cat_origin.php?app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "&originid=3' target='_blank'>" . $counterCount . "</a>";
                                    }
                                    ?> 
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">CFC centers/Zone Offices/ Head Office</span></p>
                            </div> -->
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                    // Check if the counter count is set and not null, otherwise set it to 0
                                    //24-05-24 $counterCount = isset($origin_rep[3]['count']) ? $origin_rep[3]['count'] : 0;

                                    $counterCount = isset($origin_rep[3]['count']) && !empty($origin_rep[3]['count']) ? $origin_rep[3]['count'] : 0;

                                    /*24-05-24 if ($_SESSION['user_type'] == 'A') {
                                        echo "<a href='cdma_ulbwise_origin_rep.php?originid=3&status=0' target='_blank'>" . $counterCount . "</a>";
                                    } else {
                                        echo "<a href='cat_origin.php?app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "&originid=3' target='_blank'>" . $counterCount . "</a>";
                                    }*/
                                    if ($_SESSION['user_type'] == 'U') {
                                        if($counterCount == 0){
                                            echo $counterCount;
                                        }
                                        else{
                                            echo "<a href='cdma_ulbwise_origin_rep.php?originid=3&app_type_id=1&status=0' target='_blank'>" . $counterCount . "</a>";
                                        }
                                    } else if ($_SESSION['user_type'] == 'E') {
                                        echo $counterCount;
                                    } else {
                                        echo "<a href='cat_origin.php?app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "&originid=3&app_type_id=1' target='_blank'>" . $counterCount . "</a>";
                                    }
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">CFC Centers/Zone Offices/ Head Office</span></p>
                            </div>

                        </section>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-danger">
                                <i class="fa fa-android text-large stat-icon "></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <!--<p class="size-h1 no-margin countdown_first"> 
                                    <?php //echo "<a href='cat_origin.php?originid=4'>".$origin_rep[4]['count']."</a>"; 
                                    ?> 
                                </p>-->

                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                        $count = isset($origin_rep[4]['count']) && !empty($origin_rep[4]['count']) ? $origin_rep[4]['count'] : 0;
                                        //24-05-24 echo "<a href='cdma_ulbwise_origin_rep.php?originid=4&status=0' target='_blank'>" . $origin_rep[4]['count'] . "</a>"; 
                                        if ($_SESSION['user_type'] == 'U') {
                                            if($count == 0){
                                                echo $count;
                                            }
                                            else{
                                                echo "<a href='cdma_ulbwise_origin_rep.php?originid=4&app_type_id=1&status=0' target='_blank'>" . $origin_rep[4]['count'] . "</a>";
                                            }
                                        } else if ($_SESSION['user_type'] == 'E') {
                                            echo $count;
                                        } else {
                                            echo "<a href='cat_origin.php?app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "&originid=4&app_type_id=1' target='_blank'>" . $count . "</a>";
                                        }
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">App My Nagpur Mobile Application</span></p>
                            </div>
                        </section>
                    </div>

                    <!--22/5/24 <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-danger">
                                <i class="fa fa-user text-large stat-icon "></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first"> <?php //echo "<a href='cdma_ulbwise_origin_rep.php?originid=7&status=0' target='_blank'>" . $origin_rep[7]['count'] . "</a>"; 
                                                                                ?> </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Endorsed by Commissioner Accepted/Committed by Commissioner</span></p>
                            </div>
                        </section>
                    </div> -->

                    <!-- <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-danger">
                                <i class="fa fa-user text-large stat-icon"></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                        //$count = isset($origin_rep[7]['count']) && !empty($origin_rep[7]['count']) ? $origin_rep[7]['count'] : 0;
                                        // Check if the count is set and not null, otherwise set it to 0
                                        /*24-05-24 $count = isset($origin_rep[7]['count']) ? $origin_rep[7]['count'] : 0;
                                            echo "<a href='cdma_ulbwise_origin_rep.php?originid=7&status=0' target='_blank'>" . $count . "</a>";*/
                                        /*new if ($_SESSION['user_type'] == 'U') {
                                            echo "<a href='cdma_ulbwise_origin_rep.php?originid=7&status=0' target='_blank'>" . $count . "</a>";
                                        } else if ($_SESSION['user_type'] == 'E') {
                                            echo $count;
                                        } else {
                                            echo "<a href='cat_origin.php?app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "&originid=7' target='_blank'>" . $count . "</a>";
                                        }*/
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Endorsed by Commissioner Accepted/Committed by Commissioner</span></p>
                            </div>
                        </section>
                    </div> -->

                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon" style="background-color: #28a745;"> <!-- Changed to a green color -->
                                <i class="fa fa-leaf text-large stat-icon"></i> <!-- Changed icon to leaf -->
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                    $count = isset($origin_rep[8]['count']) && !empty($origin_rep[8]['count']) ? $origin_rep[8]['count'] : 0;
                                    //24-05-24 echo "<a href='cdma_ulbwise_origin_rep.php?originid=8&status=0' target='_blank'>" . $origin_rep[8]['count'] . "</a>"; 
                                    if ($_SESSION['user_type'] == 'U') {
                                        if($count == 0){
                                            echo $count;
                                        }
                                        else{
                                            echo "<a href='cdma_ulbwise_origin_rep.php?originid=8&app_type_id=1&status=0' target='_blank'>" . $origin_rep[8]['count'] . "</a>";
                                        }
                                    } else if ($_SESSION['user_type'] == 'E') {
                                        echo $count;
                                    } else {
                                        echo "<a href='cat_origin.php?app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "&originid=8&app_type_id=1' target='_blank'>" . $count . "</a>";
                                    }
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Garden Complaints</span></p>
                            </div>
                        </section>
                    </div>
					
					<div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon" style="background-color: #28a745;"> <!-- Changed to a green color -->
                                <i class="fa fa-leaf text-large stat-icon"></i> <!-- Changed icon to leaf -->
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                    $count = isset($origin_rep[12]['count']) && !empty($origin_rep[12]['count']) ? $origin_rep[12]['count'] : 0;
                                    //24-05-24 echo "<a href='cdma_ulbwise_origin_rep.php?originid=12&status=0' target='_blank'>" . $origin_rep[12]['count'] . "</a>"; 
                                    if ($_SESSION['user_type'] == 'U') {
                                        if($count == 0){
                                            echo $count;
                                        }
                                        else{
                                            echo "<a href='cdma_ulbwise_origin_rep.php?originid=12&app_type_id=1&status=0' target='_blank'>" . $origin_rep[12]['count'] . "</a>";
                                        }
                                    } else if ($_SESSION['user_type'] == 'E') {
                                        echo $count;
                                    } else {
                                        echo "<a href='cat_origin.php?app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "&originid=12&app_type_id=1' target='_blank'>" . $count . "</a>";
                                    }
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">QR Complaints</span></p>
                            </div>
                        </section>
                    </div>
					<?php if(in_array($_SESSION['uid'],$mayor_users)) { ?>
                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon" style="background-color: #D8BFD8;"> <!-- Changed to a green color -->
                                <i class="fa fa-folder-o text-large stat-icon"></i> <!-- Changed icon to leaf -->
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                     <?php echo "<a href='mayor_office.php?originid=10'>".($origin_rep[10]['count']??0)."</a>"; 
                                    ?> 
                               
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Mayor Office</span></p>
                            </div>
                        </section>
                    </div>
					<?php } ?>	
					<?php if(in_array($_SESSION['uid'],$deputy_mayor_users)) { ?>
                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon" style="background-color: #D8BFD8;"> <!-- Changed to a green color -->
                                <i class="fa fa-folder-o text-large stat-icon"></i> <!-- Changed icon to leaf -->
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                     <?php echo "<a href='deputy_mayor_office.php?originid=11'>".($origin_rep[11]['count']??0)."</a>"; 
                                    ?> 
                               
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Deputy Mayor Office</span></p>
                            </div>
                        </section>
                    </div>
					<?php } ?>
                    <!--08-07-2024 <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-danger">
                                <i class="fa fa-user text-large stat-icon"></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                    //08-07-2024 $count = isset($origin_rep[7]['count']) && !empty($origin_rep[7]['count']) ? $origin_rep[7]['count'] : 0;
                                    // Check if the count is set and not null, otherwise set it to 0
                                    /*24-05-24 $count = isset($origin_rep[7]['count']) ? $origin_rep[7]['count'] : 0;
                                        echo "<a href='cdma_ulbwise_origin_rep.php?originid=7&status=0' target='_blank'>" . $count . "</a>";*/
                                    /*08-07-2024 if ($_SESSION['user_type'] == 'U') {
                                        if($count == 0){
                                            echo $count;
                                        }
                                        else{
                                            echo "<a href='cdma_ulbwise_origin_rep.php?originid=7&app_type_id=1&status=0' target='_blank'>" . $count . "</a>";
                                        }
                                    } else if ($_SESSION['user_type'] == 'E') {
                                        echo $count;
                                    } else {
                                        echo "<a href='cat_origin.php?app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "&originid=7&app_type_id=1' target='_blank'>" . $count . "</a>";
                                    }*/
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Endorsed by Commissioner Accepted/Committed by Commissioner</span></p>
                            </div>
                        </section>
                    </div> -->
                </div>
            </div>
        </div><!-- /.tab-pane -->

        <?php mysqli_close($conn); ?>