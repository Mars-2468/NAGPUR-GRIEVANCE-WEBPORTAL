<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET names=utf8');
mysqli_query($conn,'SET character_set_client=utf8');
mysqli_query($conn,'SET character_set_connection=utf8');
mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET collation_connection=utf8_general_ci');

$langId=$_REQUEST['lang_id'];
	
	 $sql="select e.edition_no,e.edition_no_marathi, e.edition_date, e1.img_url, e1.description from add_edition e, add_content e1 where e.edition_no = e1.edition_no and e1.ulbid='".$_REQUEST['ulbid']."' group by edition_no order by edition_date DESC";
	
	if($rs=mysqli_query($conn,$sql))
	{
		$i=1;
		while($row = mysqli_fetch_assoc($rs))
		{
		    if($langId==1){
			$data[]=array('sno'=>$i,'content_no'=>$row['edition_no'],'title'=>$row['description'],'edition_date'=>date("d-m-Y",strtotime($row['edition_date'])),'file_url'=>'http://egovmars.in/csms/'.$row['img_url']);
		    }else{
		    $data[]=array('sno'=>$i,'content_no'=>$row['edition_no_marathi'],'title'=>$row['description_marathi'],'edition_date'=>date("d-m-Y",strtotime($row['edition_date'])),'file_url'=>'http://egovmars.in/csms/'.$row['img_url']);    
		    }
			$i++;
		}
	}
	else
	 $data[0] = array('sno'=>'1','content_no'=>'0','edition_date'=>'No Data Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>