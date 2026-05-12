<script>
    
function validateForm()
{
    alert();
errors=0;

$(".mytext").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});



$(".dropdown").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='0')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
		
    alert(errors);	
	if(errors==0)
	{
		return true;
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
}
</script>

<?php $attributes=array('onsubmit'=>'return validateForm'); echo form_open('CreateWidgetController/savepageWidget',$attributes);?>
<input type="hidden" name="widgettype" value="<?php echo $widgetdet['widget_type']; ?>">
<input type="hidden" name="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">

<hr>


    <div class="col-md-6 col-md-offset-3" style="margin-bottom:10px;">
        <div class="card bd-teal ">
            <div class="card-header bg-teal tx-white">Pages</div>
            <div class="card-body pd-sm-10">
            
                <div class="form-horizontal">
                    <div class=" ">
                        <div class="">
                            <div >
                                <div class="">
                                    <div class="form-group">
                                    
                                        <div style="overflow-y: scroll;height: 300px;border:1px solid #ddd;padding:10px;margin:8px;">
                                            <?php  foreach($custom_menus as $key=>$val){?>
                                            <label class="ckbox" style="width:100%;">
                                                <input type="checkbox"  value="<?php echo $val['page_id']; ?>" class="chk" name="check_list[]"><span><?php echo $val['page_name']?></span><br>
                                            </label>
                                            
                                            <?php }?>
                                        </div>
                                    </div>  
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div>
        <div class="card bd-teal " style="clear:both;margin:15px 0 0 0;">
            <div class="card-header bg-teal tx-white">Names</div>
            <div class="card-body">
                
                <div class="col-md-12">
                    <label class="ckbox" style="width:100%;">
                        <input class="chkcat" type="checkbox" value="" id="checkAll" > <span>Select All</span>
                    </label>
                </div>
                
                <?php foreach($ulbList as $key => $value ){?>
                <div class="col-md-3">
                    <label class="ckbox" style="width:100%;">
                        <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" name="ulb_check_list[]" > <span><?php echo $value['ulbname']; ?></span>
                    </label>
                </div>
                <?php }?>
            </div>
        
        </div>
    </div>
    
    <br>
    <center style="clear:both;"><div class=""><input type='submit' value='Save' name="save" class='btn btn-success'> </div></center> 
<?php echo form_close(); ?>
<script>
    
    $("#checkAll").change(function(){
        //alert('check All');
        //$(".checkbox").prop('checked', $(this).prop("checked"));
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    
   
</script>          
       