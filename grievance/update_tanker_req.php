<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors',1);
require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		$end_pos = strrpos($_SERVER['REQUEST_URI'], '.php');
		$start_pos = strrpos($_SERVER['REQUEST_URI'], '/');
		$service=substr($_SERVER['REQUEST_URI'],$start_pos+1,$end_pos-$start_pos-1);
		
		
		if(isset($_POST['save']))
	 	{      
	            for($i=1; $i<$_POST['file_count']; $i++)
			{
				
				  $status="status".$i;
				  $req_id="req_id".$i;
				  $amount_received="amount_received".$i;
				 
				  $delivery_date="delivery_date".$i;
				 
				if($_POST[$status] == '3')
				{
	
				   
		$sql="insert into tanker_req_details(taker_number,req_id,status,status_date) values(?,?,?,?)";	
		
		         $status=htmlspecialchars(strip_tags($_POST[$status]));
				 $taker_number=htmlspecialchars(strip_tags($_POST[$taker_number]));
				 $req_id=htmlspecialchars(strip_tags($_POST[$req_id]));
				 $status_date=htmlspecialchars(strip_tags($_POST[$delivery_date]));
				 $query=$conn->prepare($sql);
				 $query->bind_param("siis",$taker_number,$req_id,$status,$status_date);
				   
					if($query->execute())
					{
					
					$sql2="UPDATE tanker_req SET status=?,amount_received=?,delivery_date=? WHERE req_id=?";
						$status = htmlspecialchars(strip_tags($_POST[$status]));
						$amount_received = htmlspecialchars(strip_tags($_POST[$amount_received]));
						$delivery_date = htmlspecialchars(strip_tags($_POST[$delivery_date]));
						$req_id = htmlspecialchars(strip_tags($_POST[$req_id]));
					
						$query=$conn->prepare($sql2);
				        $query->bind_param("iisi",$status,$amount_received,$delivery_date,$req_id);
						$query->execute();
						$tpl->assign('class','alert alert-success display-hide');
						$msg="Successfully Updated  Details";	
						
						
					}
					else
					{
						$tpl->assign('fail','Unable to insert');
					}
				}
			else if ($_POST[$status] == '2')
				{       
		
					    
					    
				  $sql2 ="UPDATE tanker_req_details SET status=?,status_date=? where req_id=? and  taker_number=? and status in (?) ";
		          $query=$conn->prepare($sql2);
		          $statusi= array(1,3);
		          $inclause = implode(',', $statusi);
        		  $status=2;
        		  $status_date=htmlspecialchars(strip_tags($_POST[$delivery_date]));
        		  $req_id=htmlspecialchars(strip_tags($_POST[$req_id]));
        		  $taker_number=htmlspecialchars(strip_tags($_POST[$taker_number]));
        		 
        	      $query->bind_param("isiss",$status,$status_date,$req_id,$taker_number,$inclause);
        	      $query->execute();
        	      $rs=$query->get_result();	    
				  $tpl->assign('suc','Record inserted successfully');	    
					    
				 
						
				  $sql2 ="UPDATE tanker_req  SET status=?,amount_received=?,delivery_date=? WHERE req_id=?";
		          $query=$conn->prepare($sql2);
		          
        		  $status=htmlspecialchars(strip_tags($_POST[$status]));
        		  $amount_received=htmlspecialchars(strip_tags($_POST[$amount_received]));
        		  $req_id=htmlspecialchars(strip_tags($_POST[$req_id]));
        		  $delivery_date=htmlspecialchars(strip_tags($_POST[$delivery_date]));
        		 
        	      $query->bind_param("iisi",$status,$amount_received,$delivery_date,$req_id);
        	      $query->execute();
        	      $rs=$query->get_result();	    
				  $tpl->assign('suc','Record inserted successfully');		

						
				}
				else
				{
				}
			}
		}	
		
		
		$sql="SELECT * FROM tanker_req where status in (?) and ulbid=? order by req_id asc";	
		$query=$conn->prepare($sql);
		
			 $status = array(1,3);
		     $inclause = implode(',',$status);
		     $ulbid=	$_SESSION['ulbid'];
		     $query->bind_param("ss",$inclause,$ulbid);
		     $query->execute();
	         $rs=$query->get_result();
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
			{   $msg="No records available";
			   $tpl->assign('fail',$msg);
			}
	       
		$sql=$conn->prepare("SELECT taker_number, taker_number FROM tanker_mst");
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   $taker_list[$row['taker_number']]=$row['taker_number'];
		}
		
		
		$sql=$conn->prepare("SELECT status_id,status_desc FROM status_mst where status_id =?");
		$status_id=2;
		$sql->bind_param("i",$status_id);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $status_list[$row['status_id']]=$row['status_desc'];
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
	      
	      
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	    
	    $conn->close();*/
	    
		$tpl->assign('user_type',$_SESSION['user_type']);
    	$tpl->assign('online_applications',$online_applications);
    	$tpl->assign('status_list',$status_list);
    	$tpl->assign('tanker_req_list',$tanker_req_list);
		
	
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('assign_provider_list',$assign_provider_list);
		$tpl->assign('status_list',$status_list);
		$tpl->assign('provide_list',$provide_list);	
		$tpl->assign('citizen_req_list',$citizen_req_list);
		$tpl->assign('cs_list',$cs_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('update_tanker_req.tpl');
		
	}
	else
	{
	
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>