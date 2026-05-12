<style>
	
	#mceu_1 {
    width: 37px !important;
	position:relative; !important;
    /*left: 10px;*/
    /*bottom: 65px;
    height: 30px;*/
	}
    
</style>
<script>
    function validateForm()
    {
        errors=0;
        $("#widgetname").each(function()
        {
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
        var target  = $("#target").val();
        var title   = $("#title").val();
        var page_url  = $("#page_url").val();
        
        if(target == '0' && title == '' && alt == '' && page_url == '')
        {
            $("#buttonDiv").hide();
            $("#titleCheckValidationError").show();
    	 	$("#titleCheckValidationSpan").html('Please Enter Image title');
    	 	$("#urlCheckValidationError").show();
    	 	$("#urlCheckValidationSpan").html('Please Enter Page URL');
    	 	$("#WindowCheckValidationError").show();
    	 	$("#WindowCheckValidationSpan").html('Please Select Open Window Option');
    	 	$('#title,#alt,#page_url,#target').css({"background-color": "pink"});
    		errors++;
		}
		else if(title == '')
		{
            $("#buttonDiv").hide();
            $("#titleCheckValidationError").show();
    	 	$("#titleCheckValidationSpan").html('Please Enter Image title');
    	 	$('#title').css({"background-color": "pink"});
    		errors++;
		}
		else if(page_url == '')
		{
            $("#buttonDiv").hide();
            $("#urlCheckValidationError").show();
    	 	$("#urlCheckValidationSpan").html('Please Enter Page URL');
    	 	$('#page_url').css({"background-color": "pink"});
    		errors++;
		}
		else if(target == '0')
		{
            $("#buttonDiv").hide();
            $("#WindowCheckValidationError").show();
    	 	$("#WindowCheckValidationSpan").html('Please Select Open Window Option');
    	 	$('#target').css({"background-color": "pink"});
    		errors++;
		}
		else
		{
            $("#buttonDiv").show();
            $("#titleCheckValidationError,#urlCheckValidationError,#WindowCheckValidationError").hide();
    	 	$("#titleCheckValidationSpan,#urlCheckValidationSpan,#WindowCheckValidationSpan").html('');
    	 	$('#title,#alt,#page_url,#target').css({"background-color": "white"});
		}
        if(errors!=0)
		{
    		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
    		return false;
		}        
	}
</script>

<?php 
	
	if($this->session->flashdata('resource'))
	{
		$filepath=$this->session->flashdata('resource');
		$thumbs=$this->session->flashdata('thumbs');
		$filename=$this->session->flashdata('filename');		
		//$dest_file=$this->session->flashdata('dest_file');		
	}
	else
	{
		$filepath = "..".$result['widgetContent'][0]['source_path'];
		$thumbs = "..".$result['widgetContent'][0]['thumbnail_path'];
		$filename = $result['widgetContent'][0]['file_name'];
		//$dest_file = $result['widgetContent'][0]['dest_file'];
		//print_r($this->session->userdata());exit;
	}
	
	
?>

<?php //print_r($result['widgetDetalis']); ?>
<?php if($this->session->flashdata('message')){?>
    
    <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
<?php }?>
<div class="sh-pagebody">
    
    <div class="card bd-primary ">
		<div class="card-header bg-primary tx-white">Image With Text Widget</div>
		<div class="card-body ">
					
			<?php 
			if($widget_det['widget_type_style'] == 1 || $widget_det['widget_type_style'] == 4)
			{
			?>
			<div class="form-horizontal">
				
				<?php $attributes=array('id'=>'form2'); echo form_open_multipart('ViewWidgetsController/uploadfile',$attributes);?>
				<?php // print_r($widget_det); ?>
				<?php $url="edite-widget/".$widget_det['widget_id']."/".$widget_det['widget_type']."/".$widget_det['widget_type_style']; ?>
				
				
				<input type="hidden" name="url" value="<?php echo $url; ?>">
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Upload Photo</label>  
					<div class="col-md-4">
						<input id="userfile" name="userfile" class="input-file" type="file" accept="image/*"  data-type="image" onchange="funInputFielTypes(this)">
						<div style="font-size:10px;color:red;" id="userfileX"></div>
					</div>
					
				</div>
				<?php echo form_close(); ?>
				
				<?php $attributes1=array('onsubmit'=>'return validateForm();');   echo form_open_multipart('ViewWidgetsController/editImageTextwidget',$attributes1); ?>
				<?php foreach($result['widgetName'] as $val){  ?>
					<input type="hidden" name="widget_type" value="<?php echo $val['widget_type']; ?>">
					<input type="hidden" name="widget_id" value="<?php echo $val['widget_id']; ?>">
					<input type="hidden" name="widget_type_style" value="<?php echo $val['widget_type_style']; ?>">
					
					<input type="hidden" name="uploadpath" value="<?php echo $filepath; ?>">
					<input type="hidden" name="file_name" value="<?php echo $filename; ?>">
					<input type="hidden" name="resource" value="<?php echo $filepath; ?>">
					<input type="hidden" name="thumbspath" value="<?php echo $thumbs; ?>">
					
					
					<div class="form-group">
						<label class="control-label col-sm-4" for="email">Widget Name :</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="widget_name" id="widget_name" data-type="text" onkeyup="funInputFielTypes(this)" value="<?php echo $val['widget_name']; ?>" <?php if(($this->session->userdata('user_type')) != 'A'){ echo 'readonly'; }?>>
							<div style="font-size:10px;color:red;" id="widget_nameX"></div>
						</div>
					</div>
					<div id="widgetNameValidationError" style="display:none;" class="alert alert-danger">
						<center><span id="widgetNameValidationSpan"></span></center>
					</div>
				<?php }?> 
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Present image</label>  
					<div class="col-md-4">
						
						<img src="<?php echo  str_replace("/admin/","",base_url()).substr($filepath,2); ?>" class="img-responsive">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Title</label>  
					<div class="col-md-4">
						<input id="title" name="title" placeholder="Enter title here" class="form-control input-md" type="text" data-type="text" onkeyup="funInputFielTypes(this)" value="<?php echo $result['widgetContent'][0]['title']; ?>">
						<div style="font-size:10px;color:red;" id="titleX"></div>
					</div>
				</div>
				<div id="titleCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="titleCheckValidationSpan"></span></center>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Description</label>  
					<div class="col-md-4">
						<textarea rows="5" id="description" name="description" placeholder="Enter Description" class="form-control input-md mytext1" type="text" maxlength="240" data-type="sptext" onkeyup="funInputFielTypes(this)" required><?php echo $result['widgetContent'][0]['description']; ?></textarea>
					<div style="font-size:10px;color:red;" id="descriptionX"></div>
					</div>
				</div>
				<!--<div id="descriptionCheckValidationError" style="display:;" class="alert alert-danger">-->
				<!--	<center><span id="descriptionCheckValidationSpan">Maximum 240 Characters only</span></center>-->
				<!--</div>-->
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Page Url</label>  
					<div class="col-md-4">
						<input id="page_url" name="page_url" placeholder="Enter url here" class="form-control input-md" type="text"  data-type="url" onkeyup="funInputFielTypes(this)" value="<?php echo $result['widgetContent'][0]['url_link']; ?>">
						<div style="font-size:10px;color:red;" id="page_urlX"></div>
					</div>
				</div>
				<div id="urlCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="urlCheckValidationSpan"></span></center>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Open window</label>  
					<div class="col-md-4">
						<select id="target" name="target" class="form-control" onchange="validatefunction();">
							<option value="0">- Select -</option>
							<option <?php echo ($result['widgetContent'][0]['target'] == '1') ? ' selected="selected"' : ''; ?> value="1">Open same window</option>
							<option <?php echo ($result['widgetContent'][0]['target'] == '2') ? ' selected="selected"' : ''; ?> value="2">Open other window</option>
							
						</select>
					</div>
				</div>
				<div id="WindowCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="WindowCheckValidationSpan"></span></center>
				</div>
				
				<!--<div class="form-group">-->
   
				
				<input type="hidden" class="form-control" name="ulb_check_list[]" value="300" />
				<div class="row" style="margin: auto;padding: 11px;background-color: #f0ece2;">
					<div class="col-md-3">
						<label class="rdiobox" style="width:100%;">
							<input class="" type="radio" value="edit" name="radio" id="radio1" onclick="radioUlbNameCheckFun();" selected> <span>Edit</span>
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput"></label>  
					<div class="col-md-4" id="buttonDiv">
						<input type="submit"  name="save" class="btn btn-success" value="Update" id="submitBtn" disabled>
						<a href="<?php echo base_url('view-widgets'); ?>"  class="btn btn-danger" >Cancel</a>
						
					</div>
				</div>
				<?php echo form_close();?>
			</div>
			<?php
			}
			else if($widget_det['widget_type_style'] == 2 || $widget_det['widget_type_style'] == 3)
			{
			?>
			
			<div class="form-horizontal">
				
				<?php $attributes=array('id'=>'form2'); echo form_open_multipart('ViewWidgetsController/uploadfile',$attributes);?>
				<?php // print_r($widget_det); ?>
				<?php $url="edite-widget/".$widget_det['widget_id']."/".$widget_det['widget_type']."/".$widget_det['widget_type_style']; ?>
				
				
				<input type="hidden" name="url" value="<?php echo $url; ?>">
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Upload Photo</label>  
					<div class="col-md-4">
						<input id="file" name="userfile" class="input-file" type="file" onchange="form_submit()">
						
					</div>
				</div>
				<?php echo form_close(); ?>
				
				<?php $attributes1=array('onsubmit'=>'return validateForm();');   echo form_open_multipart('ViewWidgetsController/editImageTextwidget',$attributes1); ?>
				<?php foreach($result['widgetName'] as $val){  ?>
					<input type="hidden" name="widget_type" value="<?php echo $val['widget_type']; ?>">
					<input type="hidden" name="widget_id" value="<?php echo $val['widget_id']; ?>">
					<input type="hidden" name="widget_type_style" value="<?php echo $val['widget_type_style']; ?>">
					
					<input type="hidden" name="uploadpath" value="<?php echo $filepath; ?>">
					<input type="hidden" name="file_name" value="<?php echo $filename; ?>">
					<input type="hidden" name="resource" value="<?php echo $filepath; ?>">
					<input type="hidden" name="thumbspath" value="<?php echo $thumbs; ?>">
					
					
					<div class="form-group">
						<label class="control-label col-sm-4" for="email">Widget Name :</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="widget_name" id="widgetname" onkeyup="widgetNameValidation()" value="<?php echo $val['widget_name']; ?>" <?php if(($this->session->userdata('user_type')) != 'A'){ echo 'readonly'; }?>>
						</div>
					</div>
					<div id="widgetNameValidationError" style="display:none;" class="alert alert-danger">
						<center><span id="widgetNameValidationSpan"></span></center>
					</div>
				<?php }?> 
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Present image</label>  
					<div class="col-md-4">
						<img src="<?php echo  $this->session->userdata('base_url').substr($filepath,2); ?>" class="img-responsive">
					</div>
				</div>
				<?php //foreach($result['widgetContent'] as $val){ ?>
				<div id="cropimageid" style="display:none;">
					<div class="form-group">
						<label class="col-md-4 control-label" for="textinput"> Crop image </label>  
						<div class="col-md-4">
							<img src="<?php echo  $this->session->userdata('base_url').substr($filepath,2);?>" alt="crop img" class="cropimg" id="yourImage"/>
							<div class="form-horizontal" style="">
								<input type="text" name="imgx" value="<?php echo $result['widgetContent'][0]['imgx']; ?>" id="x" class="form-control input-md" />  
								<input type="text" name="imgy" value="<?php echo $result['widgetContent'][0]['imgy']; ?>" id="y" class="form-control input-md" />  
								<input type="text" name="width" value="<?php echo $result['widgetContent'][0]['width']; ?>" id="w" class="form-control input-md" />  
								<input type="text" name="height" value="<?php echo $result['widgetContent'][0]['height']; ?>" id="h" class="form-control input-md" />  
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Title</label>  
					<div class="col-md-4">
						<input id="title" name="title" placeholder="Enter title here" class="form-control input-md" type="text" onkeyup="validatefunction();" value="<?php echo $result['widgetContent'][0]['title']; ?>">
					</div>
				</div>
				<div id="titleCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="titleCheckValidationSpan"></span></center>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Description</label>  
					<div class="col-md-4">
						<textarea rows="5" id="description" name="description" placeholder="Enter Description" class="form-control input-md mytext1" type="text"  required><?php echo $result['widgetContent'][0]['description']; ?>
						</textarea>
					</div>
				</div>
				<!--<div id="descriptionCheckValidationError" style="display:;" class="alert alert-danger">-->
				<!--	<center><span id="descriptionCheckValidationSpan">Maximum 240 Characters only</span></center>-->
				<!--</div>-->
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Page Url</label>  
					<div class="col-md-4">
						<input id="page_url" name="page_url" placeholder="Enter url here" class="form-control input-md" type="text" onkeyup="validatefunction();" value="<?php echo $result['widgetContent'][0]['url_link']; ?>">
					</div>
				</div>
				<div id="urlCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="urlCheckValidationSpan"></span></center>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Open window</label>  
					<div class="col-md-4">
						<select id="target" name="target" class="form-control" onchange="validatefunction();">
							<option value="0">- Select -</option>
							<option <?php echo ($result['widgetContent'][0]['target'] == '1') ? ' selected="selected"' : ''; ?> value="1">Open same window</option>
							<option <?php echo ($result['widgetContent'][0]['target'] == '2') ? ' selected="selected"' : ''; ?> value="2">Open other window</option>
							
						</select>
					</div>
				</div>
				<div id="WindowCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="WindowCheckValidationSpan"></span></center>
				</div>
				
				<input type="hidden" class="form-control" name="ulb_check_list[]" value="300" />
				<div class="row" style="margin: auto;padding: 11px;background-color: #f0ece2;">
					<div class="col-md-3">
						<label class="rdiobox" style="width:100%;">
							<input class="" type="radio" value="edit" name="radio" id="radio1" onclick="radioUlbNameCheckFun();" selected> <span>Edit</span>
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput"></label>  
					<div class="col-md-4" id="buttonDiv">
						<input type="submit"  name="save" class="btn btn-success" value="Update">
						
					</div>
				</div>
				<?php echo form_close();?>
			</div>
			<?php
			}else{
			?>
			<div class="form-horizontal">
				
				<?php $attributes=array('id'=>'form2'); echo form_open_multipart('ViewWidgetsController/uploadfile',$attributes);?>
				<?php // print_r($widget_det); ?>
				<?php $url="edite-widget/".$widget_det['widget_id']."/".$widget_det['widget_type']."/".$widget_det['widget_type_style']; ?>
				
				
				<input type="hidden" name="url" value="<?php echo $url; ?>">
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Upload Photo</label>  
					<div class="col-md-4">
						<input id="file" name="userfile" class="input-file" type="file" onchange="form_submit()">
						
					</div>
				</div>
				<?php echo form_close(); ?>
				
				<?php $attributes1=array('onsubmit'=>'return validateForm();');   echo form_open_multipart('ViewWidgetsController/editImageTextwidget',$attributes1); ?>
				<?php foreach($result['widgetName'] as $val){  ?>
					<input type="hidden" name="widget_type" value="<?php echo $val['widget_type']; ?>">
					<input type="hidden" name="widget_id" value="<?php echo $val['widget_id']; ?>">
					<input type="hidden" name="widget_type_style" value="<?php echo $val['widget_type_style']; ?>">
					
					<input type="hidden" name="uploadpath" value="<?php echo $filepath; ?>">
					<input type="hidden" name="file_name" value="<?php echo $filename; ?>">
					<input type="hidden" name="resource" value="<?php echo $filepath; ?>">
					<input type="hidden" name="thumbspath" value="<?php echo $thumbs; ?>">
					
					
					<div class="form-group">
						<label class="control-label col-sm-4" for="email">Widget Name :</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="widget_name" id="widgetname" onkeyup="widgetNameValidation()" value="<?php echo $val['widget_name']; ?>" <?php if(($this->session->userdata('user_type')) != 'A'){ echo 'readonly'; }?>>
						</div>
					</div>
					<div id="widgetNameValidationError" style="display:none;" class="alert alert-danger">
						<center><span id="widgetNameValidationSpan"></span></center>
					</div>
				<?php }?> 
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Present image</label>  
					<div class="col-md-4">
						
						<img src="<?php echo  $this->session->userdata('base_url').substr($filepath,2); ?>" class="img-responsive">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Title</label>  
					<div class="col-md-4">
						<input id="title" name="title" placeholder="Enter title here" class="form-control input-md" type="text" onkeyup="validatefunction();" value="<?php echo $result['widgetContent'][0]['title']; ?>">
					</div>
				</div>
				<div id="titleCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="titleCheckValidationSpan"></span></center>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Description</label>  
					<div class="col-md-4">
						<textarea rows="5" id="description" name="description" placeholder="Enter Description" class="form-control input-md mytext1" type="text" maxlength="240" required><?php echo $result['widgetContent'][0]['description']; ?></textarea>
					</div>
				</div>
				<!--<div id="descriptionCheckValidationError" style="display:;" class="alert alert-danger">-->
				<!--	<center><span id="descriptionCheckValidationSpan">Maximum 240 Characters only</span></center>-->
				<!--</div>-->
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Page Url</label>  
					<div class="col-md-4">
						<input id="page_url" name="page_url" placeholder="Enter url here" class="form-control input-md" type="text" onkeyup="validatefunction();" value="<?php echo $result['widgetContent'][0]['url_link']; ?>">
					</div>
				</div>
				<div id="urlCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="urlCheckValidationSpan"></span></center>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput">Open window</label>  
					<div class="col-md-4">
						<select id="target" name="target" class="form-control" onchange="validatefunction();">
							<option value="0">- Select -</option>
							<option <?php echo ($result['widgetContent'][0]['target'] == '1') ? ' selected="selected"' : ''; ?> value="1">Open same window</option>
							<option <?php echo ($result['widgetContent'][0]['target'] == '2') ? ' selected="selected"' : ''; ?> value="2">Open other window</option>
							
						</select>
					</div>
				</div>
				<div id="WindowCheckValidationError" style="display:none;" class="alert alert-danger">
					<center><span id="WindowCheckValidationSpan"></span></center>
				</div>
				
				<!--<div class="form-group">-->
   
				
				<input type="hidden" class="form-control" name="ulb_check_list[]" value="300" />
				<div class="row" style="margin: auto;padding: 11px;background-color: #f0ece2;">
					<div class="col-md-3">
						<label class="rdiobox" style="width:100%;">
							<input class="" type="radio" value="edit" name="radio" id="radio1" onclick="radioUlbNameCheckFun();" selected> <span>Edit</span>
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="textinput"></label>  
					<div class="col-md-4" id="buttonDiv">
						<input type="submit"  name="save" class="btn btn-success" value="Update">
						
					</div>
				</div>
				<?php echo form_close();?>
			</div>
			<?php } ?>
		</div>
	</div>
	
</div>

<script src='https://egovindia.in/TSFC/dynamic/assets/cdma/TSFC/js/jquery-3.6.0.js'></script>
<link rel="stylesheet" type= text/css href="https://egovindia.in/TSFC/dynamic/assets/cdma/TSFC/css/fontawesome/css/all.css">


<script>
    
    $(document).ready(function()
    {
		var type = <?php echo $this->uri->segment('4'); ?>;
		var widget = <?php echo $this->uri->segment('3'); ?>;
		
	});
    
    function form_submit()
    {
	    $("#form2").submit();
	}
    
    /* The uploader form */
    $(function () {
        $(":file").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
				
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
			}
		});
	});
	
    function imageIsLoaded(e) {
        $('#myImg').attr('src', e.target.result);
        $('#yourImage').attr('src', e.target.result);
	};
	
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
	
	
    
    
    function validatefunction()
    {
        //alert('click');
        var target = $("#target").val();
        var title = $("#title").val();
        var description = $("#description").val();
        var page_url  = $("#page_url").val();
        
        if(target == '0' && title == '' && description == '' && page_url == '')
		{
            $("#buttonDiv").hide();
            $("#titleCheckValidationError").show();
    	 	$("#titleCheckValidationSpan").html('Please Enter Image title');
    	 	$("#descriptionCheckValidationError").show();
    	 	$("#descriptionCheckValidationSpan").html('Please Enter Description');
    	 	$("#urlCheckValidationError").show();
    	 	$("#urlCheckValidationSpan").html('Please Enter Page URL');
    	 	$("#WindowCheckValidationError").show();
    	 	$("#WindowCheckValidationSpan").html('Please Select Open Window Option');
		}
		else if(title == '')
		{
            $("#titleCheckValidationError").show();
    	 	$("#titleCheckValidationSpan").html('Please Enter Image title');
    	 	return false;
		}
		else if(description == '')
		{
            $("#descriptionCheckValidationError").show();
    	 	$("#descriptionCheckValidationSpan").html('Please Enter Description');
    	 	return false;
		}
		else if(page_url == '')
		{
            $("#urlCheckValidationError").show();
    	 	$("#urlCheckValidationSpan").html('Please Enter Page URL');
    	 	return false;
		}
		else if(target == '0')
		{
            $("#WindowCheckValidationError").show();
    	 	$("#WindowCheckValidationSpan").html('Please Select Open Window Option');
    	 	return false;
		}
		else
		{
            $("#buttonDiv").show();
            $("#titleCheckValidationError").hide();
    	 	$("#titleCheckValidationSpan").html('');
    	 	$("#altCheckValidationError").hide();
    	 	$("#altCheckValidationSpan").html('');
    	 	$("#urlCheckValidationError").hide();
    	 	$("#urlCheckValidationSpan").html('');
    	 	$("#WindowCheckValidationError").hide();
    	 	$("#WindowCheckValidationSpan").html('');
		}
	}
</script>
