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
		include('prepare_connection.php');
		$conn=getconnection();
		
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
		
	
		
		
		$sql=$conn->prepare("select * from category_mst where ulbid=? order by description");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		  	$cat_list[$row['cat_id']]=$row['description'];  
		}
		$sql->close();
		
	
		$sql=$conn->prepare("select * from dept_mst where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		  	$dept_list[$row['dept_id']]=$row['dept_desc'];  
		}
	    $sql->close();
	    
	    
		
		if(isset($_POST['save']))
		{
		  $cutt_of_time=preg_replace('/^[0-9]+$/', ' ', $_POST['timeframe']);
		  $app_fee=preg_replace('/^[0-9]+$/', ' ', $_POST['app_fee']);
		   $fine_per_day=preg_replace('/^[0-9]+$//', ' ', $_POST['fine_per_day']);
		    $comp_desc=preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['comp_desc']);
		     $telugu_description=preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['telugu_description']);
		      $fee_desc=preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['fee_desc']);
		       $fee_type_id=preg_replace('/^[0-9]+$/', ' ', $_POST['fee_type_id']);
		        $sp_id=preg_replace('/^[0-9]+$/', ' ', $_POST['sp_id']);
		  
	
		    
  $sql ="update category3_mst set cutt_of_time=?,app_fee=?,fine_per_day=?,comp_desc=?,telugu_description=?,fee_desc=?,
  fee_type_id=?,sp_id=? where ulbid=? and cs_id=?";
  $query=$conn->prepare($sql);
  
 $query->bind_param("iiisssiisi", htmlspecialchars(strip_tags($_POST['timeframe'])),htmlspecialchars(strip_tags($_POST['app_fee'])),htmlspecialchars(strip_tags($_POST['fine_per_day'])),
 htmlspecialchars(strip_tags($_POST['comp_desc'])),htmlspecialchars(strip_tags($_POST['telugu_description'])),htmlspecialchars(strip_tags($_POST['fee_desc'])),htmlspecialchars(strip_tags($_POST['fee_type_id'])),htmlspecialchars(strip_tags($_POST['sp_id'])),
 htmlspecialchars(strip_tags($_SESSION['ulbid'])),htmlspecialchars(strip_tags($_POST['cs_id'])));
  $query->execute();		    
		    if($query->execute())
		    {
		    	$errors=0;
		    	$cs_id=htmlspecialchars(strip_tags($_POST['cs_id']));
		    	if($_POST['comp_type']=='2')
		    	{
		    		$tpl->assign('error_status',0);
		    		$check_doc_name=$_POST['check_doc_name'];
		    		
		    		 $sql ="delete from cs_doc_map where cs_id=?";
		    		 $query=$conn->prepare($sql);
		    		 $query->bind_param("i",$cs_id);
		    		 
                        
		    		 
		    		if($query->execute())
		    		{
			      		foreach($check_doc_name as $chk1)  
					{  
						$required="required".$chk1;
					 $sql="INSERT INTO cs_doc_map(cs_id,doc_id,mandatory_status,flag) VALUES (?,?,?,?)";
					 
					
		    		 $query=$conn->prepare($sql);
		    		 $query->bind_param("iisi",$cs_id,$chk1,$_POST[$required],1);
		    		 
					 
					 
					if($query->execute())
						{
						}
						else
						{
							$errors++;
						}
					} 
				}
				if($errors > 0)
				{
					$tpl->assign('error_status',1);
				}
				
		    	
		    	}
		    	else
		    	{
		    	$tpl->assign('error_status',0);
		    	}
		    }
		    else
		    {
		    $tpl->assign('error_status',1);
		    }

		}
		
		if(isset($_POST['update']) || isset($_POST['save']))
		{
		
			$sql="select * from category3_mst where ulbid=? and cs_id=? and cs_type_id=?";
			   $i=1;
			   
			   $query=$conn->prepare($sql);
		    		 $query->bind_param("sii",htmlspecialchars(strip_tags($_SESSION['ulbid'])),htmlspecialchars(strip_tags($_POST['cs_id'])),2);
			   
			   
			   $query->execute();
			   $rs=$query->get_result();
			   
			   $tot_row = $rs->num_rows;

				
					$field_info = $rs->fetch_fields();
					while($row = $rs->fetch_array())
					{
						
						foreach($field_info as $fi => $f) 
							$data[$f->name]=$row[$f->name];
							$i++;
					}
					$tpl->assign('data',$data);
			 
			 
			 
			 
			 $sql ="select cs_id,comp_desc from category3_mst where dept_id=? and cs_type_id=? and ulbid=?";
			 
			 $query=$conn->prepare($sql);
		     $query->bind_param("iis",htmlspecialchars(strip_tags($data['dept_id'])),2,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
			   
			   
			   $query->execute();
			   $rs=$query->get_result();
			 
			 
			while($row = $rs->fetch_array())
				{
				$cs_list[$row['cs_id']]=$row['comp_desc'];
				}
		 }
		 else
		 {
		 	header('location:update_services.php');
		 }
			
	
		
	$sql=$conn->prepare("select doc_id,doc_desc from doc_mst where ulbid=?");
	$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs=$sql->get_result();
	$field_info =$rs->fetch_fields();
	while($row = $rs->fetch_assoc())
	{
	    foreach($field_info as $fi => $f) 
	    $doc_list[$row['doc_id']][$f->name]=$row[$f->name];
	}
	$sql->close();	
		
		
	
		
		$sql=$conn->prepare("select doc_id,mandatory_status from cs_doc_map where cs_id=?");
		$sql->bind_param("i",htmlspecialchars(strip_tags($_POST['cs_id'])));
		$sql->execute();
		$rs=$sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		    	$checked[$row['doc_id']]="checked";
			    $required_status[$row['doc_id']]=$row['mandatory_status'];
		}
		$sql->close();
		
		
	
		
		
		$sql=$conn->prepare("select * from service_placed_mst");
		$sql->execute();
		$rs=$sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		 $sp_list[$row['sp_id']]=$row['sp_desc'];   
		}
		$sql->close();
		
		$tpl->assign('sp_list',$sp_list);
	
		$tpl->assign('required_status',$required_status);
		$tpl->assign('fee_type_list',array('1'=>'Fixed','2'=>'Variable'));
		$tpl->assign('mandatory_list',array('mytext'=>'Mandatory',''=>'Not Mandatory'));
		$tpl->assign('checked',$checked);	
		$tpl->assign('doc_list',$doc_list);	
		$tpl->assign('app_type',array('2'=>'Service'));		
		$tpl->assign('data',$data);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('sub_cat_list',$sub_cat_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('update_service_doc_map.tpl');
	}
	else
	{
		
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>