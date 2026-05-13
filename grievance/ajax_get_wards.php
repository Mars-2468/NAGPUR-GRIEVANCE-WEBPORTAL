<?php
require "config.php";
		if(isset($_REQUEST['ulbid']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		$sql ="select ward_id,ward_desc from ward_mst where ulbid=?";
		$ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
	
	       
	       if($rs)
		       {
		       echo 1;
		       }
		       else
		       {
		       echo 0;
		       }
	      
	       ?>
	       <option value="0">---Select----</option>
	       <?php
	       
	       if($rs->num_rows > 0)
	       {
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['ward_id']; ?>"><?php echo $row['ward_desc']; ?></option>
		       <?php
		       }
		       
		}
		else
		{
			echo "<option value='0'>---Select----</option>";
		}
		
		$query->close();
	
		
	}
?>