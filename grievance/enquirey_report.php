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
		
		$sql ="select e.id as uniqueid, e.*,d.*,u.*,e2.*,d2.*,v.*,d.distname as distname1,d2.distname as distname2,d4.distname as distname4 from enquiries e left join Districtmst d on e.distidvillage=d.distid left join  Districtmst d2 on e.distidothers=d2.distid left join ulbmst u on e.ulbid=u.ulbid left join Districtmst d4 on u.distid=d4.distid left join village_mst v on e.villageid=v.villageid left join enquiryList e2 on e.regardingId=e2.id where user_id='".$_SESSION['uid']."'";
	    $rs = mysqli_query($conn,$sql);
	    
	    while($row = mysqli_fetch_assoc($rs))
	    {
	        $data[$row['uniqueid']]['regardingId']=$row['regardingId'];
	        $data[$row['uniqueid']]['name']=$row['name'];
	        $data[$row['uniqueid']]['mobile']=$row['mobile'];
	        $data[$row['uniqueid']]['fromid']=$row['fromid'];
	        $data[$row['uniqueid']]['ulbname']=$row['ulbname'];
	        $data[$row['uniqueid']]['distname']=$row['distname'];
	        $data[$row['uniqueid']]['village_desc']=$row['village_desc'];
	        $data[$row['uniqueid']]['town']=$row['town'];
	        $data[$row['uniqueid']]['remarks']=$row['remarks'];
	        $data[$row['uniqueid']]['listdesc']=$row['listdesc'];
	        $data[$row['uniqueid']]['datetime']=$row['datetime'];
	        $data[$row['uniqueid']]['village']=$row['village'];
	        
	        if($row['fromid']==1)
	        {
	            $data[$row['uniqueid']]['village_desc']="N/A";
	            $data[$row['uniqueid']]['mandalname']="N/A";
	            $data[$row['uniqueid']]['distname']=$row['distname4'];
	        }
	        else if($row['fromid']==2)
	        {
	            $data[$row['uniqueid']]['village_desc']=$row['village_desc'];
	            $data[$row['uniqueid']]['mandalname']="N/A";
	            $data[$row['uniqueid']]['distname']=$row['distname1'];
	        }
	        else if($row['fromid']==3)
	        {
	            $data[$row['uniqueid']]['village_desc']=$row['village'];
	            $data[$row['uniqueid']]['mandalname']=$row['town'];;
	            $data[$row['uniqueid']]['distname']=$row['distname2'];
	        }
	       
	        
	    }
	    
	   
	   
	    $tpl->assign('data',$data);
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
		$tpl->display('enquirey_report.tpl');
		
		
	}
	
		
	
	
	else
	{
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
?>