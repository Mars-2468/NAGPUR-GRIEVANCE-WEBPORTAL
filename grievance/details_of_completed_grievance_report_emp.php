<?php
    require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
    date_default_timezone_set('Asia/Calcutta');
	
	$tpl=new Smarty();
	
	
	//$link ="http://localhost:8080/details_of_completed_grievance_report.php";
	
	
					//$host = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
					//$ip_address = $_SERVER["REMOTE_ADDR"];

//echo "<pre>";print_r($_POST);echo "</pre>";die();

$threshold_date='2024-09-01';

	if(isset($_SESSION['uid']))
	{
			
		require_once('connection.php');			
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
	
		$conn=getconnection();
		
	
		$grievance_id =$_POST['ref_no'];
		$ward_id =$_POST['ward_id'];
		$department_id =$_POST['department_id'];
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$grievance_status_id =9;
		$disposal_status=9;
		$ratings_list = $_POST['rating_list'];
		$remarks=$_POST['remarks'];
		$emp_details=$_POST['emp_details'];
		$feedback_by=$_SESSION['user_id'];
		
		
		$f_date =!empty($_POST['f_date'])? date('Y-m-d', strtotime($_POST['f_date'])):'';
		$t_date =!empty($_POST['t_date'])? date('Y-m-d', strtotime($_POST['t_date'])):'';	
		

		/* foreach($ratings_list as $key=>$value){			
			echo "<pre>";print_r($ratings_list[$key]);echo "</pre>";
		}die(); */ 
		
		//echo "<pre>";print_r($emp_details);echo "</pre>";die();
		//echo "<pre>";print_r($ratings_list);echo "</pre>";die();
		//$input_rating = !empty($_POST['input_rating'][0])?$_POST['input_rating']:0;

	
		if($_SESSION['user_type']=='E')
		{	
				$emp_id=$_SESSION['emp_id'];
				//echo"<pre>";print_r($emp_id);echo"</pre>";die();
				
				
				
				
				
				
				
				
				
				
				/* if($f_date!='' && $t_date!=''){
					
					if(isset($_POST['search']) && !empty($_POST['ref_no']) && !empty($_POST['department_id']))
					{		
					//var_dump('if');die();
						$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.grievance_id=?
						  and g.ulbid=? and g.grievance_status_id=? and gt.dept_id=? and gt.emp_id=?  and gt.disposal_status=? and date_regd >='".$threshold_date."' and g.date_regd between '".$f_date."' and '".$t_date."' and g.ward_id like '". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."'";
						$query = $conn->prepare($sql);
						$query->bind_param("isiiii",$grievance_id,$ulbid,$grievance_status_id,$department_id,$emp_id,$disposal_status);
						
					}elseif(isset($_POST['search']) && empty($_POST['ref_no']) && !empty($_POST['department_id'])){
						//var_dump('else if');die();
						
						$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where gt.dept_id=? and gt.emp_id=?
						  and g.ulbid=? and g.grievance_status_id=?  and gt.disposal_status=? and date_regd >='".$threshold_date."' and g.date_regd between '".$f_date."' and '".$t_date."' and g.ward_id like '". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."'";
						$query = $conn->prepare($sql);
						$query->bind_param("iisii",$department_id,$emp_id,$ulbid,$grievance_status_id,$disposal_status);
						
					}elseif(isset($_POST['search']) && !empty($_POST['ref_no']) && empty($_POST['department_id'])){
						//var_dump('present else if');die();
						
						$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where gt.emp_id=? and g.grievance_id=?
						  and g.ulbid=? and g.grievance_status_id=?  and gt.disposal_status=? and date_regd >='".$threshold_date."' and g.date_regd between '".$f_date."' and '".$t_date."' and g.ward_id like '". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."'";	
					//var_dump($sql);die();
						$query = $conn->prepare($sql);
						$query->bind_param("iisii",$emp_id,$grievance_id,$ulbid,$grievance_status_id,$disposal_status);
						
					}else{
						//var_dump('else');die();
						$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.ulbid=? and g.grievance_status_id=? and gt.emp_id=? and gt.disposal_status=? and date_regd >='".$threshold_date."' and g.date_regd between '".$f_date."' and '".$t_date."' and g.ward_id like '". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."'";
						$query = $conn->prepare($sql);
						$query->bind_param("siii",$ulbid,$grievance_status_id,$emp_id,$disposal_status);
					}
					
				}else{
			
					if(isset($_POST['search']) && !empty($_POST['ref_no']) && !empty($_POST['department_id']))
					{		
					//var_dump('if');die();
						$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.grievance_id=?
						  and g.ulbid=? and g.grievance_status_id=? and gt.dept_id=? and gt.emp_id=?  and gt.disposal_status=? and date_regd >='".$threshold_date."' and g.ward_id like '". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."'";
						$query = $conn->prepare($sql);
						$query->bind_param("isiiii",$grievance_id,$ulbid,$grievance_status_id,$department_id,$emp_id,$disposal_status);
						
					}elseif(isset($_POST['search']) && empty($_POST['ref_no']) && !empty($_POST['department_id'])){
						//var_dump('else if');die();
						
						$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where gt.dept_id=? and gt.emp_id=?
						  and g.ulbid=? and g.grievance_status_id=? and date_regd >='".$threshold_date."' and gt.disposal_status=? and g.ward_id like '". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."'";
						$query = $conn->prepare($sql);
						$query->bind_param("iisii",$department_id,$emp_id,$ulbid,$grievance_status_id,$disposal_status);
						
					}elseif(isset($_POST['search']) && !empty($_POST['ref_no']) && empty($_POST['department_id'])){
						//var_dump('present else if');die();
						
						$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where gt.emp_id=? and g.grievance_id=?
						  and g.ulbid=? and g.grievance_status_id=?  and gt.disposal_status=? and date_regd >='".$threshold_date."' and g.ward_id like '". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."'";
					//var_dump($sql);die();
						$query = $conn->prepare($sql);
						$query->bind_param("iisii",$emp_id,$grievance_id,$ulbid,$grievance_status_id,$disposal_status);
						
					}else{
						//var_dump('else');die();
						
						if(!empty($_POST['ward_id'])){
						$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.ulbid=? and g.grievance_status_id=? and gt.emp_id=? and gt.disposal_status=? and date_regd >='".$threshold_date."' and g.ward_id like '". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."'";
						}else{
							$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after,
						  g.comp_desc,g.grievance_origin_id,g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.ulbid=? and g.grievance_status_id=? and gt.emp_id=? and gt.disposal_status=? and date_regd >='".$threshold_date."' and g.ward_id like '%". mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."%'";
						}
						
						$query = $conn->prepare($sql);
						$query->bind_param("siii",$ulbid,$grievance_status_id,$emp_id,$disposal_status);
					}
				} */
				
				
				
				
				
				
				if(isset($_POST['search'])) {		
			
					$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,
						gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after1,g.comp_desc,g.grievance_origin_id,
						g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						from grievances g inner join ".$_SESSION['grievances_trns']." gt 
						on g.grievance_id=gt.grievance_id 
						where g.ulbid='".$_SESSION['ulbid']."' 
						and g.grievance_status_id IN(3,6,8,9,12) 
						and date_format(g.date_regd,'%Y-%m-%d') >='2024-10-01' 
						and gt.emp_id=".$emp_id." ";
			
						
						if(!empty($_POST['department_id'])){					
							$sql.=" and gt.dept_id=".$_POST['department_id']." ";
						}
						
						if(!empty($_POST['ref_no'])){					
							$sql.=" and g.grievance_id=".$_POST['ref_no']." ";
						}
						
						if(!empty($_POST['ward_id'])){					
							$sql.=" and g.ward_id=".$_POST['ward_id']." ";
						}	
						
						if(!empty($f_date) && !empty($t_date)){					
							$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
						} 
											
				}else{
					
					$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,
						gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after1,g.comp_desc,g.grievance_origin_id,
						g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						from grievances g inner join ".$_SESSION['grievances_trns']." gt 
						on g.grievance_id=gt.grievance_id 
						where g.ulbid='".$_SESSION['ulbid']."' 
						and g.grievance_status_id IN(3,6,8,9,12) 
						and date_format(g.date_regd,'%Y-%m-%d') >='2024-10-01' 
						and gt.emp_id=".$emp_id." ";
						
				}
			
			
		//		echo"<pre>";print_r($sql);echo"</pre>";die();	

				
			$query = $conn->prepare($sql);
				
								
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
			
			//echo "<pre>";print_r($data[10]['dept_id']);echo "</pre>";die();
						
			$sql=$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
			$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			$sql->bind_param("s",$ulbid);
			$sql->execute();
			$rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
			{
				$ward_list[$row['ward_id']]=$row['ward_desc'];  
			}
		}
		//echo "<pre>";print_r($ward_list);echo "</pre>";die();
		
		if($_SESSION['user_type']=='E')
		{
		    
		    $sql=$conn->prepare("select distinct gt.emp_id,gt.dept_id 
    		  from grievances g left join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.ulbid='250' and g.grievance_status_id=9 and gt.emp_id=? and gt.disposal_status=9");
		    $emp_id = htmlspecialchars(strip_tags($_SESSION['emp_id']));
			//echo "<pre>";print_r($emp_id);echo "</pre>";die();	
		    $sql->bind_param("i",$emp_id);
			
			$sql->execute();
			$rs=$sql->get_result();
			$dept_list[0]='Select';
			while($row = $rs->fetch_assoc())
			{
				$deptlist[]=$row['dept_id'];
				
			}

			$bindClause = implode(',', array_fill(0, count($deptlist), '?'));
			//create a int for the bind param just containing the right amount of i 
			$bindIds = str_repeat('s', count($deptlist));

			$sql = $conn->prepare('SELECT dept_id,dept_desc FROM dept_mst WHERE `dept_id` IN (' . $bindClause . ')');

			$sql->bind_param($bindIds, ...$deptlist);
			$sql->execute();

		
			$rs=$sql->get_result();
			$dept_list[0]='Select';
			while($row = $rs->fetch_assoc())
			{
				$dept_list[$row['dept_id']]=$row['dept_desc'];
			}	

			//echo "<pre>";print_r( $dept_list );echo "</pre>";die();
		
		} 
		//echo "<pre>";print_r( $dept_list );echo "</pre>";die();
			
		if($_POST['app_type_id'] == '1'){

			$sql=$conn->prepare("select cs_id,cs_desc as comp_desc,m.description from cs_mst cm,grievances g,category_mst m where
			g.cat3_id=cm.cs_id and cm.cat_id=m.cat_id and g.app_type_id=? and 
			g.ulbid=? group by g.cat3_id");

			$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			$app_type_id = $_POST['app_type_id'];
			$sql->bind_param("is",$app_type_id,$ulbid);

		}else{

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
		
		$sql = $conn->prepare("select cs_id,cutt_off_time  from comp_cutofdays_map");
		$sql->execute();
		$rs =$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $cut_of_days[$row['cs_id']]=$row['cutt_off_time'];
			
		}
		//echo "<pre>";print_r($cut_of_days);echo "</pre>";die();
		
		
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
		
		
		
		$sql="select c.cs_id,c.cs_desc,cm.cat_id,cm.description from cs_mst c, category_mst cm where c.cat_id=cm.cat_id";
		$query=$conn->prepare($sql);
        
        
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				//$cat_list[$row['cs_id']]=$row['description'];
				$cat_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		 
	      
	    /*$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid =?";
	    $query=$conn->prepare($sql);
		$query->bind_param("s",$_SESSION['ulbid']);
		$query->execute();
	    $rs=$query->get_result();
	    $row=$rs->fetch_assoc();
	      */
	    
		$sql = "select grievance_id,rating_no,feedback_desc from hod_feedback_to_emp";

		if ($rs = mysqli_query($conn, $sql)) {

			while ($row = mysqli_fetch_assoc($rs)){
				$rating_list[$row['grievance_id']]['rating_no'] = $row['rating_no'];
				$rating_list[$row['grievance_id']]['feedback_desc'] = $row['feedback_desc'];
			}
		}
		// echo "<pre>";print_r($rating_list[12]['feedback_desc']);echo "</pre>";die(); 
		
		$minDate='2024-09-01';
		
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	    $tpl->assign('online_applications',$online_applications);
        $tpl->assign('emp_list',$emp_list);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('app_type_id',$_POST['app_type_id']);
		$tpl->assign('ref_no',$grievance_id);
		$tpl->assign('applicant_name',$_POST['applicant_name']);
		$tpl->assign('mobile',$_POST['mobile']);

		$tpl->assign('dept_id',$_POST['dept_id']);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('cut_of_days',$cut_of_days);
		$tpl->assign('list',$list);
		$tpl->assign('cat3_id',$_POST['cat3_id']);
		$tpl->assign('department_id',$_POST['department_id']);
		$tpl->assign('dward_id',$_POST['ward_id']);
	    
	/*	$query->close();*/
		
		$tpl->assign('fdate',$f_date);
		$tpl->assign('tdate',$t_date);
		
		$tpl->assign('minDate',$minDate);
	
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('app_type_list',array('1'=>'Complaints','2'=>'Services'));
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('cat3_list',$cat3_list);			
		$tpl->assign('data',$data);
		$tpl->assign('rating_list',$rating_list);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);
       

		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
	
		$tpl->display('details_of_completed_grievance_report_emp.tpl');
	}
	else
	{
		
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>