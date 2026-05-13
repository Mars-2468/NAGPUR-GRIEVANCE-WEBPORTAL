<?php
	require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	require_once('csrf.class.php');
    $csrf = new csrf();
	
	$token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
    
	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	}
	
	if(isset($_SESSION['uid']))
	{
	   // session_regenerate_id();
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

			if(!validateField($_POST['date'], 'date')['valid'] || !validateField($_POST['title'], 'text')['valid'] || !validateField($_POST['title_marathi'], 'text')['valid'] || !validateField($_POST['description'], 'sptext')['valid'] || !validateField($_POST['description_marathi'], 'sptext')['valid']){
				$msg  = "Enter Valid date/title/description...!";
				$class = "alert alert-danger display-hide";
				set_flash($msg,$class);
				header('Location: add_notification.php');
				exit;
			}else{
				
				if($token_id==$_POST['token']){                
									
					if(is_uploaded_file($_FILES["photo"]["tmp_name"])){
							//define ("MAX_SIZE","10000");
							$errors=0;

							$image =$_FILES["photo"]["name"];

							$uploadedfile = $_FILES['photo']['tmp_name'];
							if($image){
								$filename = stripslashes($_FILES['photo']['name']);
								$extension = strtolower(getExtension($filename));
								
								/* if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")){
									echo ' Unknown Image extension ';
									$errors=1;
								} else{ */
								
								if (!in_array($extension,["jpg","jpeg","png","gif"])){
									//echo ' Unknown Image extension ';
									$errors=1;
									$msg="Invalid image!";
									$class = "alert alert-danger display-hide";
									set_flash($msg,$class);
									header('Location: add_notification.php');
									exit;
								}else{								
									
									$newname = time().".".$extension;
									$size=filesize($_FILES['photo']['tmp_name']);
								   
									if($extension=="jpg" || $extension=="jpeg" ){
										$uploadedfile = $_FILES['photo']['tmp_name'];
										$src = imagecreatefromjpeg($uploadedfile);
									}else if($extension=="png"){
										$uploadedfile = $_FILES['photo']['tmp_name'];
										$src = imagecreatefrompng($uploadedfile);
									}else{
										$src = imagecreatefromgif($uploadedfile);
									}
									list($width,$height)=getimagesize($uploadedfile);

									$newwidth=256;
								  
									$newheight=256;
							
									$tmp=imagecreatetruecolor($newwidth,$newheight);

									

									imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);

									imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, $width,$height);

									$filename = "notification_images/".$newname;
								  

									imagejpeg($tmp,$filename,100); //file name also indicates the folder where to save it to
									

									imagedestroy($src);
									imagedestroy($tmp);
									// $target_file="http://municipalservices.in/".$filename;
									// $target_file="https://".$_SERVER['SERVER_NAME']."/csms/".$filename;
									$target_file=$_SERVER['HTTP_ORIGIN'].'/grievance/'.$filename;
									
									//var_dump($target_file);die();		
								}
							}
					}else{
						$target_file=$_POST['previous_image'];
					}				
					
					$sql=$conn->prepare("update notification_mst set date=?,title=?,title_marathi=?,description=?,description_marathi=?,photo=? where id=? and ulbid=?");
					$date=date('Y-m-d',strtotime($_POST['date']));
					
					/* $title=mysqli_real_escape_string($conn,$_POST['title']);
					 $title_marathi=mysqli_real_escape_string($conn,$_POST['title_marathi']);
					 $description=mysqli_real_escape_string($conn,$_POST['description']);
					 $description_marathi=mysqli_real_escape_string($conn,$_POST['description_marathi']); */
					 
					$title=$_POST['title']; //mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['title'])));
					$title_marathi=$_POST['title_marathi']; //mysqli_real_escape_string($conn,strip_tags($_POST['title_marathi']));
					$description= $_POST['description']; //$_POST['description'];
					$description_marathi= $_POST['description_marathi']; //$_POST['description_marathi'];
					 
					 $photo=$target_file;
					 $id=$_REQUEST['id'];
					 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
					 $sql->bind_param("ssssssis",$date,$title,$title_marathi,$description,$description_marathi,$target_file,$id,$ulbid);
					if($sql->execute())
					{
						
					
						$class='alert alert-success display-hide';
						$msg="Successfully Updated  Details";
					}
					else
					{
						$class = 'alert alert-danger display-hide';
						$msg="Unable to insert";
					}
					
				}
				
				set_flash($msg,$class);
				header('Location: add_notification.php');
				exit;
			}
		
		}
		
	}else{		
		echo "<script>window.location='index.php';</script>";
	}
