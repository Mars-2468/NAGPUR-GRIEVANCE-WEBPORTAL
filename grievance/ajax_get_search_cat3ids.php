<?php
require "config.php";
	ini_set('display_errors',0);
	
	if(isset($_POST['app_type_id']))
	{
		$list1="";
	
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		
		
		if($_POST['app_type_id']=='1')
		{
		    $sql ="select cs_id,cs_desc as comp_desc,m.description from cs_mst cm,grievances g,category_mst m where g.cat3_id=cm.cs_id and cm.cat_id=m.cat_id and g.app_type_id=? and g.ulbid=? group by g.cat3_id";
			
			
		}
		else
		{
		    $sql ="select cs_id,cm.comp_desc from category3_mst cm,grievances g where g.cat3_id=cm.cs_id and g.app_type_id=? and g.ulbid=? group by g.cat3_id";
		}
		
		    $app_type_id = $_POST['app_type_id'];
			$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			
		   $query=$conn->prepare($sql);
		   $query->bind_param("is",$app_type_id,$ulbid);
		   $query->execute();
		   $rs=$query->get_result();

	       
	       
	       
	      $list1.=" <option value=''>---Select----</option>";
	      $string="";
	       
	       if($rs->num_rows > 0)
	       {
		       while($row = $rs->fetch_assoc())
		       {
		           
		           if($row['description'] !='')
		           {
		               $string="(".$row['description'].")";
		           }
		           else
		           {
		               $string=$row['description']='';
		           }
		      
		      $list1.=" <option value=".$row['cs_id'].">". $row['comp_desc'].$string."</option>";
		      
		       }
		}
		
		
	
		
		echo $list1;
		
	$query->close();	
	}
?>