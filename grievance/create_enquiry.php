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
		    
		    if($token_id==$_POST['token']){
		    
		    
		   
		        
		        if ( !empty( $_POST['csrf_token'] ) ) {
		        
		        if( checkToken( $_POST['csrf_token'], $csrf_prefix_token ) ) {
		    
		                    $ward_description=preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_desc']);
		                    
		                    
		                    
		                    if(!empty($ward_description))
		                    {
		    
                				if($_POST['id']=='0')
                				{
                				    
                				   $sql ="insert into enquiryList(listdesc) values(?)";
                				    $query=$conn->prepare($sql);
                				    $query->bind_param("s",$ward_description);
                				    
                				}
                				else
                				{
                				    
                				    $sql ="update enquiryList set listdesc=? where id=?";
                				    $query=$conn->prepare($sql);
                				    $query->bind_param("si",$ward_description,$_POST['id']);
                				    
                					
                				}
                				if($query->execute())
                				{
                					$tpl->assign('class','alert alert-success display-hide');
                					$msg="Successfully Saved";
                				}
                				else
                				{
                					$tpl->assign('msg','alert alert-danger display-hide');
                					$msg="Uable to save   ".$query->error;
                				}
                				$query->close();
		                    }
		                    else
		                    {
		                            $tpl->assign('class','alert alert-success display-hide');
                					$msg="Enter a valid ward description";
		                    }
            				
            				$tpl->assign('msg',$msg);
		        }
		        else
		        {
		            $tpl->assign('msg','Invalid token');
		        }
		        }
		        else
		        {
		                            $tpl->assign('msg','Something went wrong');
                					
		        }

		            
		
		            
		}
		
		}
		
	
		
		$sql =$conn->prepare("select id as ward_id,listdesc as ward_desc from enquiryList");
	
	
		$sql->execute();
	    $rs=$sql->get_result();
	    
		while($row = $rs->fetch_assoc())
		{
		    $ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		$sql->close();
		
		
		$sql =$conn->prepare("select ward_id,count(street_id) num_streets from street_mst where ulbid=? group by ward_id");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $ward_list1[$row['ward_id']]=$row['num_streets'];
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
		
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
        $tpl->assign('user_type',$_SESSION['user_type']);
		$conn->close();
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('ulbid',$_SESSION['ulbid']);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('code',$code);
		$tpl->assign('token_id',$token_id);
		$tpl->display('create_enquiry.tpl');
		
		
	}
	
		
	
	
	else
	{
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
?>