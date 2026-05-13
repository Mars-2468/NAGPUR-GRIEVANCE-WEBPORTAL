<?php
ini_set('display_errors',0);
date_default_timezone_set('Asia/Calcutta');
function getdata($url)
{
                            $ch = curl_init();    
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                            //curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                            //curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $output=curl_exec($ch);
                            
                           
                            if (curl_error($ch)) {
                                        $error_msg = curl_error($ch);
                                    } 
                                    
                                    return $output;
}



	                        
	                        
                            require_once('connection.php');
                            $conn=getconnection();
                            // Assement of property tax
                            
                            $url="http://125.18.179.57:8081/Taxcal/getRestDashboardCMS.do";
                            $output=getdata($url);
                            $output=json_decode($output,true);
                            $sql ="update external_service_statistics set 
                            
                             	total_applications='".$output['Total Assessment']."',
                             	 	approved='".$output['Application_Approved']."',
                             	 	under_rori_login='".$output['Under RO/RI Login']."',
                             	 	beyond_15_days='".$output['Application_beyond15days']."',
                             	 	under_comm_login='".$output['Under Commissioner Login']."',
                             	 	rejected='".$output['Application_Rejected']."' where cs_id='1'";
                             	mysqli_query($conn,$sql);
                             	
                             	// vacant land tax
                             	
                             	$url="http://125.18.179.57:8081/VLTTaxcal/getRestDashboardCMS.do";
                                $output=getdata($url);
                                $output=json_decode($output,true);
                                
                                
                                $sql ="update external_service_statistics set 
                            
                             	total_applications='".$output['Total Assessment']."',
                             	 	approved='".$output['Application_Approved']."',
                             	 	under_rori_login='".$output['Under RO/RI Login']."',
                             	 	beyond_15_days='".$output['Application_beyond15days']."',
                             	 	under_comm_login='".$output['Under Commissioner Login']."',
                             	 	rejected='".$output['Application_Rejected']."' where cs_id='6'";
                             	mysqli_query($conn,$sql);
                             	
                             	// Trade Renewal
                             	
                             	$url="http://epaycdma.telangana.gov.in:8081/Tradeapplication/tradeRestDashboardRenewalCMS.do";
                                $output=getdata($url);
                                $output=json_decode($output,true);
                                
                                
                                $sql ="update external_service_statistics set 
                            
                             	total_applications='".$output['Total_Application']."',
                             	 	approved='".$output['Certificate_issued']."',
                             	 	under_rori_login='".$output['Under RO/RI Login']."',
                             	 	beyond_15_days='".$output['Application_beyond15days']."',
                             	 	under_comm_login='".$output['Under Commissioner Login']."',
                             	 	rejected='".$output['Application_rejected']."',
                             	 	under_progress='".$output['Application_underprocess']."' where cs_id='18'";
                             	mysqli_query($conn,$sql);
                             	
                             	// sanction and disposal of trade linces
                             	
                             	$url="http://epaycdma.telangana.gov.in:8081/Tradeapplication/tradeDashboardMob.do";
                             	 $output=getdata($url);
                                $output=json_decode($output,true);
                                
                                
                                $sql ="update external_service_statistics set 
                            
                             	total_applications='".$output['Total_Application']."',
                             	 	approved='".$output['Certificate_issued']."',
                             	 	under_rori_login='".$output['Under RO/RI Login']."',
                             	 	beyond_15_days='".$output['Application_beyond15days']."',
                             	 	under_comm_login='".$output['Under Commissioner Login']."',
                             	 	rejected='".$output['Application_rejected']."',
                             	 	under_progress='".$output['Application_underprocess']."' where cs_id='14'";
                             	mysqli_query($conn,$sql);
                             	
                             	// water tap connection
                             	
                             	$url="http://epaycdma.telangana.gov.in:8081/Tradeapplication/waterTapDashboardRestCMS.do";
                             	 $output=getdata($url);
                                $output=json_decode($output,true);
                                
                                
                                $sql ="update external_service_statistics set 
                            
                             	total_applications='".$output['WaterTap Applications Received']."',
                             	 	approved='".$output['WaterTap Connections Issued']."',
                             	 	under_ae_me_login='".$output['WaterTap Applications Under AE/ME Login']."',
                             	 	beyond_15_days='".$output['WaterTap Applications Beyond 15 days']."',
                             	 	under_comm_login='".$output['WaterTap Applications Under Commissioner Login']."',
                             	 	rejected='".$output['WaterTap Applications Rejected']."',
                             	 	under_chairperson_login='".$output['WaterTap Applications Under Chair Person Login']."' where cs_id='7'";
                             	mysqli_query($conn,$sql);
                             	
                             	
                             	
                             	
                             	
                             	
                             	
                             	
                             	 	
                             	 	
?>