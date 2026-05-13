<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		$ulbid=$_SESSION['ulbid'];
		if(isset($_GET['getr']))
		{
		
		
			$sql = $conn->prepare("select * from emp_map where ulbid=? and flag=? and cs_type_id=? and cs_id=?");
			     $sql->bind_param("siii",$ulbid,$flag,$cs_type_id,$cs_id);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			
		while($row = $rs->fetch_assoc())
		{
		$data[$row['ward_id']][$row['cs_id']]['emp_id']=$row['emp_id'];
		$data[$row['ward_id']][$row['cs_id']]['emp_id2']=$row['emp_id2'];
		$data[$row['ward_id']][$row['cs_id']]['dept_id']=$row['dept_id'];
		}
		
		$tpl->assign('data',$data);
		
		
	       
	       	$sql = $conn->prepare("select c.cs_id,cs_desc from complaint_ulbmap c,cs_mst cm where c.cs_id=cm.cs_id and c.ulbid=? and flag=? order by cs_id");
			     $sql->bind_param("si",$ulbid,$flag);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			    
	       while($row = $rs->fetch_assoc())
	       {
	       $cs_list[$row['cs_id']]=$row['cs_desc'];
	       }
		
		
			$sql = $conn->prepare("select c.cs_id,c.cs_desc as comp_desc from  cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid=? and cu.flag=? and c.cs_id =?");
			     $cs_id=$_GET['cs_id'];
			     $sql->bind_param("sii",$ulbid,$flag,$cs_id);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			    
	       while($row = $rs->fetch_assoc())
	       {
	       $cs_list1[$row['cs_id']]=$row['comp_desc'];
	       }
		$tpl->assign('cs_list1',$cs_list1);
	
	       
	       	$sql = $conn->prepare("select * from ward_mst where ulbid=? order by ward_id");
			     $sql->bind_param("s",$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
	       while($row = $rs->fetch_assoc())
	       {
	       $ward_list[$row['ward_id']]=$row['ward_desc'];
	      
	       }
	       
	       
	       	$sql = $conn->prepare("select c.cs_id,cs_desc from complaint_ulbmap c,cs_mst cm where c.cs_id=cm.cs_id and c.ulbid=? and flag=? order by cs_id");
			     $sql->bind_param("si",$ulbid,$flag);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
	       
	       while($row = $rs->fetch_assoc())
	       {
	       $cs_list[$row['cs_id']]=$row['cs_desc'];
	       }
	       
	       
	       $sql = $conn->prepare("select * from dept_mst where ulbid=? order by dept_id");
		   $sql->bind_param("s",$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
	       while($row = $rs->fetch_assoc())
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }
	       
	    
		
		    $sql = $conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where ulbid=?");
		   $sql->bind_param("s",$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			    
	       while($row = $rs->fetch_assoc())
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	         
	       }
	       
	       
		
		 $sql = $conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=?");
		 $dept_id=$_REQUEST['dept_id'];
		   $sql->bind_param("i",$dept_id);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			    
	       while($row = $rs->fetch_assoc())
	       {
	       $emp_list2[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	       $sql = $conn->prepare("select * from desg_mst where ulbid=?");
		   $sql->bind_param("s",$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			    
	       
	       while($row = $rs->fetch_assoc())
	       {
	       $desg_list[$row['desg_id']]=$row['desg_desc'];
	       }
	 }
	 else
	 {
	     $flag=1;
	     $sql = $conn->prepare("select c.cs_id,cs_desc from complaint_ulbmap c,cs_mst cm where c.cs_id=cm.cs_id and c.ulbid=? and flag=? order by cs_id");
		   $sql->bind_param("si",$ulbid,$flag);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
	 	
	       while($row = $rs->fetch_assoc())
	       {
	       $cs_list[$row['cs_id']]=$row['cs_desc'];
	       }
	 }      
	 
	$conn->close();
	 
	$tpl->assign('desg_list',$desg_list);
	$tpl->assign('emp_list',$emp_list);
	$tpl->assign('dept_list',$dept_list);
	$tpl->assign('cs_list',$cs_list);
	$tpl->assign('ward_list',$ward_list);
	$tpl->assign('uname',$_SESSION['user_name']);
	$tpl->assign('services',$obj->services);
	$tpl->assign('main_icons',$obj->main_icons);
	$tpl->assign('logo',$_SESSION['logo']);
	$tpl->assign('uid',$_SESSION['uid']);
	$tpl->assign('banner',$_SESSION['banner']);
	$tpl->display('complaint_emp_map_report.tpl');
		
}
	
	?>
	
	