<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		
		require_once('prepare_connection.php');
		
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		if(isset($_GET['grievance_id']))
		{
		    if(is_numeric($_GET['grievance_id']))
		    {
			  $sql="select lat,lng,ulbid,grievance_id,person_name,park_name,email,hno,address,ward_id,street_id,mobile,cat3_id,comp_desc,comp_subject,grievance_origin_id,grievance_status_id,date_regd,file_url,app_type_id,grievance_at_emp_level from grievances where grievance_id =?";
			  
			            $grievance_id = htmlspecialchars(strip_tags($_GET['grievance_id']));
			            $app_type_id=$_REQUEST['app_type_id'];
        	            $disposal_status = 5;
        	            $ulbid = $_SESSION['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $grievance_status_id = 6;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("i",$grievance_id);
			
			if($query->execute())
			{
                $rs=$query->get_result();
				$row =$rs->fetch_assoc();
				$app_type_id=$row['app_type_id'];
				$field_info = $rs->fetch_fields();
				foreach($field_info as $fi => $f) 
					$data[$f->name]=$row[$f->name];

                $query->close();
                
				if($row['grievance_status_id']<>1)
				{
					$sql="select transaction_id,dept_id,desg_id,emp_id,alloted_date,disposed_date,disposal_status,disposal_remarks,emp_level from grievances_transactions where  grievance_id =? order by transaction_id asc";
					 $query=$conn->prepare($sql);
					$query->bind_param("i",$grievance_id);
					
					if($query->execute())
					{
					    
					    $rs1=$query->get_result();
					    $field_info = $rs1->fetch_fields();
					    
						while($row1 = $rs1->fetch_assoc())
						{
							foreach($field_info as $fi => $f) 
								$data['transactions'][$row1['transaction_id']][$f->name]=$row1[$f->name];
						}
						
						$query->close();
					}
					else
					{
					    echo "something went wrong 2";
					}
				}					
				
			}
			else
				echo "something went wrong 1";	
						
			$tpl->assign('data',$data);
		    }
		    else
		    {
		        die('Invalid data submition');
		    }
		}
		
		//echo "<pre>";print_r($data['grievance_at_emp_level']);echo "</pre>";die();		
		$sql="select c.cs_id,c.cs_desc,cm.cat_id,cm.description from cs_mst c, category_mst cm where c.cat_id=cm.cat_id";
		$query=$conn->prepare($sql);
        
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				//$cat_list[$row['cs_id']]=$row['description'];
				$cat_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		$sql="select ward_id,ward_desc from ward_mst";
		$query=$conn->prepare($sql);
        
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
		echo "something went wrong 3";	
		
		$query->close();
			
		$sql="select street_id,street_desc from street_mst";
		$query=$conn->prepare($sql);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$street_list[$row['street_id']]=$row['street_desc'];
		}
		else
			echo "something went wrong 4 ";	
			$query->close();
			
		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst";
		$query=$conn->prepare($sql);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		else
			echo "something went wrong 5 ";
			$query->close();

		$sql="select grievance_origin_id,grievance_origin_desc from grievance_origin_mst";
		$query=$conn->prepare($sql);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		else
			echo "something went wrong 6";
			
			if($app_type_id =='1')
			{
			    $grievance_origin_list[0]='Website';
			}
			else
			{
			    $grievance_origin_list[0]='Counter';
			}
        $query->close();
		$sql="select dept_id,dept_desc from dept_mst";
		$query=$conn->prepare($sql);
		if($query->execute())
		{
		     $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		else
			echo "something went wrong 7";
			$query->close();
		$sql="select desg_id,desg_desc from desg_mst";
		$query=$conn->prepare($sql);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$desg_list[$row['desg_id']]=$row['desg_desc'];
		}
		else
			echo "something went wrong 8";	
		$query->close();

		$sql='select emp_id,emp_dept,emp_desg,emp_code,emp_name,emp_mobile from emp_mst';
		$query=$conn->prepare($sql);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
						
			$field_info = $rs->fetch_fields();					    
					    
			while($row1 = $rs->fetch_assoc())
			{
				foreach($field_info as $fi => $f) 
					$emp_list[$row1['emp_id']][$f->name]=$row1[$f->name];
			}
		}			
		
		if($query->execute())
		{
		    $rs1=$query->get_result();	 
			while($row = $rs1->fetch_assoc())
			{			    
				$empt_list[$row['emp_id']]['emp_name']=$row['emp_name'];
				$empt_list[$row['emp_id']]['emp_mobile']=$row['emp_mobile'];
				$empt_list[$row['emp_id']]['emp_dept']=$dept_list[$row['emp_dept']];
				$empt_list[$row['emp_id']]['emp_desg']=$desg_list[$row['emp_desg']];
				$empt_list[$row['emp_id']]['emp_code']=$row['emp_code'];
			} 
		}
		else
		echo "something went wrong 9";
		$query->close();		
	
 //echo "<pre>";print_r($empt_list);echo "</pre>";die();		
		
		$sql ="select * from category3_mst where ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		
		if($query->execute())
		{
    		$rs=$query->get_result();
			while($row = $rs->fetch_assoc())
			{
    		$cat3_list[$row['cs_id']]=$row['comp_desc'];
    		}
		}
		else
		{
		    echo "something went wrong 10";
		}
		
		$sql = "select * from ulbmst" ;
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		
			 $ulblist[$row['ulbid']]=$row['ulbname'];
		}

        $query->close();
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('ulblist',$ulblist);
		$tpl->assign('desg_list',$desg_list);			
		$tpl->assign('emp_list',$emp_list);			
		$tpl->assign('cat3_list',$cat3_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('street_list',$street_list);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);
		$tpl->assign('empt_list',$empt_list);		
		
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);		
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);	
		$tpl->assign('user_type', $_SESSION['user_type']);
		$tpl->display('corp_view_search_comp_det_admin.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
	}
?>