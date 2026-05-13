<?php
	session_start();
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	$response=array();
	
	if($_REQUEST['ulbid'])
	{
            	     $sql="select ulbid,ulbname,ulb_type_desc from ulbmst u,ulb_type ut where u.ulb_type=ut.ulb_type_id and u.ulbid = '".$_REQUEST['ulbid']."' ";
            	    $rs = mysqli_query($conn,$sql);
            	    
            	   
            	   $nr= mysqli_num_rows($rs);
            	   if($nr > 0)
            	   {
            	       $row = mysqli_fetch_assoc($rs);
            	       $ulbname=$row['ulbname']." ".$row['ulb_type_desc'];
            	       $ulbid=$row['ulbid'];
            	       
            	       ##get weblinks
            	       $web_links = "select * from AppWebLinks";
            	       $result = mysqli_query($conn,$web_links);
            	        $items = array();
                        foreach($result as $value) {
                         $items[] = (object) array('cat_id' => $value['awl_id'], 'cat_dsc' => $value['discription'], 'link' => $value['link']);
                        }
            	       
            	       $data=array('status_code'=>'200','message'=>'success','ulbname'=>$ulbname,'ulbid'=>$ulbid,'final_data' => $items);
            	       
            	       
            	       
            	        
            	   }
            	   else
            	   {
            	       $data=array('status_code'=>'100','message'=>'fail');
            	       
            	   }
            	   
            	    
            	    
            	
            	$indexedOnly = array();
            
            foreach ($data as $row) {
                $indexedOnly[] = array_values($row);
            }
}
else
{
    $data=array('status_code'=>'100','message'=>'fail');
}

echo json_encode($data);

mysqli_close($conn);


?>