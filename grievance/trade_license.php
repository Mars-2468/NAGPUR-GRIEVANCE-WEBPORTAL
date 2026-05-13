<?php
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',1);
phpinfo();

		
		//require_once('connection.php');
		//$conn=getconnection();
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://epaycdma.telangana.gov.in:8081/Tradeapplication/tradeDashboardCMS.do');
		//curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output=curl_exec($ch);
        
        if (curl_error($ch)) 
        {
            echo $error_msg = curl_error($ch);
        }
        
        print_r($output);
		
		
		
		
		
	/*	
	
	    $curl_h = curl_init('http://epaycdma.telangana.gov.in:8081/Tradeapplication/tradeDashboardCMS.do');
	    
		echo 'njmfr';
	    curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
	    echo $response = curl_exec($curl_h);
	    print_r($response);
	
        $response = json_decode($response, true);
        $response=json_decode($response['data'], true);
        	
        
    */

	
	$sql ="insert into trade_license(
	    Total_Application,
	    Certificate_issued,
	    Application_underprocess,
	    Application_rejected,
	    Application_beyond15days
	    
	    )values(
	    
	    
	    
	        )";
	       
	    

?>
                            
                            
                            
                            
                            
                            