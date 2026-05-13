<?php
require "config.php";
    ini_set('display_errors',0);


	if(isset($_POST['emp_id']))
	{
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		$status=0;
		
		if($_REQUEST['od_status']=='1'){
		    $sql ="select * from emp_mst_od where emp_id=?";
		                $query=$conn->prepare($sql);
		                $query->bind_param("i",htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
		}else{
		    $sql ="select * from emp_mst where emp_id=?";
		                $query=$conn->prepare($sql);
		                $query->bind_param("i",htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
		}
		                
                  	    
                    	$query->execute();
                    	$rs3= $query->get_result();
                    	while($row = $rs3->fetch_assoc())
                    	{
                    	   
							 if($_REQUEST['od_status']=='1')
								{
									$sql ="update emp_mst_od set delete_status='1',emp_mobile='".rand(1000,999999)."',mobile='".$row['emp_mobile']."' where emp_id='".$_REQUEST['emp_id']."'";
								   
									
								}   
								else
								{
									$sql ="update emp_mst set delete_status='1',emp_mobile='".rand(1000,999999)."',mobile='".$row['emp_mobile']."' where emp_id='".$_REQUEST['emp_id']."'";
								
								}
								//echo $sql;
								 if( mysqli_query($conn,$sql))
								 {
									 $status=1;
								 }
								 else
								 {
									$status=0;;
								 }
						}
	
		
		 /*$emp_id=preg_replace('/^[0-9]+$/', ' ',$_REQUEST['emp_id']); 
		  $emp_id=$_REQUEST['emp_id']; 
		 
		 
		 
        		    $sql =$conn->prepare("select * from emp_map where emp_id=? and ulbid=?");
            		$sql->bind_param("is",$emp_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
            	    //print_r($sql);
            	    $sql->execute();
            	    $rs=$sql->get_result();
            	    
		            $nr=$rs->num_rows;
		            if($nr > 0)
		            {
		                while($row = $rs->fetch_assoc())
		                {
		                  $sql ="insert into emp_map_delete(cs_id,
		        cs_type_id,
		        street_id,
		        ward_id,
		        emp_id,
		        emp_id2,
		        emp_id3,
		        emp_id4,
		        dept_id,
		        desg_id,
		        flag,
		        ulbid) values(?,?,?,?,?,?,?,?,?,?,?,?)";
                				    $query=$conn->prepare($sql);
                				    $query->bind_param("iiiiiiiiiiis",$row['cs_id'],$row['cs_type_id'],$row['street_id'],
                				    $row['ward_id'],$row['emp_id'],$row['emp_id2'],$row['emp_id3'],$row['emp_id4'],$row['dept_id'],
                				    $row['desg_id'],$row['flag'],htmlspecialchars(strip_tags($_SESSION['ulbid'])));   
                				    $query->execute();
		                }
		                
		                
		                $sql ="delete from emp_map where emp_id=?";
		                $query=$conn->prepare($sql);
		                $query->bind_param("i",htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
                        $query->execute();
                       
                        
		            }
		            
	
		
		          
		            
		            $sql2 =$conn->prepare("select emp_id from grievances_transactions where emp_id=? group by emp_id");
            		$sql2->bind_param("i",htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
            	    $sql2->execute();
            	    $rs2=$sql2->get_result();
		            $nr2=$rs2->num_rows;
		            
		            if($nr2 > 0)
		            {
		            if($_REQUEST['od_status']=='1')
		                {
		                
		                $sql =$conn->prepare("update emp_mst_od set delete_status=? where emp_id=?");
		                $delete_status= 1;
                        $sql->bind_param("ii",$delete_status,htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
                        $sql->execute();
                        
		                }
		                else
		                {
		                
		                $sql =$conn->prepare("update emp_mst set delete_status=? where emp_id=?");
		                $delete_status= 1;
                        $sql->bind_param("ii",$delete_status,htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
                        $sql->execute();
                        
		                }
		                if($sql->execute())
		                {
		                    $status=1;
		                }
		            
		           
		            }
		            
		            else
		            {
		                
                    		    
                    		    
                    		 if($_REQUEST['od_status']=='1')
		                {
		                    $sql ="select * from emp_mst_od where emp_id=?";
		                    $query=$conn->prepare($sql);
		                    $query->bind_param("i",htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
		                }   
                    		    
                    	else
		                {
		               
		                $sql ="select * from emp_mst where emp_id=?";
		                $query=$conn->prepare($sql);
		                $query->bind_param("i",htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
		                } 
                  	    
                    	$query->execute();
                    	$rs3= $query->get_result();
                    	while($row = $rs3->fetch_assoc())
                    	{
                    	    
                    	    
                    	    
                    	  $sql ="insert into emp_mst_delete(emp_id,
                    		            emp_name,
                    		            emp_dept,
                    		            emp_desg,
                    		            emp_mobile,
                    		            ulbid,
                    		            pincode,
                    		            mobile,
                    		            delete_status)values(
                    		                '".$emp_id."',
                    		                '".$row['emp_name']."',
                    		                '".$row['emp_dept']."',
                    		                '".$row['emp_desg']."',
                    		                '".$row['emp_mobile']."',
                    		                '".$_SESSION['ulbid']."',
                    		                '".$row['pincode']."',
                    		                '".$row['mobile']."',
                    		                '".$row['delete_status']."'
                    		                )";
                    		                
                    		                $q = mysqli_query($conn,$sql);
                    		                
                				   
                				    
                				    if($q)
                    		                {
                    		                    
                    		                    if($_REQUEST['od_status']=='1')
                    		                    {
                    		                        $sql ="update emp_mst_od set delete_status='1',emp_mobile='".rand(1000,999999)."',mobile='".$row['emp_mobile']."' where emp_id='".$emp_id."'";
                    		                       
                    		                        
                    		                    }   
                    		                    else
                    		                    {
                    		                        $sql ="update emp_mst set delete_status='1',emp_mobile='".rand(1000,999999)."',mobile='".$row['emp_mobile']."' where emp_id='".$emp_id."'";
		                                        
                    		                    }
                    		                    
                    		                     if( mysqli_query($conn,$sql))
                    		                     {
                    		                         $status=1;
                    		                     }
                    		                     else
                    		                     {
                    		                        
                    		                     }
                    		                     
                    		                }  
                				    
                				 
                				    
                    	}*/
                    		    
                    		    
		            
		
	      
	      
	  $conn->close(); 
	   
	   echo $status;
	       
	      
	}
?>