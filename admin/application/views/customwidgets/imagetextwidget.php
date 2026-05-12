

 
  <script src="<?php echo base_url() ?>assets/js/bootstrap.bundle.min.js"></script>




<hr>

    <div class="card bd-teal ">
        <div class="card-header bg-teal tx-white">Image details</div>
        <div class="card-body ">
        
        
             <div class="panel with-nav-tabs  ">
                <div class="panel-heading " style="background-color: #CCC;">
                        <ul class="nav nav-tabs"  role="tablist">
                            
                            
                             <li class="nav-item">
                              <a class="nav-link active" data-bs-toggle="tab" href="#tab1success">About Widget with Icon</a>
                            </li>
                            
                            <!-- <li class="nav-item">-->
                            <!--  <a class="nav-link" data-bs-toggle="tab" href="#tab3success">About Widget Image</a>-->
                            <!--</li>-->
                            
                            <!-- <li class="nav-item">-->
                            <!--  <a class="nav-link" data-bs-toggle="tab" href="#tab2success">About Widget</a>-->
                            <!--</li>-->
                            
                            <!-- <li class="nav-item">-->
                            <!--  <a class="nav-link" data-bs-toggle="tab" href="#tab4success">Team Widget</a>-->
                            <!--</li>-->
                            
                            <!-- <li class="nav-item">-->
                            <!--  <a class="nav-link" data-bs-toggle="tab" href="#tab5success">Latest Updates</a>-->
                            <!--</li>-->
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane container active" id="tab1success">
                            <!--<div class="tab-pane fade" id="tab1success">-->
                            <br>
                            <?php echo form_open_multipart('CreateWidgetController/saveImageTextwidget'); ?>

                                <input type="hidden" name="widgettype" value="<?php echo $widgetdet['widget_type']; ?>">
                                <input type="hidden" name="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">
                                <!--<input type="hidden" name="widget_type_style" value="1">-->
                                <input type="hidden" name="image_crop_width" value="73">
                                <input type="hidden" name="image_crop_height" value="90">
                            
                            
                            <div class="form-horizontal">
            
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Select Style</label>  
                                        <div class="col-md-4">
                                            <select id="widget_type_style" name="widget_type_style" class="form-control combo">
                                                <option value="0">- Select -</option>
                                                <option value="1">Services</option>
                                                <option value="2">Minister</option>
                                                <!-- <option value="3">Slider section widgets</option> -->
                                                <option value="4">News & Widgets</option>
                                                 <!-- <option value="5">Training widgets</option> -->
                                                  <option value="6">Logo Widgets</option>
                                                 <!-- <option value="7">Ministers</option> --> 
                                                 <option value="8">Footer Logo</option>
                                                 <option value="9">Social Media</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Upload Photo</label>  
                                        <div class="col-md-4">
                                            <input id="file" name="userfile" class="input-file mytext1" type="file" required accept="image/x-png,image/gif,image/jpeg">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="display:none;" id="previewImageDiv">
                                        <label class="col-md-4 control-label">Upload Photo Preview </label>  
                                         <div class="col-md-7" id="previewImage">
                                        </div> 
                                    </div>
                                    
                                  
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Heading </label>  
                                        <div class="col-md-4">
                                            <input id="title" name="title" placeholder="Enter event heading" class="form-control input-md mytext1" type="text" maxlength="30" required autocomplete="off">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Description</label>  
                                        <div class="col-md-4">
                                            <textarea rows="5" id="description" name="description" placeholder="Enter Description" class="form-control input-md mytext1" type="text" maxlength="240" required></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Page Url</label>  
                                        <div class="col-md-4">
                                            <input id="page_url" name="page_url" placeholder="Enter url here" class="form-control input-md mytext1" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Open window</label>  
                                        <div class="col-md-4">
                                            <select id="target" name="target" class="form-control combo">
                                                <option value="0">- Select -</option>
                                                <option value="1">Open same window</option>
                                                <option value="2">Open other window</option>
                                            </select>
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
                                                <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" name="ulb_check_list[]" > <span><?php echo $value['ulbname'] ?></span>
                                            </label>
                                        </div>
                                        <?php }?>
                                    </div>
                                
                                </div>
                            </div>
                            
                            
                            <br>
                            <center>
                                <div class="form-group">
                                    <div >
                                        <input type="submit"  name="save" id='btnss1' onchange="btnssFun(1);" class="btn btn-success btn-sm" value="Submit">
                                    </div>
                                </div>
                            </center>
                        <?php echo form_close();?>
                                                    
                        </div>
                        
                        
                        
                        <div class="tab-pane fade" id="tab2success">
                            
                            
                             <br>
                            <?php echo form_open_multipart('CreateWidgetController/saveImageTextwidget'); ?>

                                <input type="hidden" name="widgettype" value="<?php echo $widgetdet['widget_type']; ?>">
                                <input type="hidden" name="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">
                                <input type="hidden" name="widget_type_style" value="4">
                            
                            
                            <div class="form-horizontal">
            
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Upload Photo</label>  
                                        <div class="col-md-4">
                                            <input id="file" name="userfile" class="input-file mytext2" type="file" accept="image/x-png,image/gif,image/jpeg">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="display:none;" id="previewImageDiv">
                                        <label class="col-md-4 control-label"> Preview logo </label>  
                                         <div class="col-md-7" id="previewImage">
                                        </div> 
                                    </div>
                                    
                                  
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Number</label>  
                                        <div class="col-md-4">
                                            <input id="title" name="title" placeholder="Enter title here" class="form-control input-md mytext2" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Title (Heading)</label>  
                                        <div class="col-md-4">
                                            <textarea rows="5" id="description" name="description" placeholder="Enter Description" class="form-control input-md mytext1" type="text" maxlength="240" required></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Page Url</label>  
                                        <div class="col-md-4">
                                            <input id="page_url" name="page_url" placeholder="Enter url here" class="form-control input-md mytext2" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Open window</label>  
                                        <div class="col-md-4">
                                            <select id="target" name="target" class="form-control combo2">
                                                <option value="0">- Select -</option>
                                                <option value="1">Open same window</option>
                                                <option value="2">Open other window</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            
                            <div>
                                <div class="card bd-teal " style="clear:both;margin:15px 0 0 0;">
                                    <div class="card-header bg-teal tx-white"> Names</div>
                                    <div class="card-body">
                                        
                                        <div class="col-md-12">
                                            <label class="ckbox" style="width:100%;">
                                                <input class="chkcat" type="checkbox" value="" id="checkAll" > <span>Select All</span>
                                            </label>
                                        </div>
                                        
                                        <?php foreach($ulbList as $key => $value ){?>
                                        <div class="col-md-3">
                                            <label class="ckbox" style="width:100%;">
                                                <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" name="ulb_check_list[]" required> <span><?php echo $value['ulbname'] ?></span>
                                            </label>
                                        </div>
                                        <?php }?>
                                    </div>
                                
                                </div>
                            </div>
                            
                            
                            <br>
                            <center>
                                <div class="form-group">
                                    <div >
                                        <input type="submit"  name="save" id='btnss2' class="btn btn-success btn-sm" value="Submit">
                                    </div>
                                </div>
                            </center>
                        <?php echo form_close();?>
                            
                            
                        </div>
                        
                        
                        
                        <div class="tab-pane fade" id="tab3success">
                            
                            
                            <br>
                            <?php echo form_open_multipart('CreateWidgetController/saveImageTextwidget'); ?>

                                <input type="hidden" name="widgettype" value="4">
                                <input type="hidden" name="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">
                                <input type="hidden" name="widget_type_style" value="1">
                                <input type="hidden" name="image_crop_width" value="167">
                                <input type="hidden" name="image_crop_height" value="287">
                            
                            
                            <div class="form-horizontal">
            
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Upload Photo Icon</label>  
                                        <div class="col-md-4">
                                            <input id="file" name="userfile" class="input-file mytext2" type="file" accept="image/x-png,image/gif,image/jpeg">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="display:none;" id="previewImageDiv">
                                        <label class="col-md-4 control-label"> Preview logo </label>  
                                         <div class="col-md-7" id="previewImage">
                                        </div> 
                                    </div>
                                    
                                  
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Title</label>  
                                        <div class="col-md-4">
                                            <input id="title" name="title" placeholder="Enter title here" class="form-control input-md mytext2" type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Description</label>  
                                        <div class="col-md-4">
                                            <input id="description" name="description" placeholder="Enter title here" class="form-control input-md mytext2" type="text" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Page Url</label>  
                                        <div class="col-md-4">
                                            <input id="page_url" name="page_url" placeholder="Enter url here" class="form-control input-md mytext2" type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Open window</label>  
                                        <div class="col-md-4">
                                            <select id="target" name="target" class="form-control combo2">
                                                <option value="0">- Select -</option>
                                                <option value="1">Open same window</option>
                                                <option value="2">Open other window</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            
                            <div>
                                <div class="card bd-teal " style="clear:both;margin:15px 0 0 0;">
                                    <div class="card-header bg-teal tx-white"> Names</div>
                                    <div class="card-body">
                                        
                                        <div class="col-md-12">
                                            <label class="ckbox" style="width:100%;">
                                                <input class="chkcat" type="checkbox" value="" id="checkAll" > <span>Select All</span>
                                            </label>
                                        </div>
                                        
                                        <?php foreach($ulbList as $key => $value ){?>
                                        <div class="col-md-3">
                                            <label class="ckbox" style="width:100%;">
                                                <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" name="ulb_check_list[]" > <span><?php echo $value['ulbname'] ?></span>
                                            </label>
                                        </div>
                                        <?php }?>
                                    </div>
                                
                                </div>
                            </div>
                            
                            
                            <br>
                            <center>
                                <div class="form-group">
                                    <div >
                                        <input type="submit"  name="save" id='btnss3' class="btn btn-success btn-sm" value="Submit">
                                    </div>
                                </div>
                            </center>
                        <?php echo form_close();?>
                        </div>
                        
                        
                        
                        <div class="tab-pane fade" id="tab4success">
                            <br>
                            <?php echo form_open_multipart('CreateWidgetController/saveImageTextwidget'); ?>

                                <input type="hidden" name="widgettype" value="<?php echo $widgetdet['widget_type']; ?>">
                                <input type="hidden" name="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">
                                <input type="hidden" name="widget_type_style" value="2">
                                <input type="hidden" name="image_crop_width" value="400">
                                <input type="hidden" name="image_crop_height" value="251">
                            
                            
                            <div class="form-horizontal">
            
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Upload Photo</label>  
                                        <div class="col-md-4">
                                            <input id="file" name="userfile" class="input-file mytext1" type="file" accept="image/x-png,image/gif,image/jpeg">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="display:none;" id="previewImageDiv">
                                        <label class="col-md-4 control-label"> Preview logo </label>  
                                         <div class="col-md-7" id="previewImage">
                                        </div> 
                                    </div>
                                    
                                  
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Title</label>  
                                        <div class="col-md-4">
                                            <input id="title" name="title" placeholder="Enter title here" class="form-control input-md mytext1" type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Description</label>  
                                        <div class="col-md-4">
                                            <input id="description" name="description" placeholder="Enter title here" class="form-control input-md mytext1" type="text" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Page Url</label>  
                                        <div class="col-md-4">
                                            <input id="page_url" name="page_url" placeholder="Enter url here" class="form-control input-md mytext1" type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Open window</label>  
                                        <div class="col-md-4">
                                            <select id="target" name="target" class="form-control combo">
                                                <option value="0">- Select -</option>
                                                <option value="1">Open same window</option>
                                                <option value="2">Open other window</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            
                            <div>
                                <div class="card bd-teal " style="clear:both;margin:15px 0 0 0;">
                                    <div class="card-header bg-teal tx-white"> Names</div>
                                    <div class="card-body">
                                        
                                        <div class="col-md-12">
                                            <label class="ckbox" style="width:100%;">
                                                <input class="chkcat" type="checkbox" value="" id="checkAll" > <span>Select All</span>
                                            </label>
                                        </div>
                                        
                                        <?php foreach($ulbList as $key => $value ){?>
                                        <div class="col-md-3">
                                            <label class="ckbox" style="width:100%;">
                                                <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" name="ulb_check_list[]" > <span><?php echo $value['ulbname'] ?></span>
                                            </label>
                                        </div>
                                        <?php }?>
                                    </div>
                                
                                </div>
                            </div>
                            
                            
                            <br>
                            <center>
                                <div class="form-group">
                                    <div >
                                        <input type="submit"  name="save" id='btnss4' class="btn btn-success btn-sm" value="Submit">
                                    </div>
                                </div>
                            </center>
                        <?php echo form_close();?>
                                                    
                        </div>
                        
                       <div class="tab-pane fade" id="tab5success">
                            
                            
                             <br>
                            <?php echo form_open_multipart('CreateWidgetController/saveImageTextwidget'); ?>

                                <input type="hidden" name="widgettype" value="<?php echo $widgetdet['widget_type']; ?>">
                                <input type="hidden" name="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">
                                <input type="hidden" name="widget_type_style" value="3">
                                <input type="hidden" name="image_crop_width" value="162">
                                <input type="hidden" name="image_crop_height" value="72">
                            
                            
                            <div class="form-horizontal">
            
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Upload Photo</label>  
                                        <div class="col-md-4">
                                            <input id="file" name="userfile" class="input-file mytext2" type="file" accept="image/x-png,image/gif,image/jpeg">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="display:none;" id="previewImageDiv">
                                        <label class="col-md-4 control-label"> Preview logo </label>  
                                         <div class="col-md-7" id="previewImage">
                                        </div> 
                                    </div>
                                    
                                  
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Title</label>  
                                        <div class="col-md-4">
                                            <input id="title" name="title" placeholder="Enter title here" class="form-control input-md mytext2" type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Description</label>  
                                        <div class="col-md-4">
                                            <input id="description" name="description" placeholder="Enter title here" class="form-control input-md mytext2" type="text" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Page Url</label>  
                                        <div class="col-md-4">
                                            <input id="page_url" name="page_url" placeholder="Enter url here" class="form-control input-md mytext2" type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Open window</label>  
                                        <div class="col-md-4">
                                            <select id="target" name="target" class="form-control combo2">
                                                <option value="0">- Select -</option>
                                                <option value="1">Open same window</option>
                                                <option value="2">Open other window</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            
                            <div>
                                <div class="card bd-teal " style="clear:both;margin:15px 0 0 0;">
                                    <div class="card-header bg-teal tx-white"> Names</div>
                                    <div class="card-body">
                                        
                                        <div class="col-md-12">
                                            <label class="ckbox" style="width:100%;">
                                                <input class="chkcat" type="checkbox" value="" id="checkAll" > <span>Select All</span>
                                            </label>
                                        </div>
                                        
                                        <?php foreach($ulbList as $key => $value ){?>
                                        <div class="col-md-3">
                                            <label class="ckbox" style="width:100%;">
                                                <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" name="ulb_check_list[]" > <span><?php echo $value['ulbname'] ?></span>
                                            </label>
                                        </div>
                                        <?php }?>
                                    </div>
                                
                                </div>
                            </div>
                            
                            
                            <br>
                            <center>
                                <div class="form-group">
                                    <div >
                                        <input type="submit"  name="save" id='btnss5' class="btn btn-success btn-sm" value="Submit">
                                    </div>
                                </div>
                            </center>
                        <?php echo form_close();?>
                            
                            
                        </div> 
                        
                        
                    </div>
                </div>
            </div>
        
        </div>
    </div>
    
    
    





<script language='javascript'>

    $("#checkAll").change(function(){
        //alert('check All');
        //$(".checkbox").prop('checked', $(this).prop("checked"));
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    
    var val = $("#imgValue").val();
    if(val != ''){
        $("#imgDiv").show();
        $("#removeBtnDiv").show();
        $("#previewImageDiv").hide();
    }else{
        $("#imgDiv").hide();
        $("#removeBtnDiv").hide();
        $("#previewImageDiv").hide();
    }
    $("#file").change(function(){
        filePreview(this);
      
    });

    function filePreview(input){
        $("#previewImageDiv").show();
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#imgDiv").hide();
                $("#removeBtnDiv").hide();
                
                $('#previewImage + img').remove();
                $('#previewImage').html('<img src="'+e.target.result+'" width="75px" height="75px" style="margin:5px 0 0 0;" />');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

/*$('#btnss').click(function(){
	var errors=0;
	var er = "";
	$(".mytext1").each(function()
	{
	    //	var letters = /^[A-Za-z]+$/;  
		var val_field=$(this).val();
      	if(val_field == "")  
      	{
      		($(this)).css({"background-color": "pink"});
      		errors++;
			er += 'Name, ';
      	}  
      	else 
      	{
      		($(this)).css({"background-color": "white"});
      	}  
	});
$(".combo").each(function()
	{
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
if(errors==0)
	{
		return true;
	}
	else
	{
	    alert("Please Enter Correct Value in following High-lighted Fields - "+errors );
       	return false;
	}
});*/
    function btnssFun(i){
        var errors=0;
    	var er = "";
    	$(".mytext"+i).each(function()
    	{
    	    //	var letters = /^[A-Za-z]+$/;  
    		var val_field=$(this).val();
          	if(val_field == "")  
          	{
          		($(this)).css({"background-color": "pink"});
          		errors++;
    			er += 'Name, ';
          	}  
          	else 
          	{
          		($(this)).css({"background-color": "white"});
          	}  
    	});
        $(".combo").each(function()
    	{
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
        if(errors==0)
    	{
    		return true;
    	}
    	else
    	{
    	    alert("Please Enter Correct Value in following High-lighted Fields - "+errors );
           	return false;
    	}
    }
</script>










