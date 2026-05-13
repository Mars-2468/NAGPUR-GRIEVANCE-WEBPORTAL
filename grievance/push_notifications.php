<?php
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
	    
	    
	  

function send_notification($tokens,$message,$server_key,$title)
{
	//print_r($tokens);
	$url ="https://fcm.googleapis.com/fcm/send";
	$fields=array(
	'registration_ids'=>$tokens,
	'data'=>array('title'=>$title,'message'=>$message)
	//'data'=>$message
	//'image'=>$image
	);
	$headers = array(
            //'Authorization:key=AIzaSyCaZA3-bLwp-JdLUbqsF3l001GOIhFY3lA',
            'Authorization:key='.$server_key,
            'Content-Type: application/json'
          
        );
		 $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
         $result = curl_exec($ch);
        if ($result === FALSE) {
            //echo curl_error($ch);
            die('Curl failed: ' . curl_error($ch));
            
            
        }
 
        // Close connection
        curl_close($ch);
 
        return $result;
		
		
		
		
		
}


        require_once('connection.php');
		$conn=getconnection();

	    $sql ="select gcm_regid from gcm_users where ulbid=?";
	    $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	    
	    $query = $conn->prepare($sql);
		$query->bind_param(s,$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
			$tokens[]= $row['gcm_regid'];
		}
		
		$sql1 ="SELECT * FROM `firebase_keys` WHERE ulbid=?";
		$query = $conn->prepare($sql);
		$query->bind_param(s,$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		while($row1 = $rs->fetch_assoc())
		{
			$server_key= $row1['server_key'];
		}
		
		
		
		if(isset($_POST['save']))
		{
    		$message1=$_POST['message'];
    		$title=$_POST['title'];
    		$message=array("message"=>$message1);
    		$image1='http://municipalservices.in/notification_images/1501667496.jpg';
    		$image=array("image"=>$image1);
    		$message_status=send_notification($tokens,$message,$server_key,$title);
    	    	if($message_status)
            		{
                		$tpl->assign('class','alert alert-success display-hide');
                		$msg="Notifications sent Successfully";
            		}else{
            		        $tpl->assign('msg','alert alert-danger display-hide');
            				$tpl->assign('msg','Unable to Process, Please try again');
            		     }
            		     
            		     
		}
		
		
	    $query->close();

	    $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('msg',$msg);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('push_notifications.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>