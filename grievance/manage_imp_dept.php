<?php
	require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',1);
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
		include('user_defined_functions.php');
		include('prepare_connection.php');
        $csrf_token=generateToken($csrf_prefix_token);
        $tpl->assign('csrf_token',$csrf_token);
        
		$captcha=mysqli_real_escape_string($conn,$_POST['captcha']);
	    $code=mysqli_real_escape_string($conn,$_SESSION['code']);
		
		
		if(isset($_POST['save']))
		{
          
           if($captcha == $code)
		    {
            if ( !empty( $_POST['csrf_token'] ) ) {
		        
		        if( checkToken( $_POST['csrf_token'], $csrf_prefix_token ) ) {
		            
		            if($token_id==$_POST['token']){
          
	
		            
		             $dept_description=preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_desc']);
		            
		    
                  
		                    if(!empty($dept_description))
		                    {
		    
                				if($_POST['dept_id']=='0')
                				{
                				    
                				    $sql ="insert into dept_imp_mst(dept_desc,ulbid) values(?,?)";
                				    $query=$conn->prepare($sql);
                				    $query->bind_param("ss",$dept_description,$_SESSION['ulbid']);
                				    
                				}
                				else
                				{
                				    
                				    $sql ="update dept_imp_mst set dept_desc=? where dept_id=?";
                				    $query=$conn->prepare($sql);
                				    $query->bind_param("si",$dept_description,$_POST['dept_id']);
                				    
                					
                				}
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
		                            $tpl->assign('class','alert alert-success display-hide');
                					$msg="Enter a valid ward description";
		                    }
            				
            				$tpl->assign('msg',$msg);
		        
			
			
		        } else {
		            
		            $tpl->assign('class','alert alert-success display-hide');
                	$msg="Enter a valid ward description";
		        }
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

                    }
        else
            		{
            		     $msg="Invalid Captcha Code";
                		$tpl->assign('msg',$msg);
            		}

		}

			
		$sql =$conn->prepare("select dept_id,dept_desc from dept_imp_mst where ulbid=?");
		
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    	$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		$sql->close();	
			

	   /* $sql =$conn->prepare("select COUNT(id) as user_count from login_details where type=? and ulbid =?");
	    $type = 1;
		$sql->bind_param("is",$type,$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	      
	      
	      
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);

			
		/** captcha generation ****/
    		
    	     $code=rand(1000,9999);
    	 
             $_SESSION['code']=$code;	
            
    		 
    		 
    	
		/** close **/



		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);			
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('dept_list1',$dept_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('code',$code);
		$tpl->assign('token_id',$token_id);
		$tpl->display('manage_imp_dept.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>