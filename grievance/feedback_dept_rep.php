<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
	    $sql = $conn->prepare("SELECT * FROM `feedback_sub_options`");
    	$sql->execute();
		$rs=$sql->get_result();
			
		while($row = $rs->fetch_assoc())
		{
		    $feedback_sub_options[$row['sub_option_id']]=$row['description'];
		}
		
		$ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql = $conn->prepare("SELECT * FROM `dept_mst` where ulbid=?");
		$sql->bind_param("s",$ulbid);
    	$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $ulb_list[$row['dept_id']]=$row['dept_desc'];
		}
	    $disposal_status=5;$is_reopened_yn=0;
	    $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql = $conn->prepare("select COUNT(g.grievance_id) count ,dept_id as ulbid,sub_option_id from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id and g.grievance_id=gt.grievance_id and ulbid=? and gt.disposal_status !=? and is_reopened_yn=? group by dept_id,sub_option_id");
		$sql->bind_param("sii",$ulbid,$disposal_status,$is_reopened_yn);
    	$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][$row['sub_option_id']]['count']=$row['count'];
		    $tot[$row['sub_option_id']]['tot']+=$row['count'];
		}
		$rating_no1= 4;$rating_no2= 5;
		$ulbid = $_REQUEST['ulbid'];
	    $sql = $conn->prepare("select COUNT(g.grievance_id) count ,dept_id as ulbid,rating_no from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id and g.grievance_id=gt.grievance_id and (rating_no=? or rating_no=?) and ulbid=? and gt.disposal_status !=?  and is_reopened_yn=? group by dept_id,rating_no");
		$sql->bind_param("iisii",$rating_no1,$rating_no2,$ulbid,$disposal_status,$is_reopened_yn);
    	$sql->execute();
		$rs=$sql->get_result();	
		
		while($row = $rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][$row['rating_no']]['count']=$row['count'];
		    $tot[$row['rating_no']]['tot']+=$row['count'];
		}
		
		$rating_no3=1;$rating_no4=2;$rating_no5=3;$sub_option_id=0;
		$ulbid = $_REQUEST['ulbid'];
		$sql=$conn->prepare("select COUNT(g.grievance_id) count ,dept_id as ulbid,rating_no from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id and g.grievance_id=gt.grievance_id and (rating_no=? or rating_no=? or rating_no=?) and sub_option_id=? and ulbid=? and gt.disposal_status !=? and is_reopened_yn=? group by dept_id,rating_no");
		$sql->bind_param("iiiisii",$rating_no3,$rating_no4,$rating_no5,$sub_option_id,$ulbid,$disposal_status,$is_reopened_yn);
		
		$sql->execute();
		$rs=$sql->get_result();	
		while($row = $rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][14]['count']+=$row['count'];
		    $tot[14]['tot']+=$row['count'];
		}
		$ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql=$conn->prepare("select ulbname from ulbmst where ulbid=?");
		$sql->bind_param("s",$ulbid);
		
		$sql->execute();
		$rs=$sql->get_result();	
	
		$row = $rs->fetch_assoc();
		$ulbname=$row['ulbname'];
		
		
		
		$sql->close();
		$tpl->assign('ulbidsel',$_REQUEST['ulbid']);
		$tpl->assign('ulbname',$ulbname);
	    $tpl->assign('tot',$tot);
		$tpl->assign('feedback_count',$feedback_count);			  		
        $tpl->assign('ulb_list',$ulb_list);		
        $tpl->assign('feedback_sub_options',$feedback_sub_options);		
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
	//	$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('feedback_dept_rep.tpl');
	}
	else
	{
	
		echo "<script>window.location ='index.php';</script>";
	}
?>