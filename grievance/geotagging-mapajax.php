<?php
require "config.php";
	ini_set('display_errors',0);
	
	if(isset($_SESSION['uid']))
	{
		require_once('connection.php');
		$conn=getconnection();
           echo  $_REQUEST['type'];
	               $sqlHhlData="SELECT tb1.*,tb3.ward_desc,tb2.desc FROM `HhlData` tb1 join geotagging_cat_dropdown tb2 on tb1.YesOrNoValue=tb2.id  join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_SESSION['uid']."'   ORDER BY tb1.Id DESC";
                   $rsHhlData=mysqli_query($conn,$sqlHhlData);
                   	if(mysqli_num_rows($rsHhlData)>0)
                		{
                			while($row = mysqli_fetch_assoc($rsHhlData))
                			{
                				$data[$row['Id']]['ResidentName']=$row['ResidentName'];
                		   	    $data[$row['Id']]['Area']=$row['Area'];
                		   	    $data[$row['Id']]['ward_desc']=$row['ward_desc'];
                		   	    $data[$row['Id']]['latitude']=$row['latitude'];
                		   	    $data[$row['Id']]['longitude']=$row['longitude'];
                				
                			}
                		}
		
                 
	 print_r($data);die;
		
		$xml= '<subdivisions>';
		

		foreach($data as $key=>$row)
		{
			   
			$xml.= '<subdivision id="'.$key.'" ResidentName="'.htmlspecialchars($row['ResidentName']).'" Area="'.htmlspecialchars($row['Area']).'" ward_desc="'.$row['ward_desc'].'" >';
			
		//	foreach($data1[$place_ID] as $sno=>$row1)
				$xml.='<coord lat="'.$row['latitude'].'" lng="'.$row['longitude'].'"/>';
				
// 			if(isset($images[$place_ID]))
// 			{
// 				foreach($images[$place_ID] as $i=>$link)
// 					$xml.='<photo link="'.$link.'"/>';
// 			}
// 			if(isset($check_list_map[$place_ID]))
// 			{
// 				foreach($check_list_map[$place_ID] as $i=>$f_desc)
// 					$xml.='<check_list f_desc="'.$f_desc.'"/>';
// 			}
			$xml.= '</subdivision>';
			}
	 
		$xml.= '</subdivisions>';
		
		echo $xml;
		
		
		


	}

?>