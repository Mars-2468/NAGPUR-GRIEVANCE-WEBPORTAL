{include file='header.tpl'}
{literal}
<script language="javascript">
$(document).ready(function() {

            $('#example> tbody > tr:odd').css("background-color", "lightblue");

 });
</script>
 
{/literal}
<div id="area" style="margin-top:5px; ">
<center>
<h2>REPORT SHOWING DAYS TAKEN FOR REDRESSAL OF GRIEVANCE</h2>
</center>
<table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
<thead>
  <tr style="background-color:#2c3e50; color:#FFF;">
  	<th   align='center' rowspan='2'> S.No </th>
  	<th   align='center' rowspan='2'> Department </th>
   	<th   align='center' colspan='5'> Redressed </th>  	
  	<th   align='center' colspan='5'> Un Resolvable </th>

  </tr>
  <tr style="background-color:#2c3e50; color:#FFF;">
	<th   align='center'> < 7 days </th>  
	<th   align='center'> 7-15 days </th>
	<th   align='center'> 15-30 days </th>
	<th   align='center'> > 30 days </th>
	<th   align='center'> Total </th>

	<th   align='center'> < 7 days </th>  
	<th   align='center'> 7-15 days </th>
	<th   align='center'> 15-30 days </th>
	<th   align='center'> > 30 days </th>
	<th   align='center'> Total </th>
	
  <tr>

</thead>
<tbody>
{foreach from=$dept_list key=dept_id item=dept_desc}
<tr>
	<td>{counter}</td>
	<td>{$dept_desc}</td>

	<td align='right'>{$data[$dept_id].3.lt_7}</td>
	<td align='right'>{$data[$dept_id].3.lt_15}</td>
	<td align='right'>{$data[$dept_id].3.lt_30}</td>
	<td align='right'>{$data[$dept_id].3.gt_30}</td>
	<td align='right'>{$data[$dept_id].3.tot}</td>
	
	<td align='right'>{$data[$dept_id].4.lt_7}</td>
	<td align='right'>{$data[$dept_id].4.lt_15}</td>
	<td align='right'>{$data[$dept_id].4.lt_30}</td>
	<td align='right'>{$data[$dept_id].4.gt_30}</td>
	<td align='right'>{$data[$dept_id].4.tot}</td>	


</tr>
{/foreach}
{if $user_dept eq '0'}
<tr>
	<td   align='center' colspan='2'>Total</td>

	<td   align='right'> {$tot.3.lt_7} </td>
	<td   align='right'> {$tot.3.lt_15} </td>
	<td   align='right'> {$tot.3.lt_30} </td>
	<td   align='right'> {$tot.3.gt_30} </td>
	<td   align='right'> {$tot.3.tot} </td>
	
	<td   align='right'> {$tot.4.lt_7} </td>
	<td   align='right'> {$tot.4.lt_15} </td>
	<td   align='right'> {$tot.4.lt_30} </td>
	<td   align='right'> {$tot.4.gt_30} </td>
	<td   align='right'> {$tot.4.tot} </td>	


</tr>
{/if}
</tbody>
</table>
</div>


<div>

<br>
<br>
<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>
</div>


<br>





{include file='footer.tpl'}