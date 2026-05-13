<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		require_once('send_sms.php');
		require_once('sms_conf.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		if(isset($_POST['send_sms']))
		{
			if($_POST['app_type_id']=='2')
			{
			$sms="Dear ".$_POST['app_name']." Pay fees ".$_POST['fee']." regarding to ".$_POST['subject']." and Remarks ".mysqli_real_escape_string($conn,$_POST['message'])."- ".$_SESSION['uid'];
			
			send_sms($sms,$_POST['mobile']);
			
			$tpl->assign('class','alert alert-success display-hide');
			$msg="Message Sent Successfully";
			
			
			}
			else
			{
			$tpl->assign('class','alert alert-danger display-hide');
			$msg="This service only for Services";
			}
			
			$tpl->assign('msg',$msg);
			
		}
		
		if(isset($_POST['search']))
		{
	
		
		$sql="select app_type_id,grievance_id,person_name,email,hno,address,ward_id,
			street_id,mobile,cat3_id,comp_desc,grievance_origin_id,grievance_status_id,date_regd 
			from grievances where  (grievance_id =? or file_no=?) 
			and ulbid=?";
			$query=$conn->prepare($sql);
			$grievance_id=htmlspecialchars(strip_tags($_POST['ref_no']));
			$file_no=htmlspecialchars(strip_tags($_POST['ref_no']));
			$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
			
			$query->bind_param("iis",$grievance_id,$file_no,$ulbid);
			$query->execute();
			$rs = $query->get_result();
			$nr = $rs->num_rows;
		
		if($nr > 0)
			{

				$row = $rs->fetch_assoc();
				$field_info = $rs->fetch_fields();
				if($row['app_type_id']=='1')
				{
					$tpl->assign('class','alert alert-danger display-hide');
					$tpl->assign('msg', "This option only for services ");
				}
				else if($row['grievance_status_id']=='3')
				{
					$tpl->assign('class','alert alert-danger display-hide');
					$tpl->assign('msg', "This service status is already completed ");
				}
				else
				{
					foreach($field_info as $fi => $f) 
					{
						$data[$f->name]=$row[$f->name];
					}
				}

								
				
			}
			else
			{
			$tpl->assign('class','alert alert-danger display-hide');
			$tpl->assign('msg', "Invalid Reference no ");
			}
		
					
			$tpl->assign('data',$data);
		}
		
		
		

			
		$sql =$conn->prepare("select ward_id,ward_desc from ward_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   	$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		$sql->close();	
		
		
			
		$sql =$conn->prepare("select street_id,street_desc from street_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   	$street_list[$row['street_id']]=$row['street_desc'];
		}
		$sql->close();	
			
		
			
		$sql =$conn->prepare("select grievance_status_id,grievance_status_desc from grievance_status_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   		$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		$sql->close();		
		
			
		$sql =$conn->prepare("select grievance_origin_id,grievance_origin_desc from grievance_origin_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   		$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		$sql->close();		
			
		
			
		$sql =$conn->prepare("select dept_id,dept_desc from dept_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   		$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		$sql->close();		
		
        $sql =$conn->prepare("select desg_id,desg_desc from desg_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   	$desg_list[$row['desg_id']]=$row['desg_desc'];
		}
		$sql->close();	
        

			
		$sql =$conn->prepare("select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   	    $empt_list[$row['emp_id']]['emp_name']=$row['emp_name'];
				$empt_list[$row['emp_id']]['emp_mobile']=$row['emp_mobile'];
				$empt_list[$row['emp_id']]['emp_dept']=$dept_list[$row['emp_dept']];
				$empt_list[$row['emp_id']]['emp_desg']=$desg_list[$row['emp_desg']];
		}
		$sql->close();	
			
		
		$sql =$conn->prepare("select * from category3_mst where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   	    $cat3_list[$row['cs_id']]=$row['comp_desc'];
		}
		$sql->close();
		

        $sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $online_applications['trade_application']=$row['trade_application'];
		  $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$query->close();
		
		/*$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
    		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    		$sql->execute();
    		$rs=$sql->get_result();
    		$row = $rs->fetch_assoc();
    		$sql->close();*/
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	     $tpl->assign('user_type',$_SESSION['user_type']);
		 $tpl->assign('online_applications',$online_applications);
			$conn->close();
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('cat3_list',$cat3_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('street_list',$street_list);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);
		$tpl->assign('empt_list',$empt_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('send_sms_individual.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
		
		
	}
?>