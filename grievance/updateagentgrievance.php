<?phprequire "config.php";
date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	if(isset($_SESSION['uid']) )
	{
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	

		$sql="select app_type_id,person_name,email,hno,address,ward_id,street_id,mobile,cat3_id,comp_desc,grievance_origin_id,grievance_status_id,date_regd,file_no,endorsement,mcat3_id from grievances where grievance_id='".$_POST['grievance_id']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			$field_info = mysqli_fetch_fields($rs);
			$row = mysqli_fetch_assoc($rs);
			foreach($field_info as $fi => $f) 
				$data1[$f->name]=$row[$f->name];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
			
			
			
		$sql ="select * from category3_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$cat3_list[$row['cs_id']]=$row['comp_desc'];
		}

		$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
			{
				$emp_list[$row['emp_id']]['emp_name']=$row['emp_name'];
				$emp_list[$row['emp_id']]['emp_dept']=$row['emp_dept'];
				$emp_list[$row['emp_id']]['emp_desg']=$row['emp_desg'];
				$emp_list[$row['emp_id']]['emp_mobile']=$row['emp_mobile'];
			}
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
		$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
			{
				$emp_list[$row['emp_id']]['emp_name']=$row['emp_name'];
				$emp_list[$row['emp_id']]['emp_dept']=$row['emp_dept'];
				$emp_list[$row['emp_id']]['emp_desg']=$row['emp_desg'];
				$emp_list[$row['emp_id']]['emp_mobile']=$row['emp_mobile'];
			}
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));


		if(isset($_POST['save']))
		{
		    if($_POST['rating_sub_options'] == '11')
		    {
		    $grievance_id = $_POST['grievance_id'];
		    $status = 13;
		    $sql ="update grievances set grievance_status_id='".$status."' where grievance_id='".$grievance_id."'";
		    if(mysqli_query($conn,$sql))
		    {
		        $sql ="insert into rating_mst(
		            grievance_id,
		            rating_no,
		            comment_desc,
		            sub_option_id,
		            user_id,
		            date
		            )values(
		                '".$grievance_id."',
		                '".$_POST['disposal_status']."',
		                '".$_POST['disposal_remarks']."',
		                '".$_POST['rating_sub_options']."',
		                '".$_SESSION['uid']."',
		                '".date('Y-m-d',strtotime($_POST['disposed_date']))."'
		                )";
		                
		                if(mysqli_query($conn,$sql))
		                {
		                    $_SESSION['message'] = 'Status updated successfully';
		                }
		                else
		                {
		                    $_SESSION['message'] = 'Error. Try again';
		                }
		                echo "<script>window.location='search_grievance.php';</script>";
		    }
		    }
		    else
		    {
		        $grievance_id = $_POST['grievance_id'];
		        $sql ="insert into rating_mst(
		            grievance_id,
		            rating_no,
		            comment_desc,
		            sub_option_id,
		            user_id,
		            date
		            )values(
		                '".$grievance_id."',
		                '".$_POST['disposal_status']."',
		                '".$_POST['disposal_remarks']."',
		                '".$_POST['rating_sub_options']."',
		                '".$_SESSION['uid']."',
		                '".date('Y-m-d',strtotime($_POST['disposed_date']))."'
		                )";
		                
		                if(mysqli_query($conn,$sql))
		                {
		                    $_SESSION['message'] = 'Status updated successfully';
		                }
		                else
		                {
		                    $_SESSION['message'] = 'Error. Try again';
		                }
		                echo "<script>window.location='search_grievance.php';</script>";
		    }
		    
		}
		

		$sql="select ward_id,ward_desc from ward_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
			
		$sql="select street_id,street_desc from street_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$street_list[$row['street_id']]=$row['street_desc'];
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

		$sql="select desg_id,desg_desc from desg_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$desg_list[$row['desg_id']]=$row['desg_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));




		$sql="select grievance_origin_id,grievance_origin_desc from grievance_origin_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
										

	

		if(isset($_POST['grievance_id']))
		{
		    $app_type_id=$_POST['app_type_id'];
			 $sql="select app_type_id,mcat3_id,cat3_id,app_type_id,person_name,email,hno,address,g.ward_id,ward_desc,g.street_id,street_desc,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id,date_regd from grievances g,ward_mst w,street_mst s where g.ward_id=w.ward_id and g.street_id=s.street_id and  grievance_id='".$_POST['grievance_id']."'";
			if($rs=mysqli_query($conn,$sql))
			{
				$field_info = mysqli_fetch_fields($rs);
				$row = mysqli_fetch_assoc($rs);
				foreach($field_info as $fi => $f) 
					$data1[$f->name]=$row[$f->name];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));

			  $sql="select transaction_id,grievance_status_id,gt.emp_id,emp_name,emp_mobile,dept_desc,desg_desc,alloted_date,disposed_date,disposal_status,disposal_remarks,app_type_id,rca,
			 ca from grievances g, grievances_transactions gt,emp_mst e,desg_mst d,dept_mst dm where  g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and e.emp_desg=d.desg_id and e.emp_dept=dm.dept_id and 
			 gt.grievance_id='".$_POST['grievance_id']."' and disposal_status IN('9','3','8') order by transaction_id";
			if($rs=mysqli_query($conn,$sql))
			{
				$transaction_id=0;
				while($row = mysqli_fetch_assoc($rs))
				{
					$data2[$row['transaction_id']]['emp_name']=$row['emp_name'];
					$data2[$row['transaction_id']]['emp_desg']=$row['desg_desc'];
					$data2[$row['transaction_id']]['emp_dept']=$row['dept_desc'];
					$data2[$row['transaction_id']]['emp_mobile']=$row['emp_mobile'];
					$data2[$row['transaction_id']]['alloted_date']=$row['alloted_date'];
					$data2[$row['transaction_id']]['disposed_date']=$row['disposed_date'];
					$data2[$row['transaction_id']]['disposal_status']=$row['disposal_status'];
					$data2[$row['transaction_id']]['disposal_remarks']=$row['disposal_remarks'];
					$data2[$row['transaction_id']]['grievance_status_id']=$row['grievance_status_id'];
					$data2[$row['transaction_id']]['rca']=$row['rca'];
					$data2[$row['transaction_id']]['ca']=$row['ca'];
					$transaction_id=$row['transaction_id'];
					
				}
				$tpl->assign('data2',$data2);
				$tpl->assign('transaction_id',$transaction_id);
			}
			$tpl->assign('grievance_id',$_POST['grievance_id']);		
			$tpl->assign('data1',$data1);
			

			if($app_type_id=='1')
			{
			    /*$sql_status="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('2','9','4','5','6','10')";
		        $sql ="select grievance_status_id from grievances where grievance_id='".$_POST['grievance_id']."'";
		        $rs = mysqli_query($conn,$sql);
		        $row = mysqli_fetch_assoc($rs);
		        $status=$row['grievance_status_id'];
		        if($status=='11')
		        {*/
		            $sql_status="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('13')";
		            $sql_status2="select grievance_status_id,grievance_status_desc from grievance_status_mst";
		        /*}*/
		        
		 
		 	$sql ="select cs_id,cs_desc as comp_desc from cs_mst";
		 
			}
			else
			{
			 $sql_status="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('2','5','9','10')";
		//	$sql ="select cs_id,comp_desc from category3_mst where ulbid='".$_SESSION['ulbid']."'";
		$sql ="select cs_id, cs_desc as comp_desc from standard_services";
			}
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			$cs_list[$row['cs_id']]=$row['comp_desc'];
			}
			$tpl->assign('cs_list',$cs_list);
            

           
    		if($rs=mysqli_query($conn,$sql_status))
    		{
    			while($row = mysqli_fetch_assoc($rs))
    				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
    		}
    		else
    			printf("Errormessage: %s\n", mysqli_error($conn));
    			
    			if($rs=mysqli_query($conn,$sql_status2))
    		{
    			while($row = mysqli_fetch_assoc($rs))
    				$grievance_status_list2[$row['grievance_status_id']]=$row['grievance_status_desc'];
    		}
    		else
    			printf("Errormessage: %s\n", mysqli_error($conn));
    			
    			$sql ="SELECT * FROM `feedback_sub_options`";
    				if($rs=mysqli_query($conn,$sql))
            		{
            			while($row = mysqli_fetch_assoc($rs))
            				$rating_suboptions_list[$row['sub_option_id']]=$row['description'];
            		}
            		else
            			printf("Errormessage: %s\n", mysqli_error($conn));
    
    
    
    
    		}
    		
    	


		mysqli_free_result($rs);
		mysqli_close($conn);
		
		
		
		$tpl->assign('rating_status_list',array('1'=>1,'2'=>'2','3'=>'3','4'=>'4','5'=>'5'));
		$tpl->assign('rating_suboptions_list',$rating_suboptions_list);
		$tpl->assign('app_type_id',$_POST['app_type_id']);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('street_list',$street_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);				
		$tpl->assign('grievance_status_list2',$grievance_status_list2);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('main_icons',$obj->main_icons);
        $tpl->assign('banner',$_SESSION['banner']);
        $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('updateagentgrievance.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>