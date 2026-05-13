<?php
	
	
	error_reporting(0);
	ini_set('display_errors',0);
	$conn2 = mysqli_connect('localhost','amc_root','Redhat@123','amc_db_2k21');
	
	require_once('../connection.php');
	$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
		
		$sql ="select * from flag_certifications where mobile='".$_POST['mobile']."'";
		$rs = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($rs);
		 //$nr=0;
		if($nr <= 0)
		{
		
		if($_FILES["image"]["name"] !='')
		{
		
		$target_dir= "../flagPhotos/";
		
		if($_FILES["image"]["name"] !='')
	    {
		    $base=$_FILES["image"]["name"];
		    
		     $path = $_FILES["image"]["name"];
           $ext = pathinfo($path, PATHINFO_EXTENSION);
           if(!($ext =="jpg" || $ext =="png" || $ext =="PNG" || $ext =="JPG" || $ext =="jpeg"))
           {
               
                die('Invalid file extension');
           }
		   
		   $a = time().rand(999,99999).".jpg";
		    
		    
		    $target_file = $target_dir.$a;
		    $file=$a;
		    $binary=base64_decode($base);
		    // header('Content-Type: image/jpeg; charset=utf-8');
			// echo 1;exit;
		    if(move_uploaded_file($_FILES["image"]["tmp_name"],$target_file))
			{
		        
		        $file_info = new finfo(FILEINFO_MIME_TYPE);
                $mime_types_array = array('image/jpeg','image/gif','image/bmp','image/gif','image/png','image/jpg');
                
                $finopath = $target_file;
		                    
					        $mime_type = $file_info->buffer(file_get_contents($finopath));
					       
					        if(!in_array($mime_type,$mime_types_array))
                                                {
                                                    unlink($finopath);
                                                    die('Invalid file type');
                                                    
                                                   
                                                }
                                                else
                                                {
                                                    $target_file="https://" . $_SERVER['HTTP_HOST'] . '/csms/flagPhotos/'.$file;
                                                }
		        
		        
		        
		        
		    }
			else{
		        $target_file = '#';
		    }
			
	    }
		
		
		$sql ="insert into flag_certifications(
		ulbid,
		person_name,
		address,
		mobile,
		file_url,
		imei,
		lat,
		lng,
		datetime
		)values(
		'250',
		'".$_POST['person_name']."',
		'".$_POST['address']."',
		'".$_POST['mobile']."',
		'".$target_file."',
		'".$_POST['imei']."',
		'".$_POST['lat']."',
		'".$_POST['lng']."',
		'".date('Y-m-d')."'
		)";
	
	
	if(mysqli_query($conn,$sql)){
	$app_id = mysqli_insert_id($conn);
	
	
	$sql ="INSERT INTO `tiranga_details`( 
`name`, 
`phone_no`, 
`file_name`, 
`file_path`, 
`address`, 
`date_time`, 
`certificate_path`, 
`status`,
origin,
origin_auto_id
) VALUES (

'".$_POST['person_name']."', 
'".$_POST['mobile']."',
'".$target_file."',
'".$target_file."',
'".$_POST['address']."',
'".date('Y-m-d H:i:s')."',
'', 
'1',
'2',
'".$app_id."'
)";

mysqli_query($conn2,$sql);
	
	
	
/** generate pdf ***/

require_once('tcpdf/examples/tcpdf_include.php');
require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf = new TCPDF('L', 'pt', ['format' => [$width, $height]]);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}


// $pdf->SetFont('dejavusans', '', 10);
$pdf->SetFont('satisfy', '', 14, '', true);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, 10);

$pdf->AddPage();

$pdf->Image('aurangabadcertificate.jpg', '15', '15', '270', '170', '', '', 'center');

  
$html = '<div style="background-image:url(aurangabadcertificate.jpg); background-repeat:no-repeat; height:700px;   background-size: contain;
    background-position: center;">
 <table width="100%">
	 <tr>
	 <td height="235"></td>
	 <td height="235"></td>
	 <td height="235"></td>
	 </tr>
	<tr>
	<td></td>
	 <td align="center">
		
		<div style="font-size: 20px; color: #b1963b;">';
			
	$html .= ucwords($_POST['person_name']);
		 
		
	$html .= '</div>
	 </td>
	 
	 <td>
	 <div style="float:right;text-align:center;margin-right:200mm"  >';
	   $pdf->Image($target_file, '220', '93.5', '51.2', '61', '', '', 'center'); 
		$html .= '</div>
		</td>
	 
	</tr>
 </table>
 
 
 </div>';
 //echo  $html;die;


// $pdf->writeHTML($html, true, false, true, false, 'center');
$pdf->writeHTMLCell(0, 0, 30, 30, $html, 0, 0, 0, true, 'center', true);



$path=$_SERVER['DOCUMENT_ROOT']."/csms/api/flag_photos/";

$filename=$path."certificate".$app_id.".pdf";


$pdf->Output($filename, 'F');

$filename="https://aurangabadmahapalika.org/csms/api/flag_photos/certificate".$app_id.".pdf";

    $data['certificate_path'] = $filename;
     $data['status_code'] = '200';
	$data['status_message'] = 'Uploaded successfully';
	$data['image_path'] = $target_file;

/** close ****/
	
	
	
	}else{
	$data['status_code'] = '100';
	$data['status_message'] = 'Error . Try again';
	}
		}else{
		
	$data['status_code'] = '100';
	$data['status_message'] = 'Please fill all fields';
		}
		}
		else{
		$data['status_code'] = '100';
	    $data['status_message'] = 'Already mobile number is uploaded';
		}
	
	
	 

echo json_encode($data);
mysqli_close($conn);



?>