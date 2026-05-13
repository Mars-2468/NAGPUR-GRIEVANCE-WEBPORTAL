<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	//ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
		require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';
	    
	    
	$tpl=new Smarty();
	require_once('csrf.class.php');
    $csrf = new csrf();
	
	
		$token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
	
	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	}
 
 
//echo "<pre>";print_r($_SERVER['HTTP_ORIGIN']);echo "</pre>";die();
 
	
	if(isset($_SESSION['uid']))
	{
	        
	        
	      // session_regenerate_id(); 
	        
	        
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
				mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');	
		
		
		
            function send_notification($tokens,$message,$server_key,$title,$img_url)
            {
            	
            	/*$url ="https://fcm.googleapis.com/fcm/send";
            	$fields=array(  
            	'registration_ids'=>$tokens,
            	'data'=>array('title'=>$title,'message'=>$message,'img_url'=>$img_url)
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
                    
                    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
             
                    // Execute post
                     $result = curl_exec($ch);
                    if ($result === FALSE) {
                        //echo curl_error($ch);
                        die('Curl failed: ' . curl_error($ch));
                        
                        
                    }
             
                    // Close connection
                    curl_close($ch);*/
             $fcmMsg = array(
    'title' => $title,
    'body' => $message,
	'img_url'=>$img_url,
   // 'channelId' => 'smartnagrikchannel',
    'sound' =>'default'

  );
  
  
  
  $fcmFields = array(
    'registration_ids'=>$tokens, //tokens sending for notification
	//'data'=>array('title'=>$title,'message'=>$message,'img_url'=>$img_url),
    'notification' => $fcmMsg,
    'priority'=> "high"

  );

  $headers = array(
    'Authorization: key=AAAAhTsSlJY:APA91bH64ySIjFLEqehl5L4QGOuvfjVic_e978AdtMb4G5_SlyBkjnmG_KIPBx32Lxtjfb9r8y22QPOQQEizuNrp9osDc8y0jqZRzpeXamoPHx-NJky0GygntptHwuCZCtER4QNEvMI5',
    'Content-Type: application/json'
  );

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
$result = curl_exec($ch );

curl_close( $ch );
//echo $result . "\n\n";
                    return $result;
            		
            	
            		
            }
 
 
 	
        $sql=$conn->prepare("select gcm_regid from gcm_users where ulbid=?");
		$ulbid=mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
	    $rs=$sql->get_result();
	   
		while($row = $rs->fetch_assoc())
		{
		    $tokens[]= $row['gcm_regid'];
		}
		
		$sql->close();
		
	
		
		$sql1=$conn->prepare("SELECT * FROM `firebase_keys` WHERE ulbid=?");
		$ulbid=mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']));
		$sql1->bind_param("s",$ulbid);
		$sql1->execute();
	    $rs1=$sql1->get_result();
	   
		while($row1 = $rs1->fetch_assoc())
		{
		    $server_key= $row1['server_key'];
		}
		
		$sql->close();
		
		
		
		
		
		
/* 		if(isset($_POST['save']))
		{
		    if($token_id==$_POST['token']){
	
			// Resizin image
			if(is_uploaded_file($_FILES["photo"]["tmp_name"]))
			{
    			//define ("MAX_SIZE","10000");
                $errors=0;

                $image =$_FILES["photo"]["name"];
                $uploadedfile = $_FILES['photo']['tmp_name'];
                if($image){
                    $filename = stripslashes($_FILES['photo']['name']);
                $extension = strtolower(getExtension($filename));
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")){
                    echo ' Unknown Image extension ';
                    $errors=1;
                } else{
                $newname = time().".".$extension;
                $size=filesize($_FILES['photo']['tmp_name']);
               
                if($extension=="jpg" || $extension=="jpeg" ){
                    $uploadedfile = $_FILES['photo']['tmp_name'];
                    $src = imagecreatefromjpeg($uploadedfile);
                }else if($extension=="png"){
                    $uploadedfile = $_FILES['photo']['tmp_name'];
                    $src = imagecreatefrompng($uploadedfile);
                }else{
                    $src = imagecreatefromgif($uploadedfile);
                }
				
                list($width,$height)=getimagesize($uploadedfile);

                $newwidth=256;
              
		        $newheight=256;
		
                $tmp=imagecreatetruecolor($newwidth,$newheight);

                

                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);

                imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, $width,$height);

                $filename = "notification_images/".$newname;
              

                imagejpeg($tmp,$filename,100); //file name also indicates the folder where to save it to
                

                imagedestroy($src);
                imagedestroy($tmp);
                // $target_file="http://municipalservices.in/".$filename;
				
                //$target_file="https://".$_SERVER['SERVER_NAME']."/csms/".$filename;
                $target_file=$_SERVER['HTTP_ORIGIN'].'/'.$filename;
				
		
                
					}
				}
			}else{
				$target_file="";
			}	
				    		    
				
				
		
			 
		$sql="insert into notification_mst(ulbid,date,time,title,title_marathi,description,description_marathi,photo) values(?,?,?,?,?,?,?,?)";
		$query=$conn->prepare($sql);
		$ulbid=mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']));
		$date=date('Y-m-d',strtotime(strip_tags($_POST['date'])));
		$time=date('Y-m-d H:i:s');
		$title=sanitize_input($_POST['title']); //mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['title'])));
		$title_marathi=sanitize_input($_POST['title_marathi']); //mysqli_real_escape_string($conn,strip_tags($_POST['title_marathi']));
		$description= sanitize_input($_POST['description']); //$_POST['description'];
		$description_marathi= sanitize_input($_POST['description_marathi']); //$_POST['description_marathi'];
		$photo=mysqli_real_escape_string($conn,$target_file);
		$query->bind_param("ssssssss",$ulbid,$date,$time,$title,$title_marathi,$description,$description_marathi,$photo);
	    $result=$query->execute();
			
			if($result)
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Successfully Added ');
				
				
			
            			
            	    $message=strip_tags($_POST['description']);
            		$title=strip_tags($_POST['title']);
            		//$img_url="http://municipalservices.in/notification_images/1502262424.jpg";
            		$img_url=$target_file;
            		//$title=array("title"=>'title');
            		//$message=array("message"=>$message1);
            		//$image1='http://municipalservices.in/notification_images/1501667496.jpg';
            		//$image=array("image"=>$image1);
            		
            		//echo "token".$tokens."-serverkey".$server_key;
            		$message_status=send_notification($tokens,$message,$server_key,$title,$img_url);
            		 
            		$tpl->assign('msg','Notification Sent Successfully');
				
			
				
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
			}



			}
		} */
		
		
	$sql=$conn->prepare("select * from notification_mst where ulbid=? order by date desc");
	$ulbid=mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s",$ulbid);
	$sql->execute();
	$rs=$sql->get_result();
	$tot_row=$rs->num_rows;
	if($rs->num_rows > 0)
			{
			
				$field_info = $rs->fetch_fields();
				while($row = $rs->fetch_assoc())
				{
				
					foreach($field_info as $fi => $f) 
					$doc_list[$row['id']][$f->name]=$row[$f->name];
				}
				$tpl->assign('doc_list',$doc_list);
			}
	//print_r($doc_list);
	
        $sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql->close();
		
    	/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
		
		mysqli_close($conn);
	
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);

        $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('date',$_POST['date']);
		$tpl->assign('desc',$_POST['description']);
		$tpl->assign('photo',$_POST['photo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('token_id',$token_id);
		$flash = get_flash();		
		$tpl->assign("flash", $flash); 
		$tpl->display('add_notification.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
	
                         
                            
                            
                            
                            