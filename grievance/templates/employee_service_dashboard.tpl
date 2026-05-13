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



<div class="boxed">
    
    <div class="title-bar blue"><h4>{$deptname} Section -  Employee Service Dashboard</h4></div>
    <div class="inner no-radius">
        
        <table  id='example'  cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf"  width="100%">
<thead>
	  <tr style="background-color:#2c3e50;">
	  	<th align='center'><font color='white'>S.No</font></th>
	  	<th align='center'><font color='white'>Employee Name </font></th>
	   	<th align='center'><font color='white'>Received</font></th>  	
	  	<th align='center' colspan='2'><font color='white'>Pending</font></th>
	  	<th align='center' colspan='2'><font color='white'>Completed</font></th>
	   	<th align='center'><font color='white'>Un Resolvable</font></th>
	   	<th align='center'><font color='white'>Reopened</font></th>
	   	<th align='center'><font color='white'>Reopened underprogress</font></th>
	   	<th align='center'><font color='white'>Reopened Completed</font></th>
	   	<th align='center'><font color='white'>Rejected</font></th>
	   	<th align='center'><font color='white'>Financial Implication</font></th>
	  </tr>

</thead>
<tbody>
{foreach from=$emp_list key=dept_id item=row}

	<tr>
		<td>{counter}</td>
		<td><a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=0&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$emp_list[$dept_id]}</a></td>
		<td align='center'>{if $data[$dept_id].count neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=0&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$dept_id].count}</a>{else}-{/if}</td>
		<td align='center'>{if $data_list[$dept_id].pending neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=2&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].pending}</a>{else}-{/if}</a></td>
		<td align='center'><a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=8&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].pending_be_sla}</a></td>
		<td align='center'>{if $data_list[$dept_id].completed neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=3&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].completed}</a>{else}-{/if}</a></td>
		<td align='center'><a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=9&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].completed_be_sla}</a></td>
		<td align='center'>{if $data_list[$dept_id].unresolved neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=4&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].reopened neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=5&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].reopened}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].reopened_pending neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=6&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].reopened_pending}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].reopened_completed neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=7&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].reopened_completed}</a>{else}-{/if}</a></td>
		<td align='center'>{$data_list[$dept_id].rejected}</td>
	    <td align='center'>{if $data_list[$dept_id].fin neq ''}<a href="#" target="_blank">{$data_list[$dept_id].fin}</a>{else}-{/if}</a></td>
	</tr>
{/foreach}

</tbody>
<tfoot>
    <td colspan="2">Total</td>
    <td align='center'>{$tot.received}</td>
    <td align='center'>{$tot.pending}</td>
    <td align='center'>{$tot.pending_be_sla}</td>
    <td align='center'>{$tot.completed}</td>
    <td align='center'>{$tot.completed_be_sla}</td>
    <td align='center'>{$tot.unresolved}</td>
    <td align='center'>{$tot.reopened}</td>
    <td align='center'>{$tot.reopened_pending}</td>
    <td align='center'>{$tot.reopened_completed}</td>
    <td align='center'>{$tot.rejected}</td>
    <td align='center'>{$tot.fin}</td>
</tfoot>
</table>
        
        
    </div>
    
</div>


<a href="department_dashboard.php">Employees Complaints dashboard</a>


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