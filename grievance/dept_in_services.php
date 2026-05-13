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
		/// In case of service 
		
		
		if($_REQUEST['aptid']=='2')
		{
		
				if($_REQUEST['aptid']=='2' && $_REQUEST['status']==0 && isset($_SESSION['ulbid']) && $_SESSION['user_type']=='U')
					{
						// Ulb login Total Assigned services
					 
					  
					  $sql="select count(g.grievance_id) as count,g.*,c.*,g1.*,DATEDIFF(disposed_date,date_regd) AS target from grievances g,
					  category3_mst c,grievances_transactions g1 where g.cat3_id=c.cs_id and g.grievance_id=g1.grievance_id and 
					  g.ulbid=? and g.app_type_id=? and g1.disposal_status!=? group by g1.dept_id";
					  
					  
					 
					  $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
					  $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					  $disposal_status=5;
					  $query=$conn->prepare($sql);
					  $query->bind_param("sii",$ulbid,$app_type_id,$disposal_status);
					  
					  
					  
					}
					
					else if ($_REQUEST['aptid']=='2' && $_REQUEST['status']==3 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==1 && $_SESSION['user_type']=='U')
					{
						// Ulb login completed services with IN SLA
			
            			
            			
                $sql="select count(g.grievance_id)as count,gt.*,g.*,c.*,DATEDIFF(disposed_date,date_regd) AS target from grievances g,
            			category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and 
            			g.grievance_status_id IN(?) and gt.disposal_status!=? and g.ulbid=? and 
            			g.app_type_id=? and  g.grievance_status_id !=? group by c.dept_id";	
            			$grievance_status_id=3;
            			$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    					$app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
    					$disposal_status=5;
    					$grievance_status_id1=1;
    					$query=$conn->prepare($sql);
					    $query->bind_param("iisii",$grievance_status_id,$disposal_status,$ulbid,$app_type_id,$grievance_status_id1);
            			
					}
					else if ($_REQUEST['aptid']=='2' && $_REQUEST['status']==3 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==2 && $_SESSION['user_type']=='U')
					{
						
						// Ulb login completed services beyond SLA
						
					
				
					 $sql="select g.*,c.dept_id,disposed_date from grievances g,category3_mst c,grievances_transactions gt where 
					 g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id  and g.grievance_status_id IN(?) and 
					 g.ulbid=? and g.app_type_id=?";
					 $grievance_status_id=3;
            		 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				 $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
    				 $query=$conn->prepare($sql);
					 $query->bind_param("isi",$grievance_status_id,$ulbid,$app_type_id);
					
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==2 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==1  && $_SESSION['user_type']=='U')
					{
						// Ulb login under progress services with IN SLA
						
				
				  $sql="select count(g.grievance_id)as count,g.*,g1.*,c.*,DATEDIFF(disposed_date,date_regd) AS target from grievances g,
				  grievances_transactions g1,category3_mst c where g.grievance_id=g1.grievance_id and g.cat3_id=c.cs_id  and 
				  (g.grievance_status_id!=? or g.grievance_status_id!=?) and g.ulbid=? and g1.disposal_status!=? and 
				    g.app_type_id=? group by g1.dept_id";
				  	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
    			    $disposal_status=5;
    			    $grievance_status_id1=3;
    			    $grievance_status_id2=6;
				    $query=$conn->prepare($sql);
			 	    $query->bind_param("iisii",$grievance_status_id1,$grievance_status_id2,$ulbid,$disposal_status,$app_type_id);
				  
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==2 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==2 && $_SESSION['user_type']=='U')
					{
						// Ulb login under progress services beyond SLA
						
				
					
						$sql="select g.*,c.dept_id from grievances g,category3_mst c where g.cat3_id=c.cs_id and  g.grievance_status_id NOT IN(?) 
					and g.ulbid=? and g.app_type_id=?";
					$grievance_status_id=3;
					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
				     $query=$conn->prepare($sql);
			 	    $query->bind_param("isi",$grievance_status_id,$ulbid,$app_type_id);
					}
					
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==3 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==1)
					{
						////////// employee login Completed services With in SLA
						
						
					    
					    
					    
					    $sql="select g.*,c.cat_id from grievances g,category3_mst c,grievances_transactions gt where 
					    g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN(?) and 
					    g.ulbid=? and g.app_type_id=? and gt.emp_id=?";
					    $grievance_status_id=3;
    					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("isis",$grievance_status_id,$ulbid,$app_type_id,$emp_id);
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==3 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==2)
					{
						////////// employee login Completed services beyond SLA
						
						
					    $sql="select g.*,c.cat_id from grievances g,category3_mst c,grievances_transactions gt where 
					    g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN(?) and 
					    g.ulbid=? and g.app_type_id=? and gt.emp_id=?";
					    
					    $grievance_status_id=3;
    					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("isis",$grievance_status_id,$ulbid,$app_type_id,$emp_id);
					    
					    
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==2 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==1)
					{
						////////// employee login Under progress  services beyond SLA
						
						
					    $sql="select g.*,c.cat_id from grievances g,category3_mst c,grievances_transactions gt where 
					    g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id NOT IN(?) and 
					    g.ulbid=? and g.app_type_id=? and 
					    gt.emp_id=?";
					    $grievance_status_id=3;
    					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("isis",$grievance_status_id,$ulbid,$app_type_id,$emp_id);
					    
					    
					    
					    
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==2 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==2)
					{
						////////// employee login Under progress  services beyond SLA
						
						
					    $sql="select g.*,c.cat_id from grievances g,category3_mst c,grievances_transactions gt where 
					    g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id NOT IN(?) and 
					    g.ulbid=? and g.app_type_id=? and 
					    gt.emp_id=?";
					    $grievance_status_id=3;
    					 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("isis",$grievance_status_id,$ulbid,$app_type_id,$emp_id);
					    
					    
					    
					    
					}
					else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==0 && $_SESSION['user_type']=='E')
					{
						// Ulb login Total Assigned services
					 $sql="select g.*,c.cat_id from grievances g,category3_mst c,grievances_transactions gt where 
					 g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id  and g.app_type_id=? 
					 and gt.emp_id=?";
					 
					    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("is",$app_type_id,$emp_id);
					 
					 
					 
					 
					}
		}
		
	
		// in case of complaint
		
		
		
		if($_REQUEST['aptid']=='1')
		{
		
			
		
			if($_REQUEST['aptid']=='1' && $_REQUEST['status']==0 && isset($_SESSION['ulbid']) && $_SESSION['user_type']=='U')
				{
					// ulb login Total assigned complaints
			
				
				 $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c where g.cat3_id=c.cs_id and 
				g.ulbid=? and g.app_type_id=?";
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    			$app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
				$query=$conn->prepare($sql);
				$query->bind_param("si",$ulbid,$app_type_id);
				
				}
				else if ($_REQUEST['aptid']=='1' && $_REQUEST['status']==3 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==1 && $_SESSION['user_type']=='U')
				{
					// ulb login completed complaints with in sla
				 
				 
				 $sql="select g.*,c.cat_id,gt.disposed_date from grievances g,complaint_ulbmap c,grievances_transactions gt 
				 where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and  g.grievance_status_id IN(?) and 
				 g.ulbid=? and g.app_type_id=?";
				  $grievance_status_id=3;
				 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    			$app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
				$query=$conn->prepare($sql);
				$query->bind_param("isi",$grievance_status_id,$ulbid,$app_type_id);
				 
				}
				else if ($_REQUEST['aptid']=='1' && $_REQUEST['status']==3 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==2 && $_SESSION['user_type']=='U')
				{
					// ulb login completed complaints beyond sla
					
				
				
				
				
				$sql="select g.*,c.cat_id,gt.disposed_date from grievances g,complaint_ulbmap c,grievances_transactions gt where 
				g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and  g.grievance_status_id IN(?) and 
				g.ulbid=? and g.app_type_id=?";
				$grievance_status_id=3;
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    			$app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
				$query=$conn->prepare($sql);
				$query->bind_param("isi",$grievance_status_id,$ulbid,$app_type_id);
				
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==2 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==1 && $_SESSION['user_type']=='U')
				{
					// ulb login under progress complaints with in sla
					
					
				 $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c where g.cat3_id=c.cs_id and  
				 g.grievance_status_id NOT IN(?) and g.ulbid=?  and g.app_type_id=?";
				 $grievance_status_id=3;
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    			$app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
				$query=$conn->prepare($sql);
				$query->bind_param("isi",$grievance_status_id,$ulbid,$app_type_id);
				 
				 
				 
				 
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==2 && isset($_SESSION['ulbid']) && $_REQUEST['sla']==2 && $_SESSION['user_type']=='U')
				{
					// ulb login under progress complaints beyond sla
					
				 $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c where  g.cat3_id=c.cs_id and  
				 g.grievance_status_id NOT IN(?) and g.ulbid=? and g.app_type_id=?";
				 
				$grievance_status_id=3;
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    			$app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
				$query=$conn->prepare($sql);
				$query->bind_param("isi",$grievance_status_id,$ulbid,$app_type_id);
				 
				 
				 
				 
				 
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==0 && isset($_SESSION['ulbid']) && $_SESSION['user_type']=='E')
				{
					////////// employee login Total Assigned complaints
					
				 $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c,grievances_transactions gt 
				 where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid=? 
				 and g.app_type_id=? and gt.emp_id=?";
				
    					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("sis",$ulbid,$app_type_id,$emp_id);
				 
				 
				 
				 
				 
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==3 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==1)
				{
					////////// employee login Completed complaints With in SLA
					
					
				    $sql="select g.*,c.cat_id,gt.disposed_date from grievances g,complaint_ulbmap c,grievances_transactions gt 
				    where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN(?) and 
				    g.ulbid=? and g.app_type_id=? and gt.emp_id=?";
				        $grievance_status_id=3;
    					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("isis",$grievance_status_id,$ulbid,$app_type_id,$emp_id);
				    
				    
				    
				    
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==3 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==2)
				{
					////////// employee login Completed complaints beyond SLA
					
					
				    $sql="select g.*,c.cat_id,gt.disposed_date from grievances g,complaint_ulbmap c,grievances_transactions gt 
				    where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN(?) and 
				    g.ulbid=? and g.app_type_id=? and gt.emp_id=?";
				    
				        $grievance_status_id=3;
    					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("isis",$grievance_status_id,$ulbid,$app_type_id,$emp_id);
				    
				    
				    
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==2 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==1)
				{
					////////// employee login Under progress  complaints beyond SLA
					
					
				    $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c,grievances_transactions gt where 
				    g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id NOT IN(?) and 
				    g.ulbid=?  and g.app_type_id=? and gt.emp_id=?";
				    
				        $grievance_status_id=3;
    					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("isis",$grievance_status_id,$ulbid,$app_type_id,$emp_id);
				    
				    
				    
				}
				else if($_REQUEST['aptid']=='1' && $_REQUEST['status']==2 && $_SESSION['user_type']=='E' && $_REQUEST['sla']==2)
				{
					////////// employee login Under progress  complaints beyond SLA
					
					
				    $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c,grievances_transactions gt where 
				    g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id NOT IN(?) and 
				    g.ulbid=?  and g.app_type_id=? and gt.emp_id=?";
				    
				    $grievance_status_id=3;
    					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("isis",$grievance_status_id,$ulbid,$app_type_id,$emp_id);
				    
				    
				    
				    
				}
				else if($_REQUEST['aptid']=='2' && $_REQUEST['status']==0 && isset($_SESSION['ulbid']) && $_SESSION['user_type']=='E')
				{
					////////// employee login Total Assigned services
					
				 $sql="select g.*,c.cat_id from grievances g,complaint_ulbmap c,grievances_transactions gt where 
				 g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid=? and 
				 g.app_type_id=? and gt.emp_id=?";
				 
				 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    				    $app_type_id=htmlspecialchars(strip_tags($_REQUEST['aptid']));
					    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
					    $query=$conn->prepare($sql);
					    $query->bind_param("sis",$ulbid,$app_type_id,$emp_id);
				 
				 
				}
		
		}

		$query->execute();
		$rs=$query->get_result();
		
		
		
		if($rs)
		{
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
				if($_REQUEST['aptid']==2  && $_REQUEST['sla']==1)
				{
				 if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] <= $row['cutt_of_time'])
					 {
					
					 foreach($field_info as $fi => $f) 
					//$data[$row['grievance_id']][$f->name]=$row[$f->name];
					$data[$row['dept_id']]['count']=$row['count'];
					 }

				}
				else if($_REQUEST['aptid']==2 && $_REQUEST['sla']==2)
				{
					if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] > $row['cutt_of_time'])
					 {
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 }
				}
				
				else if($_REQUEST['aptid']==1  && $_REQUEST['sla']==1)
				{
					if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] <= 1)
					 {
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 }
				}
				else if($_REQUEST['aptid']==1 && $_REQUEST['sla']==2)
				{
					if($row['target']=="")
					 {
					 $row['target']=0;
					 }
					 if($row['target'] > 1)
					 {
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 }
				}
				else if($_REQUEST['status']=='fin')
				{
					
					
					 foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 
				}
				else if($_REQUEST['aptid']==1)
				{
					foreach($field_info as $fi => $f) 
					//$data[$row['grievance_id']][$f->name]=$row[$f->name];
					$data[$row['dept_id']]['count']=$row['count'];
				}
				else if($_REQUEST['aptid']==2)
				{
					foreach($field_info as $fi => $f) 
					//$data[$row['grievance_id']][$f->name]=$row[$f->name];
					$data[$row['dept_id']]['count']=$row['count'];
				}
			}
			}
			
		
		$tpl->assign('data',$data);



			
		$sql=$conn->prepare("select ward_id,ward_desc from ward_mst");
		$sql->execute();
		$rs=$sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		    $ward_list[$row['ward_id']]=$row['ward_desc'];
		}
			
		
			
	$sql =$conn->prepare("select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?");
		$grievance_status_id=5;
		$sql->bind_param("i",$grievance_status_id);
		$sql->execute();
		$rs=$sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		   	$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
	
	
			
		$sql=$conn->prepare("select dept_id,dept_desc from dept_mst");
		$sql->execute();
		$rs=$sql->get_result();
		while($row =$rs->fetch_assoc())
		{
		    	$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
			
					
		$tpl->assign('dept_list',$dept_list);
		
		
		
		$sql="select cs_id,comp_desc from category3_mst where ulbid=?";
		$query = $conn->prepare($sql);
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query->bind_param("s",$ulbid);
		
		
		
		
		if($_REQUEST['aptid']=='1')
		{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		$query = $conn->prepare($sql);
		}
		$query->execute();
		$rs = $query->get_result();
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
			
			
			
		$conn->close();
		$tpl->assign('sla',$_REQUEST['sla']);	
		$tpl->assign('status',$_REQUEST['status']);	
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('dept_in_services.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>