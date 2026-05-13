<?php

/*function getDistance($addressFrom, $addressTo, $unit){
    //Change address format
    $formattedAddrFrom = str_replace(' ','+',$addressFrom);
    $formattedAddrTo = str_replace(' ','+',$addressTo);
    
    //Send request and receive json data
    $geocodeFrom = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false');
    $outputFrom = json_decode($geocodeFrom);
    $geocodeTo = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false');
    $outputTo = json_decode($geocodeTo);
    
    //Get latitude and longitude from geo data
    $latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
    $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
    $latitudeTo = $outputTo->results[0]->geometry->location->lat;
    $longitudeTo = $outputTo->results[0]->geometry->location->lng;
    
    //Calculate distance from latitude and longitude
    $theta = $longitudeFrom - $longitudeTo;
    $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    if ($unit == "K") {
        return ($miles * 1.609344).' km';
    } else if ($unit == "N") {
        return ($miles * 0.8684).' nm';
    } else {
        return $miles.' mi';
    }
}

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



$latitude = '17.4426963';
$longitude = '78.4636396';
$from_address = getAddress($latitude,$longitude);

$latitude = '18.105917';
$longitude = '78.838325';
echo $to_address = getAddress($latitude,$longitude);

$addressFrom = $from_address;
$addressTo = $to_address;

$from = "sr nagar,hyderabad";
$to = "kukatpalle,hyderabad";
$from = urlencode($from);
$to = urlencode($to);
$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
$data = json_decode($data);
$time = 0;
$distance = 0;
foreach($data->rows[0]->elements as $road) {
    $time += $road->duration->value;
    $distance += $road->distance->value;
}
echo "To: ".$data->destination_addresses[0];
echo "<br/>";
echo "From: ".$data->origin_addresses[0];
echo "<br/>";
echo "Time: ".$time." seconds";
echo "<br/>";
echo "Distance: ".$distance." meters";
echo $time_h=number_format($time/3600,2);
        echo "<br>";
?>*/



               /* $geocodeFrom = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=Adilabad&sensor=false');
                    $outputFrom = json_decode($geocodeFrom);
                    $latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
                    $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
				    
				    
				    
				    $ch = curl_init();
                    $data = array(
                        'vendor_name' => 'Adilabad', 
                        'access_key' => 'l10avdkw',
                        'mobileNumber'=>'9154644586',
                        'categoryId'=>'1',
                        'complaintLatitude'=>$latitudeFrom,
                        'complaintLongitude'=>$longitudeFrom,
                        'complaintLocation'=>'Adilabad',
                        'complaintLandmark'=>'Adilabad',
                        'fullName'=>'testing api',
                        'userLatitude'=>$latitudeFrom,
                        'userLongitude'=>$longitudeFrom,
                        'userLocation'=>'Adilabad',
                        'deviceOs'=>'external',
                        'file'=>'',
                        'complaintPostedDate'=>date("Y-m-d h:i:sa"));
                        
                        
                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/sbm/v1/post-complaint');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    
                    $output=curl_exec($ch);
                    $arr=json_decode($output,TRUE);
                    print_r($arr);*/
                    
                    $ch = curl_init();
                    $data = array(
                        'statusId'=>'3',
                        'complaintId'=>'1877785',
                        'commentDescription'=>'Assigned to engineer',
                        'deviceOs'=>'external',
                        'vendor_name' => 'Adilabad',
                        'access_key' => 'l10avdkw',
                        'apiKey'=>'493439434yiihfhdsfidsf'
                        );
                        
                        
                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/engineer/v1/complaint-status-update');
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $arr=json_decode($output,TRUE);
                    print_r($arr);





?>


