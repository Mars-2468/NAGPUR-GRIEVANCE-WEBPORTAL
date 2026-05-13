{include file='header.tpl'}
{literal}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script language="javascript">
function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}
</script>
{/literal}	

<div style="border:#999999 0px solid;  min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<div id="div_print">
<div style="width: 700px; height: 486px; border: #666666 2px solid; border-radius: 10px; padding: 5px 10px; margin:0 auto; background-color:#FFF;">
<table width="97%" border="0" align="center">
  <tr>
    <td width="90%" height="82" align="center"><!--<img src="{$logo}"/>-->
      <table width="69%" border="0">
        <tr>
          <td align="center"><strong style="font-size:20px;">పురపాలక సంఘ కార్యాలయము :బోడుప్పల్</strong>
              <div style="font-size:16px;"> మేడ్చల్ జిల్లా </div>
            <div style="font-size:13px;"> Phone No:040-27215959 </div>
            <br/>
            {$data2.comp_desc}</td>
        </tr>
      </table></td>
    <td width="10%" align="right" valign="top">Original</td>
  </tr>
</table>

  
  <br>
  <div style="float:left;">ఫైల్ నెం {$data2.ref_no}</div>
  <div style="float:right;">తేది {$data2.date}</div>
  <br>
<div style="text-align: left; font-size: 14px; ">&nbsp;  <span style="color:#000;">శ్రీ / శ్రీమతి  </span>&nbsp;{$data.person_name}, {$data.mobile}<span style="color:#000;"> ఇంటి నెంబర్</span> {$data.hno}, {$data.address }  గారి నుండి </span>{$data2.comp_desc}  కొరకు ధరఖాస్తు జారీ కోరుతూ {$data2.date} తేదిన, దరఖాస్తు స్వీకరించబడింది. ఇట్టి దృవీకరణ పత్రమును తేది {$data.cutt_of_time} తేదిన, మ || 2.00గం || నుండి సా || 5.00 గం|| ల వరకు అర్జీదారునకు జారీ చేయబడును.<br />

<br /><br />

<strong>సూచన:</strong><br />


1. {$data2.cutt_of_time} రోజుల లోపల కోరిన {$data2.comp_desc} జారి చేయబడనిచో కలిగిన అసౌకర్యమునకు వెంటనే మునిసిపల్ కమిషనర్ గారికి సంప్రదించవచ్చును.
<br> <br />

2. 
నిర్దేశించిన గడువు వరకు <span>{$data2.comp_desc_substr}</span> ఆజ్ఞాపత్రం ఇవ్వనట్లయితే  మీ విలువైన కాలమునకు నష్టపరిహారంగా ఆలస్యమైనా ప్రతి రోజుకు రూ ||  50-00 చెల్లింపబడును. </div> 

<br>
<div style="text-align:right;"></div>
<div style="text-align:right;"><strong></strong></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="59%">&nbsp;</td>
    <td width="41%" align="center">పౌరసేవా కేంద్ర సహాయకులు<br>
      పురపాలక సంఘ కార్యాలయము, బోడుప్పల్</td>
  </tr>
</table>


</div>
<br>

<div style="width: 700px; height: 486px; border: #666666 2px solid; border-radius: 10px; padding: 5px 10px; margin:0 auto; background-color:#FFF;">
  <table width="97%" border="0" align="center">
    <tr>
      <td width="90%" height="82" align="center"><!--<img src="{$logo}"/>-->
          <table width="69%" border="0">
            <tr>
              <td align="center"><strong style="font-size:20px;">పురపాలక సంఘ కార్యాలయము :బోడుప్పల్</strong>
                  <div style="font-size:16px;"> మేడ్చల్ జిల్లా </div>
                <div style="font-size:13px;"> Phone No:040-27215959 </div>
                <br/>
                {$data2.comp_desc}</td>
            </tr>
        </table></td>
      <td width="10%" align="right" valign="top">Duplicate</td>
    </tr>
  </table>
  <br>
  <div style="float:left;">ఫైల్ నెం {$data2.ref_no}</div>
  <div style="float:right;">తేది {$data2.date}</div>
  <br>
  <div style="text-align: left; font-size: 14px; ">&nbsp; <span style="color:#000;">శ్రీ / శ్రీమతి </span>&nbsp;{$data.person_name}, {$data.mobile}<span style="color:#000;"> ఇంటి నెంబర్</span> {$data.hno}, {$data.address }  గారి నుండి </span>{$data2.comp_desc}  కొరకు ధరఖాస్తు జారీ కోరుతూ {$data2.date} తేదిన, దరఖాస్తు స్వీకరించబడింది. ఇట్టి దృవీకరణ పత్రమును తేది {$data.cutt_of_time} తేదిన, మ || 2.00గం || నుండి సా || 5.00 గం|| ల వరకు అర్జీదారునకు జారీ చేయబడును.<br />
      <br />
    <br />
      <strong>సూచన:</strong><br />
    1. {$data2.cutt_of_time} రోజుల లోపల కోరిన {$data2.comp_desc} జారి చేయబడనిచో కలిగిన అసౌకర్యమునకు వెంటనే మునిసిపల్ కమిషనర్ గారికి సంప్రదించవచ్చును. <br>
    <br />
    2. 
    నిర్దేశించిన గడువు వరకు <span>{$data2.comp_desc_substr}</span> ఆజ్ఞాపత్రం ఇవ్వనట్లయితే  మీ విలువైన కాలమునకు నష్టపరిహారంగా ఆలస్యమైనా ప్రతి రోజుకు రూ ||  50-00 చెల్లింపబడును. </div>
  <br>
  <div style="text-align:right;"></div>
  <div style="text-align:right;"><strong></strong></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="59%">&nbsp;</td>
      <td width="41%" align="center">పౌరసేవా కేంద్ర సహాయకులు<br>
        పురపాలక సంఘ కార్యాలయము, బోడుప్పల్</td>
    </tr>
  </table>
</div>

</div>
<br>

</center>


</div>
</div>

</div>
<br>
<center>
<button type="button" onClick="printdiv('div_print');" value=" Print" class="btn btn-primary">
<span class="fa fa-print"></span>
Print
</button> 
</center>
<br>

{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            