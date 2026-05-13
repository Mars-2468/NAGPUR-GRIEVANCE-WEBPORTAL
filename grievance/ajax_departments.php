<?php
require "config.php";
	if(isset($_SESSION['ulbid']))
	{
		
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();

	       
	       
	       $sql ="select dept_id,dept_desc from dept_mst where ulbid=?";
	       $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
	       $query=$conn->prepare($sql);
	       $query->bind_param("s",$ulbid);
	       $query->execute();
	       $rs=$query->get_result();
	       
	       ?>
	       <option value="0">--- Select Department ----</option>
	       <?php
	       
	       if($rs->num_rows > 0)
	       {
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_desc']; ?></option>
		       <?php
		       }
		}
		else
		{
			echo "<option value='0'>--- Select Department ----</option>";
		}
		
	
		$conn->close();
	}
?>