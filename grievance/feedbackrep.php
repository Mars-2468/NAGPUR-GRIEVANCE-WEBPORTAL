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
		
		require_once('prepare_connection.php');
		
		
		
		$sql="SELECT * FROM `feedback_sub_options`";
		$query=$conn->prepare($sql);
		if(!$query->execute())
            {
                echo "Query not executed 1";
            }
            $rs=$query->get_result();
		
    		while($row = $rs->fetch_assoc())
    		{
    		    $feedback_sub_options[$row['sub_option_id']]=$row['description'];
    		}
		
		//$query->close();
		$sql="SELECT * FROM `ulbmst`";
		$query=$conn->prepare($sql);
			if(!$query->execute())
            {
                echo "Query not executed 2";
            }
		$rs = $query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		}
		
		
		$sql ="select COUNT(g.grievance_id) count ,ulbid,sub_option_id from rating_mst r, grievances g where r.grievance_id=g.grievance_id group by ulbid,sub_option_id";
		$query=$conn->prepare($sql);
			if(!$query->execute())
            {
                echo "Query not executed 2";
            }
		$rs = $query->get_result();
		
		
		while($row = $rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][$row['sub_option_id']]['count']=$row['count'];
		    $tot[$row['sub_option_id']]['tot']+=$row['count'];
		}
		
		
		
		$sql ="select COUNT(g.grievance_id) count ,ulbid,rating_no from rating_mst r, grievances g where r.grievance_id=g.grievance_id and (rating_no = ? or rating_no= ?) group by ulbid,rating_no";
			
			$id1=4;
			$id2=5;
			$query=$conn->prepare($sql);
			$query->bind_param("ii",$id1,$id2);
			if(!$query->execute())
            {
                echo "Query not executed 3";
            }
			$rs = $query->get_result();
			
		
		while($row =$rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][$row['rating_no']]['count']=$row['count'];
		    $tot[$row['rating_no']]['tot']+=$row['count'];
		}
		
		
		$sql ="select COUNT(g.grievance_id) count ,ulbid,rating_no from rating_mst r, grievances g where r.grievance_id=g.grievance_id and (rating_no = ? or rating_no = ? or rating_no = ?) and sub_option_id=? group by ulbid,rating_no";
			$id1=1;
			$id2=2;
			$id3=3;
			$sub_option_id=0;
	  	  $query=$conn->prepare($sql);
	  	  $query->bind_param("iiii",$id1,$id2,$id3,$sub_option_id);
			if(!$query->execute())
            {
                echo "Query not executed 4";
            }
			$rs = $query->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $feedback_count[$row['ulbid']][14]['count']+=$row['count'];
		    $tot[14]['tot']+=$row['count'];
		}
		
	
		
		
		
		$query->close();
	    $tpl->assign('tot',$tot);
		$tpl->assign('feedback_count',$feedback_count);			  		
        $tpl->assign('ulb_list',$ulb_list);		
        $tpl->assign('feedback_sub_options',$feedback_sub_options);		
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
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
		//$tpl->display('add-edition.tpl');
		$tpl->display('feedbackrep2.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>