<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
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
		include('prepare_connection.php');
		if(isset($_POST['save']))
		{
		    for($i=0; $i<=$_POST['cnt']; $i++)
		    {
		        $cs_id="cs_id".$i;
		        $cutt_of_time="cutt_of_time".$i;
		        if($_POST[$cs_id]!='')
		        {
		         
		         
		         $sql ="insert into comp_cutofdays_map(cs_id,cutt_off_time)values(?,?)
		         ON DUPLICATE KEY UPDATE cutt_off_time=?";
		         $cs_id=htmlspecialchars(strip_tags($_POST[$cs_id]));
		         $cutt_off_time=htmlspecialchars(strip_tags($_POST[$cutt_of_time]));
		         
		         $query=$conn->prepare($sql);
		        
		        $query->bind_param("iss",$cs_id,$cutt_off_time,$cutt_off_time);
		
    			
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
		

	
	$sql=$conn->prepare("SELECT cs_id,dept_id,cutt_of_time as cutt_off_time FROM `category3_mst` where ulbid=?");
	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s",$ulbid);
	$sql->execute();
	$rs=$sql->get_result();
	while($row = $rs->fetch_assoc())
	{
	     $data[$row['cs_id']]['cutt_off_time']=$row['cutt_off_time'];
	}
	
		$sql=$conn->prepare("select dept_id, dept_desc from dept_mst where ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
    	$sql->execute();
    	$rs=$sql->get_result();
    	while($row = $rs->fetch_assoc())
    	{
    	      $cat_list[$row['dept_id']]=$row['dept_desc'];
    	}
    
		
	
		$sql=$conn->prepare("select * from category3_mst where ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
    	$sql->execute();
    	$rs=$sql->get_result();
    	while($row = $rs->fetch_assoc())
    	{
    	    $cs_list[$row['dept_id']][$row['cs_id']]['desc']=$row['comp_desc'];
    	}

		  /*$sql ="select COUNT(id) as user_count from login_details where type=? and ulbid like ?";
		  $type='1';
		  $ulbid="%".$_SESSION['ulbid']."%";
		  
		  $query=$conn->prepare($sql);
		  $query->bind_param("is",$type,$ulbid);
		  $query->execute();
		  $rs4=$query->get_result(); 
		  $row = $rs4->fetch_assoc();
	      $users_count=$row['user_count'];*/
	     $tpl->assign('users_count',$users_count);
	
        $tpl->assign('data',$data);   	
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('services_sla.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
		
		
	}
?>