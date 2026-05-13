<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
	    	
	$_REQUEST['emp_id']=117;
	
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
		
		
		$app_type_id=$_REQUEST['app_type_id'];
		$emp_id=$_REQUEST['emp_id'];
        $status=$_REQUEST['status'];
	    $dept_id=$_REQUEST['dept_id'];
	    
	    
	    $tpl->assign('app_type_id',$app_type_id);
	    $tpl->assign('emp_id',$emp_id);
	    $tpl->assign('status',$status);
	    $tpl->assign('dept_id',$dept_id);
	    
	    
	    if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		 {
    		$fdate = date('Y-m-d',strtotime($_REQUEST['f_date']));
    		$tdate = date('Y-m-d',strtotime($_REQUEST['t_date']));
    	
		 }
	
	
	
        if($_REQUEST['app_type_id']==1)
        {
            $table="cs_mst";
            $fieldName="c.cs_desc";
        }
        else
        {
            $table="standard_services";
            $fieldName="c.cs_desc";
        }
	
		
		
		
		
		
		
		      $sql ="select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='".$_SESSION['ulbid']."' and 
		      g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5'  and gt.emp_id='".$_REQUEST['emp_id']."' and cat3_id !='0' and ward_id='32' and sla_status='1' and is_escalated='1' ";
		      
		      
		      
		      $sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
		      g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5'  and gt.emp_id='".$_REQUEST['emp_id']."' and cat3_id !='0' and ward_id='32' and sla_status='1' and is_escalated='1' ";
	                     
        			         if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
            			        {
            			            
            			            $sql.="and date(date_regd) between '".$_REQUEST['f_date']."' and '".$_REQUEST['t_date']."' ";
            			            $sqlExcel.="and date(date_regd) between '".$_REQUEST['f_date']."' and '".$_REQUEST['t_date']."' ";
            			        }
            			        
            			        
        			          
        			          
        			          
        			          
	    
		
		
          
         
		
	
		  
		  
		  
		  
		  
		  echo $sql;
		  
		  
		  
		 	$rs = mysqli_query($conn,$sql);
		$field_info = mysqli_fetch_fields($rs); 
		  	while($row= mysqli_fetch_assoc($rs))
		{
		     foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 
		}
		  
		  //pagination end
		  
			
         $sql="select cs_id,cs_desc as comp_desc from standard_services";
		
		if($_REQUEST['app_type_id']=='1')
		{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		}
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
		
		$sql="select * from emp_mst";
		
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$emp_list[$row['emp_id']]=$row['emp_name'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
             
		 
	



		
	              	$sql="select dept_id,dept_desc from dept_mst where ulbid='".$_SESSION['ulbid']."'";
			if($rs=mysqli_query($conn,$sql))
			{
				while($row = mysqli_fetch_assoc($rs))
					$dept_list[$row['dept_id']]=$row['dept_desc'];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
			
			
			$sql="select * from grievance_status_mst";
			if($rs=mysqli_query($conn,$sql))
			{
				while($row = mysqli_fetch_assoc($rs))
					$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
				
				$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		mysqli_close($conn);
		
    	//	print_r($online_applications);
		$tpl->assign('dept_id_sel',$_REQUEST['dept_id']);
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('firstNumber',$start);
    	$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('fdate',$_POST['f_date']);
        $tpl->assign('tdate',$_POST['t_date']);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('reference_no',$_POST['reference_no']);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('status_list',$status_list);
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);		
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('user_dept',$_SESSION['user_dept']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('mc_yn',$_SESSION['mc_yn']);
		$tpl->assign('is_hod',$_SESSION['is_hod']);
		$tpl->assign('is_level4_emp',$_SESSION['is_level4_emp']);
		$tpl->display('comp_det1.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>	