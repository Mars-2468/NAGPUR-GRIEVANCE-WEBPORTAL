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
		require_once('connection.php');
		$conn=getconnection();
		
		$ulbid = $_SESSION['ulbid'];
	 		if(isset($_POST['submit']))
			{
				
				$data=array();
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
					$data[]=$cs_id;
					$csid_list[$cs_id]=$cs_id;
					$sql=$conn->prepare("select * from ward_mst where ulbid=? order by ward_id");
					$sql->bind_param("s",$ulbid);
					$sql->execute();
				    $rs=$sql->get_result();
					
			       while($row = $rs->fetch_assoc())
			       {
			       $ward_list[$cs_id][$row['ward_id']]=$row['ward_desc'];
			       
			       }
			       $cs_type_id=2;
			       
			        $sql=$conn->prepare("select * from street_mst where ulbid=? and street_id NOT IN(select street_id from emp_map_testing where cs_id=? and ulbid=? and cs_type_id=?) order by ward_id");
					$sql->bind_param("sisi",$ulbid,$cs_id,$ulbid,$cs_type_id);
					$sql->execute();
				    $rs= $sql->get_result();
			       
			       while($row = $rs->fetch_assoc())
			       {
			       $street_list[$cs_id][$row['ward_id']][$row['street_id']]=$row['street_desc'];
			       
			       }
			      
				}
				$sql=$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where ulbid=?");
					$sql->bind_param("s",$ulbid);
					$sql->execute();
				    $rs = $sql->get_result();
			      
				       while($row = $rs->fetch_assoc())
				       {
				       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
				       }
				      
	       $sql=$conn->prepare("select * from dept_mst where ulbid=? order by dept_id");
					$sql->bind_param("s",$ulbid);
					$sql->execute();
				    $rs = $sql->get_result();
			      
	       while($row = $rs->fetch_assoc())
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }
				
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
				
				    $flag=1; $cs_type_id=2;
				    
					$sql=$conn->prepare("select * from emp_map_testing where ulbid=? and flag=? and cs_type_id=? and cs_id=?");
					$sql->bind_param("siii",$ulbid,$flag,$cs_type_id,$cs_id);
					$sql->execute();
				    $rs = $sql->get_result();
			      
					while($row = $rs->fetch_assoc())
					{
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id']=$emp_list[$row['emp_id']];
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id2']=$emp_list[$row['emp_id2']];
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id3']=$emp_list[$row['emp_id3']];
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id4']=$emp_list[$row['emp_id4']];
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['dept_id']=$dept_list[$row['dept_id']];
					}
				
				}
				
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
				    $street_id=0; $cs_type_id=2;
				    
				    $sql=$conn->prepare("select * from ward_mst where ulbid=? and ward_id IN(select ward_id from emp_map_testing where cs_id=? and ulbid=? and cs_type_id=? and street_id !=?) order by ward_id");
					$sql->bind_param("isii",$cs_id,$ulbid,$cs_type_id,$street_id);
					$sql->execute();
				    $rs = $sql->get_result();
				 
			       while($row = $rs->fetch_assoc())
			       {
			       $ward_list2[$cs_id][$row['ward_id']]=$row['ward_desc'];
			       }
			       
			        $sql=$conn->prepare("select * from street_mst where ulbid=? and street_id IN(select street_id from emp_map_testing where cs_id=? and ulbid=? and cs_type_id=?) order by ward_id");
					$sql->bind_param("sisi",$ulbid,$cs_id,$ulbid,$cs_type_id);
					$sql->execute();
				    $rs = $sql->get_result();
				  
			       while($row = $rs->fetch_assoc())
			       {
			       $street_list2[$cs_id][$row['ward_id']][$row['street_id']]=$row['street_desc'];
			       }
				   
				}
				
				$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
				$sql->bind_param("s",$ulbid);
					$sql->execute();
				    $rs = $sql->get_result();
			
		while($row =$rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
	
		$tpl->assign('online_applications',$online_applications);
				
				    $tpl->assign('street_list2',$street_list2);
			       	$tpl->assign('street_list',$street_list);
				    $tpl->assign('ward_list2',$ward_list2);
			      
    				$tpl->assign('csid_list',$csid_list);
    				$tpl->assign('dept_list',$dept_list);
    				$tpl->assign('emp_list',$emp_list);
    				
				   $tpl->assign('data',$data);
				   $tpl->assign('data2',$data2);
				   $tpl->assign('ward_list',$ward_list);
				   $tpl->assign('cs_id_sel',$_POST['cs_id']);
				   $tpl->assign('dept_id_sel',$_POST['dept_id']);
				   $tpl->assign('emp_id_sel',$_POST['emp_id']);
				   $tpl->assign('emp_id2_sel',$_POST['emp_id2']);
				   $tpl->assign('emp_id3_sel',$_POST['emp_id3']);
				   $tpl->assign('emp_id4_sel',$_POST['emp_id4']);
				   
			}
	 		
	 		$errors=0; 
	 		if(isset($_POST['save']))
	 		{
				
				
				for($j=0;$j<$_POST['cs_count'];$j++)
					{
						$cs_id='cs_id'.$j;
						for($i=0; $i<$_POST['file_count']; $i++)
						{
						  	
							 	$ward_id="ward_id".$i;
							 	$street_id="street_id".$i;
								$check="check".$i;
								
								
							
							 if($_POST[$street_id] !='')
			 				{ 
				 				$ward= split("-",$_POST[$ward_id]);
				 				$street= split("-",$_POST[$street_id]);
				 				
				 				if($street[0]==$_POST[$cs_id])
				 				{
				 				    $flag=1; $cs_type_id=2;
				 				    $street_id=$street[2];
				 				    $ward_id=$street[1];
				 				    $emp_id=$_POST['emp_id_sel'];
				 				    $emp_id2=$_POST['emp_id2_sel'];
				 				    $emp_id3=$_POST['emp_id3_sel'];
				 				    $emp_id4=$_POST['emp_id4_sel'];
				 				    $cs_id=$_POST[$cs_id];
				 				    $dept_id=$_POST['dept_id_sel'];
				 				    
							 		$sql =$conn->prepare("insert into emp_map_testing(street_id,ward_id,emp_id,emp_id2,emp_id3,emp_id4,cs_id,dept_id,ulbid,cs_type_id,flag) values (?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE flag=?,emp_id2=?");
				                    $sql->bind_param("iissssiisiiis",$street_id,$ward_id,$emp_id,$emp_id2,$emp_id3,$emp_id4,$cs_id,$dept_id,$ulbid,$cs_type_id,$flag,$flag,$emp_id2);
				                	$sql->execute();
				                    $rs = $sql->get_result();	
							       
								  
								  if($rs)
									 {
									 }
									 else
									 {
									 $errors++;
									 }
								}
							 				
				 			}
						}
					}	
				
	         
				 if($errors > 0)
					{
					$tpl->assign('class','alert alert-danger display-hide');
					$tpl->assign('msg','Unable to update try again');
					}
					else{
					$tpl->assign('class','alert alert-success display-hide');
					$tpl->assign('msg','employees Mapped Successfully');
					}
					}
			
	       			$tpl->assign('data',$data);
	       		$cs_type_id=2;
	
		$sql=$conn->prepare("select * from emp_map_testing where cs_type_id=? and ulbid=?");
		$sql->bind_param("is",$cs_type_id,$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
	       while($row = $rs->fetch_assoc())
	       {
	       $map_list[$row['ward_id']]['ward_id']=$row['ward_id'];
	       $map_list[$row['ward_id']]['dept_id']=$row['dept_id'];
	       $map_list[$row['ward_id']]['desg_id']=$row['desg_id'];
	       $map_list[$row['ward_id']]['emp_id']=$row['emp_id'];
	       $map_list[$row['ward_id']]['emp_id2']=$row['emp_id2'];
	       $map_list[$row['ward_id']]['emp_id3']=$row['emp_id3'];
	       $map_list[$row['ward_id']]['emp_id4']=$row['emp_id4'];
	       $map_list[$row['ward_id']]['cs_id']=$row['cs_id'];
	       
	       
	       }
	
		$tpl->assign('map_list',$map_list);
		$is_external_service=0;
		
		$sql=$conn->prepare("select cs_id, cs_desc as comp_desc,telugu_description from  standard_services where is_external_service=?");
		$sql->bind_param("i",$is_external_service);
		$sql->execute();
		$rs = $sql->get_result();
		
	       while($row =$rs->fetch_assoc())
	       {
	       $cs_list[$row['cs_id']]=$row['comp_desc']."(".$row['telugu_description'].")";
	       }
		$tpl->assign('cs_list',$cs_list);
	
	      
	    $sql=$conn->prepare("select * from dept_mst where ulbid=? order by dept_id");
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
	        
	       while($row = $rs->fetch_assoc())
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }
	       $delete_status=0;
	    $dept_id=$_POST['dept_id'];   
	    $sql=$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=? and ulbid=? and delete_status=?");
		$sql->bind_param("isi",$dept_id,$ulbid,$delete_status);
		$sql->execute();
		$rs = $sql->get_result();
		
	       while($row = $rs->fetch_assoc())
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	    $delete_status=0;
	    $dept_id=$_POST['dept_id'];
	    $sql=$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst_od where emp_dept=? and ulbid=? and delete_status=?");
		$sql->bind_param("isi",$dept_id,$ulbid,$delete_status);
		$sql->execute();
		$rs = $sql->get_result();
		
	      
	       while($row = $rs->fetch_assoc())
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	       
	    $dept_id=$_POST['dept_id'];  
	    $sql=$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=?");
		$sql->bind_param("i",$dept_id);
		$sql->execute();
		$rs = $sql->get_result();
	       
	       while($row =$rs->fetch_assoc())
	       {
	       $emp_list2[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	       
	    $sql=$conn->prepare("select * from desg_mst where ulbid=?");
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
	        
	       while($row = $rs->fetch_assoc())
	       {
	       $desg_list[$row['desg_id']]=$row['desg_desc'];
	       }
	       
	       $type=1;
	       $ulbidlike='%'.$_SESSION['ulbid'].'%';
	       
	    $sql=$conn->prepare("select COUNT(id) as user_count from login_details where type=? and ulbid like ?");
		$sql->bind_param("is",$type,$ulbidlike);
		$sql->execute();
		$rs = $sql->get_result();
		
	      
	      $row = $rs->fetch_assoc();
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	      
	      $sql->close();
	       $tpl->assign('user_type',$_SESSION['user_type']);
	       $tpl->assign('desg_list',$desg_list);
	       $tpl->assign('emp_list',$emp_list);
	       $tpl->assign('dept_list',$dept_list);
	       $tpl->assign('cs_list',$cs_list);
	       $tpl->assign('uname',$_SESSION['user_name']);
	       $tpl->assign('services',$obj->services);
    		$tpl->assign('main_icons',$obj->main_icons);
    		$tpl->assign('logo',$_SESSION['logo']);
    		$tpl->assign('uid',$_SESSION['uid']);
    		$tpl->assign('banner',$_SESSION['banner']);
    		$tpl->display('employee_standard_service_map.tpl');
		
	}
	else
	{
	
	echo "<script>window.location='index.php';</script>";
	}
	
?>	
	
	