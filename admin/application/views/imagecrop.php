<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



<link href="<?php echo base_url()?>assets/imagecropplugins/resource/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/imagecropplugins/resource/cropimg.css" />
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="<?php echo base_url()?>assets/imagecropplugins/resource/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/imagecropplugins/resource/cropimg.jquery.js"></script>



<div class="sh-pagebody">
    
    <div class="card bd-primary ">
		<div class="card-header bg-primary tx-white">Crop Image</div>
		<div class="card-body ">
			
			
			<div class="mypagetitile"></div>
			<br>
			<div class="row">
				<div class="col-md-12">
					<!-- image crop code-->
					
					<input type="hidden" id="image_path" value="<?php echo $this->session->userdata('source_image');?>">
					<input type="hidden" id="slide_id" value="<?php echo $source_image['post_id'];?>">
					<input type="hidden" id="thumbspath" value="<?php echo $this->session->userdata('pathimagesaveurl');?>">
					
					<img src="<?php echo $this->session->userdata('base_url').$this->session->userdata('source_image');?>" alt="crop img" class="cropimg" />
					<script>
						$(document).ready(function() {
							$('img.cropimg').cropimg({
								resultWidth:1366,
								resultHeight:400,
								onChange: function() {
									$('#preview-info').hide();
									$('#preview-container').show();
								}
							});
							
							$('.btn-crop').click(function() {
								
								var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
								
								
								
								var width=$('#w').val();
								var height=$('#h').val();
								var x=$('#x').val();
								var y=$('#y').val();
								var source_image=$("#image_path").val();
								var thumb_image=$("#thumbspath").val();
								var slide_id=$("#post_id").val();
								
								
								$.post('<?php echo base_url(); ?>/ImageCropController/imageCrop123',{width:width,height:height,imgx:x,imgy:y,source_image:source_image,slide_id:slide_id,thumb_image:thumb_image,'csrf_test_name': csrf_value},function(data)
								{
									alert(data);
									window.location='<?php echo base_url(); ?>view-posts';
								});
								
								
								
							});
						});
						
						function fun1()
						{
						    
						    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
							var img_width=$('#w').val();
							var img_height=$('#h').val();
							var img_x=$('#x').val();
							var img_y=$('#y').val();
							var source_image=$("#image_path").val();
							
							$.post('<?php echo base_url(); ?>/ImageCropController/imageCrop123',{width:img_width,height:img_height,x:img_x,y:img_y,source_image:source_image,'csrf_test_name': csrf_value},function(data)
							{
								alert(data);
								
							});
						}
					</script>
					<div>
						
						<div class="form-horizontal" style="visibility:hidden;">
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">X</label>  
								<div class="col-md-4"> 
									<input type="text" name="" value="0" id="x" class="form-control input-md" />  
								</div>
								<label class="col-md-2 control-label" for="textinput">Y</label>  
								<div class="col-md-4"> 
									<input type="text" name="" value="0" id="y" class="form-control input-md" />  
								</div>
								
							</div>
							
							
							
							<div class="form-group">
								
								<label class="col-md-2 control-label" for="textinput">Width</label>  
								<div class="col-md-4"> 
									<input type="text" name="" value="0" id="w" class="form-control input-md" />  
								</div>
								<label class="col-md-2 control-label" for="textinput">Height</label>  
								<div class="col-md-4"> 
									<input type="text" name="" value="0" id="h" class="form-control input-md" />  
								</div>
								
							</div>		
							
							
							
						</div>
						
						
						
						<center>
						    <button class="btn-crop btn btn-success"><i class="fa fa-crop"></i> Crop this image</button>
						    <!--<a href="<?php echo base_url()?>create-post" class="btn btn-danger">Back</a>-->
						    </center>
						
						
						
						
						
						<br><br><br><br><br>
						
						
					</div>
					
					
					<!-- close-->
				</div>
			</div>
			
		</div>
	</div>
</div>





