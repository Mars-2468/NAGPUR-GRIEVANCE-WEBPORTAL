<?php
require "config.php";
	ini_set('display_errors',0);
	
	if(isset($_REQUEST['rdmaid']))
	{
		
		require_once('connection.php');
		$conn=getconnection();

	       $sql ="SELECT * FROM  `Districtmst` WHERE  `rdma` = ?";
		   $rdma = htmlspecialchars(strip_tags($_REQUEST['rdmaid']));
		   $query=$conn->prepare($sql);
		   $query->bind_param("s",$rdma);
		   $query->execute();
		   $rs=$query->get_result();
	      
	       
	       ?>
	       <option value="0">---Select----</option>
	       <?php
	       
	       if($query->num_rows > 0)
	       {
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['distid']; ?>"><?php echo $row['distname']; ?></option>
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