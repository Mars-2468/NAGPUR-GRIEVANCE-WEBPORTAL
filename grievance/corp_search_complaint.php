<?php
    require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	
	ini_set('display_errors',0);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		//include('prepare_connection.php');
		
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
	    if(isset($_POST['search']))
	    {
			//$_POST['ref_no']='xys';
			if(!validateField($_POST['ref_no'], 'dnumber')){
				$class = "alert alert-danger display-hide";
				$msg="Not a vlid grievance id";
				set_flash($msg,$class);
				header('Location: search_complaint.php');
				exit;			
			}	
			
    		$sql="select g.grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,
    		  g.comp_desc,grievance_origin_id,grievance_status_id,date_regd,cat3_id,file_no,app_type_id,emp_id,dept_id 
    		  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.grievance_id=?
    		  and ulbid=?";
    		$query = $conn->prepare($sql);
    		$grievance_id =$_POST['ref_no'];
    		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    		$query->bind_param("is",$grievance_id,$ulbid);
    		$query->execute();
    		$rs = $query->get_result();
    		if($rs->num_rows > 0 )
    		{
    			$field_info = $rs->fetch_fields();
    			while($row =  $rs->fetch_assoc())
    			{
    				foreach($field_info as $fi => $f) 
    					$data[$row['grievance_id']][$f->name]=$row[$f->name];
    			}
    			
    		}
    		else
    		{
    		    $tpl->assign('msg','Record not found');
    		}
    
	    }
			
		$sql=$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		  	$ward_list[$row['ward_id']]=$row['ward_desc'];  
		}
		
		$sql=$conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=?");
		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
		
		if($_SESSION['user_type']=='E')
		{
		    
		    $sql=$conn->prepare("select dept_id,dept_desc from dept_mst dm, emp_mst e  where e.emp_dept=dm.dept_id and e.emp_id=?");
		    $emp_id = htmlspecialchars(strip_tags($_SESSION['emp_id']));
		    $sql->bind_param("i",$emp_id);
		}
		
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		  	$dept_list[$row['dept_id']]=$row['dept_desc'];
		}	
			
		if($_POST['app_type_id'] == '1'){        		   
			
			$sql=$conn->prepare("select cs_id,cs_desc as comp_desc,m.description from cs_mst cm,grievances g,category_mst m where
			g.cat3_id=cm.cs_id and cm.cat_id=m.cat_id and g.app_type_id=? and 
			g.ulbid=? group by g.cat3_id");
			
			$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			$app_type_id = $_POST['app_type_id'];
			$sql->bind_param("is",$app_type_id,$ulbid);
			
		}
		else
		{
		   
		   $sql=$conn->prepare("select cs_id,cm.comp_desc from category3_mst cm,grievances g where 
			g.cat3_id=cm.cs_id and g.ulbid=? group by g.cat3_id");
				
			$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			$sql->bind_param("s",$ulbid);
			
		}
		
		if($sql->execute())
		{
			$rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
			{
				 if($row['description'] !='')
						   {
							  
							   $string="(".$row['description'].")";
							  
						   }
						   else
						   {
							   $string=$row['description']='';
						   }
				$list[$row['cs_id']]=$row['comp_desc'].$string;
			}
		}
			
		$sql=$conn->prepare("select grievance_origin_id,grievance_origin_desc from grievance_origin_mst");
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
					
		$sql = $conn->prepare("select grievance_status_id,grievance_status_desc from grievance_status_mst");
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
		$sql =$conn->prepare("select * from category3_mst where ulbid=?");
		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   $cat3_list[$row['cs_id']]=$row['comp_desc']; 
		}
		
		$sql = $conn->prepare("select cs_id,cs_desc as comp_desc from cs_mst");
		$sql->execute();
		$rs =$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		
        $sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where ulbid=?");
        $sql->bind_param("s",$_SESSION['ulbid']);
        $sql->execute();
        $rs = $sql->get_result();
		
        while($row = $rs->fetch_assoc())
        {
			$emp_list[$row['emp_id']]=$row['emp_name']."(".$row['emp_mobile'].")";  
        }
		
        $sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst_od where ulbid=?");
        $sql->bind_param("s",$_SESSION['ulbid']);
        $sql->execute();
        $rs = $sql->get_result();
		
        while($row = $rs->fetch_assoc())
        {
          $emp_list[$row['emp_id']]=$row['emp_name']."(".$row['emp_mobile'].")";  
        }
     	
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		  
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	    $tpl->assign('online_applications',$online_applications);
        $tpl->assign('emp_list',$emp_list);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('app_type_id',$_POST['app_type_id']);
		$tpl->assign('ref_no',$_POST['ref_no']);
		$tpl->assign('applicant_name',$_POST['applicant_name']);
		$tpl->assign('mobile',$_POST['mobile']);
		$tpl->assign('ward_id',$_POST['ward_id']);
		$tpl->assign('dept_id',$_POST['dept_id']);
		$tpl->assign('list',$list);
		$tpl->assign('cat3_id',$_POST['cat3_id']);
		/*	$query->close();*/
	
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('app_type_list',array('1'=>'Complaints','2'=>'Services'));
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('cat3_list',$cat3_list);			
		$tpl->assign('data',$data);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$flash = get_flash();		
		$tpl->assign("flash", $flash); 
		$tpl->display('corp_search_complaint.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
		
	}
?>