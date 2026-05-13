<?php
require "config.php";
ini_set('display_errors',0);

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
		
	/*	$sql ="select date from public_holydays where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$holiday_list[$row['date']]=$row['date'];
		}
		$hdays=0;*/
		
		/********************************************************/
		if($_REQUEST['app_type_id']=='2')
		{
		
		$sql ="select cutt_off_time from standard_services where cs_id='".$_REQUEST['cs_id']."'";
		$rs= mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		$cuttofdate=$row['cutt_off_time'];
		}
		
		/*$sql ="select e.emp_id,e.emp_id2,c.cutt_of_time,c.app_fee,c.fine_per_day,fee_desc,fee_type_id from emp_map e,category3_mst c where e.cs_id=c.cs_id and e.cs_id='".$_REQUEST['cs_id']."' and e.cs_type_id='".$_REQUEST['app_type_id']."' and e.ward_id='".$_REQUEST['ward_id']."'";
		$rs = mysqli_query($conn,$sql);
		$nr= mysqli_num_rows($rs);
		
		$emp_det=mysqli_fetch_assoc($rs);*/
		
		
		
		
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
	/*	if($_SESSION['ulbid']=='207')
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
		        
			
		}*/
		
		
	        $sql ="select cm.cs_id,doc_id,mandatory_status from service_doc_map cdm,category3_mst cm where cm.cs_id=cdm.cs_id and cm.merg_cs_id='".$_REQUEST['cs_id']."' and cm.ulbid='".$_SESSION['ulbid']."'";
	       $rs = mysqli_query($conn,$sql);
	       
	       while($row = mysqli_fetch_assoc($rs))
		       {
		           $documents[$row['doc_id']]=$row['doc_id'];
		           $mandatory_status[$row['doc_id']]['mytext']=$row['mandatory_status'];
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
	       if(count($documents) > 0)
	       {
		       foreach($documents as $key=>$val)
		       {
		       ?>
		       <tr>
		       	<td><?php echo $i; ?></td>
		        <td>
		        <?php echo $doc_list[$key]?>
		        <input type="hidden" name="doc_id<?php echo $i; ?>" value="<?php echo $key;?>" >
		        </td>
		        <td>
		        <?php if($_SESSION['ulbid']==207){?>
		        <input type="checkbox" name="doc_id_check<?php echo $i; ?>" value="1">
		        <?php }else{?>
		        <input type="text" name="doc_number<?php echo $i; ?>" class="<?php echo $mandatory_status[$key]['mytext'];?>">
		        
		        <?php }?>
		        
		        </td>
		       </tr>
		       <?php
		       $i++;
		       }
		       
		}
		else
		{
			echo "<tr><td colspan='3'>Documents not mapped</td>";
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