{include file='boduppal_header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css" type="text/css" media="all">

 <script language='javascript'>
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
<script>

function print_div()
{
            var divContents = $("#area").html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
}
</script>



<script>
$(document).ready(function(){
    $(".datepick").datepicker({ maxDate:+2000,dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true});

});
</script>
{/literal}

<br><br>

<div class="" style="margin-top: -45px;">
    <form method="POST" class="form-horizontal">


<div class="boxed">
    
    <div class="title-bar blue"></div>
    <div class="inner no-radius">
   <!--{if $ulb eq '208' || $ulb eq '210' || $ulb eq '3'}     
<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">Village:</label>
  
   <select name="ulbid"  class="form-control">
              <option value="">--select--</option>
              {html_options options=$villages selected=$ulb}
          </select>
  
</div>
</div>
{/if}-->
<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
  
  <input type="text" class="phone-group form-control datepicker"  name="f_date" value="{$fdate}" placeholder="Select Date">
  
</div>
</div>      


<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
 
  <input type="text" class="phone-group form-control datepicker"  name="t_date" value="{$tdate}" placeholder="Select Date">
  
</div>
</div>  
 
  <div class="col-md-2" >
       <div class="form-group" style="margin-top:31px;">
        <input name="search" type="submit" class="btn btn-success" value="SEARCH"> 
       </div>
      </div>   
   
   
    </div>
    
    
</div>


 </form>
 </div>



<div class="boxed">
    <div class="title-bar blue"></div>
    <div class="inner no-radius">
        
        <div  id="area">

<table  id='example'  cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf"  width="100%">
<thead>
	  <tr style="background-color:#2c3e50; color:#FFF;">
	  	<th align='center' rowspan='2'> S.No </th>
	  <!--	<th align='center'> Id </th>-->
	  	<th align='center' rowspan='2'> Department </th>
	   	<th align='center' rowspan='2'> Received </th>  	
	  	<th colspan='2'> Under Progress </th>
	  	<th colspan='2'>Redressed </th>
	   	<th align='center' rowspan='2'>Un Resolvable </th>
	   	<th align='center' rowspan='2'>Reopened </th>
	   	<th align='center' rowspan='2'>Reopened underprogress </th>
	   	<th align='center' rowspan='2'>Reopened completed </th>
	   	<th align='center' rowspan='2'>Rejected </th>
	   	<th align='center' rowspan='2'>Financial Implication </th>
	  </tr>
	  
	  <tr style="background-color:#2c3e50; color:#FFF;">
	      
	   <th align='center'>Within SLA </th>
	   <th align='center'>Beyond SLa </th>
	   <th align='center'>Within SLA </th>
	   <th align='center'>Beyond SLa </th>
	      
	  </tr>

</thead>
<tbody>
{foreach from=$dept_list key=dept_id item=row}
	<tr >
		<td>{counter}</td>
			<!--<td>{$dept_id}</td>-->
		<td><a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}">{$dept_list[$dept_id]}</a></td>
	
		<td align='center'>{if $data[$dept_id].count neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$dept_id].count}</a>{else}-{/if}</td>
		<td align='center'>{if $data_list[$dept_id].pending neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=2&f_date={$fdate}&t_date={$tdate}&sla_status=1" target="_blank">{$data_list[$dept_id].pending}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].pending_be neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=2&f_date={$fdate}&t_date={$tdate}&sla_status=2" target="_blank">{$data_list[$dept_id].pending_be}</a>{else}-{/if}</td>
		<td align='center'>{if $data_list[$dept_id].completed neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=3&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].completed}</a>{else}-{/if}</a></td>
		<td align='center'>{$data_list[$dept_id].completed_be_sla}</td>
		<td align='center'>{if $data_list[$dept_id].unresolved neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=4&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</a></td>
		<td align='center'>{$data_list[$dept_id].reopened} </td>
		<td align='center'>{$data_list[$dept_id][11].reopend_underProgress} </td>
		<td align='center'>{$data_list[$dept_id].reopend_completed} </td>
		<td align='center'>{$data_list[$dept_id].rejected} </td>
		<td align='center'>{$data_list[$dept_id].fin} </td>
	</tr>
{/foreach}

</tbody>

<tfoot>
    <td colspan='2'>Total</td>
    <td align='center'>{$tot.received}</td>
    <td align='center'>{$tot.pending}</td>
    <td align='center'>{$tot.pending_be}</td>
    <td align='center'>{$tot.completed}</td>
    <td align='center'>{$tot.completed_be_sla}</td>
    <td align='center'>{$tot.unresolved}</td>
    <td align='center'>{$tot.reopened}</td>
    
    <td align='center'>{$tot[11].reopend_underProgress}</td>
    <td align='center'>{$tot.reopend_completed.count}</td>
    <td align='center'>{$tot.rejected}</td>
    <td align='center'>{$tot.fin}</td>
    
</tfoot>
</table>
</div>

<br>
<div>
<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>
</div>

        
    </div>
</div>




<br>




<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
{include file='footer.tpl'}



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>

$(function() {
    $( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>











