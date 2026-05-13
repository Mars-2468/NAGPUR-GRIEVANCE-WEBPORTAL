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
		
	$sql ="SELECT * FROM `standard_services`";
	
	$query=$conn->prepare($sql);
	
		if(!$query->execute())
        {
            echo "Query not executed 1";
        }
        $rs=$query->get_result();
        
	while($row = $rs->fetch_assoc())
	{
	    $data[$row['section_id']][$row['cs_id']]['cutt_off_time']=$row['cutt_off_time'];
	    $cs_list[$row['cs_id']]=$row['cs_desc'];
	}
	
		$sql ="select dept_id, dept_desc from standard_departments";
		
		$query=$conn->prepare($sql);
	
		if(!$query->execute())
        {
            echo "Query not executed 2";
        }
        $rs1=$query->get_result();
        
		
		while($row = $rs1->fetch_assoc())
		{
		    $cat_list[$row['dept_id']]=$row['dept_desc'];
		}
		$cat_list[0]="Others";
		
	
		$conn->close();
        $tpl->assign('data',$data);   	
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('service_disposable_days.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
		
	}
?>