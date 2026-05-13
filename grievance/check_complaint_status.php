<?php
    //session_start();
	ini_set('display_errors',0);
	

	require_once('Smarty.class.php');
	$tpl=new Smarty();
	require_once('citizen_connection.php');
	$conn=getcitizenconnection();
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
  


	    if(true)
    	{
    	   
    		$ulbid=$_POST['ulbid'];
    		    		
    		$sql="select open_comp_banner from users where ulbid='".$ulbid."'";
    		$rs=mysqli_query($conn,$sql);
    		$row = mysqli_fetch_assoc($rs);
    		$banner=$row['open_comp_banner'];
    		
    		if($banner =='')
    		{
    		    $banner="images/complaint_form_streetvendors.png";
    		}
    		
			//echo"<pre>";print_r(count($_POST));echo"</pre>";die();
			
    		if(isset($_POST['save']))
    		{
				
				
				
    		  //  die('testing');
    			$from_date =!empty($_POST['from_date'])? date('Y-m-d', strtotime($_POST['from_date'])):'';
				$to_date =!empty($_POST['to_date'])? date('Y-m-d', strtotime($_POST['to_date'])):'';	
    			
    			 $sql="select feedback_status,grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id,date_regd from grievances where app_type_id='1' ";
    		
			
				if(!empty($_POST['person_name'])){
					$sql.=" and person_name like '%".strip_tags($_POST['person_name'])."%' ";
				}
						
				if(!empty($_POST['mobile'])){
					$sql.=" and mobile like '%".strip_tags($_POST['mobile'])."%' ";
				}
				
				//echo"<pre>";print_r(!empty($_POST['grievance_status_id']));echo"</pre>";die();
				
				if(!empty($_POST['grievance_id'])){
					$sql.=" and grievance_id=". $_POST['grievance_id'] ." ";
				}
				
				
				if(!empty($_POST['grievance_id'])){
					$sql.=" and grievance_id=".strip_tags($_POST['grievance_id'])." ";
				}	
				
				if(!empty($_POST['grievance_status_id'])){
					$sql.=" and grievance_status_id='".strip_tags($_POST['grievance_status_id'])."' ";
				} 
				
				if(!empty($from_date) && !empty($to_date)){
					$sql.=" and date_format(date_regd,'%Y-%m-%d') between '".$from_date."' and '".$to_date."' ";
				}
				
				$sql.="  order by grievance_id desc";	
			
			
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
    						
				//echo "<pre>";print_r($data);echo "</pre>";die();
    			
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
    		$tpl->assign('banner',$banner);	
    		$tpl->assign('street_list',$street_list);	
    		$tpl->assign('grievance_id',$_POST['grievance_id']);	
    		$tpl->assign('grievance_status_id',$_POST['grievance_status_id']);	
    		$tpl->assign('mobile',!empty($_POST['mobile'])?$_POST['mobile']:'');	
    		$tpl->assign('person_name',$_POST['person_name']);	
    		$tpl->assign('from_date',$_POST['from_date']);	
    		$tpl->assign('to_date',$_POST['to_date']);	
    		$tpl->assign('ward_list',$ward_list);
    		$tpl->assign('grievance_status_list',$grievance_status_list);
    		$tpl->display('check_complaint_status.tpl');
    	}else{
    	    header('check_complaint_status.php?id=250');
    	}
	
	

?>