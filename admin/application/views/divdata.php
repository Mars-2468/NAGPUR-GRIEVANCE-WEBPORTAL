 

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

?>

<style>
.dropzone{
     border: 2px dashed rgba(0,0,0,0.3);
}


    .image-checkbox {
	cursor: pointer;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	border: 2px solid transparent;
	margin-bottom: 0;
	outline: 0;
	height: 134px;
	width:134px;
}
.image-checkbox input[type="checkbox"] {
	display: none;
}

.image-checkbox-checked {
	border-color: #0866C6;
}
.image-checkbox .fa {
  position: absolute;
  color: #0866C6;
  background-color: #fff;
  padding: 10px;
  top: 0;
  right: 5px;
  font-size: 14px;
}
.image-checkbox-checked .fa {
  display: block !important;
}

.row-xs > div{
    padding-top:5px !important;
}


</style>

<body>
     <!-------modal start----------->
    <div id="myModal" class="modal fade" >
      <div class="modal-dialog modal-xl">
    
        <!-- Modal content-->
        <div class="modal-content" style="background-color:#FFF;">
            <div class="modal-header" style="border-bottom: 1px #CCC solid;">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                <h4 class="modal-title">Attachment Details</h4>
            </div>
            <div class="modal-body">
                
                <div class="row">
                
                    <input type="hidden" id="photogallery_album_id" name="photogallery_album_id" value="" />
                
                    <div class="col-md-8" style="overflow-y: scroll;height: 492px;">
                        
                        <div class="row">
                            <?php  foreach($create_media_data as $key=>$val ){?>
                       
                              <div class="col-3" >
                                  <label class="image-checkbox">
                               <a class="file-manager-icon" onclick="edit_rec(<?php echo $val['slide_id']; ?>)">
                               <!--<a class="file-manager-icon" >-->
                                 <div class="thumbnail img_height" style="overflow:hidden; ">
                                    <img src="<?php  echo $this->session->userdata('base_url').$val['thumbnail_path']?>" />
                                    <input type="checkbox" class="checkboxImageSlide" name="image[]" value="<?php echo $val['slide_id']; ?>" id="id_<?php echo $val['slide_id']; ?>" />
                                     <i class="fa fa-check hidden"></i>
                                    
                                 </div>
                                 
                               </a>
                               </label>
                             </div>
                      
                      
                      
                      
                      
                          <!-- col- -->
                         <?php } ?> 
                        </div>
                        
                        
                    </div>
                
                
                
                    <div class="col-md-4" style="padding-right:0px;">
                       <div class="attachment-info att_detail">
                           <div style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><strong>File name:</strong> <span id="fname"></span></div>
                           <div><strong>File type:</strong> <span id="ftype"></span></div>
                           <div><strong>Uploaded on:</strong> <span id="timestamp"></span></div>
                           <div><strong>File size:</strong> <span id="fsize"></span></div>
                           <div><strong>Dimensions:</strong> <span id="fdim"></span> </div>
                           <input type='hidden' id="is_image">
                           <input type="hidden" id="slide_id">
                           <hr>
        
                            <div class="form-horizontal myform-group">
                                <div class="form-group">
                                <div class="row">
                                  <label class="col-md-4 control-label text-right col-pad" for="url">URL <span class="tx-danger">*</span></label>  
                                  <div class="col-md-8">
                                  <input id="filepath" name="filepath" placeholder="Enter URL" class="form-control input-md" type="text" readonly value="">
                                  <input type="hidden" id="burl" value="">
                                  </div>
                                 </div>
                                </div>
                            
                                <div class="form-group">
                                <div class="row">
                                  <label class="col-md-4 control-label text-right col-pad" for="description"> Description <span class="tx-danger">*</span></label>  
                                  <div class="col-md-8">
                                   <textarea class="form-control" id="description" name="textarea" rows="3" placeholder="Enter Description"></textarea>
                                  
                                  </div>
                                  <div style="display:none;" id="err_msg_description_div"><center><span style="color:red;padding-left:45px;" id="err_msg_description"></span></center></div>
                                 </div>
                                </div>
                            
                                <div class="form-group"> 
                                <div class="row">
                                  <label class="col-md-4 control-label text-right col-pad" for="title">Title <span class="tx-danger">*</span></label>  
                                  <div class="col-md-8">
                                  <input  name="textinput" id="title" placeholder="Enter title" class="form-control input-md" type="text">
                                  
                                  </div>
                                  <div style="display:none;" id="err_msg_title_div"><center><span style="color:red;padding-left:8px;" id="err_msg_title"></span></center></div>
                                  </div>
                                </div>
                            
                            
                                <div class="form-group">
                                    <div class="row">
                                  <label class="col-md-4 control-label text-right col-pad" for="alttext">Alt Text <span class="tx-danger">*</span></label>  
                                  <div class="col-md-8">
                                  <input  name="textinput" id="alttext" placeholder="Enter Alt Text" class="form-control input-md" type="text">
                                  
                                  </div>
                                  <div style="display:none;" id="err_msg_alttext_div"><center><span style="color:red;padding-left:18px;" id="err_msg_alttext"></span></center></div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                    
            </div>
            
            <div class="modal-footer">
                <button type="button" style="display:none;" id="photo_gallery_page" class="btn btn-primary btn-sm" onclick="photoGallery()">Insert into Gallery</button>
                <button type="button" style="display:none;" id="insert_page" class="btn btn-primary btn-sm" onclick="getInfo()" data-bs-dismiss="modal" aria-hidden="true">Insert into page</button>
                
            </div>
        </div>
    
      </div>
    </div>
    
    <!-------modal end----------->

</body>
<script>
function edit_rec(slide_idd){
    var slide_id = '';
    
    
    
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    
    if(!$("#id_"+slide_idd).is(':checked')){
        slide_id = slide_idd;
        //alert('if slide_id is '+slide_id);
    }else{
        var check_val = []; 
        $(':checkbox:checked').each(function(i){
          check_val[i] = $(this).val();
        });
        var len = check_val.length;
        //alert(check_val[len-1]+' '+slide_idd);
        if(check_val[len-1] != slide_idd){
            slide_id = check_val[len-1];    
        }else if(check_val[len-1] == slide_idd){
            slide_id = check_val[len-2];
        }else{
            slide_id = '';
        }
        //alert('else slide_id is '+slide_id);
    }

    var status = 1;
    if(slide_id == '' || slide_id == null){
        $("#slide_id").val('');
        $("#fname").text('');
        $("#ftype").text('');
        $("#timestamp").text('');
        $("#fsize").text('');
        $("#fdim").text('');
        
        $("#title").val('');
        $("#alttext").val('');
        $("#description").val('');
        
        $("#filepath").val('');
        $("#burl").val('');
        
    }else{
       $.get('<?php echo base_url(); ?>CreateMediaController/mediaOnStatus',{slide_id:slide_id,status:status,'csrf_test_name': csrf_value},function(data){
            
            var obj = JSON.parse(data);
            
            $("#is_image").val(obj[0].is_image);
            $("#slide_id").val(obj[0].slide_id);
            $("#fname").text(obj[0].file_type);
            $("#ftype").text(obj[0].file_ext);
            $("#timestamp").text(obj[0].ts);
            $("#fsize").text(obj[0].file_size);
            $("#fdim").text(obj[0].image_width + " X " +obj[0].image_height);
            
            $("#title").val(obj[0].title);
            $("#alttext").val(obj[0].alttext);
            $("#description").val(obj[0].description);
            
            $("#filepath").val(obj[0].image_path);
            $("#burl").val(obj[0].base_url);
            
        }); 
    }
}

$("#description").keyup(function(){
    var description=$("#description").val();
    if(description =='')
    {
        $("#err_msg_description_div").show();
        $("#err_msg_description").html('Description is Required');
        return false;
    }else{
        $("#err_msg_description_div").hide();
        $("#err_msg_description").html('');
    }
});
$("#title").keyup(function(){
    var title=$("#title").val();
    if(title =='')
    {
        $("#err_msg_title_div").show();
        $("#err_msg_title").html('Title is Required');
        return false;
    }else{
        $("#err_msg_title_div").hide();
        $("#err_msg_title").html('');
    }
});
$("#alttext").keyup(function(){
    var alttext=$("#alttext").val();
    if(alttext =='')
    {
        $("#err_msg_alttext_div").show();
        $("#err_msg_alttext").html('Alt text is Required');
        return false;
    }else{
        $("#err_msg_alttext_div").hide();
        $("#err_msg_alttext").html('');
    }
});

function getInfo(){
    
    
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    
    var slide_id = $("#slide_id").val();
    
    var title = $("#title").val();
    var alttext = $("#alttext").val();
    var description = $("#description").val();
    
    if(slide_id == ''){
        alert('Please Select Any One');
        return false;
    }
    if(description == '' && title == '' && alttext == ''){
        $("#err_msg_description_div").show();
        $("#err_msg_description").html('Description is Required');
        $("#err_msg_title_div").show();
        $("#err_msg_title").html('Title is Required');
        $("#err_msg_alttext_div").show();
        $("#err_msg_alttext").html('Alt text is Required');
        return false;
    }
    
    if(description == ''){
        $("#err_msg_description_div").show();
        $("#err_msg_description").html('Description is Required');
        return false;
    }
    if(title == ''){
        $("#err_msg_title_div").show();
        $("#err_msg_title").html('Title is Required');
        return false;
    }
    if(alttext == ''){
        $("#err_msg_alttext_div").show();
        $("#err_msg_alttext").html('Alt text is Required');
        return false;
    }
    
    $.get('<?php echo base_url(); ?>CreateMediaController/updateImgInfo',{slide_id:slide_id,description:description,title:title,alttext:alttext,'csrf_test_name': csrf_value},function(data){
        
        
        if(data=='true'){
            //var mceprevioustext= tinyMCE.get('richTextArea').getContent();
            var img=$("#filepath").val();
           //alert(img);
            var burl=$("#burl").val();
            var title=$("#title").val();
            var alt=$("#alttext").val();
            var is_image = $("#is_image").val();
            var currentfilename=$("#currentpage").val();
            
            if(is_image=='1')
            {
                if(currentfilename=='edittextwidget.php')
                {
                    
                    var mceprevioustext="<img src='../../.."+img+"' title='"+title+"' alt='"+alt+"'>";
                }
                else
                {
                    var mceprevioustext="<img src='.."+img+"' title='"+title+"' alt='"+alt+"'>";
                }
            
            }
            else
            {
            var mceprevioustext="<a href='"+img+"'>"+img+"</a>";
            }
		    tinymce.activeEditor.execCommand('mceInsertContent', false, mceprevioustext);
		    //$('#myModal').modal('hide');
        }else{
            alert('Unable to update');
        }
    });
}


function photoGallery(){
    
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    
    var check_val = [];
    $(':checkbox:checked').each(function(i){
      check_val[i] = $(this).val();
    });
    var album_id = $("#photogallery_album_id").val();
    //alert(check_val+' ,'+album_id);
    if(check_val != ''){
        $.post('http://municipalservices.in/sites/admin/CreateMediaController/updateImgInfoPhotoGallery',{check_val:check_val,album_id:album_id,'csrf_test_name': csrf_value},function(data){
            //alert(data);
            if(data == '1'){
                alert('Upload Files Successfully');
                location.reload();
            }
        });
    }else{
        alert('Please Select Photos');
        return false;
    }
}
function media(name,album_id){
   
    if(name == 'photogallery'){
        $("#photo_gallery_page").show();
        $("#insert_page").hide();
    }else if(name == 'mapPages'){
        $("#insert_page").hide();
        $("#photo_gallery_page").hide();
    }
    else{
        $("#insert_page").show();
        $("#photo_gallery_page").hide();
    }
    $("#photogallery_album_id").val(album_id);
    $("#slide_id").val('');
    $("#fname").text('');
    $("#ftype").text('');
    $("#timestamp").text('');
    $("#fsize").text('');
    $("#fdim").text('');
    
    $("#title").val('');
    $("#alttext").val('');
    $("#description").val('');
    
    $("#filepath").val('');
    
    $("#err_msg_description_div").hide();
    $("#err_msg_description").html('');
    $("#err_msg_title_div").hide();
    $("#err_msg_title").html('');
    $("#err_msg_alttext_div").hide();
    $("#err_msg_alttext").html('');
   
    $(".checkboxImageSlide").prop('checked', false);
    $(".image-checkbox").each(function () {
      if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
        $(this).addClass('image-checkbox-checked');
      }
      else {
        $(this).removeClass('image-checkbox-checked');
      }
    });
    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
    myModal.show();
 }
</script>

<script>
function checkBoxFunction(){
    var check_val = []; 
    var slide_id = '';
    $(':checkbox:checked').each(function(i){
      check_val[i] = $(this).val();
      slide_id = $(this).val();
    });
    //alert(check_val);
    //edit_rec(slide_id);
    
}
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
  //checkBoxFunction();
});
</script>