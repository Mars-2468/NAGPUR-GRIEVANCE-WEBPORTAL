<?php 
	
function post_to_url($url, $data) 
{
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
    //echo $result; //output from server displayed
    curl_close($post);
}
function send_sms($message,$mobile,$templateId)
{
    
    
                $user_mobile = $mobile;
				$message =str_replace ( ' ', '%20', $message);
				$url ="https://manage.smssolutions.in/smsapi/index?key=35FD85B7BD7DA4&campaign=0&routeid=19&type=text&contacts=".$user_mobile."&senderid=TSMCPL&msg=".$message;
				
				
				$post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_POST, count($data));
                    curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post); //result from mobile seva server
                    
                    //output from server displayed
                    curl_close($post);
    
    
/*$username="cdmatelangana";
$encryp_password =sha1(trim('Cdmats@4321'));
$senderid = "TSMCPL";
$message=$message;
$mobileno=trim($mobile);
$deptSecureKey="65ff1daa-95e8-49b5-a954-1a41a9bfabb3";
$key=hash('sha512',trim($username).trim($senderid).trim($message).trim($deptSecureKey));
$data = array(
"username" => trim($username),
"password" => trim($encryp_password),
"senderid" => trim($senderid),
"content" => trim($message),
"smsservicetype" =>"singlemsg",
"mobileno" =>trim($mobileno),
"key" => trim($key),
'templateid' => $templateId
);
post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequestDLT",$data);*/
		
}
?> 