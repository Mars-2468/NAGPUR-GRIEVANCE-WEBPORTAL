<?php	
require "config.php";
	
	//var_dump($_SESSION);die();

 	if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
			echo "<p>Error: You must be logged in to access this page.</p>";
		exit;
	} 
	
	ini_set('display_errors',0);
		
	if(isset($_REQUEST['cat_id'])){
		
		require_once('connection.php');
		$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
			
		$sql ="select c.cs_id,c.cs_desc as comp_desc,telugu_description from cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid=? and cu.flag='1' and c.sub_cat_id=? order by comp_desc asc";

		$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$catid=htmlspecialchars(strip_tags($_REQUEST['cat_id']));

		$query=$conn->prepare($sql);
		
		$query->bind_param("si",$ulbid,$catid);
		$query->execute();
		
		//var_dump($query);die();
		
		
		$rs=$query->get_result();		   
				
 		//print_r($rs);exit;
		
		//$rs = mysqli_query($conn,$sql);
		
	       ?>
	       <option value="">---Select----</option>
	       <?php
	       
			if(mysqli_num_rows($rs) > 0){
				   while($row = mysqli_fetch_assoc($rs))
				   {
				   ?>
				   <option value="<?php echo $row['cs_id']; ?>"><?php echo ucfirst(strtolower($row['comp_desc'])); ?> (<?php echo $row['telugu_description']?>)</option>
				   <?php
				   }
			}else{
				echo "<option value='0'>---Select----</option>";
			}
			mysqli_close($conn);	
	}
?>