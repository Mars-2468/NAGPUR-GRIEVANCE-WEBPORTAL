<?php
require "config.php";
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
		
		if(isset($_POST['update']))
		{
     		if($token_id==$_POST['token']){
     		    
		$cat_id=$_POST['cat_id'];
		$desc=$_POST['desc'];
		$sub_cat_desc_marathi=$_POST['sub_cat_desc_marathi'];
		
		if($_FILES["f1"]["name"]=='')
		{
		 $file_url=$_POST['pdf'];
		}else{
		$target_dir="forms/".$_SESSION['ulbid'];
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
			$target_dir= "forms/".$_SESSION['ulbid'];
			if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
			}
					
			}
		
		
		    if(is_uploaded_file($_FILES['f1']['tmp_name']))
		
		    {
			$file = $_FILES["f1"]["name"];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$newfile =time().$_SESSION['ulbid'].".".$ext;	    
		        $file_url = $target_dir."/".$newfile;		        								
			move_uploaded_file($_FILES['f1']['tmp_name'],$file_url);
			// $file_url ="http://municipalservices.in/aurangabad/".$file_url;					
			$file_url ="http://43.242.214.64/csms/".$file_url;					
		    }
		    }
		  	
   
				$sql="update form_sub_cat set cat_id=?,sub_cat_desc=?,sub_cat_desc_marathi=?,file_url=? where ulbid=? and sub_cat_id=?";
				$query=$conn->prepare($sql);
				$cat_id=strip_tags($_POST['cat_id']);
				$sub_cat_desc=htmlspecialchars(strip_tags($desc));
				$sub_cat_desc_marathi=htmlspecialchars(strip_tags($sub_cat_desc_marathi));
				$file_url=$file_url;
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$sub_cat_id=htmlspecialchars(strip_tags($_POST['cat']));
				$query->bind_param("issssi",$cat_id,$sub_cat_desc,$sub_cat_desc_marathi,$file_url,$ulbid,$sub_cat_id);
				
				if($query->execute())
				{
					
					$tpl->assign('class','alert alert-success display-hide');
					$msg="Updated Successfully";
				
					?>
					<script type="text/javascript">location.href = 'form_upload.php';</script>
					<?php
				}
				else
				{
					$tpl->assign('msg','alert alert-danger display-hide');
					$msg="Unable to update";
					
				}
				
				$tpl->assign('msg',$msg);
		}

		}
		
	
		$sql ="select * from form_sub_cat where ulbid=? and sub_cat_id=?";
		$query=$conn->prepare($sql);
		$sub_cat_id=$_REQUEST['sub_cat_id'];
		$query->bind_param("si",htmlspecialchars(strip_tags($_SESSION['ulbid'])),htmlspecialchars(strip_tags($sub_cat_id)));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $data['sub_cat_id']=$row['sub_cat_id'];
		$data['sub_cat_desc']=$row['sub_cat_desc'];
		$data['sub_cat_desc_marathi']=$row['sub_cat_desc_marathi'];
		$data['cat_id']=$row['cat_id'];
		$data['file_url']=$row['file_url'];
		$cat=$row['cat_id'];
		}
		$query->close();
		
		
		$sql =$conn->prepare("select * from category_mst");
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
		
		
		
		
		
		
		$tpl->assign('cat',$cat);
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
		$tpl->display('update_form.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
		
	}
?>