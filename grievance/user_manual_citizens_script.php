<?php
// Check if the download button is clicked
/*if(isset($_GET['download_pdf'])) {
    // Remote URL of the PDF file
    
    $file_url = 'https://nmcnagpur.gov.in/grievance/PDF/User-Manual-For-Citizens.pdf';
    
    // Set headers for PDF download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="User-Manual-For-Citizens.pdf"');
    
    // Read the file and output it to the browser
    readfile($file_url);
    exit;
}*/

if(isset($_GET['download_pdf'])) {
    // File URL to your PDF file
    $file_url = 'https://nmcnagpur.gov.in/grievance/Pdf/User-Manual-For-Citizens.pdf';

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
