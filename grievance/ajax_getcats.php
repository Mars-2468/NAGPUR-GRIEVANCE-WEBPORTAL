<?php
require "config.php";
	if(isset($_POST['dept_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['dept_id'])) // id
   {
       die('Invalid data passed to Department');
   }

	       $sql ="select cat_id,description from category_mst where dept_id=?";
		   $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
		   $query=$conn->prepare($sql);
		   $query->bind_param("i",$dept_id);
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
		       <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['description']; ?></option>
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