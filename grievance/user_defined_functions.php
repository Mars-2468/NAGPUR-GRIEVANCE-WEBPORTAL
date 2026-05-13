<?php
// session_start();
$csrf_prefix_token = "12345";
function generateToken( $formName ) 
{
    $secretKey = 'gsfhs154aergz2#';
    
    $sessionId = session_id();
    $sessionId="12345";

    return sha1( $formName.$sessionId.$secretKey );

}

function checkToken( $token, $formName ) 
{
   
    return $token === generateToken( $formName );
}

?>