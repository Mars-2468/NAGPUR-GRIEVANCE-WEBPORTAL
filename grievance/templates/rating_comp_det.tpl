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
                                <th>Person name</th>
                                <th>Mobile</th>
                                <th>Subject</th>
                                <th>Complaint description</th>
                                <th>Complaint registration date</th>
                                <th>Resolved Date</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                
                               
                            </tr>
                            <tbody>
                                {foreach from=$data item=row key=grievance_id}
                                
                                <tr>
                                <td>{counter}</td>
                                <td>{$row.person_name}</td>
                                <td>{$row.mobile}</td>
                                <td>{$row.comp_subject}</td>
                                <td>{$row.comp_desc}</td>
                                <td>{$row.date_regd}</td>
                                <td>{$row.disposed_date}</td>
                                <td>{$row.rating_no}</td>
                                <td>{$row.comment_desc}</td>
                                </tr>
                                {/foreach}
                                
                                
                                
                            </tbody>
                        </thead>
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

