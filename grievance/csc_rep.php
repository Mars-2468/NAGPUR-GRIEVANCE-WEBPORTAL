<?php
require "config.php";
//include('responsible_sms.php');
?><?php
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();
	 
	
	
	//require_once('sms_conf.php');
	//require_once('send_sms.php');	
	
	//echo "hi";
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		/*require_once('connection.php');
		$conn=getconnection();*/
		require_once('prepare_connection.php');
		
		
		
		
		///????????????????????admin(CDMA)
		
		if($_SESSION['uid']=='CDMA' || $_SESSION['uid']=='admin')
				{
	
				
				// $sql="select cm.* from ulbmst u, Districtmst d, rdma_mst r,csc_mst cm  where cm.ulbid=u.ulbid and u.distid=d.distid and d.rdma=r.rdma_id and u.ulbid like '%".$_POST['ulbid']."%' and d.distid like '%".$_POST['distid']."%' and r.rdma_id like '%".$_POST['rdma_id']."%'"; 
				 $sql="select cm.* from ulbmst u, Districtmst d, rdma_mst r,csc_mst cm  where cm.ulbid=u.ulbid and u.distid=d.distid and d.rdma=r.rdma_id and u.ulbid like ? and d.distid like ? and r.rdma_id like ?";
				 
				 
				 
				 $ulbid = "%".$_POST['ulbid']."%";
				 $distid = "%".$_POST['distid']."%";
				 $rdmaid = "%".$_POST['rdma_id']."%";
				 
				 $query=$conn->prepare($sql);
				 $query->bind_param("sss",$ulbid,$distid,$rdmaid);
				 
    		     if(!$query->execute())
                    {
                        echo "Query not executed 1";
                    }
                 $rs=$query->get_result();
    				 
				 
				 
				 
			
				$field_info = $rs->fetch_fields();
				while($row = $rs->fetch_assoc())
				{
					
					
					foreach($field_info as $fi => $f) 
						$data[$row['ulbid']][$f->name]=$row[$f->name];
						
				}
			
				
				}
				
				
			 $sql ="select * from ulbmst";
			 $query=$conn->prepare($sql);
			  if(!$query->execute())
                    {
                        echo "Query not executed 2";
                    }
                 $rs=$query->get_result();
			 
				
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				
				
		$sql="SELECT * FROM  rdma_mst";
		$query=$conn->prepare($sql);
			  if(!$query->execute())
                    {
                        echo "Query not executed 2";
                    }
                 $rs=$query->get_result();
		
	
		while($row= $rs->fetch_assoc())
		{
		$region_list[$row['rdma_id']]=$row['rdma_desc'];
		}
		
		$sql="SELECT * FROM  Districtmst";
		
		$query=$conn->prepare($sql);
			  if(!$query->execute())
                    {
                        echo "Query not executed 2";
                    }
                 $rs=$query->get_result();
		while($row= $rs->fetch_assoc())
		{
		$dist_list[$row['distid']]=$row['distname'];
		}
		
		
		$sql ="select * from ulbmst";
		$query=$conn->prepare($sql);
		
		if($_POST['regionid'])
		{
		$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.distid=d.distid and d.rdma=?";
		
		$rdma = strip_tags($_POST['regionid']);
		$query=$conn->prepare($sql);
		$query->bind_param("s",$rdma);
		
		
		}
		if($_POST['regionid'] && $_POST['distid'])
		{
		$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.distid=? and d.rdma=?";
		$distid = $_POST['distid'];
		$rdmaid = strip_tags($_POST['regionid']);
		$query=$conn->prepare($sql);
		$query->bind_param("ss",$distid,$rdma);
		}
		if($_POST['regionid'] && $_POST['distid'] && $_POST['ulbid'])
		{
		$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.ulbid=? and u.distid=? and d.rdma=?";
		$ulbid = strip_tags($_POST['ulbid']);
		$distid = strip_tags($_POST['distid']);
		$rdmaid = strip_tags($_POST['regionid']);
		$query=$conn->prepare($sql);
		$query->bind_param("sss",$ulbid,$distid,$rdmaid);
		
		}
		
		if(!$query->execute())
                    {
                        echo "Query not executed 2";
                    }
                 $rs=$query->get_result();
		
		
				while($row = $rs->fetch_assoc())
				{
				
			         $ulb_list1[$row['ulbid']]=$row['ulbname'];
				}
				
				if(isset($_POST['search1']))
				{
				
					$sql ="select * from ulbmst";
					$query=$conn->prepare($sql);
					
					
					if($_POST['regionid'])
					{
					 $sql ="select d.*,u.* from Districtmst d,ulbmst u where u.distid=d.distid and d.rdma=?";
					 $query=$conn->prepare($sql);
					 $region_id = strip_tags($_POST['regionid']);
					 $query->bind_param("s",$rdma);
					}
					if($_POST['regionid'] && $_POST['distid'])
					{
					 $sql ="select d.*,u.* from Districtmst d,ulbmst u where u.distid=? and d.rdma=?";
					 $query=$conn->prepare($sql);
					 $distid = strip_tags($_POST['distid']);
					 $region_id = strip_tags($_POST['regionid']);
					 $query->bind_param("ss",$distid,$region_id);
					}
					if($_POST['regionid'] && $_POST['distid'] && $_POST['ulbid'])
					{
					 $sql ="select d.*,u.* from Districtmst d,ulbmst u where  u.distid='".strip_tags($_POST['distid'])."' and d.rdma='".strip_tags($_POST['regionid'])."'";
					 $query=$conn->prepare($sql);
					 $distid = strip_tags($_POST['distid']);
					 $region_id = strip_tags($_POST['regionid']);
					 $query->bind_param("sss",$distid,$region_id);
					}
				
					
            		    if(!$query->execute())
                        {
                            echo "Query not executed 1";
                        }
                       $rs=$query->get_result();
                       
							while($row = $rs->fetch_assoc())
							{
							
						         $ulb_list2[$row['ulbid']]=$row['ulbname'];
							}
					$tpl->assign('ulb_list2',$ulb_list2);
					
					$sql="SELECT * FROM  Districtmst where rdma='".$_POST['regionid']."'";
					$query=$conn->prepare($sql);
					
					if(!$query->execute())
                        {
                            echo "Query not executed 1";
                        }
                       $rs=$query->get_result();
					while($row= $rs->fetch_assoc())
					{
					$dist_list2[$row['distid']]=$row['distname'];
					}
					$tpl->assign('dist_list2',$dist_list2);
				
				}
				
				
				$query->close();
				
				
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('ulb_list1',$ulb_list1);
		$tpl->assign('preg',$_POST['regionid']);
		$tpl->assign('pulb',$_POST['ulbid']);
		$tpl->assign('pdist',$_POST['distid']);
		$tpl->assign('region_list',$region_list);
		$tpl->assign('dist_list',$dist_list);	
				
				
				
	
		
	
	
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
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>
                            
                            
                            
                            
                            
                            