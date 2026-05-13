<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	date_default_timezone_set('Asia/Calcutta');
	
	if(isset($_SESSION['uid']))
	{
	
		require_once('connection.php');
		$conn=getconnection();
		
	    $sql ="select ulbid from ulbmst where ulbname='".$_SESSION['uid']."'";
	    $rs = mysqli_query($conn,$sql);
	    $row = mysqli_fetch_assoc($rs);
	     $tpl->assign('lat',$row['lat']);
	     $tpl->assign('lng',$row['lng']);
	   
	    
	    $tpl->assign('user_type',$_SESSION['user_type']);
	    $tpl->assign('ulbid',$row['ulbid']);
	    
	     $sql="select * from geotagging_cat_mst where ParentId=0";
           	 $rs=mysqli_query($conn,$sql);
          
            	while($row = mysqli_fetch_assoc($rs))
	     	{
		    	$geotagginglist[]=array('Id'=>$row['Id'],'Description'=>$row['Description']);
		    	
		    	
		    }
		     $sqlsub="select * from geotagging_cat_mst where ParentId=1";
           	 $rssub=mysqli_query($conn,$sqlsub);
           	 	while($rows = mysqli_fetch_assoc($rssub))
            {
		    	$geotaggingsublist[]=array('Id'=>$rows['Id'],'Description'=>$rows['Description']);
		    }           
                    
		$tpl->assign('grant_type',array('1'=>'Basic grants','2'=>'Performance grants'));
	    $tpl->assign('geotagging',$geotagginglist);
		$tpl->assign('geotaggingsub',$geotaggingsublist);
		$tpl->assign('geotagging_slct',1);
		$tpl->assign('geotaggingsub_slct',4);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('type_list',$type_list);
		$tpl->assign('data',$data);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('geotagging-map.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>