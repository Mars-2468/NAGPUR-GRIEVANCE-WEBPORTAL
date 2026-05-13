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
	    
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();	
		
		mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
		if(isset($_POST['save']))
		{
     		if($token_id==$_POST['token']){
     		
		$cat_id=strip_tags($_POST['cat_id']);
		$desc=strip_tags($_POST['desc']);
		$sub_cat_desc_marathi=strip_tags($_POST['sub_cat_desc_marathi']);
		
		
		
		
		$target_dir="forms/".$_SESSION['ulbid'];
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
			$target_dir= "forms/".$_SESSION['ulbid'];
			if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
			}
					
			}
		
		
		
			$file = $_FILES["f1"]["name"];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			
			
			if($ext=='.pdf' || $ext=='pdf')
			{
		
		    if(is_uploaded_file($_FILES['f1']['tmp_name']))
			{
			
			$newfile =time().$_SESSION['ulbid'].".".$ext;
			
		    $file_url = $target_dir."/".$newfile;	
			// echo 	$file_url;exit;        								
			move_uploaded_file($_FILES['f1']['tmp_name'],$file_url);
			// $file_url ="http://municipalservices.in/aurangabad/".$file_url;	
			$file_url ="https://" . $_SERVER['HTTP_HOST'] . "/csms/".$file_url;			
		    }
		  	
           $sql="insert into form_sub_cat(cat_id,sub_cat_desc,sub_cat_desc_marathi,file_url,ulbid) values (?,?,?,?,?)";
				$query=$conn->prepare($sql);
				$cat_id=strip_tags($_POST['cat_id']);
				$sub_cat_desc=$desc;
				$sub_cat_desc_marathi=$sub_cat_desc_marathi;
				$file_url=$file_url;
				$ulbid=$_SESSION['ulbid'];
				
				$query->bind_param("issss",$cat_id,$sub_cat_desc,$sub_cat_desc_marathi,$file_url,$ulbid);
				
				if($query->execute())
				{
					$tpl->assign('class','alert alert-success display-hide');
					$msg="Saved Successfully";
				}
				else
				{
					$tpl->assign('msg','alert alert-danger display-hide');
					$msg="Unable to save";
				}
				
				
			}
			else{
			         $tpl->assign('msg','Upload only pdf files');
					 
					 
			}
		}

		}
		
		 
		$sql ="select * from form_sub_cat where ulbid=? order by sub_cat_id desc";
		$query=$conn->prepare($sql);
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	    $query->execute();
	    $rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $data[$row['sub_cat_id']]['sub_cat_id']=$row['sub_cat_id'];
		$data[$row['sub_cat_id']]['sub_cat_desc']=$row['sub_cat_desc'];
		$data[$row['sub_cat_id']]['sub_cat_desc_marathi']=$row['sub_cat_desc_marathi'];
		$data[$row['sub_cat_id']]['cat_id']=$row['cat_id'];
		$data[$row['sub_cat_id']]['file_url']=$row['file_url'];
		}
		$query->close();
		
		
		$sql =$conn->prepare("select * from form_cat");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   	$cat_list[$row['cat_id']]=$row['description'];
		}
		$sql->close();
		
	
		
		$sql =$conn->prepare("select * from form_cat");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   $cat_list[$row['cat_id']]=$row['cat_desc'];
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
		
		
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('data',$data);			
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('form_upload.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>