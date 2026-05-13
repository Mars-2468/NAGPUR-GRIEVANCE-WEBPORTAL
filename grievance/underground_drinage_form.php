<?php
require "config.php";


	date_default_timezone_set('Asia/Calcutta');
    

	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	require_once('csrf.class.php');
    $csrf = new csrf();
	$tpl=new Smarty();
	
	 $token_id = $csrf->get_token_id();
     $token_value = $csrf->get_token($token_id);
     
	if(isset($_SESSION['uid']))
	{
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		//require_once('connection.php');
		//$conn=getconnection();
		
		require_once('prepare_connection.php');
		
		include('user_defined_functions.php');
		$csrf_token=generateToken($csrf_prefix_token);
		$tpl->assign('csrf_token',$csrf_token);
		
			
		
		
		$captcha=mysqli_real_escape_string($conn,$_POST['captcha']);
	
		
		$code=mysqli_real_escape_string($conn,$_SESSION['code']);
		
		if(isset($_POST['save']))
		{
		    
		    
		    	$path="drinagephotos/";
		
		if(is_uploaded_file($_FILES['f1']['tmp_name']))
			{
				 $file = $_FILES["f1"]["name"];
				 $ext = pathinfo($file, PATHINFO_EXTENSION);
				 $newfile =md5(rand(1,99999)).".".$ext;
				 $photo_url = $path.$newfile;
				 
				 
				 
				 
				 

				
				move_uploaded_file($_FILES['f1']['tmp_name'],$photo_url);
				$photo_url="http://municipalservices.in/".$photo_url;
			//	$photo_url=$photo_url;
				
			}
			else
			{
			$photo_url="";
			}
			
		    $sql ="insert into drinageapplications(
		        ulbid,
		        applicant_name,
		        hno,
		        address,
		        ward_no,
		        mobile,
		        email,
		        app_type,
		        file_url,
		        file_type,
		        pipesize,
		        toilet_seats,
		        tax_receipt_yn,
		        adhaar_yn,
		        fsc_yn,
		        date
		        )values(
		            '".$_SESSION['ulbid']."',
		            '".htmlspecialchars(strip_tags($_POST['applicant_name']))."',
		            '".htmlspecialchars(strip_tags($_POST['hno']))."',
		            '".htmlspecialchars(strip_tags($_POST['address']))."',
		            '".htmlspecialchars(strip_tags($_POST['ward_id']))."',
		            '".htmlspecialchars(strip_tags($_POST['mobile']))."',
		            '".htmlspecialchars(strip_tags($_POST['email']))."',
		            '".htmlspecialchars(strip_tags($_POST['app_type']))."',
		            '".htmlspecialchars(strip_tags($photo_url))."',
		            '".$ext."',
		            '".htmlspecialchars(strip_tags($_POST['pipesize']))."',
		            '".htmlspecialchars(strip_tags($_POST['toilet_seats']))."',
		            '".htmlspecialchars(strip_tags($_POST['tax_receipt_yn']))."',
		            '".htmlspecialchars(strip_tags($_POST['adhaar_yn']))."',
		            '".htmlspecialchars(strip_tags($_POST['fsc_yn']))."',
		            '".date('Y-m-d',strtotime($_POST['datetime']))."'
		            
		            )";
		            
		            if(mysqli_query($conn,$sql))
		            {
		                $insertid = mysqli_insert_id($conn);
		                foreach($_POST['check_list'] as $val)
		                {
		                    $sql ="insert into drinage_water_source_map(
		                        app_id,
		                        ulbid,
		                        source_id
		                        )values('".$insertid."','".$_SESSION['ulbid']."','".$val."')";
		                        mysqli_query($conn,$sql);
		                }
		            }
		            
		            $tpl->assign('msg','Data saved successfully');
		    
		   
		}
		
	
		
		$sql =$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=? order by ward_id ASC");
	
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
	    
		while($row = $rs->fetch_assoc())
		{
		    $ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		$sql->close();
		
		
	
		//$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		//printf( str_replace('?', '%s', $sql), $_SESSION['ulbid']);
		
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		
		$sql->bind_param("s",$_SESSION['ulbid']);
		//printf( str_replace('?', '%s', $sql), $_SESSION['ulbid']);
		$sql->execute();
		
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql->close();
		
		/** captcha generation ****/
    		
    	     $code=rand(1000,9999);
    	 
             $_SESSION['code']=$code;	
            
    		 
    		 
    	
		/** close **/
		
		/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	    
	    //$ward_list=array(2,3);
	    
	    $sql ="SELECT * FROM `drinage_app_types`";
	    $rs = mysqli_query($conn,$sql);
	    while($row = mysqli_fetch_assoc($rs))
	    {
	        $app_list[$row['id']]=$row['application_desc'];
	    }
		
	    $users_count=$row['user_count'];
	    
	    $tpl->assign('app_list',$app_list);
	    $tpl->assign('users_count',$users_count);
        $tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('ulbid',$_SESSION['ulbid']);			
		$tpl->assign('ward_list',$ward_list);
	    $tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('code',$code);
		$tpl->assign('token_id',$token_id);
		
		$tpl->display('underground_drinage_form.tpl');
		
		
	}
	
		
	
	
	else
	{
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
?>