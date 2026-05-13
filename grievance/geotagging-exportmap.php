<html>
	<head>	
		<style>
		 #mapCanvas {
                width: 100%;
                height: 650px;
            }
		</style>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	</head>
	<body>
	  
<?php
//PRINT_R($_POST);
if(empty($_POST)){ ?>
    <script>
 
  location.replace("http://municipalservices.in/geotagging-reportmap.php")
 
</script> 
    
<?php exit();
}
ini_set('display_errors',1);
    	            define("API_KEY","AIzaSyAm9ekbF8SnmFeUH4BvEffHYu_TuUieoDw");  
	               //	session_start();
                     require_once('prepare_connection.php');
            		//$conn=getconnection();
                    $sql21 ="select * from ulbmst where ulbid='".$_POST['ulb']."'";
            	    $rs21 = mysqli_query($conn,$sql21);
            	    $row212 = mysqli_fetch_assoc($rs21);
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
            			                 $sqlward="select * from ward_mst where ward_id='".$_POST['Wardno']."' order by sort_order asc";
                                      	 $rsward=mysqli_query($conn,$sqlward);
                                      	 $rswards = mysqli_fetch_assoc($rsward);
            			                 $wardnm=$rswards['ward_desc'];
			                      }else{
			                            $Wardno.="";
			                      }
		    /*------IIHL-----*/
		     if($_POST['type']==1 and $_POST['subtype'] == 4){
		      $typename='Septic Tank';
		      $subtype='IHHL'; 
		     }  
		     if($_POST['type']==1 and $_POST['subtype'] == 5){
		      $typename='Septic Tank'; 
		      $subtype='Public Toilets';
		     }  
		     if($_POST['type']==1 and $_POST['subtype'] == 6){
		      $typename='Septic Tank'; 
		      $subtype='Community Toilets';
		     }  
		     if($_POST['type']==1 and $_POST['subtype'] == 7){
		      $typename='Septic Tank'; 
		      $subtype='Others';
		     }  
		       
		      if($_POST['type']==2){
		      $mhole=$_POST['type']; 
		      $typename='Maintenance Holes'; 
		       $subtype='';
		       $_POST['subtype'] ='';
		     }  
		     if($_POST['type']==3){
		       $hoading=$_POST['type']; 
		       $typename='IEC Hoardings'; 
		        $subtype='';
		        $_POST['subtype'] ='';
		     }
		     if($_POST['type']==1 and $_POST['subtype'] == 4){  
    		       $sqlHhlData14="SELECT tb1.*,tb3.ward_desc,tb2.desc FROM `HhlData` tb1 join geotagging_cat_dropdown tb2 on tb1.YesOrNoValue=tb2.id  join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
                   $rsHhlData14=mysqli_query($conn,$sqlHhlData14);
                 if(mysqli_num_rows($rsHhlData14) == 0){ ?>
                   <script>
                     alert('No Records found');
                    window.top.close();
                   </script> 
                 <?php exit();
                }    
               
		     }
              if($_POST['type']==1 and ($_POST['subtype']==5 || $_POST['subtype']==6 || $_POST['subtype']==7)){
		         
    		    $sqlPCO21="SELECT tb1.*,tb2.ward_desc FROM `public_community_other_toilets` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_POST['ulb']."' and tb1.ToiletID='".$_POST['subtype']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsPCO21=mysqli_query($conn,$sqlPCO21);
                  if(mysqli_num_rows($rsPCO21) == 0){ ?>
                       <script>
                         alert('No Records found');
                        window.top.close();
                       </script> 
                     <?php exit();
                    }    
    		    
		     }   
       
              if($mhole==2){
		         
		       //  PRINT_R($_POST);DIE;
    		    $sqlsub20="SELECT tb2.desc,tb1.*,tb3.ward_desc FROM `MHolesMst` tb1 join geotagging_cat_dropdown tb2 on tb1.ConditionValue=tb2.id join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rssub20=mysqli_query($conn,$sqlsub20);
                  if(mysqli_num_rows($rssub20) == 0){ ?>
                       <script>
                         alert('No Records found');
                       window.top.close();
                       </script> 
                     <?php exit();
                    }    
              }
    		     
		     
		     if($hoading==3){
		            
    		     $sqlIEC12="SELECT tb1.*,tb2.ward_desc FROM `IECHoardings` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsIEC12=mysqli_query($conn,$sqlIEC);
                  if(mysqli_num_rows($rsIEC12) == 0){ ?>
                       <script>
                         alert('No Records found');
                        window.top.close();
                       </script> 
                     <?php exit();
                    }    
		     }
    		   
		    ?>
		    <div style="padding:10px; background-color:#a20e0e; margin:0 auto;font-size: 25px; text-align:center; font-family:'Open Sans'; font-size:14px; color:#FFF;">
                <div class="heading3"><strong style="font-size: 25px;" >ULB :: <?php echo $_POST['uid']; ?>  </strong></div>
                <div class="heading3"><strong style="font-size: 18px;line-height: 30px;" >Type :: <span style="font-size: 19px;"><?php echo $typename; ?></span> Subtype :: <span style="font-size: 19;"><?php echo $subtype; ?></span> Wardno :: <span style="font-size: 19px;"><?php echo @$wardnm; ?></span> </strong>
            </div>
        </div>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo API_KEY; ?>"></script>
		    <script>
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
         center: new google.maps.LatLng(<?php echo $row212['lat'] ?>, <?php echo $row212['lng'] ?>),
         
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(50);
        
    // Multiple markers location, latitude, and longitude
    var markers = [
        // ["Brooklyn Museum, NY", 18.4519937, 79.1199556],
        // ["Brooklyn Public Library, NY", 18.4525993,  79.1063082],
           
           <?php
                
		    if($_POST['type']==1 and $_POST['subtype'] == 4){  
    		       $sqlHhlData="SELECT tb1.*,tb3.ward_desc,tb2.desc FROM `HhlData` tb1 join geotagging_cat_dropdown tb2 on tb1.YesOrNoValue=tb2.id  join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
                   $rsHhlData=mysqli_query($conn,$sqlHhlData);
                 
                  foreach($rsHhlData as $key => $rowsHhlData)
                 { 
                	  
    		       echo '["'.$rowsHhlData['Area'].'", '.$rowsHhlData['latitude'].', '.$rowsHhlData['longitude'].'],';
                   }  
                
                  
                }    
               
               
              if($_POST['type']==1 and ($_POST['subtype']==5 || $_POST['subtype']==6 || $_POST['subtype']==7)){
		         
    		    $sqlPCO="SELECT tb1.*,tb2.ward_desc FROM `public_community_other_toilets` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_POST['ulb']."' and tb1.ToiletID='".$_POST['subtype']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsPCO=mysqli_query($conn,$sqlPCO);
              
                	while($rowsPCO = mysqli_fetch_assoc($rsPCO))
    	     	{
    		    	 
    		    	   echo '["'.$rowsPCO['Area'].'", '.$rowsPCO['latitude'].', '.$rowsPCO['longitude'].'],';
    		    }
    		    
		     }   
       
              if($mhole==2){
		         
		       //  PRINT_R($_POST);DIE;
    		    $sqlsub="SELECT tb2.desc,tb1.*,tb3.ward_desc FROM `MHolesMst` tb1 join geotagging_cat_dropdown tb2 on tb1.ConditionValue=tb2.id join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rssub=mysqli_query($conn,$sqlsub);
              
                	while($rows = mysqli_fetch_assoc($rssub))
    	     	{
    		     
                      echo '["'.$rows['Area'].'", '.$rows['latitude'].', '.$rows['longitude'].'],';
    		     
    		    }
              }
    		     
		     
		     if($hoading==3){
		            
    		     $sqlIEC="SELECT tb1.*,tb2.ward_desc FROM `IECHoardings` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsIEC=mysqli_query($conn,$sqlIEC);
              
                	while($rowsIEC = mysqli_fetch_assoc($rsIEC))
    	     	{
    		      
    		          echo '["'.$rowsIEC['Area'].'", '.$rowsIEC['latitude'].', '.$rowsIEC['longitude'].'],';
    		    }
		     }
    		    ?>
    ];
                        
    // Info window content
     var infoWindowContent = [
       
        
         <?php
                
		    if($_POST['type']==1 and $_POST['subtype'] == 4){  
    		       $sqlHhlData1="SELECT tb1.*,tb3.ward_desc,tb2.desc FROM `HhlData` tb1 join geotagging_cat_dropdown tb2 on tb1.YesOrNoValue=tb2.id  join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
                   $rsHhlData1=mysqli_query($conn,$sqlHhlData1);
                 
                  foreach($rsHhlData1 as $key => $rowsHhlData1)
                 { 
                	 
    		      ?>
                ["<div class='info_content'>" +
                "<h3><?php echo $rowsHhlData1['Area']; ?></h3>" +
                 "<p>Ward no:<?php echo $rowsHhlData1['ward_desc']; ?></p>" + "</div>"],
              <?php
                   }  
                   }   
              if($_POST['type']==1 and ($_POST['subtype']==5 || $_POST['subtype']==6 || $_POST['subtype']==7)){
		        
    		    $sqlPCO1="SELECT tb1.*,tb2.ward_desc FROM `public_community_other_toilets` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_POST['ulb']."' and tb1.ToiletID='".$_POST['subtype']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsPCO1=mysqli_query($conn,$sqlPCO1);
              
                	while($rowsPCO1 = mysqli_fetch_assoc($rsPCO1))
    	     	{
    		    	   ?>
                ["<div class='info_content'>" +
                "<h3><?php echo $rowsPCO1['Area']; ?></h3>" +
                 "<p>Ward no:<?php echo $rowsPCO1['ward_desc']; ?></p>" + "</div>"],
              <?php
    		    }
    		    
		     }   
     
              if($mhole==2){
		          
		       //  PRINT_R($_POST);DIE;
    		    $sqlsub1="SELECT tb2.desc,tb1.*,tb3.ward_desc FROM `MHolesMst` tb1 join geotagging_cat_dropdown tb2 on tb1.ConditionValue=tb2.id join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rssub1=mysqli_query($conn,$sqlsub1);
              
                	while($rows1 = mysqli_fetch_assoc($rssub1))
    	     	{
    		     	   ?>
                ["<div class='info_content'>" +
                 "<h3><?php echo $rows1['Area']; ?></h3>" +
                 "<p>Ward no:<?php echo $rows1['ward_desc']; ?></p>" + "</div>"],
              <?php
    		     
    		    }
              }
    		     
		     if($hoading==3){
		            
    		     $sqlIEC1="SELECT tb1.*,tb2.ward_desc FROM `IECHoardings` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_POST['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsIEC1=mysqli_query($conn,$sqlIEC1);
              
                	while($rowsIEC1 = mysqli_fetch_assoc($rsIEC1))
    	     	{
    		       ?>
                  ["<div class='info_content'>" +
                 "<h3><?php echo $rowsIEC1['Area']; ?></h3>" +
                 "<p>Ward no:<?php echo $rowsIEC1['ward_desc']; ?></p>" + "</div>"],
                  <?php
    		    }
		     }
    		    ?>
    ];
       	    
    		    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
    
}
// Load initialize function
google.maps.event.addDomListener(window, 'load', initMap);
</script>
<div id="mapCanvas"></div>
</div>

</body>
</html>