{include file='header.tpl'}
{literal}
<script language="javascript">
$(document).ready(function() {

            $('#example> tbody > tr:odd').css("background-color", "lightblue");

 });
</script>

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

{/literal}
<div  id="area" >

<table  id='example'  cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf"  width="100%">
<thead>
	  <tr style="background-color:#2c3e50;">
	  	<th align='center'><font color='white'>S.No</font></th>
	  	<th align='center'><font color='white'>Emp.Name</font></th>
	   	<th align='center'><font color='white'>Received</font></th>  	
	  	<th align='center'><font color='white'>Pending</font></th>
	  	<th align='center'><font color='white'>Completed</font></th>
	   	<th align='center'><font color='white'>Un Resolvable</font></th>
	  </tr>

</thead>
<tbody>
{foreach from=$emp_list key=emp_id item=row}
	<tr>
		<td>{counter}</td>
		<td>{$emp_list[$emp_id]}</td>
		<td align='center'>{if $data[$dept_id].count neq ''}<a href="comp_det.php?app_type_id=2&dept_id={$dept_id}&status=0">{$data[$dept_id].count}</a>{else}-{/if}</td>
		<td align='center'>{if $data_list[$dept_id].pending neq ''}<a href="comp_det.php?app_type_id=2&dept_id={$dept_id}&status=2">{$data_list[$dept_id].pending}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].completed neq ''}<a href="comp_det.php?app_type_id=2&dept_id={$dept_id}&status=3">{$data_list[$dept_id].completed}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].unresolved neq ''}<a href="comp_det.php?app_type_id=2&dept_id={$dept_id}&status=4">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</a></td>
	</tr>
{/foreach}

</tbody>
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