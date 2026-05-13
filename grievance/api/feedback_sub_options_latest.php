<?php
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	
	if($_REQUEST['feedback_id']==1 || $_REQUEST['feedback_id']==2 || $_REQUEST['feedback_id']==3)
	{
	    //$feedback_sublist[0]="--select--";
	    $sql ="select * from feedback_sub_options";
	    $rs = mysqli_query($conn,$sql);
	    $feedback_sublist=array('status_code'=>200,'message'=>'success');
	    $feedback_sublist['data']=array();
	    
	    $distic['sub_option_id']=0;
		$distic['description']='--select--';
			
		array_push($feedback_sublist['data'], $distic);
	    while($row= mysqli_fetch_assoc($rs))
	    {
	        //$feedback_sublist[$row['sub_option_id']]=$row['description'];
	      
	       $distic['sub_option_id']=$row['sub_option_id'];
		   $distic['description']=$row['description'];
			
			array_push($feedback_sublist['data'], $distic);
	    }
	}
	else
	{
	    $feedback_sublist=array('status_code'=>100,'message'=>'faile');
	     $feedback_sublist['data']=array();
	    $distic['sub_option_id']="0";
		$distic['description']="--select--";
		array_push($feedback_sublist['data'], $distic);
	}
	
	

	

		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($feedback_sublist);
mysqli_close($conn);



?>