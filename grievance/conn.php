<?php
//create a mysql connection 
$con=mysqli_connect("localhost","root", "", 'nmccsms');// we have used db name test you can change your db name
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
