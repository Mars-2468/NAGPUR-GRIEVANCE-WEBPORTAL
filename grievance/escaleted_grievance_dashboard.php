<?php
	require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		
		$conn=getconnection();
		
		
		
		$reference_no = null;
		$f_date = null;
		$t_date = null;
		$errors = [];
		
		if (isset($_POST['search'])) {

			if (!empty($_POST['status_id'])){
				$gstatus=$_POST['status_id'];
			}
			
			if (!empty($_POST['department_id'])){
				$department_id=$_POST['department_id'];
			}
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
		}else{
			$gstatus='';
			$f_date='';
			$t_date='';
			$department_id='';
		}		
		
		if(!strcmp($gstatus,"Resolved")){
			$grievance_status='3,6,8,9,12';			
		}else if(!strcmp($gstatus,"Pending")){
			$grievance_status='2,5,10,11,13';
		}else{
			$grievance_status='2,3,5,6,8,9,10,11,12,13';
		}		

		if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){
			
			if(!empty($department_id)){
				$sql ="SELECT count(DISTINCT (g.grievance_id)) as count, g.cat3_id,cm.description,cm.cat_id,c.sub_cat_id,g.ward_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and `is_escalated` = 1 and c.cat_id=". $department_id . " and g.grievance_status_id IN(" . $grievance_status . ") and g.date_regd between '" . $f_date . "' and '" . $t_date . "' group by g.cat3_id , g.ward_id order by count DESC";
			}else{
				$sql ="SELECT count(DISTINCT (g.grievance_id)) as count, g.cat3_id,cm.description,cm.cat_id,c.sub_cat_id,g.ward_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and `is_escalated` = 1 and g.grievance_status_id IN(" . $grievance_status . ") and g.date_regd between '" . $f_date . "' and '" . $t_date . "' group by g.cat3_id , g.ward_id order by count DESC";
			}
			
		}else{
			
			if(!empty($department_id)){
				$sql ="SELECT count(DISTINCT (g.grievance_id)) as count, g.cat3_id,cm.description,cm.cat_id,c.sub_cat_id,g.ward_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and `is_escalated` = 1 and c.cat_id=" . $department_id . " and g.grievance_status_id IN(" . $grievance_status . ")  group by g.cat3_id , g.ward_id order by count DESC";
			}else{
				$sql ="SELECT count(DISTINCT (g.grievance_id)) as count, g.cat3_id,cm.description,cm.cat_id,c.sub_cat_id,g.ward_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id  and `is_escalated` = 1 and g.grievance_status_id IN(" . $grievance_status . ") group by g.cat3_id , g.ward_id order by count DESC";
			}
			
		}
		
//echo "<pre>";print_r($sql);echo "</pre>";die();	
	
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
		
		$sql ="SELECT * from ward_mst order by sortOrder";
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
		}
		
		$sql ="select * from subcategory_mst";
		
		
		$query=$conn->prepare($sql);
		
		if(!$query->execute())
		{
			echo "Query not executed 2";
		}
		$rs3=$query->get_result(); 
		
		while($row = $rs3->fetch_assoc())
		{
		    $sub_cat_list[$row['cat_id']][$row['sub_cat_id']]=$row['description'];
		}
		
		$sql ="select * from cs_mst";
		
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
		
		$sql=$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		  	$wards_list[$row['ward_id']]=$row['ward_desc'];  
		}
		
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
		
		
		$status_list=[
			''=>'Select status',
			'Resolved'=>'Resolved',
			'Pending'=>'Pending',
		];
	      
		$row = $rs4->fetch_assoc();

		$tpl->assign('total',$total);
		$tpl->assign('tot_wards',$tot_wards);
		$tpl->assign('tot',$tot);
		$tpl->assign('comp_details',$comp_details);
		$tpl->assign('max_comp_details',$max_comp_details);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('department_id',$department_id);
		$tpl->assign('gstatus',$gstatus);
		$tpl->assign('wards_list',$wards_list);
		$tpl->assign('fdate',$f_date);
		$tpl->assign('tdate',$t_date);
		$users_count=$row['user_count'];
		$tpl->assign('users_count',$users_count);
		$conn->close();
		$tpl->assign('data',$data);   	
		$tpl->assign('status_list',$status_list);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('sub_cat_list',$sub_cat_list);		
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('dept_list',$dept_list);	
		$tpl->assign('disposable_days',$disposable_days);
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('escaleted_grievance_dashboard.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
	}
?>