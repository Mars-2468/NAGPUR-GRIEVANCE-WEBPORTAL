<?php 
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	

	if(isset($_SESSION['uid']))
	{
	   
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		require_once('prepare_connection.php');
		$conn=getconnection();
		
	 		if(isset($_POST['submit']))
			{
				
				
				$data=array();
				// print_r($_POST['cs_id']);
				// die;
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
				    // if (!preg_match("/^[0-9]+$/", $cs_id))
				    // {
				    //     die('Invalid data passed to category id');
				    // }
				    
				    
					$data[]=$cs_id;
					$csid_list[$cs_id]=$cs_id;
					
				   /*$sql ="select * from ward_mst where ulbid='".$_SESSION['ulbid']."'  order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			        $ward_list[$cs_id][$row['ward_id']]=$row['ward_desc'];
			       }*/
			       
			       $sql=$conn->prepare("select * from ward_mst where ulbid=? order by ward_id");
			       $sql->bind_param("s",$_SESSION['ulbid']);
			       $sql->execute();
			       $rs=$sql->get_result();
			       while($row =$rs->fetch_assoc())
			       {
			         $ward_list[$cs_id][$row['ward_id']]=$row['ward_desc']; 
			       }
			       $sql->close();
			       
			      
			       $sql ="select * from street_mst where ulbid='".$_SESSION['ulbid']."' and street_id NOT IN(select street_id from emp_map where cs_id='".$cs_id."' and ulbid='".$_SESSION['ulbid']."' and cs_type_id='1') order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			        $street_list[$cs_id][$row['ward_id']][$row['street_id']]=$row['street_desc'];
			       }
			       
				}
				
				//  if (!preg_match("/^[0-9]+$/", $_POST['dept_id']))
				//     {
				//         die('Invalid data passed to Department');
				//     }
				    
				
				
				
				
		   $sql="select emp_id,emp_name,emp_mobile from emp_mst where ulbid='".$_SESSION['ulbid']."' and delete_status='0' and emp_status='0'";
		   $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	        $emp_dept=preg_replace('/^[0-9]+$/', ' ', $_POST['dept_id']);
	       
	       /*$sql=$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=? and ulbid=? and delete_status=?");
	       $delete_status=0;
	       $sql->bind_param("isi",$_POST['dept_id'],$_SESSION['ulbid'],$delete_status);
	       $sql->execute();
	       $rs=$sql->get_result();
	       while($row =$rs->fetch_assoc())
	       {
	            $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	       $sql->close();*/
	       
	      
	       
	      $sql="select emp_id,emp_name,emp_mobile from emp_mst_od where ulbid='".$_SESSION['ulbid']."' and delete_status='0'";
		  $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	      
	      
		   /*$sql ="select * from dept_mst where ulbid='".$_SESSION['ulbid']."' order by dept_id";
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }*/
		         $sql=$conn->prepare("select * from dept_mst where ulbid=? order by dept_desc");
			       $sql->bind_param("s",$_SESSION['ulbid']);
			       $sql->execute();
			       $rs=$sql->get_result();
			       while($row =$rs->fetch_assoc())
			       {
			          $dept_list[$row['dept_id']]=$row['dept_desc'];  
			       }
			       $sql->close();		
				
				// print_r($dept_list);
				
				 
				       
				
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
				    if (!preg_match("/^[0-9]+$/",$cs_id))
				    {
				        die('Invalid data passed to category');
				    }
				    
				    
				  $sql ="select * from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' and cs_type_id='1' and cs_id='".$cs_id."'";
		
					$rs = mysqli_query($conn,$sql);
					while($row = mysqli_fetch_assoc($rs))
					{
					
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id']=$emp_list[$row['emp_id']];
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id2']=$emp_list[$row['emp_id2']];
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id3']=$emp_list[$row['emp_id3']];
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['emp_id4']=$emp_list[$row['emp_id4']];
					$data2[$row['ward_id']][$row['cs_id']][$row['street_id']]['dept_id']=$dept_list[$row['dept_id']];
					
					}
					
				
				
				}
				
				//print_r($data2);
				
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
				
				if (!preg_match("/^[0-9]+$/", $cs_id))
				    {
				        die('Invalid data passed to category');
				    }
				
				    
				   $sql ="select * from ward_mst where ulbid='".$_SESSION['ulbid']."' and ward_id IN(select ward_id from emp_map where cs_id='".$cs_id."' and ulbid='".$_SESSION['ulbid']."' and cs_type_id='1' and street_id !=0) order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			        $ward_list2[$cs_id][$row['ward_id']]=$row['ward_desc'];
			       }
				   
				  $sql ="select * from street_mst where ulbid='".$_SESSION['ulbid']."' and street_id IN(select street_id from emp_map where cs_id='".$cs_id."' and ulbid='".$_SESSION['ulbid']."' and cs_type_id='1') order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			        $street_list2[$cs_id][$row['ward_id']][$row['street_id']]=$row['street_desc'];
			       }  
				  
			    }
			
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql->close();
		
	//	print_r($online_applications);
		
		$tpl->assign('online_applications',$online_applications);
			
			
			//echo $_POST['emp_id4'];
			
			//print_r($data2);
				
			        $tpl->assign('street_list',$street_list);
			        $tpl->assign('ward_list2',$ward_list2);
			        $tpl->assign('street_list2',$street_list2);
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
				 				
				 				if($street[0]==$_POST[$cs_id])
				 				{
							 					
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
							                '".$street[2]."',
							                '".$street[1]."',
							                '".$_POST['emp_id_sel']."',
							                '".$_POST['emp_id2_sel']."',
							                '".$_POST['emp_id3_sel']."',
							                '".$_POST['emp_id4_sel']."',
							                '".$_POST[$cs_id]."',
							                '".$_POST['dept_id_sel']."', 
							                '".$_SESSION['ulbid']."',
							                '1',
							                '1'
							                ) ON DUPLICATE KEY UPDATE flag='1',emp_id2='".$_POST['emp_id2_sel']."',emp_id3='".$_POST['emp_id3_sel']."',emp_id4='".$_POST['emp_id4_sel']."'";
								
								

								  if(mysqli_query($conn,$sql))
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
					$tpl->assign('msg','Unable to Update try Again..!');
					}
					else{
					$tpl->assign('class','alert alert-success display-hide');
					$tpl->assign('msg','Employees Mapped Successfully..!');
					}
					}
			
			
			
			 
	       			
	       			
	       			$tpl->assign('data',$data);
	       			
			
		
		
		
		$sql ="select * from emp_map where cs_type_id='1' and ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
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
	       
	       $sql ="select * from emp_map_od where cs_type_id='1' and ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
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
		
		
		/*$sql ="select c.cs_id,c.cs_desc as comp_desc from  cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid='".$_SESSION['ulbid']."' and cu.flag='1'";
		$rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $cs_list[$row['cs_id']]=$row['comp_desc'];
	       }
		$tpl->assign('cs_list',$cs_list);
	*/
	       /*$sql ="SELECT cat_id,description FROM  `category_mst` ";
			$rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $cat_list[$row['cat_id']]=$row['description'];
	       }*/
	       
	   $sql =$conn->prepare("SELECT cat_id,description FROM  `category_mst`");
	
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $cat_list[$row['cat_id']]=$row['description'];
		}
		
		$sql->close();
	       
	       
	       $sql ="select c.cs_id,cs_desc,cam.cat_id,description from complaint_ulbmap c,cs_mst cm,category_mst cam where cam.cat_id=cm.cat_id and c.cs_id=cm.cs_id and c.ulbid='".$_SESSION['ulbid']."' and flag='1' order by cs_id";
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	            $cs_list[$row['description']][$row['cs_id']]=$row['cs_desc']." (".$cat_list[$row['cat_id']].")";
	            $cs_data[$row['cs_id']]=$row['cs_desc']." (".$cat_list[$row['cat_id']].")";
	       }
	       
	    
	       
	       /* $sql ="select * from dept_mst where ulbid='".$_SESSION['ulbid']."' order by dept_id";
	       
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }
	       */
	       
	    $sql =$conn->prepare("select * from dept_mst where ulbid=? order by dept_desc"); 
		$sql->bind_param("s",$_SESSION['ulbid']);
	    $sql->execute();
	    $rs=$sql->get_result();
	   
	    while($row = $rs->fetch_assoc()) 
	    {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];  
	    }
	     $sql->close();  
	   //    if (!preg_match("/^[0-9]+$/", $_POST['dept_id']))
			 //   {
			 //       die('Invalid data passed to Department');
			 //   }
	       
	       
		/* $sql="select emp_id,emp_name,emp_mobile from emp_mst where emp_dept='".$_POST['dept_id']."' and ulbid='".$_SESSION['ulbid']."'";
		  $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }*/
	     $delete_status=0;  
	    $emp_dept=preg_replace('/^[0-9]+$/', $_POST['dept_id']);
	    $sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=? and ulbid=? and delete_status=? and emp_status='0'");
		$sql->bind_param("isi",$_POST['dept_id'],$_SESSION['ulbid'],$delete_status);
	    $sql->execute(); 
	    $rs=$sql->get_result();
	    
		while($row = $rs->fetch_assoc())
		{
		    $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
		}
		
		$sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst_od where emp_dept=? and ulbid=? and delete_status=?");
		$sql->bind_param("isi",$_POST['dept_id'],$_SESSION['ulbid'],$delete_status);
	    $sql->execute(); 
	    $rs=$sql->get_result();
	    
		while($row = $rs->fetch_assoc())
		{
		    $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
		}
		
		$sql->close();
		
		
		$sql ="select e.emp_id,emp_name,emp_mobile,desg_id from emp_mst e,emp_desg_map em where em.emp_id=e.emp_id and em.dept_id='".$emp_dept."' and ulbid='".$_SESSION['ulbid']."' and delete_status='0' and e.emp_status='0' group by e.emp_id";
		 
	      $rs = mysqli_query($conn,$sql);
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
	          
		       while($row = mysqli_fetch_assoc($rs))
		       {
		      
		      $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
		      
		       }
		}
		
		$sql ="select e.emp_id,emp_name,emp_mobile,desg_id from emp_mst_od e,emp_desg_map em where em.emp_id=e.emp_id and em.dept_id='".$_POST['dept_id']."' and ulbid='".$_SESSION['ulbid']."' and delete_status='0' group by e.emp_id";
		 
	      $rs = mysqli_query($conn,$sql);
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
	          
		       while($row = mysqli_fetch_assoc($rs))
		       {
		      
		      $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
		      
		       }
		}
	    
	   
	       
	   //    if (!preg_match("/^[0-9]+$/", $_REQUEST['dept_id']))
			 //   {
			 //       die('Invalid data passed to Department');
			 //   }
	       
	       
	        /*$sql="select emp_id,emp_name,emp_mobile from emp_mst where emp_dept='".$_REQUEST['dept_id']."'";
		   $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $emp_list2[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }*/
	       $delete_status=0;
	       $emp_depts=preg_replace('/^[0-9]+$/', $_POST['dept_id']);
	       $sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=? and delete_status=? and emp_status='0'");
		   $sql->bind_param("ii",$emp_depts,$delete_status);
	       $sql->execute();
	       $rs=$sql->get_result();
	   
	    while($row = $rs->fetch_assoc()) 
	    {
	         $emp_list2[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	    }
	     $sql->close(); 
		 
		 $sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst_od where emp_dept=? and delete_status=?");
		   $sql->bind_param("ii",$_POST['dept_id'],$delete_status);
	       $sql->execute();
	       $rs=$sql->get_result();
	   
	    while($row = $rs->fetch_assoc()) 
	    {
	         $emp_list2[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	    }
	     $sql->close(); 
		 
		 
		 
		 $sql ="select emp_id,emp_name,emp_mobile,emp_desg from emp_mst where emp_dept='".$_POST['dept_id']."' and ulbid='".$_SESSION['ulbid']."' and delete_status='0' and emp_status='0'";
		 $list2.=" <option value='0'>---Select----</option>";
	      $rs = mysqli_query($conn,$sql);
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
	           $nodata=1;
		       while($row = mysqli_fetch_assoc($rs))
		       {
		      
		     $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
		      
		       }
		   }
		
		$sql ="select emp_id,emp_name,emp_mobile,emp_desg from emp_mst_od where emp_dept='".$_POST['dept_id']."' and ulbid='".$_SESSION['ulbid']."' and delete_status='0'";
		 
	      $rs = mysqli_query($conn,$sql);
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
	           $nodata=1;
		       while($row = mysqli_fetch_assoc($rs))
		       {
		      
		      $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
		      
		       }
		   }
		
		
		$sql ="select e.emp_id,emp_name,emp_mobile,desg_id from emp_mst e,emp_desg_map em where em.emp_id=e.emp_id and em.dept_id='".$_POST['dept_id']."' and ulbid='".$_SESSION['ulbid']."' and delete_status='0' and e.emp_status='0' group by e.emp_id";
		 
	      $rs = mysqli_query($conn,$sql);
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
	           $nodata=1;
		       while($row = mysqli_fetch_assoc($rs))
		       {
		      
		      $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
		      
		       }
		}
		
		
		
		 
		 
		 
		 
	       
	       /* $sql ="select * from desg_mst where ulbid='".$_SESSION['ulbid']."'";
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $desg_list[$row['desg_id']]=$row['desg_desc'];*/
	       
	       $sql =$conn->prepare("select * from desg_mst where ulbid=?");
		   $sql->bind_param("s",$_SESSION['ulbid']);
	       $sql->execute();
	       $rs=$sql->get_result();
	   
	    while($row = $rs->fetch_assoc()) 
	    {
	         $desg_list[$row['desg_id']]=$row['desg_desc'];
	    }
	     $sql->close(); 
	       
	       
	       
	      
	   /*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	   //   echo "<pre>";
	   //   print_r($cs_data);

	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	    $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);

	  //mysqli_close($conn);
	       $tpl->assign('user_type',$_SESSION['user_type']);
	        $tpl->assign('cs_list1',$cs_list1);
	        $tpl->assign('desg_list',$desg_list);
	        $tpl->assign('emp_list',$emp_list);
	        $tpl->assign('dept_list',$dept_list);
	        $tpl->assign('cs_list',$cs_list);
	        $tpl->assign('cs_data',$cs_data);
	       
	        $tpl->assign('uname',$_SESSION['user_name']);
	        $tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('page_name', 'ward_emp_complaint_map.php');
		
		$tpl->display('ward_emp_complaint_map.tpl');
		
		
		
}
	else
	{
	header('location:index.php');
	}
	
?>	
	
	