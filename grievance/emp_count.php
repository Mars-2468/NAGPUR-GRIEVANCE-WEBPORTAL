<?phprequire "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
	 	$aptid1=$_POST['app_type_id'];
		$status1=$_POST['status'];
		$ulbid1=$_SESSION['ulbid'];
		$user_type1=$_SESSION['user_type'];
		$sla1=$_REQUEST['sla'];
		
		$fdate = date('Y-m-d',strtotime($_POST['f_date']));
        $tdate = date('Y-m-d',strtotime($_POST['t_date']));
		
		
	
	            
	             /*  if($_POST['status'] =='1')
	               {
	                  $sql ="SELECT cat3_id,grievance_status_id,grievance_id,app_type_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_desc,date_regd FROM 
	                  grievances where user_id LIKE '%".$_POST['employee']."%' and ulbid='".$_SESSION['ulbid']."' and cat3_id !='0' and app_type_id = 1 and 
	                  grievance_status_id ='".$_POST['status']."'"; 
	               }
	               else
	               {
	               */
	               
	               
	               
	               /*** resolved ***/
	               
	               if($_REQUEST['status'] == 1)
	               {
    	                 $sql ="SELECT g.cat3_id,g.grievance_status_id,g.grievance_id,g.app_type_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,
    	                g.comp_desc,g.date_regd,disposed_date,DATEDIFF(gt.disposed_date,g.date_regd) AS target FROM grievances g,grievances_transactions gt where 
    	                g.grievance_id=gt.grievance_id and user_id LIKE '%".$_REQUEST['emp_id']."%' and g.ulbid='".$_SESSION['ulbid']."' and cat3_id !='0' and 
    	                disposal_status !='5' and is_reopened_yn='0' and app_type_id = 1 and g.grievance_status_id  IN ('3','8','9')";
	               }  
	               
	               /*** under progress ***/
	               
	               else if($_REQUEST['status'] == 2)
	               {
    	                 $sql ="SELECT g.cat3_id,g.grievance_status_id,g.grievance_id,g.app_type_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,
    	                g.comp_desc,g.date_regd,disposed_date,DATEDIFF(gt.disposed_date,g.date_regd) AS target FROM grievances g,grievances_transactions gt where 
    	                g.grievance_id=gt.grievance_id and user_id LIKE '%".$_REQUEST['emp_id']."%' and g.ulbid='".$_SESSION['ulbid']."' and cat3_id !='0' and 
    	                disposal_status !='5' and is_reopened_yn='0' and app_type_id = 1 and g.grievance_status_id  IN ('2')";
	               }  
	               
	               
	               /*** fin implication ***/
	               
	               else if($_REQUEST['status'] == 3)
	               {
    	                 $sql ="SELECT g.cat3_id,g.grievance_status_id,g.grievance_id,g.app_type_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,
    	                g.comp_desc,g.date_regd,disposed_date,DATEDIFF(gt.disposed_date,g.date_regd) AS target FROM grievances g,grievances_transactions gt where 
    	                g.grievance_id=gt.grievance_id and user_id LIKE '%".$_REQUEST['emp_id']."%' and g.ulbid='".$_SESSION['ulbid']."' and cat3_id !='0' and 
    	                disposal_status !='5' and is_reopened_yn='0' and app_type_id = 1 and g.grievance_status_id  IN ('6')";
	               }  
	               
    	              
	     
	                /*** rejected ***/
	               
	               else if($_REQUEST['status'] == 5)
	               {
    	                 $sql ="SELECT g.cat3_id,g.grievance_status_id,g.grievance_id,g.app_type_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,
    	                g.comp_desc,g.date_regd,disposed_date,DATEDIFF(gt.disposed_date,g.date_regd) AS target FROM grievances g,grievances_transactions gt where 
    	                g.grievance_id=gt.grievance_id and user_id LIKE '%".$_REQUEST['emp_id']."%' and g.ulbid='".$_SESSION['ulbid']."' and cat3_id !='0' and 
    	                disposal_status !='5' and is_reopened_yn='0' and app_type_id = 1 and g.grievance_status_id  IN ('10')";
	               }       
	     
	     
	     
	                /*** unresolved ***/
	               
	               else if($_REQUEST['status'] == 6)
	               {
    	                 $sql ="SELECT g.cat3_id,g.grievance_status_id,g.grievance_id,g.app_type_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,
    	                g.comp_desc,g.date_regd,disposed_date,DATEDIFF(gt.disposed_date,g.date_regd) AS target FROM grievances g,grievances_transactions gt where 
    	                g.grievance_id=gt.grievance_id and user_id LIKE '%".$_REQUEST['emp_id']."%' and g.ulbid='".$_SESSION['ulbid']."' and cat3_id !='0' and 
    	                disposal_status !='5' and is_reopened_yn='0' and app_type_id = 1 and g.grievance_status_id  IN ('4')";
	               }   
	     
	     
	     
		
		$total_recordss=0;
		
		if($rs=mysqli_query($conn,$sql))
		{
			$field_info = mysqli_fetch_fields($rs);
			while($row = mysqli_fetch_assoc($rs))
			{
			
				
			
				
					foreach($field_info as $fi => $f) 
					{
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					
					}
					$total_recordss++;
			}
			
	
			
		}
		else
		echo mysqli_error($conn);
						
		$tpl->assign('total_recordss',$total_recordss);
		$tpl->assign('data',$data);



	
	
	
		

	  	$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id NOT IN('5','8','3')";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
			
			
			$sql="select cs_id,comp_desc from category3_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$service_list[$row['cs_id']]=$row['comp_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
		$sql="select cs_id,cs_desc from cs_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['cs_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
			
	//$sql="select user_id,user_name from users where ulbid= '".$_SESSION['ulbid']."' and user_id NOT IN ('Warangal_sc','mc_Warangal','Shruti_operator','Shailaja_operator')";
		
		
		$sql = "select g.user_id,u.* from grievances g , users u where u.user_id = g.user_id and u.user_type= 'E' and u.ulbid = '".$_SESSION['ulbid']."' and
		g.grievance_origin_id IN ('2','3','7') group by g.user_id";
		
		
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$emp_list[$row['user_id']]=$row['user_name'];
		}
		
	
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
	   
       
	
        		
        		
        		
        mysqli_close($conn);
        
        $tpl->assign('service_list',$service_list);
        $tpl->assign('app_type_sel',$_POST['app_type_id']);
        $tpl->assign('status_sel',$_POST['status']);
        $tpl->assign('emp_list',$emp_list);
        $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('emp',$_POST['employee']);
		$tpl->assign('fdate',$_POST['f_date']);
        $tpl->assign('tdate',$_POST['t_date']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('emp_count.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>