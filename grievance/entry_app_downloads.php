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
		
		if(isset($_POST['save']))
		{
		    for($i=0; $i<=$_POST['cnt']; $i++)
		    {
		        $ulbid="ulbid".$i;
		        $ulb_downloads="ulb_downloads".$i;
		        $active_downloads="active_downloads".$i;
		        
		        $present_ulb_downloads="present_ulb_downloads".$i;
		        $present_ctive_downloads="present_active_downloads".$i;
		        $present_ulb_downloads = $_POST[$present_ulb_downloads];
		        $present_ctive_downloads = $_POST[$present_ctive_downloads];
		        
		        $percent_ulb_downloads="percent_ulb_downloads".$i;
		        $percent_active_downloads="percent_active_downloads".$i;
		        $percent_ulb_downloads = $_POST[$percent_ulb_downloads];
		        $percent_active_downloads = $_POST[$percent_active_downloads];
		        
		        $ulbid1 =strip_tags($_POST[$ulbid]);
		        $ulb_downloads1=strip_tags($_POST[$ulb_downloads]);
		        $active_downloads1=strip_tags($_POST[$active_downloads]);
		        
		        $sql ="insert into app_downloads(
		            ulbid,
		            no_of_downloads,
		            no_of_active_installations,
		            present_no_of_downloads,
		            present_no_of_active_installations,
		            percent_no_of_downloads,
		            percent_no_of_active_installations
		            )values(
		                '".$ulbid1."',
		                '".$ulb_downloads1."',
		                '".$active_downloads1."',
		                '".$present_ulb_downloads."',
		                '".$present_ctive_downloads."',
		                '".$percent_ulb_downloads."',
		                '".$percent_active_downloads."'
		                ) ON DUPLICATE KEY UPDATE 
		                no_of_downloads='".$ulb_downloads1."',
		                no_of_active_installations='".$active_downloads1."',
		                present_no_of_downloads='".$present_ulb_downloads."',
		                present_no_of_active_installations='".$present_ctive_downloads."',
		                percent_no_of_downloads='".$percent_ulb_downloads."',
		                percent_no_of_active_installations='".$percent_active_downloads."'";
		        mysqli_query($conn,$sql);
		        
		       
		    }
		
		  
				
			
if($rs)
		
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Saved Successfully ');
			

		}
		
		
			$sql = $conn->prepare("select * from app_downloads");
			   
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			
		while($row = $rs->fetch_assoc())
		{
		    $data[$row['ulbid']]['no_of_downloads']=$row['no_of_downloads'];
		    $data[$row['ulbid']]['no_of_active_installations']=$row['no_of_active_installations'];
		    
		    $data[$row['ulbid']]['present_no_of_downloads']=$row['present_no_of_downloads'];
		    $data[$row['ulbid']]['present_no_of_active_installations']=$row['present_no_of_active_installations'];
		    
		    $data[$row['ulbid']]['percent_no_of_downloads']=$row['percent_no_of_downloads'];
		    $data[$row['ulbid']]['percent_no_of_active_installations']=$row['percent_no_of_active_installations'];
		}
		
		    $ulbid_500= 500;
			$sql = $conn->prepare("select * from ulbmst where ulbid!=? order by ulbname");
			     $sql->bind_param("s",$ulbid_500);
		    	
				$sql->execute();
			   $rs=$sql->get_result();
			
	
		while($row = $rs->fetch_assoc())
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		}
		
		
          $sql->close();
		$tpl->assign('data',$data);			
		$tpl->assign('ulb_list',$ulb_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('entry_app_downloads.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
	}
?>