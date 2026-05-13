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
		include('prepare_connection.php');
		
		if(isset($_POST['desg_id']))
		{

					
			$sql1=$conn->prepare("delete from desg_mst where desg_id=? and ulbid=?");
			$sql1->bind_param("is",$_POST['desg_id'],$_SESSION['ulbid']);
			$result=$sql1->execute();
			if($result)
			{
			  $msg="Successfully Deleted"; 
				$_SESSION['msg'] = $msg; 
			  	echo '<script type="text/javascript">alert("Record deleted successfully");
                                window.location = "manage_desg.php";
                            </script>';
			}
			else
			{
			   $msg="Unable to insert"; 
				$_SESSION['msg'] = $msg;
			}
                       
			$tpl->assign('msg',$msg);
		}

	
			
		$sql =$conn->prepare("select dept_id,desg_id,desg_desc from desg_mst where ulbid=? order by dept_id,desg_desc");
		
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   $desg_list[$row['desg_id']]['dept_id']=$row['dept_id'];
		   $desg_list[$row['desg_id']]['desg_desc']=$row['desg_desc'];
		}
		
		$sql->close();	
		

        $sql =$conn->prepare("select emp_desg,count(emp_id) num_emp from emp_mst where ulbid=? group by emp_desg");
		
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   	$desg_list[$row['emp_desg']]['num_emp']=$row['num_emp'];
		}
		
		$sql->close();

	
		 $sql =$conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   	$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		$sql->close();
		
 	
			
				
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);

		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('manage_desg.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>