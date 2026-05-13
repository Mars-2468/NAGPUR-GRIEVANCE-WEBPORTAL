<?php
  require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	


	
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
		
		if(!empty($_POST['save']))
		{
			//$_POST['link']='adfdsfds';

				//echo "<pre>";print_r(!validateField($_POST['designation'], 'text')['valid']);echo "</pre>";die();
				
			if( !validateField($_POST['comm_name'], 'text')['valid'] || 
				!validateField($_POST['comm_name_marathi'], 'text')['valid'] || 
				!validateField($_POST['address'], 'address')['valid'] || 
				!validateField($_POST['address_marathi'], 'address')['valid'] || 
				!validateField($_POST['designation'], 'text')['valid']){
					
			//	echo "<pre>";print_r($_POST);echo "</pre>";die('if');		
					
	//die('in if');				
				$msg  = "Enter Valid name/email/address/designation/mobile...etc!";
				$class = "alert alert-danger display-hide";

				set_flash($msg,$class);
				header('Location: comm_contact.php');
				exit;
			}else{
		
	//echo "<pre>";print_r($_POST);echo "</pre>";die('else');
	
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
								$target_file=base_url()."/grievance/".$target_file;
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
						// assets/cdma/css/aurangabad/images
			
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
								$target_file1=base_url()."/grievance/".$target_file1;
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

				$sql =  "INSERT INTO comm_tab (ulbid,address, address_marathi, link, comm_name, comm_name_marathi, user_type,designation,designation_marathi, mobile, file_url, officebuilding, email, land_line, fax)
						VALUES (
							'".$_SESSION['ulbid']."',
							'". strip_tags($_POST['address']) ."',
							'". strip_tags($_POST['address_marathi']) ."',
							'".mysqli_real_escape_string($conn, strip_tags($_POST['link']))."',
							'". $_POST['comm_name'] ."',
							'". $_POST['comm_name_marathi'] ."',
							'".strip_tags($_POST['user_type'])."',
							'".strip_tags($_POST['designation'])."',
							'".strip_tags($_POST['designation'])."',
							'".strip_tags($_POST['mobile'])."',
							'".$target_file."',
							'".$target_file1."',
							'".strip_tags($_POST['email'])."',
							'".strip_tags($_POST['land_line'])."',
							'".strip_tags($_POST['fax'])."'
						)";
				if(mysqli_query($conn,$sql))
				{
					unset($_POST);
					$class='alert alert-success display-hide';
					$msg='Details Added Successfully ';
				}
				else
				{
					$class='alert alert-danger display-hide';
					$msg='Unable to Process, Please try again';
				}
				
				set_flash($msg,$class);

			header('Location: comm_contact.php');
			exit;
			}
			
		}	
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
	
