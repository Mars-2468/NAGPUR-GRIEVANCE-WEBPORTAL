<?php
// Get the zone_id from the client-side request
$zone_id = $_GET['zone_id'];

// Set the API endpoint URL
$api_url = 'https://114.79.182.180/grievance/api/get_zone_details.php';

// Set the request headers
$headers = [
    'Content-Type: application/x-www-form-urlencoded'
];

// Set the request body parameters
$params = http_build_query([
    'ulbid' => '250',
    'access_key' => '123456789qwerty',
    'zone_id' => $zone_id
]);

// Initialize cURL
$curl = curl_init();

// Set the cURL options
curl_setopt_array($curl, [
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_HTTPHEADER => $headers
]);

// Execute the cURL request
$response = curl_exec($curl);

// Close cURL
curl_close($curl);

// Return the API response to the client
echo $response;
?>
