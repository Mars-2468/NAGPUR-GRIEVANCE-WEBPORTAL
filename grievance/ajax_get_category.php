<?php
require "config.php";
	if(isset($_REQUEST['ulbid']))
	{
		
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		$ulbid=htmlspecialchars(strip_tags($_REQUEST['id']));

	       $sql ="select cat.cat_id,description from category_mst cat,complaint_ulbmap cu,cs_mst cm 
	       where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag=? and cu.ulbid=? group by cat_id";
		   $flag = 1;
		   
		   
		   $query=$conn->prepare($sql);
		   $query->bind_param("is",$flag,$ulbid);
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