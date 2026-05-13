<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();		
		if(isset($_POST['save']))
		{
		        
		
				$errors=0;
				
				for($i=1; $i<=$_POST['cnt']; $i++)
				{
				    $tanker_id="tanker_id".$i;
				    
				    if(!$_POST[$tanker_id]=="")
				    {
				    
				  
				    $sql= "insert into water_tanker_emp_map(water_tank_id,emp_id1,emp_id2,ulbid) values(?,?,?,?)";
                    $water_tank_id=htmlspecialchars(strip_tags($_POST[$tanker_id]));
                     $emp_id1=htmlspecialchars(strip_tags($_POST['emp_id1']));
                     $emp_id2=htmlspecialchars(strip_tags($_POST['emp_id2']));
                     $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
                     $query=$conn->prepare($sql);
                     $query->bind_param("iiis",$water_tank_id,$emp_id1,$emp_id2,$ulbid);
                     $result=$query->execute();
    				    if($result)
    				    {
    				        $errors++;
    				    }
				    }
				}
				
				if($errors > 0)
				{
				    $tpl->assign('msg','Employees mapped successfully');
				}
				else
				{
				    $tpl->assign('msg','Unable to insert , try again');
				}
				
				
			}
			
		
	
		 $sql ="SELECT w.*,wt.water_tank_desc FROM water_tanker_emp_map w,water_tank_det_mst wt where wt.water_tank_id=w.water_tank_id 
		 and w.ulbid=?";
		 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $query=$conn->prepare($sql);
		 $query->bind_param("s",$ulbid);
         $query->execute();
		 $rs =$query->get_result();
		  
			    
				$field_info = $rs->fetch_fields();
				while($row = $rs->fetch_assoc())
				{
				    
				        $water_tanker_list2[$row['water_tank_id']]=$row['water_tank_desc'];
						foreach($field_info as $fi => $f) 
							$data[$row['water_tank_id']][$f->name]=$row[$f->name];
							 
				}
				       
					
			

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
		// water tanker list
		
		$sql ="SELECT * FROM `water_tank_det_mst`  where ulbid=? and 
		water_tank_id NOT IN(select water_tank_id from water_tanker_emp_map)";
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $water_tanker_list[$row['water_tank_id']]=$row['water_tank_desc'];
		    
		}
		
		
		
		$sql ="SELECT * FROM `dept_mst` where ulbid=?";
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $dept_list[$row['dept_id']]=$row['dept_desc'];
		    
		}
		
	
		$sql ="SELECT * FROM `emp_mst` where ulbid=?";
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		     $emp_list[$row['emp_id']]=$row['emp_name'];
		    
		}
		
	
		$sql ="SELECT * FROM `emp_mst_od` where ulbid=?";
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		     $emp_list[$row['emp_id']]=$row['emp_name'];
		    
		}
		
		
		$conn->close();

	$tpl->assign('user_type',$_SESSION['user_type']);
	
		
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('data',$data);
		$tpl->assign('water_tanker_list2',$water_tanker_list2);
		$tpl->assign('water_tanker_list',$water_tanker_list);
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('num_emp',$num_emp);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('add_water_supply_tankers.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>