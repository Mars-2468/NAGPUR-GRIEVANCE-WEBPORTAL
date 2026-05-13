{include file='header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="all">
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

<div id="searcharea">
     <form method="POST" class="form-horizontal">


<div class="boxed">
    
    <div class="title-bar blue"></div>
    
    <div class="inner no-radius">
       
       <div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date</label>
  <input type="text" class="phone-group form-control datepicker"  name="f_date" value="{$fdate}" placeholder="select date" autocomplete="off">
  
</div>
</div>      


<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date</label>
  <input type="text" class="phone-group form-control datepicker"  name="t_date" value="{$tdate}" placeholder="select date" autocomplete="off">
  
</div>
</div>

 <div class="col-md-2"  >
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
        
        <div  id="area" >

<table  id='example'  cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf"  width="100%">
<thead>
	  <tr style="background-color:#2c3e50;">
	  	<th align='center'><font color='white'>S.No</font></th>
	  	
	  	<th align='center'><font color='white'>Department</font></th>
	   	<th align='center'><font color='white'>Received</font></th>  	
	  	<th align='center' colspan="2"><font color='white'>Pending</font></th>
	  	<th align='center' colspan="2"><font color='white'>Completed</font></th>
	   	<th align='center'><font color='white'>Un Resolvable</font></th>
	   	<th align='center'><font color='white'>Rejected</font></th>
	  </tr>

</thead>
<tbody>
{foreach from=$dept_list key=dept_id item=row}
	<tr>
		<td>{counter}</td>
		
		<td><a href="dept_empwise.php?app_type_id=2&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}">{$dept_list[$dept_id]}</a></td>
	
		
		<td align='center'>{if $data[$dept_id].count neq ''}<a href="dept_empwise.php?app_type_id=2&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}">{$data[$dept_id].count}</a>{else}-{/if}</td>
		<td align='center'>{if $data_list[$dept_id].pending neq ''}<a href="dept_empwise.php?app_type_id=2&dept_id={$dept_id}&status=2&f_date={$fdate}&t_date={$tdate}&sla_status=1">{$data_list[$dept_id].pending}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].pending_be neq ''}<a href="dept_empwise.php?app_type_id=2&dept_id={$dept_id}&status=2&f_date={$fdate}&t_date={$tdate}&sla_status=2">{$data_list[$dept_id].pending_be}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].completed neq ''}<a href="dept_empwise.php?app_type_id=2&dept_id={$dept_id}&status=3&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].completed}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].completed_be neq ''}<a href="dept_empwise.php?app_type_id=2&dept_id={$dept_id}&status=3&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].completed_be}</a>{else}-{/if}</a></td>
		<td align='center'>{if $data_list[$dept_id].unresolved neq ''}<a href="dept_empwise.php?app_type_id=2&dept_id={$dept_id}&status=4&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</a></td>
	<td align='center'>{if $data_list[$dept_id].rejected neq ''}<a href="#">{$data_list[$dept_id].rejected}</a>{else}-{/if}</a></td>
	</tr>
{/foreach}

</tbody>
<tfoot>
    <td colspan='2'>Total</td>
    <td>{$tot.received}</td>
    <td>{$tot.pending}</td>
    <td>{$tot.pending_be}</td>
    <td>{$tot.completed}</td>
    <td>{$tot.completed_be}</td>
    <td>{$tot.unresolved}</td>
    <td>{$tot.rejected}</td>
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