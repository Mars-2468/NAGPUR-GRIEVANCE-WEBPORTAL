<html>
	<head>	
		<style>
			/* Absolute Center Spinner */
			.loading {
			position: fixed;
			z-index: 999;
			overflow: show;
			margin: auto;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			width: 50px;
			height: 50px;
			}
			
			/* Transparent Overlay */
			.loading:before {
			content: '';
			display: block;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(255,255,255,0.5);
			}
			
			/* :not(:required) hides these rules from IE9 and below */
			.loading:not(:required) {
			hide "loading..." text
			font: 0/0 a;
			color: transparent;
			text-shadow: none;
			background-color: transparent;
			border: 0;
			}
			
			.loading:not(:required):after {
			content: '';
			display: block;
			font-size: 10px;
			width: 50px;
			height: 50px;
			margin-top: -0.5em;
			
			border: 5px solid rgba(33, 150, 243, 1.0);
			border-radius: 100%;
			border-bottom-color: transparent;
			-webkit-animation: spinner 1s linear 0s infinite;
			animation: spinner 1s linear 0s infinite;
			
			
			}
			
			/* Animation */
			
			@-webkit-keyframes spinner {
			0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			}
			100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
			}
			}
			@-moz-keyframes spinner {
			0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			}
			100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
			}
			}
			@-o-keyframes spinner {
			0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			}
			100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
			}
			}
			@keyframes spinner {
			0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			}
			100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
			}
			}
			.load_text{
               position: absolute; text-align:center;
               font-family: 'Poppins', sans-serif;
               color:#000; top:70px; left: -159px;
               width: 370px; background-color: #edf7fa; border-radius: 3px;
            }
		</style>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	</head>
	<body>
	    <div class="loading" style="display:;">
			<div class="load_text">
			    Please wait and do not close the tab, the file will be automatically downloaded
			</div>
		</div>
<?php
    	 require_once('prepare_connection.php');
	 
	$filename   = "ExcelReport_".date('d-m-Y').".csv";
    	ini_set('display_errors',1);
?>   
<div class="table-responsive">
	
                <?php 
                
                $i=1;  
                if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
            			                $datesbw.=" and (date(tb1.Date) between '".$f_date."' and '".$t_date."') " ;
            			                
			                      }
			elseif($_POST['f_date'] !='' && $_POST['t_date'] =='')
			                     {
			                            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                           
            			                $datesbw.=" and tb1.Date = '".$f_date."' " ;
            			                
			                      }
			elseif($_POST['f_date'] =='' && $_POST['t_date'] !='')
			                     {
			                           
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
            			                $datesbw.=" and tb1.Date ='".$t_date."'  " ;
            			                
			                      }else{
			                          $datesbw.="";
			                      }
		    if($_POST['Wardno'] !='')
			                     {
			                            
            			                $Wardno.="and tb1.Wardno='".$_POST['Wardno']."'" ;
            			                
			                      }else{
			                            $Wardno.="";
			                      }
		    /*------IIHL-----*/
		    if($_POST['type']==1 and $_POST['subtype'] == 4){ ?>
		   <table class="table table-bordered card-table table-hover table-vcenter  table-warning" id="" style="font-size:13px;display:none;">
		<thead class="bg-warning text-white">
		         <tr class="table-success">
                         <th width=" ">S.no</th>
                         <th width="">House hold No</th>
                         <th width="">Area</th>
                         <th width="">Resident Name</th>
                         <th width="">Ward</th>
                         <th width="">Mobile</th>
                         <th width="">Toilet (Yes / No)</th>
                         <th width="">Defecate location</th>
                         <th width="">longitude & latitude</th>
                         <th width="">Date</th>
                  
                 </tr>
                </thead>
                <tbody>
                <?php
    		       $sqlHhlData="SELECT tb1.*,tb3.ward_desc,tb2.desc FROM `HhlData` tb1 join geotagging_cat_dropdown tb2 on tb1.YesOrNoValue=tb2.id  join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
                   $rsHhlData=mysqli_query($conn,$sqlHhlData);
                  foreach($rsHhlData as $key => $rowsHhlData)
                 {  ?>
    		     <tr class="table-default">
                     <td><?php echo $i++ ?></td>
                     <td>" <?php echo str_replace(","," ",$rowsHhlData['HHno']) ?> "</td>
                     <td><?php echo str_replace(","," ",$rowsHhlData['Area']) ?></td>
                     <td><?php echo str_replace(",","&",$rowsHhlData['ResidentName']) ?></td>
                     <td><?php echo $rowsHhlData['ward_desc'] ?></td>
                     <td><?php echo $rowsHhlData['MobileNo'] ?></td>
                     <td><?php echo $rowsHhlData['HHToiletFacility'] ?></td>
                     <td><?php echo $rowsHhlData['desc'] ?></td>
                     <td><?php echo $rowsHhlData['latitude'] .' & '.$rowsHhlData['longitude'] ?></td>
                     <td><?php echo $rowsHhlData['DateTime'] ?></td>
                 </tr>
                <?php   } ?>
                
                 </tbody>
            </table>
                
                <?php }    ?>    
                 /*------PUBLIC**COMMUNITY***OTHER TOILETS-----*/
                 <?php
              if($_POST['type']==1 and ($_POST['subtype']==5 || $_POST['subtype']==6 || $_POST['subtype']==7)){
		         ?>
		         <table class="table table-bordered card-table table-hover table-vcenter  table-warning" id="" style="font-size:13px;display:none;">
		<thead class="bg-warning text-white">
		     <tr class="table-success">
                          <td>Sl.No</td>
                          <td>Area</td>
                          <td>Ward</td>
                          <td>Longitude &amp; Llatitude</td>
                          <td>Date</td>
                          
                  
                </tr>
                </thead>
                <tbody>
                    <?php
    		    $sqlPCO="SELECT tb1.*,tb2.ward_desc FROM `public_community_other_toilets` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_POST['ulb']."' and tb1.ToiletID='".$_POST['subtype']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsPCO=mysqli_query($conn,$sqlPCO);
              
                	while($rowsPCO = mysqli_fetch_assoc($rsPCO))
    	     	{
    		    	$PCO[]=array('Id'=>$rowsPCO['Id'],'Area'=>$rowsPCO['Area'],'Wardno'=>$rowsPCO['ward_desc']
    		    	,'Longitude'=>$rowsPCO['latitude'].'  & '.$rowsPCO['longitude'],'latitude'=>$rowsPCO['latitude']
    		    	,'longitudes'=>$rowsPCO['longitude'],'CaptureImagePath'=>$rowsPCO['CaptureImagePath']
    		    	,'DateTime'=>$rowsPCO['DateTime']);
    		    	?>
    		    	 <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $rowsPCO['Area'] ?></td>
                            <td><?php echo $rowsPCO['ward_desc'] ?></td>
                            <td><?php echo $rowsPCO['latitude'].'  & '.$rowsPCO['longitude'] ?></td>
                            <td><?php echo $rowsPCO['DateTime'] ?></td>
                    </tr>
    		    	<?php
    		    }
    		    
		     }   
        /*------Maintance holes-----*/
              if($_POST['type']==2  and empty($_POST['subtype'])){
		          ?>
		         <table class="table table-bordered card-table table-hover table-vcenter  table-warning" id="" style="font-size:13px;display:none;">
		<thead class="bg-warning text-white">
		     <tr class="table-success">
                          <td>Sl.No</td>
                          <td>Area</td>
                          <td>Ward</td>
                          <td>Unique Id</td>
                          <td>Condition</td>
                          <td>Length</td>
                          <td>Longitude &amp; Llatitude</td>
                          <td>Date</td>
                          
                  
                </tr>
                </thead>
                <tbody>
                    <?php
		       //  PRINT_R($_POST);DIE;
    		    $sqlsub="SELECT tb2.desc,tb1.*,tb3.ward_desc FROM `MHolesMst` tb1 join geotagging_cat_dropdown tb2 on tb1.ConditionValue=tb2.id join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rssub=mysqli_query($conn,$sqlsub);
              
                	while($rows = mysqli_fetch_assoc($rssub))
    	     	{
    		    	$MHolesMst[]=array('Id'=>$rows['Id'],'Area'=>$rows['Area'],'UniqueId'=>$rows['UniqueId']
    		    	,'ConditionValue'=>$rows['desc'],'Wardno'=>$rows['ward_desc']
    		    	,'SewerLineLength'=>$rows['SewerLineLength']
    		    	,'Longitude'=>$rows['latitude'].'  & '.$rows['longitude'],'latitude'=>$rows['latitude']
    		    	,'longitudes'=>$rows['longitude'],'CaptureImagePath'=>$rows['CaptureImagePath']
    		    	,'DateTime'=>$rows['DateTime']); ?>
    		    	 <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $rows['Area'] ?></td>
                            <td><?php echo $rows['ward_desc'] ?></td>
                            <td><?php echo $rows['UniqueId'] ?></td>
                            <td><?php echo $rows['desc'] ?></td>
                            <td><?php echo $rows['SewerLineLength'] ?></td>
                            <td><?php echo $rows['latitude'].'  & '.$rows['longitude'] ?></td>
                            <td><?php echo $rows['DateTime'] ?></td>
                    </tr>
    		    	<?php
    		    }
              }
    		     
		      /*------IEC HODINGS-----*/
		     if($_POST['type']==3  and empty($_POST['subtype'])){
		            ?>
		         <table class="table table-bordered card-table table-hover table-vcenter  table-warning" id="" style="font-size:13px;display:none;">
		<thead class="bg-warning text-white">
		     <tr class="table-success">
                          <td>Sl.No</td>
                          <td>Area</td>
                          <td>Ward</td>
                          <td>Unique Id</td>
                          <td>Slum unplanned</td>
                          
                          <td>Longitude &amp; Llatitude</td>
                          <td>Date</td>
                          
                  
                </tr>
                </thead>
                <tbody>
                    <?php
    		     $sqlIEC="SELECT tb1.*,tb2.ward_desc FROM `IECHoardings` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsIEC=mysqli_query($conn,$sqlIEC);
              
                	while($rowsIEC = mysqli_fetch_assoc($rsIEC))
    	     	{
    		    	$IECHODINGS[]=array('Id'=>$rowsIEC['Id'],'Area'=>$rowsIEC['Area'],'Wardno'=>$rowsIEC['ward_desc']
    		    	,'UniqueId'=>$rowsIEC['UniqueId'],'Slum_Unplanned_colony'=>$rowsIEC['Slum_Unplanned_colony']
    		        ,'Longitude'=>$rowsIEC['latitude'].'  & '.$rowsIEC['longitude'],'latitude'=>$rowsIEC['latitude']
    		    	,'longitudes'=>$rowsIEC['longitude'],'CaptureImagePath'=>$rowsIEC['CaptureImagePath']
    		        ,'DateTime'=>$rowsIEC['DateTime']); ?>
    		         <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $rowsIEC['Area'] ?></td>
                            <td><?php echo $rowsIEC['ward_desc'] ?></td>
                            <td><?php echo $rowsIEC['UniqueId'] ?></td>
                            <td><?php echo $rowsIEC['Slum_Unplanned_colony'] ?></td>
                            <td><?php echo $rowsIEC['latitude'].'  & '.$rowsIEC['longitude'] ?></td>
                            <td><?php echo $rowsIEC['DateTime'] ?></td>
                    </tr>
    		    	<?php
    		    }
		     }
    		    ?>
</div>
<script>
	exportTableToCSV("<?php echo $filename; ?>");
	
	function downloadCSV(csv, filename) {
		var csvFile;
		var downloadLink;
        
		// CSV file
		csvFile = new Blob([csv], {type: "text/csv"});
        
		// Download link
		downloadLink = document.createElement("a");
        
		// File name
		downloadLink.download = filename;
        
		// Create a link to the file
		downloadLink.href = window.URL.createObjectURL(csvFile);
        
		// Hide download link
		downloadLink.style.display = "none";
        
		// Add the link to DOM
		document.body.appendChild(downloadLink);
        
		// Click download link
		downloadLink.click();
		window.close();
	}
	
	function exportTableToCSV(filename) {
		
		var csv = [];
		var rows = document.querySelectorAll("table tr");
		
		for (var i = 0; i < rows.length; i++) {
			var row = [], cols = rows[i].querySelectorAll("td, th");
			
			for (var j = 0; j < cols.length; j++) 
			row.push(cols[j].innerText);
			
			csv.push(row.join(","));        
		}
        
		// Download CSV file
		downloadCSV(csv.join("\n"), filename);
	}
</script>
</body>
</html>