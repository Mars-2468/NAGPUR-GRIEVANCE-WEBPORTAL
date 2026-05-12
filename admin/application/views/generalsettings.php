<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>


       <?php //print_r($ulbList); ?>
       
       <?php 
            if($this->session->userdata('user_type') == 'A'){
                if($this->session->flashdata('resource'))
                {
                    $filepath=substr($this->session->flashdata('resource'),2);
                    $thumbs=$this->session->flashdata('thumbs');
                    $filename=$this->session->flashdata('filename');
                    $randomValueId=$this->session->flashdata('randomValueId');
                }
                //echo $filepath.", ".$thumbs.", ".$filename.", ".$randomValueId;
        ?>
        <?php if($this->session->flashdata('message')){?>
            <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
        <?php }?>
        
        <div class="sh-pagebody">
            <div class="card bd-primary ">
                <div class="card-header bg-primary tx-white">General Settings</div>
                <div class="card-body ">
                    <?php
                        $i = 1;
                        foreach($ulbList as $key=>$val){
                    ?>
                    
                    <div class="" id="advance_div_<?php echo $i; ?>">
                        <div class="wid-gal-list" id="previewImageDivU_<?php echo $i; ?>">
                            <input type="hidden" id="ulbid_<?php echo $i; ?>" name="ulbid_<?php echo $i; ?>" value="<?php echo $val['ulbid']; ?>" class="form-control input-md mytext" readonly>
                            <div class="form-group col-md-1">
                               <div id="previewImageU_<?php echo $i; ?>">
                                   <img src="<?php if($val['file_path'] != ''){echo $val['base_url'].$val['file_path'];}else if($randomValueId == $i){echo $thumbs;}else{echo '../assets/000/ulb_logo/logo_not_found.jpg';} ?>" id="logo_<?php echo $i; ?>" width="60" height="60">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class=" control-label" for="textinput">Name</label>  
                                <div class="">
                                    <input id="municipality_name_<?php echo $i; ?>" name="municipality_name_<?php echo $i; ?>" value="<?php echo $val['ulbname']; ?>" placeholder="Enter Municipality Name" class="form-control input-md mytext" type="text" readonly>
                                </div>
                            </div>
                            <?php $attributes=array('id'=>'form'.$i); echo form_open_multipart('GeneralSettingsController/uploadfile',$attributes);?>
                            <div class=" col-md-3" style="padding-left:0px;">
                                <label class="control-label " for="textinput">Upload logo </label>  
                                <div class="">
                                    <input type="hidden" id="randomValue" name="randomValue" value="<?php echo $i; ?>" />
                                    <input type="hidden" id="ulbid_<?php echo $i; ?>" name="ulbid" value="<?php echo $val['ulbid']; ?>" class="form-control input-md mytext" readonly>
                                    <input id="userfile_<?php echo $i; ?>"  name="userfile_<?php echo $i; ?>" class="input-file mytext FileUpload" type="file"  onchange="form_submit(<?php echo $i; ?>)" />
                                </div>
                                <div id="imagefileErrorMsgDiv_<?php echo $i; ?>" style="display:none;">
                                    <span id="imagefileErrorMsgSpan_<?php echo $i; ?>" style="color:red;font-size: 12px;"></span>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="form-group col-md-2">
                                <input type="hidden" id="file_path_<?php echo $i ?>" name="file_path_<?php echo $i ?>" value="<?php if($randomValueId == $i){echo $filepath;}else if($val['file_path'] != ''){echo $val['file_path'];} ?>">
                                <label class="control-label">Image Title <span class="tx-danger">*</span></label>  
                                <div class="">
                                    <input id="image_title_<?php echo $i; ?>" name="image_title_<?php echo $i; ?>" value="<?php echo $val['title']; ?>" placeholder="Enter Title here" class="form-control input-md" type="text" onkeyup="titleFunction(<?php echo $i; ?>);">
                                </div>
                                <div id="imagetitleErrorMsgDiv_<?php echo $i; ?>" style="display:none;">
                                    <span id="imagetitleErrorMsgSpan_<?php echo $i; ?>" style="color:red;font-size: 12px;"></span>
                                </div>
                            </div>
            
                            <div class="form-group col-md-2">
                                <label class="control-label">Image Alt <span class="tx-danger">*</span></label>  
                                <div class="">
                                    <input id="image_alt_<?php echo $i; ?>" name="image_alt_<?php echo $i; ?>" value="<?php echo $val['alt']; ?>" placeholder="Enter Alt here" class="form-control input-md mytext" type="text" onkeyup="altFunction(<?php echo $i; ?>);">
                                </div>
                                <div id="imagealtErrorMsgDiv_<?php echo $i; ?>" style="display:none;">
                                    <span id="imagealtErrorMsgSpan_<?php echo $i; ?>" style="color:red;font-size: 12px;"></span>
                                </div>
                            </div>
            
                            <div class="form-group col-md-1" style="padding-left:0px; padding-right:0px; padding-top:18px; "> 
                                <div class="">
                                    <input type="button" class="btn btn-success" style="margin-top:6px;" onclick="addUpdateValue(<?php echo $i; ?>)" value="Update">
                                </div>
                                <!--<div class="btn-sm alert-success" id="successAlertDiv" style="margin-left: -52px;margin-top: -5px;display:;">
                                    
                                    <span class="label label-success"><i class="fa fa-check"></i> Successfully Update</span> 
                                </div>-->
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <?php
                            $i++;
                        }
                    ?>    
                    
                </div>
            </div>
        </div>    
        <?php
                
            }else{
       ?>
       
       <div class="sh-pagebody">
           
           
           <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">General Settings</div>
         <div class="card-body ">
           <br>
           
           <?php if($this->session->flashdata('message')){?>
            <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
           <?php }?>
           
           <div class="mypagetitile"></div>
           
           <?php 
           $attributes=array('id'=>'form','onsubmit'=>'return validateForm()');
           
           echo form_open_multipart('general-settings',$attributes); ?>
           <?php //echo json_encode($logodet); ?>
           <input type="hidden" name="logo" id="imgValue" value="<?php echo $logodet['file_path']; ?>">
           
           <div class="col-md-7">
           
           <div class="form-horizontal">
               
               <div class="form-group">
                  <label class="col-md-4 control-label">Upload logo <span class="tx-danger">*</span></label>  
                  <div class="col-md-7">
                   <input id="filebutton" name="userfile" class="input-file" type="file">
                   </div>
  
              </div>
              <div class="form-group" style="display:none;" id="previewImageDiv">
                <label class="col-md-4 control-label"> Preview logo </label>  
                  <div class="col-md-7" id="previewImage">
                  </div> 
              </div>
              <?php //echo $logodet['file_path']; ?>
              <?php //if($logodet['file_path'] != ''){ ?>
              <div class="form-group" id="imgDiv" style="display:none;">
                  <label class="col-md-4 control-label"> Previous logo </label>  
                  <div class="col-md-7">
                   <img src="..<?php echo $logodet['file_path']; ?>" width="75px" height="75px" id="logoimgpath" >
                   
                   </div>
                    
              </div>
                
                <div class="form-group" id="removeBtnDiv" style="display:none;">
                    <label class="col-md-4 control-label">  </label>  
                    <div class="col-md-7"><input type="button" class="btn btn-danger btn-sm" value="Remove Logo" id="removeLogoBtn" onclick="removeLogo()"></div>
                </div>          
              <? //} ?>
              <div class="form-group">
                  <label class="col-md-4 control-label">Image Titile <span class="tx-danger">*</span></label>  
                  <div class="col-md-7">
                  <input id="textinput" name="title" placeholder="Enter Image Titile" value="<?php echo $logodet['title']; ?>" class="form-control input-md url1 mytext" type="text" onblur="check_username()">
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-4 control-label">Image Alt <span class="tx-danger">*</span></label>  
                  <div class="col-md-7">
                  <input id="textinput" name="alt" placeholder="Enter Image Alt" value="<?php echo $logodet['alt']; ?>" class="form-control input-md url1 mytext" type="text" onblur="check_username()">
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-4 control-label"></label>  
                  <div class="col-md-7">
                  <input type="submit" class="btn btn-success btn-block" name="save" value="Update">
                   </div>
  
              </div>
              <?php echo form_close(); ?>
              
               
           </div>
           </div>
           
           <div class="col-md-5">
               <img src="assets/img/logo-img.jpg">
           </div>
           
           
           
           </div>
           </div>
        </div>
        <?php
            }
       ?>
       
<script>
  var val = $("#imgValue").val();
  if(val != ''){
    $("#imgDiv").show();
    $("#removeBtnDiv").show();
    $("#previewImageDiv").hide();
  }else{
    $("#imgDiv").hide();
    $("#removeBtnDiv").hide();
    $("#previewImageDiv").hide();
  }

  $("#filebutton").change(function(){
      filePreview(this);
      
  });

  function filePreview(input){
    $("#previewImageDiv").show();
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#imgDiv").hide();
        $("#removeBtnDiv").hide();
        
          $('#previewImage + img').remove();
          $('#previewImage').html('<img src="'+e.target.result+'" width="75px" height="75px" style="margin:5px 0 0 0;" />');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  
    function form_submit(id){
        $('#form'+id).submit();
    }
    function titleFunction(id){
        var title = $('#image_title_'+id).val();
        if(title == ''){
            $('#imagetitleErrorMsgDiv_'+id).show();
            $('#imagetitleErrorMsgSpan_'+id).html('Enter Title');
            return false;
        }else{
            $('#imagetitleErrorMsgDiv_'+id).hide();
            $('#imagetitleErrorMsgSpan_'+id).html('');
        }
    }
    function altFunction(id){
        var alt = $('#image_alt_'+id).val();
        if(alt == ''){
           $('#imagealtErrorMsgDiv_'+id).show();
            $('#imagealtErrorMsgSpan_'+id).html('Enter Alt Text');
            return false;
        }else{
            $('#imagealtErrorMsgDiv_'+id).hide();
            $('#imagealtErrorMsgSpan_'+id).html('');
        }
    }
    function addUpdateValue(id){
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var ulbid = $('#ulbid_'+id).val();
        var title = $('#image_title_'+id).val();
        var alt  = $('#image_alt_'+id).val();
        var file_path = $('#file_path_'+id).val();
        var id = id;
        //alert(id+" ulbid "+ulbid+" title "+title+" alt "+alt+" file "+file_path);
        if(file_path == '' || file_path == 'undefined'){
            $('#imagefileErrorMsgDiv_'+id).show();
            $('#imagefileErrorMsgSpan_'+id).html('Select Image');
            return false;
        }
        if(title == ''){
            $('#imagetitleErrorMsgDiv_'+id).show();
            $('#imagetitleErrorMsgSpan_'+id).html('Enter Title');
            return false;
        }
        if(alt == ''){
            $('#imagealtErrorMsgDiv_'+id).show();
            $('#imagealtErrorMsgSpan_'+id).html('Enter Alt Text');
            return false;
        }
        $.post('GeneralSettingsController/ulbLogoUpdate',{ulbid:ulbid,title:title,alt:alt,file_path:file_path,'csrf_test_name': csrf_value},function(data){
            //alert(data);
            if(data == 1){
                alert("Successfully Updated");
            }else{
                alert("Please Try Again!");
            }
        });
        
    }
 
function validateForm()
{


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
function removeLogo(){
    
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    
  //alert("Remove Logo");
  var imgPath  = $("#logoimgpath").val();
  //alert(imgPath);
  if(confirm('Are sure you want to delete this Logo')){
    $.post('GeneralSettingsController/deleteLogoImg',{'csrf_test_name': csrf_value},function(data){
      //alert(data);
      if(data == 'true'){
        alert('Logo Removed Successfully');
        location.reload();
      }else{
        alert("Logo is not Deleted. Please Try Again!");
      }
    });
  }
}
</script>
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
   
