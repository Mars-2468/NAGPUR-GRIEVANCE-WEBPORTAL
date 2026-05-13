{include file='header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="all">

    <style>
        .activ_column{
            background-color: #7ac18a;
            color: white !important;
        }
        .activ_column a{
            /*background-color: #54B435;*/
            color:#FFF !important;
            /*text-shadow: 0 0 3px #FFFF;*/
            text-decoration: underline #1C82AD;  
        }
		a{
	color:blue;
	text-decoration: underline;
	}
          
    </style>

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
    <!--<form method="POST" class="form-horizontal">


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
{/if}-
<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
  
  <input type="text" class="phone-group form-control datepicker"  name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">
  
</div>
</div>      


<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
 
  <input type="text" class="phone-group form-control datepicker"  name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">
  
</div>
</div>  
 
  <div class="col-md-2" >
       <div class="form-group" style="margin-top:31px;">
        <input name="search" type="submit" class="btn btn-success" value="SEARCH"> 
       </div>
      </div>   
   
   
    </div>
    
    
</div>


 </form>-->
 </div>

<div style="text-align:right;"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div>

<div class="boxed">
    
    <div class="inner no-radius">
        
        <div  id="area">

<table  id='example'  cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf"  width="100%">
<thead>
	  <tr style="background-color:#2c3e50; color:#FFF;">
	  	<th align='center' rowspan='2'> S.No </th>
	  <!--	<th align='center'> Id </th>-->
	  	<th align='center' rowspan='2'> Employee name </th>
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
	   <th align='center'>Beyond SLA </th>
	   <th align='center'>Within SLA </th>
	   <th align='center'>Beyond SLA </th>
	      
	  </tr>

</thead>
<tbody>

{assign var="tot_progress_in_sla" value="0"}
{assign var="tot_progress_beyond_sla" value="0"}
{assign var="tot_completed_in_sla" value="0"}
{assign var="tot_completed_beyond_sla" value="0"}
{assign var="tot_unresolved" value="0"}
{assign var="tot_reopened" value="0"}
{assign var="tot_reopend_underProgress" value="0"}
{assign var="tot_reopend_completed" value="0"}
{assign var="tot_rejected" value="0"}
{assign var="tot_fin" value="0"}
{assign var="dept_received" value="0"}



{foreach from=$dept_list key=dept_id item=row}
{$tot_progress_in_sla = $tot_progress_in_sla+$data[$dept_id][2][1]['count']}
{$tot_progress_beyond_sla = $tot_progress_beyond_sla+$data[$dept_id][2][2]['count']}
{$tot_completed_in_sla = $tot_completed_in_sla+$data[$dept_id][9][1]['count']}
{$tot_completed_beyond_sla = $tot_completed_beyond_sla+$data[$dept_id][9][2]['count']}
{$tot_unresolved = $tot_unresolved+$data[$dept_id][4][1]['count']+$data[$dept_id][4][2]['count']}
{$tot_reopened = $tot_reopened+$data[$dept_id][13][1]['count']+$data[$dept_id][13][2]['count']}
{$tot_reopend_underProgress = $tot_reopend_underProgress+$data[$dept_id][11][1]['count']+$data[$dept_id][11][2]['count']}
{$tot_reopend_completed = $tot_reopend_completed+$data[$dept_id][12][1]['count']+$data[$dept_id][12][2]['count']}
{$tot_rejected = $tot_rejected+$data[$dept_id][10][1]['count']+$data[$dept_id][10][2]['count']}
{$tot_fin = $tot_fin+$data[$dept_id][6][1]['count']+$data[$dept_id][6][2]['count']}
{$dept_received = $dept_received+$data[$dept_id]['count']}

	<tr >
		<td>{counter}</td>
			<!--<td>{$dept_id}</td>-->
		<td><a href="level_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}">{$dept_list[$dept_id]}</a></td>
	
		<td align='center' class="{if $active_class eq 'tr-clmn'}activ_column{/if}">{if $data[$dept_id].count neq ''}<a href="level_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="">{$data[$dept_id]['count']}</a>{else}-{/if}</td>
		<td align='center' class="{if $active_class eq 'pwsla-clmn'}activ_column{/if}">{if $data[$dept_id][2][1]['count'] neq ''}<a href="level_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=2&f_date={$fdate}&t_date={$tdate}&sla_status=1" target="">{$data[$dept_id][2][1]['count']}</a>{else}-{/if}</a></td>
		<td align='center' class="{if $active_class eq 'rbsla-clmn'}activ_column{/if}">{if $data[$dept_id][2][2]['count'] neq ''}<a href="level_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=2&f_date={$fdate}&t_date={$tdate}&sla_status=2" target="">{$data[$dept_id][2][2]['count']}</a>{else}-{/if}</td>
		<td align='center' class="{if $active_class eq 'rwsla-clmn'}activ_column{/if}">{if $data[$dept_id][9][1]['count'] neq ''}<a href="level_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=3&f_date={$fdate}&t_date={$tdate}" target="">{$data[$dept_id][9][1]['count']}</a>{else}-{/if}</a></td>
		<td align='center' class="{if $active_class eq 'rdbsla-clmn'}activ_column{/if}" >{$data[$dept_id][9][2]['count']}</td>
		<td align='center'><a href="level_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=4&f_date={$fdate}&t_date={$tdate}" target="">{{$data[$dept_id][4][2]['count']}}</a></td>
		<td align='center'>{$data[$dept_id][13][2]['count'] + $data[$dept_id][13][1]['count']} </td>
		<td align='center'>{$data[$dept_id][11][2]['count'] + $data[$dept_id][11][1]['count']} </td>
		<td align='center'>{$data[$dept_id][12][2]['count'] + $data[$dept_id][12][1]['count']} </td>
		<td align='center'>{$data[$dept_id][10][2]['count'] + $data[$dept_id][10][1]['count']}</td>
		<td align='center'>{$data[$dept_id][6][2]['count'] + $data[$dept_id][6][1]['count']} </td>
	</tr>
{/foreach}

</tbody>

<tfoot>
    <td colspan='2'>Total</td>
    <td align='center'><a href="TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}">{$dept_received}</a></td>
    <td align='center'>{$tot_progress_in_sla}</td>
    <td align='center'>{$tot_progress_beyond_sla}</td>
	<td align='center'>{$tot_completed_in_sla}</td>
    <td align='center'>{$tot_completed_beyond_sla}</td>
    
    <td align='center'>{$tot_unresolved}</td>
    <td align='center'>{$tot_reopened}</td>
    <td align='center'>{$tot_reopend_underProgress}</td>
    <td align='center'>{$tot_reopend_completed}</td>
    <td align='center'>{$tot_rejected}</td>
    <td align='center'>{$tot_fin}</td>
    
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











