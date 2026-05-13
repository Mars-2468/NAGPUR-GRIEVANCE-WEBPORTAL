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
		
		/// In case of service 
		
		$app_type_id=1;$disposal_status = 5;
		    if($_REQUEST['originid']!=='')
		    {
		     
            	 
            
            	 
            	 
            $sql="select g.*,count(g.cat3_id)as count,g1.*,e.* from grievances g,grievances_transactions g1,emp_mst e 
            	 where g.grievance_id=g1.grievance_id and g1.emp_id=e.emp_id and g.grievance_origin_id=? and 
            	 g1.disposal_status!=? and g.app_type_id=? and g.ulbid=? and g.cat3_id=?";	 
            	 $query = $conn->prepare($sql);
            	 $grievance_origin_id=htmlspecialchars(strip_tags($_REQUEST['originid']));
            	 $disposal_status=5;
            	 $app_type_id=1;
            	 $ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
            	 $cat3_id=htmlspecialchars(strip_tags($_REQUEST['cat3_id']));
            	 $query->bind_param("iiiss",$grievance_origin_id,$disposal_status,$app_type_id,$ulbid,$cat3_id);
		         $sql.=" group by e.emp_id";
		    }
		
		if($_REQUEST['grievance_status_id'] ==1)
		{
		  
		    
		     $sql.=" and grievance_status_id=?";
		     $query = $conn->prepare($sql);
		    $grievance_origin_id=htmlspecialchars(strip_tags($_REQUEST['originid']));
		    $grievance_status_id=htmlspecialchars(strip_tags($_REQUEST['grievance_status_id']));
            	 $disposal_status=5;
            	 $app_type_id=1;
            	 $ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
            	 $cat3_id=htmlspecialchars(strip_tags($_REQUEST['cat3_id']));
            	 $query->bind_param("iiissi",$grievance_origin_id,$disposal_status,$app_type_id,$ulbid,$cat3_id,$grievance_status_id);
            	 $sql.=" group by e.emp_id";
		}
		
		if($_REQUEST['grievance_status_id'] ==2)
		{
		  
		     $sql.=" and grievance_status_id=?";
		     $query = $conn->prepare($sql);
		    $grievance_origin_id=htmlspecialchars(strip_tags($_REQUEST['originid']));
		    $grievance_status_id=htmlspecialchars(strip_tags($_REQUEST['grievance_status_id']));
            	 $disposal_status=5;
            	 $app_type_id=1;
            	 $ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
            	 $cat3_id=htmlspecialchars(strip_tags($_REQUEST['cat3_id']));
            	 $query->bind_param("iiissi",$grievance_origin_id,$disposal_status,$app_type_id,$ulbid,$cat3_id,$grievance_status_id);
            	 $sql.=" group by e.emp_id";
		}
		
		
		if($_REQUEST['grievance_status_id'] ==3)
		{
		  
		    $sql.=" and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=? grievance_status_id=? 
		    or grievance_status_id=? or grievance_status_id=?)";
		    $query = $conn->prepare($sql);
		    $grievance_origin_id=htmlspecialchars(strip_tags($_REQUEST['originid']));
		    $grievance_status_id1=3;
		    $grievance_status_id2=4;
		    $grievance_status_id3=6;
		    $grievance_status_id4=10;
		    $grievance_status_id5=12;
		    $grievance_status_id6=13;
            	 $disposal_status=5;
            	 $app_type_id=1;
            	 $ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
            	 $cat3_id=htmlspecialchars(strip_tags($_REQUEST['cat3_id']));
            	 $query->bind_param("iiissiiiiii",$grievance_origin_id,$disposal_status,$app_type_id,$ulbid,$cat3_id,
            	 $grievance_status_id1,$grievance_status_id2,$grievance_status_id3,$grievance_status_id4,$grievance_status_id5,$grievance_status_id6);
            	 $sql.=" group by e.emp_id";
		}
		
		
		
		$sql.=" group by e.emp_id";
		
		
		$query->execute();
		$rs =$query->get_result();
		if($rs)
		{
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
				if($_REQUEST['originid']!=='')
				{
				 if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] <= $row['cutt_of_time'])
					 {
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					$data2[$row['grieviance_id']]['count']=$row['count'];
					 }

				}
			}
			
		}
	
						
		
		$tpl->assign('data',$data);



			
		$sql= $conn->prepare("select ward_id,ward_desc from ward_mst");
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}

		
		
		$sql= $conn->prepare("select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?");
		$grievance_status_id=5;
		$sql->bind_param("i",$grievance_status_id);
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
		
		
		
		
		$sql= $conn->prepare("select dept_id,dept_desc from dept_mst");
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
			$tpl->assign('dept_list',$dept_list);
	
	
		$sql= $conn->prepare("select cs_id,cs_desc as comp_desc from cs_mst");
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		
		if($_REQUEST['originid'] == '0')
		{
		    $originid = 1;
		}
		else
		{
		    $originid = $_REQUEST['originid'] ;
		}
			
		
		
		$sql= $conn->prepare("select * from grievance_origin_mst where grievance_origin_id=?");
		$grievance_origin_id=$originid;
		$sql->bind_param("i",$grievance_origin_id);
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		$origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		
		$sql= $conn->prepare("select * from emp_mst");
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		$emp_list[$row['emp_id']]=$row['emp_name'];
		}		
				
		$conn->close();			
		
		$tpl->assign('gstatus_id',$_REQUEST['grievance_status_id']);
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('origin_list',$origin_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$app_type_id);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('origin_id',$_REQUEST['originid']);
		$tpl->assign('ulbid',$_REQUEST['ulbid']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('cat_emp_origin.tpl');
	}
	else
	{
	
		
		echo "<script>window.location='index.php';</script>";
	}
?>