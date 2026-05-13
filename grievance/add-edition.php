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
	
	if(isset($_SESSION['uid']))
	{
	    
	    //session_regenerate_id();
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
		        
			   if($_POST['update_status']==1)
			   {
			       
			 
		$edition_no=htmlspecialchars(strip_tags($_POST['edition_no']));
		$edition_date=date('Y-m-d',strtotime(htmlspecialchars(strip_tags($_POST['edition_date']))));
		$id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['id']));
		
		$sql= "UPDATE add_edition SET edition_no=?, edition_date=? where id=?";
		$query=$conn->prepare($sql);
		$query->bind_param("ssi",$edition_no,$edition_date,$id);
		$result=$query->execute();	
			
		if($result)
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Record Updated  successfully');
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to insert, Please try again');
			}
				
				
				
				
				
			   }
			   else
			   {
	    $edition_no=$_POST['edition_no'];
	    $sql=$conn->prepare("SELECT * FROM add_edition WHERE edition_no=? and ulbid=?");
		$sql->bind_param("ss",$edition_no,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		$nr=$rs->num_rows;		
		
		$row=$rs->fetch_assoc();
	
	
	      
			if($nr > 0)
			{
	              
	               		$tpl->assign('msg','alert alert-danger display-hide');
				        $tpl->assign('msg','This Edition Number  ' .htmlspecialchars(strip_tags($_POST['edition_no'])).' Already Exist Please select another edition no');
	                }
	                else
	                {
	
			  
				
				
		$edition_no=htmlspecialchars(strip_tags($_POST['edition_no']));
		$edition_no_marathi=htmlspecialchars(strip_tags($_POST['edition_no_marathi']));
		$edition_date=date('Y-m-d',strtotime(htmlspecialchars(strip_tags($_POST['edition_date']))));
		$sql ="insert into add_edition(edition_no,edition_no_marathi,edition_date,ulbid) values(?,?,?,?)";
		$query=$conn->prepare($sql);
		$query->bind_param("ssss",$edition_no,$edition_no_marathi,$edition_date,$_SESSION['ulbid']);

		if($query->execute())
		{
		 	$tpl->assign('class','alert alert-success display-hide');
			$tpl->assign('msg','Record Inserted  successfully');   
		}
		
		else
		{
			$tpl->assign('msg','alert alert-danger display-hide');
			$tpl->assign('msg','Unable to insert, Please try again');
				
		}
		
          }
	                  
		}
		
		}
	}
		
	
	
	            $sql ="select * from add_edition where ulbid=? order by edition_date desc";
				$query=$conn->prepare($sql);
				$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
				$query->execute();
				$rs=$query->get_result();
				$tot_row=$rs->num_rows;
				if($tot_row > 0)
				{
				   $field_info = $rs->fetch_fields();
				   while($row = $rs->fetch_assoc())
				   {
				      	foreach($field_info as $fi => $f) 
						$edition_list[$row['id']][$f->name]=$row[$f->name]; 
				   }
				   	$tpl->assign('edition_list',$edition_list);
				}
				$query->close();
	
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
		
		
		
		  
	      
	       /* $sql=$conn->prepare("select COUNT(id) as user_count from login_details where type=? and ulbid=?");
	        $type = 1;
    		$sql->bind_param("is",htmlspecialchars(strip_tags($type)),htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    		$sql->execute();
    		$rs=$sql->get_result();
    		$row = $rs->fetch_assoc();
    		$sql->close();*/
	      
	      
	      
	      $users_count=$row['user_count'];
	      $tpl->assign('users_count',$users_count);
		  mysqli_close($conn);
	      $tpl->assign('user_type',$_SESSION['user_type']);
		  $tpl->assign('online_applications',$online_applications);
        $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('add-edition.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
	}
?>
                            
                            
                            
                            
                            
                            