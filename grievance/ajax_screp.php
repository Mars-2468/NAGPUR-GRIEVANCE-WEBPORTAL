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
		$conn=getconnection();
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
	
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
		
	      $sql="SELECT count(grievance_id) as grievance_id, cat3_id FROM grievances g,cs_mst c 
	      where g.cat3_id=c.cs_id  and app_type_id=? group by cat3_id";
	     $query=$conn->prepare($sql);
		 $app_type_id = 1;
		$query->bind_param("i",$app_type_id);
		$query->execute();
		$rs=$query->get_result();
		
	     
	       
			while($row = $rs->fetch_assoc())
		    {
				  $data[$row['cat3_id']]['total_received']=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			}
			// resolved within sla	 
		 
        $sql="select count(grievance_id) as resolved_within_sla,cat3_id from grievances g , cs_mst  c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and (g.grievance_status_id =? or g.grievance_status_id =? or g.grievance_status_id =?) and sla_status=?  and g.app_type_id=? group by cat3_id"; 
		
		$id3 = 3;
		$id9=9;
		$id8=8;
		$sla_status=1;
		$app_type_id=1;
		
		$query=$conn->prepare($sql);
		 
		$query->bind_param("iiiii",$id3,$id9,$id8,$sla_status,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
		
        
      
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
        	$tot['resolved_within_sla']+=$row['resolved_within_sla'];
			}
			// end
			
			// Resolved beyond sla
			$sql="select count(grievance_id) as resolved_beyond_sla,cat3_id from grievances g , cs_mst  c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and (g.grievance_status_id =? or g.grievance_status_id =? or g.grievance_status_id =?)  and sla_status=?  and g.app_type_id=? group by cat3_id"; 
        
        $id3 = 3;
		$id9=9;
		$id8=8;
		$sla_status=2;
		$app_type_id=1;
		
		$query=$conn->prepare($sql);
		 
		$query->bind_param("iiiii",$id3,$id9,$id8,$sla_status,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        
        
        	 
							
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
        	$tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			}
			// end
			
			// under progress with in sla
			
			 $sql="select count(grievance_id) as pending_within_sla,cat3_id from grievances g , cs_mst c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id =?  and sla_status==?  and g.app_type_id=? group by cat3_id"; 
        
      $status_id = 2;
	  $sla_status=1;
	  $app_type_id=1;
	  
	    $query=$conn->prepare($sql);
		$query->bind_param("iii",$status_id,$sla_status,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        
        
        	 
							
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['pending_within_sla']+=$row['pending_within_sla'];
        	$tot['pending_within_sla']+=$row['pending_within_sla'];
			}
			// under progress beyond sla
			
			 $sql="select count(grievance_id) as pending_beyond_sla,cat3_id from grievances g , cs_mst c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id =?  and sla_status=?  and g.app_type_id=? group by cat3_id"; 
        
		  $status_id = 2;
		  $sla_status=2;
		  $app_type_id=1;
	  
	    $query=$conn->prepare($sql);
		$query->bind_param("iii",$status_id,$sla_status,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
        	$tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
			}
			
			
			// Financial implications
			
				
			
			 $sql="select count(grievance_id) as fin_implication,cat3_id from grievances g , cs_mst c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id IN(?)  and g.app_type_id=? group by cat3_id"; 
        
          $status_id = 6;
		 
		  $app_type_id=1;
	  
	    $query=$conn->prepare($sql);
		$query->bind_param("ii",$status_id,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        
        			
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['fin_implication']+=$row['fin_implication'];
        	$tot['fin_implication']+=$row['fin_implication'];
			}
			
			// Un resolved
			
			 $sql="select count(grievance_id) as unresolved,cat3_id from grievances g , cs_mst c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id =?  and g.app_type_id=? group by cat3_id"; 
        
         $status_id = 4;
		 
		  $app_type_id=1;
	  
	    $query=$conn->prepare($sql);
		$query->bind_param("ii",$status_id,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['unresolved']+=$row['unresolved'];
        	$tot['unresolved']+=$row['unresolved'];;
			}
			
			// Rejected
			
				// Un resolved
			
			 $sql="select count(grievance_id) as rejected,cat3_id from grievances g , cs_mst c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id =?  and g.app_type_id=? group by cat3_id"; 
        
       $status_id = 10;
	   $app_type_id=1;
	  
	    $query=$conn->prepare($sql);
		$query->bind_param("ii",$status_id,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        				
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['rejected']+=$row['rejected'];
        	$tot['rejected']+=$row['rejected'];
			}
			
        		 
			
			
	 	// Reopen 
	 	
			
			 $sql="select count(grievance_id) as reopen,cat3_id from grievances g , cs_mst c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id =?  and g.app_type_id=? group by cat3_id"; 
        
      $status_id = 11;
	   $app_type_id=1;
	  
	    $query=$conn->prepare($sql);
		$query->bind_param("ii",$status_id,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        
        
        	 
							
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['reopen']+=$row['reopen'];
        	$tot['reopen']+=$row['reopen'];
			}	
				
	       
		// Reopen Completed
		
		
				
			 $sql="select count(grievance_id) as reopen_comp,cat3_id from grievances g , cs_mst c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id =?  and g.app_type_id=? group by cat3_id"; 
        
       $status_id = 12;
	   $app_type_id=1;
	  
	    $query=$conn->prepare($sql);
		$query->bind_param("ii",$status_id,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['reopen_comp']+=$row['reopen_comp'];
        	$tot['reopen_comp']+=$row['reopen_comp'];
			}
			
			
			
			// Pending for approval
			
			$sql="select count(grievance_id) as pendigforapproval,cat3_id from grievances g , cs_mst c,ulbmst u  where 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id =?  and g.app_type_id=? group by cat3_id"; 
        
		$status_id = 1;
	   $app_type_id=1;
	  
	    $query=$conn->prepare($sql);
		$query->bind_param("ii",$status_id,$app_type_id);
		$query->execute();
		$rs=$query->get_result();
        
        
        	 
					
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['pendigforapproval']+=$row['pendigforapproval'];
        	$tot['pendigforapproval']+=$row['pendigforapproval'];;
			}
	                    
	      
				
				$sql ="select * from ulbmst";
				$query=$conn->prepare($sql);
				
				$query->execute();
				$rs=$query->get_result();
				
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				    
	        $sql ="select * from cs_mst";
	       $query=$conn->prepare($sql);
				
				$query->execute();
				$rs=$query->get_result();
				
				while($row = $rs->fetch_assoc())
    		{
    			$cs_list[$row['cs_id']]=$row['cs_desc'];
    				    $total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla'];
    				    $data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
    		}
    		$cs_list[0]="Others";
    		
    	//	print_r($cs_list);
    		
    				$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    				
    				
    				
    			$sql ="select cat_id,description from category_mst";
				
				$query=$conn->prepare($sql);
				
				$query->execute();
				$rs=$query->get_result();
				
				
				while($row = $rs->fetch_assoc())
				{
				    $cat_list[$row['cat_id']]=$row['description'];
				}
				  		
        		$query->close();
        		
	
	}

?>

<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									
										<thead>
										  
										<tr class="mytr_bgcolor">
											<td rowspan="2">S.No</td>
											<td rowspan="2">Complaints </td>
											<td rowspan="2">Received</td>
											<td rowspan="2">Pending for Approval</td>
											<td colspan="2" align="center">Resolved</td>
											<td colspan="2" align="center">Pending</td>
											<td rowspan="2">Financial Implications</td>
											<td rowspan="2">Reopen</td>
											<td rowspan="2">Reopend Completed</td> 
											<td rowspan="2">Rejected</td>
											<td rowspan="2">Un resolved</td>
											<td rowspan="2">% of Complete</td>
											
											
										</tr>
										
										
									
									<tr class="mytr_bgcolor">
									<td align="center">With in SLA</td>
									<td align="center">Beyond SLA</td>
									<td align="center">With in SLA</td>
									<td align="center">Beyond SLA</td>
									
									</tr>
									</thead>
									<tbody>
									    
									    <?php $i=1;foreach($cs_list as $section_id=>$value){?>
									   
									    <tr>
									        <td><?php echo $i; ?></td>
									       
									        <td><?php echo $cs_list[$section_id]; ?></td>
									        <td><?php echo $data[$section_id]['total_received']; ?></td>
									        
									        <td><?php echo $data[$section_id]['pendigforapproval']; ?> </td>
									        <td><?php echo $data[$section_id]['resolved_within_sla']; ?> </td>
									        <td><?php echo $data[$section_id]['resolved_beyond_sla']; ?></td>
									        
									        <td><?php echo $data[$section_id]['pending_within_sla']; ?> </td>
									        <td><?php echo $data[$section_id]['pending_beyond_sla']; ?> </td>
									        
									        <td><?php echo $data[$section_id]['fin_implication']; ?> </td>
									        <td><?php echo $data[$section_id]['reopen']; ?> </td>
									        <td><?php echo $data[$section_id]['reopen_comp']; ?> </td>
									        <td><?php echo $data[$section_id]['rejected']; ?> </td>
									        <td><?php echo $data[$section_id]['unresolved']; ?> </td>
									        <td><?php echo $data[$section_id]['percent']; ?> </td>
									    </tr>
									   <?php $i++; } ?>
									</tbody>
									<tfoot>
									    
									     <tr>
									        <td colspan="2">Total</td>
									       
									        <td><?php echo $tot['total_received']; ?></td>
									        <td><?php echo $tot['pendigforapproval']; ?> </td>
									        
									        <td><?php echo $tot['resolved_within_sla']; ?> </td>
									        <td><?php echo $tot['resolved_beyond_sla']; ?> </td>
									        
									        <td><?php echo $tot['pending_within_sla']; ?> </td>
									        <td><?php echo $tot['pending_beyond_sla']; ?> </td>
									        
									        <td><?php echo $tot['fin_implication']; ?> </td>
									       <td><?php echo $tot['reopen']; ?> </td>
									        <td><?php echo $tot['reopen_comp']; ?></td>
									        <td><?php echo $tot['rejected']; ?> </td>
									        <td><?php echo $tot['unresolved']; ?> </td>
									        <td><?php echo $tot['percent']; ?> </td>
									    </tr>
									    
									</tfoot>
			</table>