<?php
require "config.php";
	if(isset($_REQUEST['distid']))
	{
		
	
        include('prepare_connection.php');
	      
	    $sql ="SELECT * FROM ulbmst WHERE distid=?";
        $distid=htmlspecialchars(strip_tags($_REQUEST['distid']));
        $query=$conn->prepare($sql);
        $query->bind_param("s",$distid);
        $query->execute();
	    $rs=$query->get_result();
	       
	       
	       ?>
	       <option value="">---Select----</option>
	       <?php
	       
	       
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['ulbid']; ?>"><?php echo $row['ulbname']; ?></option>
		       <?php
		       }
		
	
		
		$query->close();
	}
?>