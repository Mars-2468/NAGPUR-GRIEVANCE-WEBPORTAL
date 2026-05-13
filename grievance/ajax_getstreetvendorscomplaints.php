<?php
require "config.php";
ini_set('display_errors',0);
	if(isset($_REQUEST['cat_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
				
				$sql ="select c.cs_id,c.cs_desc as comp_desc,telugu_description from  cs_mst c  where c.cat_id='".$_REQUEST['cat_id']."' and is_mepma='1'";
				
				
		
		
	$rs = mysqli_query($conn,$sql);
	       ?>
	       <option value="0">---Select----</option>
	       <?php
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
		       while($row = mysqli_fetch_assoc($rs))
		       {
		       ?>
		       <option value="<?php echo $row['cs_id']; ?>"><?php echo $row['comp_desc']; ?> (<?php echo $row['telugu_description']; ?>)</option>
		       <?php
		       }
		}
		else
		{
			echo "<option value='0'>---Select----</option>";
		}
		
		
		
	mysqli_close($conn);	
		
	}
?>