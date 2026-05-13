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
		
		/* if(isset($_POST['save']))
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
						
                        if (in_array($extension,["jpg","jpeg","png","gif"])){
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
                
                // $query  =   $conn->prepare("INSERT INTO add_content (`edition_no`, `description`, `img_url`, `ulbid`) VALUES (?, ?, ?)");
                // # Bind parameters and spell "password" correctly
                // $query->bind_param('isss', $edition_no,$description,$img_url,$ulbid);
                // # Execute
                // $query->execute();
                # See if the row was created and echo success
                // echo ($query->affected_rows > 0)? 'Success!' : 'Failed';

                    $query=$conn->prepare($sql);
                	$query->bind_param("issi",$edition_no,$description,$img_url,$ulbid);
                	$result=$query->execute();
                
        		if($result)
        		{
        			$tpl->assign('class','alert alert-success display-hide');
        			$msg="Successfully Updated  Details";  
        		}
        		
        		else
        		{
        			$tpl->assign('msg','alert alert-danger display-hide');
        			$msg="Uable to insert   ".mysqli_error();
        				
        		}
                $tpl->assign('msg',$msg);

            }

		} */

	    $sql=$conn->prepare("SELECT * FROM add_edition where ulbid=?");
	    $ulbid =htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   $edition_list[$row['id']]=$row['edition_no']; 
		}
		
		$sql="select * from add_content where ulbid=?";
		 
 	    
		//$query="select count(*)as num from add_content where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";	
		$query=$conn->prepare("select count(*)as num from add_content where ulbid=?");
		$query = "select count(*)as num from add_content where ulbid='".$_SESSION['ulbid']."'";
	    
	    
		
		////////////////////pagination
		
		//$tbl_name="nalgonda_survey";		//your table name
		// How many adjacent pages should be shown on each side?
		$adjacents = 5;
		

		
	
   	    $result=mysqli_query($conn,$query);
		$total_pages = mysqli_fetch_array(mysqli_query($query));
		while($row=mysqli_fetch_assoc($result))
		{
	        $total_pages = $row['num'];
	    }
	    
	  	    
	    //print_r($total_pages);
	    
		//echo $total_pages;
		/* Setup vars for query. */
		$targetpage = "addcontent.php"; 	//your file name  (the name of this file)
		$limit = 20; 								//how many items to show per page
		$page = $_GET['page'];
		if($page) 
			$start = ($page - 1) * $limit; 			//first item to display on this page
		else
			$start = 0;								//if no page var is given, set start to 0
		
		/* Get data. */
	        $sql.=" order by id desc LIMIT $start, $limit";
	        //echo $sql;
	        //$sql. = "SELECT * FROM $tbl_name order by submission_date desc LIMIT $start, $limit";
		//$rs = mysql_query($sql);
		
		/* Setup page vars for display. */
		
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//previous page is page - 1
		$next = $page + 1;
		//next page is page + 1
		//echo $total_pages;
	 $lastpage =ceil($total_pages/$limit);
	
		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;						//last page minus 1
		
		 //echo $lastpage;
		$pagination = "";
		if($lastpage > 1)
		{	
			$pagination .= "<div class=\"pagination\">";
			//previous button
			if ($page > 1) 
				$pagination.= "<a href=\"$targetpage?page=$prev\"><< previous</a>";
			else
				$pagination.= "<span class=\"disabled\"><< previous</span>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
				$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
				$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
				}
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination.= "<a href=\"$targetpage?page=$next\">next >></a>";
			else
				$pagination.= "<span class=\"disabled\">next >></span>";
			 $pagination.= "</div>\n";
		  	
		}  	
		
		
	//	echo $sql;
		
		
		////////////////////pagination end
    	$query=$conn->prepare($sql);	
    	$ulbid =mysqli_real_escape_string($conn,$_SESSION['ulbid']);
	    $query->bind_param("s",$ulbid); 
		$query->execute();
		$rs=$query->get_result();
		
		while($row =$rs->fetch_assoc())
		{
			$data[$row['id']]['edition_no']=$row['edition_no'];
			$data[$row['id']]['description']=$row['description'];
			$data[$row['id']]['img_url']=$row['img_url'];
		}
		
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
		
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	     
		$conn->close();
	
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('user_type',$_SESSION['user_type']);
	    $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('pagination',$pagination);		
		$tpl->assign('data',$data);
		$tpl->assign('edition_list',$edition_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$flash = get_flash();		
		$tpl->assign("flash", $flash); 
		$tpl->display('addcontent.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
