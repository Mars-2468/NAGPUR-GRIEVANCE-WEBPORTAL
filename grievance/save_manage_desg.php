<?php
  require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    $tpl->assign('msg',$_SESSION['msg']);
           // echo $_SESSION['msg'];
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		include('user_defined_functions.php');
         $csrf_token=generateToken($csrf_prefix_token);
         $tpl->assign('csrf_token',$csrf_token);
		
		$captcha=mysqli_real_escape_string($conn,$_POST['captcha']);
	    $code=mysqli_real_escape_string($conn,$_SESSION['code']);
	    
	    
	    mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
	
		if(isset($_POST['save']))
		{
            if(!validateField($_POST['desg_desc'], 'text')['valid'] || !validateField($_POST['desig_marathi'], 'text')['valid']){
				$tpl->assign('class', 'alert alert-danger display-hide');
				$msg = "Enter Valid Zone/ward Description..!";
				set_flash($msg,$class);
				header("Location: manage_desg.php");
				exit;
			}else{
			//var_dump($_POST);die();
			
		        if ( !empty( $_POST['csrf_token'] ) ) {
		        
					
						 $desg_desc= $_POST['desg_desc']; // preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['desg_desc']);
						 $desig_marathi= $_POST['desig_marathi']; // $_POST['desig_marathi'];
						 $emp_dept=preg_replace('/[^0-9]+$/', ' ', $_POST['dept_id']);
				
								
								if(!empty($desg_desc) && !empty($desig_marathi))
								{
				
									if($_POST['desg_id']=='0')
									{
										
										$sql ="insert into desg_mst(desg_desc,desig_marathi,dept_id,ulbid) values(?,?,?,?)";
										$query=$conn->prepare($sql);
										$query->bind_param("ssis",$desg_desc,$desig_marathi,$_POST['dept_id'],$_SESSION['ulbid']);
										
									}
									else
									{
										$sql ="update desg_mst set desg_desc=?,desig_marathi=?,dept_id=? where desg_id=?";
										$query=$conn->prepare($sql);
										$query->bind_param("ssii",$desg_desc,$desig_marathi,$_POST['dept_id'],$_POST['desg_id']);
									}
							
									if($query->execute())
									{
										
										
										
										$sql1 ="update emp_mst set emp_dept=? where emp_desg=?";
										$query1=$conn->prepare($sql1);
										$query1->bind_param("ss",$emp_dept,$_POST['desg_id']);
										if($query1->execute())
											{
												$tpl->assign('class','alert alert-success display-hide');
												$msg="Successfully Updated  Details..!";
											}
											
											// 	$tpl->assign('class','alert alert-success display-hide');
											// $msg="Successfully Updated  Details";
									}
									else
									{
										$class = 'alert alert-danger display-hide';
										$msg="Uable to save   ".$query->error;
									}
									$query->close();
								}
								else
								{
										$class='alert alert-danger display-hide';
										$msg = "Enter Valid Ward Description..!";
								}
								
								
					
				
                }else{
					$class= 'alert alert-danger display-hide';
					$msg= 'Something Went Wrong..!';
                                    
                }
				
				set_flash($msg,$class);
				header("Location: manage_desg.php");
				exit;
            } 			
		}			
	}
	else
	{
	
		
		echo "<script>window.location='index.php';</script>";
		
	}
	
