<?php
	

	  date_default_timezone_set('Asia/Calcutta');
	

            				    $ch = curl_init();
                                $data = array(
                                    
                                    'deviceOs'=>'external',
                                    'vendor_name' => 'Bhainsa',
                                    'access_key' => 'z5h0c29o',
                                    'mobileNumber'=>'9133444252',
                                    'apiKey'=>'af4e61d75d2782a33eac7641e42bba6f',
                                    'lang'=>'en',
                                    'userCreatedDate'=>date("Y-m-d h:i:sa"),
                                    'macAddress'=>'00-B0-00-00-00-00-00-0E'
                                    );
                                    
                                    
                                curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/sbm/v1/user');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output=curl_exec($ch);
                                
                                print_r($output);
                                
            					
			
			
			
			
			
			
			
				
				
				
				
			
				
				
			
	
	

?>