<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    $ulb_like = "%".$_SESSION['ulbid']."%";
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		if($_REQUEST['code']==0)
		{
		    
		 
		 $sql = $conn->prepare("select * from category3_mst where ulbid=? and cs_type_id=?");
		 $sql->bind_param("si",$_SESSION['ulbid'],$_REQUEST['cs_type_id']);
		 
		 
		 $sql2 = $conn->prepare("select cs_id from category3_mst where ulbid=? and cs_id IN(select cs_id from emp_map where ulbid=? group by cs_id) and cs_type_id=?");
		 $sql2->bind_param("ssi",$_SESSION['ulbid'],$_SESSION['ulbid'],$_REQUEST['cs_type_id']);
		$sql2->execute();
	    $rs=$sql2->get_result();
	    while($row = $rs->fetch_assoc())
		 {
		    $cs_list[$row['cs_id']]=$row['cs_id'];
		 }
		 
		}
		else if($_REQUEST['code']==1)
		{
		    
	        $sql = $conn->prepare("select * from category3_mst where ulbid=? and cs_id IN(select cs_id from emp_map where ulbid=? group by cs_id) and cs_type_id=?");
	        $sql->bind_param("ssi",$_SESSION['ulbid'],$_SESSION['ulbid'],$_REQUEST['cs_type_id']);
		}
		else if($_REQUEST['code']==2)
		{
    		
    		$sql = $conn->prepare("select * from category3_mst where ulbid=? and cs_id NOT IN(select cs_id from emp_map where ulbid=? group by cs_id) and cs_type_id=?");
    		$sql->bind_param("ssi",$_SESSION['ulbid'],$_SESSION['ulbid'],$_REQUEST['cs_type_id']);
		}
		
		$sql->execute();
	    
		if($rs=$sql->get_result())
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

		
		$sql = $conn->prepare("select ward_id,ward_desc from ward_mst");
		$sql->execute();
	    
	    if($rs=$sql->get_result())
		{
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		
        
        $in_5 = 5;
		
		$sql = $conn->prepare("select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?");
		$sql->bind_param("i",$in_5);
		$sql->execute();
	    
	    if($rs=$sql->get_result())
		{
			while($row = $rs->fetch_assoc())
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		

		
		$sql = $conn->prepare("select dept_id,dept_desc from dept_mst");
		$sql->execute();
	    
	    if($rs=$sql->get_result())
		{
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
					
		$tpl->assign('dept_list',$dept_list);
		
		$in_1 = 1;$in_201 = 201;
		if($_SESSION['user_type'] == 'A')
		{
		   
		     $sql1 = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and c.swatchta_app_status_yn = ? and g.http_code=? group by c.cs_id");
		    $sql1->bind_param("ii",$in_1,$in_201);
		    
		}
		
		else if($_SESSION['user_type']== 'R')
		{
		    
		    $sql1 = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ? and g.http_code=? group by c.cs_id");
		    $sql1->bind_param("sii",$_SESSION['uid'],$in_1,$in_201);
		}
		else
		{
		    $ulb = "%".$_SESSION['ulbid']."%";
		     
		     $sql1 = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and g.http_code=? group by c.cs_id");
		     $sql1->bind_param("sii",$ulb_like,$in_1,$in_201);
		}
		
		$sql1->execute();
	    $rs1=$sql1->get_result();
	
	    while($row = $rs1->fetch_assoc())
		{
		    $received[$row['cs_id']]['count']=$row['count'];
		    $tot1 += $received[$row['cs_id']]['count'];
		}
		
		
		
		
		$in_0 =0; $in_1 = 1; $in_3 =3;
		if($_SESSION['user_type'] == 'A')
		{
		    
		     $qry = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and c.swatchta_app_status_yn = ? and g.http_code=? and (swatchta_app_status=? OR swatchta_app_status=? OR swatchta_app_status=?) group by c.cs_id");
		     $qry->bind_param("iiiii",$in_1,$in_201,$in_0,$in_1,$in_3);
		}
		else if($_SESSION['user_type']== 'R')
	    {
	        
	        $qry = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ? and g.http_code=? and (swatchta_app_status=? OR swatchta_app_status=?) group by c.cs_id");
		    $qry->bind_param("siiii",$_SESSION['uid'],$in_1,$in_201,$in_0,$in_3);
	    }
	    else
	    {
		    
		    $qry = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and g.http_code=? and (swatchta_app_status=? OR swatchta_app_status=? OR swatchta_app_status=?) group by c.cs_id");
		    $qry->bind_param("siiiii",$ulb_like,$in_1,$in_201,$in_0,$in_1,$in_3);
	    }
	    
		$qry->execute();
	    $rs=$qry->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    $pending[$row['cs_id']]['count']=$row['count'];
		    $tot2 += $pending[$row['cs_id']]['count'];
		}
		
		$in_4 = 4;
		
		if($_SESSION['user_type'] == 'A')
		{
		    
		    $sql2 = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? group by c.cs_id");
		    $sql2->bind_param("iii",$in_1,$in_201,$in_4);
		}
		
		else if($_SESSION['user_type']== 'R')
	    {
	  
	       
		    $sql2 = $conn->prepare("elect count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? group by c.cs_id");
		    $sql2->bind_param("siii",htmlspecialchars(strip_tags($_SESSION['uid'])),$in_1,$in_201,$in_4);
	    }
	    else
	    {
		    
		    $sql2 = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    g.ulbid like ? and c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? group by c.cs_id");
		    $sql2->bind_param("siii",$ulb_like,$in_1,$in_201,$in_4);
	    }
	    
		$sql2->execute();
	    $rs2=$sql2->get_result();
	
	    while($row = $rs2->fetch_assoc())
		{
		    $resolved[$row['cs_id']]['count']=$row['count'];
		    $tot3 += $resolved[$row['cs_id']]['count'] ;
		}
		
		$in_6 =6;
		
		if($_SESSION['user_type'] == 'A')
		{
		    
		    $sql3 = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? group by c.cs_id");
		    $sql3->bind_param("iii",$in_1,$in_201,$in_6);
		}
		
		
		else if($_SESSION['user_type']== 'R')
	    {
	        
		    $sql3 = $conn->prepare("elect count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g ,ulbmst u,Districtmst d where g.ulbid=u.ulbid and 
		    u.distid=d.distid and c.cs_id = g.cat3_id and d.rdma = ? and c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? group by c.cs_id");
		    $sql3->bind_param("siii",htmlspecialchars(strip_tags($_SESSION['uid'])),$in_1,$in_201,$in_6);
	    }
		else
		{
		    
		    $sql3 = $conn->prepare("select count(c.cs_id) as count,c.cs_id,g.swatchta_app_status from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		    g.ulbid like ? and c.swatchta_app_status_yn = ? and g.http_code=? and swatchta_app_status = ? group by c.cs_id");
		    $sql3->bind_param("siii",$ulb_like,$in_1,$in_201,$in_6);
		}
		
		$sql3->execute();
	    $rs3 = $sql3->get_result();
	
	    while($row = $rs3->fetch_assoc())
		{
		    $rejected[$row['cs_id']]['count']=$row['count'];
		    $tot4 += $rejected[$row['cs_id']]['count'] ;
		}
		
		
		$array=array(22,25,31,33,71,72,73,74);
		$array2=array('1'=>25,'2'=>31,'3'=>22,'4'=>71,'5'=>33,'6'=>72,'7'=>73,'8'=>74);
		
		$sql = $conn->prepare("select count(grievance_id) as count,g.swatchta_app_status,cat3_id,sw_cat_id from  grievances g where g.ulbid like ? and http_code =? group by cat3_id");
		$sql->bind_param("si",$ulb_like,$in_201);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    if(!in_array($row['cat3_id'],$array))
		    {
		        if(array_key_exists($row['sw_cat_id'],$array2))
		        {
		            $keys[$row['sw_cat_id']]=$row['sw_cat_id'];
		            $cat3_id=$array2[$row['sw_cat_id']];
		            
		            
		        }
		    }
		    else
		    {
		       $cat3_id= $row['cat3_id'];
		      
		    }
		    
		    $ulbsdata[$cat3_id]['posted_to']+=$row['count'];
		    $totals['posted_to'] += $row['count'];
		}
		
	    $sql = $conn->prepare("select count(app_id) as count,sw_cat_id from  lrs_applications g where g.ulbid like ? and http_code =? group by sw_cat_id");
		$sql->bind_param("si",$ulb_like,$in_201);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    
		        if(array_key_exists($row['sw_cat_id'],$array2))
		        {
		            $keys[$row['sw_cat_id']]=$row['sw_cat_id'];
		            $cat3_id=$array2[$row['sw_cat_id']];
		            
		            
		        }
		    
		    else
		    {
		       $cat3_id= $row['sw_cat_id'];
		      
		    }
		    
		    $ulbsdata[$cat3_id]['posted_to']+=$row['count'];
		    $totals['posted_to'] += $row['count'];
		}
		// ading brs applications
		
		
		     
		$sql = $conn->prepare("select count(app_id) as count,sw_cat_id from  brs_application g where g.ulbid like ? and http_code =? group by sw_cat_id");
		$sql->bind_param("si",$ulb_like,$in_201);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    
		        if(array_key_exists($row['sw_cat_id'],$array2))
		        {
		            $keys[$row['sw_cat_id']]=$row['sw_cat_id'];
		            $cat3_id=$array2[$row['sw_cat_id']];
		            
		            
		        }
		    
		    else
		    {
		       $cat3_id= $row['sw_cat_id'];
		      
		    }
		    
		    $ulbsdata[$cat3_id]['posted_to']+=$row['count'];
		    $totals['posted_to'] += $row['count'];
		}
		//	// only surypaet data from aryavysya database
		
		
		     
		$sql = $conn->prepare("select count(family_no) as count,sw_cat_id from  aryavysya_servey  where  ulbid like ? and  http_code =? group by sw_cat_id");
		$sql->bind_param("si",$ulb_like,$in_201);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    
		        if(array_key_exists($row['sw_cat_id'],$array2))
		        {
		            $keys[$row['sw_cat_id']]=$row['sw_cat_id'];
		            $cat3_id=$array2[$row['sw_cat_id']];
		            
		            
		        }
		    
		    else
		    {
		       $cat3_id= $row['sw_cat_id'];
		      
		    }
		    
		    $ulbsdata[$cat3_id]['posted_to']+=$row['count'];
		    $totals['posted_to'] += $row['count'];
		}
		// suryapet external data
		
		
		     
		$sql = $conn->prepare("select count(app_id) as count,sw_cat_id from suryapet_data g where g.ulbid like ? and http_code =? group by sw_cat_id");
		$sql->bind_param("si",$ulb_like,$in_201);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    
		        if(array_key_exists($row['sw_cat_id'],$array2))
		        {
		            $keys[$row['sw_cat_id']]=$row['sw_cat_id'];
		            $cat3_id=$array2[$row['sw_cat_id']];
		            
		            
		        }
		    
		    else
		    {
		       $cat3_id= $row['sw_cat_id'];
		      
		    }
		    
		    $ulbsdata[$cat3_id]['posted_to']+=$row['count'];
		    $totals['posted_to'] += $row['count'];
		}
		
		// Boduppal external data
		
		
		
		     
		$sql = $conn->prepare("select count(app_id) as count,sw_cat_id from  boduppal_data g where g.ulbid like ? and http_code =? group by sw_cat_id");
		$sql->bind_param("si",$ulb_like,$in_201);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    
		        if(array_key_exists($row['sw_cat_id'],$array2))
		        {
		            $keys[$row['sw_cat_id']]=$row['sw_cat_id'];
		            $cat3_id=$array2[$row['sw_cat_id']];
		            
		            
		        }
		    
		    else
		    {
		       $cat3_id= $row['sw_cat_id'];
		      
		    }
		    
		    $ulbsdata[$cat3_id]['posted_to']+=$row['count'];
		    $totals['posted_to'] += $row['count'];
		}
		// Nalgonda survey
		
		
		     
		$sql = $conn->prepare("select count(id) as count,sw_cat_id from nalgonda_survey g where g.ulbid like ? and http_code =? group by sw_cat_id");
		$sql->bind_param("si",$ulb_like,$in_201);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    
		        if(array_key_exists($row['sw_cat_id'],$array2))
		        {
		            $keys[$row['sw_cat_id']]=$row['sw_cat_id'];
		            $cat3_id=$array2[$row['sw_cat_id']];
		            
		            
		        }
		    
		    else
		    {
		       $cat3_id= $row['sw_cat_id'];
		      
		    }
		    
		    $ulbsdata[$cat3_id]['posted_to']+=$row['count'];
		    $totals['posted_to'] += $row['count'];
		}
		
		
		
		/// ulbwise pending
		
		
		     
	    $sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and g.grievance_status_id IN (?) group by cat3_id");
		$sql->bind_param("sii",$ulb_like,$in_1,$in_1);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['pending']=$row['count'];
    		    $totals['pending'] += $row['count'];
    		}
    	// ulbwise on job
    	
    	
		     
        $sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and g.grievance_status_id IN (?) group by cat3_id");
		$sql->bind_param("sii",$ulb_like,$in_1,$in_2);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['underprogress']=$row['count'];
    		    $totals['underprogress'] += $row['count'];
    		}
    	// ulbwise resolved
    	$in_8 = 8;
    	
		
		$sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and (g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=?) group by cat3_id");
		$sql->bind_param("siiiii",$ulb_like,$in_1,$in_3,$in_4,$in_6,$in_8);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['resolved']=$row['count'];
    		    $totals['resolved'] += $row['count'];
    		}
    	// ulbwise rejected
    	
	
		$in_10 = 10;
		$sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and g.grievance_status_id IN (?) group by cat3_id");
		$sql->bind_param("sii",$ulb_like,$in_1,$in_10);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['rejected']=$row['count'];
    		    $totals['rejected'] += $row['count'];
    		}
    	// Total complaints posted
    	
    
		     
		$sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and http_code=? group by cat3_id");
		$sql->bind_param("sii",$ulb_like,$in_1,$in_201);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['posted']=$row['count'];
    		    $totals['posted'] += $row['count'];
    		}
    	// ON open complaint at swachh ta 	
    		
    		$sql = "select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     g.ulbid like '%".$_REQUEST['ulbid']."%' and c.swatchta_app_status_yn = '1' and http_code='201' and swatchta_app_status IN ('1') group by cat3_id";
		     
		$sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and http_code=? and swatchta_app_status IN (?) group by cat3_id");
		$sql->bind_param("siii",$ulb_like,$in_1,$in_201,$in_1);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['opencomplaint']=$row['count'];
    		    $totals['opencomplaint'] += $row['count'];
    		}
    		
    		// ON job at swachh ta 	
    		
    		
		     
		$sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and http_code=? and swatchta_app_status IN (?) group by cat3_id");
		$sql->bind_param("siii",$ulb_like,$in_1,$in_201,$in_3);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['onjob']=$row['count'];
    		    $totals['onjob'] += $row['count'];
    		}
    		
    			// ON Resolved at swachh ta 	
    		
    
		     
		$sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ?' and c.swatchta_app_status_yn = ? and http_code=? and swatchta_app_status IN (?) group by cat3_id");
		$sql->bind_param("siii",$ulb_like,$in_1,$in_201,$in_4);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['completed']=$row['count'];
    		    $totals['completed'] += $row['count'];
    		}
    		
    			// ON Rejected at swachh ta 	
    		
    
		     
		    $sql = $conn->prepare("select count(c.cs_id) as count,g.swatchta_app_status,cat3_id from cs_mst c , grievances g where c.cs_id = g.cat3_id and g.ulbid like ? and c.swatchta_app_status_yn = ? and http_code=? and swatchta_app_status IN (?) group by cat3_id");
		$sql->bind_param("siii",$ulb_like,$in_1,$in_201,$in_6);
		$sql->execute();
	    $rs = $sql->get_result();
	
	    while($row = $rs->fetch_assoc())
    		{
    		    $ulbsdata[$row['cat3_id']]['sw_rejected']=$row['count'];
    		    $totals['sw_rejected'] += $row['count'];
    		}
		
		                      
		
	
		$sql = $conn->prepare("select * from cs_mst where swatchta_app_status_yn = ?");
		$sql->bind_param("i",$in_1);
		$sql->execute();
		if($rs=$sql->get_result())
		{
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['cs_desc'];
				
		}
			
			
		
	    $sql = $conn->prepare("select COUNT(id) as user_count from login_details where type=? and ulbid like ?");
		$sql->bind_param("is",$in_1,$ulb_like);
		$sql->execute();
		$rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	      $users_count=$row['user_count'];
	       $tpl->assign('users_count',$users_count);
    
		
		$tpl->assign('ulbsdata',$ulbsdata);
		$tpl->assign('cs_list',$cs_list);
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
		$tpl->display('categorywise_sw_complaints.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
	}
?>