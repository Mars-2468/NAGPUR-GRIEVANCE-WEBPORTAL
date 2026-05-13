<?php
require "config.php";
ini_set('display_errors',0);

	
    date_default_timezone_set('Asia/Calcutta');
   
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		
		//require_once('prepare_connection.php');
		$conn=getconnection();
		
		if(isset($_POST['save']))
		{
		    $sql ="insert into enquiries(
		        regardingId,
		        name,
		        mobile,
		        fromid,
		        ulbid,
		        distidvillage,
		        mandalid,
		        villageid,
		        distidothers,
		        town,
		        village,
		        remarks,
		        datetime,
		        user_id
		        )values(
		            '".$_POST['regid']."',
		            '".$_POST['personname']."',
		            '".$_POST['mobile']."',
		            '".$_POST['fromid']."',
		            '".$_POST['ulbid']."',
		            '".$_POST['distidvillage']."',
		            '".$_POST['mandalid']."',
		            '".$_POST['villageid']."',
		            '".$_POST['distidothers']."',
		            '".$_POST['town']."',
		            '".$_POST['village']."',
		            '".$_POST['remarks']."',
		            '".date('Y-m-d')."',
		            '".$_SESSION['uid']."'
		            
		            )";
		            
		            if(mysqli_query($conn,$sql))
		            {
		                $tpl->assign('msg','Enquiry saved successfully');
		                echo "<script>alert('Enquiry saved successfully')</script>";
		            }
		            else
		            {
		                $tpl->assign('msg','Enquiry Not saved . Please try again');
		                echo "<script>alert('Enquiry Not saved . Please try again')</script>";
		            }
		            ///return redirect('create_grievance.php');
		            echo "<script>window.location='create_grievance.php';</script>";exit;
		}
	    
			
			
			
			
			
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('ulblist',$ulblist);
		mysqli_close($conn);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);
		$tpl->assign('ulbid',$_SESSION['ulbid']);			
		$tpl->assign('app_type_list',array('1'=>'Complaint'));		
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);
		$tpl->assign('street_list',$street_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
				
		$tpl->display('create_grievance.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
		
?>