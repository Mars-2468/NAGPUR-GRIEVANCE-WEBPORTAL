<?php
require "config.php";
		
		require_once('connection.php');
		$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
	
	            $sql ="select cat_id,description,telugu_description from category_mst where is_mepma in(0,1)";
		
	            $rs = mysqli_query($conn,$sql);
	            
	       
	       ?>
	       <option value="0">---Select----</option>
	       <?php
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
		       while($row = mysqli_fetch_assoc($rs))
		       {
		       ?>
		       <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['description']; ?> (<?php echo $row['telugu_description']; ?>)</option>
		       <?php
		       }
		}
		else
		{
			echo "<option value='0'>---Select----</option>";
		}
		
		mysqli_close($conn);
	
?>