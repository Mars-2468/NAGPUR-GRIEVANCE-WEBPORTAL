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
$type_conn_list=array('1'=>'Metered','2'=>'Non-Metered');
$donation_list=array('1'=>'General','2'=>'Oyt','3'=>'Bpl');
$tot_amount=$_SESSION['field_det']['sup_charge']+$_SESSION['field_det']['rs_charge']+$_SESSION['field_det']['ser_charge'];
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

$tbl = <<<EOD
<table  cellpadding="2" cellspacing="2">

 <tr style="background-color:#FFFF00;color:#0000FF;">
  <td width="100%" align="center">NIZAMABAD MUNICIPAL CORPORATION</td>
  
  </tr>
  <tr>
  <td width="100%" align="left">Note file: For the sanction of tap new connection:</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">PARA - 1</td>
 </tr>


<tr nobr="true">
  <td width="50%">Tap Consumer no:</td>
  <td width="50%">Date of verification: {$_SESSION['field_det']['date']}</td>
  
  
 </tr>
 
 <tr>
  <td width="100%" align="left"><u>A.Field Verification for feasibility: </u></td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">1.Applicant</td>
  <td width="50%">:{$_SESSION['field_det']['appl_name']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">2.H.No:</td>
  <td width="50%">:{$_SESSION['field_det']['hno']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">3.Assessment no:</td>
  <td width="50%">:{$_SESSION['field_det']['prop_tex_no']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">4.Huse tax:</td>
  <td width="50%">:{$_SESSION['field_det']['htax']}</td>
 </tr>
 
 
 <tr nobr="true">
  <td width="50%">5.No of the portions under the assessment:</td>
  <td width="50%">:{$_SESSION['field_det']['no_of_portions']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">6.Acivity under the assessment:</td>
  <td width="50%">:{$_SESSION['field_det']['active_portions']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">7.Usage of water : Res/Res.bulk/Non res/Com/Ind</td>
  <td width="50%">:{$_SESSION['usage_list'][$_SESSION['field_det']['usage_id']]}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">8.Size of the distribution line in the steet</td>
  <td width="50%">:{$_SESSION['size_list'][$_SESSION['field_det']['pipesize_id']]}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">9.Presssure available in the line</td>
  <td width="50%">:</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">10.Distance from the distribution line</td>
  <td width="50%">:{$_SESSION['field_det']['distance']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">11.Qty of water required</td>
  <td width="50%">:{$_SESSION['usage_list'][$_SESSION['field_det']['usage_id']]}</td>
 </tr>
 
 
 <tr>
  <td width="100%" align="left"><u>B. Recommendations: </u></td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">1.Category of connection eligible</td>
  <td width="50%">:{$_SESSION['conn_list'][$_SESSION['field_det']['app_type_id']]}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">2.Type of the connection proposed: Tap rate / metered</td>
  <td width="50%">:{$type_conn_list[$_SESSION['field_det']['app_type_id']]}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">3.Qty of water requested per day</td>
  <td width="50%">:{$_SESSION['usage_list'][$_SESSION['field_det']['usage_id']]}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">4.Size of the pipe connection recommendaded(1/2",1",11/2",2")</td>
  <td width="50%">:{$_SESSION['size_list'][$_SESSION['field_det']['pipesize_id']]}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">5.Donation preferred: General /Qyt/Bpl</td>
  <td width="50%">:{$donation_list[$_SESSION['field_det']['donation_pref']]}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">6.Donation amount</td>
  <td width="50%">:{$_SESSION['field_det']['donation_amt']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">7.Security deposit</td>
  <td width="50%">:{$_SESSION['field_det']['sec_amt']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">8.Amount of donation payable</td>
  <td width="50%">:{$_SESSION['field_det']['amt_payable']}</td>
 </tr>
 
 <tr>
  <td width="100%" align="left"><u>C. Centages and road cutting charges(As per Annexure 1): </u></td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">1.Supervision charge</td>
  <td width="50%">:{$_SESSION['field_det']['sup_charge']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">2.service charges</td>
  <td width="50%">:{$_SESSION['field_det']['ser_charge']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">3.Road restoration charges</td>
  <td width="50%">:{$_SESSION['field_det']['rs_charge']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">Amount payable under  service connection charges</td>
  <td width="50%">:{$tot_amount}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">Sign. Line men</td>
  <td width="50%">Sign. Asst Engineer,</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">PARA - 2</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">1.Payment  of donaton by the applicant: DD no</td>
  <td width="50%">:{$_SESSION['field_det']['ddno']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">Amount payable under  service connection charges</td>
  <td width="50%">:{$_SESSION['field_det']['sec_amt']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">Amount payable under  service connection charges</td>
  <td width="50%">:{$_SESSION['field_det']['rs_charge']}</td>
 </tr>
 
 <tr nobr="true">
  <td width="50%">Sign. Line men</td>
  <td width="50%">Sign. Call Centre</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">PARA - 3</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">The applicant has deposited Rs <span style="color:blue">{$_SESSION['field_det']['donation_amt']}</span>as donation, Rs <span style="color:blue">{$_SESSION['field_det']['sec_amt']} </span> of the security deposit and Rs <span style="color:blue">{$_SESSION['field_det']['rs_charge']}</span>towards the centages and road resoration charges are as per the estimates approved. The applicant is hence eligible for the sanction of new tap connection under the category (res/res.buk/non res/com/ind). Accordingly the proceedings for sanctin of teap to above house is put up for approval.</td>
 </tr>
 
 <tr nobr="true">
  <td width="25%">E2</td>
  <td width="25%">AE</td>
  <td width="25%">ME</td>
  <td width="25%">Commr</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">PARA - 4</td>
 </tr>
 <tr>
 <td width="100%"> The saction Proceedings no. <span style="color:blue">_______ </span>were served to the applicant on date <span style="color:blue"> {$_SESSION['field_det']['date']} </span>duly intimating the party to make arrangenents such as piipe matterial and labour for the giving tap cnneection and to intimate the AE for arranging the fitters for the giving tap connection.
 </td>
 </tr>
 
 <tr nobr="true">
  <td width="25%"></td>
  <td width="25%"></td>
  <td width="25%"></td>
  <td width="25%">Call centre</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">PARA - 5</td>
 </tr>
 
 <tr>
  <td width="100%" align="left">As pr the intimation received from the party about the making arrangements for taking tap connection to the said H.No  <span style="color:blue"> {$_SESSION['field_det']['hno']} </span> The linemen _____ and the fitter______ is deputed to give connection with the ferrule control and reported by the fitters as completed by date. <span style="color:blue"> {$date} </span> The tap connectin is tested and the tap is getting the supply as per the norms. The above completion of tap connection under flat rate/metered type for the purpse of (res/res.bulk/non res/com/ind) need to be reported to revenue section for initiating the demand.</td>
 </tr>
 
 <tr nobr="true">
  <td width="25%">AE</td>
  <td width="25%">ME</td>
  <td width="25%">Call Cente</td>
  <td width="25%">REV Section</td>
 </tr>

 
</table>
EOD;


$pdf->writeHTML($tbl, true, false, false, false, '');

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('field_inspection_previes.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+