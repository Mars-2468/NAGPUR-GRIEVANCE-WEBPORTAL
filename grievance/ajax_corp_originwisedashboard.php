<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('get_services.php');
$obj = new get_services($_SESSION['uid']);
require_once('connection.php');
$conn = getconnection();

$ward_id=$_SESSION['zone_id'];
// Total received

/** counting grievence origing wise report**/
$app_type_id = 1;
$disposal_status = 5;

$sql = $conn->prepare("SELECT g.grievance_origin_id, COUNT(DISTINCT g.grievance_id) AS count from grievances g, ulbmst u,Districtmst d  where g.ulbid=u.ulbid and u.distid=d.distid 
and g.cat3_id!=0 and g.app_type_id=? and g.ulbid=? and g.ward_id=? and grievance_status_id in(1,2,3,6,8,9,11,12,13) group by g.grievance_origin_id ");
$sql->bind_param("isi", $app_type_id, $_SESSION['ulbid'],$ward_id);
	

$sql->execute();
$rs = $sql->get_result();
//echo $sql;exit;


while ($row = $rs->fetch_assoc()) {

    $origin_rep[$row['grievance_origin_id']]['count'] = $row['count'];
    $origin_rep['total_received'] += $row['count'];
}


//echo "<pre>";print_r($origin_rep);echo "</pre>";die();


//echo $rs->num_rows;
?>

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

                                    <?php                                     
                                        echo "<a href='corp_cat_origin.php?originid=0&app_type_id=1&ulbid=" . $_SESSION['ulbid'] . "' target='_blank'>" . $origin_rep['total_received'] . "</a>";
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
       
                                    <?php echo "<a href='corp_cdma_ulbwise_origin_rep.php?originid=1&app_type_id=1&status=0' target='_blank'>" . ($origin_rep[0]['count'] + $origin_rep[1]['count']) . "</a>"; ?>

                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">NMC Website</span></p>
                            </div>
                        </section>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon bg-info">
                                <i class="fa fa-phone-square text-large stat-icon "></i>
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
										$count = isset($origin_rep[2]['count']) && !empty($origin_rep[2]['count']) ? $origin_rep[2]['count'] : 0;
										if($count == 0){
                                            echo $count;
                                        }else{
                                            echo "<a href='corp_cdma_ulbwise_origin_rep.php?originid=2&app_type_id=1&status=0' target='_blank'>" . $count . "</a>";
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
                           
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                      $counterCount = isset($origin_rep[3]['count']) && !empty($origin_rep[3]['count']) ? $origin_rep[3]['count'] : 0;

                                        if($counterCount == 0){
                                            echo $counterCount;
                                        }
                                        else{
                                            echo "<a href='corp_cdma_ulbwise_origin_rep.php?originid=3&app_type_id=1&status=0' target='_blank'>" . $counterCount . "</a>";
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
                              
                                <p class="size-h1 no-margin countdown_first">
                                    <?php
                                        $count = isset($origin_rep[4]['count']) && !empty($origin_rep[4]['count']) ? $origin_rep[4]['count'] : 0;
                                       
                                            if($count == 0){
                                                echo $count;
                                            }
                                            else{
                                                echo "<a href='corp_cdma_ulbwise_origin_rep.php?originid=4&app_type_id=1&status=0' target='_blank'>" . $origin_rep[4]['count'] . "</a>";
                                            }
                                        
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">App My Nagpur Mobile Application</span></p>
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
                                    $count = isset($origin_rep[8]['count']) && !empty($origin_rep[8]['count']) ? $origin_rep[8]['count'] : 0;
                                    
                                        if($count == 0){
                                            echo $count;
                                        }
                                        else{
                                            echo "<a href='corp_cdma_ulbwise_origin_rep.php?originid=8&app_type_id=1&status=0' target='_blank'>" . $origin_rep[8]['count'] . "</a>";
                                        }
                                    
                                    ?>
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Garden Complaints</span></p>
                            </div>
                        </section>
                    </div>
					
                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon" style="background-color: #D8BFD8;"> <!-- Changed to a green color -->
                                <i class="fa fa-folder-o text-large stat-icon"></i> <!-- Changed icon to leaf -->
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                     <?php echo "<a href='corp_mayor_office.php?originid=10'>".($origin_rep[10]['count']??0)."</a>"; 
                                    ?> 
                               
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Mayor Office</span></p>
                            </div>
                        </section>
                    </div>
					
                    <div class="col-md-4 col-sm-6">
                        <section class="panel panel-box">
                            <div class="panel-left panel-icon" style="background-color: #D8BFD8;"> <!-- Changed to a green color -->
                                <i class="fa fa-folder-o text-large stat-icon"></i> <!-- Changed icon to leaf -->
                            </div>
                            <div class="panel-right panel-icon bg-reverse">
                                <p class="size-h1 no-margin countdown_first">
                                     <?php echo "<a href='corp_deputy_mayor_office.php?originid=11'>".($origin_rep[11]['count']??0)."</a>"; 
                                    ?> 
                               
                                </p>
                                <p class="text-muted no-margin"><span style="color:#000;">Deputy Mayor Office</span></p>
                            </div>
                        </section>
                    </div>
					
                  
                </div>
            </div>
        </div><!-- /.tab-pane -->

        <?php mysqli_close($conn); ?>