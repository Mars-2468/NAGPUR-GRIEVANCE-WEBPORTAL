<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	ini_set('display_errors',0);
?>
<!-- editors--->
<head>
	
    
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
	<script src="<?php echo base_url()?>assets/editors/jquery.min.js"></script>
	<script src="<?php echo base_url()?>assets/editors/jquery-1.11.3.js"></script>
	<script  src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>
	
	<script  src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
	<script  src = "<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
	<script  src = "<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
	<script  src = "<?php echo base_url() ?>assets/js/tags.js"></script><!-- // this is for tags -->
	
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
	<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<script type = "text/javascript">
		
		var BASE_URL = "http://municipalservices.in/sites/assets/editors2/"; // use your own base url
		
		
		tinymce.init({
			selector: "#richTextArea",theme: "modern",width: 710,height: 500,
			theme: "modern",
			// width: 680,
			// height: 200,
			relative_urls: false,
			remove_script_host: false,
			// document_base_url: BASE_URL,
			plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
			],
			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
			toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
			image_advtab: true,
			
			external_filemanager_path: BASE_URL + "filemanager/",
			filemanager_title: "Media Gallery",
			external_plugins: {"filemanager": BASE_URL + "filemanager/plugin.min.js"}
			
		});
	</script>
	<script>
		
		function go_draft()
		{
			
			$("#is_draft").val('1');
			$("#category_form").find('[type="submit"]').trigger('click');
			//$("#category_form").find('[type="button"]').trigger('click');
			//$("#category_form").submit();
		}
	</script>
	<!--textbox spaces and characters-->
	<script>
		$(document).ready(function(){
			$("#inputTextBox").keypress(function(event){
				var inputValue = event.charCode;
				if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
					event.preventDefault();
				}
			});
		});
		
		
		
	</script>
	
	
	
	
	<style>
		#mceu_34{display:none;}
		
		.panel-body {
		padding: 10px;
		}
		
		.mycalender i {
		position: absolute;
		left: 8px;
		top: 6px;
		pointer-events: none;
		font-size: 1.5em;
		cursor:pointer;
		}
		.mycalender {
		position: relative;
		}
		
		
		.add-on .input-group-btn > .btn {
		border-left-width:0;left:-2px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		}
		/* stop the glowing blue shadow */
		.add-on .form-control:focus {
		box-shadow:none;
		-webkit-box-shadow:none; 
		border-color:#cccccc; 
		}
		
		
		
		.bootstrap-tagsinput {
		background-color: #fff;
		border: 1px solid #ccc;
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		/*display: inline-block;*/
		padding: 4px 6px;
		color: #555;
		vertical-align: middle;
		border-radius: 0px;
		max-width: 100%;
		line-height: 22px;
		cursor: text;
		}
		.bootstrap-tagsinput input {
		border: none;
		box-shadow: none;
		outline: none;
		background-color: transparent;
		padding: 0 6px;
		margin: 0;
		width: auto;
		max-width: inherit;
		}
		.bootstrap-tagsinput.form-control input::-moz-placeholder {
		color: #777;
		opacity: 1;
		}
		.bootstrap-tagsinput.form-control input:-ms-input-placeholder {
		color: #777;
		}
		.bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
		color: #777;
		}
		.bootstrap-tagsinput input:focus {
		border: none;
		box-shadow: none;
		}
		.bootstrap-tagsinput .tag {
		margin-right: 2px;
		color: white;
		}
		.bootstrap-tagsinput .tag [data-role="remove"] {
		margin-left: 8px;
		cursor: pointer;
		}
		.bootstrap-tagsinput .tag [data-role="remove"]:after {
		content: "x";
		padding: 0px 2px;
		}
		.bootstrap-tagsinput .tag [data-role="remove"]:hover {
		box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
		}
		.bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
		box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
		}
		
		
		.bootstrap-tagsinput .label{
		font-size:13px;
		font-weight:normal;
		}   
		.bootstrap-tagsinput .tag [data-role="remove"]{
        
        opacity:1;
		}
		
		.bootstrap-tagsinput .tag [data-role="remove"]::after{
        
        font-family:arial;
		}
		
		
		
		.snip1550 {
		position: relative;
		display: inline-block;
		overflow: hidden;
		margin: 6px -10px !important;
		min-width: 176px;
		max-width: 175px;
		width: 100%;
		font-size: 16px;
		line-height: 1.2em;
		}    
		
		
		
		
		.icon{
        height: 127px;
		border: 1px #dfdfdf solid;
		background-color: #efefef;
		}
		
		
		.icon i {
		display: table-cell;
		font-size: 30px;
		vertical-align: middle;
		color: #000;
		padding-top: 44px;
		padding-left:60px;
		padding-bottom: 49px;
		text-align: center;
		}
		
		
		.input-group{
        padding-right: 15px !important;
		padding-left: 15px !important;
		}
		
		
		.form-control{
		border-radius: 0px !important;
		}    
		
		.panel-title{
        font-size:14px !important;
		}
		
		
	</style>
	
	
	
	
	
	
	
	<body>
		
		<div class="sh-pagebody">
			
			
			
			
			<div class="col-md-9" style="padding-left: 0px;">
				
				
				<div class="card bd-primary ">
					
					<div class="card-header bg-primary tx-white">Add New Post</div>
					
					<div class="card-body pd-sm-30">  
						
						
						<?php if($this->session->flashdata('message')){?>
							
							<div class="alert alert-success text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
							<div> Page URL : <?php echo $this->session->flashdata('permalink'); ?></div>
						<?php }?>
						
						
						
						<?php $attribute=array('id'=>'category_form'); echo form_open_multipart('create-post',$attribute);?>
						
						<input type="hidden" name="is_draft" id="is_draft" value="0">
						<input type="hidden" name="is_custumlink" id="is_custumlink" value="2">
						
						<div class="form-horizontal">
							
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Post name: <span class="tx-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" name="pagename" class="form-control "  onkeyup="fun1(this.value)" placeholder="Enter Post name" required>
									<span class="myerror"> <?php echo form_error('pagename');?></span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Post Title: <span class="tx-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" name="pagetitle" class="form-control mytext"  onkeyup="fun1(this.value)" placeholder="Enter Post title" required>
									<span class="myerror"> <?php echo form_error('pagetitle');?></span>
								</div>
							</div>
							
							
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="email"></label>
								<div class="col-sm-9">
									<input type="button" id="enableDate" value="Enable Date" class="btn btn-default">
									<input type="hidden" id="enableDateStatus" value="0">
								</div>
							</div>
						
							
							<div style="display:none" id="period">
								

								<div class="form-group">
									<label class="control-label col-sm-3" for="fromdate">From Date: <span class="tx-danger">*</span></label>
									<div class='input-group date col-sm-9' id='datepickerfrom'>
										<input type='text' class="form-control" name="fromDate"/>
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
									<div class="col-sm-1">
										<!--<span class="myerror"> <?php echo form_error('fromDate');?>-->
									</div>
								</div>
								
								
								
								<div class="form-group">
									<label class="control-label col-sm-3" for="todate">To Date: <span class="tx-danger">*</span></label>
									
    									<div class='input-group date col-sm-9' id='datepickerto'>
    										<input type='text' class="form-control" name="toDate"/>
    										<span class="input-group-addon">
    											<span class="fa fa-calendar"></span>
    										</span>
    										
    									</div>
    									
    									<div class="col-sm-1">
    										<!--<span class="myerror"> <?php echo form_error('toDate');?></span>-->
    									</div>
								</div>
								    
							    </div>
							
							
						</div>
						
						
						<hr>
						
						<div>
							<a class="btn btn-default" data-toggle="modal" data-target="#myModal" onclick="media()"><i class="fa fa-image"></i> Add Media </a>
						</div>
						
						<br>
						<div class="">
							<textarea id="richTextArea"  name="content" style=" height:400px;"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>
							
						</div>
						<br>
						
						<div class="form-horizontal">
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Hover title:<span class="tx-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control mytext" placeholder="Hover title" name="hover_title" required>
									
								</div>
								
							</div>  
							
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Related Tags:  <span class="tx-danger">*</span> <br> <span style="font-size:12px;"> Separated by Space </span></label>
								<div class="col-sm-9">
									
									<input rows="3" data-role="tagsinput"  type="text" class="form-control mytext" placeholder="Related tags" name="ptags" required>
									<!--<span class="myerror"> <?php echo form_error('ptags');?></span>-->
									
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Description:  <span class="tx-danger">*</span> <br> </label>
								<div class="col-sm-9">
									<textarea rows="3" class="form-control mytext" placeholder="Enter Page Related Description here " name="meta_desc" required></textarea>
									<span class="myerror"> <?php echo form_error('ptags');?></span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Subject  <span class="tx-danger">*</span> <br> </label>
								<div class="col-sm-9">
									<textarea rows="3" class="form-control mytext" placeholder="Enter Page subject here " name="meta_subject" required></textarea>
									<span class="myerror"> <?php echo form_error('ptags');?></span>
								</div>
							</div>
							
	
						</div>
						
						
						<span class="error"><?php echo form_error('content');?></span>
						<br>
						
						
						<br><br>
						
						
					</div>
				</div>
				
				
				<!----------------------- forms start here -------------------------------->
				
				
				<div>
					<?php $i=1;  foreach($categories as $key=>$val){ ?>
						
						
						<input type="hidden" name="category_id<?php echo $key; ?>" value="<?php echo $val; ?>">
						<input type="hidden" name="category_desc<?php echo $key; ?>" value="<?php echo $val; ?>">
						<input type="hidden" name="tbl<?php echo $key; ?>" value="<?php echo $tbls[$key]; ?>">
						<div style="display:none;" id="<?php echo $key;?>" class="hidden_divs">
							
							<div class="card bd-primary mg-t-20">
								<div class="card-header bg-primary tx-white"><?php echo $val; ?> Details </div>
								<div class="card-body pd-sm-30">
									
									
									
									<div class="form-horizontal">
										
										<?php $content=""; foreach($forms[$key] as $sno=>$label){?> 
											
											<?php 
												// if any dependent fields on select yes or no found need to display them in none
												
												if(in_array($sno,$hiddenfields))
												{
													$customStyle="style='display:none;'";
												}
												else
												{
													$customStyle=""; 
												}
												
												// to display dependent fields on change of parent select box need to set function to on changing the value
												
												if(in_array($sno,$dependentParentFields))
												{
													$dependentFunction=" onchange=getDependentFields(this.value,'".$setFunctionValues[$sno]."')";
												}
												else
												{
													$dependentFunction="";
												}
												
												
												if($label['type']=="text" || $label['type']=="file")
												{
													// in case field is date picker then to set minimum date
													
													if($label['data_type']=="date")
													{
														$name=$label['id'];
														$function=" onchange=setMindate('".$label['min_date_after']."','".$name."')";
													}
													else
													{
														$function="";
													}
													$content.="<div class='form-group' ".$customStyle." id='".$sno."'>";
													$content.="<label class='col-md-5 control-label' for='".$label['label']."'>".$label['label']." <span class='tx-danger'>*</span></label>";  
													$content.="<div class='col-md-4'>";
													$content.="<input id='".$label['id']."' name='".$label['name'].$key."' placeholder='".$label['label']."' class='form-control input-md ".$label['class']." ".$key." csl".$sno."'   type='".$label['type']."' ".$function." ".$dependentFunction.">";  
													$content.="</div>";		
													$content.="</div>";
												}
												if($label['type']=="select")
												{
													$content.="<div class='form-group' ".$customStyle." id='".$sno."'>";
													$content.="<label class='col-md-5 control-label' for='".$label['label']."'>".$label['label']." <span class='tx-danger'>*</span> </label>";  
													$content.="<div class='col-md-4'>";
													$content.="<select id='".$label['id']."' name='".$label['name'].$key."'  class='form-control input-md ".$label['class']." ".$key." csl".$sno."' ".$dependentFunction.">";
													$content.="<option value='0'>---select---</option>";
													foreach($select_options[$sno] as $option_id=>$option_value)
													{
														$content.="<option value='".$option_id."_".$option_value['option_desc']."'>".$option_value['option_desc']."</option>"; 
													}
													
													$content.="</select>";  
													$content.="</div>";		
													$content.="</div>";
												}
											?>
											
										<?php }  echo $content; ?>
										
									</div>
									
								</div>
							</div>
						</div>
						
					<?php $i++;}?>
				</div> 
				<!---------------------- forms close here ------------------------------->

			</div>
			<div class="col-md-3"  style="padding-right: 0px; padding-left: 0px;">
				
				<div class="panel-group d-accordion">
					
					
					<div class="panel panel-default" style="margin-bottom:15px;">
						<div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#publish">
							<h4 class="panel-title">Publish <i class="fa fa-chevron-up pull-right"></i></h4>
						</div>
						<div id="publish" class="panel-collapse collapse in">
							<div class="panel-body">
								<center>
									<input type="submit" name="draft" value="Save to Draft" class="btn btn-primary btn-sm" id="draft" onclick="go_draft()">	
								<input type="submit" name="save" value="Publish" id="publish" class="btn btn-success btn-sm"></center> 
							</div>
						</div>
					</div>
					
					
					
					<div class="panel panel-default" style="margin-bottom:15px;">
						<div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#layout">
							<h4 class="panel-title">Page Attributes <i class="fa fa-chevron-up pull-right"></i></h4>
						</div>
						<div id="layout" class="panel-collapse collapse in">
							<div class="panel-body">
								
								<div class="form-group">
									<label>Select layout</label>
									<select class="form-control" id="sel1" name="layourid">
										
										<option value="1">Left side bar</option>
										<option value="2">Right side bar</option>
										<option value="3">Two side bars</option>
										<option value="4">Full page</option>
										<option value="5" selected>Default layout</option>
									</select>
								</div>
								
							</div>
							
							<div class="panel-body">
								<label class="ckbox" style="font-size:13px;">
									<input type="checkbox" id="target" value="1"><span>Open link in a new window / Tab</span>
								</label>
							</div>
						</div>
					</div>
					
					
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#aboutus">
							<h4 class="panel-title"><strong> Categories </strong><i class="fa fa-chevron-up pull-right"></i></h4>
						</div>
						<div id="aboutus" class="panel-collapse collapse in">
							<div class="panel-body">
								
								<?php $i=1; foreach($categories as $key=>$val){?>
									<label class="ckbox" style="width:100%;">
										<input type="checkbox" value="<?php echo $key; ?>" class="chkcat" name="categories[]" onclick="fun1();"><span><?php echo $val?></span><br>
										
									</label>
									
								<?php $i++;}?>
								
							</div>
						</div>
					</div>
					
					
				</div>
				
				
			</div>
			
			
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	</div>
    <?php echo form_close();?>
    
    <link rel="stylesheet" href="<?php echo base_url()?>assets/timepicker/css/bootstrap.min.css">
	
    <!-- Optional theme -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/timepicker/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/timepicker/css/bootstrap-datetimepicker.min.css" />
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="<?php echo base_url()?>assets/timepicker/js/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/timepicker/js/bootstrap.min.js"></script>
    
    <script src="<?php echo base_url()?>assets/timepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(document).ready(function()
        {
            $( ".datepicker" ).datetimepicker({minDate: new Date(),format:'DD-MM-YYYY HH:mm'});
            
            
            $("#enableDate").click(function()
            {
                var enableDateStatus = $("#enableDateStatus").val();
                
                
                $("#period").toggle();
			});
            
            
			//             $( "#datepickerfrom" ).datepicker({
			//             changeMonth: true,  
			//             changeYear:true,      
			//             minDate:0,
			//             dateFormat:'dd-mm-yy',
			//             onSelect: function( selectedDate ) {
			//         $( "#datepickerto" ).datepicker( "option", "minDate", selectedDate );
			//       }
			//     });
			
			//   // $('#timepickerfrom').timepicki(); 
			//     $( "#datepickerto" ).datepicker({      
			//       changeMonth: true,   
			//       changeYear:true,
			//       minDate:0,
			//       dateFormat:'dd-mm-yy',
			//       onSelect: function( selectedDate ) {
			//         $( "#datepickerfrom" ).datepicker( "option", "maxDate", selectedDate );
			//       }
			//     });
			//     //$('#timepickerto').timepicki(); 
			$('#datepickerfrom').datetimepicker({minDate: new Date(),format:'DD-MM-YYYY HH:mm'});
			$('#datepickerto').datetimepicker({
				format:'DD-MM-YYYY HH:mm',
				useCurrent: false //Important! See issue #1075
			});
			$("#datepickerfrom").on("dp.change", function (e) {
				$('#datepickerto').data("DateTimePicker").minDate(e.date);
			});
			$("#datepickerto").on("dp.change", function (e) {
				$('#datepickerfrom').data("DateTimePicker").maxDate(e.date);
			});
			
			$("#getcatform").click(function()
			{
				/* var category_id=$("#category_id").val();
					$.post('CreatePostController/getTenderForm',{category_id:category_id},function(data)
					{
					$("#result").html(data);
				});*/
				
				$("#category_form").submit();
				
				
			});
			
			
			
			
			
		});
        
        function fun1()
        {
            
            $(".hidden_divs").css('display','none');
            $(".reqclass").removeProp('required',false);
			
			$("input[type=checkbox]:checked").each(function(i){
				
				$("#" + $(this).val()).css('display','block');
				$("." + $(this).val()).prop('required',true);
				
			});
		}
	</script>
    
	<script language='javascript'>
		function setMindate(classid,name)
		{
			
			var previousdate=$("#" + name).val();
			alert(classid);
			$( "cls" + classid).datetimepicker({minDate: new Date(previousdate),format:'DD-MM-YYYY HH:mm'});
			
			
		}
		
		function getDependentFields(dependentvalue,displaystyleid)
		{
			
			var arr=dependentvalue.split("_");
			var str=arr[1].toUpperCase();
			
			if(str=='YES')
			{
				$("#" + displaystyleid).css('display','block');
			}
			else
			{
				$("#" + displaystyleid).css('display','none');
			}
		}
		
		
	</script>
	
	
	
    
    
    
	
