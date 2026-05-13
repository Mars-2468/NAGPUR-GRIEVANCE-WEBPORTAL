<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('prepare_connection.php'); 
		

		if($_REQUEST['code']==0)
		{
		    
		 $sql ="select * from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_type_id='".$_REQUEST['cs_type_id']."'";
		 
		 $sql2="select cs_id from category3_mst where ulbid=? and cs_id IN(select cs_id from emp_map where ulbid=? group by cs_id) and cs_type_id=?";
		 
		 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $cs_type_id=htmlspecialchars(strip_tags($_REQUEST['cs_type_id']));
		 $query=$conn->prepare($sql2); 
		
		$query->bind_param("ssi",$ulbid,$ulbid,$cs_type_id);
		
		if(!$query->execute())
            {
                echo "Query not executed 1";
            }
           $rs2=$query->get_result();
		
		 while($row = $rs2->fetch_assoc())
		 {
		    $cs_list[$row['cs_id']]=$row['cs_id'];
		 }
		 
		}
		else if($_REQUEST['code']==1)
		{
		    
		$sql="select * from category3_mst where ulbid= ? and cs_id IN(select cs_id from emp_map where ulbid= ? group by cs_id) and cs_type_id= ? ";
	
		}
		else if($_REQUEST['code']==2)
		{
		$sql="select * from category3_mst where ulbid= ? and cs_id NOT IN(select cs_id from emp_map where ulbid= ? group by cs_id) and cs_type_id= ? ";
		}
		
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid'])); 
		$cs_type_id=htmlspecialchars(strip_tags($_REQUEST['cs_type_id']));
		
		if($query=$conn->prepare($sql))
		{
		    $query->bind_param("ssi",$ulbid,$ulbid,$cs_type_id);
		    
		    	if(!$query->execute())
            {
                echo "Query not executed 2";
            }
            
            $rs3=$query->get_result();
           
			$field_info = $rs3->fetch_fields();
			while($row = $rs3->fetch_assoc())
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



		$sql="select ward_id,ward_desc from ward_mst";
		
		if($query=$conn->prepare($sql))
		{
		    if(!$query->execute())
            {
                echo "Query not executed 3";
            }
           $rs4=$query->get_result();
           
			while($row = $rs4->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		

		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?";
		
		$grievance_status_id='5';
		
		if($query=$conn->prepare($sql))
		{
		    $query->bind_param("i",$grievance_status_id);
		    
		    	if(!$query->execute())
            {
                echo "Query not executed 4";
            }
            
            $rs5=$query->get_result();
		    
			while($row = $rs5->fetch_assoc())
			
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
			

		$sql="select dept_id,dept_desc from dept_mst";
		
		if($query=$conn->prepare($sql))
		{
		    if(!$query->execute())
            {
                echo "Query not executed 5"; 
            }
           $rs6=$query->get_result();
           
			while($row = $rs6->fetch_assoc())
			
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
					
		$tpl->assign('dept_list',$dept_list);
		
		
		if($_SESSION['user_type'] == 'A')
		{
		    
		    $sql1 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = ? and g.http_code= ? ";
		     
		     $swatchta_app_status_yn='1';
		     $http_code='201';
		     
		     $query7=$conn->prepare($sql1);
		     $query7->bind_param("ii",$swatchta_app_status_yn,$http_code);
		     
		     if($_REQUEST['ulbid']!='')
		     {
		         $sql1.=" and g.ulbid like ?";
		         
		         $ulbid="%".$_REQUEST['ulbid']."%";
		         
		         $query7=$conn->prepare($sql1);
		         $query7->bind_param("sii",$ulbid,$swatchta_app_status_yn,$http_code);
		         
		         
		     }
		     
		     
		     $sql1.="group by c.cs_id" ;
		     
		     
		     $sql_ulb = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like ? and c.swatchta_app_status_yn = ? ";
		     
		     $ulbid="%".$_SESSION['ulbid']."%";
		     $swatchta_app_status_yn='1';
		     $query5=$conn->prepare($sql_ulb);
		     $query5->bind_param("si",$ulbid,$swatchta_app_status_yn);
		     
		     if($_REQUEST['ulbid']!='')
		     {
		         $sql_ulb.=" and g.ulbid like ? ";
		         
		         $ulbid="%".$_REQUEST['ulbid']."%";
		         $query5=$conn->prepare($sql_ulb);
		         $query5->bind_param("ssi",$ulbid,$ulbid,$swatchta_app_status_yn);
		        
		     }
		     
		     
		        $sql_ulb.="group by c.cs_id";
		    
		}
		
		else if($_SESSION['user_type']== 'R')
		{
		    $sql1 ="select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ? and g.http_code= ? group by c.cs_id";
		    
		     $rdma1=$_SESSION['uid'];
		     $swatchta_app_status_yn='1';
		     $http_code='201';
		     $query7=$conn->prepare($sql1);
		     $query7->bind_param("iii",$rdma1,$swatchta_app_status_yn,$http_code);
		   
		    $sql_ulb ="select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ?  group by c.cs_id";
		    
		    $rdma=$_SESSION['uid'];
		    $swatchta_app_status_yn='1';
		    $query5=$conn->prepare($sql_ulb);
		    $query5->bind_param("ii",$rdma,$swatchta_app_status_yn);
		}
		else
		{
		    $sql1 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like ? and c.swatchta_app_status_yn = ? and g.http_code= ? group by c.cs_id" ;
		     
		     $ulbid="%".$_SESSION['ulbid']."%";
		     $swatchta_app_status_yn='1';
		     $http_code='201';
		     $query7=$conn->prepare($sql1);
		     $query7->bind_param("sii",$ulbid,$swatchta_app_status_yn,$http_code);
		     
		     $sql_ulb = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like ? and c.swatchta_app_status_yn = ? group by c.cs_id" ;
		     
		     $ulbid="%".$_SESSION['ulbid']."%";
		     $swatchta_app_status_yn='1';
		     $query5=$conn->prepare($sql_ulb);
		     $query5->bind_param("si",$ulbid,$swatchta_app_status_yn);
		}
		
		$query7->execute();
		$rs1=$query7->get_result();
		
		while( $row = $rs1->fetch_assoc())
		{
		    $received[$row['cs_id']]['count']=$row['count'];
		    $tot1 += $received[$row['cs_id']]['count'];
		}
		
		
		
		
		if($_SESSION['user_type'] == 'A')
		{
		    $qry = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = ? and g.http_code= ? and (swatchta_app_status= ? or swatchta_app_status= ? or swatchta_app_status= ?) ";
		     
		     $swatchta_app_status_yn='1';
		     $http_code='201';
		     $zero='0';
		     $one='1';
		     $three='3';
		     
		     $query=$conn->prepare($qry);
		     $query->bind_param("iiiii",$swatchta_app_status_yn,$http_code,$zero,$one,$three);
		     
		     if($_REQUEST['ulbid']!='')
		     {
		         $qry.=" and g.ulbid like ? ";
		         
		         $ulbid="%".$_REQUEST['ulbid']."%";
		         $query=$conn->prepare($qry);
		         $query->bind_param("siiiii",$ulbid,$swatchta_app_status_yn,$http_code,$zero,$one,$three);
		     }
		     
		     
		     $qry.="group by c.cs_id" ;
		     
		     
		}
		else if($_SESSION['user_type']== 'R')
	    {
	        $qry = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ? and g.http_code=? and (swatchta_app_status=? or swatchta_app_status=? ) group by c.cs_id" ;
	        
	        $rdma=$_SESSION['uid'];
	        $swatchta_app_status_yn='1';
	        $http_code='201';
	        $swatchta_app_status0='0';
	        $swatchta_app_status3='3';
	        $query=$conn->prepare($qry); 
	        $query->bind_param("iiiii",$rdma,$swatchta_app_status_yn,$http_code,$swatchta_app_status0,$swatchta_app_status3);
	    }
	    else
	    {
		    $qry = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    g.ulbid like ? and c.swatchta_app_status_yn = ? and g.http_code=? and (swatchta_app_status=? or swatchta_app_status=? or swatchta_app_status=?) group by c.cs_id" ;
	    
	        $ulbid="%".$_SESSION['ulbid']."%";
	        $swatchta_app_status_yn='1';
	        $http_code='201';
	        $swatchta_app_status0='0';
	        $swatchta_app_status1='1';
	        $swatchta_app_status3='3';
	        
	        $query=$conn->prepare($qry); 
	        $query->bind_param("siiiii",$ulbid,$swatchta_app_status_yn,$http_code,$swatchta_app_status0,$swatchta_app_status1,$swatchta_app_status3);
	    }
	    
	
		   if(!$query->execute())
            {
                echo "Query not executed 6";
            }
           $rs7=$query->get_result();
           
		while($row = $rs7->fetch_assoc())
		{
		    $pending[$row['cs_id']]['count']=$row['count'];
		    $tot2 += $pending[$row['cs_id']]['count'];
		}
		
		
		
		if($_SESSION['user_type'] == 'A')
		{
		    $sql2 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? ";
		     
		     $swatchta_app_status_yn='1';
		     $http_code='201';
		     $swatchta_app_status='4';
		     
		     $query=$conn->prepare($sql2);
		     $query->bind_param("iii",$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		     
		     if($_REQUEST['ulbid']!='')
		     {
		         $sql2.=" and g.ulbid like ? ";
		         
		         $ulbid="%".$_REQUEST['ulbid']."%";
		         
		         $query=$conn->prepare($sql2);
		         $query->bind_param("siii",$ulbid,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		         
		     }
		     
		     
		     $sql2.="group by c.cs_id" ;
		    
		}
		
		else if($_SESSION['user_type']== 'R')
	    {
	  
	        $sql2 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ? and g.http_code=? and 
		    swatchta_app_status = ? group by c.cs_id" ;
		    
		    $rdma=$_SESSION['uid'];
		    $swatchta_app_status_yn='1';
		    $http_code='201';
		    $swatchta_app_status='4';
		    $query=$conn->prepare($sql2);
		    $query->bind_param("iiii",$rdma,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		    
	    }
	    else
	    {
		    $sql2 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    g.ulbid like ? and c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? group by c.cs_id" ;
	        
	        $ulbid="%".$_SESSION['ulbid']."%";
	        $swatchta_app_status_yn='1';
	        $http_code='201';
	        $swatchta_app_status='4';
	        $query=$conn->prepare($sql2);
	        $query->bind_param("siii",$ulbid,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
	        
	    }
	    
	
		$query->execute();
		$rs21=$query->get_result();
		while($row =$rs21->fetch_assoc())
		{
		    $resolved[$row['cs_id']]['count']=$row['count'];
		    $tot3 += $resolved[$row['cs_id']]['count'] ;
		}
		
		
		
		if($_SESSION['user_type'] == 'A')
		{
		    $sql3 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? ";
		    
		    $swatchta_app_status_yn='1';
		    $http_code='201';
		    $swatchta_app_status='6';
		    $query=$conn->prepare($sql3);
		    $query->bind_param("iii",$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		    
		    if($_REQUEST['ulbid']!='')
		     {
		         $sql3.=" and g.ulbid like ? ";
		         
		         $ulbid="%".$_REQUEST['ulbid']."%";
		         $query=$conn->prepare($sql3);
		         $query->bind_param("uiii",$ulbid,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		     }
		     
		     
		     $sql3.="group by c.cs_id" ;
		}
		
		
		else if($_SESSION['user_type']== 'R')
	    {
	        $sql3 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ? and g.http_code=? and 
		    swatchta_app_status = ? group by c.cs_id" ;
		    
		    $rdma=$_SESSION['uid'];
		    $swatchta_app_status_yn='1';
		    $http_code='201';
		    $swatchta_app_status='6';
		    $query=$conn->prepare($sql3);
		    $query->bind_param("iiii",$rdma,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
	    }
		else
		{
		    $sql3 = "select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    g.ulbid like ? and c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? group by c.cs_id" ;
		
		    $ulbid="%".$_SESSION['ulbid']."%";
	        $swatchta_app_status_yn='1';
	        $http_code='201';
	        $swatchta_app_status='6';
	        $query=$conn->prepare($sql3);
	        $query->bind_param("siii",$ulbid,$swatchta_app_status_yn,$http_code,$swatchta_app_status);
		}
		
		
		$query->execute();
		$rs3=$query->get_result();
	   
		while($row = $rs3->fetch_assoc())
	
		{
		    $rejected[$row['cs_id']]['count']=$row['count'];
		    $tot4 += $rejected[$row['cs_id']]['count'] ;
		}
		
		// Total received at ulb
		
		$query5->execute();
		$rs=$query5->get_result();
		
		     
		     while($row = $rs->fetch_assoc())
		     {
		         $received_ulb[$row['cs_id']]['count']=$row['count'];
		         $received_ulbtotal+=$row['count'];
		     }
		
		                      
		
		 $sql = "select * from cs_mst where swatchta_app_status_yn = ? " ;
		 
		 $swatchta_app_status_yn='1';
		 $query=$conn->prepare($sql);
		 $query->bind_param("i",$swatchta_app_status_yn);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['cs_desc'];
				
		}
	
			
			/*$sql ="select COUNT(id) as user_count from login_details where type=? and ulbid like ? "; 
			
			$type='1';
			$ulbid="%".$_SESSION['ulbid']."%";
			$query6=$conn->prepare($sql);
			$query6->bind_param("is",$type,$ulbid);
			$query6->execute();
			$rs=$query6->get_result();*/
	      
	      $row = $rs->fetch_assoc();
	      
	      $users_count=$row['user_count'];
	       $tpl->assign('users_count',$users_count);
    
		$tpl->assign('received_ulbtotal',$received_ulbtotal);
		$tpl->assign('received_ulb',$received_ulb);
		$tpl->assign('sec_level',$_SESSION['sec_level']);			
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('update_code',$update_code);
		$tpl->assign('code',$_REQUEST['code']);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
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
		$tpl->display('swapp_dashboard.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>