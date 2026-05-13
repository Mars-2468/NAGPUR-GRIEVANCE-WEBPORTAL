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
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

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
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$tbl = <<<EOD
<table  cellpadding="2" cellspacing="2">

 <tr style="background-color:#FFFF00;color:#0000FF;">
  <td width="100%" align="center">NIZAMANAD MUNICIPAL CORPORATION</td>
  
  </tr>
  <tr>
  <td width="100%" align="center"></td>
 </tr>
  <tr>
  <td width="100%" align="center">Proceedings of the Commissioner, Nizamabad Municipal Corporation</td>
 </tr>
 <tr>
  <td width="100%" align="center"></td>
 </tr><tr>
  <td width="100%" align="center"></td>
 </tr>
 
 <tr>
  <td width="100%" align="center">Present: Dr. V. Venkateswarlu</td>
 </tr>
 
 
 <tr>
  <td width="100%" align="center"></td>
 </tr>
 
 <tr>
  <td width="100%" align="center"><h5>FORM C</h5></td>
 </tr>
<tr>
  <td width="100%" align="center"></td>
 </tr>

<tr nobr="true">
  <td width="50%">Proceedings no:</td>
  <td width="50%">Date : {$_SESSION['det']['date']}</td>
  
  
 </tr>
 
 <tr>
  <td width="100%" align="center"></td>
 </tr>
 

<tr>
  <td width="100%" align="left">Sub:- Nizamabad Mpl. Corporation - New water tap connnection-Domestic/Domestic Bulk Non domestic / commercial / industrial - Tap rate / Metered system - sanctions accorded- Proceedings - Issued- redg.</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">Ref:-1. Appication of sri/ smt <span style="color:blue"> {$_SESSION['det']['appl_name']}</span> Dated;</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">Ref:-2. Consumer No:_________ Dated;</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">Ref:-3. Note orders of the AE/ME on the Feasibility dated; <span style="color:blue"> {$_SESSION['det']['date']} </span></td>
 </tr>
 
 <tr>
  <td width="100%" align="left">Ref:-4. Report of call centre dated <span style="color:blue"> {$_SESSION['det']['date']}</span> onwards payment of donation<span style="color:blue">{$_SESSION['det']['donation_amt']}</span> and estimate chares Charges_______</td>
 </tr>
 
 <tr>
  <td width="100%" align="left"><u>ORDERS</u></td>
 </tr>
 
 <tr>
  <td width="100%" align="left">1. Sanction is hereby accorded for Providing new tap connection to sri.<span style="color:blue"> {$_SESSION['det']['appl_name']}</span>  to the H.No <span style="color:blue"> {$_SESSION['det']['hno']}</span>in <span style="color:blue"> {$_SESSION['det']['locality']} </span> area with a provision of <span style="color:blue"> {$size_list[$pipesize_id]} </span> mm size of pipeline in Nizamanbad city.</td>
 </tr>
 
 
 <tr>
  <td width="100%" align="center"></td>
 </tr>
 
 
 <tr>
  <td width="100%" align="left">2. The conneection sanctioned to the above house is for the purpose of Domestic / domestic bulk/ Non domestic/Commercial/industrial category under general/OYT /BPL type of connection monthly consumption chargeable under Flat rate/Metered rate consumption system as per the bye laws/G.Os in force which were amended from time to time.</td>
 </tr>
 
 <tr>
  <td width="100%" align="center"></td>
 </tr>
 
 
 
 <tr>
  <td width="100%" align="left">3. Sri/Smt.<span style="color:blue"> {$_SESSION['det']['appl_name']}</span> is here by informed that the above sanctin of tap connection is subject to the terms and conditins of the water supply bye law of the corporation. aAny deviation in the use of the connection eigher to the purpose sanctined or in the size of the pipe line sanctined is liable for the disconnectiion of the tap connection at the cost and risk of the consumer. The applicant is informed to keep ready with the reuired material for extension of the tap connection to the above sanctined house and inform the AE_____ zone for arranging the lineman and fitter for giving the tap connection.</td>
 </tr>
 
 <tr>
  <td width="100%" align="center"></td>
 </tr>
 
 
 
 <tr>
  <td width="100%" align="left">4. The tap shall be given strictly following as per the approved technical arrangement duly fixing the ferrule and adjusting the flow to the required standards. Any deviation either in the manner of giving connection or in the change in size of the  pipe and tpe of the connectin will attrct the penal action both on the part of the applicant and the line men participated in the process of giving tap connection. After the completion of the connection the testing of the connection is made compulsory to ensure the quality of the work done.</td>
 </tr>
 
 <tr>
  <td width="100%" align="center"></td>
 </tr>
 
 
 
 <tr>
  <td width="100%" align="left">5. The certificate of completion in the prescribed proforma shall to be produced to the office duly signed both by the applicant and the linemen with counter signature of the concerned AE</td>
 </tr>
 
 <tr>
  <td width="100%" align="center"></td>
 </tr>
 
 
 
 <tr>
  <td width="100%" align="left">6. The demand towards the cnsumption will be charged from the corresponding month in which the connectin is given.</td>
 </tr>
 
 <tr>
  <td width="100%" align="center"></td>
 </tr>
 
 
 
 <tr>
  <td width="100%" align="left">7. The change in the nature usage , shall be reported to the corporation immediately and get the type of tap connection be converted apppropriate to the latest usage as per the bye laws in force</td>
 </tr>
 
 

</table>






EOD;


$pdf->writeHTML($tbl, true, false, false, false, '');



// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+