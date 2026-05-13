<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
	 
				   
	 	$sql1="SELECT count(grievance_id) as total_received,ulbid,app_type_id FROM grievances  where  cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126) group by ulbid,app_type_id";		   

		$rs = mysqli_query($conn,$sql1);
		while($row = mysqli_fetch_assoc($rs))
		{
		      $data1[$row['ulbid']][$row['app_type_id']]['total_received']=$row['total_received'];
		      $data[$row['app_type_id']]['comp_tot_received']+=$data1[$row['ulbid']][$row['app_type_id']]['total_received'];
		}
		
		
	
		
		
		/******************* pending for approval **************/
		
		
		
		$query="select count(grievance_id) as pending_for_approval,app_type_id,ulbid from grievances where  grievance_status_id='1' and cat3_id !='0' 
		and cat3_id IN(105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126) group by ulbid,app_type_id ";
		
			$rs211 = mysqli_query($conn,$query);
		while($row = mysqli_fetch_assoc($rs211))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['pending_for_approval']=$row['pending_for_approval'];
		      $data[$row['app_type_id']]['pending_approval']+=$data1[$row['ulbid']][$row['app_type_id']]['pending_for_approval'];
		}
		
		
		
		
		
		
		// completed within sla  
		
		
		
		$sql2="SELECT count(grievance_id) as resolved_withinsla,app_type_id,ulbid FROM grievances  where  grievance_status_id IN('3','8','9') and
		sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126) 104 group by ulbid,app_type_id ";
		
		$rs1 = mysqli_query($conn,$sql2);
		while($row = mysqli_fetch_assoc($rs1))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['resolved_withinsla']=$row['resolved_withinsla'];
		     $data[$row['app_type_id']]['resolved_withinsla']+=$data1[$row['ulbid']][$row['app_type_id']]['resolved_withinsla'];
	
		}
		
	
		$sql6 ="SELECT count(grievance_id) as resolved_beyond_sla,app_type_id,ulbid FROM grievances  where  grievance_status_id IN('3','8','9') and
		sla_status=2 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126) group by ulbid,app_type_id";
			  	  
			  
		$rs6 = mysqli_query($conn,$sql6);
		while($row = mysqli_fetch_assoc($rs6))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['resolved_beyond_sla']=$row['resolved_beyond_sla'];
		     $data[$row['app_type_id']]['resolved_beyond_sla']+=$data1[$row['ulbid']][$row['app_type_id']]['resolved_beyond_sla'];
		}	  
			  
			  
			  
			//////////////////////////////////////////////////////	  
			  
			  
			  
		
		//  pending with in sla and beyond sla 
		
		
		$sql3="SELECT count(grievance_id) as pending_within_sla,app_type_id,ulbid FROM grievances  where  grievance_status_id IN('2') and
		sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126) group by ulbid,app_type_id";
		
			$rs2 = mysqli_query($conn,$sql3);
		while($row = mysqli_fetch_assoc($rs2))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['pending_within_sla']=$row['pending_within_sla'];
		     $data[$row['app_type_id']]['pending_within_sla']+=$data1[$row['ulbid']][$row['app_type_id']]['pending_within_sla'];
		     
		}
		
		
		
		
		
		
		$sql7="SELECT count(grievance_id) as pending_be_sla,app_type_id,ulbid FROM grievances  where grievance_status_id IN('2') and
		sla_status=2 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126) group by ulbid,app_type_id";
		
		$rs7 = mysqli_query($conn,$sql7);
		while($row = mysqli_fetch_assoc($rs7))
		{
		     $data1[$row['ulbid']][$row['app_type_id']]['pending_be_sla']=$row['pending_be_sla'];
		     $data[$row['app_type_id']]['pending_be_sla']+=$data1[$row['ulbid']][$row['app_type_id']]['pending_be_sla'];
		}	
		
		
		
		
	
		
		//$sql ="select * from ulbmst";
	  $sql="select d.*,u.* from ulbmst u,Districtmst d,rdma_mst r where d.rdma=r.rdma_id and u.distid=d.distid and u.ulbid like '%".$_REQUEST['ulbid']."%' and
	  u.ulbid !='500' and d.distid like '%".$_REQUEST['distid']."%' and r.rdma_id like '%".$_REQUEST['regionid']."%' order by u.ulbname";
	  if($_SESSION['user_type']=='R')
	  {
	       $sql="select d.*,u.* from ulbmst u,Districtmst d,rdma_mst r where d.rdma=r.rdma_id and u.distid=d.distid and u.ulbid like '%".$_REQUEST['ulbid']."%' and 
	       u.ulbid !='500' and d.distid like '%".$_REQUEST['distid']."%' and d.rdma like '%".$_SESSION['uid']."%' order by u.ulbname";
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
		
		$sql="SELECT * FROM  Districtmst";
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
                  <h4>ULB wise street vendors summery report</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    
                    
 
                    
                    <br> <br>
                    
			<form  method="post" action="entry_app_downloads.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				
				
		<div>



<!--<div class="wrapper1">
    <div class="div3" >
    </div>	
</div>-->

<div class="" style="margin:auto;">
<div >
    
 
    
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:13px;" class="table-bordered table-striped table-condensed cf " id='example' >
    <thead>
  <tr style="background-color:#2c3e50; color:#FFF;">
    <td rowspan="3" align="center">S.No</td>
    <td rowspan="3" align="center">District Name</td>
    <td rowspan="3" align="center">ULB Name</td>
    <td colspan="11" align="center">Complaint</td>
    
  </tr>
  <tr style="background-color:#2c3e50; color:#FFF;">
    <td rowspan="2" align="center">Received</td>
    <td rowspan="2" align="center">Pending for Approval</td>
    <td rowspan="2" align="center">% Percentage</td>
    <td colspan="4" align="center">Redressed</td>
    <td colspan="4" align="center">Pending</td>
    
    
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
    
  </tr>
  </thead>
  <tbody>
      
      
      
    <?php $i = 1 ; foreach($ulb_list as $key=>$value) { ?>   
      
 
  
  
  
  <tr>
    <td align="center"><?php echo $i; ?></td>
    <td align="center"><?php echo $dist_list[$key];?></td>
    <td align="center"><?php echo $value; ?></td>
    <td align="center"><?php echo $data1[$key][1]['total_received'] ;?></td>
    
    <?php if($data1[$key][1]['pending_for_approval'] == '') { ?>
    
    <td align="center">0</td>
    
    <?php } else { ?>
    
    <td align="center"><?php echo $data1[$key][1]['pending_for_approval'] ;?></td>
    
    <?php } ?> 
    
    
    <?php 
    
    $per = $data1[$key][1]['total_received'];
    $per1 = $data1[$key][1]['pending_for_approval'] ;
    
    
    $res = $per1/$per*100;
    if(is_nan($res))
    {
        $res=0.00;
    }
    
    $a =$data1[$key][1]['resolved_withinsla']/$per;
    if(is_nan($a))
    {
        $a=0.00;
    }
    $b = $data1[$key][1]['resolved_beyond_sla']/$per;
    if(is_nan($b))
    {
        $b=0.00;
    }
    $c = $data1[$key][1]['pending_within_sla']/$per;
    if(is_nan($c))
    {
        $c=0.00;
    }
    ?>
    
    
    <td align="center"><?php echo $res; ?></td>
    <td align="center"><?php echo $data1[$key][1]['resolved_withinsla'] ;?></td>
    <td align="center"><?php echo $a;?></td>
    <td align="center"><?php echo $data1[$key][1]['resolved_beyond_sla'] ;?></td>
    <td align="center"><?php echo $b;?></td>
    
    
    <?php if($data1[$key][1]['pending_within_sla'] == '') { ?>
    
    <td align="center">0</td>
    
    <?php } else { ?>
    
    <td align="center"><?php echo $data1[$key][1]['pending_within_sla'] ;?></td>
    
    <?php } ?> 
    
    <td align="center"><?php echo $c;?></td>
    
    
    <?php if($data1[$key][1]['pending_be_sla'] == '') { ?>
    
    <td align="center">0</td>
    
    <?php } else { ?>
    
    <td align="center"><?php echo $data1[$key][1]['pending_be_sla'] ;?></td>
    
    <?php } ?> 
    
    <td align="center"><?php $data1[$key][1]['pending_be_sla']/$per;?></td>
  
  </tr>
  
  <?php $i++; } ?>
  
 </tbody>
 <tfoot>
     
     
     <?php 
     
     $total = $data[1]['comp_tot_received'];
     $total1 = $data[2]['comp_tot_received'];
     
     ?>
     
     
    <td colspan="3">Total</td>
     <td align="center"><?php echo $data[1]['comp_tot_received']; ?></td>
     <td align="center"><?php echo $data[1]['pending_approval']; ?></td>
     <td align="center"><?php echo number_format($data[1]['pending_approval']/$total*100,2);?></td>
     <td align="center"><?php echo $data[1]['resolved_withinsla'];?></td>
     <td align="center"><?php echo number_format($data[1]['resolved_withinsla']/$total*100,2);?></td>
     <td align="center"><?php echo $data[1]['resolved_beyond_sla'];?></td>
     <td align="center"><?php echo number_format($data[1]['resolved_beyond_sla']/$total*100,2);?></td>
     <td align="center"><?php echo $data[1]['pending_within_sla'];?></td>
     <td align="center"><?php echo number_format($data[1]['pending_within_sla']/$total*100,2);?></td>
     <td align="center"><?php echo $data[1]['pending_be_sla'];?></td>
     <td align="center"><?php echo number_format($data[1]['pending_be_sla']/$total*100,2);?></td>
     
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


		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
