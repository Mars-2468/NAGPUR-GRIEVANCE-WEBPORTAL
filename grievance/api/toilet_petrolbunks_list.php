<?php
	error_reporting(0);
require_once('../connection.php');
	$conn=getconnection();
//$lat=$_REQUEST['lat'];
//$lng=$_REQUEST['lng'];

$lat='18.105917';
$lat='78.838325';

 $sql="SELECT id,lat,lng,location,( 3959 * acos( cos( radians(".$lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$lng.") ) + sin( radians(".$lat.") ) * sin( radians( lat ) ) ) ) AS distance FROM petrol_toilets_latlngs where cat_type='".$_REQUEST['cat_type_id']."' HAVING distance < 2000 ORDER BY distance LIMIT 0 , 50";
$rs = mysqli_query($conn,$sql);

if(mysqli_num_rows($rs) > 0)
{
	while($row = mysqli_fetch_assoc($rs))
	{
	   
		$data[]=array('id'=>$row['id'],'lat'=>$row['lat'],'lng'=>$row['lng'],'location'=>$row['location'],'distance'=>$row['distance']);
	}
}
else
{
	$data[0] = array('status'=>'1','status_desc'=>'Records fount');
}



echo json_encode($data);
mysqli_close($conn);
?>