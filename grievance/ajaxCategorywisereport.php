<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();


		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		$search =0;
		$fromDate = "2019-01-01";
		$toDate = "2020-03-31";
		$status = 0;
		//$cat_id =4;
		$cat_id = $_REQUEST['catid'];
		$fromDate = date('Y-m-d',strtotime($_REQUEST['fromdate']));
		$toDate = date('Y-m-d',strtotime($_REQUEST['todate']));;
		
		if(!empty($fromDate) && !empty($toDate) && $fromDate !='1970-01-01' && $toDate !='1970-01-01')
		{
		    $status = 1;
		}
		
		
		
	 
				   
	 	$sql1="SELECT count(grievance_id) as total_received,g.ulbid,app_type_id,cm.description FROM grievances g,cs_mst c,category_mst cm  where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and  g.cat3_id !='0' and cm.cat_id='".$cat_id."'";
	 	if($status==1)
	 	{
	 	    $sql1.=" and date_regd between DATE('".$fromDate."')  and  DATE('".$toDate."')";
	 	}
	 	
	 	$sql1.=" group by g.ulbid,app_type_id";	
	 	
	 	//echo $sql1;
	 	

		$rs = mysqli_query($conn,$sql1);
		while($row = mysqli_fetch_assoc($rs))
		{
		      $data1[$row['ulbid']][$row['app_type_id']]['total_received']=$row['total_received'];
		      $data[$row['app_type_id']]['comp_tot_received']+=$data1[$row['ulbid']][$row['app_type_id']]['total_received'];
		      $description = $row['description'];
		}
		
		
	
		
		
		/******************* pending for approval **************/
		
		
		
		$query="select count(grievance_id) as pending_for_approval,app_type_id,g.ulbid from grievances g,cs_mst c,category_mst cm  where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and cm.cat_id='".$cat_id."' and grievance_status_id='1' and cat3_id !='0'";
		if($status==1)
	 	{
	 	    $query.=" and date_regd between DATE('".$fromDate."')  and  DATE('".$toDate."')";
	 	}
		$query.=" group by g.ulbid,app_type_id ";
		
			$rs211 = mysqli_query($conn,$query);
		while($row = mysqli_fetch_assoc($rs211))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['pending_for_approval']=$row['pending_for_approval'];
		      $data[$row['app_type_id']]['pending_approval']+=$data1[$row['ulbid']][$row['app_type_id']]['pending_for_approval'];
		}
		
		
		
		
		
		
		// completed within sla  
		
		
		
		$sql2="SELECT count(grievance_id) as resolved_withinsla,app_type_id,g.ulbid FROM grievances g,cs_mst c,category_mst cm  where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and cm.cat_id='".$cat_id."' and grievance_status_id NOT IN('2','1') and
		sla_status=1 and cat3_id !='0'";
		if($status==1)
	 	{
		$sql2.=" and date_regd between DATE('".$fromDate."')  and  DATE('".$toDate."')";
	 	}
		$sql2.=" group by g.ulbid,app_type_id ";
		
		$rs1 = mysqli_query($conn,$sql2);
		while($row = mysqli_fetch_assoc($rs1))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['resolved_withinsla']=$row['resolved_withinsla'];
		     $data[$row['app_type_id']]['resolved_withinsla']+=$data1[$row['ulbid']][$row['app_type_id']]['resolved_withinsla'];
	
		}
		
	
		$sql6 ="SELECT count(grievance_id) as resolved_beyond_sla,app_type_id,g.ulbid FROM grievances g,cs_mst c,category_mst cm  where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and cm.cat_id='".$cat_id."' and grievance_status_id NOT IN('2','1') and
		sla_status=2 and cat3_id !='0'";
		if($status==1)
	 	{
		$sql6.=" and date_regd between DATE('".$fromDate."')  and  DATE('".$toDate."')";
	 	}
		$sql6.=" group by g.ulbid,app_type_id";
			  	  
			  
		$rs6 = mysqli_query($conn,$sql6);
		while($row = mysqli_fetch_assoc($rs6))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['resolved_beyond_sla']=$row['resolved_beyond_sla'];
		     $data[$row['app_type_id']]['resolved_beyond_sla']+=$data1[$row['ulbid']][$row['app_type_id']]['resolved_beyond_sla'];
		}	  
			  
			  
			  
			//////////////////////////////////////////////////////	  
			  
			  
			  
		
		//  pending with in sla and beyond sla 
		
		
		$sql3="SELECT count(grievance_id) as pending_within_sla,app_type_id,g.ulbid FROM grievances g,cs_mst c,category_mst cm  where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and cm.cat_id='".$cat_id."' and grievance_status_id IN('2') and
		sla_status=1 and cat3_id !='0'";
		if($status==1)
	 	{
		$sql3.=" and date_regd between DATE('".$fromDate."')  and  DATE('".$toDate."')";
	 	}
		$sql3.=" group by g.ulbid,app_type_id";
		
			$rs2 = mysqli_query($conn,$sql3);
		while($row = mysqli_fetch_assoc($rs2))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['pending_within_sla']=$row['pending_within_sla'];
		     $data[$row['app_type_id']]['pending_within_sla']+=$data1[$row['ulbid']][$row['app_type_id']]['pending_within_sla'];
		     
		}
		
		
		
		
		
		
		$sql7="SELECT count(grievance_id) as pending_be_sla,app_type_id,g.ulbid FROM grievances g,cs_mst c,category_mst cm  where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and cm.cat_id='".$cat_id."' and grievance_status_id IN('2') and
		sla_status=2 and cat3_id !='0'";
		if($status==1)
	 	{
		$sql7.=" and date_regd between DATE('".$fromDate."')  and  DATE('".$toDate."')";
	 	}
		$sql7.=" group by g.ulbid,app_type_id";
		
		$rs7 = mysqli_query($conn,$sql7);
		while($row = mysqli_fetch_assoc($rs7))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['pending_be_sla']=$row['pending_be_sla'];
		     $data[$row['app_type_id']]['pending_be_sla']+=$data1[$row['ulbid']][$row['app_type_id']]['pending_be_sla'];
		}	
		
		
		
		
	
		
		//$sql ="select * from ulbmst";
	  $sql="select d.*,u.* from ulbmst u,Districtmst d,rdma_mst r where d.rdma=r.rdma_id and u.distid=d.distid and u.ulbid like '%".$_REQUEST['ulbid']."%' and
	  u.ulbid !='500' and d.distid like '%".$_REQUEST['distid']."%' and r.rdma_id like '%".$_REQUEST['regionid']."%' order by d.distname,u.ulbname";
	  if($_SESSION['user_type']=='R')
	  {
	       $sql="select d.*,u.* from ulbmst u,Districtmst d,rdma_mst r where d.rdma=r.rdma_id and u.distid=d.distid and u.ulbid like '%".$_REQUEST['ulbid']."%' and 
	       u.ulbid !='500' and d.distid like '%".$_REQUEST['distid']."%' and d.rdma like '%".$_SESSION['uid']."%' order by d.distname,u.ulbname";
	  }
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		    $dist_list[$row['ulbid']]=$row['distname'];
		
		    
		}
		
		$sql="SELECT * FROM  rdma_mst";
		$rs = mysqli_query($conn,$sql);
		while($row= mysqli_fetch_assoc($rs))
		{
		    $region_list[$row['rdma_id']]=$row['rdma_desc'];
		}
		
		$sql="SELECT * FROM  Districtmst order by distname";
		$rs = mysqli_query($conn,$sql);
		while($row= mysqli_fetch_assoc($rs))
		{
		    $dist_list[$row['distid']]=$row['distname'];
		}
		
		mysqli_close($conn);
		
		
?>				
  
<div class="row" id="div_print">
 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>ULB Categorywise Summery Report</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    
                    
  <!--<div>
      
      <a href="past3report.php?days_3=3&ulbid=&distid=&regionid=" class="btn btn-primary col-md-2" style="margin-right:5px;">Last 3Days</a>
      <a href="past3report.php?days_7=7&ulbid=&distid=&regionid=" class="btn btn-primary col-md-2"  style="margin-right:5px;">Last One week</a>
      <a href="past3report.php?days_30=30&ulbid=&distid=&regionid=" class="btn btn-primary col-md-2" style="margin-right:5px;">Last One month</a>
        <a href="past3report.php?days_60=60&ulbid=&distid=&regionid=" class="btn btn-primary col-md-2" style="margin-right:5px;">Last Two months</a>
      <a href="past3report.php?ulbid=&distid=&regionid=" class="btn btn-primary col-md-2">All</a>
  </div>-->
                    
                    <br> <br>
                    
			
				
				
		<div>

<div>
    
</div>



<div class="wrapper2" style="margin:auto;">
<div class="div4">
    
    
 
    
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:13px;" class="display table-bordered table-striped table-condensed cf " id='example' >
    <thead>
  <tr style="background-color:#2c3e50; color:#FFF;">
    <td rowspan="3" align="center">S.No</td>
    <td rowspan="3" align="center">District Name</td>
    <td rowspan="3" align="center">ULB Name</td>
    <td rowspan="3" align="center">Category Name</td>
    <td colspan="11" align="center">Complaint</td>
    <!--<td colspan="11" align="center">Services</td>-->
  </tr>
  <tr style="background-color:#2c3e50; color:#FFF;">
    <td rowspan="2" align="center">Received</td>
    <td rowspan="2" align="center">Pending for Approval</td>
    <td rowspan="2" align="center">% Percentage</td>
    <td colspan="4" align="center">Redressed</td>
    <td colspan="4" align="center">Underprogress</td>
    <!--<td rowspan="2" align="center">Received</td>
    <td rowspan="2" align="center">Pending for Approval</td>
    <td rowspan="2" align="center">% Percentage</td>
    <td colspan="4" align="center">Completed</td>
    <td colspan="4" align="center">Pending</td>-->
  </tr>
  <tr style="background-color:#2c3e50; color:#FFF;">
    <td align="center">Within SLA</td>
    <td align="center">% Percentage</td>
    <td align="center">Beyond SLA</td>
    <td align="center">% Percentage</td>
    <td align="center">Within SLA</td>
    <td align="center">% Percentage</td>
    <td align="center">Beyond SLA</td>
    <td align="center">% Percentage</td>
    <!--<td align="center">Within SLA</td>
    <td align="center">% Percentage</td>
    <td align="center">Beyond SLA</td>
    <td align="center">% Percentage</td>
    <td align="center">Within SLA</td>
    <td align="center">% Percentage</td>
    <td align="center">Beyond SLA</td>
    <td align="center">% Percentage</td>-->
  </tr>
  </thead>
  <tbody>
      
      
      
    <?php $i = 1 ;
    $totalReceived=0;
    $pendignApproval =0;
    $resolvedInsla =0;
    $resolvedbeyondsla =0;
    $pendinginsla=0;
    $pendingbeyondsla=0;
    foreach($ulb_list as $key=>$value) { 
    $t = $data1[$key][1]['pending_for_approval']+$data1[$key][1]['resolved_withinsla']+$data1[$key][1]['resolved_beyond_sla']+$data1[$key][1]['pending_within_sla']+$data1[$key][1]['pending_be_sla'];
    $totalReceived+=$t;
    $pendignApproval+=$data1[$key][1]['pending_for_approval'];
    $resolvedInsla+=$data1[$key][1]['resolved_withinsla'];
    $resolvedbeyondsla+=$data1[$key][1]['resolved_beyond_sla'];
    $pendinginsla+=$data1[$key][1]['pending_within_sla'];
    $pendingbeyondsla+=$data1[$key][1]['pending_be_sla'];
    ?>   
      
 
  
  <!--{if $ulbid eq '207'} 
  {assign var='pending_beyond_sla' value=6} 
  {assign var='pending_within_sla' value=$comp_pending[$ulbid].withinsla + $comp_pending[$ulbid].beyondinsla -6}
  
  {assign var='pending_beyond_sla_ser' value=2} 
  {assign var='pending_within_sla_ser' value=$service_pending[$ulbid].withinsla + $service_pending[$ulbid].beyondinsla -2}
  
  {/if}-->
  
  <tr>
    <td align="center"><?php echo $i; ?></td>
    <td align="center"><?php echo $dist_list[$key];?></td>
    <td align="center"><?php echo $value; ?></td>
    <td align="center"><?php echo $description; ?></td>
    <td align="center"><?php echo $data1[$key][1]['pending_for_approval']+$data1[$key][1]['resolved_withinsla']+$data1[$key][1]['resolved_beyond_sla']+$data1[$key][1]['pending_within_sla']+$data1[$key][1]['pending_be_sla'] ;?></td>
    
    <?php if($data1[$key][1]['pending_for_approval'] == '') { ?>
    
    <td align="center">0</td>
    
    <?php } else { ?>
    
    <td align="center"><?php echo $data1[$key][1]['pending_for_approval'] ;?></td>
    
    <?php } ?> 
    
    
    <?php 
    
    $data1[$key][1]['total_received']=$data1[$key][1]['pending_for_approval']+$data1[$key][1]['resolved_withinsla']+$data1[$key][1]['resolved_beyond_sla']+$data1[$key][1]['pending_within_sla']+$data1[$key][1]['pending_be_sla'];
    
    $per = $data1[$key][1]['total_received'];
    $per1 = $data1[$key][1]['pending_for_approval'] ;
    //$rescompwitinslaper=number_format($data1[$key][1]['resolved_withinsla']/$per,2);
    if(is_nan($data1[$key][1]['resolved_withinsla']/$per*100))
    {
        $rescompwitinslaper=0;
    }
    else
    {
        $rescompwitinslaper=number_format($data1[$key][1]['resolved_withinsla']/$per*100,2);
    }
   //$rescompbeyondlsla =number_format($data1[$key][1]['resolved_beyond_sla']/$per,2);
    if(is_nan($data1[$key][1]['resolved_beyond_sla']/$per*100))
    {
        $rescompbeyondlsla=0;
    }
    else
    {
        $rescompbeyondlsla = number_format($data1[$key][1]['resolved_beyond_sla']/$per*100,2);
    }
    
    $res = $per1/$per*100;
    if(is_nan($res))
    {
        $res=0;
    }
    
    ?>
    
    
    <td align="center">
        <?php 
        
        echo number_format($res,2); ?>
    </td>
    <td align="center"><?php echo $data1[$key][1]['resolved_withinsla'] ;?></td>
    <td align="center"><?php echo $rescompwitinslaper;?></td>
    <td align="center"><?php echo $data1[$key][1]['resolved_beyond_sla'] ;?></td>
    <td align="center">
        <?php 
        
        echo $rescompbeyondlsla;
        
        
        ?>
        </td>
    
    
    <?php if($data1[$key][1]['pending_within_sla'] == '') { ?>
    
    <td align="center">0</td>
    
    <?php } else { ?>
    
    <td align="center"><?php echo $data1[$key][1]['pending_within_sla'] ;?></td>
    
    <?php } ?> 
    
    <td align="center">
        <?php 
        $a = $data1[$key][1]['pending_within_sla']/$per*100;
        if(is_nan($a))
        {
         echo 0.00;
        }
        else
        {
         echo number_format($data1[$key][1]['pending_within_sla']/$per*100,2);
        }
        ?>
    </td>
    
    
    <?php if($data1[$key][1]['pending_be_sla'] == '') { ?>
    
    <td align="center">0</td>
    
    <?php } else { ?>
    
    <td align="center"><?php echo $data1[$key][1]['pending_be_sla'] ;?></td>
    
    <?php } ?> 
    
    <td align="center">
        <?php 
        $b = $data1[$key][1]['pending_be_sla']/$per*100;
        if(is_nan($b))
        {
            echo 0.00;
        }
        else
        {
        echo number_format($data1[$key][1]['pending_be_sla']/$per*100,2);
        }
        ?>
        </td>
    
    
    
    
  </tr>
  
  <?php $i++; } ?>
  
 </tbody>
 <tfoot>
     
     
     <?php 
     
     $total = $totalReceived;
     $total1 = $data[2]['comp_tot_received'];
     
     ?>
     
     <td></td>
     <td></td>
     <td></td>
     <td>Total</td>
     <td align="center"><?php echo $totalReceived; ?></td>
     <td align="center"><?php echo $pendignApproval; ?></td>
     <td align="center"><?php echo number_format($pendignApproval/$total*100,2);?></td>
     <td align="center"><?php echo $resolvedInsla;?></td>
     <td align="center"><?php echo number_format($resolvedInsla/$total*100,2);?></td>
     <td align="center"><?php echo $resolvedbeyondsla;?></td>
     <td align="center"><?php echo number_format($resolvedbeyondsla/$total*100,2);?></td>
     <td align="center"><?php echo $pendinginsla;?></td>
     <td align="center"><?php echo number_format($pendinginsla/$total*100,2);?></td>
     <td align="center"><?php echo $pendingbeyondsla;?></td>
     <td align="center"><?php echo number_format($pendingbeyondsla/$total*100,2);?></td>
     
 </tfoot>
</table>



</div>
    
</div>


</div>
				
			</form>
		</div>
		</div>
	</div>
</div>

</div>

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    	<script>
    	$(document).ready(function() {
    $('#example').DataTable({"bPaginate": false});
} );
    	
</script>


		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
