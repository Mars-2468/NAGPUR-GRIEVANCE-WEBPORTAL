<?php
require_once('connection.php');
		$conn=getconnection();
		
	/*	$sql="SELECT * FROM `ulbmst` ORDER BY ulbid ASC";
		$res=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($res))
		{
		$query="SELECT * FROM `cs_mst` WHERE `cat_id` IN (24,25)";
	    $res1=mysqli_query($conn,$query);
	    while($row2=mysqli_fetch_assoc($res1))
	    {
	        
	        echo $sql ="INSERT INTO complaint_ulbmap(cs_id,cat_id,flag,ulbid,cs_type_id) values('".$row2['cs_id']."','".$row2['cat_id']."','1','".$row['ulbid']."','1')";
	        mysqli_query($conn,$sql); 
	         
	        echo  "<br>";
	    }
	    }*/
	    
	    $dept="MEPMA";
	    $desg="MEPMA";
	    //$sql="select *from ulbmst where ulbid ='001'";
	    /*$sql="select *from ulbmst where ulbid NOT IN (select ulbid from dept_mst where `dept_desc` LIKE '%MEPMA%')";
	    $res=mysqli_query($conn,$sql);
	    while($row=mysqli_fetch_assoc($res))
	    {
	        echo $sql1="INSERT INTO dept_mst(dept_desc,ulbid,prefix,admin_status,manual_status) values('".$dept."',
	        '".$row['ulbid']."',
	        '',
	        '0',
	        '1')";
	        echo "<br>";
	        $result=mysqli_query($conn,$sql1); 
	        $dept_id=mysqli_insert_id($conn);
	        
	     
	     
	   
	       $sql3="INSERT INTO desg_mst(desg_desc,dept_id,ulbid,sort_order) values('".$desg."',
	       '".$dept_id."',
	        '".$row['ulbid']."',
	        '0')";
	        $result=mysqli_query($conn,$sql3); 
	        
	    
	   
	    }*/
	   /* $sql="SELECT * FROM `dept_mst` WHERE `dept_desc` LIKE '%MEPMA%' AND `manual_status` = ''";
	    
	    $res=mysqli_query($conn,$sql);
	    while($row=mysqli_fetch_assoc($res))
	    {
	        
	        $dept_id=$row['dept_id'];
	        
	     
	     
	   
	       $sql3="INSERT INTO desg_mst(desg_desc,dept_id,ulbid,sort_order) values('".$desg."',
	       '".$dept_id."',
	        '".$row['ulbid']."',
	        '0')";
	        $result=mysqli_query($conn,$sql3); 
	        
	    
	   
	    }*/
	  /*  function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}*/
	    
	   /* $sql ="SELECT * FROM `emp_excel_od` where odStatus=1";
	    $rs = mysqli_query($conn,$sql);
	    while($row = mysqli_fetch_assoc($rs))
	    {
	        $sql ="SELECT * FROM `dept_mst` WHERE `dept_desc` LIKE 'MEPMA' AND `ulbid` LIKE '".$row['ulbid']."'";
	        $deptRs = mysqli_query($conn,$sql);
	        $deptRow = mysqli_fetch_assoc($deptRs);
	        $deptId = $deptRow['dept_id'];
	        
	        $sql ="SELECT * FROM `desg_mst` WHERE `desg_desc` LIKE 'MEPMA' AND `ulbid` LIKE '".$row['ulbid']."'";
	        $desgRs = mysqli_query($conn,$sql);
	        $desgRow = mysqli_fetch_assoc($desgRs);
	        $desgId = $desgRow['desg_id'];
	        
	        if($row['odStatus']=='')
	        {
	        
	      /*  echo $sql ="insert into emp_mst(
	            emp_name,
	            emp_dept,
	            emp_desg,
	            emp_mobile,
	            ulbid,
	            mobile,
	            isMepmaEmp
	            )values(
	               '".$row['emp_name']."',
	               '".$deptId."',
	               '".$desgId."',
	               '".$row['mobile']."',
	               '".$row['ulbid']."',
	               '".$row['mobile']."',
	               '1'
	                
	                )";
	                echo "<br>";
	                mysqli_query($conn,$sql);
	    }
	        else
	        {
	            $length=10;
	            $emp_id=generateRandomString($length);
	            echo $sql ="insert into emp_mst_od(
	            emp_id,
	            
	            emp_name,
	            
	            emp_dept,
	            emp_desg,
	            emp_mobile,
	            ulbid,
	            mobile,
	            isMepmaEmp
	            )values('".$emp_id."',
	               '".$row['emp_name']."',
	               '".$deptId."',
	               '".$desgId."',
	               '".$row['mobile']."',
	               '".$row['ulbid']."',
	               '".$row['mobile']."',
	               '1'
	                
	                )";
	                echo "<br>";
	                mysqli_query($conn,$sql);
	        }
	        
	    }
	    */
	    //$sql ="SELECT * FROM `emp_mst` WHERE `emp_id` > 3095 AND `isMepmaEmp` = 1";
	 // $sql ="SELECT * FROM `emp_mst_od` WHERE `isMepmaEmp` LIKE '1'";
	  //  $rs = mysqli_query($conn,$sql);
	    /*while($row = mysqli_fetch_assoc($rs))
	    {
	        $empId = $row['emp_id'];
	        $deptId = $row['emp_dept'];
	        $desgId = $row['emp_desg'];
	        $ulbid = $row['ulbid'];
	        $sql ="SELECT * FROM `cs_mst` WHERE `cat_id` IN (24,25)";
	        $csrs = mysqli_query($conn,$sql);
	        while($csrow = mysqli_fetch_assoc($csrs))
	        {
	            $csId =$csrow['cs_id'];
	            $sql ="SELECT ward_id FROM `ward_mst` WHERE `ulbid` LIKE '".$row['ulbid']."'";
	            $wardrs = mysqli_query($conn,$sql);
	            while($wardrow = mysqli_fetch_assoc($wardrs))
	            {
	                $wardId = $wardrow['ward_id'];
	                $sql ="SELECT * FROM `street_mst` WHERE `ward_id` = '".$wardrow['ward_id']."'";
	                $streetrs = mysqli_query($conn,$sql);
	                while($streetrow = mysqli_fetch_assoc($streetrs))
	                {
	                    $streetId = $streetrow['street_id'];
	                    echo $sql = "insert into emp_map (
	                        cs_id,
	                        cs_type_id,
	                        street_id,
	                        ward_id,
	                        emp_id,
	                        emp_id2,
	                        emp_id3,
	                        emp_id4,
	                        dept_id,
	                        desg_id,
	                        flag,
	                        ulbid,
	                        isMempaEmp
	                        ) values(
	                            '".$csId."',
	                            '1',
	                            '".$streetId."',
	                            '".$wardId."',
	                            '".$empId."',
	                            '".$empId."',
	                            '".$empId."',
	                            '".$empId."',
	                            '".$deptId."',
	                            '".$desgId."',
	                            '1',
	                            '$ulbid',
	                            '1'
	                            )";
	                            mysqli_query($conn,$sql);
	                            echo "<br>";
	                }
	                
	            }
	        }
	    }
		*/
?>

