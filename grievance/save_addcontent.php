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
		$conn=getconnection();	
		include('prepare_connection.php');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');	
		
		if(isset($_POST['save']))
		{
		    if($token_id==$_POST['token']){
				// Resizin image
    			if(is_uploaded_file($_FILES["img_url"]["tmp_name"]))
    			{		    
                    //define ("MAX_SIZE","10000");
                    $errors=0;
    
                    $image =$_FILES["img_url"]["name"];
                    $uploadedfile = $_FILES['img_url']['tmp_name'];
                    if($image){
                        $filename = stripslashes($_FILES['img_url']['name']);
                        $extension = strtolower(getExtension($filename));						
						//var_dump(in_array($extension,["jpg","jpeg","png","gif"]));die();
						
                        if (!in_array($extension,["jpg","jpeg","png","gif"])){
                            //echo ' Unknown Image extension ';
                            $errors=1;
							$msg="Invalid image!";
							$class = "alert alert-danger display-hide";
							set_flash($msg,$class);
							header('Location: addcontent.php');
							exit;
                        } else{
                            $newname = time().".".$extension;
                            $size=filesize($_FILES['img_url']['tmp_name']);
                           
                            if($extension=="jpg" || $extension=="jpeg" ){
                                $uploadedfile = $_FILES['img_url']['tmp_name'];
                                $src = imagecreatefromjpeg($uploadedfile);
                            }else if($extension=="png"){
                                $uploadedfile = $_FILES['img_url']['tmp_name'];
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
            
                            $filename = "media/".$newname;
            
                            imagejpeg($tmp,$filename,100); //file name also indicates the folder where to save it to
                        
                            imagedestroy($src);
                            imagedestroy($tmp);
                            // $target_file="http://municipalservices.in/aurangabad/".$filename;
                            $target_file=base_url() . "/grievance/".$filename;
                            
            			}
            		}
            	}
            	else
    			{
    			    $target_file="";
    			}	
    			
        		$sql ="insert into add_content (edition_no,description,img_url,ulbid) values(?,?,?,?)";
        		$edition_no=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['edition_no']));
                // $description=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['description']));
                $description=htmlspecialchars(strip_tags($_POST['description']));
        		$img_url=$target_file;
    		    $ulbid =htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$query=$conn->prepare($sql);
				$query->bind_param("issi",$edition_no,$description,$img_url,$ulbid);
				$result=$query->execute();
                
        		if($result)
        		{
        			$class='alert alert-success display-hide';
        			$msg="Successfully Updated  Details";  
        		}
        		
        		else
        		{
        			$class = 'alert alert-danger display-hide';
        			$msg="Uable to insert   ".mysqli_error();
        				
        		}
                $class = "alert alert-success display-hide";
				set_flash($msg,$class);
				header('Location: addcontent.php');
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
