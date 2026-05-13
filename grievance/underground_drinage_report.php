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
		
		$sql ="select *,d.id as autoid,
		IF(tax_receipt_yn=1,'Yes','No') as tax_receipt_yn,
		IF(adhaar_yn=1,'Yes','No') as adhaar_yn,
		IF(fsc_yn=1,'Yes','No') as fsc_yn
		from drinageapplications d
		left join ward_mst w on d.ward_no=w.ward_id
		left join drinage_app_types dat on d.app_type=dat.id
		left join drinage_size ds on d.pipesize=ds.id
		
		
		where d.ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $data[$row['autoid']]['applicant_name'] = $row['applicant_name'];
		    $data[$row['autoid']]['hno'] = $row['hno'];
		    $data[$row['autoid']]['address'] = $row['address'];
		    $data[$row['autoid']]['ward_desc'] = $row['ward_desc'];
		    $data[$row['autoid']]['mobile'] = $row['mobile'];
		    $data[$row['autoid']]['email'] = $row['email'];
		    $data[$row['autoid']]['application_desc'] = $row['application_desc'];
		    $data[$row['autoid']]['file_url'] = $row['file_url'];
		    $data[$row['autoid']]['file_type'] = $row['file_type'];
		    $data[$row['autoid']]['size_desc'] = $row['size_desc'];
		    $data[$row['autoid']]['toilet_seats'] = $row['toilet_seats'];
		    $data[$row['autoid']]['tax_receipt_yn'] = $row['tax_receipt_yn'];
		    $data[$row['autoid']]['adhaar_yn'] = $row['adhaar_yn'];
		    $data[$row['autoid']]['fsc_yn'] = $row['fsc_yn'];
		    $data[$row['autoid']]['date'] = $row['date'];
		}
		
		$sql ="select * from drinage_water_source_map d left join water_sources w on d.source_id=w.id where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		$i=0;
		while($row = mysqli_fetch_assoc($rs))
		{
		    $enclosures[$row['app_id']][$i]['app_id']=$row['app_id'];
		    $enclosures[$row['app_id']][$i]['water_source_name']=$row['water_source_name'];
		    $i++;
		}
		
		$tpl->assign('enclosures',$enclosures);
		
		
	
		
		$sql =$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=? order by ward_id ASC");
	
		$sql->bind_param("s",$_SESSION['ulbid']);
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
	    $tpl->assign('data',$data);
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
		$tpl->display('underground_drinage_report.tpl');
		
		
	}
	
		
	
	
	else
	{
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
?>