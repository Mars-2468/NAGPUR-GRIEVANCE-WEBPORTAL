<?php
	ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');
//	ECHO "asa";die;
     $sqlMST = "SELECT * FROM IECHoardings";
     $resultMST = mysqli_query($conn,$sqlMST);
              if (mysqli_num_rows($resultMST) >  0) {
                  // output data of each row
                 while($rowMST = mysqli_fetch_assoc($resultMST)) {
                       $sqluld = "SELECT ulbname FROM ulbmst WHERE ulbid='".$rowMST['ulbid']."'";
                       $resultuld = mysqli_query($conn,$sqluld);
                          if (mysqli_num_rows($resultuld) >  0) {
                          // output data of each row
                              while($rowulb = mysqli_fetch_assoc($resultuld)) {
                                   $ulbname=$rowulb["ulbname"];
                              }
                          }
                         $sqluld1 = "SELECT ward_desc FROM ward_mst WHERE ward_id='".$rowMST['Wardno']."'";
                       $resultuld1 = mysqli_query($conn,$sqluld1);
                          if (mysqli_num_rows($resultuld1) >  0) {
                          // output data of each row
                              while($rowulb1 = mysqli_fetch_assoc($resultuld1)) {
                                   $ward_desc=$rowulb1["ward_desc"];
                              }
                          }
                       $lastid=$rowMST["Id"];
                       $newid= str_pad($lastid,4,"0",STR_PAD_LEFT); // 0001
                       $uniqid=$ulbname.'/'.$ward_desc.'/'.$newid;
                       $sql1 = "UPDATE IECHoardings SET UniqueId='$uniqid' WHERE Id='".$rowMST["Id"]."'";
                        mysqli_query($conn, $sql1);
                 }
                  
              }
		

mysqli_close($conn);

?>