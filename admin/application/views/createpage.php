<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>


<head>

    <!--<script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script>

    <script  src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script> -->
    <!--<script type="text/javascript" src="https://egovindia.in/TSFC/dynamic/admin/assets/editors2/tinymce.min-5.10.2.js "></script>-->
    <!-- <script type="text/javascript"src="https://cdn.tiny.cloud/1/o18hvsjrdz2ygt5yj2furkpyuz6mfuvrop05uu4eetaxk3cg/tinymce/5/tinymce.min.js "></script> -->

    <script src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>
    <script  src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
    <script src = "<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
    <script  src = "<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>

    <script>
        // tinymce.init({
        //     selector: 'textarea#default',
        //     plugins: [
        //         'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        //         'tinymcespellchecker code table'
        //     ],
        //     toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | print preview code ",
        //     menubar: "file edit insert view format table tools help"

        // });

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
            selector: "#richTextArea",
            theme: "modern",
            width: 710,
            height: 500,

            theme: "modern",
            // width: 680,
            // height: 200,
            relative_urls: true,
            //remove_script_host: true,
            // document_base_url: BASE_URL,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager code autolink"
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
    $(document).ready(function() {
        $("#inputTextBox").keypress(function(event) {
            var inputValue = event.charCode;
            if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
                event.preventDefault();
            }
        });


    });
    </script>



    <style>
    #mceu_47 #mceu_22 {
        display: none;
    }

    #mceu_43 {
        display: none;
    }

    #mceu_17 {
        display: none;
    }

    #mceu_34 {
        display: none;
    }

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


    .bootstrap-tagsinput .label {
        font-size: 13px;
        font-weight: normal;
    }

    .bootstrap-tagsinput .tag [data-role="remove"] {

        opacity: 1;
    }

    .bootstrap-tagsinput .tag [data-role="remove"]::after {

        font-family: arial;
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



    .icon {
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
        padding-left: 60px;
        padding-bottom: 49px;
        text-align: center;
    }

    .thumb_bor {
        border: 0px #ccc solid;
    }

    .thumb_bor1 {
        border: 1px #00c1ff solid;
        position: relative;
    }

    .form-control {
        border-radius: 0px;
    }
    </style>


    <script>
    $(document).ready(function() {

        $(".snip1550").click(function() {
            $(".thumb_bor").toggleClass("thumb_bor1");
        });

    });
    </script>


</head>

<body>




    <div class="sh-pagebody">


        <div class="row">

            <div class="col-md-9" style="padding-left: 0px;">


                <?php if($this->session->flashdata('error_message')){?>

                <div class="alert alert-danger text-center"> <strong>
                        <?php echo $this->session->flashdata('error_message');?> </strong></div>

              
                <?php }?>
				
				
                <?php if($this->session->flashdata('message')){?>

                <div class="alert alert-success text-center"> <strong>
                        <?php echo $this->session->flashdata('message');?> </strong></div>

                <div> Page URL : <?php echo $this->session->flashdata('permalink'); ?></div>
                <?php }?>




                <?php $attributes=array('id'=>'createPage','onsubmit'=>'return validateForm()');  echo form_open_multipart('CreatepageController/addPageRecord',$attributes)?>
                <input type="hidden" name="is_draft" id="is_draft" value="0">
                <input type="hidden" name="is_custumlink" id="is_custumlink" value="0">
				  <!-- CSRF Token -->
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
   
				<!-- custom one-time nonce -->
				<input type="hidden" name="form_nonce" value="<?= $form_nonce; ?>">
	
                <div class="card bd-primary ">

                    <div class="card-header bg-primary tx-white">Add New Page </div>

                    <div class="card-body pd-sm-30">


                        <div class="form-horizontal">

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Page name: <span
                                        class="tx-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="pagename" class="form-control" 
                                        required="required" id="pagename" data-type="text" onkeyup="funInputFielTypes(this)">
                                    <div style="font-size:10px;color:red;" id="pagenameX"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Page Title: <span
                                        class="tx-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="pagetitle" id="pagetitle" class="form-control " data-type="text" onkeyup="funInputFielTypes(this)"
                                        required="required">
                                    <div style="font-size:10px;color:red;" id="pagetitleX"></div>
                                </div>
                            </div>


                            <div>
                                <a class="btn btn-secondary btn-sm text-white" data-bs-toggle="modal"
                                    onclick="media()"><i class="fa fa-image"></i> Add Media </a>
                            </div>



                        </div>




                        <br>
                        <!--<div class="">-->
                        <!--   <textarea id="richTextArea" name="content" style="width:100%; height:400px;"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>-->

                        <!--   </div>-->
                        <div class="">
                            <textarea id="content" name="content"
                                style="width:100%; height:400px;" data-type="sptext" onkeyup="funInputFielTypes(this)"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>
						 <div style="font-size:10px;color:red;" id="contentX"></div>
                        </div>

                        <br><br>
                        <div class="form-horizontal">

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Hover title:<span
                                        class="tx-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control " placeholder="Hover title"
                                        name="hover_title" id="hover_title" data-type="text" onkeyup="funInputFielTypes(this)">
                                    <div style="font-size:10px;color:red;" id="hover_titleX"></div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Related Tags: <span
                                        class="tx-danger">*</span> <br> <span style="font-size:12px;"> Separated by
                                        Space </span></label>
                                <div class="col-sm-12">

                                    <input rows="3" type="text" data-role="tagsinput" class="form-control "
                                        placeholder="Related tags" name="ptags" id="ptags" data-type="text" onkeyup="funInputFielTypes(this)">
                                   <div style="font-size:10px;color:red;" id="ptagsX"></div>

                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Description: <span
                                        class="tx-danger">*</span> <br> </label>
                                <div class="col-sm-12">
                                    <textarea rows="3" class="form-control"
                                        placeholder="Enter Page Related Description here " name="meta_desc" id="meta_desc" data-type="sptext" onkeyup="funInputFielTypes(this)"></textarea>
                                    <div style="font-size:10px;color:red;" id="meta_descX"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Subject: <span
                                        class="tx-danger">*</span> <br> </label>
                                <div class="col-sm-12">
                                    <textarea rows="3" class="form-control "
                                        placeholder="Enter Page Related Subject here " name="meta_subject" id="meta_subject" data-type="sptext" onkeyup="funInputFielTypes(this)"></textarea>
                                    <div style="font-size:10px;color:red;" id="meta_subjectX"></div>
                                </div>
                            </div>

                            <p id="captImg" style=" position: absolute;margin-left: 250px;"><?php echo $captchaImg; ?>
                            </p><br><br><br>
                            <p style=" position: absolute;margin-left: 250px;">Can't read the image? click <a
                                    href="javascript:void(0);" class="refreshCaptcha">here</a> to refresh.</p>
                            <br><br>


                            <div class="form-group" class="col-sm-9">
                            <input type="hidden" name="session_captcha" value="<?php echo $this->session->userdata('captchaCode');?>">
                                <input type="text" class="form-control input-md captcha" minlength="6" maxlength="6" name="captcha" id="captcha"
                                    placeholder="Enter Captcha" data-type="captcha" onkeyup="funInputFielTypes(this)" />
									
									<div style="font-size:10px;color:red;" id="captchaX"></div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3" style="padding-right: 0px; padding-left: 0px;">

                <div class=" " id="accordion">


                    <div class="card" style="margin-bottom:15px;" >
                        <div class="card-header" data-toggle="collapse" data-parent=".d-accordion" href="#publish">
                            <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                                <h6> Publish </h6>
                            </a>
                        </div>

                        <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                            <div class="card-body">
                                <center><input type="submit" name="draft" value="Save to Draft"
                                        class="btn btn-primary btn-sm" onclick="go_draft()" disabled>
										
                                    <input type="submit" name="save" value="Publish" id="submitBtn"
                                        class="btn btn-success btn-sm" disabled>
										
                                </center>
                            </div>


                        </div>
                    </div>



                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-parent=".d-accordion" href="#aboutus">
                            <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                                <h6>Page Attributes </h6>
                            </a>
                        </div>
                        <div id="aboutus" class="collapse show" data-bs-parent="#accordion">

                            <div class="card-body">

                                <div class="form-group">
                                    <label>Select layout</label>
                                    <select class="form-select" id="sel1" name="layourid">
                                        <?php $string=""; foreach($layoutlists as $key=>$val){if($key=='4'){$string="selected";}else{$string="";}?>
                                        <option value="<?php echo $key; ?>" <?php echo $string; ?>><?php echo $val; ?>
                                        </option>

                                        <?php } ?>
                                    </select>
                                </div>

                            </div>


                            <div class="card-body">
                                <label class="ckbox" style="font-size:13px;">
                                    <input type="checkbox" id="target" value="1"><span>Open link in a new window /
                                        Tab</span>
                                </label>
                            </div>

                        </div>

                    </div>


                </div>

            </div>
        </div>

        <span class="error"><?php echo form_error('content');?></span>
        <br>


        <?php echo form_close();?>
    </div>
    </div>



    <script language='javascript'>
    $('#publish').click(function() {
        //alert();
        var errors = 0;
        var er = "";
        $(".mytext1").each(function() {

            var val_field = $(this).val();
            if (val_field == "") {
                ($(this)).css({
                    "background-color": "pink"
                });
                errors++;
                er += 'Name, ';
            } else {
                ($(this)).css({
                    "background-color": "white"
                });
            }
        });


        if (errors == 0) {
            return true;
        } else {
            //return false;
            alert("Please Enter Numbers valid Langitude - " + errors);
            return false;
        }
    });
    // function media(){
    //     //alert('clixk');
    //     $("#slide_id").val('');
    //     $("#fname").text('');
    //     $("#ftype").text('');
    //     $("#timestamp").text('');
    //     $("#fsize").text('');
    //     $("#fdim").text('');
    //     $("#heading").val('');
    //     $("#title").val('');
    //     $("#alttext").val('');
    //     $("#description").val('');
    //     $("#status").val('');
    //     $("#filepath").val('');
    // }
    </script>
    <script>
    function go_draft() {

        $("#is_draft").val('1');
        $("#category_form").find('[type="submit"]').trigger('click');
        //$("#category_form").find('[type="button"]').trigger('click');
        //$("#category_form").submit();
    }
    </script>
    <script>
	const isValidText = /^[A-Za-z0-9\s-_]+$/;
	const isValidDesc = /^[a-zA-Z0-9.,!?()'"\s-]+$/;
	const allowedPattern = /^[a-zA-Z0-9<>\/\s="':.-]+$/; // Allows basic characters and tags
    const allowedTags = /<\/?(b|i|u|a)(\s+[^>]*)?>/gi; // Allow only <b>, <i>, <u>, <a>

	
    function pageName() {
		
		$("#pagename").each(function() {

            var field_val = $(this).val();
			
            if (!isValidText.test(field_val)) {
                alert('Invalid name!');
				$(this).val('');
                return false;
            } 
			
        });
	}
	
	function pageTitle() {
		
		$("#pagetitle").each(function() {

            var field_val = $(this).val();
			
            if (!isValidText.test(field_val)) {
                alert('Invalid title!');
				$(this).val('');
                return false;
            } 
			
        });
	}	
	
	function hoverTitle() {
		
		$("#hovertitle").each(function() {

            var field_val = $(this).val();
			
            if (!isValidText.test(field_val)) {
                alert('Invalid title!');
				$(this).val('');
                return false;
            } 
			
        });
	}	
	function descriptionText() {
		
		$("#descriptiontext").each(function() {

            var field_val = $(this).val();
			
            if (!isValidDesc.test(field_val)) {
                alert('Invalid description!');
				$(this).val('');
                return false;
            } 
			
        });
	}
	
	function subjectText() {
		
		$("#subjecttext").each(function() {

            var field_val = $(this).val();
			
            if (!isValidText.test(field_val)) {
                alert('Invalid subject!');
				$(this).val('');
                return false;
            } 
			
        });
	}	
	function relatedTags1() {
		
		$("#relatedtags").each(function() {

            var field_val = $(this).val();
			
            if (!allowedPattern.test(field_val)) {
                alert('Invalid related tag!');
				$(this).val('');
                return false;
            } 
			
        });
	}
	
	


	
    function validateForm() {
        //alert();
        errors = 0;

        $(".mytext").each(function() {

            var val_field = $(this).val();
            if (val_field == '') {
                ($(this)).css({
                    "background-color": "pink"
                });
                errors++;
            } else {
                ($(this)).css({
                    "background-color": "white"
                });
            }
        });



        $(".dropdown").each(function() {

            var val_field = $(this).val();
            if (val_field == '0') {
                ($(this)).css({
                    "background-color": "pink"
                });
                errors++;
            } else {
                ($(this)).css({
                    "background-color": "white"
                });
            }
        });


        if (errors == 0) {
            return true;
        } else {
            alert("Please Enter Correct Value in High-lighted Fields - " + errors);
            return false;
        }
    }
    </script>

    <script>
    $('#validateForm1').click(function() {
        //alert();
        errors = 0;

        $(".mytext").each(function() {

            var val_field = $(this).val();
            if (val_field == '') {
                ($(this)).css({
                    "background-color": "pink"
                });
                errors++;
            } else {
                ($(this)).css({
                    "background-color": "white"
                });
            }
        });



        $(".dropdown").each(function() {

            var val_field = $(this).val();
            if (val_field == '0') {
                ($(this)).css({
                    "background-color": "pink"
                });
                errors++;
            } else {
                ($(this)).css({
                    "background-color": "white"
                });
            }
        });


        if (errors == 0) {
            return true;
        } else {
            alert("Please Enter Correct Value in High-lighted Fields - " + errors);
            return false;
        }
    });
    </script>


    <script>
    $(document).ready(function() {
        $('.refreshCaptcha').on('click', function() {
            $.get('<?php echo base_url().'CreatepageController/refresh'; ?>', function(data) {
                $('#captImg').html(data);
            });
        });
    });
    </script>