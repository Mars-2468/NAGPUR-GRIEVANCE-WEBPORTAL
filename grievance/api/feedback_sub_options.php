<?php
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();

	//$apk_version = $_REQUEST['apk_version'];
	//require_once('check_version.php');

	
	if($_REQUEST['feedback_id']==1 || $_REQUEST['feedback_id']==2 || $_REQUEST['feedback_id']==3)
	{
	    //$feedback_sublist[0]="--select--";
	    $sql ="select * from feedback_sub_options";
	    $rs = mysqli_query($conn,$sql);
	    $feedback_sublist=array();
	    $distic['sub_option_id']="0";
		$distic['description']='--select--';
			
			array_push($feedback_sublist, $distic);
	    while($row= mysqli_fetch_assoc($rs))
	    {
	       // $feedback_sublist[$row['sub_option_id']]=$row['description'];
	      
	       $distic['sub_option_id']=$row['sub_option_id'];
		   $distic['description']=$row['description'];
			
			array_push($feedback_sublist, $distic);
	    }
	}
	else
	{
	   $distic['sub_option_id']="0";
		$distic['description']="--select--";
		array_push($feedback_sublist, $distic);
	}
	
	

	

		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($feedback_sublist);
mysqli_close($conn);



?>