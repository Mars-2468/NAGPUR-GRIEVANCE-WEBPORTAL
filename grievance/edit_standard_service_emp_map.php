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
		
		
		
		
		     
	 	
	 		if(isset($_POST['submit']))
			{
				
				
				$data=array();
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
					$data[]=$cs_id;
					$csid_list[$cs_id]=$cs_id;
					
				$sql ="select * from ward_mst where ulbid='".$_SESSION['ulbid']."'  order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			       $ward_list[$cs_id][$row['ward_id']]=$row['ward_desc'];
			       }
			       
			       $sql ="select * from street_mst where ulbid='".$_SESSION['ulbid']."' and street_id NOT IN(select street_id from emp_map where cs_id='".$cs_id."' and ulbid='".$_SESSION['ulbid']."' and cs_type_id='2') order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			       $street_list[$cs_id][$row['ward_id']][$row['street_id']]=$row['street_desc'];
			       
			       }
				}
				
				
				
				 $sql="select emp_id,emp_name,emp_mobile from emp_mst where ulbid='".$_SESSION['ulbid']."'";
					$rs = mysqli_query($conn,$sql);
				       while($row = mysqli_fetch_assoc($rs))
				       {
				       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
				       }
				       
				       $sql="select emp_id,emp_name,emp_mobile from emp_mst_od where ulbid='".$_SESSION['ulbid']."'";
					$rs = mysqli_query($conn,$sql);
				       while($row = mysqli_fetch_assoc($rs))
				       {
				       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
				       }
				       
				       $sql ="select * from dept_mst where ulbid='".$_SESSION['ulbid']."' order by dept_id";
	       
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }
				
				
				
				foreach($_POST['cs_id'] as $key=>$cs_id)
				{
				  $sql ="select * from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' and cs_type_id='2' and cs_id='".$cs_id."'";
		
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
				
				 $sql ="select * from ward_mst where ulbid='".$_SESSION['ulbid']."' and ward_id IN(select ward_id from emp_map where cs_id='".$cs_id."' and ulbid='".$_SESSION['ulbid']."' and cs_type_id='2' and street_id !=0) order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			       $ward_list2[$cs_id][$row['ward_id']]=$row['ward_desc'];
			       }
				   
				  $sql ="select * from street_mst where ulbid='".$_SESSION['ulbid']."' and street_id IN(select street_id from emp_map where cs_id='".$cs_id."' and ulbid='".$_SESSION['ulbid']."' and cs_type_id='2') order by ward_id";
			       $rs = mysqli_query($conn,$sql);
			       while($row = mysqli_fetch_assoc($rs))
			       {
			       $street_list2[$cs_id][$row['ward_id']][$row['street_id']]=$row['street_desc'];
			       }  
				   
				   
				  
			}
			
			
			
			
			
			
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
				 				$ward= split("-",strip_tags($_POST[$ward_id]));
				 				$street= split("-",strip_tags($_POST[$street_id]));
				 				
				 				if($street[0]==$_POST[$cs_id])
				 				{
							 					
							         $sql ="insert into emp_map(street_id,ward_id,emp_id,emp_id2,emp_id3,emp_id4,cs_id,dept_id,ulbid,cs_type_id,flag) values ('".$street[2]."','".$street[1]."','".strip_tags($_POST['emp_id'])."','".strip_tags($_POST['emp_id2'])."','".strip_tags($_POST['emp_id3'])."','".strip_tags($_POST['emp_id4'])."','".strip_tags($_POST[$cs_id])."','".strip_tags($_POST['dept_id'])."',  '".$_SESSION['ulbid']."','2','1') ON DUPLICATE KEY UPDATE flag='1',emp_id='".strip_tags($_POST['emp_id'])."',emp_id2='".strip_tags($_POST['emp_id2'])."',emp_id3='".strip_tags($_POST['emp_id3'])."',emp_id4='".strip_tags($_POST['emp_id4'])."',dept_id='".strip_tags($_POST['dept_id'])."'";
								  
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
					$tpl->assign('msg','Unable to update try again');
					}
					else{
					$tpl->assign('class','alert alert-success display-hide');
					$tpl->assign('msg','employees Mapped Successfully');
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
	      $sql ="select cs_id,cs_desc , dept_desc,telugu_description from standard_services c,standard_departments d  where c.section_id=d.dept_id and is_external_service='0'";
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $cs_list[$row['dept_desc']][$row['cs_id']]=$row['cs_desc']."(".$row['telugu_description'].")";
	       }
	       
	        $sql ="select * from dept_mst where ulbid='".$_SESSION['ulbid']."' order by dept_id";
	       
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }
		 $sql="select emp_id,emp_name,emp_mobile from emp_mst where  ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	       
	   $sql="select emp_id,emp_name,emp_mobile from emp_mst_od where  ulbid='".$_SESSION['ulbid']."'";
		  $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	        $sql="select emp_id,emp_name,emp_mobile from emp_mst where emp_dept='".$_REQUEST['dept_id']."'";
		$rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $emp_list2[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	        $sql ="select * from desg_mst where ulbid='".$_SESSION['ulbid']."'";
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $desg_list[$row['desg_id']]=$row['desg_desc'];
	       }
	      
	       $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	/*       
	 $sql="select cs.cs_desc,c.description,cu.cs_id from cs_mst cs,category_mst c,complaint_ulbmap cu where cs.cat_id=c.cat_id and cu.ulbid='".$_SESSION['ulbid']."'";
	       
	       $rs = mysqli_query($conn,$sql);
	       while($row = mysqli_fetch_assoc($rs))
	       {
	       $cs_list1[$row['cs_desc']]=$row['description'];
	       }
	       
	        //print_r($cs_list1);
	  
	  
	  */
	  
	  mysqli_close($conn);
	  $tpl->assign('user_type',$_SESSION['user_type']);
	       
	        $tpl->assign('cs_list1',$cs_list1);
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
		$tpl->display('edit_standard_service_emp_map.tpl');
		
		
		
	}
	else
	{
	header('location:index.php');
	}
	
?>	
	
	