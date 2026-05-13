<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']) )
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
	
		
		 $sql ="select COUNT(r.grievance_id) as count,rating_no,g.ulbid as emp_id from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id  and gt.grievance_id=g.grievance_id  and gt.disposal_status !=? group by g.ulbid,rating_no";
		$query=$conn->prepare($sql);
		$disposal_status=5;
	$query->bind_param("i",	htmlspecialchars(strip_tags($disposal_status)));
	
		$query->execute();
	    $rs=$query->get_result();
			  
		
		while($row = $rs->fetch_assoc())
		{
		    $data[$row['emp_id']][$row['rating_no']]['count']=$row['count'];
		    $empIds[$row['emp_id']]=$row['emp_id'];
		    $totals[$row['emp_id']]+=$row['count'];
		    $totals[$row['rating_no']]+=$row['count'];
		    $totals['total']+=$row['count'];
		    
		 }
		 
		$query->close();
		 
		 $sql ="select * from rating_status_mst";
		 $query=$conn->prepare($sql);
					$query->execute();
	    $rs=$query->get_result();
		 
		 
		
		 while($row = $rs->fetch_assoc())
		 {
		     $ratingList[$row['marks']]=$row['ratingId'];
		     $ratingMarks[$row['ratingId']]=$row['marks'];
		 }
		 	$query->close();
		 $tpl->assign('ratingMarks',$ratingMarks);
		 
		 foreach($empIds as $emp_id)
		 {
    		 foreach($ratingList as $marks=>$val)
    		 {
    		     $a=$data[$emp_id][$val]['count'] * $marks;
    		     $tot_marks[$emp_id]['marks']+=$a;
    		     $totals['total_marks']+=$a;
    		 }
		 }
		
		arsort($tot_marks);
		
		$tpl->assign('tot_marks',$tot_marks);
		 $tpl->assign('tot_marks',$tot_marks);
		 
		$sql ="select ulbid as emp_id,ulbname as emp_name from ulbmst";
	$query=$conn->prepare($sql);
					$query->execute();
	    $rs=$query->get_result();
		 
		 
		
		 while($row = $rs->fetch_assoc())
		{
		    $emp_list[$row['emp_id']]=$row['emp_name'];
		}
		
			$query->close();
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('ratingList',$ratingList);
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
		$tpl->display('ulbwise_ratings.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
		
	}
?>