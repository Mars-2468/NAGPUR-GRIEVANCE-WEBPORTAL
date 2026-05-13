<?php
ini_set('display_errors',0);
require_once('../connection.php');
date_default_timezone_set('Asia/Calcutta');
	$conn=getconnection();
$lat_prev=$_REQUEST['lat'];
$lng_prev=$_REQUEST['lng'];

function getAddress($latitude,$longitude){
    if(!empty($latitude) && !empty($longitude)){
        //Send request and receive json data by address
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyAm9ekbF8SnmFeUH4BvEffHYu_TuUieoDw'); 
        $output = json_decode($geocodeFromLatLong,true);
        $from_address = $output['results']['0']['formatted_address'];
        
      
        
        if(!empty($from_address)){
            return $from_address;
        }else{
            return false;
        }
    }else{
        return false;   
    }
}



function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
     $theta = $longitude1 - $longitude2;
     $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
     $distance = acos($distance);
     $distance = rad2deg($distance);
     $distance = $distance * 60 * 1.1515;
     $distance = $distance * 1.609344;
     return (round($distance,2));
}

/* function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
	// Calculate the distance in degrees
	$degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
 
	// Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
	switch($unit) {
		case 'km':
			$distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
			break;
		case 'mi':
			$distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
			break;
		case 'nmi':
			$distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
	}
	return round($distance, $decimals);
} */





//$lat='18.105917';
//$lng='78.838325';

$type_list=array('1'=>'Public Toilets','2'=>'She Toilets','3'=>'Community Toilets');

 //$sql="SELECT id,lat,lng,location,file_url,toilet_type,( 3959 * acos( cos( radians(".$lat_prev.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$lng_prev.") ) + sin( radians(".$lat.") ) * sin( radians( lat ) ) ) ) AS distance FROM petrol_toilets_latlngs where cat_type='".$_REQUEST['cat_type_id']."' and ulbid='".$_REQUEST['ulbid']."' HAVING distance < 2000 ORDER BY distance LIMIT 0 , 50";
  $sql="SELECT id,lat,lng,location,file_url,toilet_type FROM petrol_toilets_latlngs where cat_type='".$_REQUEST['cat_type_id']."' and ulbid='".$_REQUEST['ulbid']."'";
$rs = mysqli_query($conn,$sql);

if(mysqli_num_rows($rs) > 0)
{
	while($row = mysqli_fetch_assoc($rs))
	{
	    
	    /*$from_address = getAddress($lat_prev,$lng_prev);
	    $to_address = getAddress($row['lat'],$row['lng']);
	    
	    $from = $from_address;
        $to = $to_address;
        $from = urlencode($from);
        $to = urlencode($to);
        $output = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
        $output = json_decode($output);
        $time = 0;
        $distance = 0;
        foreach($output->rows[0]->elements as $road) {
            $time += $road->duration->value;
            $distance += $road->distance->value;
        }
        
       // $tot_dist_km=number_format($distance/1000,2);*/
        
        
	    
	    
	    
	    
	    $tot_dist_km=getDistanceBetweenPointsNew($row['lat'], $row['lng'],$lat_prev, $lng_prev);
	   $type=$type_list[$row['toilet_type']];
		$data[]=array('id'=>$row['id'],'lat'=>$row['lat'],'lng'=>$row['lng'],'location'=>$row['location'],'distance'=>$tot_dist_km.' Km','file_url'=>$row['file_url'],'type'=>$type,'Link'=>'https://www.google.co.in/maps/place/'.$row['lat'].','.$row['lng']);
	}
}
else
{
	$data[0] = array('status'=>'1','status_desc'=>'Records fount');
}



echo json_encode($data);
mysqli_close($conn);

?>