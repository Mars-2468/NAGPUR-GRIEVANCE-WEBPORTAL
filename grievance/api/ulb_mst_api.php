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
            	       $ulb_mst = "select ulbcode,ulbname from ulbmst_api";
            	       $result = mysqli_query($conn,$ulb_mst);
            	        $extra = array('ulb_id'=>'1','ulb_name'=>'--Select Municipality--');
            	        $items = array();
                        foreach($result as $key=>$value) {
                            if($key == '0')
                            {
                                $items[] = (object) array('ulb_id'=>'1','ulb_name'=>'--Select Municipality--');
                            }
                            $items[] = (object) array('ulb_id'=>$value['ulbcode'],'ulb_name' =>$value['ulbname']);
                        }
            	       //$final[] = array_push($extra,$items);
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









