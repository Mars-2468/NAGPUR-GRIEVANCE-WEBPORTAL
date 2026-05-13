<?php
//require_once('./../connection.php');
$conn= mysqli_connect("localhost", "root", "", 'biometri_regulation');
$sql ="select * from ulbmst";
$rs = mysqli_query($conn,$sql);
?>