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

function fun(key,key2)
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
   
}
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
                  <h4> Merge Departments </h4>
                </div>
                
            	<div class="form-body">
				{if isset($msg)}
				<div class="title-bar white">
                  <h4> 	{$msg} </h4>
                </div>
				{/if}
				</div>
				
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
                <!-- Title Bart End -->
                <div class="inner no-radius hideFun">
                    <form action="" method="POST">
					 <table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
                      <tbody>
                          <tr style="background-color:#2c3e50; color:#FFF;">
                              <th>Departments</th>
                              <th>ULB Departments</th>
                          </tr>
                           
                            {foreach $array1 as $key=>$value}
                            <tr>
                                <td rowspan="{count($array2)}">{$value}</td>
                                {foreach $array2 as $key2 => $value2}
                               
                                {if $dept_id_checked[$key2] eq $key}
                                <td><input type="checkbox" name="checkbox[{$key}][{$key2}]" id="checkbox_id_{$key}_{$key2}" checked value="1" onclick="fun({$key},{$key2})"> {$value2}</td>
                                {else}
                                <td><input type="checkbox" name="checkbox[{$key}][{$key2}]" id="checkbox_id_{$key}_{$key2}" value="1" onclick="fun({$key},{$key2})"> {$value2}</td>
                                {/if}
                               
                            </tr>
                                <tr>
                                {/foreach}
                            </tr>
                            {/foreach}
                         
                      </tbody>
                    </table>  
                    <input type="hidden" id="mainDeptCount" value="{$array1Count}">
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

