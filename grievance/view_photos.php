<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
	
		
		if($_SESSION['uid']=='CDMA' || $_SESSION['uid']=='admin')
				{
	
				
				 $sql="select cm.* from ulbmst u, Districtmst d, rdma_mst r,csc_mst cm  where cm.ulbid=u.ulbid and u.distid=d.distid and d.rdma=r.rdma_id and u.ulbid like ? and d.distid like ? and r.rdma_id like ?";
				 
				 $ulbid = "%".$_POST['ulbid']."%";
				 $distid = "%".$_POST['distid']."%";
				 $rdma = "%".$_POST['rdma_id']."%";
				 
				 
				 
				 $query=$conn->prepare($sql);
				 $query->bind_param("sss",htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($distid)),htmlspecialchars(strip_tags($rdma)));
				 $query->execute();
				 $rs=$query->get_result();
				
				$field_info = $rs->fetch_fields();
				while($row = $rs->fetch_array())
				{
					
					
					foreach($field_info as $fi => $f) 
						$data[$row['ulbid']][$f->name]=$row[$f->name];
						
				}
			
				
				}
				
				
			 $sql ="select * from ulbmst";
			 $query=$conn->prepare($sql);
			 $query->execute();
			 $rs=$query->get_result();
				
				while($row = $rs->fetch_array())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
		
	
        $conn->close();
		$tpl->assign('status_list',array('1'=>'Started','2'=>'Not Started','3'=>'Under Progress'));
	    $tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('data',$data);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('csc_rep.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>
                            
                            
                            
                            
                            
                            