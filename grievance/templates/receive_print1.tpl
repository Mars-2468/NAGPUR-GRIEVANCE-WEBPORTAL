{include file='header.tpl'}
{literal}

<script>
	function myFunction() {
        window.print();
   }
</script>
{/literal}

<div style="border:#999999 1px solid;  min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>

{foreach from=$data key=apprec_id item=row}

<div class="my_heading">Application Received</div>
<div id="area">

<center>
<div style="width: 700px; height: 470px; border: #666666 2px solid; border-radius: 10px; padding: 0px 10px; line-height:1.3pc;">
<div style="text-align: center; font-size: 20PX; font-weight: bold;">పుర పరిపాలన శాఖ </div>
<div style="text-align: center; font-size: 20PX; font-weight: bold; margin-top:5px;">పురపాలక సంఘం, సూర్యాపేట. </div>
<div style="text-align: center; font-size: 15PX;"><strong>తెలంగాణ - 508213</strong></div><br/>
<div style="text-align: center; font-size: 20px;"><strong>రసీదు</strong></div>


<div>
<table border="0" width="100%">
<tbody>
<tr>
<td align="left" width="50%" style="font-size:14px;">రసీదు సంఖ్య: <strong>{$row.apprec_id} </strong></td>
</tr>
<tr>
<td align="left" >తేది : <strong>{$row.apprec_date|date_format:"%d-%m-%Y %H:%M:%S"} </strong></td>
<td align="left">దరఖాస్తుదారు పేరు: <strong>{$row.apprec_name} </strong></td>
</tr>
<tr>
<td align="left">చిరునామా : <strong> {$row.apprec_address} </strong></td>
<td align="left">ఫోన్ : <strong>{$row.apprec_phone} </strong></td>
</tr>
<tr>
<td align="left">ఇమెయిల్ : <strong>{$row.apprec_email}</strong></td>
<td align="left">సేవ పేరు: <strong> {$service_list[$row.service_id]}</strong></td>
</tr>
<tr>
<td align="left">విభాగం యొక్క పేరు: <strong>{$section_list[$row.section_id]}</strong></td>
<td align="left">&nbsp;</td>
</tr>
<tr>
<td align="left">&nbsp;</td>
<td align="left">&nbsp;</td>
</tr>

</tbody>
</table>
<table border="0" width="701">
<tbody>
<tr>
<td width="346" align="left">ఇట్టి పని చేయుటకు భాధ్యుడైన అధికారి : </td>
<td width="345" align="left"><strong>{$designation_list[$row.emp_responsible]}</strong></td>
</tr>
<tr>
<td align="left">మీ సేవ గురించి పిర్యాదు చేయదలచిన లేదా సకాలంలో <br />
 అందని యెడల సంప్రదించవలసిన అధికారి : </td>
<td align="left"><strong> {$designation_list[$row.officer_responsible]}</strong></td>
</tr>
<tr>
<td align="left">మీ సేవను పూర్తి చేయవలసిన చివరి తేది : </td>
<td align="left"><strong>{$row.cutoff_date|date_format:"%d-%m-%Y"} </strong></td>
</tr>
<tr>
<td align="left">&nbsp;</td>
<td align="right">Signature of Receiver</td>
</tr>


<tr>
<td colspan="2" align="left">
<table border="0" width="100%">
<tbody>
<tr>
<td align="right" width="37%"> </td>

</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</center>

{/foreach}

<br><br>
{foreach from=$data key=apprec_id item=row}

<div class="my_heading">Application Received</div>
<div id="area">

<center>
<div style="width: 700px; height: 480px; border: #666666 2px solid; border-radius: 10px; padding: 5px 10px; line-height:1.3pc;">
<div style="text-align: center; font-size: 20PX; font-weight: bold;">పుర పరిపాలన శాఖ</div>
<div style="text-align: center; font-size: 20PX; font-weight: bold;  margin-top:5px;">పురపాలక సంఘం, సూర్యాపేట </div>
<div style="text-align: center; font-size: 15PX;"><strong>తెలంగాణ - 508213</strong></div><br/>
<div style="text-align: center; font-size: 20px;"><strong>రసీదు</strong></div>

<div>
<table border="0" width="100%">
<tbody>
<tr>
<td align="left" width="50%">రసీదు సంఖ్య:  <strong>{$row.apprec_id} </strong></td>
</tr>
<tr>
<td align="left">తేది : <strong>{$row.apprec_date|date_format:"%d-%m-%Y %H:%M:%S"} </strong></td>
<td align="left">దరఖాస్తుదారు పేరు: <strong>{$row.apprec_name} </strong></td>
</tr>
<tr>
<td align="left">చిరునామా : <strong> {$row.apprec_address} </strong></td>
<td align="left">ఫోన్ :  <strong>{$row.apprec_phone} </strong></td>
</tr>
<tr>
<td align="left">ఇమెయిల్  : <strong>{$row.apprec_email}</strong></td>
<td align="left">సేవ పేరు: <strong> {$service_list[$row.service_id]}</strong></td>
</tr>
<tr>
<td align="left">విభాగం యొక్క పేరు: <strong>{$section_list[$row.section_id]}</strong></td>
<td align="left">&nbsp;</td>
</tr>

</tbody>
</table>
<table border="0" width="701">
<tbody>
<tr>
<td width="346" align="left">ఇట్టి పని చేయుటకు భాధ్యుడైన అధికారి : </td>
<td width="345" align="left"><strong>{$designation_list[$row.emp_responsible]}</strong></td>
</tr>
<tr>
<td align="left">మీ సేవ గురించి పిర్యాదు చేయదలచిన లేదా సకాలంలో <br />
 అందని యెడల సంప్రదించవలసిన అధికారి : </td>
<td align="left"><strong> {$designation_list[$row.officer_responsible]}</strong></td>
</tr>
<tr>
<td align="left">మీ సేవను పూర్తి చేయవలసిన చివరి తేది : </td>
<td align="left"><strong>{$row.cutoff_date|date_format:"%d-%m-%Y"} </strong></td>
</tr>
<tr>
<td align="left">&nbsp;</td>
<td align="left">&nbsp;</td>
</tr>

<tr>
<td colspan="2" align="left">
<table border="0" width="100%">
<tbody>
<tr>

<td align="right" width="37%">Signature of Receiver<br /> </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</center>

{/foreach}
</div>
<input type='BUTTON' name='save' Onclick="window.location.href='application_received.php'" value='Go Back' style="background-color:#991f36; color:#FFF; border-radius:8px; cursor:pointer;">



</div>

{include file='footer_print.tpl'}<br />

{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            