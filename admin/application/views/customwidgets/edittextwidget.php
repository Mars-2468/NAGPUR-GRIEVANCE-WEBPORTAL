<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',1);


?>
<head>
    <script src="<?php echo base_url()?>assets/editors/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/editors/jquery-1.11.3.js"></script>
    <!--<script type="text/javascript" src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>-->
    <script src="assets/editors/bootstrap.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>-->
    <!--<script type="text/javascript" src="https://egovindia.in/TSFC/dynamic/admin/assets/editors2/tinymce.min-5.10.2.js"></script>-->
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/o18hvsjrdz2ygt5yj2furkpyuz6mfuvrop05uu4eetaxk3cg/tinymce/5/tinymce.min.js "></script>
    
    
    
    <script type = "text/javascript">
    
            tinymce.init({
              selector: 'textarea#default',
              plugins: [
               'advlist autolink lists link image charmap print preview hr anchor pagebreak',
               'tinymcespellchecker code table'],
              toolbar: "code",
              menubar: "file edit insert view format table tools help"
 
           });
      
       // var BASE_URL = "<?php echo base_url(); ?>assets/editors2/"; // use your own base url
    
    
        tinymce.init({
          selector: "#richTextArea",theme: "modern",width: 1000,height: 500,
            theme: "modern",
            // width: 680,
           // height: 200,
            relative_urls: true,
            //remove_script_host: false,
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
            $('.checkbox1:checked').each(function(i){
              check_val[i] = $(this).val();
            });
            //alert(check_val);
            var len = check_val.length;
            
            if(len == 0){
                //$("#buttonDiv").hide();
                $("#UlbCheckValidationError").show();
        	 	$("#UlbCheckValidationSpan").html('Please Select Atleast One ULB');
        	 	errors++;
            }else{
                $("#buttonDiv").show();
                $("#UlbCheckValidationError").hide();
        	 	$("#UlbCheckValidationSpan").html('');
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
     
    <style>
        #mceu_34{display:none;}
    </style>

</head>

<body>
    
    <?php //print_r($result); exit;?>
    
    
    <div class="sh-pagebody">
        <div class="card bd-primary ">
            <div class="card-header bg-primary tx-white">Text Widget</div>
            <div class="card-body ">
            
                <?php if($this->session->flashdata('message')){?>
                    <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
                    <div> Page URL : <?php echo $this->session->flashdata('permalink'); ?></div>
                <?php }?>
                
                <div class="mypagetitile">  </div>
                
                <!--<?php //$attributes=array('id'=>'createPage','class'=>'form-horizontal'); echo form_open_multipart('ViewWidgetsController/editTextwidget',$attributes)?>-->
                <?php $attributes=array('onsubmit'=>'return validateForm();'); echo form_open_multipart('ViewWidgetsController/editTextwidget',$attributes)?>
                <input type="hidden" name="widget_type" value="<?php echo $result['widgetName'][0]['widget_type']; ?>">
                <input type="hidden" name="widget_id" value="<?php echo $result['widgetName'][0]['widget_id']; ?>">
                 <input type="hidden" name="widget_type_style" value="<?php echo $result['widgetName'][0]['widget_type_style']; ?>">
                
                <div>
                    <br>

                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Widget Name :</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="widget_name" id="widgetname" onkeyup="widgetNameValidation()" value="<?php echo $result['widgetName'][0]['widget_name']; ?>" <?php if(($this->session->userdata('user_type')) != 'A'){ echo 'readonly'; }?>>
                            </div>
                        </div>
                    </div>   
                </div>
                <div id="widgetNameValidationError" style="display:none;" class="alert alert-danger">
                   <center><span id="widgetNameValidationSpan"></span></center>
                </div>
                <div>
                    <a class="btn btn-default" data-toggle="modal"  onclick="media()" ><i class="fa fa-image"></i> Add Media </a>
                </div>
                
                <br>
                
                <div class="">
                    <input type="hidden" name="currentpage" id="currentpage" value="<?php echo basename(__FILE__); ?>">
                    <!--<textarea id="richTextArea" name="content" style="width:100%; height:400px;"><?php echo str_replace('/assets','../../../assets',$result['widgetContent']['content']); ?></textarea>-->
                    
                </div>
                <div class="">
                 <textarea id="default" name="content" style="width:100%; height:400px;"><?php if($result['widgetContent']['content'] !=''){echo  $result['widgetContent']['content'];} ?></textarea>
              </div>
                
                <?php 
                    if(($this->session->userdata('user_type')) == 'A'){
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
                    
                    <input type="hidden" class="form-control" name="ulb_check_list[]" value="300" />
                    <br>
                    <div class="row" style="margin: auto;padding: 11px;background-color: #f0ece2;">
                        <div class="col-md-3">
                            <label class="rdiobox" style="width:100%;">
                                <input class="" type="radio" value="edit" name="radio" id="radio1" onclick="radioUlbNameCheckFun();"> <span>Edit</span>
                            </label>
                        </div>
                        <!--<div class="col-md-3">
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
                        </div>-->
                    </div>
                </div>
                <?php } ?>
                
                <span class="error"><?php echo form_error('content');?></span>
                <br>
                <div id="buttonDiv">
                    <center><input type="submit" name="save" value="Update" class="btn btn-success btn-sm"></center>
                </div>	
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <!--</div>-->
<script>
    function widgetNameValidation(){
        //alert("Widget");
        var widgetName = $("#widgetname").val();
        //alert(widgetName);
        if(widgetName == ''){
            //$("#buttonDiv").hide();
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
                    //$("#buttonDiv").hide();
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
        //alert('radio');
        var check_val = [];
        $('.checkbox1:checked').each(function(i){
          check_val[i] = $(this).val();
        });
        var len = check_val.length;
        //alert(len);
        var count = <?php echo $ulblist; ?>;
        
        if(len == count){
            $("#checkAll").prop('checked', true);
        }else{
            $("#checkAll").prop('checked', false);
        }
      /*  if(count >= len){
            $("#checkAll").prop('checked', true);
        }else{
            $("#checkAll").prop('checked', false);
        }*/
        
        
        if(len == 0){
            //$("#buttonDiv").hide();
            $("#UlbCheckValidationError").show();
    	 	$("#UlbCheckValidationSpan").html('Please Select Atleast One ULB');
    	 	return false;
        }
        else{
            $("#buttonDiv").show();
            $("#UlbCheckValidationError").hide();
    	 	$("#UlbCheckValidationSpan").html('');
        }
    }
</script>    
    
    
    
    
    