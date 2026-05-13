{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    	
 
    	


<script>
function fill(ward_id,ward_desc)
{
	document.manage_wards.ward_id.value=ward_id;
	document.manage_wards.ward_desc.value=ward_desc;
} 

function delete_ward(ward_id)
{
	
	if(confirm('Do You really want to delete this record'))
	{
	
		$.post('ajax_del_ward.php',{ward_id:ward_id},function(data)
		{
		if(data==1)
		{
		alert('Ward deleted successfully');
		window.location='manage_wards.php';
		}
		else if(data==0)
		{
		alert('Unable to delete , Try again');
		}
		else if(data==2)
		{
		alert('Ward is mapped with employees You cannot delete this ward');
		}
		
		});
	}

} 

function validateForm()
{
	var ward_desc=document.manage_wards.ward_desc.value;		
	if(ward_desc=='')
	{
		alert("Please Enter Ward No / Description");
		return false;
	}

	return true;
}

</script>
{/literal}




 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Complaints RATING</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    
                    <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Category name</th>
                                {foreach $ratingList item=$row key=index}
                                <th>{$ratingList[$index]} Rating <br> ({$ratingMarks[$ratingList[$index]]}  Marks) </th>
                                {/foreach}
                                <th>Total</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                            <tbody>
                                
                                {assign var="gt" value=0}
                                
                                
                                
                              
                                
                                {foreach from=$tot_marks item=row1 key=emp_id}
                                <tr>
                                    <td>{counter}</td>
                                    <td><a href="rating_comp_det.php?emp_id={$emp_id_sel}&cat_id={$emp_id}" target="_blank">{$emp_list[$emp_id]}</a></td>
                                   {foreach $ratingList item=$row2 key=index}
                                    
                                    <td>{$data[$emp_id][$ratingList[$index]].count}</td>
                                   {/foreach}
                                    <td>{$totals2[$emp_id]}</td>
                                    <td>{$tot_marks[$emp_id].marks}</td>
                                
                                </tr>
                                {/foreach}
                               </tbody>
                               <tfoot>
                                <tr>
                                    <td colspan="2">Total</td>
                                    {foreach $ratingList item=$row key=index}
                                    <th>{$totals[$ratingList[$index]]}</th>
                                    {/foreach}
                                    <th>{$totals.total}</th>
                                    <th>{$tot_marks.tot}</th>
                                </tr>
                                </tfoot>
                                
                                
                           
                        </table>
                        
                        {include file='footer_print.tpl'}
			
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>








{include file='footer.tpl'}

{literal}
<script>
   $(".num").keydown(function(event) {
    // Allow only backspace and delete
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ) {
        // let it happen, don't do anything
    }
    else {
        // Ensure that it is a number and stop the keypress
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
        }   
    }
});
    
    
</script>
{/literal}

