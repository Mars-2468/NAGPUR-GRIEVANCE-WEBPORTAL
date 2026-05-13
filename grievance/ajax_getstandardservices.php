<?php
require "config.php";
	if(isset($_SESSION['ulbid']))
	{
		
		require_once('connection.php');
		$conn=getconnection();

 if (!preg_match("/^[0-9]+$/", $_REQUEST['dept_id'])) // id
   {
       die('Invalid data passed to Department');
   }
   
	       $sql ="select cs_id,cs_desc from standard_services where section_id=?";
		   $section_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
		   $query=$conn->prepare($sql);
		   $query->bind_param("i",$section_id);
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
		       <option value="<?php echo $row['cs_id']; ?>"><?php echo $row['cs_desc']; ?></option>
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