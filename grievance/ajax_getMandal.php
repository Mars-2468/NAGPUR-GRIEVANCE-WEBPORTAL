<?php
require "config.php";
	if(isset($_POST['distid']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['distid'])) // id
           {
               die('Invalid data passed');
           }

	       $sql ="select villageid,village_desc from village_mst v,Districtmst d,ulbmst u where v.ulbid=u.ulbid and u.distid=d.distid and d.distid=?";
		   $ward_id = htmlspecialchars(strip_tags($_REQUEST['distid']));
		   $query=$conn->prepare($sql);
		   $query->bind_param("i",$ward_id);
		   $query->execute();
		   $rs=$query->get_result();
		   
		   
	      
	       ?>
	       <option value="0">---Select----</option>
	       <?php
	       
	      
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['villageid']; ?>"><?php echo $row['village_desc']; ?></option>
		       <?php
		       }
		       ?>
		       
		       <?php
		
		
		$query->close();
		
	}
?>