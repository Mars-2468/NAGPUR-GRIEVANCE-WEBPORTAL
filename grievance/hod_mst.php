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
	    
	    
	   // session_regenerate_id();
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('user_defined_functions.php');
		require_once('prepare_connection.php');
        $csrf_token=generateToken($csrf_prefix_token);
        $tpl->assign('csrf_token',$csrf_token);
		
		
		
			$captcha=mysqli_real_escape_string($conn,$_POST['captcha']);
	    $code=mysqli_real_escape_string($conn,$_SESSION['code']);
		
		
		if(isset($_POST['save']))
		{
		    if($token_id==$_POST['token']){
		        
		/*	if($captcha == $code)
		    { 	*/
				
				if ( !empty( $_POST['csrf_token'] ) ) {
                
                if( checkToken( $_POST['csrf_token'], $csrf_prefix_token ) ) {
				
		
				 $dept_id=preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id']);
				 $desg_id=preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['desg_id']);
			
		            
		             $sql ="insert into hod_mst(dept_id,desg_id,ulbid) values(?,?,?)";
                				    $query=$conn->prepare($sql);
                				    $query->bind_param("iis",$dept_id,$desg_id,$_SESSION['ulbid']);
                  
		                    
			        if($query->execute())
                				{
                					$tpl->assign('class','alert alert-success display-hide');
                					$msg="Successfully Saved";
                				}
                				else
                				{
                					$tpl->assign('msg','alert alert-danger display-hide');
                					$msg="Uable to save   ".$query->error;
                				}
                				$query->close();
				
				
				
				
				}
				else
                {
                    $tpl->assign('msg','Invalid token');
                }
                }
                else
                {
                                    $tpl->assign('msg','Something went wrong');
                                    
                }

                   /* }
				else
                	{
                	   
                	    $msg="Invalid Captcha Code";
                		$tpl->assign('msg',$msg);
                		
                	}*/
                	
		}

		}
		
	
		$sql=$conn->prepare("select * from hod_mst where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $data[$row['dept_id']]['dept_id']=$row['dept_id'];
		    $data[$row['dept_id']]['desg_id']=$row['desg_id'];
		}
		
		$sql->close();

 
				$sql=$conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=? order by dept_id ASC");
				$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
        		$sql->execute();
        	    $rs=$sql->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		    	$dept_list[$row['dept_id']]=$row['dept_desc'];
        		}
        		
        		$sql->close();

    	$sql=$conn->prepare("select desg_id,desg_desc from desg_mst where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    	$desg_list[$row['desg_id']]=$row['desg_desc'];
		}
		$sql->close();
		 	
    	$sql=$conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=? and dept_id not in (select dept_id from hod_mst where ulbid=?)order by dept_id");
		$sql->bind_param("ss",htmlspecialchars(strip_tags($_SESSION['ulbid'])),htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   	$dp_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		$sql->close();
			
			$sql=$conn->prepare("select desg_id,desg_desc from desg_mst where ulbid=?");
			$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
			$sql->execute();
			$rs=$sql->get_result();
			while($row =$rs->fetch_assoc())
			{
			  	$ds_list[$row['desg_id']]=$row['desg_desc'];  
			}
			$sql->close();
				/** captcha generation ****/
    		
    	     $code=rand(1000,9999);
    	 
             $_SESSION['code']=$code;	
            
    		 
    		 
    	
		/** close **/
		
	    /*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
			
		
	    $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('dp_list',$dp_list);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('data',$data);			
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('code',$code);
		$tpl->assign('token_id',$token_id);
		$tpl->display('hod_mst.tpl');
	}
	else
	{
	
		echo "<script>window.locati='index.php';</script>";
		
	}
?>