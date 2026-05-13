<?php
require "config.php";
	if(isset($_POST['mandalId']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['mandalId'])) // id
           {
               die('Invalid data passed');
           }

	       $sql ="select villageid,village_desc from Districtmst d,ulbmst u, village_mst v where v.ulbid=u.ulbid and u.distid=d.distid and v.ulbid=?";
		   $ward_id = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
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