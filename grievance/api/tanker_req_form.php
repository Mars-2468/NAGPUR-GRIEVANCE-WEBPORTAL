<head>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
function get_streets(ward_id)
{
$.post('get_streets.php',{ward_id:ward_id,ulbid:'052'},function(data)
	{
	alert(data);
		$('#street_id').html(data);
	});
}
</script>
</head>

<form action="insert_tanker_req.php" method="POST">
req_name: <input type="text" name="req_name">
req_mobile: <input type="text" name="req_mobile">
req_address: <input type="text" name="req_address">
ward_id: <input type="text" name="ward_id"> 
street_id: <input type="text" name="street_id">
req_date: <input type="text" name="req_date">
req_time: <input type="text" name="req_time">
ulbid:<input type="text" name="ulbid">
<input type="submit" name="save" value="save">

</form>
<?php
require_once('../connection.php');
	$conn=getconnection();
$sql ="select ward_id,ward_desc from ward_mst where ulbid='052'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	$ward_list[$row['ward_id']]=$row['ward_desc'];
	}
	
?>

Know your service person

<select id="ward_id" name="ward_id" onchange="get_streets(this.value)">
<option value="0">--seleect---</option>
<?php
print_r($ward_list);
foreach($ward_list as $ward_id=>$ward_desc)
{
?>
<option value="<?php echo $ward_id; ?>"><?php echo $ward_desc; ?></option>
<?php
}
?>

</select>
<select id="street_id" name="street_id" >
</select>