<?php
require "config.php";
ini_set('display_errors',0);
date_default_timezone_set('Asia/Calcutta');

	if(isset($_REQUEST['cat_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		
		if($_REQUEST['user_type']=='A')
		{
		
		$sql ="select COUNT(grievance_id) as count ,app_type_id from grievances where grievance_status_id=?  group by app_type_id";
		$status_id = 13;
		$query=$conn->prepare($sql);
	    	$query->bind_param("i",$status_id);
		}
		else if($_REQUEST['user_type']=='U')
		{
		    $sql ="select COUNT(grievance_id) as count ,app_type_id from grievances where grievance_status_id=? and ulbid =? group by app_type_id";
			$status_id = 13;
			$ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
			
			$query=$conn->prepare($sql);
	       $query->bind_param("is",$status_id,$ulbid);
		}
		
		$query->execute();
	    	$rs=$query->get_result();
			  
		
		while($row = $rs->fetch_assoc())
		{
		    $data[$row['app_type_id']]['count']=$row['count'];
		}
		
		if($data[1]['count'] =='')
		{
		    $data[1]['count']=0;
		}
		if($data[2]['count'] =='')
		{
		    $data[2]['count']=0;
		}
		
		
		
	}
	$query->close();
?>


<table class="table table-bordered" style="background-color:#FFF;">
    <thead>
        <tr>
        <th>Total number of complaints reopened</th>
        <th>Total number of services reopened</th>
        </tr>
    </thead>
    <tbody>
        <tr>
           
                <?php if($_REQUEST['user_type']=='A'){?>
                
                 <td><a href="ulbwise_reopened_rep.php?app_type_id=1&status=13"><?php echo $data[1]['count']; ?></a></td>
                 <td><a href="ulbwise_reopened_rep.php?app_type_id=2&status=12"><?php echo $data[2]['count']; ?></a></td>
                 
                 <?php }else if($_REQUEST['user_type']=='U'){?>
                 
                 
                 <td><a href="deptwise_reopened.php?ulbid=<?php echo $_REQUEST['ulbid']; ?>&app_type_id=1&status=13"><?php echo $data[1]['count']; ?></a></td>
                 <td><a href="deptwise_reopened.php?ulbid=<?php echo $_REQUEST['ulbid']; ?>&app_type_id=2&status=12"><?php echo $data[2]['count']; ?></a></td>
                 
                 <?php }?>
        </tr>
    </tbody>
</table>