<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
    ini_set('display_errors',0);
    require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		$end_pos = strrpos($_SERVER['REQUEST_URI'], '.php');
		$start_pos = strrpos($_SERVER['REQUEST_URI'], '/');
		$service=substr($_SERVER['REQUEST_URI'],$start_pos+1,$end_pos-$start_pos-1);
		
		
			
			
			
		if(isset($_POST['submit']))
	 	{      
	 	
	            for($i=1; $i<$_POST['file_count']; $i++)
			{
				
				 $req_id="req_id".$i;
				 $mobile="mobile".$i;
				 $amount="amount".$i;
				 $taker_number="taker_number".$i;
				 
				 
				if($_POST[$taker_number] != '0')
				{    
				
				 
				 $sql ="insert into tanker_req_details(taker_number,req_id,status,status_date) values(?,?,?,?)";
				 $status=1;
				 $taker_number=htmlspecialchars(strip_tags($_POST[$taker_number]));
				 $req_id=htmlspecialchars(strip_tags($_POST[$req_id]));
				 $status_date=now();
				 $query=$conn->prepare($sql);
				 $query->bind_param("siis",$taker_number,$req_id,$status,$status_date);
				 
					if($query->execute())
					{
						
						
						$sql2="UPDATE tanker_req SET taker_number=?,status=?,amount=? WHERE req_id=?";
						$status=1;
						$amount=htmlspecialchars(strip_tags($_POST[$amount]));
						$req_id=htmlspecialchars(strip_tags($_POST[$req_id]));
						$taker_number=htmlspecialchars(strip_tags($_POST[$taker_number]));
						$query=$conn->prepare($sql2);
				        $query->bind_param("siii",$taker_number,$status,$amount,$req_id);
						$query->execute();
						$tpl->assign('class','alert alert-success display-hide');
						$msg="Successfully Updated  Details";
					}
					else
					{
						$tpl->assign('class','alert alert-danger display-hide');
						$msg="Unable to insert";
					}
				}
			}
		}	
		

			
			
		$sql=$conn->prepare("SELECT * FROM tanker_req  where status=? and ulbid=? order by req_id asc");
		$status=0;
		$sql->bind_param("is",$status,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    if($rs->num_rows > 0)
			{ $i=1;
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
					foreach($field_info as $fi => $f) 
					$tanker_req_list[$i][$f->name]=$row[$f->name];
					$i++;
			}
			       
				$tpl->assign('tanker_req_list',$tanker_req_list);
			}else
			{    $msg="No records available";
			 	$tpl->assign('class','alert alert-danger display-hide');
			
			}
		
		$sql=$conn->prepare("SELECT taker_number, taker_number FROM tanker_mst");
        $sql->execute();
	    $rs=$sql->get_result();	
	    while($row =$rs->fetch_assoc())	
		  {
		    $taker_list[$row['taker_number']]=$row['taker_number'];
		    $takername_list[$row['taker_number']]=$row['name'];
		  }		
		$tpl->assign('taker_list',$taker_list);	
		$tpl->assign('takername_list',$takername_list);
		
		$sql=$conn->prepare("SELECT status_id,status_desc FROM status_mst where status_id !=0");
	    $sql->execute();
	    $rs=$sql->get_result();
		 while($row =$rs->fetch_assoc())	
		  {
		    $status_list[$row['status_id']]=$row['status_desc'];
		  }	
		
		$sql=$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		 $ward_list[$row['ward_id']]=$row['ward_desc'];
		}
	
		$sql=$conn->prepare("select street_id,street_desc from street_mst where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		 $street_list[$row['street_id']]=$row['street_desc'];
		}
		
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
	    /*$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid =?";
	    $query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
	    $rs=$query->get_result();
	    $row=$rs->fetch_assoc();
	      $query->close();*/
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	    $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('street_list',$street_list);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('status_list',$status_list);
	    $tpl->assign('msg',$msg);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('tanker_req_list',$tanker_req_list);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('tanker_req.tpl');
		
	}
	else
	{
	
	
	echo "<script>window.location='index.php';</script>";
	
	}