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
	    
	     //session_regenerate_id();
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('user_defined_functions.php');
		include('prepare_connection.php');
		
			
		mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
	    $csrf_token=generateToken($csrf_prefix_token);
		$tpl->assign('csrf_token',$csrf_token);
		
		
		 $captcha=mysqli_real_escape_string($conn,$_SESSION['code']);
	    $code=mysqli_real_escape_string($conn,$_POST['code']);
		
		
		if(isset($_POST['update']))
		{
		    
		    if(!empty($_POST['comp_marathi'])){
		        
		        foreach($_POST['comp_marathi'] as $key=>$val){
		            
		            $sql ="update cs_mst set telugu_description='".$val."' where cs_id='".$_POST['cs_ids'][$key]."'";
		            mysqli_query($conn,$sql);
		            
		        }
		    }
		}
		
	
		
		$sql =$conn->prepare("select * from cs_mst");
	
		//$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	   
		while($row = $rs->fetch_assoc())
		{
		      
		      $doc_list[$row['cs_id']]['cs_desc']=$row['cs_desc'];
		      $marathi_list[$row['cs_id']]['telugu_description']= $row['telugu_description'];
		}

	
		$sql->close();
		
		
		
		
			
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
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
		
		
		
		
		
	      
	     /*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type=? and ulbid =?");
		$type=1;
		$sql->bind_param("is",$type,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	      
	      
	      
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	     
	     
		

	
	$tpl->assign('user_type',htmlspecialchars(strip_tags($_SESSION['user_type'])));
		
		$tpl->assign('online_applications',$online_applications);

		$sql->close();
        
        
        $tpl->assign('marathi_list',$marathi_list);
        $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('code',$code);
		$tpl->assign('doc_list',$doc_list);
		$tpl->assign('token_id',$token_id);
		$tpl->display('add_complaint_type.tpl');
		
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>
                            
                            
                            
                            
                            
                            