<?php
require "config.php";
    ini_set('display_errors',0);
	
	if(isset($_REQUEST['dept_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
		$ulbid = $_SESSION['ulbid'];
		if($_REQUEST['code']==1)
		{
		
		
		$sql ="select * from emp_map where ulbid=? and dept_id=? and cs_type_id=?";
		
		
		
		$dept_id = $_REQUEST['dept_id'];
		$cs_type_id = $_REQUEST['app_type_id'];
		
		
		        $query1 = $conn->prepare($sql);
		        $query1->bind_param("sii",$ulbid,$dept_id,$cs_type_id);
		        $query1->execute();
	            $rs=$query1->get_result();
				
				
				$nr =$rs->num_rows();
				if($nr > 0)
				{
					$sql ="select e.cs_id,c.cs_desc as comp_desc from emp_map e, cs_mst c,complaint_ulbmap cu where e.cs_id=c.cs_id and c.cs_id=cu.cs_id and cu.ulbid=? and cu.flag=? and e.dept_id=? group by c.cs_id";
					
					
					
					$flag = 1;
					$dept_id = $_REQUEST['dept_id'];
					
					 $query1 = $conn->prepare($sql);
    		        $query1->bind_param("sii",$ulbid,$flag,$dept_id);
    		       
					
					
				}
				else
				{
				
				$sql ="select c.cs_id,c.cs_desc as comp_desc from  cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid=? and cu.flag=? group by c.cs_id";
				
				
					$flag = 1;
					
					
					$query1 = $conn->prepare($sql);
    		        $query1->bind_param("si",$ulbid,$flag);
				
				}
		
		
		
		
		
		
		
		}
		else
		{
			if($_REQUEST['app_type_id']=='1')
			{
			    
			     $dept_id = $_REQUEST['dept_id'];

	       $sql = "select sc.sub_cat_id,sc.description,sc.description_marathi from subcategory_mst sc where cat_id=".$dept_id." order by description ASC";
	       
	      
	      
	       // $cs_type_id = $_REQUEST['app_type_id'];
	       // $sp_id =1;
	       // $disable_status_yn=1;
	       $query1 = $conn->prepare($sql);
    	   // $query1->bind_param("isiii",$dept_id,$ulbid,$cs_type_id,$sp_id,$disable_status_yn);
	       
	      
	       }
	       
	       
	       $query1->execute();
	       
	       $rs=$query1->get_result();
	       ?>
	       <option value="">---Select----</option>
	       <?php
	      // echo $sql;
	       
	      
		       while($row = $rs->fetch_assoc())
		       {
		         
		       ?>
		       <option value="<?php echo $row['sub_cat_id']; ?>"><?php echo ucwords(strtolower($row['description'].'/'.$row['description_marathi'])); ?></option>
		       <?php
		       }
	
		
	}	
		$conn->close();
		
		
	}
?>