<?php
require "config.php";
	if(isset($_REQUEST['rdmaid']))
	{
		
	
        require_once('prepare_connection.php');
        
	      
	      
	       $sql=$conn->prepare("SELECT * FROM Districtmst WHERE rdma=?");
		   $rdma=htmlspecialchars(strip_tags($_REQUEST['rdmaid']));
		   $sql->bind_param("s",$rdma);
		   $sql->execute();
		   $rs=$sql->get_result();
	
		
	       ?>
	       <option value="">---Select----</option>
	       <?php
	       
	       if($rs->num_rows > 0)
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
		
	$conn->close();
	}
?>