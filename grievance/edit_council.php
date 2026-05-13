<?php
require "config.php";
ini_set('display_errors',0);

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

		

		

		

		

		

		

		

				

				

				if(isset($_POST['update']))

				{

				

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

				$newfile =time().$_SESSION['ulbid'].$_POST['ward_id'].".".$ext;

				$target_file = $target_dir. $newfile;

		                if(move_uploaded_file($_FILES["img_url"]["tmp_name"], $target_file))

		                {

		                    	$file_info = new finfo(FILEINFO_MIME_TYPE);

                               $mime_types_array = array('image/jpeg','image/gif','image/bmp','image/gif','image/png');

                               $finopath = $target_file;

		                       $mime_type = $file_info->buffer(file_get_contents($finopath));

		                       if(!in_array($mime_type,$mime_types_array))

                                                {

                                                    unlink($finopath);

                                                    die('Invalid file type');

                                                    

                                                   

                                                }

                                                else

                                                {

                                                    $target_file="https://" . $_SERVER['HTTP_HOST'] . "/csms/".$target_file;

                                                }

					                        

		                    

		                    

                                

		                }

		                else

		                {

		                    $target_file=$_POST['img_url'];

		                }

				}

				else

				{

				$target_file=$_POST['img_url'];

				}

				

				

			$name=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['name'])); 

			$mobile=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])); 

			$img_url=$target_file;

			$id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['id']));

			

			

	/*	$sql="update council_mst set 

		    	        

			name='".strip_tags($_POST['name'])."',	

			mobile='".strip_tags($_POST['mobile'])."',

			img_url='$target_file' where id='".strip_tags($_POST['id'])."'";

			

			if(mysqli_query($conn,$sql))

			{

				$tpl->assign('class','alert alert-success display-hide');

				$tpl->assign('msg','updated successfully');

				echo "<script>alert('Updated Successfully.');window.location='add_council.php';</script>";

			}

			else

			{

				$tpl->assign('msg','alert alert-danger display-hide');

				$tpl->assign('msg','Unable to Process, Please try again');

			}

			*/

			

		$sql= "update council_mst set  name=?,mobile=?,img_url=? where id=?";

		$query=$conn->prepare($sql);

		$query->bind_param("sssi",$name,$mobile,$img_url,$id);

		$result=$query->execute();	

			

		if($result)

			{

				$tpl->assign('class','alert alert-success display-hide');

				$tpl->assign('msg','updated successfully');

				echo "<script>alert('Updated Successfully.');window.location='add_council.php';</script>";

			}

			else

			{

				$tpl->assign('msg','alert alert-danger display-hide');

				$tpl->assign('msg','Unable to Process, Please try again');

			}	

			

			

		}

		

	

		

	

	

	/*$sql ="select ward_id,ward_desc from ward_mst where ulbid='".$_SESSION['ulbid']."' order by ward_desc  ";

		$rs= mysqli_query($conn,$sql);

		while($row =mysqli_fetch_assoc($rs))

		{

		$ward_list[$row['ward_id']]=$row['ward_desc'];

		}*/

	

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

	

	

	   /* $sql ="select * from council_mst where id='".$_REQUEST['id']."'";

		$rs= mysqli_query($conn,$sql);

		while($row =mysqli_fetch_assoc($rs))

		{

		

		$data['id']=$row['id'];

		$data['ward_id']=$row['ward_id'];

		$data['name']=$row['name'];

		//$data['designation']=$row['designation'];

		$data['mobile']=$row['mobile'];

		$data['img_url']=$row['img_url'];

		}*/

		$id=$_REQUEST['id'];

		

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

		//$data['designation']=$row['designation'];

		$data['mobile']=$row['mobile'];

		$data['img_url']=$row['img_url'];

		}

		$query->close();

		

		

			

		

		//print_r($ward_list);

		mysqli_close($conn);

		$tpl->assign('ward_list',$ward_list);	

		$tpl->assign('data',$data);	

		$tpl->assign('desg_list',$desg_list);	

		$tpl->assign('ward_list',$ward_list);	

		$tpl->assign('main_icons',$obj->main_icons);

		$tpl->assign('banner',$_SESSION['banner']);

		$tpl->assign('services',$obj->services);

		$tpl->assign('uid',$_SESSION['uid']);

		$tpl->display('edit_council.tpl');

		

	}

	else

	{

	/*	$tpl->display('user_login.tpl');*/

	

	echo "<script>window.location='index.php';</script>";

	}