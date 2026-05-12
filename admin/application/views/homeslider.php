<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>

<head>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>

	<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
	
	
	
  
	
	
	<style>
	
.slider_main-div{
    border:1px #CCC solid;
    width: 100%; 
    padding: 15px;
    display: inline-block; 
    cursor: move;
}
	
	

.dropzone {
        
 min-height: 200px;
padding: 60px 20px 0px 20px;
text-align: center;
border: dashed 3px #C1C3C5;

    }
    
    
.dropzone::before{
position: absolute;
top: 36%;
left: 50%;
margin-left: -25px;
content: "";
width: 51px;
height: 33px;
/*background-image: url("http://municipalservices.in/sites/admin/assets/img/icn-upload.png");*/
background-size: 100%;
    }
    
    
.modal-header{
        
}
    
label{
        font-weight:normal !important;
}
    
ul{
     list-style-type:none;
 }







	</style>

</head>

<body>
   

<div class="sh-pagebody">
    
     <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Add Sliders</div>
         <div class="card-body ">
    
    
    
    
              <br>
              
              <?php 
              
             // $statusList=array('0'=>'Offline','1'=>'Online');
              //$attributes= array('class'=>'dropzone','id'=>'imageUpload'); echo form_open_multipart('HomesliderController/imageUploadPost',$attributes);?>
              
              <!--<img src="http://municipalservices.in/sites/admin/assets/img/icn-upload.png">-->
              
              <!--<center><h3>Upload Multiple Images By Clicking On Box</h3></center>-->
              
              	<?php// echo form_close();?>
              	
              	<?php echo form_open(); ?>
              	
              	
              	
              	<?php echo form_close();?>
              
              <?php foreach($file_errors as $key=>$val){echo $val; }?>
              <?php 
              
$attributes=array('method'=>'POST');

echo form_open_multipart('add-slider',$attributes); ?>



<div class="form-horizontal">
               
               <div class="form-group">
                  <label class="col-md-3 control-label">Upload Image <span class="tx-danger">*</span></label>  
                  <div class="col-md-5">
                   <input id="filebutton" name="userfile[]" class="input-file" type="file">
                   <span class="help-block" style="margin-bottom: 0px; font-size:13px;">Image Dimensions should be greater than or equalant to 1210w X 311h</span>
                   <br>
                    <span class="myerror"> <?php echo form_error('userfile');?></span>
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label"> Image Name<span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="title[]" id="title" placeholder="Enter Image name" value="" class="form-control input-md url1" type="text" required="required">
                   <br>
                    <span class="myerror"> <?php echo form_error('title');?></span>
                   
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Alt tag <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="alttext[]" id="alttext" placeholder="Enter Alt tag" value="" class="form-control input-md url1" type="text" required="required">
                   <br>
                    <span class="myerror"> <?php echo form_error('alttext');?></span>
                   
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Slider Heading <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="slide_heading[]" id="slide_heading" placeholder="Slider Heading" value="" class="form-control input-md url1" type="text" required="required">
                   <br>
                    <span class="myerror"> <?php echo form_error('slide_heading');?></span>
                   
                   
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Slider Discription <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="slide_desc[]" id="slide_desc" placeholder="Slider Discription" value="" class="form-control input-md url1" type="text" maxlenght="160" required="required">
                   <br>
                    <span class="myerror"> <?php echo form_error('slide_desc');?></span>
                   
                   
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label"> Apply languages <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                      
                      Telugu <input type="checkbox" name="check_list[]" value="2" id="tel">
                      English <input type="checkbox" name="check_list[]" id="eng" value="1">
                      Hindi <input type="checkbox" name="check_list[]" value="3" id="hin">
                  
                  
                  
                  <br>
                    <span class="myerror"> <?php echo form_error('check_list');?></span>
                   </div>
  
              </div>
              
              <!---------english div starts---->
              <div id="english" style="display:none;">
              <div class="form-group">
                  <label class="col-md-3 control-label"> Image Name<span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="title[]" id="title" placeholder="Enter Image name" value="" class="form-control input-md url1" type="text" >
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Alt tag <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="alttext[]" id="alttext" placeholder="Enter Alt tag" value="" class="form-control input-md url1" type="text" >
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Slider Heading <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="slide_heading[]" id="slide_heading" placeholder="Slider Heading" value="" class="form-control input-md url1" type="text" >
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Slider Discription <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="slide_desc[]" id="slide_desc" placeholder="Slider Discription" value="" class="form-control input-md url1" type="text" maxlenght="160">
                   </div>
  
              </div>
              </div>
               <!---------english div ends---->
                <!-----hindhi div starts---------->
               <div id="hindhi" style="display:none;">
              <div class="form-group">
                  <label class="col-md-3 control-label"> Image Name<span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="title[]" id="title" placeholder="Enter Image name" value="" class="form-control input-md url1" type="text" >
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Alt tag <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="alttext[]" id="alttext" placeholder="Enter Alt tag" value="" class="form-control input-md url1" type="text" >
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Slider Heading <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="slide_heading[]" id="slide_heading" placeholder="Slider Heading" value="" class="form-control input-md url1" type="text" >
                   </div>
  
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label">Slider Discription <span class="tx-danger">*</span></label>  
                  <div class="col-md-4">
                  <input id="textinput" name="slide_desc[]" id="slide_desc" placeholder="Slider Discription" value="" class="form-control input-md url1" type="text" maxlenght="160">
                   </div>
  
              </div>
 
              </div>
              
              <div class="form-group">
                  <label class="col-md-3 control-label"></label>  
                  <div class="col-md-4">
                  <input type="submit" name="save" class="btn btn-success btn-block" value="Submit">
                   </div>
  
              </div>
              
              </div>
              
               
              <!-----hindhi div endss---------->
              
              </div>
             
             
              
             
              
              
               
          
           
           <?php form_close();?>
           
           <br>
           <br>
           <?php
 if(count($sliderList) > 0)
              {
                  ?>
 
	<div class="" >
	    <ul id="sortable-row" class="ul_sortable" style="padding-left:0px;">
	        <?php $i=1;foreach($sliderList as $key=>$val){?>
	        
	    <li id='<?php echo $val['slide_id']?>'>
	   <div class="slider_main-div">
	       <div class="col-md-1"><?php echo $i; ?></div>
	       <div class="col-md-2 mywrap">
	           <div> <?php echo $val['image_path']?></div>
	       </div>
	       <div class="col-md-3">
	           <div style="border:1px #CCC solid;"><img src="../<?php echo $val['thumbnail_path']; ?>" width="100%" height="51"></div>
	       </div>
	       <div class="col-md-2">
	           <button class="btn btn-danger btn-block btn-xs" type="button" onclick="delete_rec(<?php echo $val['slide_id']; ?>)"> <i class="fa fa-trash"></i> Delete </button>
	           <a href="#" class="btn btn-success btn-block btn-xs" data-toggle="modal" data-target="#myModal" onclick="fun1('<?php echo base_url().$val['folder_path']; ?>','<?php echo $val['slide_id']; ?>')"> <i class="fa fa-pencil"></i> Edit slider </a>
	           <a href="crop-image/<?php echo $val['slide_id']; ?>" class="btn btn-warning btn-block btn-xs"> <i class="fa fa-crop"></i> Crop image </a>
	           
	       </div>
	       <div class="col-md-1 pull-right">
	        <div class="myhandle"><img src="assets/img/handle-arrow.png"></div>
	           
	           </div>
	   </div>
	   </li>
	   
	   <?php $i++;}?>
	   
	   
	   </ul>
	   <br>   
	  
	   <center> <input type="button" class="btnSave btn btn-success btn-sm"  onClick="saveOrder();" value="Save Changes"/> </center>
	   
	    
	</div>
	
	
	
<!--	<center><input class="btn btn-success" type="submit" name="Update" value="Update content"></center>	-->
        
        
          <br>   <br>   <br>    
                    
           
</div>

	
	


	


<?php echo form_close(); }?>


</div>
</div>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:90%;">

    <!-- Modal content-->
    <div class="modal-content" style="background-color:#FFF;">
      <div class="modal-header" style="border-bottom: 1px #CCC solid;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Attachment Details</h4>
      </div>
      <div class="modal-body">
       <div class="col-md-8">
           <div style=" margin:0 auto;">
         <img src="assets/img/loading.gif" class="img-responsive" style=" margin:0 auto;" id="model_img">
         </div>
       </div>
       <div class="col-md-4 ">
           <div class="attachment-info att_detail">
           <div><strong>File name:</strong> <span id="fname"></span></div>
           <div><strong>File type:</strong> <span id="ftype"></span></div>
           <div><strong>Uploaded on:</strong> <span id="timestamp"></span></div>
           <div><strong>File size:</strong> <span id="fsize"></span></div>
           <div><strong>Dimensions:</strong> <span id="fdim"></span> </div>
           <input type="hidden" id="slide_id">
           <hr>

<div class="form-horizontal myform-group">
<div class="form-group">
  <label class="col-md-4 control-label text-right" for="url">URL</label>  
  <div class="col-md-8">
  <input id="filepath" name="filepath" placeholder="Enter URL" class="form-control input-md" type="text" readonly>
  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="title">Slider heading</label>  
  <div class="col-md-8">
  <input  name="textinput" id="heading" placeholder="Enter Slider heading" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="description">Slider Description</label>  
  <div class="col-md-8">
   <textarea class="form-control" id="description" name="textarea" rows="3" placeholder="Enter Description"></textarea>
  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="title">Title</label>  
  <div class="col-md-8">
  <input  name="textinput" id="title" placeholder="Enter title" class="form-control input-md" type="text">
  
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label text-right" for="alttext">Alt Text</label>  
  <div class="col-md-8">
  <input  name="textinput" id="alttext" placeholder="Enter Alt Text" class="form-control input-md" type="text">
  
  </div>
</div>



<!--<div class="form-group">-->
<!--  <label class="col-md-4 control-label text-right" for="status">Status</label>  -->
<!--  <div class="col-md-8">-->
<!--   <select id="status" name="status" class="form-control">-->
       
<!--       <option value="">---select---</option>-->
<!--       <option value="1">Online</option>-->
<!--       <option value="0">Offline</option>-->
       
<!--   </select>-->
  
<!--  </div>-->
<!--</div>-->

</div>

</div>



       </div>
       
       
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" onclick="getInfo()">Save Changes</button>
      </div>
      
      
      
      
      
      
    </div>




  </div>
  
</div>


<br><br><br>








<script>
    
 
  $(function() {
    $( "#sortable-row" ).sortable();
  });
  
  function saveOrder() 
  {
      
      var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
      
	var selectedslides = new Array();
	$('ul#sortable-row li').each(function() {
	selectedslides.push($(this).attr("id"));
	});
	$.post('HomesliderController/updateSortOrder',{selectedslides:selectedslides,'csrf_test_name': csrf_value},function(data)
	{
	    alert('Updated Successfully');
	});
	
	
	
  }
</script>

   

</script>




<script type="text/javascript">

	Dropzone.options.imageUpload = {

        maxFilesize:20,

        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        
       success: function(){
           
        //location.reload();
        
        setInterval(doSomething, 1000);
    }
    
    };
    
    
    function doSomething() {
    alert('Your images uploaded successfully');
    location.reload();
}

function getInfo()
{
    
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    
    var title=$("#title").val();
    var slide_id=$("#slide_id").val();
    var alttext=$("#alttext").val();
    var description=$("#description").val();
    var status=$("#status").val();
    var heading=$("#heading").val();
    
    
    
    if(title=='')
    {
        alert('Title is required');
        return false;
    }
    
    if(alttext=='')
    {
        alert('Alt text is required');
        return false;
    }
    
    if(description=='')
    {
        alert('Description is required');
        return false;
    }
    
    if(status=='')
    {
        alert('Status is required');
        return false;
    }
    
    $.post('HomesliderController/insertImgInfo',{title:title,alttext:alttext,description:description,status:status,slide_id:slide_id,heading:heading,'csrf_test_name': csrf_value},function(data)
    {
        
        if(data==1)
        {
            alert('Updated successfully');
        }
        else
        {
            alert('Unable to update');
        }
    });
}
    
    function fun1(img_path,img_id)
    {
        
        $.post('HomesliderController/getImgInfo',{slide_id:img_id},function(data)
        {
            var obj = JSON.parse(data);
            $("#slide_id").val(obj[0].slide_id);
            $("#fname").text(obj[0].image_path);
            $("#ftype").text(obj[0].image_type);
            $("#timestamp").text(obj[0].ts);
            $("#fsize").text(obj[0].file_size);
            $("#fdim").text(obj[0].image_width + " X " +obj[0].image_height);
            $("#heading").val(obj[0].slide_heading);
            $("#title").val(obj[0].title);
            $("#alttext").val(obj[0].alttext);
            $("#description").val(obj[0].slide_desc);
            $("#status").val(obj[0].status);
            $("#filepath").val(obj[0].full_path);
            
           $("#model_img").attr('src',obj[0].full_path);
           $('#myModal').modal('show');
        });
        
    }
    
    function delete_rec(slide_id)
    {
      var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';  
        if(confirm('Are sure you want to delete this record'))
        {
            $.post('HomesliderController/deleteContent',{slide_id:slide_id,'csrf_test_name': csrf_value},function(data)
            {
                
                if(data=='1')
                {
                    alert('Successfully deleted');
                    location.reload();
                }
                else
                {
                    alert('Unable deleted');
                }
            });
        }
    }

</script>

<script>
       $('#eng').change(function(){
           
        if(this.checked)
            $('#english').show();
        else
            $('#english').hide();

    });
</script>
<script>
       $('#hin').change(function(){
           
        if(this.checked)
            $('#hindhi').show();
        else
            $('#hindhi').hide();

    });
</script>
<script>
       $('#tel').change(function(){
           
        if(this.checked)
            $('#telugu').show();
        else
            $('#telugu').hide();

    });
</script>







