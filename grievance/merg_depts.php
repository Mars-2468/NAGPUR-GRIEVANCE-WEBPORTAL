<?php 
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		
		
		     
	 	
	 		if(isset($_POST['save']))
			{
				
                    			if(!empty($_POST['check_list'])) 
                    			{
                    			    $error=0;
                                    foreach($_POST['check_list'] as $check) 
                                    {
                                            $arr=explode("-",$check);
                                            $admincsid=$arr[0];
                                            $cs_id=$arr[1];
                                            $ulbid=$arr[2];
                                            
                                            $merge_cs_id = $admincsid;
                                            $merg_dept_id = strip_tags($_POST['dept_id_sel']);
                                            $cs_id = $cs_id;
                                            
                                            $sql ="update category3_mst set merg_cs_id=?,merg_dept_id=? where cs_id=? and ulbid=?";
                                            
                                            $query = $conn->prepare($sql);
                                            $query->bind_param(iiii,$merge_cs_id,$merg_dept_id,$cs_id,$ulbid);
                                            
                                            
		                                    
		                                   
                                            
                                            
                                            if($query->execute())
                                            {
                                               $error++; 
                                            }
                                            else
                                            {
                                                
                                            }
                                            
                                            
                                    }
                                    
                                    if($error > 0)
                                    {
                                        $tpl->assign('msg','Services Mapped Successfully');
                                    }
                                    else
                                    {
                                        $tpl->assign('msg','Services Not Mapped Properly');
                                    }
                                 }
                    			       
			       
			}
			
			 $sql ="select * from dept_mst where admin_status=?";
			 $admin_status_id = 1;
			 $query = $conn->prepare($sql);
		     $query->bind_param(i,$admin_status_id);
		    
		    
			$query->execute();
			$rs=$query->get_result();
			while($row = $rs->fetch_assoc())
			{
			    $dept_list[$row['dept_id']]=$row['dept_desc'];
			}
			
			if(isset($_POST['getdata']))
			{
			    $sql ="select ulbid,ulbname from ulbmst";
			    $query = $conn->prepare($sql);
			    $query->execute();
			    $rs=$query->get_result();
			    while($row = $rs->fetch_assoc())
			    {
			        $ulb_list[$row['ulbid']]=$row['ulbname'];
			    }
			    
			    
			    $sql ="select cs_id,comp_desc from admin_service_table where dept_id=?";
			    $dept_id = $_POST['dept_id'];
			    
			    $query = $conn->prepare($sql);
		        $query->bind_param(i,$dept_id);
		        $query->execute();
			    $rs=$query->get_result();
			    
			    while($row = $rs->fetch_assoc())
			    {
			        $admincs_list[$row['cs_id']]=$row['comp_desc'];
			    }
			    
			
			    
			    $sql ="select cs_id,comp_desc,ulbid,merg_dept_id from category3_mst";
			    $query = $conn->prepare($sql);
			    $query->execute();
			    $rs=$query->get_result();
			    while($row = $rs->fetch_assoc())
			    {
			        $postfix="";
			        
			        if($row['merg_dept_id'] > 0)
			        {
			            $postfix="<span style='color:green'> (Merged To ".$dept_list[$row['merg_dept_id']].") </span>";
			        }
			        
			        $cs_list[$row['ulbid']][$row['cs_id']]=$row['comp_desc'].$postfix;
			    }
			    
			    
			    $sql ="select cs_id,merg_cs_id,ulbid from category3_mst";
			    
			    $query = $conn->prepare($sql);
			    $query->execute();
			    $rs=$query->get_result();
			    while($row = $rs->fetch_assoc())
			    {
			        $data[$row['ulbid']][$row['cs_id']]['id']=$row['merg_cs_id'];
			    }
			    
			    
			}
				
				
				
		
				
				
		
				
				
				
		$query->close();	
	 	
	        $tpl->assign('data',$data);
	       $tpl->assign('dept_id_sel',$_POST['dept_id']);
	       $tpl->assign('cs_list',$cs_list);
	      $tpl->assign('admincs_list',$admincs_list);
	        $tpl->assign('ulb_list',$ulb_list);
	       $tpl->assign('user_type',$_SESSION['user_type']);
	       $tpl->assign('desg_list',$desg_list);
	        $tpl->assign('emp_list',$emp_list);
	       $tpl->assign('dept_list',$dept_list);
	       $tpl->assign('cs_list',$cs_list);
	       
	   $tpl->assign('uname',$_SESSION['user_name']);
	   $tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('merge_depts.tpl');
		
	}
	else
	{
	//header('location:index.php');
	echo "<script>window.location='index.php';</script>";
	}
	
?>	
	
	