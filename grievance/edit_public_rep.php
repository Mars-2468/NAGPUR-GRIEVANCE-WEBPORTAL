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
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		
				if(isset($_POST['update']))
				{
				    
				    if($token_id==$_POST['token']){
				
				$dat=date('dmy');
				if($_POST['ward_id']==''){$_POST['ward_id']=0;}
				$target_dir= "council/".$_SESSION['ulbid']."/";
				if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
					$target_dir= "council/".$_SESSION['ulbid']."/".$_POST['ward_id']."/";
					if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
					}
					
				}
				else
				{
				$target_dir= "council/".$_SESSION['ulbid']."/".$_POST['ward_id']."/";
					if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
					}
				}
				if(is_uploaded_file($_FILES["img_url"]["tmp_name"]))
				{
				$file = $_FILES["img_url"]["name"];
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				
				$ext_array = array("php","css","js","doc","docx","pdf");
				
        			if(in_array($ext,$ext_array))
        				{
        				    die('Image extension is not accepted');
        				}
				
				$newfile =time().$_SESSION['ulbid'].$_POST['ward_id'].".".$ext;
				$target_file = $target_dir. $newfile;
		                move_uploaded_file($_FILES["img_url"]["tmp_name"], $target_file);
                                $target_file="https://" . $_SERVER['HTTP_HOST'] . "/csms/".$target_file;
				}
				else
				{
				$target_file=$_POST['img_url'];
				}
			 
			$name=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['name'])); 
			$designation=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['designation'])); 
			$mobile=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])); 
			$img_url=$target_file;
			$id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['id']));
			
			
     	$sql= "update council_mst set  name=?,designation=?,mobile=?,img_url=? where id=?";
		$query=$conn->prepare($sql);
		$query->bind_param("ssssi",$name,$designation,$mobile,$img_url,$id);
		$result=$query->execute();	
			
		if($result)
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','updated successfully');
				echo "<script>alert('Updated Successfully.');window.location='add_public_rep.php';</script>";
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
			}
			
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
			}
			
		}
		
	    $sql="select ward_id,ward_desc from ward_mst where ulbid=? order by ward_desc";
		$query=$conn->prepare($sql);
		$query->bind_param("s",$_SESSION['ulbid']);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
	        $ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		$query->close();
	
		$id=htmlspecialchars(strip_tags($_REQUEST['id']));
		
		$sql="select * from council_mst where id=?";
		$query=$conn->prepare($sql);
		$query->bind_param("i",$id);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		$data['id']=$row['id'];
		$data['ward_id']=$row['ward_id'];
		$data['name']=$row['name'];
		$data['designation']=$row['designation'];
		$data['mobile']=$row['mobile'];
		$data['img_url']=$row['img_url'];
		}
		$query->close();
	
		
		$conn->close();
		$tpl->assign('ward_list',$ward_list);	
		$tpl->assign('data',$data);	
		$tpl->assign('desg_list',$desg_list);	
		$tpl->assign('ward_list',$ward_list);	
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('edit_public_rep.tpl');
		
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
	}