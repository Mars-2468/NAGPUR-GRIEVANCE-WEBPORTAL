{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  	
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/manage_wards.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>	

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
	    var csrf_token=$("#csrf_token").val();
		$.post('ajax_del_ward.php',{ward_id:ward_id,csrf_token:csrf_token},function(data)
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
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Geotagging Map Report</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
		    <form method="post" action="geotagging-exportmap.php" target="_blank">
			     <input type="hidden" name="token" value="{$token_id}" />
		    	 <input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token"/>
		 	     <input type='hidden' name='ward_id' value='0'>
				 <div class="form-body">
				 	{if isset($msg)}
				 <div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				 </div>
				{/if}
					 	<div class="row justify-content-center">
					<div class="col-md-3">
					    <div class="form-group1">
                          <label  >Type:</label>{$search.type1}
                          <select class="form-control" name="type" required id="dropdown_change">
                               <option value="">-select-</option>
                              	{foreach from=$geotagging  item=row}
							         <option value='{$row.Id}'  >{$row.Description}</option>
							   {/foreach}
						  </select>
                        </div>
					</div>
					
    				 <div class="col-md-3" style="display:none" id="sub_type" >
    					    <div class="form-group1">
                              <label  >Sub Type:</label>
                              <select class="form-control" name="subtype" id="subdrop">
    							        <option value="">-select-</option>
    							       {foreach from=$geotaggingsub  item=row}
							            <option value='{$row.Id}' >{$row.Description}</option>
							           {/foreach}
    							    </select>
                            </div>
    					</div>
    					 <div class="col-md-3" style=""  >
    					    <div class="form-group1">
                              <label  >Wards</label>
                              <select class="form-control" name="Wardno" >
    							        <option value="">-select-</option>
    							       {foreach from=$geowardlists  item=rows}
							            <option value='{$rows.ward_id}' {if ($search.Wardno)===($rows.ward_id)} selected  {/if}>{$rows.ward_desc}</option>
							           {/foreach}
    							    </select>
                            </div>
    					</div>
					<div class="col-md-3" style="">
                        <div class="form-group1">
                          <label class="" style="">From Date:</label>
                           <input type="text" class="phone-group form-control datepicker"    autocomplete="off" name="f_date" value="{$search.f_date}">
                         
                        </div>
                        </div>      
                        
                        
                        <div class="col-md-3" style="">
                        <div class="form-group1">
                          <label class="" style="">To Date:</label>
                          
                          <input type="text" class="phone-group form-control datepicker"    autocomplete="off" name="t_date" value="{$search.t_date}">
                          <input type="hidden"name="ulb" value='{$search.suld}'>
                          <input type="hidden"name="uid" value='{$uid}'>
                        </div>
                        </div>
					</div>
					
				 
					
					<div class="form-actions fluid "><br>
						<div class="col-md-offset-5 col-md-2">
						<button type="submit" class="btn btn-info" name="save">Get Map</button>
						 
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>


</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
    function Ihhl(id) {
        var HHno = $('#HHno'+id).val();
        var Area = $('#Area'+id).val();
        var MobileNo = $('#MobileNo'+id).val();
         $('#4id').val(id);
         $('#4HHno').val(HHno);
         $('#4Area').val(Area);
         $('#4MobileNo').val(MobileNo);
    }
    function pu_cm_otr(id) {
        var pArea = $('#pArea'+id).val();
         $('#5Area').val(pArea);
         $('#5id').val(id);
        
    }
    function manhole(id) {
        var mArea = $('#mArea'+id).val();
         var mUniqueId = $('#mUniqueId'+id).val();
          var mLength = $('#mLength'+id).val();
         $('#mArea').val(mArea);
          
         $('#mLength').val(mLength);
         $('#2id').val(id);
        
    }
    function IEChoading(id) {
        var iArea = $('#iArea'+id).val();
         $('#3Area').val(iArea);
         $('#3id').val(id);
        
    }
</script>
<script>
$(function() {
    $(".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>
<script>
    $(document).ready(function(){
     $("#dropdown_change").change(function(){
         
        if($("#dropdown_change").val()==1){
            $("#sub_type").css("display", "block");  
            
            $('#subdrop').attr("required", true);
        }else{
            $("#sub_type").css("display", "none"); 
            $ 
             $('#subdrop').attr("required", false);
        }
   
     });
   });
      $(document).ready(function () {    
    
            $('.isnumber').keypress(function (e) {    
    
                var charCode = (e.which) ? e.which : event.keyCode    
               if($('.isnumber').val().length==0){
                if (String.fromCharCode(charCode).match(/[^6-9]/g)){    
    
                    return false;
                }
               }
               if($('.isnumber').val().length>1){
                if (String.fromCharCode(charCode).match(/[^0-9]/g)){    
    
                    return false;
                }
               }
    
            });    
    
        });
</script>
<script type="text/javascript">

 $(document).ready(function() {

 $('.mobile-valid').on('keypress', function(e) {

            var $this = $(this);
            var regex = new RegExp("^[1-9\b]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            // for 10 digit number only
            if ($this.val().length > 9) {
                e.preventDefault();
                return false;
            }
            if (e.charCode < 54 && e.charCode > 47) {
                if ($this.val().length == 0) {
                    e.preventDefault();
                    return false;
                } else {
                    return true;
                }
             }
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });

   });
</script>