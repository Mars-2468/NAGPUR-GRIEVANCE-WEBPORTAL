<script>
    
    function addAdvance()
{
    //alert();
    var divcontent;
    var i = document.getElementById('cnt').value;
    var j = i-1;
	
     var newdiv = document.createElement('div');
     newdiv.setAttribute('id', i);
	 newdiv.setAttribute('class', 'wid-gal-list');
     divcontent="";
    
           
			divcontent=divcontent + "<div class='col-md-1' style='margin-top:18px;'>";
            divcontent=divcontent + "";
            divcontent=divcontent + "</div>"; 
            
            
            divcontent=divcontent + "<div class='form-group col-md-3' style=''>";
            divcontent=divcontent + "<label class='control-label' for='textinput'>Upload Photo</label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input  name='userfile[]' class='input-file mytext FileUpload"+i+"' type='file' onchange='checkimagetype(" + i +");'>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            
            /*divcontent=divcontent + "<div class='form-group col-md-2'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'>Paste Url</label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input id='image_url' name='image_url[]' placeholder='Enter url here' class='form-control input-md' type='text'>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";*/
            
            
            
            
            divcontent=divcontent + "<div class='form-group col-md-2'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'> Title </label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input id='title' name='title[]' placeholder='Enter title here' class='form-control input-md' type='text'>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            divcontent=divcontent + "<div class='form-group col-md-3'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'>Page Url</label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input id='page_url' name='page_url[]' placeholder='Enter url here' class='form-control input-md' type='text'>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            
            divcontent=divcontent + "<div class='form-group col-md-2'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'>Open window</label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<select id='target' name='target[]' class='form-control'>";
            
            divcontent=divcontent + "<option value='0'>- Select -</option>";
            divcontent=divcontent + "<option value='1'>Open same window</option>";
            divcontent=divcontent + "<option value='2'>Open other window</option>";
            
            divcontent=divcontent + "</select>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            
            divcontent=divcontent + "<div class='form-group col-md-1'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'></label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input type='button' class='btn btn-danger' value=' - ' onclick='fnRemove(" + i +");' />";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            
        divcontent=divcontent + "</div>";
    divcontent=divcontent + "</div>";
            
           
            
    

			newdiv.innerHTML = divcontent;                                  
			document.getElementById('advance_div').appendChild(newdiv);
   
			document.getElementById('cnt').value = eval (document.getElementById('cnt').value) + 1 ;
			$(".datepick").datepicker({dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true,maxDate: '0',minDate: "-6M"});
    
  }
  
  function fnRemove(arg)
{
	
	//alert(arg);
	
	//alert(arg);
	var el = $("#div"+arg).remove();
	
    var d1=document.getElementById(arg).parentNode;
    var d2=document.getElementById(arg);
    d1.removeChild(d2); 
    var arg=arg-1;
 
   }
    
</script>


<style>
 
#mceu_1 {
    width: 37px !important;
     position:relative; !important;
    /*left: 10px;*/
    /*bottom: 65px;
    height: 30px;*/
}
    
</style>

<?php //print_r($result);?>

<div class="sh-pagebody">

<div class="card bd-primary mg-t-20">
         <div class="card-header bg-primary tx-white">Home Page Photo Gallery</div>
         <div class="card-body pd-sm-30">

<?php //echo form_open_multipart('CreateWidgetController/updateMediaGallerywidget'); ?>
<?php $attributes=array('id'=>'formA'); echo form_open_multipart('CreateWidgetController/updateMediaGallerywidget',$attributes);?>
<?php if($this->session->flashdata('message')){?>
    
    <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
    <?php }?>


<input type="hidden" name="cnt" value="0" id="cnt1">

<?php 
    $widgetIds = '';
    if($this->session->userdata('user_type') == 'A'){
        foreach($result['widgetName'] as $k => $v){
            if($v['ulbid'] == $this->session->userdata('ulbid'))
            //echo $v['ulbid']." == ".$this->session->userdata('ulbid')." & ".$v['widget_id'];
            $widgetIds = $v['widget_id'];
        }
    }
?>    
    
<?php foreach($result['widgetName'] as $key=>$value) { ?>
<div class="form-horizontal">
<div class="form-group" style="clear:both;">
    <label class="col-md-4 control-label" for="textinput">Widget Name:</label>
    <div class="col-md-6">
    <input class="form-control" type="text" name="widget_name" id="widgetname" onkeyup="widgetNameValidation()" value="<?php echo $value['widget_name']; ?>" <?php if(($this->session->userdata('user_type')) != 'A'){ echo 'readonly'; }?>>
     <input type="hidden" name="widget_type" value="<?php echo $value['widget_type']; ?>">
     <input type="hidden" name="widget_id" value="<?php if($widgetIds != ''){ echo $widgetIds; }else{echo $value['widget_id'];} ?>">
    </div>
</div>
</div>
    <?php } ?>
   <div id="widgetNameValidationError" style="display:none;" class="alert alert-danger">
        <center><span id="widgetNameValidationSpan"></span></center>
    </div> 
    
    <hr>
<div class="bulk_btn">
         <input type="button" class="btn btn-default btn-sm" id="bulk_select" value="Bulk Selection" />
  	    
  	    <input type="button" style="display:none;" class="btn btn-primary btn-sm" id="delete_select" value="Delete Selected" />
  	    
  	    <input type="button" style="display:none;" class="btn btn-default btn-sm " id="cancel_select" value="Cancel Selection" />
    </div>    
<div class="" id="advance_div">
   
<?php 
    if($result['widgetContent']){

    $j=1; foreach($result['widgetContent'] as $val){ ?>
    <input type="hidden" id="pid<?php echo $j; ?>" name="pid[]" value="<?php echo $val['id']; ?>" />
<div class="wid-gal-list" id="div<?php echo $j;?>">
     
    
<div class="col-md-1" > <img src="<?php echo $this->session->userdata('base_url').$val['full_path']; ?>" width="50px" height="50px" style="margin-top:2px;">  </div>
  
<!-- <div class="form-group col-md-1">-->
    
    
<!--  <label class="control-label " for="textinput">Present Photo</label>  -->
<!--  <div class="">-->
<!--  <img src="<?php echo $val->full_path?>" width="75px" height="75px">-->
 
<!--  </div>-->
<!--</div> -->

<input type="hidden" name="image_name[]" value="<?php echo $val['file_name']; ?>"/>
<input type="hidden" name="folder_path_name[]" value="<?php echo $val['folder_path']; ?>"/> 

<div class=" col-md-3" style="">
    
<label class="control-label " for="textinput">Upload Photo</label>
  <div class="">
  <input  name="userfile[]" class="input-file mytext FileUpload<?php echo $j;?>" type="file" accept="image/*"  onchange="checkimagetype(<?php echo $j;?>)">
  
</div>
</div>

<?php $attributes=array('id'=>'form'.$j); echo form_open_multipart('CreateWidgetController/cropImagePhotoGallery',$attributes);?>
<div class="col-md-1" style="padding-right: 0px;padding-left: 0px;">
  <label class=" control-label" for="textinput"></label>  
  <div class="">
  <!--<button class="btn btn-default" style="margin-top:6px;" onclick="form_submit(<?php echo $j; ?>);"><i class="fa fa-crop"></i> Crop</button>-->
  <input type="button" class="btn btn-default" style="margin-top:6px;" onclick="form_submit(<?php echo $j; ?>);" value="Crop" />
  <input type="hidden" name="widgetName" value="<?php echo $result['widgetName'][0]['widget_name']; ?>" />
  <input type="hidden" name="fileName" value="<?php echo $val['file_name']; ?>" />
  <input type="hidden" name="full_path" value="<?php echo $val['full_path']; ?>" />
  <input type="hidden" name="thumbnail_path" value="<?php echo $val['thumbnail_path']; ?>" />
  <input type="hidden" name="widgetId" value="<?php echo $val['widget_id']; ?>" />
  <input type="hidden" name="id" value="<?php echo $val['id']; ?>" />
  <input type="hidden" name="widgetIdAdmin" value="<?php echo $result['widgetName'][0]['widget_id']; ?>" />
  </div>
</div>   
<?php echo form_close(); ?> 
<div class=" col-md-2">
  <label class=" control-label" for="textinput"> Title </label>  
  <div class="">
  <input id="title" name="title[]" placeholder="Enter title here" class="form-control input-md" type="text" value="<?php echo $val['title']; ?>">
 
  </div>
</div>

<div class=" col-md-2">
  <label class=" control-label" for="textinput">Page Url</label>  
  <div class="">
  <input id="page_url" name="page_url[]" placeholder="Enter url here" class="form-control input-md" type="text" value="<?php echo $val['url_link']; ?>">
 
  </div>
</div>

<div class=" col-md-2">
  <label class=" control-label" for="textinput">Open window</label>  
  <div class="">
  <select id="target" name="target[]" class="form-control">
      <option value="0">- Select -</option>
      <option <?php echo ($val['target'] == '1') ? ' selected="selected"' : ''; ?> value="1">Open same window</option>
      <option <?php echo ($val['target'] == '2') ? ' selected="selected"' : ''; ?> value="2">Open other window</option>
      
    </select>
  </div>
</div>

<div class=" col-md-1" style="padding-right: 0px;padding-left: 0px;">
  <label id="lb1" class="lb1 control-label" for="textinput"></label>
  <label id="lb2" class="lb2 control-label" style="width:100%;display:none;">
  <input class="chkcat checkboxDel" type="checkbox"  value="<?php echo $j; ?>"  name="delete_checkbox[]">
  </label>
  <div class="addRemoveDiv">
    <input type='button' class="btn btn-success" style="margin-top:6px;" onclick="addAdvance()" value=" + ">
    <input type='button' class="btn btn-danger" style="margin-top:6px;" onclick="fnRemoveD(<?php echo $j;?>)" value=" - "> 
  </div>
  
  
</div>



</div>
<?php $j++; }
    }else{
?>        
        <div class="wid-gal-list" id="div1">
            <div class='col-md-1' style='margin-top:18px;'>
                
            </div> 
            <div class='form-group col-md-3' style=''>
                <label class='control-label' for='textinput'>Upload Photo</label>
                <div class=''>
                    <input  name='userfile[]' class='input-file FileUpload"+i+"' type='file' onchange='checkimagetype(" + i +");'>
                </div>
            </div>
            <div class='form-group col-md-2'>
                <label class='control-label' for='textinput'> Title </label>
                <div class=''>
                    <input id='title' name='title[]' placeholder='Enter title here' class='form-control input-md' type='text'>
                </div>
            </div>
            <div class='form-group col-md-3'>
                <label class='control-label' for='textinput'>Page Url</label>
                <div class=''>
                    <input id='page_url' name='page_url[]' placeholder='Enter url here' class='form-control input-md' type='text'>
                </div>
            </div>
            <div class='form-group col-md-2'>
                <label class='control-label' for='textinput'>Open window</label>
                <div class=''>
                    <select id='target' name='target[]' class='form-control'>
                        <option value='0'>- Select -</option>
                        <option value='1'>Open same window</option>
                        <option value='2'>Open other window</option>
                    </select>
                </div>
            </div>
            <div class='form-group col-md-1'>
                <label class='control-label' for='textinput'></label>
                <div class=''>
                    <input type='button' class="btn btn-success" style="margin-top:6px;" onclick="addAdvance()" value=" + ">
                </div>
            </div>
        </div>
<?php        
   }
?>

<input type="hidden" id="cnt" value="<?php echo $j; ?>"/>

</div>
<?php if(($this->session->userdata('user_type')) == 'A'){ 
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
    <!--<div>
        <div class="card bd-teal " style="clear:both;margin:15px 0 0 0;">
            <div class="card-header bg-teal tx-white">ULB Names</div>
            <div class="card-body">
            
                <div class="col-md-12">
                    <label class="ckbox" style="width:100%;">
                        <input class="chkcat" type="checkbox" value="" id="checkAll" <?php if($ulbCount == $ulblist){ echo 'checked'; } ?>> <span>Select All</span>
                    </label>
                </div>
                <?php
                    foreach($ulbList as $key => $value ){
                        $string = '';
                        foreach($result['widgetDetails'] as $key => $value1){
                            if($value['ulbid'] == $value1['ulbid']){
                                $string = 'checked';
                                break;
                            }else{
                                $string = '';
                            }
                        }
                ?>
                <div class="col-md-3">
                    <label class="ckbox" style="width:100%;">
                        <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" onclick="radioUlbNameCheckFun();" name="ulb_check_list[]" <?php echo $string; ?>> <span><?php echo $value['ulbname']; ?></span>
                    </label>
                </div>
                <?php  
                    }
                ?>
            </div>
            <div id="UlbCheckValidationError" style="display:none;" class="alert alert-danger">
                <center><span id="UlbCheckValidationSpan"></span></center>
            </div>
        </div>
        <br>
        <div class="row" style="margin:0 0 0 15px;">
            <div class="col-md-3">
                <label class="rdiobox" style="width:100%;">
                    <input class="" type="radio" value="edit" name="radio" id="radio1" onclick="radioUlbNameCheckFun();"> <span>Edit</span>
                </label>
            </div>
            <div class="col-md-3">
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
            </div>
        </div>
    </div>
    <br />-->
<?php } ?>

<br>
<div style="width:100%; text-align:center; clear:both;" id="buttonDiv">
    <input type="submit" name="save" onclick="form_submitA();" value="Update" class="btn btn-success btn-sm">
</div>

<?php echo form_close();?>

</div>
</div>

</div>



<script>

    function checkimagetype(i){
                   
       // var id=$(".FileUpload" +i).val();
        
        var ext = $(".FileUpload" +i).val().split('.').pop().toLowerCase();
         //alert(ext);
         if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
             alert("Upload only image formats");
             $(".FileUpload" +i).val('')
         }
        
    }
    $("#bulk_select").on("click",function(){
        //alert("Bulk Clicked");
        $("#delete_select").show();
        $("#cancel_select").show();
        $("#bulk_select").hide();
        $(".lb1").hide();
        $(".lb2").show();
        $(".addRemoveDiv").addClass("margin-top: -10px;")
    });
    $("#cancel_select").on("click",function(){
        
        $("#delete_select").hide();
        $("#cancel_select").hide();
        $("#bulk_select").show();
        $(".lb1").show();
        $(".lb2").hide();
       
    });
    $("#delete_select").on("click",function(){
        //alert("Delete Clicked");
        var album_id = $("#album_id").val();
        var check_val = [];
        $('.checkboxDel:checked').each(function(i){
          check_val[i] = $(this).val();
        });
        alert(check_val);
        var len = check_val.length;
        //alert(len);
        
        if(len>0){
            if(confirm('Do you want to Delete Checked Images Permenantly')){
                for(var i=0;i<len;i++){
                    var id = check_val[i];
                    alert(id);
                    var pid = $('#pid'+id).val();
                    alert(pid);
                    //alert(id+" "+pid);
                    /*$.post('<?php echo base_url(); ?>CreateWidgetController/deletePhotoGallerySingleImage',{pid:pid},function(data){
                        //alert(data);
                        if(data == 1){
                            //alert('Successfully Deleted');
                            //location.reload();
                        }else{
                            //alert('Please Try Again!');
                        }
                    });*/
                    
                }
                alert('Deleted Successfully');
            }    
            $("#delete_select").hide();
            $("#cancel_select").hide();
            $("#bulk_select").show();
            $(".lb1").show();
            $(".lb2").hide();
            location.reload();
        }else{
            alert("Please Select alteast One Image");
        }
    });
    function widgetNameValidation(){
        //alert("Widget");
        var widgetName = $("#widgetname").val();
        //alert(widgetName);
        if(widgetName == ''){
            $("#buttonDiv").hide();
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
                    $("#buttonDiv").hide();
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
        var check_val = [];
        $('.checkbox1:checked').each(function(i){
          check_val[i] = $(this).val();
        });
        var len = check_val.length;
        <?php if(($this->session->userdata('user_type')) == 'A'){ ?>
        var count = <?php echo $ulblist; ?>;
        
        if(len == count){
        	$("#checkAll").prop('checked', true);
        }else{
        	$("#checkAll").prop('checked', false);
        }
        
        if(len == 0){
            $("#buttonDiv").hide();
            $("#UlbCheckValidationError").show();
    	 	$("#UlbCheckValidationSpan").html('Please Select Atleast One ULB');
    	 	return false;
        }else{
            $("#buttonDiv").show();
            $("#UlbCheckValidationError").hide();
    	 	$("#UlbCheckValidationSpan").html('');
        }
        <?php } ?>
    }
    function form_submit(id){
        //alert('ok');
        $('#form'+id).submit();
    }
    function form_submitA(){
        $('#formA').submit();
    }
    function fnRemoveD(id){
        var pid = $('#pid'+id).val();
        //alert(id+" "+pid);
        if(confirm('Do you want to Delete this Image Permenantly')){
            $.get('<?php echo base_url(); ?>CreateWidgetController/deletePhotoGallerySingleImage',{pid:pid},function(data){
                //alert(data);
                if(data){
                    alert('Successfully Deleted');
                    location.reload();
                }else{
                    alert('Please Try Again!');
                }
            });
        }
    }
</script>







