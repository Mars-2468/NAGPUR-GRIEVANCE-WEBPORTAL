<?php

if(isset($_GET['download_pdf'])) {
    // File URL to your PDF file
    //old 22-04-24 $file_url = 'https://nmcnagpur.gov.in/grievance/Pdf/User-Manual-For-Department.pdf';

    $file_url = 'https://nmcnagpur.gov.in/grievance/Pdf/User-Manual-For-Department.pdf';
    // Set headers for PDF download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file_url).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    // Open the file for reading
    $file = fopen($file_url, 'rb');
    
    if ($file) {
        // Output the file to the browser
        while (!feof($file)) {
            echo fread($file, 1024);
        }
        fclose($file);
        exit;
    } else {
        echo "Error: Unable to open file.";
    }
}

?>
