<?php
	error_reporting(0);
require_once('connection.php');

$sql ="select * from cs_mst c, category_mst cm where c.cat_id=cm.cat_id";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    echo $sql ="insert into complaint_ulbmap(cs_id,cat_id,flag,ulbid,cs_type_id)values('".$row['cs_id']."','".$row['cat_id']."','1','1')";
    echo "<br>";
}
?>