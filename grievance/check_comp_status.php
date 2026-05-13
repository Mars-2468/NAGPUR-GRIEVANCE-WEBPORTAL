<?php
require "config.php";
	ini_set('display_errors',0);
	
	if(!isset($_SESSION['login_status']) && $_SESSION['login_status'] != 1){
	    $indexpage="complaint_form.php";
			 //header("location:$indexpage");
		echo "<script>window.location='$indexpage';</script>";
	}
	
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	require_once('connection.php');
	$conn=getconnection();
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
    // 	echo $_SESSION['login_status'];
    // 	echo $_SESSION['com_reg_mobile'];
    // 	die();
	
	$search_fields=$_POST;
	//echo "<pre>";print_r($search_fields['mobile']);echo "</pre>";die();
	
	if($_SESSION['login_status'] == 1){
	    if(isset($_REQUEST['id']) || isset($_POST['ulbid']))
    	{
    	    
    	
    		if(isset($_REQUEST['id'])){
    		    $ulbid=$_REQUEST['id'];
    		}
    		if(isset($_POST['ulbid'])){
    		    $ulbid=$_POST['ulbid'];
    		}
    		if($_SESSION['login_status']){
    		    $ulbid=$_SESSION['ulbid'];
    		}
    		
    		
    		
    		
    		$sql="select open_comp_banner from users where ulbid='".$ulbid."'";
    		$rs=mysqli_query($conn,$sql);
    		$row = mysqli_fetch_assoc($rs);
    		$banner=$row['open_comp_banner'];
    		
    		if($banner =='')
    		{
    		    $banner="images/complaint_form_streetvendors.png";
    		}
    		
    		if(isset($_POST['save']) || $_SESSION['login_status'] == 1)
    		{
    		  //  die('testing');
    			if($_POST['from_date']=='') $from_date='0000-00-00';
    			if($_POST['to_date']=='') $to_date=date('Y-m-d', time()+86400);
    			
    			 $sql="select feedback_status,grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id,date_regd from grievances where mobile='".$_SESSION['com_reg_mobile']."' and person_name like '%".strip_tags($_POST['person_name'])."%' and mobile like '%".strip_tags($_POST['mobile'])."%' and street_id like '%".strip_tags($_POST['street_id'])."%' and grievance_status_id like '%".strip_tags($_POST['grievance_status_id'])."%' and grievance_id like '%".strip_tags($_POST['grievance_id'])."%' and date_regd between '".$from_date."' and '".$to_date."' and ulbid like '%".$ulbid."%' and ulbid like '%".strip_tags($_POST['ulbid'])."%' and app_type_id='1' order by grievance_id desc";
    		
                // 	echo $sql;
                // 	die('testing');
    			if($rs=mysqli_query($conn,$sql))
    			{
    				$field_info = mysqli_fetch_fields($rs);
    				while($row = mysqli_fetch_assoc($rs))
    				{
    					foreach($field_info as $fi => $f) 
    						$data[$row['grievance_id']][$f->name]=$row[$f->name];
    				}
    				
    			}
    			else
    				printf("Errormessage: %s\n", mysqli_error($conn));	
    						
    			$num_comp=mysqli_num_rows($rs);
    			$tpl->assign('data',$data);
    			$tpl->assign('num_comp',$num_comp);
    			if($num_comp==0)
    				$tpl->assign('msg','No details found matching your search');
    		}
    
    		$sql="select ward_id,ward_desc from ward_mst where ulbid='".$ulbid."'";
    		if($rs=mysqli_query($conn,$sql))
    		{
    			while($row = mysqli_fetch_assoc($rs))
    				$ward_list[$row['ward_id']]=$row['ward_desc'];
    		}
    		else
    			printf("Errormessage: %s\n", mysqli_error($conn));
    			
    			
    		$sql="select street_id,street_desc from street_mst where ulbid='".$ulbid."' order by street_desc";
    		if($rs=mysqli_query($conn,$sql))
    		{
    			while($row = mysqli_fetch_assoc($rs))
    				$street_list[$row['street_id']]=$row['street_desc'];
    		}	
    
    		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
    		if($rs=mysqli_query($conn,$sql))
    		{
    			while($row = mysqli_fetch_assoc($rs))
    				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
    		}
    		else
    			printf("Errormessage: %s\n", mysqli_error($conn));
    		mysqli_close($conn);
    		$tpl->assign('ulbid',$ulbid);
    		$tpl->assign('search_fields',$search_fields);	
    		$tpl->assign('banner',$banner);	
    		$tpl->assign('street_list',$street_list);	
    		$tpl->assign('ward_list',$ward_list);
    		$tpl->assign('grievance_status_list',$grievance_status_list);
    		$tpl->display('check_comp_status.tpl');
    		}
    	else
    	{
    	    header('check_comp_status.php?id=250');
    	}
	}
	

?>