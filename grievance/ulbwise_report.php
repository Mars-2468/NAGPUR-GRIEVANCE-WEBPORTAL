<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();

	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
	
		
		if($_SESSION['uid']=='CDMA' || 'admin')
				{
	
		
		$sql="select count(g.grievance_id) as servicecount,g.ulbid,u.ulbid from grievances g,ulbmst u where 
		g.ulbid=u.ulbid and app_type_id=? group by g.ulbid order by ulbname";
		$app_type_id=2;
		$query=$conn->prepare($sql);
		$query->bind_param("i",htmlspecialchars(strip_tags($app_type_id)));
	    
				
			if(isset($_POST['search1']))
			{	
			$sql="select count(g.grievance_id) as servicecount,g.ulbid,u.*,d.*,r.* from grievances g,ulbmst u,Districtmst d,
			rdma_mst r where g.ulbid=u.ulbid and app_type_id=? and u.distid=d.distid and d.rdma=r.rdma_id";
			$query=$conn->prepare($sql);
			$app_type_id=2;
			$query->bind_param("i",htmlspecialchars(strip_tags($app_type_id)));
				
				if($_POST['regionid']!='')
					{
				
					 
					 	 $sql.="  and r.rdma_id=? ";
					 	 $sql.=" group by g.ulbid order by ulbname";
					 	$query=$conn->prepare($sql);
            			$app_type_id=2;
            			$rdma_id=$_POST['regionid'];
            			$query->bind_param("is",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($rdma_id)));
					 	 
					 	 
					}
				if($_POST['distid'])
					{
					 
					    $sql.=" and d.distid=? ";
					 
					    $query=$conn->prepare($sql);
            			$app_type_id=2;
            			$rdma_id=$_POST['regionid'];
            			$distid=$_POST['distid'];
            			$query->bind_param("iss",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($rdma_id)),htmlspecialchars(strip_tags($distid)));
					}
				if($_POST['ulbid'])
				        {
			
				 		$sql.="  and u.ulbid=? ";
				 	
					    $query=$conn->prepare($sql);
            			$app_type_id=2;
            			$rdma_id=$_POST['regionid'];
            			$distid=$_POST['distid'];
            			$ulbid=$_POST['ulbid'];
            			$query->bind_param("isss",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($rdma_id)),htmlspecialchars(strip_tags($distid)),htmlspecialchars(strip_tags($ulbid)));
				 	
					}
					$sql.=" group by g.ulbid order by ulbname";
			    		
		
			}
		
			$query->execute();		
			$rs=$query->get_result();
			while($row =$rs->fetch_assoc())
			{
			    $datalist[$row['ulbid']]['servicecount']=$row['servicecount'];
        		$tot_rec_s+=$row['servicecount'];
			}
			  $tpl->assign('tot_rec_s',$tot_rec_s);
        		
		     
		
		$sql="select count(g.grievance_id) as servicecount,g.ulbid,u.ulbid from grievances g,ulbmst u where g.ulbid=u.ulbid and 
		app_type_id=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) group by g.ulbid order by ulbname";
		$app_type_id=2;	
		$grievance_status_id1=3;
		$grievance_status_id2=8;
		$grievance_status_id3=10;
		$grievance_status_id4=4;
		$query=$conn->prepare($sql);
		$query->bind_param("iiiii",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),htmlspecialchars(strip_tags($grievance_status_id4)));
		
				if(isset($_POST['search1']))
				{
					
					
					$sql="select count(g.grievance_id) as servicecount,g.ulbid,u.*,d.*,r.* from grievances g,ulbmst u,
					Districtmst d,rdma_mst r where g.ulbid=u.ulbid and app_type_id=? and u.distid=d.distid and d.rdma=r.rdma_id and 
					(grievance_status_id=? or grievance_status_id=? or grievance_status_id=? or grievance_status_id=?)";
					$app_type_id=2;	
            		$grievance_status_id1=3;
            		$grievance_status_id2=9;
            		$grievance_status_id3=10;
            		$grievance_status_id4=4;
					$query=$conn->prepare($sql);
		            $query->bind_param("iiiii",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),
		            htmlspecialchars(strip_tags($grievance_status_id4)));
					
					
					
					if($_POST['regionid']!='')
						{
					
						 
						  $sql.="  and r.rdma_id=?";
						  $sql.=" group by g.ulbid order by ulbname";
						  $query=$conn->prepare($sql);
						  $rdma_id=$_POST['regionid'];
						  $app_type_id=2;	
                    		$grievance_status_id1=3;
                    		$grievance_status_id2=9;
                    		$grievance_status_id3=10;
                    		$grievance_status_id4=4;
		                  $query->bind_param("iiiiis",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),
		                  htmlspecialchars(strip_tags($grievance_status_id4)),htmlspecialchars(strip_tags($rdma_id)));
						  
						 
						  
						}
					if($_POST['distid'])
						{
					
						  $sql.=" and d.distid=? ";
						  $query=$conn->prepare($sql);
						  $rdma_id=$_POST['regionid'];
						  $distid=$_POST['distid'];
		                  $query->bind_param("iiiiiss",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),
		                  htmlspecialchars(strip_tags($grievance_status_id4)),htmlspecialchars(strip_tags($rdma_id)),htmlspecialchars(strip_tags($distid)));
						  
					  
						}
					if($_POST['ulbid'])
					        {
					 
					 	  $sql.="  and u.ulbid=? ";
					 	  $query=$conn->prepare($sql);
						  $rdma_id=$_POST['regionid'];
						  $distid=$_POST['distid'];
						  $ulbid=$_POST['ulbid'];
		                  $query->bind_param("iiiiisss",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),
		                  htmlspecialchars(strip_tags($grievance_status_id4)),htmlspecialchars(strip_tags($rdma_id)),htmlspecialchars(strip_tags($distid)),htmlspecialchars(strip_tags($ulbid)));
					 	
					 	
						}
						$sql.=" group by g.ulbid order by ulbname";
						
						
				
				}
		
		
		    $query->execute();
			$rs =$query->get_result();
			while($row = $rs->fetch_assoc())
			{
			   $res_services[$row['ulbid']]['servicecount']=$row['servicecount'];
				$tot_red_s+=$row['servicecount'];
			}
			 $tpl->assign('tot_red_s',$tot_red_s);
		
		
		$sql="select count(g.grievance_id) as servicecount,g.ulbid,u.ulbid from grievances g,ulbmst u where g.ulbid=u.ulbid and 
		app_type_id=? group by g.ulbid order by ulbname";
		
		$app_type_id=1;
		$query=$conn->prepare($sql);
		$query->bind_param("i",htmlspecialchars(strip_tags($app_type_id)));
		
		
			if(isset($_POST['search1']))
				{
				
				 $sql="select count(g.grievance_id) as servicecount,g.ulbid,u.*,d.*,r.* from grievances g,ulbmst u,Districtmst d,rdma_mst r 
				 where g.ulbid=u.ulbid and app_type_id=? and u.distid=d.distid and d.rdma=r.rdma_id";
				 $app_type_id=1;
        		 $query=$conn->prepare($sql);
        		 $query->bind_param("i",htmlspecialchars(strip_tags($app_type_id)));
				 
				 
				 
					if($_POST['regionid']!='')
						{
				
						  $sql.="  and r.rdma_id=? ";
						  $sql.=" group by g.ulbid order by ulbname";
						  $query=$conn->prepare($sql);
						   $app_type_id=1;
						  $rdma_id=$_POST['regionid'];
		                  $query->bind_param("is",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($rdma_id)));
						 
						}
					if($_POST['distid'])
						{
				
						 $sql.=" and d.distid=? ";
						 
						 $query=$conn->prepare($sql);
						 $rdma_id=$_POST['regionid'];
						 $distid=$_POST['distid'];
		                 $query->bind_param("iss",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($rdma_id)),htmlspecialchars(strip_tags($distid)));
						 
						 
						}
					if($_POST['ulbid'])
					        {
		
					 	 $sql.="  and u.ulbid=? ";
					 	 $query=$conn->prepare($sql);
						 $rdma_id=$_POST['regionid'];
						 $distid=$_POST['distid'];
						 $ulbid=$_POST['ulbid'];
		                 $query->bind_param("isss",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($rdma_id)),htmlspecialchars(strip_tags($distid)),htmlspecialchars(strip_tags($ulbid)));
						}
						$sql.=" group by g.ulbid order by ulbname";
						
				}
		
				 
				 
			$query->execute();
			$rs =$query->get_result();
			while($row = $rs->fetch_assoc())
			{
			   $tot_complaints[$row['ulbid']]['servicecount']=$row['servicecount'];
			   $tot_rec_c+=$row['servicecount'];
			}
		   $tpl->assign('tot_rec_c',$tot_rec_c);
				 
			
				 
				 
		$sql="select count(g.grievance_id) as servicecount,g.ulbid,u.ulbid from grievances g,ulbmst u where g.ulbid=u.ulbid and 
		app_type_id=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) group by g.ulbid order by ulbname";
		
		$app_type_id=1;	
		$grievance_status_id1=3;
		$grievance_status_id2=8;
		$grievance_status_id3=10;
		$grievance_status_id4=4;
		$query=$conn->prepare($sql);
		$query->bind_param("iiiii",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),htmlspecialchars(strip_tags($grievance_status_id4)));
		
		
				if(isset($_POST['search1']))
				
				{
			$sql="select count(g.grievance_id) as servicecount,g.ulbid,u.*,d.*,r.* from grievances g,ulbmst u,
			Districtmst d,rdma_mst r where g.ulbid=u.ulbid and app_type_id=? and u.distid=d.distid and d.rdma=r.rdma_id and 
			(grievance_status_id=? or grievance_status_id=? or grievance_status_id=? or grievance_status_id=?)";
			
			        $app_type_id=1;	
            		$grievance_status_id1=3;
            		$grievance_status_id2=9;
            		$grievance_status_id3=10;
            		$grievance_status_id4=4;
					$query=$conn->prepare($sql);
		            $query->bind_param("iiiii",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),
		            $grievance_status_id4);
			
					if($_POST['regionid']!='')
						{
			
						 
						  $sql.="  and r.rdma_id=?";
						  $sql.=" group by g.ulbid order by ulbname";
						  $query=$conn->prepare($sql);
						  $rdma_id=$_POST['regionid'];
						  $app_type_id=1;	
                    		$grievance_status_id1=3;
                    		$grievance_status_id2=9;
                    		$grievance_status_id3=10;
                    		$grievance_status_id4=4;
		                  $query->bind_param("iiiiis",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),
		                  htmlspecialchars(strip_tags($grievance_status_id4)),htmlspecialchars(strip_tags($rdma_id)));
						 
						 
						}
					if($_POST['distid'])
						{
			
						  $sql.=" and d.distid=? ";
						  $query=$conn->prepare($sql);
						  $rdma_id=$_POST['regionid'];
						  $distid=$_POST['distid'];
		                  $query->bind_param("iiiiiss",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),
		                  htmlspecialchars(strip_tags($grievance_status_id4)),htmlspecialchars(strip_tags($rdma_id)),htmlspecialchars(strip_tags($distid)));
						 
						}
					if($_POST['ulbid'])
					        {
					
					 	  $sql.="  and u.ulbid=? ";
					 	  $query=$conn->prepare($sql);
						  $rdma_id=$_POST['regionid'];
						  $distid=$_POST['distid'];
						  $ulbid=$_POST['ulbid'];
		                  $query->bind_param("iiiiisss",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),
		                  htmlspecialchars(strip_tags($grievance_status_id4)),htmlspecialchars(strip_tags($rdma_id)),htmlspecialchars(strip_tags($distid)),htmlspecialchars(strip_tags($ulbid)));
					 	
						}
						$sql.=" group by g.ulbid order by ulbname";
				}
		
			
				
				
				$query->execute();
				$rs = $query->get_result();
				while($row =$rs->fetch_assoc())
				{
				    $res_complaints[$row['ulbid']]['servicecount']=$row['servicecount'];
				    $tot_red_c+=$row['servicecount'];
				}
					$tpl->assign('tot_red_c',$tot_red_c);
		
		
		$sql =$conn->prepare("SELECT * FROM  rdma_mst");
		$sql->execute();
		$rs = $sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		  $region_list[$row['rdma_id']]=$row['rdma_desc'];  
		}
		
		

		$sql =$conn->prepare("SELECT * FROM  Districtmst");
		$sql->execute();
		$rs = $sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		 $dist_list[$row['distid']]=$row['distname'];  
		}
		
		
		
		$sql ="select * from ulbmst";
		$query =$conn->prepare($sql);
		
		if($_POST['regionid']!='')
		{
	
		$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.distid=d.distid and d.rdma=?";
		$query = $conn->prepare($sql);
		$rdma=htmlspecialchars(strip_tags($_POST['regionid']));
		$query->bind_param("s",$rdma);
		
		}
		if($_POST['regionid'] && $_POST['distid'])
		{

		$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.distid=? and d.rdma=?";
		$query = $conn->prepare($sql);
		$distid=htmlspecialchars(strip_tags($_POST['distid']));
		$rdma=htmlspecialchars(strip_tags($_POST['regionid']));
		$query->bind_param("ss",$distid,$rdma);
		}
		if($_POST['regionid'] && $_POST['distid'] && $_POST['ulbid'])
		{

		
		$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.ulbid=? and u.distid=? and d.rdma=?";
		$query = $conn->prepare($sql);
		$ulbid =htmlspecialchars(strip_tags($_POST['ulbid']));
		$distid=htmlspecialchars(strip_tags($_POST['distid']));
		$rdma=htmlspecialchars(strip_tags($_POST['regionid']));
		$query->bind_param("sss",$ulbid,$distid,$rdma);
		
		}
		

		        $query->execute();
				$rs = $query->get_result();
				while($row =$rs->fetch_assoc())
				{
				     $ulb_list1[$row['ulbid']]=$row['ulbname'];
				}
				$tpl->assign('ulb_list1',$ulb_list1);	
				
				
			
				
				
				if(isset($_POST['search1']))
				{
				
					$sql ="select * from ulbmst";
					$query = $conn->prepare($sql);
					
					if($_POST['regionid']!='')
					{
				
					$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.distid=d.distid and d.rdma=?";
					$query = $conn->prepare($sql);
            		$rdma=htmlspecialchars(strip_tags($_POST['regionid']));
            		$query->bind_param("s",$rdma);
					}
					if($_POST['regionid'] && $_POST['distid'])
					{
			
					$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.distid=? and d.rdma=?";
					$query = $conn->prepare($sql);
            		$distid=htmlspecialchars(strip_tags($_POST['distid']));
            		$rdma=htmlspecialchars(strip_tags($_POST['regionid']));
            		$query->bind_param("ss",$distid,$rdma);
					
					}
					if($_POST['regionid'] && $_POST['distid'] && $_POST['ulbid'])
					{
					$sql ="select d.*,u.* from Districtmst d,ulbmst u where u.ulbid=? and u.distid=? and d.rdma=?";
					$query = $conn->prepare($sql);
            		$ulbid =htmlspecialchars(strip_tags($_POST['ulbid']));
            		$distid=htmlspecialchars(strip_tags($_POST['distid']));
            		$rdma=htmlspecialchars(strip_tags($_POST['regionid']));
            		$query->bind_param("sss",$ulbid,$distid,$rdma);
					
					}
					
				
				$query->execute();
				$rs = $query->get_result();
				while($row =$rs->fetch_assoc())
				{
				    $ulb_list2[$row['ulbid']]=$row['ulbname'];
				}
					$tpl->assign('ulb_list2',$ulb_list2);	
					
					
					
					$sql=$conn->prepare("SELECT * FROM  Districtmst where rdma=?");
					$rdma=htmlspecialchars(strip_tags($_POST['regionid']));
					$sql->bind_param("s",$rdma);
					$sql->execute();
					$rs = $sql->get_result();
					while($row= $rs->fetch_assoc())
					{
					$dist_list2[$row['distid']]=$row['distname'];
					}
					$tpl->assign('dist_list2',$dist_list2);
			
				
				}
				
		
		}
		
		
	       $sql=$conn->prepare("select * from ulbmst");
				
					$sql->execute();
					$rs = $sql->get_result();
					while($row= $rs->fetch_assoc())
					{
					  $ulb_list[$row['ulbid']]=$row['ulbname'];
					}
				
		$conn->close();
	
	  
	   $tpl->assign('ulb_list',$ulb_list);
	    $tpl->assign('ulb_list1',$ulb_list1);
		$tpl->assign('preg',$_POST['regionid']);
		$tpl->assign('pulb',$_POST['ulbid']);
		$tpl->assign('pdist',$_POST['distid']);
		$tpl->assign('region_list',$region_list);
		$tpl->assign('dist_list',$dist_list);

		$tpl->assign('feedback_count',$feedback_count);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('tot_complaints',$tot_complaints);
		$tpl->assign('res_complaints',$res_complaints);
		$tpl->assign('res_services',$res_services);
		$tpl->assign('datalist',$datalist);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('origin_rep',$origin_rep);
		$tpl->assign('origin_list',$origin_list);

		$tpl->assign('tanker_enable_status',$tanker_enable_status);
		$tpl->assign('map',$map);
		$tpl->assign('pic',$pic);
		$tpl->assign('data',$data);
		$tpl->assign('data1',$data1);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ulbwise_report.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>
                            
                            
                            
                            
                            
                            