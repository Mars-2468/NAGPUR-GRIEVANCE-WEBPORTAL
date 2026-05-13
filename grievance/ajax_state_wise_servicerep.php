<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');

	if(isset($_SESSION['uid']))
	{
		
		/*require_once('connection.php');
		$conn=getconnection();*/
		
		require_once('prepare_connection.php');
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
        $user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
		
	      $sql="SELECT count(grievance_id) as grievance_id, merg_cs_id FROM grievances g,category3_mst c
	      where g.cat3_id=c.cs_id and g.app_type_id=? and g.cat3_id!=? group by merg_cs_id";
	      
	      
	      $app_type_id = 2; 
	      $cat3_id = 0;
	      $query=$conn->prepare($sql);
          $query->bind_param("ii",$app_type_id,$cat3_id);
          if(!$query->execute())
    		        {
    		            echo "Query not executed 1";
    		        }
    	   $rs=$query->get_result();
    	   
			while($row = $rs->fetch_assoc())
		    {
				  $data[$row['merg_cs_id']]['total_received']=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			}
			
			$query->close(); 
		 
        $sql="select count(grievance_id) as resolved_within_sla,merg_cs_id from grievances g ,category3_mst c where g.cat3_id=c.cs_id and 
         g.grievance_status_id IN(?)  and sla_status=?  and g.app_type_id=? and cat3_id !=? group by merg_cs_id"; 
        
                        $app_type_id=2;
        	            $disposal_status = 5;
        	            $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        	            $cat3_id = 0;
        	            $sla_status=1;
        	            $grievance_status_id = 6;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("siii",$inclause,$sla_status,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 2";
            		        }
    	                $rs=$query->get_result();
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['merg_cs_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
        	$tot['resolved_within_sla']+=$row['resolved_within_sla'];
			}
			// end
			
			$query->close();
			
			// Resolved beyond sla
			$sql="select count(grievance_id) as resolved_beyond_sla,merg_cs_id from grievances g ,category3_mst c where g.cat3_id=c.cs_id and
        g.grievance_status_id IN(?)  and sla_status=?  and g.app_type_id=? and cat3_id != ? group by merg_cs_id"; 
        
                        $app_type_id=2;
        	            $disposal_status = 5;
        	            $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $grievance_status_id = 6;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("siii",$inclause,$sla_status,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 3";
            		        }
    	                $rs=$query->get_result();
        
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['merg_cs_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
        	$tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			}
			// end
			
			$query->close();
			
		$sql="select count(grievance_id) as pending_within_sla,merg_cs_id from grievances g ,category3_mst c where 
        g.cat3_id=c.cs_id and g.grievance_status_id IN(?)  and sla_status=?  and g.app_type_id=? and cat3_id != ? group by merg_cs_id"; 
        
        
                        $app_type_id=2;
        	            $disposal_status = 5;
        	            $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        	            $cat3_id = 0;
        	            $sla_status=1;
        	            $grievance_status_id = 2;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iiii",$grievance_status_id,$sla_status,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 4";
            		        }
    	                $rs=$query->get_result();
        
        	 
						
            			while($row = $rs->fetch_assoc())
            			{
            			$data[$row['merg_cs_id']]['pending_within_sla']+=$row['pending_within_sla'];
                    	$tot['pending_within_sla']+=$row['pending_within_sla'];
            			}
			            
			            $query->close();
			
				$sql="select count(grievance_id) as pending_beyond_sla,merg_cs_id from grievances g ,category3_mst c where g.cat3_id=c.cs_id and
        g.grievance_status_id IN(?)  and sla_status=?  and g.app_type_id=? and cat3_id != ? group by merg_cs_id"; 
        
                        $app_type_id=2;
        	            $disposal_status = 5;
        	            $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $grievance_status_id = 2;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iiii",$grievance_status_id,$sla_status,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 5";
            		        }
    	                $rs=$query->get_result();
        
        
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['merg_cs_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
        	$tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
			}
			
			$query->close();
	 		
			// Financial implications
			
				
			
			 $sql="select count(grievance_id) as fin_implication,merg_cs_id from grievances g ,category3_mst c where g.cat3_id=c.cs_id and
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by merg_cs_id"; 
        
                        $app_type_id=2;
        	            $disposal_status = 5;
        	            $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $grievance_status_id = 6;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 6";
            		        }
    	                $rs=$query->get_result();
        
        
        	 
					
            			while($row = $rs->fetch_assoc())
            			{
            			$data[$row['merg_cs_id']]['fin_implication']+=$row['fin_implication'];
                    	$tot['fin_implication']+=$row['fin_implication'];
            			}
            			
            			$query->close();
            			
            			// Un resolved
			
			 $sql="select count(grievance_id) as unresolved,merg_cs_id from grievances g ,category3_mst c where g.cat3_id=c.cs_id and
        grievance_status_id IN(?)  and app_type_id=? and cat3_id != ? group by merg_cs_id"; 
        
        
        
        
                        $app_type_id=2;
        	            $disposal_status = 5;
        	            $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $grievance_status_id = 4;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 7";
            		        }
    	                $rs=$query->get_result();
        
      
        
        
        	 
					
			while($row = $rs->fetch_assoc())
			{
			$data[$row['merg_cs_id']]['unresolved']+=$row['unresolved'];
        	$tot['unresolved']+=$row['unresolved'];;
			}
			
			$query->close();
			
			// Rejected
			
				
			
			 $sql="select count(grievance_id) as rejected,merg_cs_id from grievances g ,category3_mst c  where g.cat3_id=c.cs_id and
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by merg_cs_id"; 
        
                        $app_type_id=2;
        	            $disposal_status = 5;
        	            $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $grievance_status_id = 10;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 8";
            		        }
    	                $rs=$query->get_result();
        
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['merg_cs_id']]['rejected']+=$row['rejected'];
        	$tot['rejected']+=$row['rejected'];
			}
			
			$query->close();
			
			// Pending for approval
			
			$sql="select count(grievance_id) as pendigforapproval,merg_cs_id from grievances g ,category3_mst c where g.cat3_id=c.cs_id and
        grievance_status_id IN(?)  and app_type_id=? and cat3_id != ? group by merg_cs_id"; 
        
      
                        $app_type_id=2;
        	            $disposal_status = 5;
        	            $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $grievance_status_id = 1;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 9";
            		        }
    	                $rs=$query->get_result();
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['merg_cs_id']]['pendigforapproval']+=$row['pendigforapproval'];
        	$tot['pendigforapproval']+=$row['pendigforapproval'];;
			}
			
        		 
			$query->close();
			
	 	   $sql ="select * from ulbmst";
				
				       
			            $query=$conn->prepare($sql);
        	           
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 10";
            		        }
    	                $rs=$query->get_result();
				
				
				
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				$query->close();
				    
	        $sql ="select section_id,cs_desc,cs_id from standard_services";
	        $query=$conn->prepare($sql);
        	           
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 10";
            		        }
    	                $rs=$query->get_result();
				
				
				
				while($row = $rs->fetch_assoc())
    		{
    			$cs_list[$row['cs_id']]=$row['cs_desc'];
    				    $total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla'];
    				    $data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
    		}
    		
    		
    		$query->close();
    		
    		$cs_list[0]="Others";
    		
    	//	print_r($cs_list);
    		
    				$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    				
    				
    				
    			$sql ="select cat_id,description from category_mst";
			$query=$conn->prepare($sql);
        	           
        
                         if(!$query->execute())
            		        {
            		            echo "Query not executed 10";
            		        }
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
											
											<td rowspan="2">Service </td>
											
											<td rowspan="2">Received</td>
											<td rowspan="2">Pending for approval</td>
											
											<td colspan="2" align="center">Resolved</td>
											<td colspan="2" align="center">Pending</td>
											
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
									   
									    <?php $i=1; foreach($cs_list as $section_id=>$value){?>
									    <tr>
									        <td><?php echo $i; ?></td>
									        <td><?php echo $cs_list[$section_id]; ?></td>
									       
									        <td><?php echo $data[$section_id]['total_received']; ?></td>
									        <td><?php echo $data[$section_id]['pendigforapproval']; ?> </td>
									        
									        
									        <td><?php echo $data[$section_id]['resolved_within_sla']; ?> </td>
									        <td><?php echo $data[$section_id]['resolved_beyond_sla']; ?> </td>
									        
									        <td><?php echo $data[$section_id]['pending_within_sla']; ?> </td>
									        <td><?php echo $data[$section_id]['pending_beyond_sla']; ?> </td>
									        
									        
									        <td><?php echo $data[$section_id]['rejected']; ?></td>
									        <td><?php echo $data[$section_id]['unresolved']; ?> </td>
									        <td><?php echo $data[$section_id]['percent']; ?></td>
									    </tr>
									    <?php $i++;} ?>
									</tbody>
									<tfoot>
									    
									     <tr>
									        <td colspan="2">Total</td>
									       
									        <td><?php echo $tot['total_received']; ?> </td>
									        <td> <?php echo $tot['pendigforapproval']; ?> </td>
									        
									        <td><?php echo $tot['resolved_within_sla']; ?> </td>
									        <td><?php echo $tot['resolved_beyond_sla']; ?> </td>
									        
									        <td><?php echo $tot['pending_within_sla']; ?> </td>
									        <td><?php echo $tot['pending_beyond_sla']; ?> </td>
									        
									        
									        <td><?php echo $tot['rejected']; ?> </td>
									        <td><?php echo $tot['unresolved']; ?> </td>
									        <td><?php echo $tot['percent']; ?> </td>
									    </tr>
									    
									</tfoot>
			</table>