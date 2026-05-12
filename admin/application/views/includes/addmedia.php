
<link rel="stylesheet" href="<?php echo base_url()."assets/css/custom.css"?>">
<style>
    .mythumb{
	width: 125px;
	height: 125px;
	overflow: hidden;
	border: 1px solid #8ea6b4;
	-moz-box-shadow:    inset 0 0 10px #ccc;
	-webkit-box-shadow: inset 0 0 10px #ccc;
	box-shadow:         inset 0 0 10px #ccc;
    }
</style>
<div id="myModal" class="modal fade" role="dialog">
	<!-- <div ng-app="appLibrary">-->
	<div class="modal-dialog modal-lg" style="width:90%;">
		
		<!-- Modal content-->
		<div class="modal-content" style="background-color:#FFF;">
			<div class="modal-header" style="border-bottom: 1px #CCC solid;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Attachment Details</h4>
			</div>
			<div class="modal-body">
				
				<div class="col-md-8" style="padding-right:0px;">
					
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab1" >Media Library</a></li>
						<li><a data-toggle="tab" href="#tab2">Upload </a></li>
						
					</ul>
					<br>
					
					<div class="tab-content" >
						
						<div id="tab1" class="tab-pane fade in active" ng-controller="contrLibrary">
						    <div style="overflow-y:scroll; height:395px;">
								
								<?php $i=1;foreach($librarydata->result() as $key=>$val){
									
									if($val->is_image==1)
									{
										
									?>
									
									<div class="col-md-2" style="padding-left:0px;">
										
										<div class="mythumb image-checkbox lib-thumbnail" style="background-image: url(<?php echo $val->folder_path; ?>);" onclick="getfiledet(<?php echo $val->slide_id; ?>,<?php echo $i;?>)">	
											<label class="">
												
												<!--<img src="<?php echo $val->thumbnail_path; ?>">-->
												
												
												
												<input type="checkbox" name="image[]" value="<?php echo $val->slide_id; ?>" id="check<?php echo $i;?>"/>  <i class="fa fa-check hidden"></i>
												
												
												
											</label>
										</div>	
										
									</div>
									
									<?php }else{ ?>
									
									
									<div class="col-md-2" style="padding-left:0px;">
										
										<div class="mythumb image-checkbox lib-thumbnail" style="text-align:center" onclick="getfiledet(<?php echo $val->slide_id; ?>,<?php echo $i;?>)">
											<label class="">
												
												
												<img src="assets/img/file.png" style="padding-top:15px;"><br>
												<div class="myfile">
													<?php echo $val->image_path; ?>
												</div>
												<input type="checkbox" name="image[]" value="<?php echo $val->slide_id; ?>" id="check<?php echo $i;?>" />  <i class="fa fa-check hidden"></i>
												
												
												
											</label>
											
										</div>		
									</div>
									
									<?php
										
										
										
									}$i++;}?>
									
									
									
							</div>	
							
						</div>
						
						<div id="tab2" class="tab-pane fade">
							
							<?php 
								
								$statusList=array('0'=>'Offline','1'=>'Online');
							$attributes= array('class'=>'dropzone','id'=>'imageUpload'); echo form_open_multipart('LibraryController/imageUploadPost',$attributes);?>
							
							<img src="http://municipalservices.in/sites/admin/assets/img/icn-upload.png">
							
							<center><h3>Upload Multiple Images By Clicking On Box</h3></center>
							
							<?php echo form_close();?>
							
							
							
						</div>
						
					</div>       
					
					
				</div>    
				
				
				
				
				
				
				<div class="col-md-4 " style="padding-right:0px;">
					<div class="attachment-info att_detail" >
						
						
						<div id="fileDetails">
							
							
							<div class="col-md-6">
								<img src="" class="img-responsive" title="image name" alt="alt" id="thumbimage">
								
							</div>	
							<div class="col-md-6 font_nor" >
								<div style="text-overflow:ellipsis; overflow:hidden"> <span id="fname"></span></div>
								<div> <span id="ftype"></span></div>
								<div> <span id="timestamp"></span></div>
								<div> <span id="fsize"></span></div>
								<div><span id="fdim"></span> </div>
							</div>	
							<br>	<br>
							
							<hr style="clear:both;">
							
							<div class="clearfix"></div>
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-md-4 control-label text-right" for="url">URL</label>  
									<div class="col-md-8">
										<input id="filepath" name="filepath" placeholder="Enter URL" class="form-control input-md URL font_nor" type="text" readonly>
										
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label text-right" for="title">Title</label>  
									<div class="col-md-8">
										<input  name="textinput" id="title" placeholder="Enter title" class="form-control input-md URL font_nor" type="text">
										
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-md-4 control-label text-right" for="alttext">Alt Text</label>  
									<div class="col-md-8">
										<input  name="textinput" id="alttext" placeholder="Enter Alt Text" class="form-control input-md URL font_nor" type="text">
										
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label text-right" for="description">Description</label>  
									<div class="col-md-8">
										<textarea class="form-control URL font_nor" id="description" name="textarea" rows="3" placeholder="Enter Description"></textarea>
										
									</div>
								</div>
								
								
								
							</div>
							
							
						</div>
						
						
						
					</div><!-- files details-->
					
					
					
				</div>
				
				
				
			</div>
			
			
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-sm" onclick="getUpload()">Insert Data</button>
			</div>
			
			
			
		</div>
		
	</div>
	
	
	
	
	
	
	
	
	
	
	
</div>


	
	
	
		<script src="<?php echo base_url()?>assets/dropzones/jquery.js"></script>
		
		<script src="<?php echo base_url()?>assets/dropzones/dropzone.min.js"></script>
		
		<script src="<?php echo base_url()?>assets/dropzones/bootstrap.min.js"></script> 
		
		<script type="text/javascript">
		
		Dropzone.options.imageUpload = {
		
		maxFilesize:20,
		
		acceptedFiles: "",
		
		success: function(){
		
		
		}
		alert('Your images uploaded to library');
		
		};
		
		
		
		
		function getImgDet()
		{
		alert('Get details here');
		}
	</script>
	
	
	
	
	
	
	<style>
		
		
		
		
		
	    .dropzone {
        
		min-height: 200px;
		padding: 60px 20px 0px 20px;
		text-align: center;
		border: dashed 3px #C1C3C5;
		}
		
		
		.dropzone::before{
        position: absolute;
		top: 36%;
		left: 50%;
		margin-left: -25px;
		content: "";
		width: 51px;
		height: 33px;
		/*background-image: url("http://municipalservices.in/sites/admin/assets/img/icn-upload.png");*/
		background-size: 100%;
		}
		
		
		.modal-header{
        
		}
		
		label{
        font-weight:normal !important;
		}
		
		ul{
		list-style-type:none;
		}
		
		
		
		
		
		
		
	</style>
 
	<script>
	$(document).ready(function()
	{
	    // image gallery
			// init the state from the input
			$(".image-checkbox").each(function () {
			   
				if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
					$(this).addClass('image-checkbox-checked');
				}
				else {
					$(this).removeClass('image-checkbox-checked');
				}
			});
			
			// sync the state to the input
			$(".image-checkbox").on("click", function (e) {
				$(this).toggleClass('image-checkbox-checked');
				var $checkbox = $(this).find('input[type="checkbox"]');
				$checkbox.prop("checked",!$checkbox.prop("checked"))
				
				e.preventDefault();
			});
			
			// toggle functionality
			
				$("#createalbum").click(function(){
					
					$("#toggleCreateAlbum").toggle();
				});
	});	
	</script>
	
	<!--
	<script>
	    var app=angular.module('appLibrary',[]);
	    app.controller('contrLibrary',function($scope,$http)
	    {
	        $http.get('LibraryController/getAllLibraryFiles').then(function(response)
	        {
	            alert(data);
	            $scope.data=response.data
			});
	        
		});
	</script>-->
	<script>
	    function getUpload() {
			var checkboxes = document.getElementsByName('image[]');
			
			var checkList = [];
			for (var i=0; i<checkboxes.length;i++) 
			{
				if (checkboxes[i].checked) 
				{
					
					checkList.push(checkboxes[i].value);
				}
			}
			
			
		}
		function getfiledet(slide_id,i)
		{
		    
		    
		    $.post('LibraryController/getFileInfo',{slide_id:slide_id},function(data)
		    {
		        
		        
		        
		        var obj=JSON.parse(data);
		        $("#fname").text(obj.image_path);
		        $("#ftype").text(obj.file_ext);
		        $("#timestamp").text(obj.ts);
		        $("#fsize").text(obj.file_size);
		        $("#fdim").text(obj.image_width + " X " + obj.image_height);
		        $("#filepath").text(obj.folder_path);
		        $("#title").text(obj.title);
		        $("#alttext").text(obj.alttext);
		        $("#description").text(obj.description);
		        $("#thumbimage").prop('src',obj.folder_path)
		        
		        if(obj.is_image==0)
		        {
		            $("#thumbimage").prop('src','assets/img/file.png')
				}
		        
		        
		        if($("#check" + i).is(":checked"))
				{
        		    $("#fileDetails").css('display','block');
				}
				else
				{
					$("#fileDetails").css('display','none');
				}
				
				
		        
		        
		        
			});
		}
	</script>
	





