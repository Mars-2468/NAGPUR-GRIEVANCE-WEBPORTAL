

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

<?php $attributes=array('onsubmit'=>'return validateForm'); echo form_open('CreateWidgetController/saveTabWidget',$attributes);?>
<input type="hidden" name="widgettype" value="<?php echo $widgetdet['widget_type']; ?>">
<input type="hidden" name="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">

<hr>

 
    <div class="form-horizontal">
        <div class="form-group">
        
            <label class="col-md-4 control-label" for="textinput">Select Tabs type:</label>  
            <div class="col-md-4"style="">
                <select name='tab_type_id' id='tab_type_id' class="form-control dropdown">
                    <option value='0'>-- Select --</option>
                    <?php  foreach($tabtypes as $key=>$val){?>
                    <option value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>   
        
    <hr>
        
    <div class="card bd-teal ">
        <div class="card-header bg-teal tx-white">Categories</div>
        <div class="card-body ">
        
            <div class="">
                <?php// print_r($categories); ?>          
                <?php foreach($categories as $key=>$val){?>
                
                <!--<input type="checkbox" value="<?php echo $val['page_id']; ?>" name="check_list[]"> <?php echo $val['page_name']; ?>-->
                <div class="col-md-3">
                    <label class="ckbox" style="width:100%;">
                        <input type="checkbox" value="<?php echo $val['page_id']; ?>" class="chkcat" name="check_list[]"><span><?php echo $val['page_name']; ?></span><br>
                    </label>
                </div>
                
                <?php }?>
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
    <div class="" style="clear:both;">
        <center>  <input type='submit' value='Create' name="save" class='btn btn-success btn-sm'> </center>
    </div>




<?php echo form_close(); ?>
<script>
    $("#checkAll").change(function(){
        //alert('check All');
        $(".checkbox1").prop('checked', $(this).prop("checked"));
        //$('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>       
       