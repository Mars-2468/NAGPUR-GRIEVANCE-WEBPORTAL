<?phprequire "config.php";
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
		
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
		if($_REQUEST['cs_type_id']==2)
		{

        		if($_REQUEST['code']==0)
        		{
        		 $sql ="select * from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_type_id='".$_REQUEST['cs_type_id']."'";
        		 $sql2="select cs_id from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_id IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' group by cs_id) and cs_type_id='".$_REQUEST['cs_type_id']."'";
        		 
        		 $rs = mysqli_query($conn,$sql2);
        		 while($row = mysqli_fetch_assoc($rs))
        		 {
        		 $cs_list[$row['cs_id']]=$row['cs_id'];
        		 }
        		 
        		}
        		else if($_REQUEST['code']==1)
        		{
        		 $sql="select * from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_id IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' group by cs_id) and cs_type_id='".$_REQUEST['cs_type_id']."'";
        		}
        		else if($_REQUEST['code']==2)
        		{
        		$sql="select * from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_id NOT IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' group by cs_id) and cs_type_id='".$_REQUEST['cs_type_id']."'";
        		}
		}
		
		if($_REQUEST['cs_type_id']==1)
		{

        		if($_REQUEST['code']==0)
        		{
        		 $sql ="select c.cs_id,cs_desc as comp_desc,cutt_off_time as cutt_of_time,c.cat_id as dept_id,c.telugu_description from complaint_ulbmap cu, cs_mst c ,comp_cutofdays_map ccm where c.cs_id=cu.cs_id and cu.cs_id=ccm.cs_id and ulbid='".$_SESSION['ulbid']."' and cu.cs_type_id='".$_REQUEST['cs_type_id']."'";
        		 
        		 
        		 $rs = mysqli_query($conn,$sql2);
        		 while($row = mysqli_fetch_assoc($rs))
        		 {
        		 $cs_list[$row['cs_id']]=$row['cs_id'];
        		 }
        		 
        		}
        		else if($_REQUEST['code']==1)
        		{
        		 //$sql="select * from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_id IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' group by cs_id) and cs_type_id='".$_REQUEST['cs_type_id']."'";
        		 $sql ="select c.cs_id,cs_desc as comp_desc,cutt_off_time as cutt_of_time,c.cat_id as dept_id,c.telugu_description from complaint_ulbmap cu, cs_mst c ,comp_cutofdays_map ccm where c.cs_id=cu.cs_id and cu.cs_id=ccm.cs_id and ulbid='".$_SESSION['ulbid']."' and cu.cs_id IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' and cs_type_id='1' group by cs_id)";
        		}
        		else if($_REQUEST['code']==2)
        		{
        		$sql ="select c.cs_id,cs_desc as comp_desc,cutt_off_time as cutt_of_time,c.cat_id as dept_id,c.telugu_description from complaint_ulbmap cu, cs_mst c ,comp_cutofdays_map ccm where c.cs_id=cu.cs_id and cu.cs_id=ccm.cs_id and ulbid='".$_SESSION['ulbid']."' and cu.cs_id NOT IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' and cs_type_id='1' group by cs_id)";
        		}
		}
		
		
		
		if($rs=mysqli_query($conn,$sql))
		{
			$field_info = mysqli_fetch_fields($rs);
			while($row = mysqli_fetch_assoc($rs))
			{
				if(in_array($row['cs_id'],$cs_list))
				{
					$update_code[$row['cs_id']]=1;
				}
				else
				{
				$update_code[$row['cs_id']]=0;
				}
				foreach($field_info as $fi => $f) 
					$data[$row['cs_id']][$f->name]=$row[$f->name];
			}
			
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
						
		
		$tpl->assign('data',$data);



		$sql="select ward_id,ward_desc from ward_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	

		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
        if($_REQUEST['cs_type_id']=='2')
        {
		$sql="select dept_id,dept_desc from dept_mst";
        }
        else
        {
            $sql="select cat_id as dept_id,description as dept_desc from category_mst";
        }
        
        
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
					
		$tpl->assign('dept_list',$dept_list);
		
		$sql="select cs_id,comp_desc from category3_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
		
		mysqli_close($conn);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('sec_level',$_SESSION['sec_level']);			
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('update_code',$update_code);
		$tpl->assign('code',$_REQUEST['code']);
		$tpl->assign('cs_type_id',$_REQUEST['cs_type_id']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('statistics.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>