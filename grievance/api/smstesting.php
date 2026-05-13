<?php
/*$password = md5('Cdmats@4321');
      $ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://msdgweb.mgov.gov.in/esms/sendsmsrequest");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "mobileno=9154644586&senderid=TSMCPL&content=hi&smsservicetype=singlemsg&username=cdmatelangana&password=Cdmats@4321&key=65ff1daa-95e8-49b5-a954-1a41a9bfabb3");

// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
print_r($server_output);


curl_close ($ch);*/
error_reporting(0);
function post_to_url($url, $data) {
    $fields = '';
    foreach($data as $key => $value) {
    $fields .= $key . '=' . $value . '&';
    }
    rtrim($fields, '&');
    $post = curl_init();
    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($post, CURLOPT_URL, $url);
    curl_setopt($post, CURLOPT_POST, count($data));
    curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($post); //result from mobile seva server
    echo $result; //output from server displayed
    curl_close($post);
}

$username="cdmatelangana";
$encryp_password =sha1(trim('Cdmats@4321'));
$senderid = "TSMCPL";
$message="hi";
$mobileno="9490371209";
$deptSecureKey="65ff1daa-95e8-49b5-a954-1a41a9bfabb3";
$key=hash('sha512',trim($username).trim($senderid).trim($message).trim($deptSecureKey));
$data = array(
"username" => trim($username),
"password" => trim($encryp_password),
"senderid" => trim($senderid),
"content" => trim($message),
"smsservicetype" =>"singlemsg",
"mobileno" =>trim($mobileno),
"key" => trim($key)
);
post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
//calling post_to_url to send otp sms






?>