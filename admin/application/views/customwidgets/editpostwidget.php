<script>
    
function validateForm()
{
    errors=0;
    $("#widgetname").each(function(){
        var val_field=$(this).val();
		if(val_field==''){
			($(this)).css({"background-color": "pink"});
			errors++;
		}else{
			($(this)).css({"background-color": "white"});
		}
    });
    if(errors!=0){
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
	<?php if(($this->session->userdata('user_type')) == 'A'){ ?>
	var check_val = [];
    var checkList = [];
    $('.checkbox1:checked').each(function(i){
      check_val[i] = $(this).val();
    });
    //alert(check_val);
    var len = check_val.length;
    $('.checkList:checked').each(function(i){
        checkList[i] = $(this).val();
    });
    var checkListlen = checkList.length;
    
    if(len == 0 && checkListlen == 0){
        $("#buttonDiv").hide();
        $("#UlbCheckValidationError").show();
	 	$("#UlbCheckValidationSpan").html('Please Select Atleast One ULB');
	 	$("#CategoryCheckValidationError").show();
	 	$("#CategoryCheckValidationSpan").html('Please Select Atleast One Category');
	 	errors++;
    }else if(len == 0){
        $("#buttonDiv").hide();
        $("#UlbCheckValidationError").show();
	 	$("#UlbCheckValidationSpan").html('Please Select Atleast One ULB');
	 	$("#CategoryCheckValidationError").hide();
	 	$("#CategoryCheckValidationSpan").html('');
	 	errors++;
    }else if(checkListlen == 0){
        $("#buttonDiv").hide();
        $("#CategoryCheckValidationError").show();
	 	$("#CategoryCheckValidationSpan").html('Please Select Atleast One Category');
	 	$("#UlbCheckValidationError").hide();
	 	$("#UlbCheckValidationSpan").html('');
	 	errors++;
    }else{
        $("#buttonDiv").show();
        $("#UlbCheckValidationError").hide();
	 	$("#UlbCheckValidationSpan").html('');
        $("#CategoryCheckValidationError").hide();
	 	$("#CategoryCheckValidationSpan").html('');
    }
	
	var message = '';
    if (document.getElementById('radio1').checked) {
        message = 'Do you really want to Edit Checked values';
    }else if (document.getElementById('radio2').checked) {
        message = 'Do you really want to Edit Unchecked values';
    }else if (document.getElementById('radio3').checked) {
        message = 'Do you really want to Delete Checked values';
    }else if (document.getElementById('radio4').checked) {
        message = 'Do you really want to Delete Unchecked values';
    }
    if(message != ''){
        if(confirm(message)){
            
        }else{
            return false;
        }
    }else{
        alert('Please Select Edit or Delete Button');
        return false;
    }
    <?php } ?>
    
}
</script>

<?php //print_r($result); ?>
<?php if($this->session->flashdata('message')){?>
<div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
<?php }?>

<div class="sh-pagebody">
    <div class="card bd-primary ">
        <div class="card-header bg-primary tx-white">Edit Post Widget</div>
        <div class="card-body pd-sm-30">
            
            <?php $attributes=array('onsubmit'=>'return validateForm();'); echo form_open('ViewWidgetsController/editpostWidget',$attributes);?>
            
            <input type="hidden" name="widget_type" value="<?php echo $widget_det['widget_type']; ?>">
            <input type="hidden" name="widget_id" value="<?php echo $widget_det['widget_id']; ?>">
            <input type="hidden" name="widget_type_style" value="<?php echo $widget_det['widget_type_style']; ?>">
            <div class="">
                <?php foreach($result['widgetName'] as $value){ ?>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Widget Name:</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="widget_name" id="widgetname" onkeyup="widgetNameValidation()" value="<?php echo $value['widget_name']; ?>" <?php if(($this->session->userdata('user_type')) != 'A'){ echo 'readonly'; }?>>
                    </div>
                </div>
                <?php }?>
            </div>
            <br/><br/>
            <div id="widgetNameValidationError" style="display:none;margin-top:10px;" class="alert alert-danger">
                <center><span id="widgetNameValidationSpan"></span></center>
            </div>
            <hr style="clear:both;">
            <div class="card bd-teal " style="clear:both;">
                <div class="card-header bg-teal tx-white">Category</div>
                <div class="card-body">
                
                    <?php foreach($result['allcategories'] as $key=>$val){
                        $string="";
                        foreach($result['selectedCategories'] as $key2=>$val2){
                            if($val['page_id']==$val2['category_id']){
                                $string="checked";
                                break;
                            }else{
                                $string="";
                            }
                        }
                        ?>
                    
                    <!--<input type="checkbox" value="<?php echo $val['page_id']; ?>" name="check_list[]" <?php echo $string; ?>> <?php echo $val['page_name']; ?>-->
                    
                    <div class="col-md-3">
                        <label class="ckbox" style="width:100%;">
                            <input class="chkcat checkList" type="checkbox" value="<?php echo $val['page_id']; ?>" name="check_list[]" <?php echo $string; ?> onclick="radioUlbNameCheckFun()"> <span><?php echo $val['page_name']; ?></span>
                        </label>
                   </div>
                    <?php }?>
                
                </div>
                <div id="CategoryCheckValidationError" style="display:none;" class="alert alert-danger">
                    <center><span id="CategoryCheckValidationSpan"></span></center>
                </div>
            </div>
            <?php if(($this->session->userdata('user_type')) == 'A'){ 
                $ulbCount = 0;
                foreach($result['widgetDetails'] as $val){
                	if($val['ulbid'] != $this->session->userdata('ulbid')){
                		//echo "ok.....".$val['ulbid'];
                		$ulbCount++; 
                	}
                	//print_r($val);
                }
                //echo $ulbCount;
                $ulblist = count($ulbList);
            ?>
            <div>
                <div class="card bd-teal " style="clear:both;margin:15px 0 0 0;">
                    <div class="card-header bg-teal tx-white">ULB Names</div>
                    <div class="card-body">
                        
                        <div class="col-md-12">
                            <label class="ckbox" style="width:100%;">
                                <input class="chkcat" type="checkbox" value="" id="checkAll" <?php if($ulbCount == $ulblist){ echo 'checked'; } ?>> <span>Select All</span>
                            </label>
                        </div>
                        
                        <?php
                            foreach($ulbList as $key => $value ){
                                $string = '';
                                foreach($result['widgetDetails'] as $key => $value1){
                                    if($value['ulbid'] == $value1['ulbid']){
                                       $string = 'checked';
                                       break;
                                    }else{
                                        $string = '';
                                    }
                                }
                        ?>
                        
                        <div class="col-md-3">
                            <label class="ckbox" style="width:100%;">
                                <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" onclick="radioUlbNameCheckFun();" name="ulb_check_list[]" <?php echo $string; ?>> <span><?php echo $value['ulbname']; ?></span>
                            </label>
                        </div>
                        <?php  
                        }
                        ?>
                    </div>
                    <div id="UlbCheckValidationError" style="display:none;" class="alert alert-danger">
                        <center><span id="UlbCheckValidationSpan" ></span></center>
                    </div>
                </div>
                <br>
                <div class="row" style="margin: auto;padding: 11px;background-color: #f0ece2;">
                    <div class="col-md-3">
                        <label class="rdiobox" style="width:100%;">
                            <input class="" type="radio" value="edit" name="radio" id="radio1" onclick="radioUlbNameCheckFun();"> <span>Edit</span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="rdiobox" style="width:100%;">
                            <input class="" type="radio" value="editexcept" name="radio" id="radio2" onclick="radioUlbNameCheckFun();"> <span>Edit Except</span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="rdiobox" style="width:100%;">
                            <input class="" type="radio" value="delete" name="radio" id="radio3" onclick="radioUlbNameCheckFun();"> <span>Delete</span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="rdiobox" style="width:100%;">
                            <input class="" type="radio" value="deleteexcept" name="radio" id="radio4" onclick="radioUlbNameCheckFun();"> <span>Delete Except</span>
                        </label>
                    </div>
                </div>
            </div>
            <?php } ?>
           
            <div style="margin-top:26px;" id="buttonDiv">
                <center><input type='submit' value='Update' name="save" class='btn btn-success'> </center>
            </div>
            <?php echo form_close(); ?>
        
        </div>      
    </div>       
</div>       
<script>
    function widgetNameValidation(){
        //alert("Widget");
        var widgetName = $("#widgetname").val();
        //alert(widgetName);
        if(widgetName == ''){
            $("#buttonDiv").hide();
            $("#widgetNameValidationError").show();
    	 	$("#widgetNameValidationSpan").html('Please Enter Widget Name');
            return false;
        }else{ 
            $("#widgetNameValidationError").hide();
            $("#buttonDiv").show();
    	 	$("#widgetNameValidationSpan").html('');
            $.post('<?php echo base_url(); ?>CreateWidgetController/widgetNameValidation',{widgetname:widgetName},function(data){
                //alert(data);
                if(data == 'true'){
                    $("#buttonDiv").hide();
                    $("#widgetNameValidationError").show();
    	 	        $("#widgetNameValidationSpan").html('Widget Name Already Exists!'); 
                }
            });
        }
        
    }


    $("#checkAll").change(function(){
        //alert('check All');
        $(".checkbox1").prop('checked', $(this).prop("checked"));
        //$('input:checkbox').not(this).prop('checked', this.checked);
        radioUlbNameCheckFun();
    });
    
    function radioUlbNameCheckFun(){
        //alert('radio');
        var check_val = [];
        var checkList = [];
        $('.checkbox1:checked').each(function(i){
          check_val[i] = $(this).val();
        });
        //alert(check_val);
        var len = check_val.length;
        $('.checkList:checked').each(function(i){
            checkList[i] = $(this).val();
        });
        var checkListlen = checkList.length;
        //alert(checkList+" len"+checkListlen+"  "+len );
        <?php if(($this->session->userdata('user_type')) == 'A'){ ?>
        var count = <?php echo $ulblist; ?>;
        
        if(len == count){
        	$("#checkAll").prop('checked', true);
        }else{
        	$("#checkAll").prop('checked', false);
        }
        
        if(len == 0 && checkListlen == 0){
            $("#buttonDiv").hide();
            $("#UlbCheckValidationError").show();
    	 	$("#UlbCheckValidationSpan").html('Please Select Atleast One ULB');
    	 	$("#CategoryCheckValidationError").show();
    	 	$("#CategoryCheckValidationSpan").html('Please Select Atleast One Category');
    	 	return false;
        }else if(len == 0){
            $("#buttonDiv").hide();
            $("#UlbCheckValidationError").show();
    	 	$("#UlbCheckValidationSpan").html('Please Select Atleast One ULB');
    	 	$("#CategoryCheckValidationError").hide();
    	 	$("#CategoryCheckValidationSpan").html('');
    	 	return false;
        }
        <?php } ?>
        if(checkListlen == 0){
            $("#buttonDiv").hide();
            $("#CategoryCheckValidationError").show();
    	 	$("#CategoryCheckValidationSpan").html('Please Select Atleast One Category');
    	 	$("#UlbCheckValidationError").hide();
    	 	$("#UlbCheckValidationSpan").html('');
    	 	return false;
        }else{
            $("#buttonDiv").show();
            $("#UlbCheckValidationError").hide();
    	 	$("#UlbCheckValidationSpan").html('');
            $("#CategoryCheckValidationError").hide();
    	 	$("#CategoryCheckValidationSpan").html('');
        }
    }
    
</script>
       
       
       
       
       
       
       
       
       
       
       
       
       
<!--<script>
    
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
<?php print_r($result); ?>
<div class="sh-pagebody">

<?php $attributes=array('onsubmit'=>'return validateForm'); echo form_open('ViewWidgetsController/editpostWidget',$attributes);?>

<input type="hidden" name="widget_type" value="<?php echo $widget_det['widget_type']; ?>">
<input type="hidden" name="widget_id" value="<?php echo $widget_det['widget_id']; ?>">

<div class="card bd-primary mg-t-20">
<div class="card-header bg-primary tx-white">Edit Post Widget</div>
<div class="card-body pd-sm-30">

<div class="form-horizontal">

<?php foreach($result['widgetName'] as $key=>$value){ ?>
<div class="form-group">
<label class="col-md-4 control-label " >Widget Name:</label>
<div class="col-md-5">
<input class="form-control" type="text" name="widget_name" value="<?php echo $value['widget_name']; ?>">
</div>
</div>
<?php } ?>
<hr>


<div>






<div class="card bd-teal mg-t-20">
<div class="card-header bg-teal tx-white">Edit Post Widget</div>
<div class="card-body pd-sm-30">



<div class="form-group">

<?php foreach($result['allcategories'] as $key=>$val){
$string="";
//print_r($result['selectedCategories']);
foreach($result['selectedCategories'] as $key2=>$val2){
if($val['page_id']==$val2['category_id'])
{
$string="checked";
break;
}
else
{
$string="";
}
}

?>

<div class="col-md-3">
<label class="ckbox" style="width:100%;">
<input class="chkcat" type="checkbox" value="<?php echo $val['page_id']; ?>" name="check_list[]" <?php echo $string; ?>> <span><?php echo $val['page_name']; ?></span>


</label>

</div>

<?php }?>

</div>


</div>

</div>

</div>




  
 
  
  
  
</div>
</div>

<br>

<center>
<div class=""><input type='submit' value='Save' class='btn btn-success'></div>
</center>



</div>
       
       
</div>

     
  


<?php echo form_close(); ?>
</div>
       
       -->