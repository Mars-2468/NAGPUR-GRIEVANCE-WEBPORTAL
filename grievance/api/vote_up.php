<?php

	error_reporting(0);
	
	$ch = curl_init();
                    $data = array(
                        'vendor_name' => 'Adilabad', 
                        'access_key' => 'l10avdkw',
                        'mobileNumber'=>'9154644586',
                        'complaintId'=>'1884343',
                        'deviceToken'=>'r838idfdfddfugfgd',
                        'deviceOs'=>'Android'
                        );
                        
                        
                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/sbm/v1/post-voteup');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output=curl_exec($ch);
                    $arr=json_decode($output,TRUE);
                    print_r($arr);
	




?>