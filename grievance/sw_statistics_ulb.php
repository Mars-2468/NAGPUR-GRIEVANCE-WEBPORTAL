<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
	

		if($_REQUEST['code']==0)
		{
		$sql ="select * from category3_mst where ulbid=? and cs_type_id=?";
		$query=$conn->prepare($sql);
		$ulbid=$_SESSION['ulbid'];
		$cs_type_id=$_REQUEST['cs_type_id']; 
		$query->bind_param("si",$ulbid,$cs_type_id);
		 
		 $sql2="select cs_id from category3_mst where ulbid=? 
		 and cs_id IN(select cs_id from emp_map where ulbid=? group by cs_id) and
		 cs_type_id=?";
		 $query=$conn->prepare($sql2);
		 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $cs_type_id=htmlspecialchars(strip_tags($_REQUEST['cs_type_id']));
		 $query->bind_param("ssi",$ulbid,$ulbid1,$cs_type_id);
		 
		 $query->execute();
		 $rs=$query->get_result();
		 while($row =$rs->fetch_assoc())
		 {
		    $cs_list[$row['cs_id']]=$row['cs_id']; 
		 }
		 
		 
		}
		else if($_REQUEST['code']==1)
		{
		 
		 
		 $sql="select * from category3_mst where ulbid=? and 
		 cs_id IN(select cs_id from emp_map where ulbid=? group by cs_id) 
		 and cs_type_id=?";
        $query=$conn->prepare($sql);
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$cs_type_id=htmlspecialchars(strip_tags($_REQUEST['cs_type_id']));
		$query->bind_param("ssi",$ulbid,$ulbid1,$cs_type_id);
		 
		}
		else if($_REQUEST['code']==2)
		{
	
		
		$sql="select * from category3_mst where ulbid=? and 
		cs_id NOT IN(select cs_id from emp_map where ulbid=? group by cs_id) 
		and cs_type_id=?";
		$query=$conn->prepare($sql);
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$cs_type_id=htmlspecialchars(strip_tags($_REQUEST['cs_type_id']));
		$query->bind_param("ssi",$ulbid,$ulbid1,$cs_type_id); 
		 
		
		
		
		}
			
		
		$query->execute();
		$rs=$query->get_result();
		if($rs)
		{
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
				if(in_array($row['cs_id'],$cs_list))
				{
					$update_code[$row['cs_id']]=1;
				}
				else
				{
				$update_code[$row['cs_id']]=0;
				}
				foreach($field_info as $fi => $f) 
				$data[$row['cs_id']][$f->name]=$row[$f->name];
			}
			
		}
		
			
						
		
		$tpl->assign('data',$data);



			
		$sql=$conn->prepare("select ward_id,ward_desc from ward_mst");
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   	$ward_list[$row['ward_id']]=$row['ward_desc']; 
		}
	

	
		$sql=$conn->prepare("select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?");
		$grievance_status_id=5;
		$sql->bind_param("i",$grievance_status_id);
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   	$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
		//print_r($grievance_status_list);	

	
		
		$sql=$conn->prepare("select dept_id,dept_desc from dept_mst");
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   	$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
			$tpl->assign('dept_list',$dept_list);
		
		
		if($_SESSION['user_type'] == 'A')
		{
		    
		     
		     $sql1 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = ? and g.http_code=? group by c.cs_id" ;
		     $query=$conn->prepare($sql1);
		     $swatchta_app_status_yn=1;
		     $http_code=201;
		     $query->bind_param("ii",$swatchta_app_status_yn,$http_code);
		    
		}
		
		else if($_SESSION['user_type']== 'R')
		{
		   
		    
		     $sql1 ="select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma =? and c.swatchta_app_status_yn =? and g.http_code=? group by c.cs_id";
		    $query=$conn->prepare($sql1);
		    $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
		     $swatchta_app_status_yn=1;
		     $http_code=201;
		     $query->bind_param("sii",$rdma,$swatchta_app_status_yn,$http_code);
		}
		else
		{
		      
		     
		     $sql1 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like ? and c.swatchta_app_status_yn =? and g.http_code=? group by c.cs_id" ;
		     $query=$conn->prepare($sql1);
		     $ulbid='%'.$_SESSION['uid'].'%';
		     $swatchta_app_status_yn=1;
		     $http_code=201;
		     $query->bind_param("sii",$ulbid,$swatchta_app_status_yn,$http_code);
		     
		}
		
		
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		   	$received[$row['cs_id']]['count']=$row['count'];
		    $tot1 += $received[$row['cs_id']]['count'];
		}
		
		
		
		if($_SESSION['user_type'] == 'A')
		{
		   
		     
		     $qry = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn =? and g.http_code=? and (swatchta_app_status=? or swatchta_app_status=? or swatchta_app_status=?) group by c.cs_id" ; 
		     $query=$conn->prepare($qry);
		     $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status0=0;
		     $swatchta_app_status1=1;
		     $swatchta_app_status3=3;
		     $query->bind_param("iiiii",$swatchta_app_status_yn,$http_code,$swatchta_app_status0,$swatchta_app_status1,$swatchta_app_status3);
		}
		else if($_SESSION['user_type']== 'R')
	    {
	       
		    
		     $qry = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where
	        g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma =? and
		    c.swatchta_app_status_yn =? and g.http_code=? and (swatchta_app_status=? or swatchta_app_status=?) group by c.cs_id" ;
		    $query=$conn->prepare($qry);
		    $rdma=$_SESSION['uid'];
		    $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status0=0;
		     
		     $swatchta_app_status3=3;
	        $query->bind_param("siiii",$rdma,$swatchta_app_status_yn,$http_code,$swatchta_app_status0,$swatchta_app_status3);
	    }
	    else
	    {
		   
		     $qry = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    g.ulbid like ? and c.swatchta_app_status_yn =? and g.http_code=? 
		    and (swatchta_app_status=? or swatchta_app_status=? or swatchta_app_status=?) group by c.cs_id";
		    
		    $query=$conn->prepare($qry);
		     $ulbid='%'.$_SESSION['uid'].'%';
		     $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status0=0;
		     $swatchta_app_status1=1;
		     $swatchta_app_status3=3;
		     $query->bind_param("siiiii",$ulbid,$swatchta_app_status_yn,$http_code,$swatchta_app_status0,$swatchta_app_status1,$swatchta_app_status3);
	    }
	    
		
		
		
	   $query->execute();
		$res=$query->get_result();
		while($row = $res->fetch_assoc())
		{
		   $pending[$row['cs_id']]['count']=$row['count'];
		    $tot2 += $pending[$row['cs_id']]['count'];
		}
		
		
		
		
		
		if($_SESSION['user_type'] == 'A')
		{
		    
		     
		     $sql2 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn =? and g.http_code=? and swatchta_app_status =? group by c.cs_id" ;
		     $query=$conn->prepare($sql2);
		   
		    $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status=4;
		     
		   
	        $query->bind_param("iii",$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		    
		}
		
		else if($_SESSION['user_type']== 'R')
	    {
	  
	     
		    
		    $sql2 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d 
	        where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma =? and 
		    c.swatchta_app_status_yn =? and g.http_code=? and 
		    swatchta_app_status =? group by c.cs_id" ;
		    $query=$conn->prepare($sql2);
		    $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
		    $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status=4;
		     
		    
	        $query->bind_param("siii",$rdma,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
	    }
	    else
	    {
		    
		    $sql2 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    g.ulbid like? and c.swatchta_app_status_yn =? and g.http_code=? 
		    and swatchta_app_status =? group by c.cs_id" ;
		    $query=$conn->prepare($sql2);
		     $ulbid='%'.$_SESSION['uid'].'%';
		     $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status=4;
		     
		     $query->bind_param("siii",$ulbid,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
	    }
	
			
	   $query->execute();
		$rs2=$query->get_result();
		while($row = $rs2->fetch_assoc())
		{
		  $resolved[$row['cs_id']]['count']=$row['count'];
		    $tot3 += $resolved[$row['cs_id']]['count'] ;
		}
		
		
		if($_SESSION['user_type'] == 'A')
		{
		  
		    
		    $sql3 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    c.swatchta_app_status_yn =? and g.http_code=? and swatchta_app_status =? group by c.cs_id" ;
		    $query=$conn->prepare($sql3);
		    $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status=6;
		  $query->bind_param("iii",$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		}
		
		
		else if($_SESSION['user_type']== 'R')
	    {
	       
		    $sql3 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma =? and c.swatchta_app_status_yn =? and g.http_code=? and 
		    swatchta_app_status =? group by c.cs_id" ;
		     $query=$conn->prepare($sql3);
		     $rdma =htmlspecialchars(strip_tags($_SESSION['uid']));
		    $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status=6;
		  $query->bind_param("siii",$rdma,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
	    }
		else
		{
		   
		    
		    
		    $sql3 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    g.ulbid like ? and c.swatchta_app_status_yn =? 
		    and g.http_code=? and swatchta_app_status =? group by c.cs_id" ;
		    
		    $query=$conn->prepare($sql3);
		     $ulbid ='%'.$_SESSION['uid'].'%';
		    $swatchta_app_status_yn=1;
		     $http_code=201;
		     $swatchta_app_status=6;
		  $query->bind_param("siii",$ulbid,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		    
		    
		    
		}
		

		$query->execute();
		$rs3=$query->get_result();
		while( $row =$rs3->fetch_assoc())
		{
		    $rejected[$row['cs_id']]['count']=$row['count'];
		    $tot4 += $rejected[$row['cs_id']]['count'] ;
		}
		
		/// ulb wise received
		
	
		$sql=$conn->prepare("select count(grievance_id) as count,g.swatchta_app_status,ulbid from grievances g where 
		     g.ulbid like '%%' group by ulbid");
		     $sql->execute();
		     $rs=$sql->get_result();
		while( $row = $rs->fetch_assoc())
		{
		    $ulbsdata[$row['ulbid']]['received_ulb']=$row['count'];
		    $totals['received_ulb'] += $row['count'];
		}     
		
	
		/// ulbwise pending
		
    		$sql =$conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,ulbid from cs_mst c , grievances g where  
		     g.ulbid like '%%' and c.swatchta_app_status_yn =? and g.grievance_status_id IN (?) group by ulbid");
		     $swatchta_app_status_yn=1;
		     $grievance_status_id=1;
		     $sql->bind_param("ii",$swatchta_app_status_yn,$grievance_status_id);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		    $ulbsdata[$row['ulbid']]['pending']=$row['count'];
            		    $totals['pending'] += $row['count'];
        		}   
    		
    		
    		
    	// ulbwise on job
    	
   
    		$sql =$conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like '%%' and c.swatchta_app_status_yn =? and g.grievance_status_id IN (?) group by ulbid");
		     $swatchta_app_status_yn=2;
		     $grievance_status_id=1;
		     $sql->bind_param("ii",$swatchta_app_status_yn,$grievance_status_id);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		    $ulbsdata[$row['ulbid']]['underprogress']=$row['count'];
    		    $totals['underprogress'] += $row['count'];
        		}   
    		
    		
    		
    		
    	// ulbwise resolved
    	
    	
    		$sql ="select count(c.cs_id) as count,g.swatchta_app_status,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like '%%' and c.swatchta_app_status_yn =? and (g.grievance_status_id=? or g.grievance_status_id=? or 
		     g.grievance_status_id=? or g.grievance_status_id=?) group by ulbid";
		     $query =$conn->prepare($sql);
		     
		     $swatchta_app_status_yn=1;
		     $grievance_status_id3=3;
		     $grievance_status_id4=4;
		     $grievance_status_id6=6;
		     $grievance_status_id8=8;
		     $query->bind_param("iiiii",$swatchta_app_status_yn,$grievance_status_id3,$grievance_status_id4,$grievance_status_id6,$grievance_status_id8);
		     $query->execute();
		     $rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   $ulbsdata[$row['ulbid']]['resolved']=$row['count'];
    		    $totals['resolved'] += $row['count'];
        		}   
    			
    		
    		
    		
    	// ulbwise rejected
   
    	$sql =$conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like '%%' and c.swatchta_app_status_yn =? and g.grievance_status_id IN (?) group by ulbid");
		     $swatchta_app_status_yn=1;
		     $grievance_status_id=10;
		     $sql->bind_param("ii",$swatchta_app_status_yn,$grievance_status_id);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		 $ulbsdata[$row['ulbid']]['rejected']=$row['count'];
    		    $totals['rejected'] += $row['count'];
        		}   
    			
    		
    	// Total complaints posted from municipal services
    	
    
    	$sql =$conn->prepare("select count(grievance_id) as count,g.swatchta_app_status,ulbid from  grievances g where 
		     g.ulbid like '%%' and http_code=? group by ulbid");
		     $http_code=201;
		     
		     $sql->bind_param("i",$http_code);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		 $ulbsdata[$row['ulbid']]['posted']=$row['count'];
    		     $totals['posted'] += $row['count'];
        		}   	
    		
    		
    		
    		// available
    		
    		 
		     $sql = "select count(grievance_id) as count,g.swatchta_app_status,ulbid from  grievances g where 
		     g.ulbid like '%%' and http_code=? and app_type_id=? and (cat3_id=? or cat3_id=? or cat3_id=? or cat3_id=? or 
		     cat3_id=? or cat3_id=? or cat3_id=? or cat3_id=?) group by ulbid";
		     $query =$conn->prepare($sql);
		     $http_code=0;
		     $app_type_id=1;
		     
		     $cat3_id1=22;
		     $cat3_id2=25;
		     $cat3_id3=31;
		     $cat3_id4=33;
		     $cat3_id5=71;
		     $cat3_id6=72;
		     $cat3_id7=73;
		     $cat3_id8=74;
		     
		     $query->bind_param("iiiiiiiiii",$http_code,$app_type_id,$cat3_id1,$cat3_id2,$cat3_id3,
		     $cat3_id4,$cat3_id5,$cat3_id6,$cat3_id7,$cat3_id8
		     );
		     $query->execute();
		     $rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   $ulbsdata[$row['ulbid']]['available']=$row['count'];
    		    $totals['available'] += $row['count'];
        		}   
    			
    	
    	// complaints posted from lrs tables
  
    	$sql =$conn->prepare("select count(app_id) as count,ulbid from lrs_applications g where http_code=? group by ulbid");
		     $http_code=201;
		     
		     $sql->bind_param("i",$http_code);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		 $ulbsdata[$row['ulbid']]['posted']+=$row['count'];
    		    $totals['posted'] += $row['count'];
        		}   	
    		
    		
    		
    		//	 complaints posted from brs tables
    
    		
    	$sql =$conn->prepare("select count(app_id) as count,ulbid from brs_application g where http_code=? group by ulbid");
		     $http_code=201;
		     
		     $sql->bind_param("i",$http_code);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		 $ulbsdata[$row['ulbid']]['posted']+=$row['count'];
    		    $totals['posted'] += $row['count'];
        		}  	
    		
    		
    		
    		// only surypaet data from aryavysya database
    	
    		$sql =$conn->prepare("select count(family_no) as count from aryavysya_servey where http_code=?");
		     $http_code=201;
		     
		     $sql->bind_param("i",$http_code);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		$ulbsdata['087']['posted']+=$row['count'];
    		    $totals['posted'] += $row['count'];
        		}  	
    		
    		
    		
    		
    		// nalgonda survey
    		
    		
    			$sql =$conn->prepare("select count(id) as count from nalgonda_survey where http_code=?");
		     $http_code=201;
		     
		     $sql->bind_param("i",$http_code);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		$ulbsdata['086']['posted']+=$row['count'];
    		    $totals['posted'] += $row['count'];
        		}  	
    		
    		// only surypaet data from aryavysya database
    	
    		$sql =$conn->prepare("select count(app_id) as count,ulbid from suryapet_data where http_code=? group by ulbid");
		     $http_code=201;
		     
		     $sql->bind_param("i",$http_code);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		 $ulbsdata[$row['ulbid']]['posted']+=$row['count'];
    		    $totals['posted'] += $row['count'];
        		}  
    		
    		
    			// only surypaet data from aryavysya database
    		
    		
    	$sql =$conn->prepare("select count(app_id) as count,ulbid from boduppal_data where http_code=? group by ulbid");
		     $http_code=201;
		     
		     $sql->bind_param("i",$http_code);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		 $ulbsdata['207']['posted']+=$row['count'];
    		    $totals['posted'] += $row['count'];
        		}  
    		
    	// ON open complaint at swachh ta 	
    		
    
    		
    	$sql =$conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like '%%' and c.swatchta_app_status_yn =? and http_code=? and swatchta_app_status IN (?) group by ulbid");
		     $http_code=201;
		     $swatchta_app_status_yn=1;
		     $swatchta_app_status=1;
		     
		     $sql->bind_param("iii",$http_code,$swatchta_app_status_yn,$swatchta_app_status);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		 $ulbsdata[$row['ulbid']]['opencomplaint']=$row['count'];
    		    $totals['opencomplaint'] += $row['count'];
        		} 	
    		
    		
    		// ON job at swachh ta 	
    	
    		
    	$sql =$conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like '%%' and c.swatchta_app_status_yn =? and http_code=? and swatchta_app_status IN (?) group by ulbid");
		     $http_code=201;
		     $swatchta_app_status_yn=1;
		     $swatchta_app_status=3;
		     
		     $sql->bind_param("iii",$http_code,$swatchta_app_status_yn,$swatchta_app_status);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		  $ulbsdata[$row['ulbid']]['onjob']=$row['count'];
    		    $totals['onjob'] += $row['count'];
        		} 	
    			
    		
    		
    		
    			// ON Resolved at swachh ta 	
    		
    	
    		$sql =$conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like '%%' and c.swatchta_app_status_yn =? and http_code=? and swatchta_app_status IN (?) group by ulbid");
		     $http_code=201;
		     $swatchta_app_status_yn=1;
		     $swatchta_app_status=4;
		     
		     $sql->bind_param("iii",$http_code,$swatchta_app_status_yn,$swatchta_app_status);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		  $ulbsdata[$row['ulbid']]['completed']=$row['count'];
    		    $totals['completed'] += $row['count'];
        		} 	
    			
    		
    		
    		
    		
    			// ON Rejected at swachh ta 	
    		
    	
		$sql =$conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like '%%' and c.swatchta_app_status_yn =? and http_code=? and swatchta_app_status IN (?) group by ulbid");
		     $http_code=201;
		     $swatchta_app_status_yn=1;
		     $swatchta_app_status=6;
		     
		     $sql->bind_param("iii",$http_code,$swatchta_app_status_yn,$swatchta_app_status);
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		  $ulbsdata[$row['ulbid']]['sw_rejected']=$row['count'];
    		    $totals['sw_rejected'] += $row['count'];
        		} 	
    			
		                      
		
		
			
		$sql =$conn->prepare("select * from ulbmst");
		 
		     $sql->execute();
		     $rs=$sql->get_result();
        		while( $row = $rs->fetch_assoc())
        		{
        		  $ulb_list[$row['ulbid']]=$row['ulbname'];
        		} 		
			
			
			
		$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();
	    $users_count=$row['user_count'];
	   $tpl->assign('users_count',$users_count);
    
		
		$tpl->assign('ulbsdata',$ulbsdata);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('totals',$totals);
		$tpl->assign('totals',$totals);
		$tpl->assign('sec_level',$_SESSION['sec_level']);			
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('update_code',$update_code);
		$tpl->assign('code',$_REQUEST['code']);
		$tpl->assign('cs_type_id',$_REQUEST['cs_type_id']);
		$tpl->assign('cs_list',$cs_list);	
		$tpl->assign('received',$received);
		$tpl->assign('resolved',$resolved);
		$tpl->assign('tot1',$tot1);
		$tpl->assign('tot2',$tot2);
		$tpl->assign('tot3',$tot3);
		$tpl->assign('tot4',$tot4);
		$tpl->assign('rejected',$rejected);
		$tpl->assign('pending',$pending);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('sw_statistics_ulb.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>