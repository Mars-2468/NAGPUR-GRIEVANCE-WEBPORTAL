<?php
	require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	//ini_set('display_startup_errors',1);
	//error_reporting(E_ALL);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	$user_type = $_SESSION['user_type'];
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');

		// User type E

		$emplist = join("','", $_SESSION['emp_list']);
		//echo $emplist;

		$sql = "SELECT dept_id,emp_id FROM hod_emp_map where emp_id IN ('" . $emplist . "') ";

		if ($_SESSION['user_type'] == 'E') {

		$sql = "select d.dept_id from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id and emp_id IN ('" . $emplist . "')";
		}

		if ($rs = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_id'];
		}
		//echo $sql;
		$dept_list1 = $dept_list;
		//$deptlist = join("','",$_SESSION['emp_list']);
		//$deptlist  =join(',',$dept_list1 );
		$deptlist = implode(',', $dept_list1);
		//print_r($deptlist);

		$conn=getconnection();

		/* $date_from_sel = $_REQUEST['f_date'];
		$date_to_sel = $_REQUEST['t_date'];

		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') 
		{
			$f_date = date('Y-m-d', strtotime($_POST['f_date']));
			$t_date = date('Y-m-d', strtotime($_POST['t_date']));
		} */
		
		$f_date = null;
		$t_date = null;
		$errors = [];
		
		if (isset($_POST['search'])) {

			// --- Validate Dates ---
			if (!empty($_POST['f_date']) && !empty($_POST['t_date'])) {

				// Convert and validate date format
				$f_date_raw = $_POST['f_date'];
				$t_date_raw = $_POST['t_date'];

				// Check valid date format (DD-MM-YYYY or YYYY-MM-DD)
				$f_date_obj = DateTime::createFromFormat('Y-m-d', $f_date_raw) ?: DateTime::createFromFormat('d-m-Y', $f_date_raw);
				$t_date_obj = DateTime::createFromFormat('Y-m-d', $t_date_raw) ?: DateTime::createFromFormat('d-m-Y', $t_date_raw);

				if ($f_date_obj && $t_date_obj) {
					$f_date = $f_date_obj->format('Y-m-d');
					$t_date = $t_date_obj->format('Y-m-d');

					// Check if from-date is earlier than to-date
					if ($f_date > $t_date) {
						$errors[] = "From date cannot be later than To date.";
					}

				} else {
					$errors[] = "Invalid date format.";
				}

			} elseif (!empty($_POST['f_date']) || !empty($_POST['t_date'])) {
				$errors[] = "Both From and To dates are required.";
			}else{
				$f_date = date('Y-m-d', strtotime($f_date));
				$t_date = date('Y-m-d', strtotime($t_date));
			}

			// --- Display or handle validation errors ---
			 $tpl->assign('errors', $errors);
		}

		if ($user_type == 'P')
		{				
			$sql ="SELECT count(`grievance_id`) as count , cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id FROM `grievances` g, cs_mst c, category_mst cm where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and `grievance_status_id` = 2" ;
		}
		else
		{
			$sql ="SELECT count(DISTINCT g.grievance_id) as count , cat3_id,`description`,cm.cat_id,c.sub_cat_id,gt.dept_id,ward_id FROM grievances g, grievances_transactions gt, cs_mst c, category_mst cm where g.grievance_id=gt.grievance_id AND g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and g.grievance_status_id IN ('2','11') And gt.disposal_status IN ('2','11') AND gt.dept_id IN ( $deptlist ) " ;
		}		

		if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){
			$sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' ";
		}
		
		$sql.=" group by cat3_id , ward_id order by count DESC";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs)){
		
		$comp_details[$row['cat3_id']][$row['ward_id']]['count'] = $row['count'];
		$tot[$row['cat3_id']]['total']+=$row['count'];
		$tot_wards[$row['ward_id']]['total']+=$row['count'];
		$total+=$row['count'];
		
		$comp_details[$row['cat3_id']]['cat_id'] = $row['cat_id'];
		$comp_details[$row['cat3_id']]['sub_cat_id'] = $row['sub_cat_id'];
		$max_comp_details[$row['cat3_id']]['count']+= $row['count'];
		$max_comp_details[$row['cat3_id']]['cat3_id']= $row['cat3_id'];
		
		}
		
		$column = array_column($max_comp_details, 'count');
		array_multisort($column, SORT_DESC,$max_comp_details);
		
		
		
		if ($user_type == 'P')
		{				
			$sql ="SELECT * from ward_mst order by sortOrder";
		}
		else
		{
			$sql ="SELECT w.*,g.ward_id from ward_mst w,grievances g where g.ward_id=w.ward_id order by w.sortOrder " ;
		}
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs)){
			$ward_list[$row['ward_id']]['ward_name'] = $row['ward_desc'];
		}
		
		$sql ="SELECT * FROM `comp_cutofdays_map`";
	    $query=$conn->prepare($sql);
	
		if(!$query->execute())
        {
            echo "Query not executed 1";
        }
        $rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
			$data[$row['cs_id']]['cutt_off_time']=$row['cutt_off_time'];
		}
		
		
		$sql ="select cat_id, description from category_mst where ulbid= ? and cs_type_id= ?";
		
		$ulbid='250';
		$cs_type_id='1';
		
		$query=$conn->prepare($sql);
		$query->bind_param("si",$ulbid,$cs_type_id);
		
    			if(!$query->execute())
    	        {
    	            echo "Query not executed 2";
    	        }
		$rs3=$query->get_result(); 
		
		while($row = $rs3->fetch_assoc())
		{
		    $cat_list[$row['cat_id']]=$row['description'];
			//$cat_list2[$row['cat_id']]=$row['telugu_description'];
		}
		//print_r($cat_list);
		
		
		
		$sql ="select * from subcategory_mst";
		//$sql ="select * from subcategory_mst where status='1' order by sub_cat_id";
		$query=$conn->prepare($sql);
    			if(!$query->execute())
    	        {
    	            echo "Query not executed 2";
    	        }
		$rs3=$query->get_result(); 
		
		while($row = $rs3->fetch_assoc())
		{
		    $sub_cat_list[$row['cat_id']][$row['sub_cat_id']]=$row['description'];
			// $data[$row['cat_id']][$row['cs_id']]['cs_desc']=$row['cs_desc'];
			$sub_cat_list2[$row['cat_id']][$row['sub_cat_id']]['sub_cat_desc']=$row['description'];
		}
		//print_r($sub_cat_list2);
		
		$sql ="select * from dept_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
			//$dept_list[$row['dept_id']]=$row['dept_desc'];
			$dept_list2[$row['dept_id']] = $row['dept_desc'];
		}
		//print_r($dept_list);
		
		$sql ="select * from cs_mst";
		//$sql ="select * from cs_mst where cs_type_id='1'";
		$query=$conn->prepare($sql);
	
		if(!$query->execute())
        {
            echo "Query not executed 3";
        }
        $rs4=$query->get_result();
		
		
		while($row = $rs4->fetch_assoc())
		{
		    $cs_list[$row['cs_id']]['desc']=$row['cs_desc'];
			$cs_list[$row['cs_id']]['cat_id']=$row['cat_id'];
			$cs_list[$row['cs_id']]['sub_cat_id']=$row['sub_cat_id'];
			
		}
		
		$sql ="select * from level_disposabledays_map";
		
		$query=$conn->prepare($sql);
	
		if(!$query->execute())
        {
            echo "Query not executed 3";
        }
        $rs4=$query->get_result();
		
		
		while($row = $rs4->fetch_assoc())
		{
		    $disposable_days[$row['cs_id']]['L1']=$row['L1'];
			$disposable_days[$row['cs_id']]['L2']=$row['L2'];
			$disposable_days[$row['cs_id']]['L3']=$row['L3'];
			
		}
		
		
		
		
	      
	      $row = $rs4->fetch_assoc();
		  
		  
		  
		$tpl->assign('total',$total);
		$tpl->assign('tot_wards',$tot_wards);
		$tpl->assign('tot',$tot);
		$tpl->assign('comp_details',$comp_details);
		$tpl->assign('max_comp_details',$max_comp_details);
		$tpl->assign('ward_list',$ward_list);

		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('dept_list2',$dept_list2);
		  
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
		$conn->close();
        $tpl->assign('data',$data);
		$tpl->assign('f_date',$f_date); 
		$tpl->assign('t_date',$t_date); 
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('sub_cat_list',$sub_cat_list);	
		$tpl->assign('sub_cat_list2',$sub_cat_list2);	
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('cat_list2',$cat_list2);
		$tpl->assign('disposable_days',$disposable_days);
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('corp_grievance_pending_rep.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>