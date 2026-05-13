{include file='header.tpl'}
{literal}




    	

    	
 
    	



{/literal}


 

 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Last Date Services</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                   <div id="printpage">
                       <div  id="area">
                    <div id="example">
                    <table class="display table-bordered table-striped table-condensed cf" id="data-table">
                        <thead>
                            <tr style="background-color:#161D6E; color:#FFF;">
                                <th>Sno</th>
                                <th>Ulb Name</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                            <tbody>
                              	{foreach from=$ulb_list item=row key=ulbid}
                              
                                <tr>
                                    <td>{counter}</td>
                                    <td>{$ulb_list[$ulbid]}</td>	
                                    <td>{$data[$ulbid].date}</td>
                                </tr>
                               {/foreach}
                            </tbody>
                       
                        </table>
                        
                        {include file='footer_print.tpl'} 
                       
			
					</div>
				</div>
				</div>
			
		</div></div>
	
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

