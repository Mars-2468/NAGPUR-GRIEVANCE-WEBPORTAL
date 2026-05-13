{include file='header.tpl'}
{literal}
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>

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

<br><br><br>

<div class="" style="margin-top: -45px;">
    <form method="POST" class="form-horizontal">



<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">From Date:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control datepicker"  name="f_date" value="{$fdate}">
  </div>
</div>
</div>      


<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">To Date:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control datepicker"  name="t_date" value="{$tdate}">
  </div>
</div>
</div>  
 
  <div class="col-md-2" align="right"><input name="search" type="submit" class="btn btn-success" value="SEARCH"> </div>   
   
 </form>
 </div>
</br></br></br></br>








<div  id="area" >

<table  id='example'  cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf"  width="100%">
<thead>
	  <tr style="background-color:#2c3e50;">
	  	<th align='center'><font color='white'>S.No</font></th>
	  <!--	<th align='center'><font color='white'>Id</font></th>-->
	  	<th align='center'><font color='white'>Department</font></th>
	   	<th align='center'><font color='white'>Received</font></th>  	
	  	<th align='center'><font color='white'>Pending</font></th>
	  	<th align='center'><font color='white'>Redressed</font></th>
	   	<th align='center'><font color='white'>Un Resolvable</font></th>
	   	<th align='center'><font color='white'>Reopened</font></th>
	  </tr>

</thead>
<tbody>
{foreach from=$dept_list key=dept_id item=row}
	<tr>
		<td>{counter}</td>
			<!--<td>{$dept_id}</td>-->
		<td>{$dept_list[$dept_id]}</td>
	
		<td align='center'>{if $data[$dept_id].count neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$dept_id].count}</a>{else}-{/if}</td>
		<td align='center'>{if $data_list[$dept_id].pending neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=2&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].pending}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].completed neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=3&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].completed}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].unresolved neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=4&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</a></td>
		<td align='center'>{$data_list[$dept_id].reopened}</td>
	</tr>
{/foreach}

</tbody>

<tfoot>
    <td colspan='2'>Total</td>
    <td>{$tot.received}</td>
    <td>{$tot.pending}</td>
    <td>{$tot.completed}</td>
    <td>{$tot.unresolved}</td>
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


<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
{include file='footer.tpl'}



<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>
$(function() {
    $( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>











