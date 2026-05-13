<?php
// Your database connection code goes here
$connection = mysqli_connect("localhost", "nagpurnewcsms", "d0-RyN6D[f4]wsl7", "nagpurnewcsms");

// Fetch data from the database (replace this with your actual query)
$query = "SELECT cs_id,cat_id,sub_cat_id,cs_desc,cs_type_id FROM cs_mst";
$result = mysqli_query($connection, $query);

require('fpdf.php'); // Include the path to FPDF library

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', 'B', 12);

// Output headers
$headers = array('cs_id', 'cat_id', 'sub_cat_id', 'cs_desc', 'cs_type_id'); // Replace with your column names
foreach ($headers as $header) {
    $pdf->Cell(40, 10, $header, 1);
}

// Output data
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Ln();
    foreach ($row as $column) {
        $pdf->Cell(40, 10, $column, 1);
    }
}

// Output PDF as a download
$pdf->Output('database_data.pdf', 'D');
?>
