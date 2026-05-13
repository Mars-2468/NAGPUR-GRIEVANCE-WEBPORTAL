<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
		if(isset($_GET['getr']))
		{
		
		 $sql ="select * from emp_map where ulbid=? and flag=? and cs_type_id=? and cs_id=?";
		
		         $ulbid =htmlspecialchars(strip_tags($_SESSION['ulbid']));
		         $flag = 1;
        		 $cs_type_id = 2;
        		 $cs_id = $_GET['cs_id'];
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("siii",$ulbid,$flag,$cs_type_id,$cs_id);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
		
	
		while($row = $rs->fetch_assoc())
		{
		$data[$row['ward_id']][$row['cs_id']]['emp_id']=$row['emp_id'];
		$data[$row['ward_id']][$row['cs_id']]['emp_id2']=$row['emp_id2'];
		$data[$row['ward_id']][$row['cs_id']]['dept_id']=$row['dept_id'];
		}
		
		$tpl->assign('data',$data);
		
		$sql ="select cs_id,comp_desc as cs_desc,telugu_description from category3_mst  where ulbid=? and cs_type_id=?";
		
		
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $cs_type_id = 2;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("si",$ulbid,$cs_type_id);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
		
	       
	       while($row = $rs->fetch_assoc())
	       {
	       $cs_list[$row['cs_id']]=$row['cs_desc']."(".$row['telugu_description'].")";
	       }
		
		
		 $sql ="select cs_id,comp_desc,telugu_description  from category3_mst  where ulbid=? and cs_type_id=? and cs_id = ?";
		 
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $cs_type_id = 2;
        		 $cs_id = $_GET['cs_id'];
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("sii",$ulbid,$cs_type_id,$cs_id);
        		 $query->execute();
        		 $rs = $query->get_result();
		 
		 
	       while($row = $rs->fetch_assoc())
	       {
	       $cs_list1[$row['cs_id']]=$row['comp_desc']."(".$row['telugu_description'].")";
	       }
		$tpl->assign('cs_list1',$cs_list1);
	
	       $sql ="select * from ward_mst where ulbid=? order by ward_id";
	       
	             $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
	     
	     
	       while($row = $rs->fetch_assoc())
	       {
	       $ward_list[$row['ward_id']]=$row['ward_desc'];
	      
	       }
	       
	     
	        $sql ="select * from dept_mst where ulbid=? order by dept_id";
	       
	             $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
	       
	       
	       while($row = $rs->fetch_assoc())
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }
		 $sql="select emp_id,emp_name,emp_mobile from emp_mst where ulbid='".$_SESSION['ulbid']."'";
		 
		 
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
		 
		 
	       while($row = $rs->fetch_assoc())
	       {
	       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	         
	       }
	       
	        $sql="select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=?";
	        
	             $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("i",$dept_id);
        		 $query->execute();
        		 $rs = $query->get_result();
	        
	        
	        
	       while($row = $rs->fetch_assoc())
	       {
	       $emp_list2[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	       }
	       
	        $sql ="select * from desg_mst where ulbid='".$_SESSION['ulbid']."'";
	        
	             $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
	        
	       
	       while($row = $rs->fetch_assoc())
	       {
	       $desg_list[$row['desg_id']]=$row['desg_desc'];
	       }
	 }
	 else
	 {
	 	$sql ="select cs_id,comp_desc as cs_desc,telugu_description from category3_mst where ulbid=? and cs_type_id=? order by cs_id";
	       
	             $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	             $cs_type_id = 2;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("si",$ulbid,$cs_type_id);
        		 $query->execute();
        		 $rs = $query->get_result();
	       
	       
	       
	       while($row = $rs->fetch_assoc())
	       {
	       $cs_list[$row['cs_id']]=$row['cs_desc']."(".$row['telugu_description'].")";
	       }
	 }      
	 
	        $conn->close();
	 	$tpl->assign('cs_id_sel',$_GET['cs_id']);
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
		$tpl->display('service_emp_map_report.tpl');
		
}
	
	?>
	
	