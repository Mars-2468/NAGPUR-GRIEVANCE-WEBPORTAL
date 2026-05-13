<?php
require "config.php";
	if(isset($_REQUEST['distid']))
	{
		include('prepare_connection.php');
		
	       $sql ="SELECT * FROM  `ulbmst` WHERE  `distid` LIKE ?";
		   $dist_id = htmlspecialchars(strip_tags($_REQUEST['distid']));
		   $query=$conn->prepare($sql);
		   $query->bind_param("s",$dist_id);
		   $query->execute();
		   $rs=$query->get_result();
			
	       ?>
	       <option value="0">---Select----</option>
	       <?php
	       
	       if($rs->num_rows > 0)
	       {
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['ulbid']; ?>"><?php echo $row['ulbname']; ?></option>
		       <?php
		       }
		}
		else
		{
			echo "<option value=''>---Select----</option>";
		}
		
		$query->close();
	}
?>