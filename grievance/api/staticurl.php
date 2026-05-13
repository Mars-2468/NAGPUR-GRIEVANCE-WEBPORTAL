<?php
error_reporting(0);
require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	// if($apk_version ==''){
	// 	$data['Status']=350;
	// 	$data['message']='Please Update Your Application';

	// }else{
	//require_once('check_version.php');

	
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	
	$data = array(
	'ptaxurl'=>'https://aurangabadmahapalika.org/TaxCollection/pg/property/getPropertyPgApi',
	'wtaxurl'=>'https://aurangabadmahapalika.org/Watersupply/pg/ledger/getPgConsumerDetails',
	'ptax_receipt_url'=>'http://43.242.214.64:8080/TaxCollection/pg/property/getPropertyPgApi',
	'wtax_receipt_url'=>'https://aurangabadmahapalika.org/Watersupply/pg/ledger/getWaterReceiptOnline',
	'flag_status'=>0,
	"RTS"                                     => "http://rtsnagpur.egovmars.in/RTS/ws/user/login.do",
    "citizen_centric_online_services"         => "http://rtsnagpur.egovmars.in/RTS/ws/user/login.do",
    "pass_port"                               => "https://www.passportindia.gov.in/AppOnlineProject/welcomeLink",
    "voterid"                                 => "https://www.nvsp.in/",
    "pan"                                     => "https://www.onlineservices.nsdl.com/paam/endUserRegisterContact.html",    
	);
		
		// }
		
	

echo json_encode($data);
mysqli_close($conn);



?>