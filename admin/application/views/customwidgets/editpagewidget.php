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

<script src='https://egovindia.in/TSFC/dynamic/assets/cdma/TSFC/js/jquery-3.6.0.js'></script>
<script src='https://egovindia.in/TSFC/dynamic/assets/cdma/js/bootstrap.min-5.1.3.js'></script>
<?php //echo count($result['selectedCategories']);print_r($result['selectedCategories']); ?>

<?php if($this->session->flashdata('message')){?>
<div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
<?php }?>

<div class="sh-pagebody">

<?php $attributes=array('onsubmit'=>'return validateForm();'); echo form_open('ViewWidgetsController/editpageWidget',$attributes);?>



    <div class="card bd-primary mg-t-20">
        <div class="card-header bg-primary tx-white">Page Widget</div>
        <div class="card-body pd-sm-30">
            <input type="hidden" name="widget_type" value="<?php echo $widget_det['widget_type']; ?>">
            <input type="hidden" name="widget_id" value="<?php echo $widget_det['widget_id']; ?>">    
            <input type="hidden" name="widget_type_style" value="<?php echo $widget_det['widget_type_style']; ?>">
            <div class="form-horizontal">
                
                <?php foreach($result['widgetName'] as $key=>$value){ ?>
                <div class="form-group">
                    <label class="col-md-2 col-md-offset-3 control-label" for="textinput">Widget Name:</label>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="widget_name" id="widgetname" onkeyup="widgetNameValidation()" value="<?php echo $value['widget_name']; ?>" <?php if(($this->session->userdata('user_type')) != 'A'){ echo 'readonly'; }?>>
                    </div>
                </div>
                <div id="widgetNameValidationError" style="display:none;" class="alert alert-danger">
                    <center><span id="widgetNameValidationSpan" ></span></center>
                </div>
                <?php } ?>
                <div class="col-md-5 col-md-offset-3">
                    <div class="panel-group d-accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#pages"> <strong>Pages</strong></div>
                                <div id="pages" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div style="height:400px; overflow:scroll;">
                
                                            <?php 
                                                foreach($result['allcategories'] as $key=>$val){
                                                    $string="";
                                                    foreach($result['selectedCategories'] as $key2=>$val2){
                                                        if($val['page_id']==$val2['page_id']){
                                                            $string="checked";
                                                            break;
                                                        }else{
                                                            $string="";
                                                        }
                                                    }
                                            ?>
                                            <label class="rdiobox" style="width:100%;">
                                                <input type="radio" class="checkList" value="<?php echo $val['page_id']; ?>" name="check_list[]" <?php echo $string; ?> onclick="radioUlbNameCheckFun();"> <span><?php echo $val['page_name']; ?></span>
                                            </label>            
                
                                            <?php }?>  
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div id="CategoryCheckValidationError" class="alert alert-danger" style="display:none;">
                            <center><span id="CategoryCheckValidationSpan"></span></center>
                        </div>
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
                            <center><span id="UlbCheckValidationSpan"></span></center>
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
                <br />
                <?php } ?>
                <center style="clear:both;">
                    <div class="" id="buttonDiv">
                        <input type='submit' value='Update' class='btn btn-success'>
                    </div>
                </center>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
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
        //$(".checkbox").prop('checked', $(this).prop("checked"));
        $('input:checkbox').not(this).prop('checked', this.checked);
        radioUlbNameCheckFun();
    });
    
    function radioUlbNameCheckFun(){
        var check_val = [];
        var checkList = [];
        $('.checkbox1:checked').each(function(i){
          check_val[i] = $(this).val();
        });
        
        var len = check_val.length;
        $('.checkList:checked').each(function(i){
            checkList[i] = $(this).val();
        });
        var checkListlen = checkList.length;
        
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

