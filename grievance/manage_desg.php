<?php
    require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    $tpl->assign('msg',$_SESSION['msg']);
           // echo $_SESSION['msg'];
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		//include('prepare_connection.php');
		$conn=getconnection();
		include('user_defined_functions.php');
         $csrf_token=generateToken($csrf_prefix_token);
         $tpl->assign('csrf_token',$csrf_token);
		
		$captcha=mysqli_real_escape_string($conn,$_POST['captcha']);
	    $code=mysqli_real_escape_string($conn,$_SESSION['code']);
	    
	    
	    mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
		//echo "<pre>";print_r($_POST);echo "</pre>";die();
		
		if(isset($_POST['sort_order']))
		{
		
			for($i=0;$i<=$_POST['cnt'];$i++)
			{
				$orderid="orderid".$i;
		    	$desg_id="desg_id".$i;
				
				$order =$_POST[$orderid];
			    $desg = $_POST[$desg_id];
				
                $sql ="update desg_mst set sort_order=? where desg_id=?";
                $query=$conn->prepare($sql);
                $query->bind_param("ii",$order,$desg);
                
               if($query->execute())
				{
					$tpl->assign('class','alert alert-success display-hide');
                    $msg="Successfully Updated Details..!";
				}
 				
			}			
                $query->close();
                $tpl->assign('msg',$msg);
		}
		
		$desg_count=1;

		$sql =$conn->prepare("select desg_id,dept_id,desg_desc,desig_marathi,sort_order from desg_mst where ulbid=? order by sort_order,desg_id,dept_id");
		
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		        $desg_list[$row['desg_id']]['dept_id']=$row['dept_id'];
				$desg_list[$row['desg_id']]['desg_desc']=$row['desg_desc'];
				$desg_list[$row['desg_id']]['desig_marathi']=$row['desig_marathi'];
				$desg_list[$row['desg_id']]['sort_order']=$row['sort_order'];
				$desg_count_list[$desg_count]=$desg_count;
				$desg_count++;
		}
		
		$sql->close();
				
		$sql =$conn->prepare("select dept_id,dept_desc,dept_marathi from dept_mst where ulbid=? order by dept_id");
		
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		$sql->close();
			
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
		
		/** captcha generation ****/
    		
		$code=rand(1000,9999);
	 
		$_SESSION['code']=$code;	
        
		//die('ssss');
		
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
		
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('desg_count_list',$desg_count_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('code',$code);
		$flash = get_flash();		
		$tpl->assign("flash", $flash); 		
		$tpl->display('manage_desg.tpl');
	}
	else
	{
	
		
		echo "<script>window.location='index.php';</script>";
		
	}
	
