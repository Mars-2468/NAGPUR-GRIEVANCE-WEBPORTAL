<?php
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		$emp_id_sel=$_REQUEST['emp_id'];
		$cat3_id=$_REQUEST['cat_id'];
		$disposal_status = 5;
	
		
		$sql ="select g.grievance_id,person_name, mobile, cat3_id,r.rating_no,comment_desc,comp_desc,comp_subject,date_regd,disposed_date from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id  and gt.grievance_id=g.grievance_id  and gt.disposal_status NOT IN (?) and gt.emp_id=? and g.cat3_id=?";
		
		$query = $conn->prepare($sql);
		$query->bind_param(iii,$disposal_status,$emp_id_sel,$cat3_id);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $data[$row['grievance_id']]['person_name']=$row['person_name'];
		    $data[$row['grievance_id']]['mobile']=$row['mobile'];
		    $data[$row['grievance_id']]['rating_no']=$row['rating_no'];
		    $data[$row['grievance_id']]['comment_desc']=$row['comment_desc'];
		    $data[$row['grievance_id']]['comp_subject']=$row['comp_subject'];
		    $data[$row['grievance_id']]['comp_desc']=$row['comp_desc'];
		    $data[$row['grievance_id']]['date_regd']=$row['date_regd'];
		    $data[$row['grievance_id']]['disposed_date']=$row['disposed_date'];
		    
		    
		 }
		 
		 $query->close();
		 
	    $tpl->assign('emp_list',$emp_list);
		$tpl->assign('ratingList',array(0,1,2,3,4,5));
		$tpl->assign('empIds',$empIds);
        $tpl->assign('data',$data); 
        $tpl->assign('data1',$data1); 
        $tpl->assign('data2',$data2); 
        $tpl->assign('data3',$data3); 
        $tpl->assign('data4',$data4); 
        $tpl->assign('totals',$totals);
        $tpl->assign('tot2',$tot2);
        $tpl->assign('tot3',$tot3);
        $tpl->assign('tot4',$tot4);
        $tpl->assign('tot5',$tot5);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('rating_comp_det.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>