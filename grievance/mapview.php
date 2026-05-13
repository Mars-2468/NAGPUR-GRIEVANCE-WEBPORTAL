<?phprequire "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',1);
//	require_once('Smarty.class.php');
//	$tpl=new Smarty();
   $_SESSION['uid'];
	   // define("API_KEY","AIzaSyCir3zEveATLQTFtg_ZOaAmpkuUUrXoSUM");  
	  define("API_KEY","AIzaSyAm9ekbF8SnmFeUH4BvEffHYu_TuUieoDw");  
	    
       require_once('connection.php');
		$conn=getconnection();
        $sql ="select * from ulbmst where ulbname='".$_SESSION['uid']."'";
	    $rs = mysqli_query($conn,$sql);
	    $row2 = mysqli_fetch_assoc($rs);

        $sql ="select * from public_community_other_toilets ";
		$result = mysqli_query($conn,$sql);
		$sql1 ="select * from public_community_other_toilets ";
		$result1 = mysqli_query($conn,$sql1);
//  while($row = mysqli_fetch_assoc($result)){
//                 echo '["'.$row['Area'].'", '.$row['latitude'].', '.$row['longitude'].'],';
//             }die;
?>

<html>
    
    <head>
        <style>
            #mapCanvas {
                width: 100%;
                height: 650px;
            }
        </style>
 


    </head>

    <body>
        
        <div class="row justify-content-center">
					<div class="col-md-3">
					    <div class="form-group1">
                          <label  >Type:</label>{$search.type1}
                          <select class="form-control" name="type" required id="dropdown_change">
                               <option value="">-select-</option>
                              	{foreach from=$geotagging  item=row}
							         <option value='{$row.Id}'  >{$row.Description}</option>
							   {/foreach}
						  </select>
                        </div>
					</div>
					
    				 <div class="col-md-3" style="display:none" id="sub_type" >
    					    <div class="form-group1">
                              <label  >Sub Type:</label>
                              <select class="form-control" name="subtype" id="subdrop">
    							        <option value="">-select-</option>
    							       {foreach from=$geotaggingsub  item=row}
							            <option value='{$row.Id}' >{$row.Description}</option>
							           {/foreach}
    							    </select>
                            </div>
    					</div>
    					 <div class="col-md-3" style=""  >
    					    <div class="form-group1">
                              <label  >Wards</label>
                              <select class="form-control" name="Wardno" >
    							        <option value="">-select-</option>
    							       {foreach from=$geowardlists  item=rows}
							            <option value='{$rows.ward_id}' {if ($search.Wardno)===($rows.ward_id)} selected  {/if}>{$rows.ward_desc}</option>
							           {/foreach}
    							    </select>
                            </div>
    					</div>
					<div class="col-md-3" style="">
                        <div class="form-group1">
                          <label class="" style="">From Date:</label>
                           <input type="text" class="phone-group form-control datepicker"    autocomplete="off" name="f_date" value="{$search.f_date}">
                         
                        </div>
                        </div>      
                        
                        
                        <div class="col-md-3" style="">
                        <div class="form-group1">
                          <label class="" style="">To Date:</label>
                          
                          <input type="text" class="phone-group form-control datepicker"    autocomplete="off" name="t_date" value="{$search.t_date}">
                          
                        </div>
                        </div>
					</div>
					
				 
					
					<div class="form-actions fluid "><br>
						<div class="col-md-offset-5 col-md-2">
						<button type="submit" class="btn btn-info" name="save">Search</button>
						 
						</div>
					</div>
       
		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo API_KEY; ?>"></script>
       <script>
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
         center: new google.maps.LatLng(<?php echo $row2['lat'] ?>, <?php echo $row2['lng'] ?>),
         
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
           while($row = mysqli_fetch_assoc($result)){
                echo '["'.$row['Area'].'", '.$row['latitude'].', '.$row['longitude'].'],';
            }
            ?>
      
    ];
                        
    // Info window content
     var infoWindowContent = [
        <?php
            while($row11 = mysqli_fetch_assoc($result1)){ ?>
                ['<div class="info_content">' +
                '<h3><?php echo $row11['Area']; ?></h3>' +
                
                '<p>Ward no:<?php echo $row11['Wardno']; ?></p>' + '</div>'],
        <?php }
        
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
    </body>
</html>