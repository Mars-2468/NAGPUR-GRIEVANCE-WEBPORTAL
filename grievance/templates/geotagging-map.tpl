{literal}

<style>
      #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      
      #content {
    width: 600px;
    color: navy;
    background-color: #FEFDCA;
    border: 1px solid #2994B2;
    padding: 5px;
    font-size:13px;
    border-radius:3px;
 }
 tr{text-align:left;}
 
  .fliter_txt{
 height:37px; background-color:#257ad1; margin:0 auto; text-align:center; font-family:'Open Sans'; font-size:14px;
 padding:5px 0px;
 float:left; width:100%;
 
 
  }
  
</style>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script> 
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAm9ekbF8SnmFeUH4BvEffHYu_TuUieoDw&callback=initMap"></script>



<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox_packed.js"></script>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">

<script language='javascript'>
function get_det()
{
initialize();
}

function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

  request.onreadystatechange = function() {
  
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request.responseText, request.status);
    }
  };
  
  var ulbid=$("#ulbid").val();
//   var uid=$("#uid").val();
 // var user_type=$("#user_type").val();
  var type=$("#type").val();
  var subtype=$("#subtype").val();
  var ulblat=$("#ulblat").val();
  var ulblng=$("#ulblng").val();
 
  
  
	  url=url+"?ulbid="+ulbid+"&type="+type+"&subtype="+subtype;
	  
	  
	 // url=url+"&proteected="+$("#proteected").val()+"&enrochment="+$("#enrochment").val();
	  request.open('GET', url, true);
	  request.send(null); 
  
}

function doNothing() {}



function initialize() {

    var mapOptions = {
        
        center: new google.maps.LatLng(17.413855, 78.578345),
        mapTypeId: google.maps.MapTypeId.HYBRID
    };
    
    var icons = [];
    
    
    
    var map = new google.maps.Map(document.getElementById('map-canvas'),  mapOptions);
    map.setZoom(10);
    var arr = new Array();
    var polygons = [];
    var bounds = new google.maps.LatLngBounds();
    
    var marker_array = [];
    var ibOptions_array = [];
    
    var infowindow_array = [];
    var img_str="";
     
    
    var midpoint_lat=0;
    var midpoint_lng=0;
     
  

     downloadUrl("geotagging-mapajax.php", function(data) {
         $(".works-found-number").text('0');
   
     var xmlString=data;
   
   
        var xml = xmlParse(xmlString);
        var subdivision = xml.getElementsByTagName("subdivision");
         
        for (var i = 0; i < subdivision.length; i++) {
            arr = [];
            
            midpoint_lat=0;
            midpoint_lng=0;
            
            var coordinates = xml.documentElement.getElementsByTagName("subdivision")[i].getElementsByTagName("coord");
            
            for (var j=0; j < coordinates.length; j++) {
            
              arr.push( new google.maps.LatLng(
                    parseFloat(coordinates[j].getAttribute("lat")),
                    parseFloat(coordinates[j].getAttribute("lng"))
              ));
              
              midpoint_lat+=parseFloat(coordinates[j].getAttribute("lat"));
              midpoint_lng+=parseFloat(coordinates[j].getAttribute("lng"));
                
               
             
              var marker = new google.maps.Marker({
                  
                position: new google.maps.LatLng(
                    parseFloat(coordinates[j].getAttribute("lat")),
                    parseFloat(coordinates[j].getAttribute("lng"))
              ),
                map: map,
                title: coordinates[j].getAttribute("lat")+'-'+coordinates[j].getAttribute("lng"),
                icon:{url:'images/marker_green.png'}
            });
            
             infowindow1= new google.maps.InfoWindow({
             content:coordinates[j].getAttribute("lat")+'-'+coordinates[j].getAttribute("lng") 
        });
        
         var x=xml.documentElement.getElementsByTagName("subdivision")[i].attributes;
	  var name=x.getNamedItem("name");
	
	  var work_name=x.getNamedItem("work_name");
	  var work_id=x.getNamedItem("work_id");
	  var total_works=x.getNamedItem("total_works");
	  
	   $(".works-found-number").text(total_works.value);
	  
	  
	  
	  var images = xml.documentElement.getElementsByTagName("subdivision")[i].getElementsByTagName("photo");
	    img_str_boundaries="<br><table align='center' border='1' style='font-size:13px; border-collapse:collapse;'><tr align='center' style='background-color:#3FC1C9; color:FFF; '><td style='padding:5px;' align='center'>Status-1</td><td align='center'>Status-2</td><td align='center'>Status-3</td></tr><tr>";
	    
	    for (var k=0; k <= j; k++)
            {
            	img_str_boundaries=img_str_boundaries+'<td><a href="'+images[k].getAttribute("link")+'" target="_new"><img src="'+images[k].getAttribute("link")+'" width="75" height="75" /></a></td>';
            }
            img_str_boundaries+="</tr></table><br>";
	  
	  
        
        var content=coordinates[j].getAttribute("lat")+'-'+coordinates[j].getAttribute("lng") + '<br><div class="slider">' + img_str_boundaries +'</div>' ;
           
          bindInfoWindow(marker, map, infowindow1, content);
            
            bounds.extend(arr[arr.length-1])
            
            }
            
            midpoint_lat=midpoint_lat/j;
            midpoint_lng=midpoint_lng/j;
            
            
            polygons.push(new google.maps.Polygon({
                paths: arr,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            }));
            polygons[polygons.length-1].setMap(map);
            
        /*  var x=xml.documentElement.getElementsByTagName("subdivision")[i].attributes;
	  var name=x.getNamedItem("name");
	
	  var work_name=x.getNamedItem("work_name");
	  var work_id=x.getNamedItem("work_id");*/
	  
	   
	    
	    
	    
	
	   
	   
	    var images = xml.documentElement.getElementsByTagName("subdivision")[i].getElementsByTagName("photo");
	    img_str="<br><table align='center' border='1' style='font-size:13px; border-collapse:collapse;'><tr align='center' style='background-color:#3FC1C9; color:FFF; '><td style='padding:5px;' align='center'>Status-1</td><td align='center'>Status-2</td><td align='center'>Status-3</td></tr><tr>";
	    
	    for (var k=0; k < images.length; k++)
            {
            	img_str=img_str+'<td><a href="'+images[k].getAttribute("link")+'" target="_new"><img src="'+images[k].getAttribute("link")+'" width="75" height="75" /></a></td>';
            }
            img_str+="</tr></table><br>";
            
             var check_list = xml.documentElement.getElementsByTagName("subdivision")[i].getElementsByTagName("check_list");
	    check_list_str="";
	    
	    for (var k=0; k < check_list.length; k++)
            {
            	check_list_str=check_list_str+check_list[k].getAttribute("f_desc")+'<br>';
            }
	   
            
	
	 var contentString = '<div id="content"><table border="1" style="border-collapse:collapse; font-size:13px;" class="table table-bordered"><tr><th width="20%" align="center" style="background-color:#3FC1C9; color:FFF;">Work ID:</th><td style="background-color:#FFF; color:333; padding:10px;">'+work_id.value+'</td></tr><tr><th width="20%" align="center" style="background-color:#3FC1C9; color:FFF;">Work Name:</th><td style="background-color:#FFF; color:333; padding:10px;">'+work_name.value+'</td></tr></table><div class="slider">'+img_str+'</div><div class="slider" >'+check_list_str+'</div></div>';
          
          infowindow_array[polygons.length-1]= new google.maps.InfoWindow({
             content:contentString 
        });
          
         
        
        marker_array[polygons.length-1]= new google.maps.Marker({
      position: new google.maps.LatLng(midpoint_lat,midpoint_lng),
      map: map,
      zoom:8
      //icon: 'https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png'
     
  });
        
       bindInfoWindow(marker_array[polygons.length-1], map, infowindow_array[polygons.length-1], contentString);
            
        }
        map.fitBounds(bounds);
  });
  
}

var prev_infowindow =false;


function bindInfoWindow(marker, map, infowindow, description) {
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(description);
        
        if( prev_infowindow ) {
           prev_infowindow.close();
        }

        prev_infowindow = infowindow;
        
        infowindow.open(map, marker);
    });
}


/**
 * Parses the given XML string and returns the parsed document in a
 * DOM data structure. This function will return an empty DOM node if
 * XML parsing is not supported in this browser.
 * @param {string} str XML string.
 * @return {Element|Document} DOM.
 */
function xmlParse(str) {
  if (typeof ActiveXObject != 'undefined' && typeof GetObject != 'undefined') {
    var doc = new ActiveXObject('Microsoft.XMLDOM');
    doc.loadXML(str);
    return doc;
  }

  if (typeof DOMParser != 'undefined') {
    return (new DOMParser()).parseFromString(str, 'text/xml');
  }

  return createElement('div', null);
}

google.maps.event.addDomListener(window, 'load', initialize);



</script>

{/literal}

<body style="margin:0; padding:0">
<div style="padding:10px; background-color:#257ad1; margin:0 auto; text-align:center; font-family:'Open Sans'; font-size:14px; color:#FFF;">
<div class="heading3"><strong >ULB : {$uid}</strong></div>
<div class="heading3"><strong >GEO TAGGING :: VIEW PLACES</strong></div>
<!--<strong><span class="works-found" style="color:#ffd96a;"> Total works : <span class="works-found-number"></span> </span></strong> -->





</div>

<div class="search" style="background-color:#FFF; box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); font-size:13px; height: 50px; padding-top: 9px;">
    
    
    <div class="form-horizontal">
        <div class="col-md-12">
      <label class="col-md-2 col-md-offset-1 control-label" for="textinput">Type</label>  
      <div class="col-md-2">
       <select class="form-control" name="type" required id="type">
                 <option value="">-select-</option>
              {foreach from=$geotagging  item=row}
				  <option value='{$row.Id}' {if ($row.Id)==($geotagging_slct)} selected  {/if}>{$row.Description}</option>
			 {/foreach}
		 </select>
      </div>
    
      <label class="col-md-2 control-label" for="textinput">Sub Type</label>  
      <div class="col-md-2">
        <select class="form-control" name="subtype" id="subtype">
    			 <option value="">-select-</option>
    				 {foreach from=$geotaggingsub  item=row}
				 <option value='{$row.Id}' {if ($row.Id)==($geotaggingsub_slct)} selected  {/if} >{$row.Description}</option>
				 	 {/foreach}
		 </select>
      </div>
   
    
    <div class="col-md-1"><input type="submit" class="btn btn-success" name="search" value="Search" onclick="get_det()"> </div>
    </div>
   </div>
    
    
   
    
    
    
   
    
</div>

<center>
<div class="fullwidth-form-container border">

<input type="hidden" id="ulbid" value="{$ulbid}">

<input type="hidden" id="ulblat" value="{$lat}">
<input type="hidden" id="ulblng" value="{$ulbid}">
<input type="hidden" id="uid" value="{*$uid*}">
<input type="hidden" id="user_type" value="{*$user_type*}">
<div id="map-canvas"></div>


</div>
</center>






{include file='footer.tpl'}
</body>