<?php
ini_set('display_errors',1);
echo $url ="https://vmaxindia.com/images/cdma.jpg";

grab_image($url,'testimages');
function grab_image($url,$saveto){
    
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    
    
    
    if (curl_errno($ch)) {
    echo $error_msg = curl_error($ch);
}
else
{
    echo "fine";
}
    
    
    curl_close ($ch);
   /* echo $saveto;
    if(file_exists($saveto)){
        unlink($saveto);
    }*/
    $fp = fopen('testimages','w');
    fwrite($fp, $raw);
    fclose($fp);
}

?>