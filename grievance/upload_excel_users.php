<form method="post" enctype="multipart/form-data">
    <input type="file" name="excel_file" accept=".xlsx,.xls,.csv" required>
    <button type="submit" name="upload">Upload & Import</button>
</form>
<?php
 //$conn= mysqli_connect("localhost", "nagpurnewcsms", "d0-RyN6D[f4]wsl7", 'nagpurnewcsms') or die(mysqli_connect_error());

$conn = mysqli_connect("localhost","root","","nagpurnewcsms_new");

if(isset($_POST['upload']))
{

    $file = $_FILES['excel_file']['tmp_name'];
    $filename = $_FILES['excel_file']['name'];

    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    // If Excel file convert to CSV
    if($ext == "xlsx" || $ext == "xls")
    {
        echo "Please save Excel as CSV before uploading.";
        exit;
    }

    $handle = fopen($file,"r");

    $i = 0;

    while(($data = fgetcsv($handle,1000,",")) !== FALSE)
    {

        if($i == 0){
            $i++;
            continue; // skip header
        }
		
//echo "<pre>";print_r($data);echo "</pre>";die();
	
	/* 
        $user_id     = mysqli_real_escape_string($conn,$data[5]);     
        $user_name   = mysqli_real_escape_string($conn,$data[4]);
        $user_pwd  = mysqli_real_escape_string($conn,$data[6]);		
		$user_pwd = 'C'.strtolower(substr($user_pwd,1));		
        $user_type  = mysqli_real_escape_string($conn,$data[7]);
		$user_pwd=sha1(md5( $user_pwd));
		
         $sql = "INSERT INTO users 
        (user_id, emp_id, user_pwd, user_name, user_mobile, user_email, user_type, user_dept, ulbid, banner, logo_url, open_comp_banner, sec_level, logout_url, app_banner, show_pwd, login_status, mc_yn, user_delete_status, is_level4_emp, update_previlize, has_access, otp, otp_status)
        VALUES 
        ('$user_id','',PASSWORD('$user_pwd'),'$user_name','','',
        '$user_type','0','250',
        'https://municipalservices.in/nagpurcsms/images/nagpur-banner1.png',
        '-','-','0','-','-',
        'VEVxZEFZcTBqUDRzblJEdlRBdjFtUT09OjqSmttmoAHfL0CkFUgTmyg3',
        '0','0','0','0','0','0','1234','2')";  */
		
		
/*		
	 	$user_id     = mysqli_real_escape_string($conn,$data[5]);     
       		
		$sql = "INSERT INTO users_services 
        (user_id, service_id,status )
        VALUES 
		('$user_id','corp_change_pwd',1),
        ('$user_id','corp_register_comp_helpline',1)"; 



		$user_id     = mysqli_real_escape_string($conn,$data[5]);     
        $zone_id   = mysqli_real_escape_string($conn,$data[1]);
        $ward_id   = mysqli_real_escape_string($conn,$data[2]);
       
		
		$sql = "INSERT INTO corporator_users 
        (user_id, zone_id,ward_id )
        VALUES 
        ('$user_id','$zone_id','$ward_id')";
		
		*/
		
		
		
		
		
		
        $zone_opt_name   = mysqli_real_escape_string($conn,$data[1]);
        $zone_id   = mysqli_real_escape_string($conn,$data[2]);
        $zonename   = mysqli_real_escape_string($conn,$data[3]);		
		$zone_name= $zonename." ($zone_opt_name)";
        $ward_id   = mysqli_real_escape_string($conn,$data[4]);
        $ward_name   = mysqli_real_escape_string($conn,$data[5]);
		$loc_of_gvp     = mysqli_real_escape_string($conn,$data[6]);     
		$latitude     = mysqli_real_escape_string($conn,$data[7]);     
		$longitude     = mysqli_real_escape_string($conn,$data[8]); 
		$created_at = date('Y-m-d h:m:s');
		
		$sql = "INSERT INTO zone_ward_loc_mst 
        (zone_id,zone_name,ward_id,ward_name,loc_of_gvp,latitude,longitude,created_at)
        VALUES 
        ('$zone_id','$zone_name','$ward_id','$ward_name','$loc_of_gvp','$latitude','$longitude','$created_at')";
		
		
		
//echo "<pre>";print_r($sql);echo "</pre>";die();

		mysqli_query($conn,$sql);

        $i++;
    }

    fclose($handle);

    echo "Users Imported Successfully";

}

?>