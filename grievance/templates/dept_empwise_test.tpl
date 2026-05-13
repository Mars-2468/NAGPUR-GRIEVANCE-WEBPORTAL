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

<style>
    
    th{
        text-align:center !important;
    }
	a{
	color:blue;
	text-decoration: underline;
	}
    
</style>


{/literal}
<div  id="area" >



<div class="boxed">
    
    <div class="title-bar blue"><h4>Department: {$dept_list[$dept_id1]}</h4></div>
    <div class="inner no-radius">
        
       <!-- <form method="GET" class="form-horizontal">
                <input type="hidden" name="ulbid" value="{$ulbid}">
                <input type="hidden" name="app_type_id" value="{$app_type_id}">
                <input type="hidden" name="dept_id" value="{$dept_id1}">
        
        
        
        
        



<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">From Date:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control datepicker"  name="f_date" value="{$fdate}" autocomplete="off">
  </div>
</div>
</div>      


<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">To Date:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control datepicker"  name="t_date" value="{$tdate}" autocomplete="off">
  </div>
</div>
</div>  
 
  <div class="col-md-4" align="right"><input name="search" type="submit" class="btn btn-success" value="SEARCH"> </div>   
   
 </form>-->
 <div style="text-align:right;"><a href="rep_comp_dept_abs_comp.php?active=tr-clmn" class="btn btn-warning" onclick="history.go(-1);"><i class="fa fa-backward"></i> Back</a></div>
        
        
        <table  id='example'  cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf"  width="100%">
<thead>
	  <tr style="background-color:#2c3e50; color:#FFF; text-align:center;">
	  	<th align='center' rowspan='2'>S.No</th>
	  	<th align='center' rowspan='2'>Employee Name </th>
		<th align='center' rowspan='2'>Zone Name </th>
		<th align='center' rowspan='2'>Ward Name </th>
	   	<th align='center' rowspan='2'>Received</th>  	
	  	<th align='center' colspan='2'>Pending</th>
	  	<th align='center' colspan='2'>Completed</th>
	   	<th align='center' rowspan='2'>Un Resolvable</th>
	   	<th align='center' rowspan='2'>Reopened</th>
	   	<th align='center' rowspan='2'>Reopened underprogress</th>
	   	<th align='center' rowspan='2'>Reopened Completed</th>
	   	<th align='center' rowspan='2'>Rejected</th>
	   	<th align='center' rowspan='2'>Financial Implication</th>
	  </tr>
	  <tr style="background-color:#2c3e50; color:#FFF; text-align:center;">
	      <th>With in SLA</th>
	      <th>Beyond SLA</th>
	      
	      <th>With in SLA</th>
	      <th>Beyond SLA</th>
	  </tr>

</thead>
<tbody>

{foreach from=$emp_list key=dept_id item=row}

	<tr>
		<td>{counter}</td>
		<td><a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=0&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$emp_list[$dept_id]}</a></td>
		
		<td>{$zone_ids[$dept_id]}</td>
		<td>{$street_ids[$dept_id]}</td>
		
		
		<td align='center'>{if $data[$dept_id].count neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=0&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data[$dept_id].count}</a>{else}-{/if}</td>
		<td align='center'>{if $data_list[$dept_id].pending neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=2&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].pending}</a>{else}-{/if}</a></td>
		<td align='center'><a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=8&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].pending_be_sla}</a></td>
		<td align='center'>{if $data_list[$dept_id].completed neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=3&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].completed}</a>{else}-{/if}</a></td>
		<td align='center'><a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=9&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].completed_be_sla}</a></td>
		<td align='center'>{if $data_list[$dept_id].unresolved neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=4&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].reopened neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=5&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].reopened}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].reopened_pending neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=6&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].reopened_pending}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].reopened_completed neq ''}<a href="comp_det1.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=7&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].reopened_completed}</a>{else}-{/if}</a></td>
		<td align='center'>{$data_list[$dept_id].rejected}</td>
	    <td align='center'>{if $data_list[$dept_id].fin neq ''}<a href="#" target="">{$data_list[$dept_id].fin}</a>{else}-{/if}</a></td>
	</tr>
{/foreach}

</tbody>
<tfoot>
    <td colspan="2">Total</td>
	<td></td>
	<td></td>
    <td align='center'><a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$dept_id1}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}">{$tot.received}</a></td>
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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>
$(function() {
    $( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>
