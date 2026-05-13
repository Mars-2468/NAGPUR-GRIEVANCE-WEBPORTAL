<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	require_once('csrf.class.php');
    $csrf = new csrf();
	$tpl=new Smarty();
	
	
	  $token_id = $csrf->get_token_id(); 
      $token_value = $csrf->get_token($token_id); 
    
	if(isset($_SESSION['uid']))
	{
	    //&& $_SESSION['ip_address']==$_SERVER['REMOTE_ADDR'] && $_SESSION['user_agent']== $_SERVER['HTTP_USER_AGENT']
	   // session_regenerate_id();
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();	
		
		
		    
		if(isset($_POST['save']))
		{
		    
		if($token_id==$_POST['token']){
		    
			if($_POST['update_status']=='0')
			{
              
                
             
             $sql="insert into tanker_mst(taker_number,name,mobile,address,ulbid) values(?,?,?,?,?)";
             $query=$conn->prepare($sql);
             $taker_number = mysqli_real_escape_string($conn,preg_replace('/[^A-Za-z0-9]/', ' ',htmlspecialchars(strip_tags($_POST['taker_number']))));   
             $name= mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',htmlspecialchars(strip_tags($_POST['name'])))));
             $mobile=mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',htmlspecialchars(strip_tags($_POST['mobile'])))));
             $address=mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',htmlspecialchars(strip_tags($_POST['address'])))));
             $ulbid = mysqli_real_escape_string($conn,$_SESSION['ulbid']);
             $query->bind_param("sssss",$taker_number,$name,$mobile,$address,$ulbid);
			}
			else
			{
		
			
			$sql="update tanker_mst set taker_number=?,name=?,mobile=?,address=? where tanker_id=?";
			$query=$conn->prepare($sql);
			$taker_number = mysqli_real_escape_string($conn,preg_replace('/[^A-Za-z0-9]/', ' ',htmlspecialchars(strip_tags($_POST['taker_number']))));
			$name= mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',htmlspecialchars(strip_tags($_POST['name'])))));
			$mobile=mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',htmlspecialchars(strip_tags($_POST['mobile'])))));
            $address=mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',htmlspecialchars(strip_tags($_POST['address'])))));
			$tanker_id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['tanker_id']));
			
			$query->bind_param("ssssi",$taker_number,$name,$mobile,$address,htmlspecialchars(strip_tags($_POST['tanker_id'])));
			
			}
			
			
			if($query->execute())
			{
			    if(!isset($_POST['tanker_id']))
			    {
			    $tanker_id=mysqli_insert_id($conn);
			    }
			    else
			    {
			        $tanker_id=htmlspecialchars(strip_tags($_POST['tanker_id']));
			    }
				$tpl->assign('class','alert alert-success display-hide');
				$msg="Successfully Added  Details";
				
				
				
				
				
			$sql=$conn->prepare("delete from tanker_officer_map where tanker_id=?");
			$tanker_id=mysqli_real_escape_string($conn,strip_tags($tanker_id));
			$sql->bind_param("s",$tanker_id);
		    $sql->execute();
	        $rs=$sql->get_result();	
	        for($i=1; $i<=mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_POST['cnt']))); $i++)
				{
				    $name="name".$i;
				    $mobile="mobile".$i;
				    if(!$_POST[$name]=="")
				    {
				    
				   
				    
				    $sql="insert into tanker_officer_map(tanker_id,name,mobile)values(?,?,?)";
				    $query=$conn->prepare($sql);
				    $tanker_id = mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($tanker_id)));
				    $name = mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_POST[$name])));
				    $mobile = mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_POST[$mobile])));
				    $query->bind_param("sss",$tanker_id,$name,$mobile);
				    }
				
			}
			
				
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$msg="Uable to insert ".$sql;
				}
			
			$tpl->assign('msg',$msg);
		} else {
		    
		    $tpl->assign('msg','alert alert-danger display-hide');
				$msg="Uable to insert ".$sql;
		    
		} 
			$tpl->assign('msg',$msg);
		
		}
		
	$sql=$conn->prepare("SELECT * FROM tanker_mst where ulbid=?");
        $ulbid=mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
        $sql->bind_param("s",$ulbid);
        $sql->execute();
        $rs=$sql->get_result();
        if($rs->num_rows > 0){
            $i=1;
				$field_info = $rs->fetch_fields();
				while($row = $rs->fetch_assoc())
				{
						    foreach($field_info as $fi => $f) 
							$tanker_mst_list[$i][$f->name]=$row[$f->name];
					        $i++;
				}
				       
					$tpl->assign('tanker_mst_list',$tanker_mst_list);
        }
        else{
             $tpl->assign('fail',$msg);
        }
        
	
		
		$sql="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$ulbid = mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		
        $query->execute();
	    $rs=$query->get_result();	
	    while($row =$rs->fetch_assoc())	
		  {
		   $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		  }	
		
	    /*$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid =?";
	    $ulbid = mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	    $query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
	    $rs=$query->get_result();
	    $row=$rs->fetch_assoc();
	      
	      
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
		$query->close();*/
		
	    $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
	    $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('data',$data);
		$tpl->assign('num_emp',$num_emp);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('add-tanker.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
	}
?>