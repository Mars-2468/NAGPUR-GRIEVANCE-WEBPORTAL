<?php
require "config.php";
	ini_set('display_errors',0);
	if(isset($_SESSION['uid']))
	{
	
		require_once('connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
		
	
		$sql ="select emp_id,emp_name from emp_mst where emp_id IN(select emp_id from emp_map where emp_id3=?)";
		$emp_id = htmlspecialchars(strip_tags($_SESSION['emp_id']));
		$query=$conn->prepare($sql);
        $query->bind_param("s",$distid);
        $query->execute();
	    $rs=$query->get_result();
		
	       
		   
    		while($row = $rs->fetch_assoc())
    		{
    			$emp_list[$row['emp_id']]=$row['emp_name'];
    			$emp_ids[$row['emp_id']]=$row['emp_id'];
    		}
			
			$query->close();
    		
    		$sql ="select emp_id,emp_name from emp_mst where emp_id IN(select emp_id2 from emp_map where emp_id3=?)";
			$query=$conn->prepare($sql);
			$query->bind_param("s",$emp_id);
			$query->execute();
			$rs=$query->get_result();
			
	        
    		while($row = $rs->fetch_assoc())
    		{
    			$emp_list[$row['emp_id']]=$row['emp_name'];
    			$emp_ids[$row['emp_id']]=$row['emp_id'];
    		}
			
			$query->close();
    		
    		foreach($emp_list as $emp_id=>$emp_name)
    		{
		
                	      $sql="SELECT count(g.grievance_id) as totalreceived,emp_id FROM grievances g,grievances_transactions gt
                	      where g.grievance_id=gt.grievance_id and app_type_id=? and cat3_id !=? and gt.emp_id=?";
						  
						  $app_type_id = 1;
						  $cat3_id = 0;
						  $emp_id_loop = $emp_id;
						  
						    $query=$conn->prepare($sql);
							$query->bind_param("iii",$app_type_id,$cat3_id,$emp_id_loop);
							$query->execute();
							$rs=$query->get_result();
						  
						  while($row = $rs->fetch_assoc())
                		    {
                				  $data[$row['emp_id']]['total_received']+=$row['totalreceived'];
                				  $tot['total_received']+=$row['totalreceived'];
                			}
                				 
                		 $query->close();
                        
                			
                			/**** resolved with in sla ****/
                			
                			$sql ="select COUNT(g.grievance_id) as resolved_within_sla,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and gt.emp_id=? and app_type_id=? and cat3_id !=? and sla_status=?";
							$id3=3;
							$id8=8;
							$id9=9;
							$app_type_id = 1;
							$cat3_id = 0;
							$sla_status = 1;
							
							$query=$conn->prepare($sql);
							$query->bind_param("iiiiiii",$id3,$id8,$id9,$emp_id_loop,$app_type_id,$cat3_id,$sla_status);
							$query->execute();
							$rs=$query->get_result();
							
                							
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$row['emp_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
                			    $tot['resolved_within_sla']+=$row['resolved_within_sla'];
                			}
                			$query->close();
                			/**** resolved beyond sla ****/
                			
                			$sql ="select COUNT(g.grievance_id) as resolved_beyond_sla,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and gt.emp_id=? and app_type_id=? and cat3_id !=? and sla_status=?";
							
							$id3=3;
							$id8=8;
							$id9=9;
							$app_type_id = 1;
							$cat3_id = 0;
							$sla_status = 1;
							
							$query=$conn->prepare($sql);
							$query->bind_param("iiiiiii",$id3,$id8,$id9,$emp_id_loop,$app_type_id,$cat3_id,$sla_status);
							$query->execute();
							$rs=$query->get_result();
							
                							
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$row['emp_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
                			    $tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
                			}
                			
                			/**** pending with in sla ****/
                			
                			$sql ="select COUNT(g.grievance_id) as pending_within_sla,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and grievance_status_id =? and gt.emp_id=? and app_type_id=? and cat3_id !=? and sla_status=?";
							
							$status_id = 2;
							$app_type_id = 1;
							$cat3_id = 0;
							$sla_status = 1;
							
							$query=$conn->prepare($sql);
							$query->bind_param("iiiii",$status_id,$emp_id_loop,$app_type_id,$cat3_id,$sla_status);
							$query->execute();
							$rs=$query->get_result();
										
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$row['emp_id']]['pending_within_sla']+=$row['pending_within_sla'];
                			    $tot['pending_within_sla']+=$row['pending_within_sla'];
                			}
                			
                			
                				/**** pending with beyond sla ****/
                			
                			$sql ="select COUNT(g.grievance_id) as pending_beyond_sla,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and grievance_status_id =? and gt.emp_id=? and app_type_id=? and cat3_id !=? and sla_status=?";
							
							$status_id = 2;
							$app_type_id = 1;
							$cat3_id = 0;
							$sla_status = 2;
							
							$query=$conn->prepare($sql);
							$query->bind_param("iiiii",$status_id,$emp_id_loop,$app_type_id,$cat3_id,$sla_status);
							$query->execute();
							$rs=$query->get_result();
                						
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$row['emp_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
                			    $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
                			}
                			
                			
                	        
                	        $sql ="select COUNT(g.grievance_id) as fin_implication,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and grievance_status_id =? and gt.emp_id=? and app_type_id=? and cat3_id !=?";
                	        
							$status_id = 6;
							$app_type_id = 1;
							$cat3_id = 0;
							
							
							$query=$conn->prepare($sql);
							$query->bind_param("iiii",$status_id,$emp_id_loop,$app_type_id,$cat3_id);
							$query->execute();
							$rs=$query->get_result();			
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$row['emp_id']]['fin_implication']+=$row['fin_implication'];
                				 $tot['fin_implication']+=$row['fin_implication'];
                			}
                			
                			
                	         $sql ="select COUNT(g.grievance_id) as pending_apprvl,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and grievance_status_id =? and gt.emp_id=? and app_type_id=? and cat3_id !=?";
							 
							$status_id = 1;
							$app_type_id = 1;
							$cat3_id = 0;
							
							
							$query=$conn->prepare($sql);
							$query->bind_param("iiii",$status_id,$emp_id_loop,$app_type_id,$cat3_id);
							$query->execute();
							$rs=$query->get_result();	
                	                    
                	       				
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$row['emp_id']]['pending_apprvl']+=$row['pending_apprvl'];
                				 $tot['pending_apprvl']+=$row['pending_apprvl'];
                			}
                			
                			 $sql ="select COUNT(g.grievance_id) as rejected,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and grievance_status_id =? and gt.emp_id=? and app_type_id=? and cat3_id !=?";
							 
							 $status_id = 10;
							 $app_type_id = 1;
							 $cat3_id = 0;
							
							
							$query=$conn->prepare($sql);
							$query->bind_param("iiii",$status_id,$emp_id_loop,$app_type_id,$cat3_id);
							$query->execute();
							$rs=$query->get_result();
                	                    
                	        while($row = $rs->fetch_assoc())
                			{
                				 $data[$row['emp_id']]['rejected']+=$row['rejected'];
                				 $tot['rejected']+=$row['rejected'];
                			}
							
                			$sql ="select COUNT(g.grievance_id) as unresolved,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and grievance_status_id =? and gt.emp_id=? and app_type_id=? and cat3_id !=?";
							
							 $status_id = 4;
							 $app_type_id = 1;
							 $cat3_id = 0;
							
							
							$query=$conn->prepare($sql);
							$query->bind_param("iiii",$status_id,$emp_id_loop,$app_type_id,$cat3_id);
							$query->execute();
							$rs=$query->get_result();
                	                    
                	        			
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$row['emp_id']]['unresolved']+=$row['unresolved'];
                				 $tot['unresolved']+=$row['unresolved'];
                			}
                			
                		$sql ="select count(g.grievance_id) as count,emp_id,grievance_status_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and (g.grievance_status_id =? or g.grievance_status_id =? or g.grievance_status_id =?) and gt.emp_id=? group by app_type_id,grievance_status_id";
						
						$id11=11;
						$id12=12;
						$id13=13;
						
						    $query=$conn->prepare($sql);
							$query->bind_param("iiii",$id11,$id12,$id13,$emp_id_loop);
							$query->execute();
							$rs=$query->get_result();
						 while($row = $rs->fetch_assoc())
		                {
		                    $reopened_completed_tot[$row['emp_id']][$row['grievance_status_id']]['count']=$row['count'];
		                    $tot[$row['grievance_status_id']]['count']+=$row['count'];
		                }
			
    		}
			
	                    
	   
				
				$sql ="select * from ulbmst";
				$query=$conn->prepare($sql);
				$query->execute();
				$rs=$query->get_result();
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				    
	        
    		$query->close();
    				
    				
    				
    				
    		
				  		
        		
        	
        
	}
	
?>



<div style="width:100%; overflow:scroll;">
	     <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									
										<thead>
										  
										<tr class="mytr_bgcolor" style="background-color:#161D6E; color:#FFF;">
											<td rowspan="2">S.No</td>
											
											<td rowspan="2">Employee name </td>
											<td rowspan="2">Received</td>
											
											<td colspan="2" align="center">Resolved</td>
											<td colspan="2" align="center">Pending</td>
											<td rowspan="2">Financial Implications</td>
											<td rowspan="2">Pending for approval</td>
											<td rowspan="2">Rejected</td>
											<td rowspan="2">Unresolved</td>
											<td rowspan="2">Reopened</td>
											<td rowspan="2">Reopened under progress</td>
											<td rowspan="2">Reopened completed</td>
											
											
											
										</tr>
										
										
									
									<tr class="mytr_bgcolor" style="background-color:#161D6E; color:#FFF;">
									<td align="center">With in SLA</td>
									<td align="center">Beyond SLA</td>
									<td align="center">With in SLA</td>
									<td align="center">Beyond SLA</td>
									
									</tr>
									</thead>
									<tbody>
									    <?php $i=1;foreach($emp_list as $cs_id=>$emp_name){?>
									    
									    <tr>
									        <td><?php echo $i; ?></td>
									        <td><?php echo $emp_list[$cs_id]; ?> </td>
									        
									        <td><?php echo $data[$cs_id]['total_received']; ?></td>
							
									        <td><?php echo $data[$cs_id]['resolved_within_sla']; ?></td>
									        <td><?php echo $data[$cs_id]['resolved_beyond_sla']; ?></td>
									        
									        <td><?php echo $data[$cs_id]['pending_within_sla']; ?></td>
									        <td><?php echo $data[$cs_id]['pending_beyond_sla']; ?></td>
									        
									        <td><?php echo $data[$cs_id]['fin_implication']; ?></td>
									       <td><?php echo $data[$cs_id]['pending_apprvl']; ?></td>
									        <td><?php echo $data[$cs_id]['rejected']; ?></td>
									        <td><?php echo $data[$cs_id]['unresolved']; ?></td>
									        <td><?php echo $reopened_completed_tot[$cs_id][13]['count']; ?></td>
									        <td><?php echo $reopened_completed_tot[$cs_id][11]['count']; ?></td>
									        <td><?php echo $reopened_completed_tot[$cs_id][12]['count']; ?></td>
									        
									    </tr>
									    <?php $i++; } ?>
									</tbody>
									<tfoot>
									    
									     <tr>
									        <td colspan="2">Total</td>
									       
									        <td><?php echo $tot['total_received']; ?></td>
									        
									        
									        <td><?php echo $tot['resolved_within_sla']; ?></td>
									        <td><?php echo $tot['resolved_beyond_sla']; ?></td>
									        
									        <td><?php echo $tot['pending_within_sla']; ?></td>
									        <td><?php echo $tot['pending_beyond_sla']; ?></td>
									        
									        <td><?php echo $tot['fin_implication']; ?></td>
									        <td><?php echo $tot['pending_apprvl']; ?></td>
									        <td><?php echo $tot['rejected']; ?></td>
									        <td><?php echo $tot['unresolved']; ?></td>
									        <td><?php echo $tot[13]['count']; ?></td>
									        <td><?php echo $tot[11]['count']; ?></td>
									        <td><?php echo $tot[12]['count']; ?></td>
									        
									    </tr>
									    
									</tfoot>
			</table>