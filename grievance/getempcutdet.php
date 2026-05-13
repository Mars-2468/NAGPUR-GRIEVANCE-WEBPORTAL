<?php
require "config.php";
ini_set('display_errors',0);
date_default_timezone_set('Asia/Calcutta');

	if(isset($_REQUEST['cs_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		
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
		
		$sql ="select * from emp_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$emp_list[$row['emp_id']]=$row['emp_name'];
		}
		
		$sql ="select * from emp_mst_od where ulbid='".$_SESSION['ulbid']."'";
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
		
		if($_REQUEST['app_type_id']=='1')
		{
		$sql ="select e.emp_id,e.emp_id2,c.cutt_off_time as cutt_of_time from emp_map e,comp_cutofdays_map c where e.cs_id=c.cs_id and e.cs_id='".$_REQUEST['cs_id']."' and e.ward_id='".$_REQUEST['ward_id']."'";
		}
		else
		{
		
		 $sql ="select e.emp_id,e.emp_id2,c.cutt_of_time,c.app_fee,c.fine_per_day from emp_map e,category3_mst c where e.cs_id=c.cs_id and e.cs_id='".$_REQUEST['cs_id']."' and c.cs_type_id='".$_REQUEST['app_type_id']."' and e.ward_id='".$_REQUEST['ward_id']."'";
		}
		$rs = mysqli_query($conn,$sql);
		$nr= mysqli_num_rows($rs);
		
		if($nr <= 0)
		{
		    
		     $sql1 = "select cutt_off_time from comp_cutofdays_map where cs_id = '".$_REQUEST['cs_id']."'" ;
		    $rs1 = mysqli_query($conn,$sql1);
		     $row = mysqli_fetch_assoc($rs1);
			 $Date=date('Y-m-d H:i:s');
			 $cutoffdays = round($row['cutt_off_time'] * 24 * 60);
			 //$cutoffdate = date('Y-m-d H:i:s', strtotime($Date. ' + '.$cutoffdays.' minutes'));
			
		      //$date=date('Y-m-d');
		      //$date = strtotime("+".$cutoffdate." minutes", strtotime($date));
			  
		     $endTime = strtotime("+".$cutoffdays." minutes", strtotime(date('Y-m-d H:i:s')));
		    
		      $date = date ( 'Y-m-d H:i:s' , $endTime );
		    
		}
		else
		{
		
		$emp_det=mysqli_fetch_assoc($rs);
		$cutoffdays = round($emp_det['cutt_of_time'] * 24 * 60);
		$date=date('Y-m-d');
		$endTime = strtotime("+".$cutoffdays." minutes", strtotime(date('Y-m-d H:i:s')));
		
		 $date=date("d-m-Y H:i:s", $endTime);
		
		}
		
		//$dates_range=date_range(date('Y-m-d'),$date);
		
		/*foreach($dates_range as $key=>$date)
		{
			if(in_array($date,$holiday_list))
			{
				$hdays++;
			}
		}*/
		
		$s=0;
		
		/*foreach($dates_range as $key=>$val)
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
		$date=date("d-m-Y H:i:s", $date);*/
		
		
	         $sql ="select cs_id,doc_id from cs_doc_map where cs_id='".$_REQUEST['cs_id']."'";
	       $rs = mysqli_query($conn,$sql);
		   $nr =1;
	       if($nr > 0)
	       {
	       
	       ?>
	       
		
	        <table class="table table-striped table-bordered table-hover">
	       <thead>
	       	<tr>
	       		<th>Sundays</th><td><?php echo $s;?></td>
	       		
	       	</tr>
	       	</thead>
	       	</table>	
	       <table class="table table-striped table-bordered table-hover">
	       <thead>
	       	<tr>
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
	       <td><?php echo $emp_det['app_fee']?></td>
	       <td><?php echo $date ?></td>
	       <td><?php echo $emp_det['fine_per_day']?></td>
	       </tr>
	       </body>
	       </table>
	      
		
		<?php
		}
		?>
		
		<input type="hidden" name="cut_off_time" value="<?php echo $date; ?>">
		<input type="hidden" name="holidays" value="<?php echo $hdays; ?>">
		
		<?php
		
		mysqli_close($conn);
		
	}
?>