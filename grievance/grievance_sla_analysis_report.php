<?php
	require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		if(isset($_POST['save']))
		{
		    for($i=0; $i<=$_POST['cnt']; $i++)
		    {
		        $cs_id="cs_id".$i;
		        $cutt_of_time="cutt_of_time".$i;
		        if($_POST[$cs_id]!='')
		        {
		        $sql ="insert into comp_cutofdays_map(cs_id,cutt_off_time)values(?,?) ON DUPLICATE KEY UPDATE cutt_off_time=?";
		         
		        $cs_id=strip_tags($_POST[$cs_id]);
		        $cutt_off_time=strip_tags($_POST[$cutt_of_time]);
		        
		        $query=$conn->prepare($sql);
		        
		        $query->bind_param("iss",$cs_id,$cutt_off_time,$cutt_off_time);
		
    			if(!$query->execute())
    	        {
    	            echo "Query not executed 0";
    	        }
		        
		        }
		    }
		
		  
				
			
if($query->execute())
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Saved Successfully ');
				}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
				}

		}
		
	$sql ="SELECT * FROM `comp_cutofdays_map`";
	    $query=$conn->prepare($sql);
	
		if(!$query->execute())
        {
            echo "Query not executed 1";
        }
        $rs=$query->get_result();
	while($row = $rs->fetch_assoc())
	{
	    $data[$row['cs_id']]['cutt_off_time']=$row['cutt_off_time'];
	}
		
		
		$sql ="select cat_id, description from category_mst where ulbid= ? and cs_type_id= ?";
		
		$ulbid='250';
		$cs_type_id='1';
		
		$query=$conn->prepare($sql);
		$query->bind_param("si",$ulbid,$cs_type_id);
		
    			if(!$query->execute())
    	        {
    	            echo "Query not executed 2";
    	        }
		$rs3=$query->get_result(); 
		
		while($row = $rs3->fetch_assoc())
		{
		    $cat_list[$row['cat_id']]=$row['description'];
		}
		
		
		
		
		$sql ="select * from subcategory_mst";
		
		
		
		$query=$conn->prepare($sql);
		
		
    			if(!$query->execute())
    	        {
    	            echo "Query not executed 2";
    	        }
		$rs3=$query->get_result(); 
		
		while($row = $rs3->fetch_assoc())
		{
		    $sub_cat_list[$row['cat_id']][$row['sub_cat_id']]=$row['description'];
		}
		
		
		
		
		$sql ="select * from cs_mst";
		
		$query=$conn->prepare($sql);
	
		if(!$query->execute())
        {
            echo "Query not executed 3";
        }
        $rs4=$query->get_result();
		
		
		while($row = $rs4->fetch_assoc())
		{
		    $cs_list[$row['cs_id']]['desc']=$row['cs_desc'];
			$cs_list[$row['cs_id']]['cat_id']=$row['cat_id'];
			$cs_list[$row['cs_id']]['sub_cat_id']=$row['sub_cat_id'];
			
		}
		
		$sql ="select * from level_disposabledays_map";
		
		$query=$conn->prepare($sql);
	
		if(!$query->execute())
        {
            echo "Query not executed 3";
        }
        $rs4=$query->get_result();
		
		
		while($row = $rs4->fetch_assoc())
		{
		    $disposable_days[$row['cs_id']]['L1']=$row['L1'];
			$disposable_days[$row['cs_id']]['L2']=$row['L2'];
			$disposable_days[$row['cs_id']]['L3']=$row['L3'];
			
			
		}
		
		
		
		
	      
	      $row = $rs4->fetch_assoc();
	      
	      $users_count=$row['user_count'];
		  
		  
		  
		  
		  
	     $tpl->assign('users_count',$users_count);
		$conn->close();
        $tpl->assign('data',$data);   	
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('sub_cat_list',$sub_cat_list);		
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('disposable_days',$disposable_days);
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('grievance_sla_anlysis_report.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>