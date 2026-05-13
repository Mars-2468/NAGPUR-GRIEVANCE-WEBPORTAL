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
		require_once('prepare_connection.php');
		$conn=getconnection();
		$conn->set_charset("utf8");
		
	 		if(isset($_POST['submit']))
			{
				
				$data=array();
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
					$data[]=$cs_id;
					$csid_list[$cs_id]=$cs_id;
					
			       $sql=$conn->prepare("select * from ward_mst where ulbid=? order by ward_id");
			       $sql->bind_param("s",$_SESSION['ulbid']);
			       $sql->execute();
			       $rs=$sql->get_result();
			       while($row =$rs->fetch_assoc())
			       {
			         $ward_list[$cs_id][$row['ward_id']]=$row['ward_desc'];
			       }
			       $sql->close();
			      
			       
			        $sql ="select * from street_mst where ulbid='".$_SESSION['ulbid']."' and street_id NOT IN(select street_id from emp_map where cs_id='".$cs_id."' and ulbid='".$_SESSION['ulbid']."' and cs_type_id='2') order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			       $street_list[$cs_id][$row['ward_id']][$row['street_id']]=$row['street_desc'];
			       
			       }
			       
			      
			       
				}
				
				     $delete_status=0;  
				   $sql=$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where ulbid=? and delete_status=?");
			       $sql->bind_param("si",$_SESSION['ulbid'],$delete_status);
			       $sql->execute();
			       $rs=$sql->get_result();
			       while($row =$rs->fetch_assoc())
			       {
			         $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
			       }
			       $sql->close();
			           
				  
	      
				   $sql=$conn->prepare("select * from dept_mst where ulbid=? order by dept_id");
			       $sql->bind_param("s",$_SESSION['ulbid']);
			       $sql->execute();
			       $rs=$sql->get_result();
			       while($row =$rs->fetch_assoc())
			       {
			          $dept_list[$row['dept_id']]=$row['dept_desc'];
			       }
			       $sql->close();
				 
				
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
		 
			       $sql ="select * from emp_map where ulbid=? and flag=? and cs_type_id=? and cs_id=?";
			       
			      
			       $flag = 1;
			       $cs_type_id = 2;
			       
			       
			       $sql=$conn->prepare($sql);
			       $sql->bind_param("siii",htmlspecialchars(strip_tags($_SESSION['ulbid'])),$flag,$cs_type_id,$cs_id);
			       $sql->execute();
			       $rs=$sql->get_result();
	
				
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
				
				 $sql1 ="select * from ward_mst where ulbid=? and ward_id IN(select ward_id from emp_map where cs_id=? and ulbid=? and cs_type_id=? and street_id !=?) order by ward_id";
				 $cs_type_id = 2;
				 $streetid =0;
				 $sql=$conn->prepare($sql1);
				 $sql->bind_param("sisii",htmlspecialchars(strip_tags($_SESSION['ulbid'])),$cs_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])),$cs_type_id,$streetid);
			     $sql->execute();
    		     $rs=$sql->get_result();
    		       while($row = $rs->fetch_assoc())
    		       {
    		       $ward_list2[$cs_id][$row['ward_id']]=$row['ward_desc'];
    		       }
			       
			       
			       
			       $sql ="select * from street_mst where ulbid=? and street_id IN(select street_id from emp_map where cs_id=? and ulbid=? and cs_type_id=?) order by ward_id";
			       $sql=$conn->prepare($sql);
			       $cs_type_id =2;
				   $sql->bind_param("sisi",htmlspecialchars(strip_tags($_SESSION['ulbid'])),$cs_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])),$cs_type_id);
			       $sql->execute();
			       $rs=$sql->get_result();
			       
			     
			       while($row = $rs->fetch_assoc())
			       {
			       $street_list2[$cs_id][$row['ward_id']][$row['street_id']]=$row['street_desc'];
			       }
				   
				}
			
		
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql->close();
		
	
		
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
				 				$ward= explode("-",$_POST[$ward_id]);
				 				$street= explode("-",$_POST[$street_id]);
				 				
				 				/*if($street[0]==$_POST[$cs_id])
				 				{*/
							 			
							 		$streetid = $street[2];
							        $ward_id = $street[1];
							        $empid = $_POST['emp_id_sel'];
							        $emp_id2 = $_POST['emp_id2_sel'];
							        $emp_id3 = $_POST['emp_id3_sel'];
							        $emp_id4 = $_POST['emp_id4_sel'];
							        $cs_id = $street[0];
							        $dept_id = $_POST['dept_id_sel'];
							        $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
							        $cs_type_id = 2;
							        $flag = 1;
							        
							 					
							        $sql ="insert into emp_map(
							            street_id,
							            ward_id,
							            emp_id,
							            emp_id2,
							            emp_id3,
							            emp_id4,
							            cs_id,
							            dept_id,
							            ulbid,
							            cs_type_id,
							            flag
							            ) values (
							                '".$streetid."',
							                '".$ward_id."',
							                '".$empid."',
							                '".$emp_id2."',
							                '".$emp_id3."',
							                '".$emp_id4."',
							                '".$cs_id."',
							                '".$dept_id."',
							                '".$ulbid."',
							               '".$cs_type_id."',
							               '".$flag."'
							                
							                ) ON DUPLICATE KEY UPDATE flag='".$flag."',emp_id2='".$emp_id2."'";
							                mysqli_query($conn,$sql);
							        
							       
							        
							        
							        //$query=$conn->prepare($sql);
			                        //$query->bind_param("iiiiiiiiiiiii",$streetid,$ward_id,$empid,$emp_id2,$emp_id3,$emp_id4,$cs_id,$dept_id,$ulbid,$cs_type_id,$flag,$flag,$emp_id2);
								  
								 /* if($query->execute())
									 {
									 }
									 else
									 {
									 $errors++;
									 }*/
							//	}
							 				
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
	       			
			
		
		
		
		$sql ="select * from emp_map where cs_type_id=? and ulbid=?";
		
		$cs_type_id = 2;
		$sql =$conn->prepare($sql);
		$sql->bind_param("is",$cs_type_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		
		
		
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
		
		
		
		$sql =$conn->prepare("select cs_id, comp_desc,telugu_description from category3_mst where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   $cs_list[$row['cs_id']]=$row['comp_desc']."(".$row['telugu_description'].")";
		}
		
		$sql->close();
		
		
	       
	    $sql =$conn->prepare("select * from dept_mst where ulbid=? order by dept_id ");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   $dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		$sql->close(); 
	       
	      
		 $sql="select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=? and ulbid=? and delete_status=?";
		 $sql =$conn->prepare($sql);
		 $delete_status=0;
		$sql->bind_param("isi",$_POST['dept_id'],htmlspecialchars(strip_tags($_SESSION['ulbid'])),$delete_status);
		$sql->execute();
	    $rs=$sql->get_result();
		
	       while($row = $rs->fetch_assoc())
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	   
	       $sql="select emp_id,emp_name,emp_mobile from emp_mst_od where emp_dept=? and ulbid=? and delete_status=?";
	       $delete_status=0;
	        $sql =$conn->prepare($sql);
    		$sql->bind_param("isi",$_POST['dept_id'],htmlspecialchars(strip_tags($_SESSION['ulbid'])),$delete_status);
    		$sql->execute();
    	    $rs=$sql->get_result();
	       
		   
	       while($row = $rs->fetch_assoc())
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	    
	       $emp_dept=preg_replace('/^[0-9]+$/', ' ', $_REQUEST['dept_id']);
	       $delete_status=0;
	       $sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=? and delete_status=?");
		   $sql->bind_param("ii",$emp_dept,$delete_status);
		   $sql->execute();
	       $rs=$sql->get_result();
    		while($row = $rs->fetch_assoc())
    		{
    		     $emp_list2[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
    		}
    		
    		$sql->close();
	       
	       
	       $sql =$conn->prepare("select * from desg_mst where ulbid=?");
		   $sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		   $sql->execute();
	       $rs=$sql->get_result();
    		while($row = $rs->fetch_assoc())
    		{
    		     $desg_list[$row['desg_id']]=$row['desg_desc'];
    		}
    		
    		$sql->close();
    		
    		
	  /* $sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	      
	       $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
            $tpl->assign('ulbid',$_SESSION['ulbid']);
	       $tpl->assign('user_type',$_SESSION['user_type']);
	       $tpl->assign('desg_list',$desg_list);
	        $tpl->assign('emp_list',$emp_list);
	       $tpl->assign('dept_list',$dept_list);
	       $tpl->assign('cs_list',$cs_list);
	       $tpl->assign('emp_list2',$emp_list2);
	      $tpl->assign('map_list',$map_list);
	       $tpl->assign('uname',$_SESSION['user_name']);
	       $tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('employee_map.tpl');
		
	}
	else
	{
	
	echo "<script>window.location='index.php';</script>";
	}
	
?>	
	
	