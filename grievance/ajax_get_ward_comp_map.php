<?php
require "config.php";
ini_set('display_errors',0);
	if(isset($_REQUEST['cs_id']))
	{

		require_once('connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['cs_id'])) // id
            {
                die('Invalid data passed to Department');
            }
        
		$sql =$conn->prepare("select * from ward_mst where ulbid=? and ward_id NOT IN(select ward_id from emp_map where cs_id=? and ulbid=?) order by ward_id");
		 $ulbid =htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $cs_id =strip_tags($_REQUEST['cs_id']);
		$sql->bind_param("sis",$ulbid,$cs_id,$ulbid);
		
			        $sql->execute();
	               $rs=$sql->get_result();
			       while($row = $rs->fetch_assoc())
			       {
			        $ward_list[$row['ward_id']]=$row['ward_desc'];
			       }
			       
			       
			        $sql =$conn->prepare("select * from ward_mst where ulbid=? and ward_id IN(select ward_id from emp_map where cs_id=? and ulbid=?) order by ward_id");
            		$ulbid =htmlspecialchars(strip_tags($_SESSION['ulbid']));
            		$cs_id =htmlspecialchars(strip_tags($_REQUEST['cs_id']));
            		$sql->bind_param("sis",$ulbid,$cs_id,$ulbid);
            		$sql->execute();
	                $rs=$sql->get_result();
			      
			       while($row = $rs->fetch_assoc())
			       {
			       $ward_list2[$row['ward_id']]=$row['ward_desc'];
			       }
			       
			       
			        $sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where ulbid=?");
            		$ulbid =htmlspecialchars(strip_tags($_SESSION['ulbid']));
            		
            		$sql->bind_param("s",$ulbid);
            		$sql->execute();
	                $rs=$sql->get_result();
			       
				       while($row = $rs->fetch_assoc())
				       {
				       $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
				       }
				       
				       $sql =$conn->prepare("select * from dept_mst where ulbid=? order by dept_id");
            		   $ulbid =htmlspecialchars(strip_tags($_SESSION['ulbid']));
            		
            		   $sql->bind_param("s",$ulbid);
            		   $sql->execute();
	                   $rs=$sql->get_result();
			       
	       while($row = $rs->fetch_assoc())
	       {
	       $dept_list[$row['dept_id']]=$row['dept_desc'];
	       }
			   
		             $sql =$conn->prepare("select * from emp_map where ulbid=? and flag=? and cs_type_id=? and cs_id=?");
            		   $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
            		   $flag=1; $cs_type_id=1;
            		   $cs_id= $_REQUEST['cs_id'];
            		   $sql->bind_param("siii",$ulbid,$flag,$cs_type_id,$cs_id);
            		   $sql->execute();
	                   $rs=$sql->get_result();	   
			       
	
		while($row = $rs->fetch_assoc())
		{
		$data[$row['ward_id']][$row['cs_id']]['emp_id']=$emp_list[$row['emp_id']];
		$data[$row['ward_id']][$row['cs_id']]['emp_id2']=$emp_list[$row['emp_id2']];
		$data[$row['ward_id']][$row['cs_id']]['dept_id']=$dept_list[$row['dept_id']];
		}	       

	       
	    $conn->close();   
	      
	}
?>
	<br><br>
	<table class="table-bordered table-striped table-condensed cf" width="100%">
		<thead>
			<tr style="background-color:#2c3e50; color:#FFF;">
				<th>Ward</th>
				<th>Department</th>
				<th>Assigned Employee</th>
				<th>Responsible Officer</th>
				
			</tr>
		</thead>
		<?php foreach($ward_list2 as $ward_id2=>$ward_desc2){?>
			<tr>
				<th><?php echo $ward_desc2; ?></th>
				<th><?php echo $data[$ward_id2][$_REQUEST['cs_id']]['dept_id']; ?></th>
				<th><?php echo $data[$ward_id2][$_REQUEST['cs_id']]['emp_id']; ?></th>
				<th><?php echo $data[$ward_id2][$_REQUEST['cs_id']]['emp_id2']; ?></th>
				
			</tr>
		<?php }?>
	
	</table>


	<input type="hidden" name="dept_id_sel" value="<?php echo strip_tags($_REQUEST['dept_id']) ?>">
	<input type="hidden" name="emp_id_sel" value="<?php echo strip_tags($_REQUEST['emp_id']) ?>">
	<input type="hidden" name="cs_id_sel" value="<?php echo strip_tags($_REQUEST['cs_id']) ?>">
	<input type="hidden" name="emp_id2_sel" value="<?php echo strip_tags($_REQUEST['emp_id2']) ?>">
	<table class="table-bordered table-striped table-condensed cf" width="100%">
	<thead>
		<tr style="background-color:#2c3e50; color:#FFF;">
		<th>Ward</th>
		<th>select Check All <input type="checkbox" id="checkAll" onClick="fun1()"/></th>
		</tr>
	</thead>
	
	<?php
	$i=0;
	foreach($ward_list as $ward_id=>$ward_desc)
	{
	?>
	
	
	
	<tr>
	
	<td>
	
	
	<?php echo $ward_desc; ?></td><td><input type="checkbox" name="ward_id<?php echo $i;?>" value="<?php echo $ward_id; ?>">
	
	
	
	</td>
	
	</tr>
	<?php
	$i++;
	}
	?>
	
	<input type="hidden" name="file_count" value="<?php echo $i;?>">
	<tr>
    <td colspan="3">
	
			<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
						<button type="submit" class="btn btn-info" name='save'>Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>
					</div>		
					</td>
                
                    
                    </tr>
					
	
			</table>	
	