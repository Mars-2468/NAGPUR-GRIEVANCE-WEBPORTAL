
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>


<link href="assets/css/dropzone.min.css" rel="stylesheet">

	<script src="assets/js/dropzone.min.js"></script>
 
   
    
    <script>
	
	/* Demo purposes only */
$(".hover").mouseleave(
  function () {
    $(this).removeClass("hover");
  }
);

	</script>
    
<style>

.overlay {
    left: 11px;
    position: absolute;
    bottom: 38px !important;
    background-color: #000000b0;
    width: 143px;
    transition: .5s ease;
    opacity: 0;
    padding-top: 7px;
    padding-left: 58px;
    padding-bottom: 6px;
}
    
    .dropzone {
        
       min-height: 200px;
padding: 60px 20px 0px 20px;
text-align: center;
border: dashed 3px #C1C3C5;
    }
    
    
    .dropzone::before{
        position: absolute;
top: 9%;
left: 50%;
margin-left: -25px;
content: "";
width: 51px;
height: 33px;
/*background-image: url("https://municipalservices.in/sites/admin/assets/img/icn-upload.png");*/
background-size: 100%;
    }
    
   .mycheckbox {
	cursor: pointer;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	border: 2px solid transparent;
	margin-bottom: 0;
	outline: 0;
	height: 134px;
	width:150px;
}
.mycheckbox input[type="checkbox"] {
	display: none;
}

.mycheckbox-checked {
	border-color: #0866C6;
}
.mycheckbox .fa {
  position: absolute;
  color: #0866C6;
  background-color: #fff;
  padding: 10px;
  top: 0;
  right: 5px;
  font-size: 14px;
}
.mycheckbox-checked .fa {
  display: block !important;
} 

.upload_info{
    min-height: 210px;
    padding-right: 10px;
    padding-top: 10px;
    border: 1px solid #b4782a;
    margin-bottom: 10px;
}


.form-control{
    border-radius:0px !important;
}




</style>



</head>

<body>
   

<div class="sh-pagebody">
    
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success text-center"> 
    <?php echo $this->session->flashdata('message');?>
    </div>
    <?php } ?>

    <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Upload Images</div>
         <div class="card-body ">
    

          
          
              
              <?php $attributes= array('class'=>'dropzone','id'=>'imageUpload'); echo form_open_multipart('UploadMediaController/imageUploadPost',$attributes);?>
              <img src="<?php echo base_url()?>assets/img/icn-upload.png">
              
              <center><h3>Click on box to select multiple files or Drop files here to upload</h3></center>
              
              
              
              
              
              	<?php echo form_close();?>
              	
              	</br>
              	
              <!--	<div class="bulk_btn">
                     <button class="btn btn-default btn-sm" id="bulk_select"><i class="fa fa-check-square"></i> Bulk Selection</button>
              	    
              	    <button style="display:none;" class="btn btn-primary btn-sm" id="delete_select"><i class="fa fa-trash" times></i> Delete Selected</button>
              	    
              	    <button style="display:none;" class="btn btn-default btn-sm " id="cancel_select"><i class="fa fa-times"></i> Cancel Selection</button>
                </div>-->
              <?php echo form_open('UploadMediaController/exportDatatomedialibrary'); ?>
              <div class="row">
              <?php $i=1; foreach($media_data as $key=>$val){?>
              
              <div class="col-md-6">
              	
              	<div class="upload_info">
              	   <div class="col-md-4 media_style" style="position:relative; padding-left: 10px; padding-right: 10px;padding-top: 3px;">
                  <label class="mycheckbox">
               <a class="file-manager-icon">
                 <div style="overflow:hidden;">
                     
                     
                                    <img src="<?php echo $this->session->userdata('base_url').$val['thumbnail_path'];?>"> 
                    
                                                        <input class="inputClassImage" name="image[]" value="281" style="display: none;" type="checkbox">
                                  <!--<i class="fa fa-check hidden"></i>-->
                 </div>
                <h6><?php echo $val['client_name']; ?></h6>
               </a>
               
                </label>
                
                
                <div class="overlay">
                <?php if($val['slide_id'] != ''){   ?>
                    <a onclick="photo_delete_rec(<?php echo $val['slide_id']; ?>)"><i class="fa fa-trash icon_style1" ></i></a>
               <?php }?>
                   
             </div>
             </div>
             <!-- images starts here -->
             
             
                <div class="col-md-8" style="padding-left: 15px; padding-right: 15px;">
                    
                    
                    <div class="row">
                        
                        <div class="col-md-6">
                        
                        <div class="form-group">
                          <label for="usr">Title <span class="tx-danger">*</span></label>
                          <input id="title<?php echo $i; ?>" name="title<?php echo $i; ?>" placeholder="Enter Title here" class="form-control input-md"  type="text" required="required">
                          <input type="hidden" name="slide_id<?php echo $i; ?>" value="<?php echo $val['slide_id']; ?>" >
                        </div>
                        
                        </div>
                        
                        <div class="col-md-6">
                        
                        <div class="form-group">
                          <label for="usr">Alt Text <span class="tx-danger">*</span></label>
                          <input id="alt<?php echo $i; ?>" name="alt<?php echo $i; ?>" placeholder="Enter Alt Text" class="form-control input-md"  type="text" required="required">
                        </div>
                        
                        </div>
   
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="comment">Description <span class="tx-danger">*</span></label>
                              <textarea class="form-control" rows="3" id="desc<?php echo $i; ?>" name="desc<?php echo $i; ?>" required="required"></textarea>
                            </div>
                        </div>
                    </div>
  
                </div>
                
        <!-- images loop close here -->        
              	</div>

         </div>
         <?php $i++; } ?>
         </div>
          
        
              	<br>
              	
              
              	
              	
              	<br>
              	<br>
              	<?php if(count($media_data)){?>
              	<center>
              	    <input type="hidden" name="count" value="<?php echo $i; ?>">
              	    <input type="submit" class="btn btn-success" name="exportdata" value="Upload">
              	    </center>
              	<?php echo form_close(); ?> 
              	<br>
              		<?php } ?>
  
</div>

<input type="hidden" id="bulksection" value="0">	
	
</div>
</div>
</div>
	



<div id="myModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:90%;">

    <!-- Modal content-->
    <div class="modal-content" style="background-color:#FFF;">
      <div class="modal-header" style="border-bottom: 1px #CCC solid;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Attachment Details</h4>
      </div>
      <div class="modal-body">
          
       <div class="col-md-8">
           <div style=" margin:0 auto; min-width: 75%; max-width: 590px;">
         <!--<img src="<?php echo base_url(); ?>assets/img/loading.gif" class="img-responsive" style=" margin:0 auto;" id="model_img">-->
         <img src="https://municipalservices.in/SaidiReddy/admin/assets/img/loading.gif" class="img-responsive" style=" margin:0 auto;" id="cpg_model_img">
         </div>
       </div>
       <div class="col-md-4 ">
           <div class="attachment-info att_detail">
           <div><strong>File name:</strong> <span id="cpg_fname"></span></div>
           <div><strong>File type:</strong> <span id="cpg_ftype"></span></div>
           <div><strong>Uploaded on:</strong> <span id="cpg_timestamp"></span></div>
           <div><strong>File size:</strong> <span id="cpg_fsize"></span></div>
           <div><strong>Dimensions:</strong> <span id="cpg_fdim"></span> </div>
           <input type="hidden" id="cpg_slide_id">
           <hr>

<div class="form-horizontal myform-group">
<div class="form-group">
  <label class="col-md-4 control-label text-right" for="url">URL <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
  <input id="cpg_filepath" name="filepath" placeholder="Enter URL" class="form-control input-md" type="text" readonly>
  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="heading">Slider heading <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
  <input  name="textinput" id="cpg_heading" placeholder="Enter Slider heading" class="form-control input-md" type="text">
  </div>
  <div style="display:none;" id="cpg_err_msg_heading_div"><span style="color:red;padding-left:18px;" id="cpg_err_msg_heading"></span></div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="description">Slider Description <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
   <textarea class="form-control" id="cpg_description" name="textarea" rows="3" placeholder="Enter Description"></textarea>
  
  </div>
  <div style="display:none;" id="cpg_err_msg_description_div"><center><span style="color:red;padding-left:45px;" id="cpg_err_msg_description"></span></center></div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="title">Title <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
  <input  name="textinput" id="cpg_title" placeholder="Enter title" class="form-control input-md" type="text" required="required">
  
  </div>
  <div style="display:none;" id="cpg_err_msg_title_div"><center><span style="color:red;padding-left:8px;" id="cpg_err_msg_title"></span></center></div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label text-right" for="alttext">Alt Text <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
  <input  name="textinput" id="cpg_alttext" placeholder="Enter Alt Text" class="form-control input-md" type="text" required="required">
  
  </div>
  <div style="display:none;" id="cpg_err_msg_alttext_div"><center><span style="color:red;padding-left:18px;" id="cpg_err_msg_alttext"></span></center></div>
</div>



<div class="form-group">
  <label class="col-md-4 control-label text-right" for="status">Status <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
   <select id="cpg_status" name="status" class="form-control">
       
       <option value="">---select---</option>
       <option value="1">Online</option>
       <option value="0">Offline</option>
       
   </select>
  
  </div>
  <div style="display:none;" id="cpg_err_msg_status_div"><center><span style="color:red;padding-left:18px;" id="cpg_err_msg_status"></span></center></div>
</div>

</div>

</div>



       </div>
       
       
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" onclick="photo_getInfo()">Save Changes</button>
      </div>
      
      
      
    </div>

  </div>
</div>


<script>
	// image gallery
// init the state from the input
$(document).ready(function()
{
    $(".mycheckbox").each(function () {
        
  if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
     
    $(this).toggleClass('mycheckbox-checked');
  }
  else {
      
   $(this).removeClass('mycheckbox-checked');
  }
});

// sync the state to the input
$(".mycheckbox").on("click", function (e) {
    var checkbulk=$("#bulksection").val();
    if(checkbulk=='1'){
        $(this).toggleClass('mycheckbox-checked');
        var $checkbox = $(this).find('input[type="checkbox"]');
        $checkbox.prop("checked",!$checkbox.prop("checked"))
    }

  e.preventDefault();
}).change();
});

</script>

<script type="text/javascript">
    //$(".mycheckbox").removeClass('mycheckbox-checked');
    $(".inputClassImage").hide();
    
    
    window.onload = function() {
    Dropzone.options.imageUpload = {

        maxFilesize:30,

        acceptedFiles: ".jpg,.png,.jpeg",
        
        
       success: function(){
           setInterval(doSomething, 1000);
    }
    };
};
    
	
    
    function doSomething() {
        // alert('Your image uploaded successfully');
        location.reload();
    }
   
    $("#bulk_select").on("click",function(){
        $("#bulksection").val('1');
        $(".inputClassImage").prop('checked',false);
        $("#delete_select").show();
        $("#cancel_select").show();
        $("#bulk_select").hide();
    });
    $("#cancel_select").on("click",function(){
        
        $("#bulksection").val('0');
        $(".mycheckbox").removeClass('mycheckbox-checked');
        $("#delete_select").hide();
        $("#cancel_select").hide();
        $("#bulk_select").show();
       
    });
    $("#delete_select").on("click",function(){
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        //alert("Delete Clicked");
        var check_val = [];
        $(':checkbox:checked').each(function(i){
          check_val[i] = $(this).val();
        });
        //alert(check_val);
        var len = check_val.length;
        //alert(len);
        if(len>0){
            if(confirm('Are sure you want to delete this record')){
                for(var i=0;i<len;i++){
                    var slide_id = check_val[i];
                    $.post('CreateMediaController/deleteContent',{slide_id:slide_id,'csrf_test_name': csrf_value},function(data){
                        if(data==1){
                            // alert('Deleted successfully');
                            // location.reload();
                        }else{
                            // alert('unable to delete, try again');
                        }
                    });
                }
                alert('Deleted Successfully');
            }    
            $(".mycheckbox").removeClass('mycheckbox-checked');
            $("#bulksection").val('0');
            $("#delete_select").hide();
            $("#cancel_select").hide();
            $("#bulk_select").show();
            location.reload();
        }else{
            alert("Please Select alteast One Image");
        }
    });
    function photo_edit_rec(slide_id){
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        $("#cpg_model_img").attr('src','<?php echo base_url(); ?>assets/img/loading.gif');
        $("#cpg_err_msg_heading_div").hide();
        $("#cpg_err_msg_heading").html('');
        $("#cpg_err_msg_description_div").hide();
        $("#cpg_err_msg_description").html('');
        $("#cpg_err_msg_title_div").hide();
        $("#cpg_err_msg_title").html('');
        $("#cpg_err_msg_alttext_div").hide();
        $("#cpg_err_msg_alttext").html('');
        $("#cpg_err_msg_status_div").hide();
        $("#cpg_err_msg_status").html('');
        
        $.post('CreateMediaController/getContent',{slide_id:slide_id,'csrf_test_name': csrf_value},function(data){
                //alert(data);
            var obj = JSON.parse(data);
            
            $("#cpg_slide_id").val(obj[0].slide_id);
            $("#cpg_fname").text(obj[0].file_type);
            $("#cpg_ftype").text(obj[0].image_type);
            $("#cpg_timestamp").text(obj[0].ts);
            $("#cpg_fsize").text(obj[0].file_size);
            $("#cpg_fdim").text(obj[0].image_width + " X " +obj[0].image_height);
            $("#cpg_heading").val(obj[0].heading);
            $("#cpg_title").val(obj[0].title);
            $("#cpg_alttext").val(obj[0].alttext);
            $("#cpg_description").val(obj[0].description);
            $("#cpg_status").val(obj[0].status);
            $("#cpg_filepath").val(obj[0].image_path);
            
            if(obj[0].is_image !='1') {
                $("#cpg_model_img").attr('src','..'+obj[0].thumbnail_path);
            }else{
                $("#cpg_model_img").attr('src','..'+obj[0].folder_path);
            }
        });
    }
    
    
    
    function photo_delete_rec(slide_id){
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
       if(confirm('Are sure you want to delete this record')) {
            //alert(slide_id); 
            $.post('UploadMediaController/deleteContent',{slide_id:slide_id,'csrf_test_name': csrf_value},function(data){
                
                if(data=='1'){
                    alert('Deleted successfully');
                    location.reload();
                }else{
                    alert('unable to delete, try again');
                }
                
            });
        }
    }
    
    
    $("#cpg_heading").keyup(function(){
        var heading=$("#cpg_heading").val();
        if(heading =='')
        {
            $("#cpg_err_msg_heading_div").show();
            $("#cpg_err_msg_heading").html('Heading is Required');
            return false;
        }else{
            $("#cpg_err_msg_heading_div").hide();
            $("#cpg_err_msg_heading").html('');
        }
    });
    $("#cpg_description").keyup(function(){
        var description=$("#cpg_description").val();
        if(description =='')
        {
            $("#cpg_err_msg_description_div").show();
            $("#cpg_err_msg_description").html('Description is Required');
            return false;
        }else{
            $("#cpg_err_msg_description_div").hide();
            $("#cpg_err_msg_description").html('');
        }
    });
    $("#cpg_title").keyup(function(){
        var title=$("#cpg_title").val();
        if(title =='')
        {
            $("#cpg_err_msg_title_div").show();
            $("#cpg_err_msg_title").html('Title is Required');
            return false;
        }else{
            $("#cpg_err_msg_title_div").hide();
            $("#cpg_err_msg_title").html('');
        }
    });
    $("#cpg_alttext").keyup(function(){
        var alttext=$("#cpg_alttext").val();
        if(alttext =='')
        {
            $("#cpg_err_msg_alttext_div").show();
            $("#cpg_err_msg_alttext").html('Alt text is Required');
            return false;
        }else{
            $("#cpg_err_msg_alttext_div").hide();
            $("#cpg_err_msg_alttext").html('');
        }
    });
    $("#cpg_status").change(function(){
        var status=$("#cpg_status").val();
        if(status =='')
        {
            $("#cpg_err_msg_status_div").show();
            $("#cpg_err_msg_status").html('Status is Required');
            return false;
        }else{
            $("#cpg_err_msg_status_div").hide();
            $("#cpg_err_msg_status").html('');
        }
    });
    
    
    function photo_getInfo(){
        
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var slide_id=$("#cpg_slide_id").val();
        var heading = $("#cpg_heading").val();
        var description = $("#cpg_description").val();
        var title = $("#cpg_title").val();
        
        var alttext = $("#cpg_alttext").val();
        var status = $("#cpg_status").val();
        //alert(slide_id);
        
        if(heading == '' && description == '' && title == '' && alttext == ''){
            $("#cpg_err_msg_heading_div").show();
            $("#cpg_err_msg_heading").html('Heading is Required');
            $("#cpg_err_msg_description_div").show();
            $("#cpg_err_msg_description").html('Description is Required');
            $("#cpg_err_msg_title_div").show();
            $("#cpg_err_msg_title").html('Title is Required');
            $("#cpg_err_msg_alttext_div").show();
            $("#cpg_err_msg_alttext").html('Alt text is Required');
            return false;
        }
        if(heading == ''){
            $("#cpg_err_msg_heading_div").show();
            $("#cpg_err_msg_heading").html('Heading is Required');
            return false;
        }
        if(description == ''){
            $("#cpg_err_msg_description_div").show();
            $("#cpg_err_msg_description").html('Description is Required');
            return false;
        }
        if(title == ''){
            $("#cpg_err_msg_title_div").show();
            $("#cpg_err_msg_title").html('Title is Required');
            return false;
        }
        if(alttext == ''){
            $("#cpg_err_msg_alttext_div").show();
            $("#cpg_err_msg_alttext").html('Alt text is Required');
            return false;
        }
        if(status == ''){
            $("#cpg_err_msg_status_div").show();
            $("#cpg_err_msg_status").html('Status is Required');
            return false;
        }
         $.post('CreateMediaController/updateImgInfo',{slide_id:slide_id,heading:heading,description:description,title:title,alttext:alttext,status:status,'csrf_test_name': csrf_value},function(data){
                //alert(data);
                if(data=='true'){
                    alert('Updated successfully');
                    location.reload();
                    
                }else{
                    alert('Unable to update');
                }
            });
       
    }

</script>







