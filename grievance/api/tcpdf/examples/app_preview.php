<?php
session_start();
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD


<table>
<tbody>
<tr><th style="text-align:center;color:blue;" colspan='8'><h1>NIZAMABAD MUNICIPAL CORPORATION</h1></th></tr>
<tr><th style="text-align:center;color:blue;" colspan='8'><h2>APPLICATION DECLARATION</h2></th></tr>
</tbody>
</table>
<br><br>
<div style="width:100%; float:left">
<span style="color:#333"> I am sri/smt  <B> <span style="color:blue;">{$_SESSION['app_det']['appl_name']}</span></B> requesting for water tap connection to the House NO <b><span style="color:blue;">{$_SESSION['app_det']['hno']} </span></b> in <b><span style="color:blue;">{$_SESSION['app_det']['locality']}</span></b> streeet for <b><span style="color:blue;">{$conn_list[$app_type_id]}</span></b> . I agree for use of 40 galon of water to a man is not exceeded and also accept the meter/Slab rates deided by the Municipal Corporation nIzamabnad if i want to cance the water tap connection I must inform to the Commissioner of Municipal Corporation before 30 days on paper only . I always obey the rules of the water department in this Municipal Corporation <p> I never wish regarding above declaration is not the aceptance of unauthorised construction / charges in the house structure.</p></span></strong>

<div style="float:left;">Date:{$_SESSION['app_det']['date']}</div><div style="float:left">Applicant Signature</div>

</div>
<table>
<tbody>
<tr><th style="text-align:center;color:blue;" colspan='8'><h1>NIZAMABAD MUNICIPAL CORPORATION</h1></th></tr>
<tr><th style="text-align:center;color:blue;" colspan='8'><h2>APPLICATION DECLARATION</h2></th></tr>
</tbody>
</table>
<br><br>

<div style="width:100%; float:left">
<span style="color:#333"> I am sri/smt   <span style="color:blue;">{$_SESSION['app_det']['appl_name']}</span> requesting for water tap connection to the House NO <span style="color:blue;">{$_SESSION['app_det']['hno']} </span> in <span style="color:blue;">{$_SESSION['app_det']['locality']}</span> streeet for <span style="color:blue;">{$conn_list[$app_type_id]}</span> . I agree for use of 40 galon of water to a man is not exceeded and also accept the meter/Slab rates deided by the Municipal Corporation nIzamabnad if i want to cance the water tap connection I must inform to the Commissioner of Municipal Corporation before 30 days on paper only . I always obey the rules of the water department in this Municipal Corporation <p> I never wish regarding above declaration is not the aceptance of unauthorised construction / charges in the house structure.</p></span></strong>

<div style="float:left;">Date:{$_SESSION['app_det']['date']}</div><div style="float:left">Applicant Signature</div>

</div>


EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('app_preview.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
