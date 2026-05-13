<?phprequire "config.php";
//include('responsible_sms.php');

	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();
	 
	
	
	//require_once('sms_conf.php');
	//require_once('send_sms.php');	
	
	//echo "hi";
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		if($_SESSION['user_type']=='E')
			{
    			$sql ="select emp_id3 from emp_map where emp_id3='".$_SESSION['emp_id']."' group by emp_id3";
    			$rs2 = mysqli_query($conn,$sql);
    			$nr2= mysqli_num_rows($rs2);
    			if($nr2 > 0)
    			{
    			   $tpl->assign('hod_status',1);
    			   $_SESSION['hod_status']=1;
    			}
    			else
    			{
    			    $tpl->assign('hod_status',0);
    			    $_SESSION['hod_status']=0;
    			}
    			
    			
    			$sql ="select emp_dept,emp_desg from emp_mst where emp_id='".$_SESSION['emp_id']."'";
    			$rs = mysqli_query($conn,$sql);
    			$row = mysqli_fetch_assoc($rs);
    			$desg_id=$row['emp_desg'];
    			
    			$sql ="select desg_id,dept_id from hod_mst where desg_id='".$desg_id."'";
    			$rs = mysqli_query($conn,$sql);
    			$nr = mysqli_num_rows($rs);
    			
    			if($nr > 0)
    			{
    			    $row= mysqli_fetch_assoc($rs);
    			    $tpl->assign('hod_status2',1);
    			    $_SESSION['hod_status2']=1;
    			    $_SESSION['dept_id']=$row['dept_id'];
    			}
    			else
    			{
    			   
    			    $tpl->assign('hod_status2',0);
    			    $_SESSION['hod_status2']=0;
    		
    			}
    			
    			
    			
    			
			}
		
	
	
		
		
	
		
		/** counting total services **/
		
		$sql ="select count(cs_id) total_services,cs_type_id from category3_mst where ulbid='".$_SESSION['ulbid']."' group by cs_type_id";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map[$row['cs_type_id']]['total_services']=$row['total_services'];
		}
		
		/** assigned services **/
		
		$sql ="select count(cs_id) total_services_mapped,cs_type_id from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_id IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' and cs_type_id='2' group by cs_id) group by cs_type_id";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map[$row['cs_type_id']]['total_services_mapped']=$row['total_services_mapped'];
		}
		
		/**/
		
		/** services not assigned **/
		$sql ="select count(cs_id) total_services_not_mapped,cs_type_id from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_id NOT IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' group by cs_id) group by cs_type_id";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map[$row['cs_type_id']]['total_services_not_mapped']=$row['total_services_not_mapped'];
		}
		/**/
		
		/** tanker reports **/
		
		 $sql="SELECT count(req_id) as count ,status FROM tanker_req where ulbid='".$_SESSION['ulbid']."' group by  status"; 
	                        $rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $tankertot+=$row['count'];
					 $tankers_list[$row['status']]=$row['count'];
				}
				
				
				$tpl->assign('tankers_list',$tankers_list);
				$tpl->assign('tankertot',$tankertot);
		
		/**/
		
		/** checking tanker request status enabled or disabled **/
		$sql ="select enable_status from tanker_enable_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		$tanker_enable_status=$row['enable_status'];
		
		/**/
		
		
				
	 $sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql ="select COUNT(id) as feedback_count from `smart_idea_box` sib,ulbmst u,Districtmst d where u.ulbid=sib.ulbid and u.distid=d.distid  and sib.ulbid like '%".$_SESSION['ulbid']."%'";
		
		if($_SESSION['user_type']=='R')
		{
		    $sql.=" and d.rdma='".$_SESSION['uid']."'";
		}
		
		$rs = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		$feedback_count=$row['feedback_count'];
		
	//	print_r($online_applications);
	
	
		/*************** complaints *****************/
		
		$sql ="select count(cs_id) total_services from complaint_ulbmap where ulbid='".$_SESSION['ulbid']."'";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map['total_complaints']=$row['total_services'];
		}
		
		/** complaints not assigned **/
		$sql ="select count(cs_id) total_services_not_mapped from complaint_ulbmap where ulbid='".$_SESSION['ulbid']."' and cs_id NOT IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' and  cs_type_id='1' group by cs_id)";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map['total_complaints_not_mapped']=$row['total_services_not_mapped'];
		}
		
			/** assigned complaints **/
		
		$sql ="select count(cs_id) total_services_mapped from complaint_ulbmap where ulbid='".$_SESSION['ulbid']."' and cs_id IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' and cs_type_id='1' group by cs_id)";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map['total_complaints_mapped']=$row['total_services_mapped'];
		}
		
		/**/
	
	
	 
	       $sql="select * from ulb_posters where ulbid = '".$_SESSION['ulbid']."' ";
	      $rs = mysqli_query($conn,$sql);
	      while($row = mysqli_fetch_assoc($rs))
	      {
	          $pic= $row['image'];
	      }	
	
	      
	      
	      $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	      
	        $sql ="select description , cat_id from category_mst where cs_type_id='1'";
    		$rs = mysqli_query($conn,$sql);
    		while($row = mysqli_fetch_assoc($rs))
    		{
    		    $catList[$row['cat_id']] = $row['description'];
    		}
	      
	      
	      
	      
	      
	      
	      mysqli_close($conn);
	      
	      
	   $tpl->assign('users_count',$users_count);
	   
	    $tpl->assign('selCatid',4);
	    $tpl->assign('catList',$catList);
	    $tpl->assign('ulb',$_SESSION['ulbid']);
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('feedback_count',$feedback_count);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('tot_complaints',$tot_complaints);
		$tpl->assign('res_complaints',$res_complaints);
		$tpl->assign('res_services',$res_services);
		$tpl->assign('datalist',$datalist);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('origin_rep',$origin_rep);
		$tpl->assign('origin_list',$origin_list);

		$tpl->assign('tanker_enable_status',$tanker_enable_status);
		$tpl->assign('map',$map);
		$tpl->assign('pic',$pic);
		$tpl->assign('data',$data);
		$tpl->assign('data1',$data1);
		
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('categorywisereport.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
	
	
?>
                            
                            
                            
                            
                            
                            