<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		require_once('prepare_connection.php');
		$conn=getconnection();
		
	
	
    	$sql="select * from app_downloads";
		$query=$conn->prepare($sql);
		$query->execute();
		$rs=$query->get_result();
		
		if(isset($_POST['search1']))
		{
		    
		    
		   
		$sql="SELECT ad.* FROM app_downloads ad,ulbmst u,Districtmst d,rdma_mst r WHERE ad.ulbid=u.ulbid 
		    and u.distid=d.distid and d.rdma=r.rdma_id 
			and u.ulbid =? 
		    and d.distid =? 
		    and r.rdma_id =? ORDER BY u.ulbname LIMIT 1";
		    $query=$conn->prepare($sql);
		
			$ulbid= mysqli_real_escape_string($conn,$_REQUEST['ulbid']);
			$distid=mysqli_real_escape_string($conn,$_REQUEST['distid']);
			$rdma_id=mysqli_real_escape_string($conn,$_REQUEST['regionid']);
			$query->bind_param("sss",$ulbid,$distid,$rdma_id);
		    $query->execute();
		    $rs=$query->get_result();
		    
		    
			
		}
		
		  while($row = $rs->fetch_assoc())
		    {
		    $data[$row['ulbid']]['no_of_downloads']=$row['no_of_downloads'];
		    $data[$row['ulbid']]['no_of_active_installations']=$row['no_of_active_installations'];
		    
		    $data[$row['ulbid']]['present_no_of_downloads']=$row['present_no_of_downloads'];
		    $data[$row['ulbid']]['present_no_of_active_installations']=$row['present_no_of_active_installations'];
		    
		    $data[$row['ulbid']]['percent_no_of_downloads']=$row['percent_no_of_downloads'];
		    $data[$row['ulbid']]['percent_no_of_active_installations']=$row['percent_no_of_active_installations'];
		    
		    $total['no_of_downloads']+=$row['no_of_downloads'];
		    $total['no_of_active_installations']+=$row['no_of_active_installations'];
		    
		    $total['present_no_of_downloads']+=$row['present_no_of_downloads'];
		    $total['present_no_of_active_installations']+=$row['present_no_of_active_installations'];
		   
		    }  
		    
		
		 
	
		
        $sql="select d.*,u.* from ulbmst u,Districtmst d,rdma_mst r where d.rdma=r.rdma_id and u.distid=d.distid 
	    and u.ulbid LIKE ?
	    and d.distid LIKE ?
	    and r.rdma_id LIKE ? order by u.ulbname";
	    $query=$conn->prepare($sql);
		 
			$ulbid= $_REQUEST['ulbid'].'%';
			$distid=$_REQUEST['distid'].'%';
			$rdma_id=$_REQUEST['regionid'].'%';
			$query->bind_param("sss",$ulbid,$distid,$rdma_id);
		    $query->execute();
		    $rs=$query->get_result();
		    while($row = mysqli_fetch_assoc($rs))
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		    $dist_list[$row['ulbid']]=$row['distname'];
		}
		
	
		$sql=$conn->prepare("SELECT * FROM  rdma_mst");
		$sql->execute();
		$rs=$sql->get_result();
		    while($row = $rs->fetch_assoc())
		    {
		    $region_list[$row['rdma_id']]=$row['rdma_desc'];
		    }
		
		
		
		

		
	/*	$sql=$conn->prepare("SELECT * FROM  Districtmst");
		$sql->execute();
		$rs=$sql->get_result();
		    while($row= $rs->fetch_assoc())
		{
		$dist_list[$row['distid']]=$row['distname'];
		}*/
	
		$sql->close();
		
		$tpl->assign('region_id_sel',$_REQUEST['regionid']);
		$tpl->assign('dist_id_sel',$_REQUEST['distid']);
		$tpl->assign('ulbid_id_sel',$_REQUEST['ulbid']);
		$tpl->assign('total',$total);
        $tpl->assign('region_list',$region_list);	
        $tpl->assign('dist_list',$dist_list);	
		$tpl->assign('data',$data);			
		$tpl->assign('ulb_list',$ulb_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('app_downloads.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>