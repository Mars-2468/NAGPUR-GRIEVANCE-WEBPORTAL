<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>
<head>
  <script src="<?php echo base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>assets/editors/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/editors/jquery-1.11.3.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url() ?>assets/editors2/tinymce.min-5.10.2.js"></script>-->
<!-- <script type="text/javascript" src="https://cdn.tiny.cloud/1/o18hvsjrdz2ygt5yj2furkpyuz6mfuvrop05uu4eetaxk3cg/tinymce/5/tinymce.min.js "></script> -->
   
    
<script src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>
<script  src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
<script src = "<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
<script  src = "<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
  
<script type = "text/javascript">

    // tinymce.init({
    //     selector: 'textarea#default',
    //     plugins: [
    //     'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    //     'tinymcespellchecker code table'],
    //     toolbar: "code",
    //     menubar: "file edit insert view format table tools help"

    // });

    tinymce.init({
		// selector: "textarea#default",theme: "modern",width: 850,height: 500,
        selector: "textarea#default",theme: "modern",height: 500,
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
           
    var BASE_URL = "<?php echo base_url(); ?>assets/editors2/"; // use your own base url


    tinymce.init({
      selector: "#richTextArea",theme: "modern",width: 950,height: 500,
        theme: "modern",
        // width: 680,
       // height: 200,
        relative_urls: true,
        remove_script_host: false,
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
        external_plugins: {"filemanager": BASE_URL + "filemanager/plugin.min.js"}*/
        
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

 

<style>
    #mceu_34{display:none;}
    
    
    
    
    
    
</style>

</head>

<body>
    
    <hr>
    
    <!--<div>-->
    <!--    <a class="btn btn-default" data-toggle="modal"  onclick="media()" ><i class="fa fa-image"></i> Add Media </a>-->
    <!--</div>-->
    <br>
    
    <div class="card bd-teal ">
        <div class="card-header bg-teal tx-white">Text widget</div>
        <div class="card-body pd-sm-10">
        
            <div>
            
                <?php if($this->session->flashdata('message')){?>
            
                    <div class="alert alert-success text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
                    <div> Page URL : <?php echo $this->session->flashdata('permalink'); ?></div>
                <?php }?>
            
            
                <div class="mypagetitile"> </div>
                <?php $attributes=array('id'=>'createPage','class'=>'form-horizontal'); echo form_open_multipart('CreateWidgetController/saveTextwidget',$attributes)?>
                
                   
                        
                <input type="hidden" name="widgettype"  id="widgettype" value="<?php echo $widgetdet['widget_type']; ?>">
                <input type="hidden" name="widgetname" id="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">
                
                <div class="">
                    <!--<textarea id="richTextArea" name="content" style="width:100%; height:400px;"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>-->
                
                </div>
                <div class="">
                    <textarea id="default" name="content" style="width:100%; height:400px;"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>
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
                <span class="error"><?php echo form_error('content');?></span>
                <br>
                <center><input type="submit" name="save" value="Create" class="btn btn-success btn-sm"></center>
                
                <?php echo form_close();?>
            </div>
        
        </div>
     </div>

    
<script>
    
    $("#checkAll").change(function(){
        //alert('check All');
        //$(".checkbox").prop('checked', $(this).prop("checked"));
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    
   
</script>    
    
    
    