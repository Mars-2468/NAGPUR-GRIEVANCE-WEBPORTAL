<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>
<!-- editors--->
<head>
<script src="<?php echo base_url()?>assets/editors/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/editors/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
 <script type = "text/javascript" src = "<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
<script type = "text/javascript">

    var BASE_URL = "<?php echo base_url(); ?>assets/editors2/"; // use your own base url


    tinymce.init({
      selector: "#richTextArea",theme: "modern",width: 1000,height: 500,
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
    $("#createPage").submit();
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
    
    
    
    
    
    
</style>



<body>
    
    
    
    
    <div class="sh-pagebody">
        
        
       <div class="col-md-9">
         
        
        
        
        
        <?php if($this->session->flashdata('message')){?>
    
    <div class="alert alert-success text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
    <div> Page URL : <?php echo $this->session->flashdata('permalink'); ?></div>
    <?php }?>
    
    
          <div class="mypagetitile"> Add News </div>
          
          <hr>
    
    <?php $attributes=array('id'=>'createNews'); echo form_open_multipart('create-news',$attributes)?>
    <input type="hidden" name="is_draft" id="is_draft" value="0">
    <input type="hidden" name="is_custumlink" id="is_custumlink" value="5">
    
   
    
    <div class="form-horizontal">
        
        <div class="form-group">
    <label class="control-label col-sm-3" for="email">Post name: <span class="tx-danger">*</span></label>
    <div class="col-sm-9">
      <input type="text" name="pagename" class="form-control"  onkeyup="fun1(this.value)" >
                    <span class="myerror"> <?php echo form_error('pagename');?></span>
    </div>
  </div>
        
     <div class="form-group">
    <label class="control-label col-sm-3" for="email">Post Title: <span class="tx-danger">*</span></label>
    <div class="col-sm-9">
      <input type="text" name="pagetitle" class="form-control"  onkeyup="fun1(this.value)" >
                    <span class="myerror"> <?php echo form_error('pagetitle');?></span>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="email">From Date: <span class="tx-danger"></span></label>
    <div class="col-sm-9">
      <input type="text" name="fromDate" class="form-control datepicker" >
                    <span class="myerror"> <?php echo form_error('fromDate');?></span>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3" for="email">To Date: <span class="tx-danger"></span></label>
    <div class="col-sm-9">
      <input type="text" name="toDate" class="form-control datepicker">
                    <span class="myerror"> <?php echo form_error('toDate');?></span>
    </div>
  </div>
   
        <div class="form-group">
    <label class="control-label col-sm-3" for="email">Popular Tags:  <span class="tx-danger">*</span> <br> <span style="font-size:12px;"> Separated by comma(,) </span></label>
    <div class="col-sm-9">
      <textarea rows="3" class="form-control" placeholder="Ex (Sports, national , words , poltics)" name="ptags"></textarea>
                    <span class="myerror"> <?php echo form_error('ptags');?></span>
    </div>
  </div>        

    
 
  </div>

  
    

	<br>	<br>
	<div class="">
    <textarea id="richTextArea" name="content" style="width:100%; height:400px;"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>
    
    </div>
    
    <span class="error"><?php echo form_error('content');?></span>
<br>
<center><input type="button" name="draft" value="Save to Draft" class="btn btn-default btn-sm" onclick="go_draft()">	<input type="submit" name="save" value="Publish" class="btn btn-success btn-sm"></center>
	
    



    </div>
    
    
    <div class="col-md-3">
        <div class="catgeory">
            
            <div style="font-weight:bold;">categories</div>
            
            <div class="inner_catgeory">
                
                <?php foreach($categories->result() as $key=>$val){?>
                <label class="ckbox" style="width:100%;">
                    <input type="checkbox" id="postCategories" value="<?php echo $val->category_id;?>" class="chk" name="categories[]"><span><?php echo $val->category_desc;?></span><br>
        			
			    </label>
			    <?php }?>
			    
			    
            </div>
            
            <div>
               <a href="#" >+ add category</a>
            </div>
            
        </div>
    </div>
   
    </div>
    
    
    </div>
    <?php echo form_close();?>
    
    
    
    <!-- date picker-->
<script type="text/javascript" src="<?php echo base_url()?>assets/datepicker/jquery-ui.css"></script>
<!--<script type="text/javascript" src="<?php echo base_url()?>assets/datepicker/jquery.min.js"></script>->

<script type="text/javascript" src="<?php echo base_url()?>assets/datepicker/jquery-ui.js"></script>

<!-- close-->

<script>
    $(function() {
        $( ".datepicker" ).datepicker({dateFormat: 'dd-mm-yy'});
    });
    </script>
    
    
    
   
    