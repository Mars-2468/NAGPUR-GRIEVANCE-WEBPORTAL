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
function save_eoffice_no()
{
    var eofficeno=$("#eoffice_no").val();
    var ref_no=$("#ref_no").val();
    
    $.post('ajax_save_eoffice.php',{eofficeno:eofficeno,ref_no:ref_no},function(data)
    {
        $("#eoffice_no").val('');
        alert(data);
    });
}
</script>


{/literal}


{if $apptype_id eq '2' || $aptid eq '2'}
<div style="width:100%; text-align:center">
E- Office no: <input type="text" id="eoffice_no"> <input type="hidden" name="ref_no" id="ref_no" value="{$data2.ref_no}"><input type="button" onclick="save_eoffice_no()" value="UPDATE">

{if $user_type neq 'AG'}
&nbsp;&nbsp;&nbsp;&nbsp;<a href="register_comp_helpline.php?app_type_id={$apptype_id}" class="btn btn-success">ADD NEW SERVICE / COMPLAINT</a>
{else}
&nbsp;&nbsp;&nbsp;&nbsp;<a href="create_grievance.php" class="btn btn-success">ADD NEW SERVICE / COMPLAINT</a>
{/if}
{/if}
<!--<a href="register_comp_helpline.php" class="btn btn-success">ADD NEW SERVICE / COMPLAINT</a>-->
</div>






<div style="border:#999999 0px solid;  min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<div id="div_print">
<div style=" border: #666666 2px solid; border-radius: 10px; padding: 5px 10px; margin:0 auto; background-color:#FFF;">
<table width="97%" border="0" align="center">
  <tr>
    <td height="82" align="center"><table width="50%" border="0">
      <tr>
        <td align="center"><strong style="font-size:20px;">{$ulb_det.ulbnametelugu} Municipal Corporation</strong><br />
         </td>
      </tr>
    </table></td>
    </tr>
</table>

  <div style="text-align: center; font-size: 18px;"><strong>Receipt</strong></div>
  
  <br>
  <div style="float:left;">Sno.{$data2.ref_no}</div>
  <div style="float:right;">Date{$data2.date}</div>
  <br>
<div style="text-align: left; font-size: 14px; ">&nbsp;  <span style="color:#000;">Sri/smt </span>&nbsp;{$data.person_name} <span style="color:#000;">Hno.</span> {$data.hno}   <span style="color:#000;">Address</span> {$data.address } <span style="color:#000;"> {$ulb_det.ulbnametelugu}  </span>{$data2.comp_desc}  Completed on Date {$data.cutt_of_time} <br />
Person Mobile{$data.mobile},Employee name {$empdata.emp_name} Employee mobile {$empdata.emp_mobile}
<br /><br />
{if $apptype_id eq '1'}

<br />
<br />
{else}



<br />
<br />


{/if}


<br>
<div style="text-align:right;"><strong>Officer     </strong> </div>


</div>


<div></div>
</div>
<br>
<div style="border:#999999 0px solid;  min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<div id="div_print2">
<div style=" border: #666666 2px solid; border-radius: 10px; padding: 5px 10px; margin:0 auto; background-color:#FFF;">
<table width="97%" border="0" align="center">
  <tr>
    <td height="82" align="center"><table width="50%" border="0">
      <tr>
        <td align="center"><strong style="font-size:20px;">{$ulb_det.ulbnametelugu} Municipal Corporation</strong><br />
         </td>
      </tr>
    </table></td>
    </tr>
</table>

  <div style="text-align: center; font-size: 18px;"><strong>Receipt</strong></div>
  
  <br>
  <div style="float:left;">Sno.{$data2.ref_no}</div>
  <div style="float:right;">Date{$data2.date}</div>
  <br>
<div style="text-align: left; font-size: 14px; ">&nbsp;  <span style="color:#000;">Sri/smt </span>&nbsp;{$data.person_name} <span style="color:#000;">Hno.</span> {$data.hno}   <span style="color:#000;">Address</span> {$data.address } <span style="color:#000;"> {$ulb_det.ulbnametelugu}  </span>{$data2.comp_desc}  Completed on Date {$data.cutt_of_time} <br />
Person Mobile{$data.mobile},Employee name {$empdata.emp_name} Employee mobile {$empdata.emp_mobile}
<br /><br />
{if $apptype_id eq '1'}

<br />
<br />
{else}



<br />
<br />


{/if}


<br>
<div style="text-align:right;"><strong>Officer     </strong> </div>


</div>


<div></div>
</div>






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
                            
                            
                            
                            
                            
                            
                            