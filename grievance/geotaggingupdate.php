<?php 
require "config.php";
require_once('connection.php');
$conn=getconnection();


   
if(isset($_POST))
	{
	
	if($_POST['Type']=='4' && $_POST['Area']!=''){
	 $sql="UPDATE HhlData SET HHno= '".$_POST['HHno']."', Area= '".$_POST['Area']."' , MobileNo= '".$_POST['MobileNo']."' WHERE Id='".$_POST['id']."'"; 
	  $rssub=mysqli_query($conn,$sql);
	  if($rssub)
		{
		echo ("<script LANGUAGE='JavaScript'>
                window.alert('Succesfully Updated');
                window.location.href='geotagging-report.php';
                </script>");
		}
		else
		{
	
			echo ("<script LANGUAGE='JavaScript'>
                window.alert('Unable to update, Try again');
                window.location.href='geotagging-report.php';
                </script>");
		}
	}
	if($_POST['Type']=='56'  && $_POST['Area']!=''){
	  $sql="UPDATE public_community_other_toilets SET  Area= '".$_POST['Area']."' WHERE Id='".$_POST['id']."'"; 
	  $rssub=mysqli_query($conn,$sql);
	  if($rssub)
		{
		echo ("<script LANGUAGE='JavaScript'>
                window.alert('Succesfully Updated');
                window.location.href='geotagging-report.php';
                </script>");
		}
		else
		{
		echo ("<script LANGUAGE='JavaScript'>
                window.alert('Unable to update, Try again');
                window.location.href='geotagging-report.php';
                </script>");
		}
   
	}
	if($_POST['Type']=='2'  && $_POST['Area']!=''){
	 $sql="UPDATE MHolesMst SET Area= '".$_POST['Area']."' , SewerLineLength= '".$_POST['Length']."' WHERE Id='".$_POST['id']."'"; 
	  $rssub=mysqli_query($conn,$sql);
	  if($rssub)
		{
		echo ("<script LANGUAGE='JavaScript'>
                window.alert('Succesfully Updated');
                window.location.href='geotagging-report.php';
                </script>");
		}
		else
		{
			echo ("<script LANGUAGE='JavaScript'>
                window.alert('Unable to update, Try again');
                window.location.href='geotagging-report.php';
                </script>");
		}
    
	}
	if($_POST['Type']=='3'  && $_POST['Area']!=''){
	  $sql="UPDATE 	IECHoardings SET   Area= '".$_POST['Area']."'  WHERE Id='".$_POST['id']."'"; 
	  $rssub=mysqli_query($conn,$sql);
	  if($rssub)
		{
	echo ("<script LANGUAGE='JavaScript'>
                window.alert('Succesfully Updated');
                window.location.href='geotagging-report.php';
                </script>");
		}
		else
		{
			echo ("<script LANGUAGE='JavaScript'>
                window.alert('Unable to update, Try again');
                window.location.href='geotagging-report.php';
                </script>");
		}
   
	}
        
	
}else{
    	echo ("<script LANGUAGE='JavaScript'>
                window.alert('No data to update, Try again');
                window.location.href='geotagging-report.php';
                </script>");
}
?> 