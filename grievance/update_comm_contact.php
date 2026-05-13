<?php
require "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    date_default_timezone_set('Asia/Calcutta');

	require_once('Smarty.class.php');
	$tpl=new Smarty();
	//echo "<pre>";print_r($_FILES);echo "</pre>";die();
	if(isset($_SESSION['uid']))
	{
	    
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
        mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		$errors = [];

//echo "<pre>";print_r($_POST['designation']);echo "</pre>";		
//echo "<pre>";print_r(!validateField($_POST['designation'], 'spcontent')['valid']);echo "</pre>";die();		
	
		if(isset($_POST['save']))
		{
			
		
			
			if( !validateField($_POST['comm_name'], 'text')['valid'] || 
				!validateField($_POST['comm_name_marathi'], 'text')['valid'] || 
				//!validateField($_POST['address'], 'address')['valid'] || 
				//!validateField($_POST['address_marathi'], 'address')['valid'] || 
				!validateField($_POST['designation'], 'spcontent')['valid']){					
			
//die('if');	
			
				//die('in if');				
				$msg  = "Enter Valid name/email/address/designation/mobile...etc!";
				$class = "alert alert-danger display-hide";

				set_flash($msg,$class);
				header('Location: comm_contact.php');
				exit;
				
			}else{			
				
//die('else');	
				
					$maxsize = 5000000;
					if(is_uploaded_file($_FILES['f1']['tmp_name']))
					{
					   
						$target_dir= "comm_address/";
						
						$file = $_FILES["f1"]["name"];
						$ext = pathinfo($file, PATHINFO_EXTENSION);
						if (!in_array($ext,["jpg","jpeg","png","gif"])){
                            //echo ' Unknown Image extension ';
                            $errors=1;
							$msg="Invalid image!";
							$class = "alert alert-danger display-hide";
							set_flash($msg,$class);
							header('Location: comm_contact.php');
							exit;
                        }	
						$newfile =time().$_SESSION['ulbid'].".".$ext;
						$target_file = $target_dir. $newfile;
						
						if(($_FILES['f1']['size'] >= $maxsize) || ($_FILES["f1"]["size"] == 0)) {
							$errors[] = 'profile image too large. File must be less than 5 megabytes.';
							// die('File too large. File must be less than 5 megabytes.');
						}
						else{
						   
							if(move_uploaded_file($_FILES["f1"]["tmp_name"], $target_file))
							{
								//$target_file="https://nmcnagpur.gov.in/grievance/".$target_file;
								$target_file=$bsurl."/grievance/".$target_file;
							}
							else
							{
							   $target_file=$_POST['previous_image'];	
							}
						}
					}
					else
					{
					  $target_file=$_POST['previous_image'];
					}
					
				   
					  
					if(is_uploaded_file($_FILES['f2']['tmp_name']))
					{
			
						$target_dir= "comm_address/";
						$file = $_FILES["f2"]["name"];
						$ext = pathinfo($file, PATHINFO_EXTENSION);
						if (!in_array($ext,["jpg","jpeg","png","gif"])){
                            //echo ' Unknown Image extension ';
                            $errors=1;
							$msg="Invalid image!";
							$class = "alert alert-danger display-hide";
							set_flash($msg,$class);
							header('Location: comm_contact.php');
							exit;
                        }	
						$newfile =time().$_SESSION['ulbid'].".".$ext;
						$target_file1 = $target_dir. $newfile;
						if(($_FILES['f2']['size'] >= $maxsize) || ($_FILES["f2"]["size"] == 0)) {
							$errors[] = 'Office Building image too large. File must be less than 5 megabytes.';
							// die('File too large. File must be less than 5 megabytes.');
						}
						else{
							if(move_uploaded_file($_FILES["f2"]["tmp_name"], $target_file1))
							{
								//$target_file1="https://nmcnagpur.gov.in/grievance/".$target_file1;
								$target_file1=$bsurl."/grievance/".$target_file1;
							}
							else
							{
								$target_file1=$_POST['previous_building_image'];
							}
						}
						
					}
					else
					{
					  $target_file1=$_POST['previous_building_image'];
					}
			 
				/* 
				  $sql ="update comm_tab set address='".$_POST['address']."',
						address_marathi='".$_POST['address_marathi']."',
						link='".trim(mysqli_real_escape_string($conn,strip_tags($_POST['link'])))."',
						comm_name='".$_POST['comm_name']."',
						comm_name_marathi='".$_POST['comm_name_marathi']."',
						user_type='".strip_tags($_POST['user_type'])."',
						designation='".strip_tags($_POST['designation'])."',
						mobile='".strip_tags($_POST['mobile'])."',
						file_url='".$target_file."',
						officebuilding='".$target_file1."',
						email='".strip_tags($_POST['email'])."',
						land_line='".strip_tags($_POST['land_line'])."',
						fax='".strip_tags($_POST['fax'])."',
						address='".$_POST['address']."',
						sortorder='".$_POST['sortorder']."',
						link='".strip_tags($_POST['link'])."' where id='".strip_tags($_POST['id'])."'"; 
 */
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 $stmt = $conn->prepare("UPDATE comm_tab SET 
    address=?,
    address_marathi=?,
    link=?,
    comm_name=?,
    comm_name_marathi=?,
    user_type=?,
    designation=?,
    mobile=?,
    file_url=?,
    officebuilding=?,
    email=?,
    land_line=?,
    fax=?,
    sortorder=?
    WHERE id=?");

$stmt->bind_param(
    "ssssssssssssssi",
    $_POST['address'],
    $_POST['address_marathi'],
    $_POST['link'],
    $_POST['comm_name'],
    $_POST['comm_name_marathi'],
    $_POST['user_type'],
    $_POST['designation'],
    $_POST['mobile'],
    $target_file,
    $target_file1,
    $_POST['email'],
    $_POST['land_line'],
    $_POST['fax'],
    $_POST['sortorder'],
    $_POST['id']
); 

//$stmt->execute();
//mysqli_query($conn,$sql)

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
if(!$stmt->execute()){
    //die("Execute failed: " . $stmt->error);
	$class ='alert alert-danger display-hide';
	$msg='Unable to Process, Please try again';
}else{
    //echo "Updated successfully";
	$class='alert alert-success display-hide';
	$msg='Details Updated Successfully ';
}

				/* if($stmt->execute())
				{
					$class='alert alert-success display-hide';
					$msg='Details Updated Successfully ';
				}
				else
				{
					$class ='alert alert-danger display-hide';
					$msg='Unable to Process, Please try again';
				} */

				set_flash($msg,$class);
				
				header('Location: comm_contact.php');
				exit;
			}
				set_flash($msg,$class);
				
				header('Location: comm_contact.php');
				exit;
		}
		
		
           $sql="select * from comm_tab where ulbid='".$_SESSION['ulbid']."' and id='".strip_tags($_POST['id'])."'";
		   $i=1;
		   $rs=mysqli_query($conn,$sql);
		   $tot_row=mysqli_num_rows($rs);
		   if(mysqli_num_rows($rs)>0)
			{
			$key = 0;
				
				while($row = mysqli_fetch_assoc($rs))
				{
				
					
					$data['comm_name']=$row['comm_name'];
                    $data['user_type']=$row['user_type'];
					$data['comm_name_marathi']=$row['comm_name_marathi'];
					$data['designation']=$row['designation'];
					$data['designation_marathi']=$row['designation_marathi'];
					$data['mobile']=$row['mobile'];
					$data['file_url']=$row['file_url'];
					$data['email']=$row['email'];
					$data['land_line']=$row['land_line'];
					$data['fax']=$row['fax'];
					$data['address']=$row['address'];
					$data['address_marathi']=$row['address_marathi'];
					$data['link']=$row['link'];
					$data['officebuilding']=$row['officebuilding'];
					$data['id']=$row['id'];
					$key++;
				}
				$tpl->assign('data',$data);
				$tpl->assign('comm_data',$rs);
				
		 }
			
			
			$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}

        $sql ="SELECT * FROM `wing_department_mst` ";
		$rs =mysqli_query($conn,$sql);
		$des_key = 0;
		while($row = mysqli_fetch_assoc($rs))
		{
			
		    $departments[$des_key]['id']=$row['id'];
		    $departments[$des_key]['title']=$row['title'];
		    $departments[$des_key]['marathi_title']=$row['marathi_title'];
			$des_key++;
		}
        $tpl->assign('departments',$departments);
		
		  $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	     
		mysqli_close($conn);
		
	//	print_r($online_applications);
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
			
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);	
		$tpl->assign('data',$data);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$flash = get_flash();		
		$tpl->assign("flash", $flash);
		$tpl->display('edit_comm_contact.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
	
