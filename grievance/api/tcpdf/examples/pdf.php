<?php
session_start();
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
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
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
$conn= mysqli_connect("localhost", "biometri_att", "wrB(+KVz*~B{", 'biometri_regulation');
	$yn_list=array('1'=>'Yes','2'=>'No');
	$sql ="select * from lrs_docs";
	$rs = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($rs))
	{
	$doc_list[$row['doc_id']]=$row['doc_name'];
	} 
	
	
	$sql ="select * from  Districtmst";
	$rs = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($rs))
	{
	$dist_list[$row['distid']]=$row['distname'];
	} 
	
	$sql ="select * from  bank_list";
	$rs = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($rs))
	{
	$bank_list[$row['bank_id']]=$row['bank_name'];
	} 
	
	
	$sql ="select * from ulbmst";
	$rs = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($rs))
	{
	$ulb_list[$row['ulbid']]=$row['ulbname'];
	} 
	
	
	
	$sql ="select * from app_type";
	$rs = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($rs))
	{
	$app_type_list[$row['id']]=$row['type'];
	} 
	
	
	 $sql ="select u.ulb_grade from ulbmst u ,lrs_applications l where u.ulbid=l.ulbid and l.app_id='".$_SESSION['id']."'";
	$rs = mysqli_query($conn,$sql);
	$row= mysqli_fetch_assoc($rs);
	$ulb_type=$row['ulb_grade'];
	
	$sql ="select * from ulb_type";
	$rs = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($rs))
	{
	$ulb_type_list[$row['ulb_type_id']]=$row['ulb_type_desc'];
	} 
	
	$sql ="select * from land_use_types";
	$rs = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($rs))
	{
	$type_change_list[$row['type_id']]=$row['type_desc'];
	} 
	
	
	
	$sql ="select * from app_doc_map where app_id='".$_SESSION['id']."'";
		$rs = mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($rs))
		{
			$sel_doc_list[$row['doc_id']]=$row['doc_id'];
		
		}
		$sql ="select ifsc_code from  lrs_applications where app_id='".$_SESSION['id']."'";
		$rs = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		$ifsc_code =$row['ifsc_code'];

  $sql ="select l.*,b.branch_name  from lrs_applications l,  bank_details b  where l.bank_id=b.bank_id and b.ifsc_code='".$ifsc_code."' and l.app_id='".$_SESSION['id']."'";
$rs = mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($rs))
{
	$site_det['app_id']=$row['app_id'];
	
	$site_det['type_application']=$row['type_application'];
	$site_det['applicant_name']=$row['applicant_name'];
	$site_det['fh_name']=$row['fh_name'];
	$site_det['age']=$row['age'];
	$site_det['occupation']=$row['occupation'];
	$site_det['door_no']=$row['door_no'];
	$site_det['street']=$row['street'];
	$site_det['change_type_id']=$row['change_type_id'];
	$site_det['locality']=$row['locality'];
	$site_det['locality2']=$row['locality2'];
	$site_det['plot_no']=$row['plot_no'];
	$site_det['city']=$row['city'];
	$site_det['phone']=$row['phone'];
	$site_det['name_of_layout']=$row['name_of_layout'];
	$site_det['survey_no']=$row['survey_no'];
	$site_det['ulb_id']=$row['ulb_id'];
	$site_det['ulbid']=$row['ulbid'];
	$site_det['bank_id']=$row['bank_id'];
	$site_det['branch_name']=$row['branch_name'];
	$site_det['village_id']=$row['village_id'];
	$site_det['district_id']=$row['district_id'];
	$site_det['mandal_id']=$row['mandal_id'];
	$site_det['located_in_slum_yn']=$row['located_in_slum_yn'];
	$site_det['tot_extent_layout']=ceil($row['tot_extent_layout']);
	$site_det['plot_area']=ceil($row['plot_area']);
	$site_det['boundaries_plot_yn']=$row['boundaries_plot_yn'];
	$site_det['width_road_approach']=ceil($row['width_road_approach']);
	$site_det['width_road_proposed']=ceil($row['width_road_proposed']);
	$site_det['percent_open_space']=ceil($row['percent_open_space']);
	$site_det['amount_paid2008']=$row['amount_paid2008'];
	$site_det['bank_name2008']=$row['bank_name2008'];
	$site_det['branch_name2008']=$row['branch_name2008'];
	$site_det['dd_no2008']=$row['dd_no2008'];
	
	$site_det['market_value_org']=$row['market_value'];
	$site_det['market_value']=ceil($row['market_value'] * 1.19);
	$site_det['land_value']=round($row['land_value']);
	$site_det['land_use_yn']=$row['land_use_yn'];
	$site_det['rate_land_use']=$row['rate_land_use'];
	$site_det['falling_prohibited_areas_yn']=$row['falling_prohibited_areas_yn'];
	$site_det['recreational_use']=$row['recreational_use'];
	$site_det['amount']=round($row['amount']);
	$site_det['dd_no']=$row['dd_no'];
	$site_det['date']=$row['date'];
	$site_det['bank_name']=$row['bank_name'];
	$site_det['land_use_value']=$row['land_use_value'];
	
}
$not_applicable="Not Applicable";



	if($site_det['located_in_slum_yn']==1)
		{
		$charge=5;
		}
		else
		{
		
			if($site_det['plot_area'] <=100)
			{
			$charge=200;
			}
			if($site_det['plot_area'] > 100 && $site_det['plot_area'] <=300)
			{
			$charge=400;
			}
			if($site_det['plot_area'] > 300 && $site_det['plot_area'] <=500)
			{
			$charge=600;
			}
			if($site_det['plot_area'] > 500)
			{
			$charge=750;
			}
		}
		
		
		
		if($site_det['market_value']<=3000)
			{
			$percent=20;
			}
			if($site_det['market_value'] > 3001 && $site_det['market_value']<=5000)
			{
			$percent=30;
			}
			if($site_det['market_value'] > 5001 && $site_det['market_value']<=10000)
			{
			$percent=40;
			}
			if($site_det['market_value'] > 10001 && $site_det['market_value']<=20000)
			{
			$percent=50;
			}
			if($site_det['market_value'] > 20001 && $site_det['market_value']<=30000)
			{
			$percent=60;
			}
			if($site_det['market_value'] > 30001 && $site_det['market_value']<=50000)
			{
			$percent=80;
			}
			if($site_det['market_value'] > 50000)
			{
			$percent=100;
			}
			
			
			 $basic_reg_charge=$charge;
		
			$tot_reg_charge=round($basic_reg_charge * $site_det['plot_area']);
		
			$actula_amount_tobe_paid=round($tot_reg_charge * $percent / 100);
			
			
			if($site_det['type_application']==2 || $site_det['type_application']==3)
				{
					$total_area_of_layout=ceil($site_det['plot_area']);
					$ten_per_total_layout=ceil($site_det['plot_area']*10/100);
					$areaprovidedopenspace=ceil($site_det['percent_open_space']);
					$percent_of_openspace=ceil($areaprovidedopenspace * $site_det['plot_area']/100);
					$short_fall =ceil($ten_per_total_layout-$percent_of_openspace);
					$land_value=round($site_det['land_value'] * 1.19);
					$payable_amount=ceil($short_fall * $land_value);
					
				}
				else
				{

				 $land_value=round($site_det['land_value'] * 1.19);
				 $payable_amount=ceil(0.14 * $site_det['plot_area'] * $land_value);
				}
		
		
				$amount_payable =ceil($site_det['plot_area'] * $site_det['rate_land_use']);
				
				$grand_total=ceil($actula_amount_tobe_paid+$payable_amount+$amount_payable);
				
				$amountpaid2008=$site_det['amount_paid2008'];
		
					if($amountpaid2008 > $grand_total)
					{
						$grand_total=0;
					}
					else
					{
					$grand_total-=$amountpaid2008;
					}
				
			
			
		
		
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
/*$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');*/

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

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
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)



// test some inline CSS
$html = '<p style="line-height:17px;">APPLICATION FOR REGULARIZATION OF UNAPPROVED  '.$app_type_list[$site_det['type_application']].' '.$ulb_list[$site_det['ulbid']].' '.$ulb_type_list[$ulb_type].'</p><p></p>';

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
//$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table
$html= '<table border="1" cellpadding="6">
	<tr>
		<th rowspan="2" align="center">WHETHER APPLJG FOR REGULARIZATION OF INDIVIDUAL PLOT OR TOTAL LAOUT/PART OF LAYOUT</th>
		<th> INDIVIDUAL PLOT</th>
		<th> TOTAL LAYOUT</th>
		<TH>PART OF LAYOUT</TH>
	</tr>
	<tr>';
		
		if($site_det['type_application']=="1")
		{
		$html.='<td align="center" valign="middle" style="padding:10px;"><div style="margin-top:20px;">Yes</div></td><td></td><td></td>';
		}
		if($site_det['type_application']=="2")
		{
		$html.='<td></td><td align="center" valign="middle">Yes</td><td></td>';
		}
		if($site_det['type_application']=="2")
		{
		$html.='<td></td><td></td><td align="center" valign="middle">Yes</td>';
		}
	$html.='</tr>
	
	</table>';
	
$pdf->writeHTML($html, true, false, true, false, '');
// add a page
//$pdf->AddPage();


$html= '<table border="1" cellpadding="6">
	<tr>
		<th width="10%">1</th>
		<th width="45%">Name of the Applicant</th>
		<td width="45%">'. $site_det['applicant_name'].'</td>
	</tr>
	
	<tr>
		<th>2</th>
		<th colspan="2">Postal Address</th>
	</tr>
	
	<tr>
		<th width="10%">i</th>
		<th width="45%">Door No</th>
		<td width="45%">'.$site_det['door_no'].'</td>
	</tr>
	
	<tr>
		<th width="10%">ii</th>
		<th width="45%">Street</th>
		<td width="45%">'.$site_det['street'].'</td>
	</tr>
	
	<tr>
		<th width="10%">iii</th>
		<th width="45%">Locality</th>
		<td width="45%">'.$site_det['locality'].'</td>
	</tr>
	
	<tr>
		<th width="10%">iV</th>
		<th width="45%">City / Town</th>
		<td width="45%">'.$site_det['city'].'</td>
	</tr>
	
	<tr>
		<th width="10%">V</th>
		<th width="45%">Phone No</th>
		<td width="45%">'.$site_det['phone'].'</td>
	</tr>
	
	<tr>
		<th>3</th>
		<th colspan="2">Location Details</th>
		
	</tr>
	
	<tr>
		<th width="10%">i</th>
		<th width="45%">Name of the Layout/Colony</th>
		<td width="45%">'.$site_det['name_of_layout'].'</td>
	</tr>
	
	<tr>
		<th width="10%">ii</th>
		<th width="45%">Survey No</th>
		<td width="45%">'.$site_det['survey_no'].'</td>
	</tr>
	
	<tr>
		<th width="10%">iii</th>
		<th width="45%">Locality</th>
		<td width="45%">'.$site_det['locality'].'</td>
	</tr>
	
	<tr>
		<th width="10%">iV</th>
		<th width="45%">Revenue Village</th>
		<td width="45%">'.$site_det['village_id'].'</td>
	</tr>
	
	<tr>
		<th width="10%">V</th>
		<th width="45%">Mandal</th>
		<td width="45%">'.$site_det['mandal_id'].'</td>
	</tr>
	
	<tr>
		<th width="10%">Vi</th>
		<th width="45%">District</th>
		<td width="45%">'.$dist_list[$site_det['district_id']].'</td>
	</tr>
	
	<tr>
		<th >4</th>
		<th colspan="2">Details of the Layout/Plot</th>
		
	</tr>
	
	<tr>
		<th width="10%">i</th>
		<th width="45%">Total Extent of Layout (in Acs.)</th>';
		
		if($site_det['tot_extent_layout']==0)
		{
			$html.='<td width="45%">'.$not_applicable.'</td>';
			}else{
				$html.='<td width="45%">'.$site_det['tot_extent_layout'].'</td>';
				}
		
	$html.='</tr>
	
	<tr>
		<th width="10%">ii</th>
		<th width="45%">Plot area (in Sq. m)</th>
		<td width="45%">'.$site_det['plot_area'].'</td>
	</tr>
	
	<tr>
		<th width="10%">iii</th>
		<th width="45%">Layout plan drawn to scale enclosed duly showing the dimensions and boundaries of the plots, roads an open spaces.</th>
		<td width="45%">'.$yn_list[$site_det['boundaries_plot_yn']].'</td>
	</tr>
	
	<tr>
		<th width="10%">iV</th>
		<th width="45%">Width of Approah Road in meters</th>
		<td width="45%">'.$site_det['width_road_approach'].'</td>
	</tr>
	
	<tr>
		<th width="10%">v</th>
		<th width="45%">Width of Roads Proposed in meters</th>
		<td width="45%">'.$site_det['width_road_proposed'].'</td>
	</tr>
	
	<tr>
		<th width="10%">vi</th>
		<th width="45%"> Percentage of open space provided</th>
		<td width="45%">'.$site_det['percent_open_space'].'</td>
	</tr>
	
	<tr>
		<th width="10%">vii</th>
		<th width="45%">Market value (Sub-Registrar value) of the plot as on 28.10.2015</th>
		<td width="45%">'.$site_det['market_value_org'].'</td>
	</tr>
	
	<tr>
		<th width="10%">viii</th>
		<th width="45%">Land value (Sub-Registrar Value) Rs. Per sq. Yards as on the date  of registration of plot</th>
		<td width="45%">'.$site_det['land_value'].'</td>
	</tr>
	
	<tr>
		<th>5</th>
		<th colspan="2">LANDUSE</th>
		
	</tr>
	
	<tr>
		<th width="10%">i</th>
		<th width="45%">Land use of the site as per Master Plan</th>
		<td width="45%">'.$site_det['land_use_value'].'</td>
	</tr>
	
	<tr>
		<th rowspan="2">6</th>
		<th> 1. Whether the site is falling in prohibitedareas. namely G.O Ms.No. 111MA.dt.8.3.1996 relating Osmansagar and Himayath sagar catchment area</th>
		<td>'.$yn_list[$site_det['falling_prohibited_areas_yn']].'</td>
	</tr>
	
	<tr>
		
		<th> 2. Recreatiional use/industrial use/ water body/ Openspace use as per notified Master Plan / Zonal development plan</th>
		<td>'.$yn_list[$site_det['recreational_use']].'</td>
	
	</tr>
	

	<tr>
		<th width="10%">7</th>
		<th width="45%">Total Regulariation charges paid (as per self computation table duly filled in)</th>
		<td width="45%">'.$grand_total.'</td>
	</tr>
	
	<tr>
		<th width="10%">8</th>
		<th width="45%">Demand Draft/ Pay Order</th>
		<td width="45%"></td>
	</tr>
	
	<tr>
		<th width="10%">i</th>
		<th width="45%">Amount</th>
		<td width="45%">'.$site_det['amount'].'</td>
	</tr>
	
	<tr>
		<th width="10%">ii</th>
		<th width="45%">D.D.No</th>
		<td width="45%">'.$site_det['dd_no'].'</td>
	</tr>
	
	<tr>
		<th width="10%">iii</th>
		<th width="45%">Date</th>
		<td width="45%">'.date('d-m-Y',strtotime($site_det['date'])).'</td>
	</tr>
	
	<tr>
		<th width="10%">iv</th>
		<th width="45%">Name of the Bank & Branch</th>
		<td width="45%">'.$bank_list[$site_det['bank_id']].',<br>'.$site_det['branch_name'].'</td>
	</tr>
	
	
	<tr>
		<th>9</th>
		<th colspan="2">Certificate to be submitted by the Applicant</th>
		
	</tr>
	
	<tr>
	<th colspan="3"> 
		<p>I hereby certify that the Site Plan / Layout Plan and the particulars furnished above are true and correct.</p>
		<p></p>
		<p>I declare that the property for which I am applying for regularization is not a public property / surplus land under Urban Land ceiling and Regulation Act or Agriculture Land Ceiling Act and I further declare that there are no disputes / complaints  / legal impediments.</p>
		<p></p>
		<p>I also declare that my application is not in contravention of the prohibited zones / layout open space as given above in SI.No.6</p>
		<p></p>
		<p>In the event of the particulars furnished in the application are found to be incorrect, my application may summarily be rejected and I am liable for action by the Competent authority as per the rules.</p>
		</th>
	</tr>
	
	<tr>
		<th width="25%">place</th><td width="25%"></td><th width="25%">Signature</th><td width="25%"></td>
	</tr>
	
	<tr>
		<th width="25%">Date</th><td width="25%"></td><th width="25%">Name</th><td width="25%">'.$site_det['applicant_name'].'</td>
	</tr>
	
	
	
	
	
	</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



$html='<h4>2. SELF-COMPUTING TABLES FOR CALCULATION OF PRO-RATA CHARGES, SHORTFALL OF OPEN SPACE CHARGGES & OTHER CHARGES PAYABLE</h4>';
$html.='<div style="text-align:center;">TABLE - I</div>';

$html.='<table border="1" cellpadding="6">
	
		<tr>
			<th>A</th>
			<th colspan="5">
				<strong>
					TABLE SHOWING PRO-RATA CHARGES PAYABLE WHICH ARE INCLUSIVE OF BETTERMENT CHARGES, DEVELOPMENT CHARGES, PENALTY AND OTHER CHARGES
				</strong>
			</th>
		</tr>
		
		<tr>
			<th width="16.6%">Plot Area (in Sq.mts)</th>
			<th width="16.6%">Basic Regularisation Charges as per Table I of G.O.(n Rs/Sq.mtr)</th>
			<th width="16.6%">Total Regularisation Charges(Rs.)</th>
			<th width="16.6%">Market Value of the land as on 28.10.2015 (Sub-Registrat Value) Rs./Sq.yd</th>
			<th width="16.6%">Applicable percentage ofbasicRegularisation charges ( asper Tble II of G.O) with reference to land value</th>
			<th width="16.6%">Actual amount to be paid</th>
		</tr>
	
		<tr>
			<th>(1)</th>
			<th>(2)</th>
			<th>(3)</th>
			<th>(4)</th>
			<th>(5)</th>
			<th>(6)</th>
		</tr>
		
		<tr>
			<td>'.$site_det['plot_area'].'</td>
			<td>'.$basic_reg_charge.'</td>
			<td>'.$tot_reg_charge.'</td>
			<td>'.$site_det['market_value_org'].'</td>
			<td>'.$percent.'</td>
			<td>'.$actula_amount_tobe_paid.'</td>
		</tr>

		
	</table>';
	
	$html.='<div style="text-align:center;">TABLE - II</div>';
	
	$html.='<table width="100%" border="1" cellpadding="6">
			<tr>
			<th width="10%">B</th>
			<th width="90%">
				<strong>
					TABLE SHOWING PRO-RATA CHARGES TO BE PAID TOWARDS SHORTFALL OF OPEN SPACE (if any)
				</strong>
			</th>
		</tr>';
		if($site_det['type_application']=="2" || $site_det['type_application']=="3")
				{
				
				$html.='<tr>
					<th width="10%">I</th>
					<th width="90%">
					<strong>
						IN CASE OF APPLICATION FILED FOR TOTAL LAYOUT REGULARISATION
					</strong>
					</th>
				</tr>
				
				<tr>
					<td width="10%">a</td><td width="45%">Total area of the layout (in sq.mts.)</td><td width="45%">'.$site_det['plot_area'].'</td>
				</tr>
				
				<tr>
					<td width="10%">b</td><td width="45%">Required as per rules i.e, 10% of total layout
area (in sq.mts.)</td><td width="45%">'.ceil($ten_per_total_layout).'</td>
				</tr>
				
				<tr>
					<td width="10%">c</td><td width="45%">Area provided as Open Space in Layout (in
sq.mts.)</td><td width="45%">'.$percent_of_openspace.'</td>
				</tr>
				
				<tr>
					<td>d</td><td>Short fall (in sq. mts. ) i.e, (b) - (c)</td><td>'.$short_fall.'</td>
				</tr>
				
				<tr>
					<td>e</td><td>Land value as on the date of Registration of plot
(sub-registrar value) in Rs.</td><td>'.$site_det['land_value'].'</td>
				</tr>
				
				<tr>
					<td>f</td><td>Amount Payable (d) x (e)</td><td>'.$payable_amount.'</td>
				</tr>
				
				
				';
				}
				else
				{
				
				$html.='<tr>
					<th width="10%">I</th>
					<th width="90%">
					<strong>
						IN CASE OF APPLICATION FILED FOR INDIVIDUAL PLOT REGULARISATION
					</strong>
					</th>
				</tr>
				<tr>
					<td width="10%">a</td><td width="45%">Plot area in sq. mts.</td><td width="45%">'.ceil($site_det['plot_area']).'</td>
				</tr>
				
				<tr>
					<td>b</td><td>Land value (Sub-Registrar Value) Rs. per sq. Mtrs as on the date of registration of plot</td><td>'.$land_value.'</td>
				</tr>
				
				
				<tr>
					<td>c</td><td>Amount Payable 0.14 x (a) x (b)</td><td>'.$payable_amount.'</td>
				</tr>
				
				';
				}
				
				
				
				
				
				
				$html.='</table>';
				
				$html.='<div style="text-align:center;">TABLE - III</div>';
				
				
				$html.='<table border="1" cellpadding="6">
				<tr>
					<th width="10%">c</th>
					<th width="90%">
						<strong>
							TABLE SHOWING PAYMENT OF CHARGES FOR CHANGE OF LANDUSE
						</strong>
					</th>
				</tr>
				
				<tr>
					<th width="10%"></th>
					<th width="90%">
						
							Change of Land use charges as per G.O.Ms.No.439 dt.13.06.2007 and
G.O.Ms.No.158 dt. 05.02.1996 (G.Os enclosed as Annexures) in case of plots
earmarked for other than residential use in notified Master Plans/Zonal
Development Plans.
						
					</th>
				</tr>
				
				
				<tr>
					<td width="10%">I</td><td width="45%">Total Layout area/Plot area applied for
regularisation</td><td width="45%">'.$site_det['plot_area'].' &nbsp;&nbsp; Sq.Mtr.</td>
				</tr>
				
				<tr>
					<td>II</td><td>Rate of Change of Land use
from <strong>'.$type_change_list[$site_det['change_type_id']].'</strong>.use</td><td>'.$site_det['rate_land_use'].' &nbsp;&nbsp; / Sq.Mtr.</td>
				</tr>
				
				<tr>
					<td>T-III</td><td>Amount Payable= (a)x(b)</td><td> Rs '.ceil( $site_det['rate_land_use'] * $site_det['plot_area']).'</td>
				</tr>
				
				<tr>
				<th colspan="6">
				(Note: In case the Applicant is not in a position to calculate the charges
payable as per Table -II and III above, he may submit the
application duly paying penalisation charges as per Table-I. In
such cases, the Competent Authority will scrutinise the
application and inform the applicant to pay the said charges and if
the applicant fails to pay the said charges within 30 days the
application will be rejected).
				</th>
				</tr>
				
				
				';
				
				$html.='</table>
				
				
				<div style="height:20px;"></div>';
				
				
				
				
				
				
$html.='<table table border="1" cellpadding="6">
<tr><th width="100%">Amount Details under LRS 2008</th></tr>
<tr> <th width="10%">i</th><th width="45%"> Name of The Bank</th> <td width="45%">'.$site_det['bank_name2008'].'</td></tr>

<tr> <th>ii</th> <th> Branch Name</th> <td>'.$site_det['branch_name2008'].'</td></tr>

<tr> <th>i</th> <th> DD Number</th> <td>'.$site_det['dd_no2008'].'</td></tr>

<tr> <th>ii</th><th> Amount Paid</th> <td>'.$site_det['amount_paid2008'].'</td></tr>

</table> <div style="height:20px;"></div>';
				
				
				$html.='<table border="1" cellpadding="6">
				<tr>
					<th>GRAND TOTAL OF PENAL
CHARGES PAYABLE = T-1 + T-II + T-III</th>
					<th>
						<strong>
							Rs. '.$grand_total.'
						</strong>
					</th>
				</tr>
				<tr>
				<th>Signature</th><td></td>
				</tr>
				<tr>
				<th>Name</th><td></td>
				</tr>
				</table>';
				$pdf->writeHTML($html, true, false, true, false, '');
				
	$pdf->lastPage();			
				
$pdf->AddPage();				
		
		
	$html='<h4>3. FORMAT OF AFFIDAVIT RELATING TO URBAN LAND CEILING CLEARANCE (wherever applicable)</h4>';
	
	$html.='
		<p style="line-height:30px;">I, <strong>'.$site_det['applicant_name'].'</strong> S/o/D/o <strong> '.$site_det['fh_name'].' </strong>.R/o '.$site_det['city'].' am the Owner of plot No  <strong>'.$site_det['plot_no'].'</strong>.Land in Sy.No.<strong> '.$site_det['survey_no'].' </strong>.. of <strong> '.$site_det['village_id'].' </strong>(V) '.$site_det['mandal_id'].' Mandal '.$dist_list[$site_det['district_id']].' District
admeasuring  ';

if($site_det['tot_extent_layout']==0)
{
	$html.='<strong>'.$site_det['plot_area'].'. Sq. Mts./';
}
else{
	$html.='<strong>'.$site_det['plot_area'].'. Sq. Mts./'.$site_det['tot_extent_layout'].' Acres .';
}


$html.='</strong> vide sale Deed No. ............ of
......and Affirm that the said plot/and is in within urban land ceiling limits.
I understand that I will be solely responsible for any action taken if the same is
declared otherwise under the Urban land Ceiling Act, 1976., and the Competent
Authority shall in no way be held responsible in according technical approval for my
plot/land under the Telangana Regularization of Unapproved Layout Rules, 2015.



<p><strong> NAME AND SIGNATURE OF OWNER (S)</strong></p>
<p> <strong> '.$site_det['applicant_name'].' </strong>.
Witness…………………………………..Name…………………………………..… and
Address ……………………………….
Sworn and signed before me on this ………… day of ………….. 2015 in presence
of above witness.</p>

<div style="text-align:right">PULIC NOTARY</div>

	
	';
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->lastPage();
$pdf->AddPage();

$html='<p><strong> INDEMNITY BOND & UNDERTAKING</strong></p>

<p style="line-height:30px;">(On Non – Judicial Stamp paper of Rs.100 & Notarized - to be submitted along
with Application Form)</p>

<p style="line-height:30px;">This Indemnity Bond and Undertaking executed on this ……day of …………....
2015 by Smt/Sri. <strong> '.$site_det['applicant_name'].'  </strong> S/o/W/o <strong> '.$site_det['fh_name'].' </strong> . Age <strong>'.$site_det['age'].'</strong>
.Occupation  <strong> '.$site_det['occupation'].' </strong> .R/o  <strong> '.$site_det['city'].' </strong>
herein after called the FIRST PARTY which term shall include their legal heirs,
successors, assignees, agents, representatives and tenants,</p>


<p style="line-height:30px;">IN FAVOUR OF</p>

<p style="line-height:30px;">The  Commissioner, <strong> '.$ulb_list[$site_det['ulbid']].' </strong> '.$ulb_type_list[$ulb_type].'    , herein after called the SECOND PARTY, which term shall
include all officials and staff of the ……………
Commissioner <strong> '.$ulb_list[$site_det['ulb_id']].' </strong> '.$ulb_type_list[$ulb_type].' Whereas FIRST PARTY
has applied for the regulation of the unapproved  '.$app_type_list[$site_det['type_application']].' of plots
in Sy.No <strong> '.$site_det['survey_no'].' </strong> of <strong> '.$site_det['village_id'].' </strong> (V) <strong> '.$site_det['mandal_id'].' </strong> Mandal  <strong> '.$dist_list[$site_det['district_id']].' </strong>District
covering an extent of '.$site_det['plot_area'].'  Sq.Mts./Acres.</p>


<p style="line-height:30px;">Whereas the SECOND PARTY has agreed to consider regularisation of the said
unapproved layout/Unapproved sub-division of plots in terms of Telangana
Regularisation of unapproved and Illegal layout Rules, 2015 and made it a condition
that there shall not be any defects / litigations over the said site/land and the same shall
be free from all claims of Govt. /Banks / and attachments of Courts, and FIRST PARTY
has to indemnify the SECOND PARTY to this effect.</p>

<p style="line-height:30px;">Whereas the FIRST PARTY having agreed to the aforesaid condition hereby
indemnifies the SECOND PARTY with the above assurance and hereby solemnly
declare that the above said site/land is the property of the FIRST PARTY which is
possessed by him/her since the date of purchase and the same is free from all defects,
litigations, claims and attachments from any courts, etc. and in case of any disputes /
litigations arises at any time in future the FIRST PARTY shall be responsible for the
settlement of the same and the SECOND PARTY shall not be a party to any such
disputes / litigations.</p>

<p style="line-height:30px;">Hence this Indemnity Bond.</p>
<p style="line-height:30px;">affirm that I shall abide by the conditions imposed by the second party and I
hereby undertake to hand over the roads, streets, open spaces/area affected in road
widening earmarked in the regulated layout to the local authority free of cost through a
registered gift deed.</p>

<p style="line-height:30px;"><strong>SIGNATURE OF THE FIRST PARTY</strong></p>

<p style="line-height:30px;">.................................................</p>


<div style="line-height:30px;"><strong>WITNESSES:</strong></div>

<div  style="line-height:30px;">1................................... Name and address</div >
<div  style="line-height:30px;">2....................................Name and address</div >
<div  style="line-height:30px;">Sworn and signed before me on this ………… day of …………… 2015 in
presence of above witnesses.</div >
<div style="text-align:right">PULIC NOTARY</div>

';

$pdf->writeHTML($html, true, false, true, false, '');

	$pdf->lastPage();			
				
$pdf->AddPage();
$i=1;
$html='<p><strong> 5. LIST OF DOCUMENTS TO BE ENCLOSED ALONG WITH THE APPLICATION</strong></p>

<table border="1" cellpadding="6">';

		foreach ($sel_doc_list as $key=>$val)
		{
		
				$html.='<tr>
					<th>'.$i.'</th>
					<th colspan="5">
						'.
							$doc_list[$key]
						.'
					</th>
				</tr>';
				$i++;
		}
		
		$sql ="select other_doc from lrs_applications where app_id='".$site_det['app_id']."'";
		$rs = mysqli_query($conn,$sql);
		$row =mysqli_fetch_assoc($rs);
		
		  $other_doc=$row['other_doc'];
		if($other_doc =="")
		{
		
		}
		else
		{
			
		$html.='<tr><th>'.$i.'</th><th colspan="5">'.$other_doc.'</th></tr>';
		}
		


$html.='</table>';

$html.='<table border="1" cellpadding="6">

<tr>
	<th>APPLICATION NUMBER </th><td>LRS...................</td>
</tr>

</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();			
				
$pdf->AddPage();


$html='<p><strong> 6. CHECKLIST & ACKNOWLEDGEMENT (To be submitted in duplicate – one to be
retained in file and another to be given to applicant as acknowledgement)</strong></p>';

$html.='<table table border="1" cellpadding="6">
<tr> <th width="10%">1</th><th width="45%"> Name of the applicant</th> <td width="45%">'.$site_det['applicant_name'].'</td></tr>

<tr> <th>2</th> <th> Postal Address</th> <td></td></tr>

<tr> <th>i</th> <th> Door no</th> <td>'.$site_det['door_no'].'</td></tr>

<tr> <th>ii</th><th> Street</th> <td>'.$site_det['street'].'</td></tr>

<tr> <th>iii</th> <th> Locality</th> <td>'.$site_det['locality'].'</td></tr>

<tr> <th>iv</th> <th> City / Town</th> <td>'.$site_det['city'].'</td></tr>

<tr> <th>v</th> <th> Phone Number</th> <td>'.$site_det['phone'].'</td></tr>

<tr> <th>3</th> <th> Plot / Layout Location</th> <td>'.$site_det['locality2'].'</td></tr>

<tr> <th>i</th><th> T.S Number</th> <td></td></tr>

<tr> <th>ii</th><th> Plot Number</th> <td>'.$site_det['plot_no'].'</td></tr>

<tr> <th>iii</th> <th> Layout / Sub Divn. No</th> <td></td></tr>

<tr> <th>iv</th> <th> Street</th> <td>'.$site_det['street'].'</td></tr>

<tr> <th>v</th> <th> Locality</th> <td>'.$site_det['locality'].'</td></tr>

<tr> <th>vi</th> <th> City / Town</th> <td>'.$site_det['city'].'</td></tr>

<tr>
	<th colspan="2">List of documents enlosed along with the application:</th><th>Submitted</th>
</tr>';
$i=1;
foreach($doc_list as $key1=>$val1)
{

	if($key1=='99')
	{
		  $sql ="select other_doc from lrs_applications where app_id='".$site_det['app_id']."'";
		$rs = mysqli_query($conn,$sql);
		$row =mysqli_fetch_assoc($rs);
		
		  $other_doc=$row['other_doc'];
		if($other_doc =="")
		{
		
		}
		else
		{
		$html.='<tr><th>'.$i.'</th><th>'.$other_doc.'</th><th>YES</th></tr>';
		}
	}
	else
	{
	
		$flag=0;
		foreach($sel_doc_list as $key2=>$val2)
		{
			if($key1==$key2)
			{
				$flag=1;
				break;
			}
		}
		if($flag==1)
		{
			$html.='<tr><th>'.$i.'</th><th>'.$val1.'</th><th>YES</th></tr>';
		}
		else{
			$html.='<tr><th>'.$i.'</th><th>'.$val1.'</th><th>NO</th></tr>';
		}
	}
	$i++;
}

$html.='<tr><th colspan="3" align="center"><strong>ACKNOWLEDGEMENT</strong></th></tr>

<tr><td colspan="3">Received the application ad documents as pasted above</td></tr>

<tr><td rowspan="2">OFFICE SEAL</td><td>Application Number for future reference</td><td>LRS/.............</td></tr>
<tr><td>SIGNATURE OF THE RECEIVER</td><td>DESIGNATION</td></tr>

	
';

$html.='</table>';



$path=$_SERVER['DOCUMENT_ROOT']."/Regulation/pdf_files/";

$filename=$path.$site_det['app_id'].".pdf";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($filename, 'F');
//Close and output PDF document
$pdf->Output('pdf.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+