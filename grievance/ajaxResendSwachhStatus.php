<?php
    
require "config.php";
	ini_set('display_errors',0);
	if(isset($_REQUEST['grievance_id']))
	{
	    
	    include('user_defined_functions.php');
		
		require_once('connection.php');
	    $conn=getconnection();
	    
	        $grievance_id = $_REQUEST['grievance_id'];
	        $sql ="select u.api_ulbname,u.access_key,u.ulbname,g.app_type_id,c.swatchta_app_status_yn,c.swapp_cat_id,g.generic_id from ulbmst u, grievances g,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_id='".$grievance_id."'";
		    $rs =mysqli_query($conn,$sql);
		    $row = mysqli_fetch_assoc($rs);
		    $vendor_name=$row['api_ulbname'];
		    $accessKey = $row['access_key'];
		    $app_type_id1=$row['app_type_id'];
		    $swatchta_app_status_yn=$row['swatchta_app_status_yn'];
		    $swapp_cat_id=$row['swapp_cat_id'];
		    $generic_id=$row['generic_id'];
		    $newarray=explode('C',$row['generic_id']);
            $complaint_id=$newarray[1];
	        $status_id=4;
	        $remarks = "Completed";
	    
	    
	    
			    
                			    if($status_id==4 || $status_id==6)
                			    {
                			        
                			       
                			        
                			        $ch = curl_init();
                                    $data = array(
                                        'statusId'=>$status_id,
                                        'complaintId'=>$complaint_id,
                                        'commentDescription'=>$remarks,
                                        'deviceOs'=>'external',
                                        'vendor_name' => $vendor_name,
                                        'access_key' => $accessKey,
                                        'apiKey'=>'af4e61d75d2782a33eac7641e42bba6f'
                                        );
                                        
                                        
                                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/engineer/v1/complaint-status-update');
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                                    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $output=curl_exec($ch);
                                    
                                    
                                    
                                    $arr=json_decode($output,TRUE);
                                    $sql ="update grievances_transactions set http_code='".$arr['httpCode']."',code='".$arr['code']."',id='".$arr['complaint']['id']."' where grievance_id='".strip_tags($grievance_id)."'";
                                    mysqli_query($conn,$sql);
                                    
                                    
                                    if($arr['httpCode']==200 && $arr['code']==2000)
                                        {
                                            
                                            $sql="insert into swatchata_comp_status_map(generic_id,status_id,complaint_id)values('".$generic_id."','".$status_id."','".$arr['complaint']['id']."')";
                                            mysqli_query($conn,$sql);
                                            $sql ="update grievances set swatchta_app_status='".$status_id."' where grievance_id='".$grievance_id."'";
                                            mysqli_query($conn,$sql);
                                            echo 1;
                                        }
                                        else
                                        {
                                            echo 0;
                                        }
                			    
                			    
                			    }
			    
				    
		
		
		
	       
	      
	}
?>