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
		$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		$sql ="select * from category_mst where cs_type_id='1' order by cat_id";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
			$cat_list[$row['cat_id']]=$row['description'];
			$cat_list2[$row['cat_id']]=$row['telugu_description'];
		}
		//print_r($cat_list);

		$sql ="select * from subcategory_mst where status='1' order by sub_cat_id";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
			$sub_cat_list[$row['sub_cat_id']]=$row['description'];
			// $data[$row['cat_id']][$row['cs_id']]['cs_desc']=$row['cs_desc'];
			$sub_cat_list2[$row['cat_id']][$row['sub_cat_id']]['sub_cat_desc']=$row['description'];
		}
		// print_r($sub_cat_list2);

		$sql ="select * from dept_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
			$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		
		$sql ="select * from cs_mst where cs_type_id='1'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
			$comp_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		$tpl->assign('dept_list',$dept_list);
		
		if(isset($_POST['save']))
		{
		
				$count=$_POST['cnt'];
				$sql ="delete from complaint_ulbmap where ulbid='".$_SESSION['ulbid']."'";
				mysqli_query($conn,$sql);

		      		  
					 $file_count=$_POST['cnt'];


							for($i=0;$i<=$file_count;$i++)
							{
								 $cs_id="cs_id".$i;
								 $_POST[$cs_id];
									if($_POST[$cs_id]==0)
									{
										
									}
									else{
									
									 $value=explode("-",$_POST[$cs_id]);
									 
									 $sql2 ="update cs_mst set cat_id='".$value[1]."' , sub_cat_id='".$value[2]."' where cs_id='".$value[0]."'";
									 //mysqli_query($conn,$sql2);
								
								$sql="INSERT INTO complaint_ulbmap(cs_id,cat_id,flag,ulbid,sub_cat_id,cs_type_id ) VALUES ('".$value[0]."','$value[1]','1','".$_SESSION['ulbid']."','".$value[2]."','1')";

								 	// echo $_POST[$cs_id]; exit();
					  mysqli_query($conn,$sql);
									}
							}
					
					 
					
				
				
				if($errors > 0)
				{
					$tpl->assign('error_status',1);
				}
				
				foreach($comp_list as $cs_id=>$cs_desc)
			{
				 $var="cs_id".$cs_id;
				 $_POST[$var];
				$arr=explode("-",$_POST[$var]);
				if(array_key_exists($var, $_POST))
				{
						
						
					  $sql="INSERT INTO complaint_ulbmap(cs_id,cat_id,flag,ulbid,cs_type_id,sub_cat_id) values('".$arr[0]."','".$arr[1]."','1','".$_SESSION['ulbid']."','1','".$arr[1]."') ON DUPLICATE KEY UPDATE flag='1'";	
				}
				else
				{
					 $sql="INSERT INTO complaint_ulbmap(cs_id,cat_id,flag,ulbid,cs_type_id,sub_cat_id) values('".$cs_id."','".$arr[1]."','0','".$_SESSION['ulbid']."','1','".$arr[1]."') ON DUPLICATE KEY UPDATE flag='0'";
				}
				
				if(mysqli_query($conn,$sql))
				{
					$tpl->assign('class','alert alert-success display-hide');
					$tpl->assign('msg','Successfully Updated');
					}
				else
				{
					$tpl->assign('msg','alert alert-danger display-hide');
					$tpl->assign('msg','Unable to Update');
					}
			}		
	
		}
		
		
		
		$sql="select * from cs_mst where cs_type_id='1'";
		   $i=1;
		   $rs=mysqli_query($conn,$sql);
		   $tot_row=mysqli_num_rows($rs);
		   if(mysqli_num_rows($rs)>0)
			{
			
				//$field_info = mysqli_fetch_fields($rs);
				while($row = mysqli_fetch_assoc($rs))
				{
					
					
						$data[$row['sub_cat_id']][$row['cs_id']]['cs_desc']=$row['cs_desc'];
						$datatel[$row['sub_cat_id']][$row['cs_id']]['cs_desc']=$row['telugu_description'];

					// $data[$row['sub_cat_id']][$row['cat_id']][$row['cs_id']]['cs_desc']=$row['cs_desc'];
					// $datatel[$row['sub_cat_id']][$row['cat_id']][$row['cs_id']]['cs_desc']=$row['telugu_description'];
						$i++;
				}
				// print_r($data);
				$tpl->assign('data',$data);
		 }
		 
		 $sql ="select * from complaint_ulbmap where ulbid='".$_SESSION['ulbid']."' and cs_type_id='1'";
		 $rs=mysqli_query($conn,$sql);
		 while($row = mysqli_fetch_assoc($rs))
				{
				//$comp_list[$row['cs_id']]=$row['cs_id'];
				
					$var="cs_id".$row['cs_id'];
					$comp_list[$var]=$row['flag'];
				}
		 
		/* echo "<pre>";
		 print_r($comp_list);
		 echo "</pre>";*/
			
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
		
	//	print_r($online_applications);
	
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
		
		//print_r($cat_list);

		mysqli_close($conn);
		$tpl->assign('comp_list',$comp_list);	
		$tpl->assign('doc_list',$doc_list);	
		$tpl->assign('app_type',array('1'=>'Complaint','2'=>'Service'));		
		$tpl->assign('data',$data);
		$tpl->assign('datatel',$datatel);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('cat_list2',$cat_list2);
		$tpl->assign('sub_cat_list',$sub_cat_list);
		$tpl->assign('sub_cat_list2',$sub_cat_list2);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('map-cat.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>