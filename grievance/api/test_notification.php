<?php
	error_reporting(0);
function send_notification($token,$message)
{
	
	$url ="https://fcm.googleapis.com/fcm/send";
	$fields=array(
	'registration_ids'=>$token,
	'data'=>$message
	);
	$headers = array(
            //'Authorization:key=AIzaSyDE98mJX4HtEvVtusWf1HNkk_l1RDO2ct0',
            'Authorization:key=AAAAKhpohWs:APA91bH49kOPnP4pV1WX_Mn1X6v6MU27W3oo51g4qx7Hk5FWhQ3llfssOlK91P1JltnnAznXPNn4xorAedbb_QaTubbnCmBsB88NhTytuDT9FNmboZmhfFO-wT-EyqSw19aRQA3VFWBj',
            'Content-Type: application/json'
        );
		 $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
 
        return $result;
		
		
		
		
}
		require_once('../connection.php');
		$conn=getconnection(); 
		
		$sql ="select gcm_regid from gcm_users";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
			$tokens[]= $row['gcm_regid'];
		}
		mysqli_close($conn);
		$message=array("message"=>"FCM PUSH NOTIFICATION MESSAGE");
		$message_status=send_notification($tokens,$message);
		echo $message_status;

?>