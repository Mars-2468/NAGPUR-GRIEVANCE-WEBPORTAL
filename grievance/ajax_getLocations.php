<?php
require "config.php";
	if(isset($_POST['ward_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['ward_id'])) // id
   {
       die('Invalid data passed to Department');
   }

	       $sql ="select id,loc_of_gvp from zone_ward_loc_mst where zone_id=?";
		   $ward_id = htmlspecialchars(strip_tags($_REQUEST['ward_id']));
		   $query=$conn->prepare($sql);
		   $query->bind_param("i",$ward_id);
		   $query->execute();
		   $rs=$query->get_result();
		   
		   
	      
	       ?>
	       <option value="">---Select----</option>
	       <?php
	       
	      
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['id']; ?>"><?php echo $row['loc_of_gvp']; ?></option>
		       <?php
		       }
		       ?>
		       <!--<option value="100000">Others</option>-->
		       <?php
		
		
		$query->close();
		
	}
?>