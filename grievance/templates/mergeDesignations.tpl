{include file='header.tpl'}
{literal}
<script>
	function fill(dept_id,dept_desc)
	{
		document.manage_dept.dept_id.value=dept_id;
		document.manage_dept.dept_desc.value=dept_desc;
	} 
	
	function validateForm()
	{
		var dept_desc=document.manage_dept.dept_desc.value;		
		if(dept_desc=='')
		{
			alert("Please Enter Department Name");
			return false;
		}
		
		return true;
	}
	
	function delete_rec(dept_id)
	{
		if(confirm('Do you really want to delete this record'))
		{
			var csrf_token=$("#csrf_token").val();
			$.post('ajax_del_dept.php',{dept_id:dept_id,csrf_token:csrf_token},function(data)
			{
				
				
				if(data==1)
				{
					alert('Deleted successfully');
					window.location='manage_dept.php';
				}
				else if(data==0)
				{
					alert('Unable to delete try again');
				}
				else if(data==3)
				{
					alert('Invalid token');
				}
				else if(data==4)
				{
					alert('csrf error');
				}
			});
		}
	}
	
	
	
/*	function fun(i,j,k)
	{
		var mainDeptCount = $('#mainDeptCount').val();
		
		for(i=1;i<=mainDeptCount;i++)
		{
			var checked = $('#checkbox_id_'+i+'_'+key2).val();
			
			if(i == key && checked == 1)
			{
				$('#checkbox_id_'+i+'_'+key2).prop('checked', true);
				$('#checkbox_id_'+i+'_'+key2).val('2');
			}else
			{
				$('#checkbox_id_'+i+'_'+key2).prop('checked', false);
				$('#checkbox_id_'+i+'_'+key2).val('1')
			}
		}
		
	}*/
	
	
</script>


<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function(){
			//alert();
			$('#ref').load('http://municipalservices.in/manage_dept.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
	
	function hideFun()
	{
		$('.hideFun').hide();
	}
	
	
</script>	
{/literal}

<div class="row" id="div_print">
	<div >
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar white">
				<h4> Merge Designations </h4>
				
			</div>
			<!-- Title Bart End -->
			
			
			<div>
				
				<form action="" method="POST">
					<div class="row" style="margin-top:15px;margin-bottom:15px;">
						<div class="col-md-4">
							
							<select name="searchulbid" id="" class="form-control" required onchange="hideFun()">
								<option value="">--Select--</option>
								{foreach $ulbList as $searchulbid => $ulbname}
								{if $ulbid eq $searchulbid}
								<option value="{$searchulbid}" selected>{$ulbname}</option>
								{else}
								<option value="{$searchulbid}">{$ulbname}</option>
								{/if}
								{/foreach}
							</select>
						</div>
						<div class="col-md-8">
							<input type="submit" name="search" value="search" class="btn btn-success"/>
						</div>
					</div>
				</form>
			</div>
			
			
			{if !empty($ulbid)}
			<div class="inner no-radius hideFun">
				<form action="" method="POST">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
						<tbody>
							
							<tr style="background-color:#2c3e50; color:#FFF;">
								<th>Departments</th>
								<th colspan="2">ULB Departments</th>
							</tr>
							
							
							{assign var="i" value="0"}
							{foreach $dept_list as $dept_id => $dept_desc}
							{if  count($designations[{$dept_id}]) eq '0'}
							<tr>
								<td>{$dept_desc}</td> 
								<td>{foreach $standard_des_list[{$dept_id}] as $stnddept_id => $stnd_desg}  {$stnd_desg}  <hr> {/foreach}</td> 
								<td></td>
							</tr>
							{else}
							
							<tr>
								<td rowspan ="{count($designations[{$dept_id}]) * count($standard_des_list[{$dept_id}])}">{$dept_desc}</td> 
								{assign var="j" value="0"}
								{foreach $standard_des_list[{$dept_id}] as $stnddept_id => $stnd_desg}
								<td rowspan ="{count($designations[{$dept_id}])}">  {$stnd_desg} </td>
								{assign var="k" value="0"}
								{foreach $designations[{$dept_id}] as $desg_id => $desg_desc}  
								
								{if  $checkedDesgns[$desg_id][{$stnddept_id}][{$dept_id}] eq $desg_id}
								<td><input type="checkbox" checked name="checkbox[{$dept_id}][{$stnddept_id}][{$desg_id}]" id="checkbox_id_{$i}_{$j}_{$k}" value="1" onclick="fun({$i},{$j},{$k})"> {$desg_desc}</td>
								{else}
								<td><input type="checkbox" name="checkbox[{$dept_id}][{$stnddept_id}][{$desg_id}]" id="checkbox_id_{$i}_{$j}_{$k}" value="1" onclick="fun({$i},{$j},{$k})"> {$desg_desc}</td>
								{/if}                                
							</tr>
							<tr>
								{assign var="k" value=$k+1}
								{/foreach}
								{assign var="j" value=$j+1}
								{/foreach}
							</tr>
							
							{/if}
							{assign var="i" value=$i+1}
							{/foreach}
							
							<input type="hidden" value="{$i}" name="i">
							<input type="hidden" value="{$j}" name="j">
							<input type="hidden" value="{$k}" name="k">
						</tbody>
					</table>
					
					<input type="hidden" id="ulbid"  name="ulbid" value="{$ulbid}">
					<input type="submit" name="save" value="save" class="btn btn-success"/>
					
					
				</div>
				
				{/if}
			</div>
		</div>
		
		<div class="hideFun">
        {if !empty($ulbid)}
        {include file='footer_print.tpl'}
        {/if}
        </div>

		
		
		{include file='footer.tpl'}
		
		