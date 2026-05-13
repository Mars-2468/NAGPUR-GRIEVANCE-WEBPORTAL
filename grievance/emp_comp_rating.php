<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		$emp_id_sel=htmlspecialchars(strip_tags($_REQUEST['emp_id']));
	
		
		$sql ="select COUNT(r.grievance_id) as count,rating_no,cat3_id from rating_mst r, grievances_transactions gt,grievances g where r.grievance_id=gt.grievance_id  and gt.grievance_id=g.grievance_id  and gt.disposal_status NOT IN ('5') and gt.emp_id='".$emp_id_sel."' group by cat3_id,rating_no";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $data[$row['cat3_id']][$row['rating_no']]['count']=$row['count'];
		    $empIds[$row['cat3_id']]=$row['cat3_id'];
		    $totals2[$row['cat3_id']]+=$row['count'];
		    $totals[$row['rating_no']]+=$row['count'];
		    $totals['total']+=$row['count'];
		    
		 }
		 
		 
		 
		 
		 
		 //$ratingList=array('0'=>'0','2'=>'1','4'=>'2','6'=>'3','8'=>'4','10'=>'5');
		 
		 $sql ="select * from rating_status_mst";
		 $rs = mysqli_query($conn,$sql);
		 while($row = mysqli_fetch_assoc($rs))
		 {
		     $ratingList[$row['marks']]=$row['ratingId'];
		     $ratingMarks[$row['ratingId']]=$row['marks'];
		 }
		 $tpl->assign('ratingMarks',$ratingMarks);
		 
		 foreach($empIds as $emp_id)
		 {
    		 foreach($ratingList as $marks=>$val)
    		 {
    		     $a=$data[$emp_id][$val]['count'] * $marks;
    		     $tot_marks[$emp_id]['marks']+=$a;
    		     $tot_marks['tot']+=$a;
    		     
    		     
    		     
    		 }
		 }
		
		arsort($tot_marks);
		
		//print_r($tot_marks);
	
		 
		 $tpl->assign('emp_id_sel',$emp_id_sel);
		 $tpl->assign('totals2',$totals2);
		 $tpl->assign('tot_marks',$tot_marks);
		 
	
		
	
	
	 

	
	

		
		$sql ="select cs_id,cs_desc from cs_mst";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $emp_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		mysqli_close($conn);
		
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
		$tpl->display('emp_comp_rating.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>