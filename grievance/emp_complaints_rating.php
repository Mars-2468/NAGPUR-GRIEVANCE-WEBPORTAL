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
	    
		$threshold_date=$_SESSION['threshold_date'];    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
				
		$department_id = $_POST['department_id'];

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
					
		//echo "<pre>";print_r($_POST);echo "</pre>";die();
		
		$sqlQuery="select count(r.grievance_id) as 5star,c.cs_id from rating_mst r , grievances g , ".$_SESSION['grievances_trns']." gt, cs_mst c where r.grievance_id = g.grievance_id and g.grievance_id = gt.grievance_id and 
		c.cs_id = g.cat3_id and g.grievance_status_id IN(3,6,8,9,12) ";
		
		if($_SESSION['uid']){
			$sqlQuery .=" and rating_given_by = '".$_SESSION['uid']."' ";
		}
		
		if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){				
			$sqlQuery.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
		} 
					
		$sqlQuery .=" and rating_no = ? and g.ulbid = ? and date_format(g.date_regd,'%Y-%m-%d') >= ? group by g.cat3_id";
		
		$sql = $conn->prepare($sqlQuery);
		$rating_no=5;
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("iss",$rating_no,$ulbid,$threshold_date);
		$sql->execute();
		$rs=$sql->get_result();
		while($row= $rs->fetch_assoc())
		{
			$data[$row['cs_id']]['5star']=$row['5star'];
			$tot= $data[$row['cs_id']]['5star'];
			$totals[5]+=$row['5star'];
			$totals['tot']+=$row['5star'];
		}
	
		$sqlQuery="select count(r.grievance_id) as 4star,c.cs_id from rating_mst r , grievances g , ".$_SESSION['grievances_trns']." gt, cs_mst c where r.grievance_id = g.grievance_id and g.grievance_id = gt.grievance_id and 
		c.cs_id = g.cat3_id and g.grievance_status_id IN(3,6,8,9,12) ";
		
		if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
			$sqlQuery.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
		} 
					
		$sqlQuery .=" and rating_no = ? and g.ulbid = ? and date_format(g.date_regd,'%Y-%m-%d') >= ? group by g.cat3_id";
		
		$sql = $conn->prepare($sqlQuery);
		
		$rating_no=4;
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("iss",$rating_no,$ulbid,$threshold_date);
		$sql->execute();
		$rs=$sql->get_result();
		
		while($row= $rs->fetch_assoc())
		{
			$data1[$row['cs_id']]['4star']=$row['4star'];
			$tot= $data1[$row['cs_id']]['4star'];
			$totals[4]+=$row['4star'];
			$totals['tot']+=$row['4star'];
		}
		
		$sqlQuery="select count(r.grievance_id) as 3star,c.cs_id from rating_mst r , grievances g , ".$_SESSION['grievances_trns']." gt, cs_mst c where r.grievance_id = g.grievance_id and g.grievance_id = gt.grievance_id and 
		c.cs_id = g.cat3_id and g.grievance_status_id IN(3,6,8,9,12) ";
		
		if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){				
			$sqlQuery.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
		} 
					
		$sqlQuery .=" and rating_no = ? and g.ulbid = ? and date_format(g.date_regd,'%Y-%m-%d') >= ? group by g.cat3_id";
		
		$sql = $conn->prepare($sqlQuery);

		$rating_no=3;
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("iss",$rating_no,$ulbid,$threshold_date);
		$sql->execute();
		$rs=$sql->get_result();
		while($row= $rs->fetch_assoc())
		{
			$data2[$row['cs_id']]['3star'] = $row['3star'];
			$tot3=$data2[$row['cs_id']]['3star'];
			 $totals[3]+=$row['3star'];
			 $totals['tot']+=$row['3star'];
		}
		
		$sqlQuery="select count(r.grievance_id) as 2star,c.cs_id from rating_mst r , grievances g , ".$_SESSION['grievances_trns']." gt, cs_mst c where r.grievance_id = g.grievance_id and g.grievance_id = gt.grievance_id and 
		c.cs_id = g.cat3_id and g.grievance_status_id IN(3,6,8,9,12) ";
		
		if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){			
			$sqlQuery.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
		} 
					
		$sqlQuery .=" and rating_no = ? and g.ulbid = ? and date_format(g.date_regd,'%Y-%m-%d') >= ? group by g.cat3_id";
		
		$sql = $conn->prepare($sqlQuery);

		$rating_no=2;
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("iss",$rating_no,$ulbid,$threshold_date);
		$sql->execute();
		$rs=$sql->get_result();
		while($row= $rs->fetch_assoc())
		{
			$data3[$row['cs_id']]['2star'] = $row['2star'];
			$tot4=$data3[$row['cs_id']]['2star'];
			 $totals[2]+=$row['2star'];
			 $totals['tot']+=$row['2star'];
		}
			
		$sqlQuery="select count(r.grievance_id) as 1star,c.cs_id from rating_mst r , grievances g , ".$_SESSION['grievances_trns']." gt, cs_mst c where r.grievance_id = g.grievance_id and g.grievance_id = gt.grievance_id and 
		c.cs_id = g.cat3_id and g.grievance_status_id IN(3,6,8,9,12) ";
		
		if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){				
			$sqlQuery.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
		} 
					
		$sqlQuery .=" and rating_no = ? and g.ulbid = ? and date_format(g.date_regd,'%Y-%m-%d') >= ? group by g.cat3_id";
		
		$sql = $conn->prepare($sqlQuery);

		$rating_no=1;
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("iss",$rating_no,$ulbid,$threshold_date);
		$sql->execute();
		$rs=$sql->get_result();
		while($row= $rs->fetch_assoc())
		{
			$data4[$row['cs_id']]['1star'] = $row['1star'];
			$tot5=$data4[$row['cs_id']]['1star'];
			$totals[1]+=$row['1star'];
			$totals['tot']+=$row['1star'];
		}
	
		$sql=$conn->prepare("select cat_id, description from category_mst where ulbid=? and cs_type_id=?");
		$ulbid=250;
		$cs_type_id=1;
		$sql->bind_param("si",$ulbid,$cs_type_id);
		$sql->execute();
		$rs=$sql->get_result();
		$cat_list['']='Select';
		while($row = $rs->fetch_assoc())
		{
		  $cat_list[$row['cat_id']]=$row['description'];  
		}
	
		//echo "<pre>";print_r($cat_list);echo "</pre>";die();
		
		$sql=$conn->prepare("select cs_id,cs_desc,cat_id from cs_mst c ,grievances g , rating_mst r where c.cs_id = g.cat3_id and g.grievance_id = r.grievance_id");
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $cs_list[$row['cat_id']][$row['cs_id']]['desc']=$row['cs_desc'];
		}
			
	    $conn->close();
	    
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	     
		$conn->close();
		$tpl->assign('totals',$totals); 
        $tpl->assign('data',$data); 
        $tpl->assign('data1',$data1); 
        $tpl->assign('data2',$data2); 
        $tpl->assign('data3',$data3); 
        $tpl->assign('data4',$data4); 
        $tpl->assign('tot1',$tot1);
        $tpl->assign('tot2',$tot2);
        $tpl->assign('tot3',$tot3);
        $tpl->assign('tot4',$tot4);
        $tpl->assign('tot5',$tot5);
        $tpl->assign('fdate',$f_date);
        $tpl->assign('tdate',$t_date);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('complaints_rating.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
	}
?>