<?phprequire "config.php";
	if(isset($_POST['cs_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

			    $dates = array();
			    $current = strtotime($first);
			    $last = strtotime($last);
			
			    while( $current <= $last ) {
			
			        $dates[] = date($output_format, $current);
			        $current = strtotime($step, $current);
			    }
			
			    return $dates;
			}
		$sql ="select * from doc_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		$nr =mysqli_num_rows($rs);
		while($row = mysqli_fetch_assoc($rs))
		{
		$doc_list[$row['doc_id']]=$row['doc_desc'];
		}
		$sql ="select * from emp_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$emp_list[$row['emp_id']]=$row['emp_name'];
		}
		
		
		/****************** getting holidays **********************/
		
		$sql ="select date from public_holydays where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$holiday_list[$row['date']]=$row['date'];
		}
		$hdays=0;
		
		/********************************************************/
		if($_REQUEST['app_type_id']=='2')
		{
		
		$sql ="select cutt_of_time from category3_mst where cs_id='".$_REQUEST['cs_id']."' and cs_type_id='".$_REQUEST['app_type_id']."'";
		$rs= mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		echo $cuttofdate=$row['cutt_of_time'];
		}
		
		$sql ="select e.emp_id,e.emp_id2,c.cutt_of_time,c.app_fee,c.fine_per_day,fee_desc,fee_type_id from emp_map e,category3_mst c where e.cs_id=c.cs_id and e.cs_id='".$_REQUEST['cs_id']."' and e.cs_type_id='".$_REQUEST['app_type_id']."' and e.ward_id='".$_REQUEST['ward_id']."'";
		$rs = mysqli_query($conn,$sql);
		$nr= mysqli_num_rows($rs);
		
		$emp_det=mysqli_fetch_assoc($rs);
		
		
		
		
		$date=date('Y-m-d');
		$date = strtotime("+".$cuttofdate." days", strtotime($date));
		$date=date("d-m-Y", $date);
		$dates_range=date_range(date('Y-m-d'),$date);
		foreach($dates_range as $key=>$date)
		{
			if(in_array($date,$holiday_list))
			{
				$hdays++;
			}
		}
		
		foreach($dates_range as $key=>$val)
			{
			
				// Finding sunday
				
				if(date("D", strtotime($val)) == "Sun")
				{
				$s++;
				$hdays++;
				}
				$months[date('Y-m',strtotime($val))]=date('Y-m',strtotime($val));
				

			}
			
			foreach($months as $key=>$val)
			{
				// Finding second saturdays
				
				$yrdata= strtotime($val);
    				 $month=date('M', $yrdata);
    				 $year=date('Y', $yrdata);
    				 $text=$month." ".$year." second saturday";
				// $second_saturdays[]=date('Y-m-d', strtotime($text));
				$second_saturdays[]=date('Y-m-d', strtotime("second saturday of ".$month." ".$year));
			}
			
			foreach($second_saturdays as $key=>$second_saturday)
						{
							
							if(in_array($second_saturday,$dates_range ))
							{
								
							$hdays++;
							}
							
							
						}
			foreach($holiday_list as $key=>$holiday_list)
						{
							
							if(in_array($holiday_list,$dates_range ))
							{
								
							$hdays++;
							}
							
							
						}
		
	
		
		$date = strtotime("+".$hdays." days", strtotime($date));
		$date=date("d-m-Y", $date);
		if($_SESSION['ulbid']=='207')
		{
		
			if($_REQUEST['ward_id']=='366' OR $_REQUEST['ward_id']=='369' OR $_REQUEST['ward_id']=='370')
			{
				if($_REQUEST['dept_id']=='83')
				{
				$prefix='A1';
				}
				else
				{
				$sql ="select prefix from dept_mst where ulbid='".$_SESSION['ulbid']."' and dept_id='".$_REQUEST['dept_id']."'";
				$rs = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($rs);
				$prefix=$row['prefix'];
				}
			}
			else if($_REQUEST['ward_id']=='367' OR $_REQUEST['ward_id']=='368')
			{
				if($_REQUEST['dept_id']=='83')
				{
				$prefix='A2';
				}
				else
				{
				$sql ="select prefix from dept_mst where ulbid='".$_SESSION['ulbid']."' and dept_id='".$_REQUEST['dept_id']."'";
				$rs = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($rs);
				$prefix=$row['prefix'];
				}
			}
			
			?>
			
			
		        <div class="form-group">
					<label>File Number</label>
					<input type="hidden"  name="prefix" value="<?php echo $prefix; ?>">
					<?php echo $prefix; ?><input type="text"name="file_no" required>/<?php echo date('Y');?>
			</div>
			
		        <?php
		        
			
		}
		
		
	        $sql ="select cs_id,doc_id,mandatory_status from cs_doc_map where cs_id='".$_REQUEST['cs_id']."'";
	       $rs = mysqli_query($conn,$sql);
	       if($nr > 0)
	       {
	       ?>
	       <table class="table table-striped table-bordered table-hover">
	       <thead>
	       	<tr style="background-color:#2c3e50; color:#FFF;">
	       		<th>Assigned Employee</th>
	       		<th>Responsible officer</th>
	       		<th>Application Fees</th>
	       		<th>Cut off date</th>
	       		<th>Fine Per Day</th>
	       		
	       	</tr>
	       </thead>
	       <body>
	       <tr>
	       <td><?php echo $emp_list[$emp_det['emp_id']]?></td>
	       <td><?php echo $emp_list[$emp_det['emp_id2']]?></td>
	       <td>
	           <?php 
	           if($emp_det['fee_type_id']==1)
	           {
	           echo $emp_det['app_fee'];
	           }
	           if($emp_det['fee_type_id']==2)
	           {
	           echo $emp_det['fee_desc'];
	           }
	           ?>
	           
	           </td>
	       <td><?php echo $date ?></td>
	       <td><?php echo $emp_det['fine_per_day']?></td>
	       </tr>
	       </body>
	       </table>
	       <?php
	       }
	       ?>
	       <table class="table table-striped table-bordered table-hover" id="sample_3">
	       <thead>
	       	<tr style="background-color:#2c3e50; color:#FFF;">
	       		<th>Sno</th>
	       		<th>Document</th>
	       		<th>Doument Number</th>
	       		
	       	</tr>
	       </thead>
	       <?php
	       $i=1;
	       if(mysqli_num_rows($rs) > 0)
	       {
		       while($row = mysqli_fetch_assoc($rs))
		       {
		       ?>
		       <tr>
		       	<td><?php echo $i; ?></td>
		        <td>
		        <?php echo $doc_list[$row['doc_id']]?>
		        <input type="hidden" name="doc_id<?php echo $i; ?>" value="<?php echo $row['doc_id'];?>" >
		        </td>
		        <td>
		        <?php if($_SESSION['ulbid']==207){?>
		        <input type="checkbox" name="doc_id_check<?php echo $i; ?>" value="1">
		        <?php }else{?>
		        <input type="text" name="doc_number<?php echo $i; ?>" class="<?php echo $row['mandatory_status'];?>">
		        
		        <?php }?>
		        
		        </td>
		       </tr>
		       <?php
		       $i++;
		       }
		       
		}
		else
		{
			echo "<tr><td colspan='3'>Documents not mapped</td></tr>";
		}
		?>
		</table> 
		<input type="hidden" name="file_count" value="<?php echo $i; ?>">
		<input type="hidden" name="cut_off_time" value="<?php echo $date; ?>">
		<input type="hidden" name="holidays" value="<?php echo $hdays; ?>">
		<?php
		
		
		
	mysqli_close($conn);	
		
	}
?>