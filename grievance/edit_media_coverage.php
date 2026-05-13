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
		function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
		
		if(isset($_POST['save']))
		{
		    if($token_id==$_POST['token']){
		        
        $edition_date=date('Y-m-d',strtotime(strip_tags($_POST['edition_date'])));
			 	

 
	 
	$sql="update add_content_media_coverage set title=?,title_marathi=?,description=?,desciption_marathi=?,edition_date=? where content_no=? and ulbid=?";
	$query=$conn->prepare($sql);
	$title=mysqli_real_escape_string($conn,strip_tags($_POST['title']));
	$title_marathi=mysqli_real_escape_string($conn,strip_tags($_POST['title_marathi']));
	$description=mysqli_real_escape_string($conn,strip_tags($_POST['description']));
	$desciption_marathi=mysqli_real_escape_string($conn,strip_tags($_POST['desciption_marathi']));
	$edition_date=date('Y-m-d',strtotime(strip_tags($_POST['edition_date'])));
	$content_no=strip_tags($_POST['content_no']);
	$ulbid=$_SESSION['ulbid'];
	$query->bind_param("sssssis",$title,$title_marathi,$description,$desciption_marathi,$edition_date,$content_no,$_SESSION['ulbid']);
		  if($query->execute())
			{
			$j = 0;
		$target_path = "media_coverages/";     
		for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
		
		$image =$_FILES["file"]["name"][$i];
        $uploadedfile = $_FILES['file']['tmp_name'][$i];
        if($image){
            $filename = stripslashes($_FILES['file']['name'][$i]);
            $extension = strtolower(getExtension($filename));
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")){
                echo 'Unkonwn Extension';
                $errors=1;
            } else{
                $newname = time().$i.".".$extension;
                $size=filesize($_FILES['file']['tmp_name'][$i]);
               
                if($extension=="jpg" || $extension=="jpeg" ){
                    $uploadedfile = $_FILES['file']['tmp_name'][$i];
                    $src = imagecreatefromjpeg($uploadedfile);
                }else if($extension=="png"){
                    $uploadedfile = $_FILES['file']['tmp_name'][$i];
                    $src = imagecreatefrompng($uploadedfile);
                }else{
                    $src = imagecreatefromgif($uploadedfile);
                }
                list($width,$height)=getimagesize($uploadedfile);

                $newwidth=256;
                $newheight=256;
		
                $tmp=imagecreatetruecolor($width,$height);
                imagecopyresampled($tmp,$src,0,0,0,0,$width,$height, $width,$height);

                

               $filename = "media_coverages/".$newname;
               imagejpeg($tmp,$filename,100); //file name also indicates the folder where to save it to
                

                imagedestroy($src);
                imagedestroy($tmp);
                $target_file1="https://aurangabadmahapalika.org/csms/".$filename;
		
		
		
		$sql_img="insert into add_content_image (content_no,images) values(?,?)";
		$query=$conn->prepare($sql_img);
		$content_no = strip_tags($_POST['content_no']);
		$images = $target_file1;
		$query->bind_param("is",$content_no,$images);
		$result=$query->execute();
		
		
		
		 } 
		 }
		 }
		
			 $tpl->assign('class','alert alert-success display-hide');
				$msg="Successfully Updated  Details";

			}
			else
			{
			$tpl->assign('msg','alert alert-danger display-hide');
				$msg="Unable to insert";
			}
			
			$tpl->assign('msg',$msg);
		}

		}

	       
		
		$sql=$conn->prepare("SELECT * FROM add_content_media_coverage where ulbid=? and content_no=?");
	    $content_no=htmlspecialchars(strip_tags($_REQUEST['content_no']));
		$sql->bind_param("si",$_SESSION['ulbid'],$content_no);
		$sql->execute();
	    $rs=$sql->get_result();
	   
		while($row = $rs->fetch_assoc())
		{
		    $data['title']=$row['title'];
		    $data['title_marathi']=$row['title_marathi'];
			$data['description']=$row['description'];
			$data['desciption_marathi']=$row['desciption_marathi'];
			$data['edition_date']=$row['edition_date'];
		}
		
		$sql->close();
		
		
		$conn->close();		
		$tpl->assign('content_no',$_REQUEST['content_no']);
		$tpl->assign('data',$data);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('edit_media_coverage.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
	}
?>