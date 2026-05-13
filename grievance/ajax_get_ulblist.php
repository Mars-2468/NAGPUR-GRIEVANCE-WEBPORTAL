<?php
require "config.php";
		if(isset($_REQUEST['distid']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		$sql ="select ulbid,ulbname from ulbmst where distid=?";
		$distid = htmlspecialchars(strip_tags($_REQUEST['distid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$distid);
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
		       <option value="<?php echo $row['ulbid']; ?>"><?php echo $row['ulbname']; ?></option>
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