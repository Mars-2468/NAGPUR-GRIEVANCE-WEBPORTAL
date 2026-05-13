<?php
  require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']) )
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();		
		if(isset($_REQUEST['content_no']) || isset($_POST['update']))
		{
		
			if(isset($_POST['update']))
			{
				$target_dir="media_coverages/";
				
				
				if(is_uploaded_file($_FILES['f1']['tmp_name']))
				{
					$file = $_FILES["f1"]["name"];
					$ext = pathinfo($file, PATHINFO_EXTENSION);
					$newfile =time().".".$ext;
					$target_file = $target_dir. $newfile;
					move_uploaded_file($_FILES["f1"]["tmp_name"], $target_file);
				}
				else
				{
				$target_file=$_POST['previous_image'];
				}
				
				
				
				
				
				$sql="update add_content_image set images=? where id=?";
				$query=$conn->prepare($sql);
				$images=$target_file;
				$id=$_POST['imageid'];
				$query->bind_param("si",htmlspecialchars(strip_tags($images)),htmlspecialchars(strip_tags($id)));
		        $query->execute();
				
				$_REQUEST['content_no']=$_POST['content_no'];
				
				
			}
	
			
			
		$sql=$conn->prepare("select * from add_content_image where content_no=?");
		$content_no=$_REQUEST['content_no'];
		$sql->bind_param("i",htmlspecialchars(strip_tags($content_no)));
		$sql->execute();
	    $rs=$sql->get_result();
	   
		while($row = $rs->fetch_assoc())
		{
		    	$data[$row['id']]['images']=$row['images'];
		}
		
		$sql->close();
			
			
			
		}
		else
		{
		header('location:media_coverage.php');
		}
		
		
			
        mysqli_close($conn);
		$tpl->assign('content_no',$_REQUEST['content_no']);
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
		$tpl->display('walpapers.tpl');
	}
	else
	{
	
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>