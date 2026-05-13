<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		$sql="SELECT * FROM `feedback_sub_options`";
		$query=$conn->prepare($sql);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $feedback_sub_options[$row['sub_option_id']]=$row['description'];
		}
		
		
		$sql="SELECT e.emp_id,e.emp_name FROM emp_mst e,grievances_transactions gt  where gt.emp_id=e.emp_id and gt.dept_id=? group by emp_id";
		$dept_id = htmlspecialchars(strip_tags($_REQUEST['depid']));
		$query=$conn->prepare($sql);
		$query->bind_param("i",$dept_id);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $ulb_list[$row['emp_id']]=$row['emp_name'];
		}
		$sql ="select COUNT(g.grievance_id) count ,emp_id as ulbid,sub_option_id from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id and g.grievance_id=gt.grievance_id and dept_id=? and gt.disposal_status !=? and is_reopened_yn=? group by emp_id,sub_option_id";
		
		$dept_id = htmlspecialchars(strip_tags($_REQUEST['depid']));
		$disposal_status = 5;
		$is_reopened_yn = 0;
		
		$query=$conn->prepare($sql);
		$query->bind_param("iii",$dept_id,$disposal_status,$is_reopened_yn);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][$row['sub_option_id']]['count']=$row['count'];
		    $tot[$row['sub_option_id']]['tot']+=$row['count'];
		}
		
		$sql ="select COUNT(g.grievance_id) count ,emp_id as ulbid,rating_no from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id and g.grievance_id=gt.grievance_id and (rating_no =? or rating_no =?) and dept_id=? and gt.disposal_status !=?  and is_reopened_yn=? group by emp_id,rating_no";
		
		$id4=4;
		$id5=5;
		$dept_id = htmlspecialchars(strip_tags($_REQUEST['depid']));
		$disposal_status=5;
		$is_reopened_yn=0;
		
		$query=$conn->prepare($sql);
		$query->bind_param("iiiii",$id4,$id5,$dept_id,$disposal_status,$is_reopened_yn);
		$query->execute();
		$rs=$query->get_result();
		
		
		while($row = $rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][$row['rating_no']]['count']=$row['count'];
		    $tot[$row['rating_no']]['tot']+=$row['count'];
		}
		
		$sql ="select COUNT(g.grievance_id) count ,emp_id as ulbid,rating_no from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id and g.grievance_id=gt.grievance_id and (rating_no =? or rating_no =? or rating_no =?) and sub_option_id=? and dept_id=? and gt.disposal_status !='5' and is_reopened_yn='0' group by emp_id,rating_no";
		
		
		$id1=1;
		$id2=2;
		$id3=3;
		$sub_option_id=0;
		$dept_id = htmlspecialchars(strip_tags($_REQUEST['depid']));
		$disposal_status=5;
		$is_reopened_yn=0;
		
		$query=$conn->prepare($sql);
		$query->bind_param("iiiiiii",$id1,$id2,$id2,$sub_option_id,$dept_id,$disposal_status,$is_reopened_yn);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][14]['count']+=$row['count'];
		    $tot[14]['tot']+=$row['count'];
		}
		
		
		$sql ="select ulbname from ulbmst where ulbid='".$_REQUEST['ulbid']."'";
		$ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		
		$row = $rs->fetch_assoc();
		$ulbname=$row['ulbname'];
		
		$sql ="select dept_desc from dept_mst where dept_id='".$_REQUEST['depid']."'";
		$dept_id = htmlspecialchars(strip_tags($_REQUEST['depid']));
		$query=$conn->prepare($sql);
		$query->bind_param("i",$dept_id);
		$query->execute();
		$rs=$query->get_result();
		
		
		
		$row = $rs->fetch_assoc();
		$deptname=$row['dept_desc'];
		
		
		
		$conn->close();
		$tpl->assign('deptidsel',$_REQUEST['depid']);
		$tpl->assign('ulbidsel',$_REQUEST['ulbid']);
		$tpl->assign('ulbname',$ulbname);
		$tpl->assign('deptname',$deptname);
	    $tpl->assign('tot',$tot);
		$tpl->assign('feedback_count',$feedback_count);			  		
        $tpl->assign('ulb_list',$ulb_list);		
        $tpl->assign('feedback_sub_options',$feedback_sub_options);		
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
	
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
		$tpl->display('feedback_emp_rep.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>