<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>
<head>
    
 

<!-- 
<script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script>

<script src="<?php //echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>-->

<!--<script  src="<?php //echo base_url() ?>assets/editors2/tinymce.min.js"></script> -->
<!--<script type="text/javascript" src="https://egovindia.in/TSFC/dynamic/admin/assets/editors2/tinymce.min-5.10.2.js"></script>-->
<!-- <script type="text/javascript" src="https://cdn.tiny.cloud/1/o18hvsjrdz2ygt5yj2furkpyuz6mfuvrop05uu4eetaxk3cg/tinymce/5/tinymce.min.js "></script> -->

<script src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>
<script  src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
<script src = "<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
<script  src = "<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
<!--
<script  src = "<?php echo base_url() ?>assets/js/tags.js"></script> // this is for tags -->

<script >

        // tinymce.init({
        //       selector: 'textarea#default',
        //       plugins: [
        //        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        //        'tinymcespellchecker code table'],
        //       toolbar: "code",
        //       menubar: "file edit insert view format table tools help"
 
        //    });
        
        tinymce.init({
            //selector: "textarea#default",theme: "modern",width: 850,height: 500,
            selector: "textarea#content",theme: "modern",height: 500,
            theme: "modern",
            // width: 680,
            // height: 200,
            relative_urls: true,
            //remove_script_host: true,
            // document_base_url: BASE_URL,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
            image_advtab: true,

            /*external_filemanager_path: BASE_URL + "filemanager/",
            filemanager_title: "Media Gallery",
            external_plugins: {"filemanager": BASE_URL + "filemanager/plugin.min.js"},*/
        
        });

        // var BASE_URL = "http://municipalservices.in/sites/assets/editors2/"; // use your own base url


    tinymce.init({
      selector: "#richTextArea",theme: "modern",width: 710,height: 500,
      
        theme: "modern",
        // width: 680,
       // height: 200,
        relative_urls: true,
        //remove_script_host: true,
        // document_base_url: BASE_URL,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true,

        /*external_filemanager_path: BASE_URL + "filemanager/",
        filemanager_title: "Media Gallery",
        external_plugins: {"filemanager": BASE_URL + "filemanager/plugin.min.js"},*/
      
        
    });
    
    
    
</script>






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

<script>
	
    function go_draft()
    {
       
        $("#is_draft").val('1');
        $("#category_form").find('[type="submit"]').trigger('click');
        //$("#category_form").find('[type="button"]').trigger('click');
        //$("#category_form").submit();
    }
</script>


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
    
    /* bootstrap-tagsinput.css file - add in local */

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
/*.snip1550:before {*/
/*    position: absolute;*/
/*    top: 0px;*/
/*    bottom: 0px;*/
/*    left: 10px;*/
/*    right: 10px;*/
/*    content: '';*/
/*    background:none!important;*/
/*    opacity: 0;*/
/*    -webkit-transition: all 0.35s ease;*/
/*    transition: all 0.35s ease;*/
/*}*/



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

.thumb_bor{
    border:0px #ccc solid;
}
.thumb_bor1{
    border:1px #00c1ff solid;
    position:relative;
}

.form-control{
    border-radius:0px;
}

    
</style>


<script> 
		
		$(document).ready(function(){
			
		$(".snip1550").click(function () {
   $(".thumb_bor").toggleClass("thumb_bor1");
});	
			
		});	
		
	
	</script>


</head>

<body>
    
    <?php
             $a = mt_rand(1000,9999);
            
             $base_url=base_url();
             $aa=base_url(uri_string());
            
            $image_path=base_url()."assets/captcha/captcha3.png";
           $content=$this->session->flashdata('message');
      ?>
    
    
<div class="sh-pagebody">
    <div class="row">
    
    <div class="col-md-9" style="padding-left: 0px;">
        
		<?php if($this->session->flashdata('error_message')){?>							
			<div class="alert alert-danger text-center"> <strong> <?php echo $this->session->flashdata('error_message');?> </strong></div>
		<?php }?>     
		<?php if($this->session->flashdata('success_message')){?>							
			<div class="alert alert-success text-center"> <strong> <?php echo $this->session->flashdata('success_message');?> </strong></div>
		<?php }?>
		
        <div class="card bd-primary ">
    
            <div class="card-header bg-primary tx-white">Add New Post</div>
    
            <div class="card-body pd-sm-30">
                
                <?php if($this->session->flashdata('message')){?>
					<!--		
					<div class="alert alert-success text-center"> <strong> <?php //echo $this->session->flashdata('message');?> </strong></div>
					-->
					<div> Page URL : <a href="#" style="text-decoration:none;"><?php echo $this->session->flashdata('permalink'); ?></a></div>
				<?php }?>
				
				<?php $attribute=array('id'=>'category_form'); echo form_open_multipart('add-post',$attribute);?>
			
				<input type="hidden" name="is_draft" id="is_draft" value="0">
				<input type="hidden" name="is_custumlink" id="is_custumlink" value="2">
                
                <div class="form-horizontal">

                <div class="form-group">
                        <label class="control-label pl-0 col-sm-3" >Language:
                            
                        
                        
                        <span class="tx-danger">*</span></label>
                        <div class="col-sm-12" style="padding-left:0px; padding-right:0px;">
                            <select name="lang_id" id="lang_id" class="form-control mytext">
                                <option value="">-- select--</option>
                                <option value="1">English</option>
                                <option value="2">Marathi</option>



                            </select>
                        </div>
                    </div>

                    <?php if($this->session->userdata('user_type')=='A'){?>

                    <div class="form-group">
                        <label class="control-label pl-0 col-sm-3" >Departments:
                            
                        
                        
                        <span class="tx-danger">*</span></label>
                        <div class="col-sm-12" style="padding-left:0px; padding-right:0px;">
                            <select name="department" id="department" class="form-control mytext">
                                <option value="">-- select--</option>
                                <?php foreach($departments as $val){ ?>
                                <option value="<?php echo $val['user_id'];?>"><?php echo $val['depart_name'];?></option>
                                <?php } ?>



                            </select>
                        </div>
                    </div>
                    <?php } ?>


                    <div class="form-group">
                        <label class="control-label pl-0 col-sm-3" >Post name:
                            
                        
                        
                        <span class="tx-danger">*</span></label>
                        <div class="col-sm-12" style="padding-left:0px; padding-right:0px;">
                            <input type="text" name="pagename" class="form-control mytext"  data-type="text" onkeyup="funInputFielTypes(this)" required="required" id="pagename" >
                            <div style="font-size:10px;color:red;" id="pagenameX"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label pl-0 col-sm-3" >Post Title: <span class="tx-danger">*</span></label>
                        <div class="col-sm-12" style="padding-left:0px; padding-right:0px;">
                            <input type="text" name="pagetitle" id="pagetitle" class="form-control mytext"  data-type="text" onkeyup="funInputFielTypes(this)" required="required" >
                            <div style="font-size:10px;color:red;" id="pagetitleX"></div>
                        </div>
                    </div>

                    <!--<div class="form-group">-->
                    <!--    <label class="control-label col-sm-3" ></label>-->
                    <!--    <div class="col-sm-12" style="padding-left:0px; padding-right:0px;">-->
                    <!--        <input type="button" id="enableDate" value="Enable Date" class="btn btn-default">-->
                    <!--        <input type="hidden" id="enableDateStatus" value="0">-->
                    <!--    </div>-->
                    <!--</div> -->

                    <!--<div style="display:none" id="period">-->
                    <!--    <div class="form-group">-->
                    <!--        <label class="control-label col-sm-3" for="fromdate">From Date: <span class="tx-danger">*</span></label>-->
                    <!--        <div class='input-group date col-sm-9' id='datepickerfrom' >-->
                    <!--            <input type='text' class="form-control" name="fromDate"/>-->
                    <!--            <span class="input-group-addon">-->
                    <!--                <span class="fa fa-calendar"></span>-->
                    <!--            </span>-->
                    <!--        </div>-->
                    <!--        <div class="col-sm-1">-->
                            <!--<span class="myerror"> <?php //echo form_error('fromDate');?>-->
                    <!--        </div>-->
                    <!--    </div>-->

                    <!--    <div class="form-group">-->
                    <!--        <label class="control-label col-sm-3" for="todate">To Date: <span class="tx-danger">*</span></label>-->
                    <!--        <div class='input-group date col-sm-9' id='datepickerto' >-->
                    <!--            <input type='text' class="form-control" name="toDate"/>-->
                    <!--            <span class="input-group-addon">-->
                    <!--                <span class="fa fa-calendar"></span>-->
                    <!--             </span>-->
                    <!--        </div>-->
                    <!--        <div class="col-sm-1">-->
                            <!--<span class="myerror"> <?php //echo form_error('toDate');?></span>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                <hr>
                
                <!--<div>-->
                <!--    <a class="btn btn-secondary btn-sm text-white" data-bs-toggle="modal"  onclick="media()" ><i class="fa fa-image"></i> Add Media </a>-->
                <!--</div>-->
                <br>	
                
                <!--<div class="">-->
                <!--    <textarea id="richTextArea" name="content" style="width:100%; height:400px;"></textarea>-->
                <!--</div>-->
                <div class="">
                <textarea id="content" name="content" style="width:100%; height:400px;" data-type="sptext" onkeyup="funInputFielTypes(this)"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>
                <div style="font-size:10px;color:red;" id="contentX"></div>
				</div>

                <br><br>
                <div class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label pl-0 col-sm-3" for="email">Hover title:<span class="tx-danger">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control " placeholder="Hover title" name="hover_title" id="hover_title" required="required" data-type="text" onkeyup="funInputFielTypes(this)" >
                       <div style="font-size:10px;color:red;" id="hover_titleX"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label pl-0 col-sm-3" for="email">Related Tags:  <span class="tx-danger">*</span> <br> <span style="font-size:12px;"> Separated by Space </span></label>
                        <div class="col-sm-12">
                            <input rows="3" type="text" data-role="tagsinput" class="form-control " placeholder="Related tags" name="ptags"  id="ptags"  required="required" data-type="text" onkeyup="funInputFielTypes(this)">
                             <div style="font-size:10px;color:red;" id="ptagsX"></div>
                        </div>
                    </div>  


                    <div class="form-group">
                        <label class="control-label pl-0 col-sm-3" for="email">Description:  <span class="tx-danger">*</span> <br> </label>
                        <div class="col-sm-12">
                            <textarea rows="3" class="form-control" placeholder="Enter Post Related Description here " name="meta_desc" id="meta_desc" required="required" data-type="sptext" onkeyup="funInputFielTypes(this)"></textarea>
                             <div style="font-size:10px;color:red;" id="meta_descX"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label pl-0 col-sm-3" for="email">Subject:  <span class="tx-danger">*</span> <br> </label>
                        <div class="col-sm-12">
                            <textarea rows="3" class="form-control " placeholder="Enter Post Related Subject here " name="meta_subject" id="meta_subject" required="required" data-type="sptext" onkeyup="funInputFielTypes(this)"></textarea>
                             <div style="font-size:10px;color:red;" id="meta_subjectX"></div>
                        </div>
                    </div>
                    <p id="captImg" style=" position: absolute;margin-left: 250px;"><?php echo $captchaImg; ?></p><br><br><br>
                <p style=" position: absolute;margin-left: 250px;">Can't read the image? click <a href="javascript:void(0);" class="refreshCaptcha">here</a> to refresh.</p>
                <br><br>
               
                  
                  <div class="input-group" class="col-sm-9">
                    <input type="hidden" name="session_captcha" value="<?php echo $this->session->userdata('captchaCode');?>">
                    <input type="text"  class="form-control input-md captcha"  name="captcha" id="captcha" minlength="6" maxlength="6" placeholder="Enter Captcha" data-type="captcha" onkeyup="funInputFielTypes(this)">
					 <div style="font-size:10px;color:red;" id="captchaX"></div>
                 
                </div>
       
            
                </div>
                    
                <span class="error"><?php echo form_error('content');?></span>
                <br>
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
											
											if($label['type']=="file"){
												
												$content.="<div class='form-group' ".$customStyle." id='".$sno."'>";
												$content.="<label class='col-md-5 control-label' for='".$label['label']."'>".$label['label']." <span class='tx-danger'>*</span></label>";  
												$content.="<div class='col-md-6'>";
												$content.="<input id='".$label['id']."' name='".$label['name'].$key."' placeholder='".$label['label']."' class='form-control input-md ".$label['class']." ".$key." csl".$sno."'   type='".$label['type']."' ".$function." ".$dependentFunction." data-type='imfile' onchange='funInputFielTypes(this)'   accept='image/*,application/pdf'>";  
												$content.="<div style='font-size:10px;color:red;' id='".$label['id']."X'></div>";		
												$content.="</div>";		
												$content.="</div>";
												
											}else if($label['label']=="Link URL"){
												
												$content.="<div class='form-group' ".$customStyle." id='".$sno."'>";
												$content.="<label class='col-md-5 control-label' for='".$label['label']."'>".$label['label']." <span class='tx-danger'>*</span></label>";  
												$content.="<div class='col-md-6'>";
												$content.="<input id='".$label['id']."' name='".$label['name'].$key."' placeholder='".$label['label']."' class='form-control input-md ".$label['class']." ".$key." csl".$sno."'   type='".$label['type']."' ".$function." ".$dependentFunction."  data-type='url' onkeyup='funInputFielTypes(this)'>";  
												$content.="<div style='font-size:10px;color:red;' id='".$label['id']."X'></div>";	
												$content.="</div>";		
												$content.="</div>";

											}else{
												
												$content.="<div class='form-group' ".$customStyle." id='".$sno."'>";
												$content.="<label class='col-md-5 control-label' for='".$label['label']."'>".$label['label']." <span class='tx-danger'>*</span></label>";  
												$content.="<div class='col-md-6'>";
												$content.="<input id='".$label['id']."' name='".$label['name'].$key."' placeholder='".$label['label']."' class='form-control input-md ".$label['class']." ".$key." csl".$sno."'   type='".$label['type']."' ".$function." ".$dependentFunction."  data-type='text' onkeyup='funInputFielTypes(this)'>";  
												$content.="<div style='font-size:10px;color:red;' id='".$label['id']."X'></div>";	
												$content.="</div>";		
												$content.="</div>";
											}
										}
										if($label['type']=="select")
										{
											$content.="<div class='form-group' ".$customStyle." id='".$sno."'>";
											$content.="<label class='col-md-5 control-label' for='".$label['label']."'>".$label['label']." <span class='tx-danger'>*</span> </label>";  
											$content.="<div class='col-md-6'>";
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
		<!-- -------------------- forms close here ----------------------------- -->
    <br><br>
    </div>
    
    <div class="col-md-3" style="padding-right: 0px; padding-left: 0px;">
    
        <div class=" " id="accordion">
            
            <div class="card" style="margin-bottom:15px;">
                <div class="card-header" data-toggle="collapse" data-parent=".d-accordion" href="#publish1">
                      <h6 >Publish  </h6>  
                </div>
    
                <div id="publish1" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        <center><input type="submit" name="draft" value="Save to Draft"  class="btn btn-primary btn-sm" onclick="go_draft()" disabled>	
                        <input type="submit" name="save" value="Publish" id="submitBtn" disabled class="btn btn-success btn-sm"></center> 
                    </div>
                </div>
            </div>
    
    
    
            <div class="card" style="margin-bottom:15px;">
                <div class="card-header" data-toggle="collapse" data-parent=".d-accordion" href="#layout">
                    <h6 >Post Attributes  </h6>
                </div>
                
                <div id="layout" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                    
                        <div class="form-group">
                            <label>Select layout</label>
							<select class="form-select" id="sel1" name="layourid">
								<option value="1">Left side bar</option>
								<option value="2">Right side bar</option>
								<option value="3">Two side bars</option>
								<option value="4">Full page</option>
								<option value="5" selected>Default layout</option>
							</select>
                        </div>
                    
                    </div>
                
                    <div class="card-body">
                        <label class="ckbox" style="font-size:13px;">
                            <input type="checkbox" id="target" value="1"><span>Open link in a new window / Tab</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="card">
				<div class="card-header" data-toggle="collapse " data-parent=".d-accordion" href="#categories">
					<h6  <strong> Categories </strong> </h6>
				</div>
				<div id="categories" class="collapse show" data-bs-parent="#accordion">
					<div class="card-body">
						
						<?php $i=1; foreach($categories as $key=>$val){?>
							<label class="ckbox" style="width:100%;">
							    <?php //if($key == '542') { ?>
								<input type="checkbox" value="<?php echo $key; ?>" class="chkcat" name="categories[]" onclick="fun1();"><span><?php echo $val?></span><br>
								<?php  //} ?>
							</label>
							
						<?php $i++;}?>
						
					</div>
				</div>
			</div>
            
        </div>
    </div>       
    </div>
    
    <?php echo form_close();?>
   
    </div>
</div>
    
 
    
    
    
 
    <script>
        $(document).ready(function()
        {
            $( ".datepicker" ).datetimepicker({minDate: new Date(),format:'DD-MM-YYYY HH:mm'});
            
            
            $("#enableDate").click(function()
            {
                var enableDateStatus = $("#enableDateStatus").val();
                var val1 = $("#enableDate").val();
               //alert(val1);
                if(val1 == 'Enable Date'){
                    $("#enableDate").val('Disable Date');
                }else{
                    $("#enableDate").val('Enable Date');
                }
                
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
        /*$('#publish').click(function(){
            //alert();
        	var errors=0;
        	var er = "";
        	$(".mytext1").each(function()
        	{
        	    
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
        	
        
        	if(errors==0)
        	{
        		return true;
        	}
        	else
        	{
        	    	//return false;
        	alert("Please Enter Numbers valid Langitude - "+errors );
             	return false;
        	}
        });*/
    </script>

<script>
function validateForm()
{
    //alert();
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

    <script>
$('#validateForm1').click(function(){
//alert();
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
		
    	
	if(errors==0)
	{
		return true;
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
});
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
	
<script>
    $(document).ready(function(){
        $('.refreshCaptcha').on('click', function(){
            $.get('<?php echo base_url().'CreatePostController/refresh'; ?>', function(data){
                $('#captImg').html(data);
            });
        });
    });


</script>

