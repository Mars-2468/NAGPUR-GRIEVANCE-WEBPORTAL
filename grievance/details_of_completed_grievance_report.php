<?php
    require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	//$link ="http://localhost:8080/details_of_completed_grievance_report.php";
	
	
					//$host = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
					//$ip_address = $_SERVER["REMOTE_ADDR"];

	if(isset($_SESSION['uid']))
	{
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		$threshold_date=$_SESSION['threshold_date'];
	
		$ward_id =$_POST['ward_id'];
		$grievance_id =$_POST['ref_no'];
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
		
		$rating_num=0;

		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		//echo"<pre>";print_r(isset($_GET['page']));echo"</pre>";die();
		// Set variables
		$limit = 300; // Number of records per page
		
		$start = ($page - 1) * $limit;
		$pageNumber=$start+1;
		

		//$input_rating = !empty($_POST['input_rating'][0])?$_POST['input_rating']:0;

		if($_SESSION['user_type']=='U' || ($_SESSION['user_type']=='E' && $_SESSION['hod_status']==1) || ($_SESSION['user_type']=='E' && $_SESSION['hod_status2']==1) )
		{	
				
			//echo "<pre>";print_r($_POST);echo "</pre>";die();
			
				$mremarks=sanitize_input($_POST['mremarks']);//$_POST['mremarks'];
				$memp_id=$_POST['memp_id'];
				$mdept_id=$_POST['mdept_id'];
				$mgrievance_id=$_POST['mgrievance_id'];
				$rating_list_no=$_POST['rating_list_no'];
			
			    $sql ="select grievance_id,rating_no from hod_feedback_to_emp WHERE grievance_id=?";
				$query = $conn->prepare($sql);
				$query->bind_param("i",$mgrievance_id);						
				$query->execute();
				$rs = $query->get_result();
				
				//$row=$rs->fetch_assoc();
				//echo "<pre>";print_r($_POST);echo "</pre>";die();	
				
				if($rs->num_rows !=0){
					$sql ="update `hod_feedback_to_emp` set rating_no=? , feedback_desc=? WHERE grievance_id=?";
					$query = $conn->prepare($sql);
					$query->bind_param("isi",$rating_list_no,$mremarks,$mgrievance_id);						
					$query->execute();
				}	
								
				if($rs->num_rows ==0){					
					$ip_address = $_SERVER["REMOTE_ADDR"];					
					$sql ="insert into hod_feedback_to_emp(grievance_id,emp_id,dept_id,ip_address,rating_no,feedback_desc,feedback_given_by) values(?,?,?,?,?,?,?)";
					$query = $conn->prepare($sql);
					$query->bind_param("iiisiss",$mgrievance_id,$memp_id,$mdept_id,$ip_address,$rating_list_no,$mremarks,$feedback_by);						
					$query->execute();	
				}   
						
			if(isset($_POST['search']) && !strcmp($_POST['search'],"Search")) {	
			
				$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,
					gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after1,g.comp_desc,g.grievance_origin_id,
					g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
					from grievances g inner join ".$_SESSION['grievances_trns']." gt
					on g.grievance_id=gt.grievance_id 
					where g.ulbid='".$_SESSION['ulbid']."' 
					and g.grievance_status_id IN(3,6,8,9,12) 
					and date_format(g.date_regd,'%Y-%m-%d') >='".$threshold_date."' ";					
										
			
			}else if(isset($_POST['save']) && !strcmp($_POST['search'],"Search") ) {		
			
				$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,
					gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after1,g.comp_desc,g.grievance_origin_id,
					g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
					from grievances g inner join ".$_SESSION['grievances_trns']." gt
					on g.grievance_id=gt.grievance_id 
					where g.ulbid='".$_SESSION['ulbid']."' 
					and g.grievance_status_id IN(3,6,8,9,12) 
					and date_format(g.date_regd,'%Y-%m-%d') >='".$threshold_date."' ";					
				 
										
			}else{ 
				
				
				$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,
					gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after1,g.comp_desc,g.grievance_origin_id,
					g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
					from grievances g inner join ".$_SESSION['grievances_trns']." gt 
					on g.grievance_id=gt.grievance_id 
					where g.ulbid='".$_SESSION['ulbid']."' 
					and g.grievance_status_id IN(3,6,8,9,12) 
					and date_format(g.date_regd,'%Y-%m-%d') >='".$threshold_date."' ";				
					
			}
				
				
				$rating_num=$_POST['rating_num'];
					if($rating_num!=0){
						$gsql=$conn->prepare("select grievance_id from hod_feedback_to_emp where rating_no=".$rating_num."");
						$gsql->execute();
						$grs=$gsql->get_result();
						$grievance_list='';
						
						while($grow = $grs->fetch_assoc())
						{
							$grievance_list.=$grow['grievance_id'].','; 						
							
						}		
						
						if(!empty($grievance_list)){		
							$grievance_list=rtrim($grievance_list,",");	 			
							$sql.=" and gt.grievance_id IN(".$grievance_list.") ";
						}
					}
					//echo "<pre>";print_r($sql);echo "</pre>";die();	
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

				$sql.=" and date_format(g.date_regd,'%Y-%m-%d') >= '2024-09-01' ";
				
				$pg_sql=$sql;
		echo $sql;exit;
				$sql.=" LIMIT ".$start.", ".$limit." ";	
				
				$query = $conn->prepare($sql);
				
				$pgrs=mysqli_query($conn,$pg_sql);
		
				$total_rows=$pgrs->num_rows;

				$query->execute();
				$rs = $query->get_result();
				
				if($rs->num_rows > 0 )
				{
					$field_info = $rs->fetch_fields();
					while($row =  $rs->fetch_assoc())
					{
						foreach($field_info as $fi => $f){ 
							$data[$row['grievance_id']][$f->name]=$row[$f->name];
							
							if(!strcmp($f->name,"disposed_date"))
								$disp_date=$row[$f->name];
							
							if(!strcmp($f->name,"date_regd"))
								$dateregd=$row[$f->name];
						}	
						$frmdate=date('Y-m-d',strtotime($dateregd));
						$todate=date('Y-m-d',strtotime($disp_date));
						
						$date1 = new DateTime($frmdate);
						$date2 = new DateTime($todate);
						$interval = $date1->diff($date2);
						$daysdiff[$row['grievance_id']]=$interval->days;
					}
					
				}
				else
				{
					$tpl->assign('msg','Record not found');
				}  

				//echo"<pre>";print_r($daysdiff);echo"</pre><br>";die();	
						
		}
	
		if($_SESSION['user_type']=='E')
		{	
			$emp_id=$_SESSION['emp_id'];
			//echo"<pre>";print_r($emp_id);echo"</pre>";die();
			if(isset($_POST['search'])) {		
			
					$sql="select g.grievance_id,g.person_name,g.email,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_subject,g.ts,
						gt.disposed_date,gt.disposal_remarks,g.file_url as previous,gt.file_url as after1,g.comp_desc,g.grievance_origin_id,
						g.grievance_status_id,g.date_regd,g.cat3_id,g.app_type_id,gt.emp_id,gt.dept_id 
						from grievances g inner join ".$_SESSION['grievances_trns']." gt 
						on g.grievance_id=gt.grievance_id 
						where g.ulbid='".$_SESSION['ulbid']."' 
						and g.grievance_status_id IN(3,6,8,9,12) 
						and date_format(g.date_regd,'%Y-%m-%d') >='".$threshold_date."' 
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
						and date_format(g.date_regd,'%Y-%m-%d') >='".$threshold_date."' 
						and gt.emp_id=".$emp_id." ";
						
				}
			
			//	echo"<pre>";print_r($sql);echo"</pre>";die();	
			
			$pg_sql=$sql;
	
			$sql.=" LIMIT ".$start.", ".$limit." ";		
				
			$query = $conn->prepare($sql);
				
			$pgrs=mysqli_query($conn,$pg_sql);
		
			$total_rows=$pgrs->num_rows;	
			
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
		
		//echo "<pre>";print_r($ward_list);echo "</pre>";die();
		
		if($_SESSION['user_type']=='U' || ($_SESSION['user_type']=='E' && $_SESSION['hod_status']==1) || ($_SESSION['user_type']=='E' && $_SESSION['hod_status2']==1))
		{
			$sql=$conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=?");
			
			$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			$sql->bind_param("s",$ulbid);
			
			$sql->execute();
			$rs=$sql->get_result();
			$dept_list[0]='Select';
			while($row = $rs->fetch_assoc())
			{
				$dept_list[$row['dept_id']]=$row['dept_desc'];
			}	
		
		}else if($_SESSION['user_type']=='E')
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
		
	
		
		$sql = "select grievance_id,rating_no,feedback_desc from hod_feedback_to_emp";

		if ($rs = mysqli_query($conn, $sql)) {

			while ($row = mysqli_fetch_assoc($rs)){
				$rating_list[$row['grievance_id']]['rating_no'] = $row['rating_no'];
				$rating_list[$row['grievance_id']]['feedback_desc'] = $row['feedback_desc'];
			}
		}
		// echo "<pre>";print_r($rating_list[12]['feedback_desc']);echo "</pre>";die(); 
		
		$minDate='2024-09-01';
		
		$ratings_list=[
		1=>'1',
		2=>'2',
		3=>'3',
		4=>'4',
		5=>'5',
		6=>'6',
		7=>'7',
		8=>'8',
		9=>'9',
		10=>'10',
		];
		
		
		/************************* pagination start  **************************/
			
		// Query to fetch paginated data


		// Calculate total pages
		
		$total_pages = ceil($total_rows / $limit);
		
		// Generate pagination data
		$pagination = [
			'current_page' => $page,
			'total_pages' => $total_pages,
			'range' => 3 // Number of visible pages before/after the current page
		];
				
		/* $filter_query = '';

		//echo "<pre>";print_r($data);echo "</pre>";die();
			
		if (!empty($department_id)) {
			$filter_query .= '&department_id=' . urlencode($department_id);
		}
		if (!empty($ward_id)) {
			$filter_query .= '&ward_id=' . urlencode($ward_id);
		}

		if (!empty($from_date)) {
			$filter_query .= '&from_date=' . urlencode($from_date);
		}

		if (!empty($to_date)) {
			$filter_query .= '&to_date=' . urlencode($to_date);
		}

		if (!empty($grievance_id)) {
			$filter_query .= '&grievance_id=' . urlencode($grievance_id);
		}

		if (!empty($rating_num)) {
			$filter_query .= '&rating_num=' . urlencode($rating_num);
		}

		if (!empty($search)) {
			$filter_query .= '&search=' . urlencode($search);
		}

		$tpl->assign('filter_query', $filter_query); */
		
		$tpl->assign('pagination', $pagination);
		$tpl->assign('current_page', $page);
		$tpl->assign('total_pages', $total_pages);
	
	/************************* pagination end  **************************/
				
		
		
		
		
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	    $tpl->assign('online_applications',$online_applications);
        $tpl->assign('emp_list',$emp_list);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('app_type_id',$_POST['app_type_id']);

		$tpl->assign('applicant_name',$_POST['applicant_name']);
		$tpl->assign('mobile',$_POST['mobile']);

		$tpl->assign('dept_id',$_POST['dept_id']);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('cut_of_days',$cut_of_days);
		$tpl->assign('list',$list);
		$tpl->assign('cat3_id',$_POST['cat3_id']);
		
		$tpl->assign('ref_no',$grievance_id);
		$tpl->assign('department_id',$department_id);
		$tpl->assign('dward_id',$ward_id);
	    
		$conn->close();
		
		$tpl->assign('fdate',$f_date);
		$tpl->assign('tdate',$t_date);
		
		$tpl->assign('pageNumber',$pageNumber);
		$tpl->assign('minDate',$minDate);
		$tpl->assign('daysdiff',$daysdiff);
	
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('app_type_list',array('1'=>'Complaints','2'=>'Services'));
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('cat3_list',$cat3_list);			
		$tpl->assign('data',$data);
		$tpl->assign('rating_list',$rating_list);
		$tpl->assign('ratings_list',$ratings_list);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);
		$tpl->assign('rating_num',$_POST['rating_num']);
       

		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
	
		$tpl->display('details_of_completed_grievance_report.tpl');
		
	}else{		
		
		echo "<script>window.location='index.php';</script>";
		
	}
	
		
function sanitize_input($sanitize_data) {

	//PHP
    // Remove unnecessary spaces
    $sanitize_data = trim($sanitize_data);

    // Strip tags to prevent HTML and PHP code injection
    $sanitize_data = strip_tags($sanitize_data);

    // Convert special characters to HTML entities (e.g., < to &lt;)
    $sanitize_data = htmlspecialchars($sanitize_data);
	
	//$sanitize_data = preg_replace('/[^a-zA-Z0-9\s]/', '', $sanitize_data);
	
    return $sanitize_data;
}

?>