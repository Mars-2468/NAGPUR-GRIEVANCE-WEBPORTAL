<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>

	<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    
   
    
    <script>
	
	/* Demo purposes only */
$(".hover").mouseleave(
  function () {
    $(this).removeClass("hover");
  }
);

	</script>
    
<style>

   
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
        /*background-image: url("http://municipalservices.in/sites/admin/assets/img/icn-upload.png");*/
        background-size: 100%;
    }
    
    /*.thumbnail {
        width: 100px;
        height: 100px;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        overflow: hidden;
    }
    .thumbnail img {
      position: absolute;
      left: 50%;
      top: 50%;
      height: 100%;
      width: auto;
      -webkit-transform: translate(-50%,-50%);
          -ms-transform: translate(-50%,-50%);
              transform: translate(-50%,-50%);
    }
    .thumbnail img.portrait {
      width: 100%;
      height: auto;*/
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



          <div class="mypagetitile"> Upload images </div>
         
              <br><br>
              
              <?php $attributes= array('class'=>'dropzone','id'=>'imageUpload'); echo form_open_multipart('CreateMediaController/imageUploadPost',$attributes);?>
              <input type="hidden" name="album_desc" value="<?php echo $album_det1[0]['album_desc']?>">
              <input type="hidden" name="album_id" value="<?php echo $album_det1[0]['album_id']?>">
              <img src="<?php echo base_url()?>assets/img/icn-upload.png">
              
              <center><h3>Upload Multiple Image By Click On Box</h3></center>
              
              	<?php echo form_close();?>
              	
              	<br></br>
              	
              <?php  foreach($media_data as $key=>$val ){?>
              <!--<div class="col-md-2">-->
                  
              <!--    <img src="../../<?php echo $val['thumbnail_path']?>">-->
              <!--</div>-->
              
            <!--<figure class="col-md-2 snip1550 ">
                  <img src="../<?php echo $val['thumbnail_path']?>"  />
                  <div class="icons">
                	  <a onclick="edit_rec(<?php echo $val['slide_id']; ?>)" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i></a>
                	  <a onclick="delete_rec(<?php echo $val['slide_id']; ?>)"><i class="fa fa-trash"></i></a> 		
                  </div>
            </figure>-->
              
              
              <div class="col-6 col-sm-4 col-lg-3 col-xl-2 ">
                <a href="#" class="file-manager-icon">
                  <div style="overflow:hidden;">
                     <img src="../<?php echo $val['thumbnail_path']?>"   />
                  </div><!-- file-manager-icon -->

                  <h6>IMG_11022017.jpg</h6>
                </a>
              </div>
              
              <?php } ?>
  
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
           <div style=" margin:0 auto; min-width: 75%; max-width: 590px;">
         <!--<img src="<?php echo base_url(); ?>assets/img/loading.gif" class="img-responsive" style=" margin:0 auto;" id="model_img">-->
         <img src="../../<?php echo $val['thumbnail_path']?>" class="img-responsive" style=" margin:0 auto;" id="model_img">
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
  <label class="col-md-4 control-label text-right" for="url">URL <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
  <input id="filepath" name="filepath" placeholder="Enter URL" class="form-control input-md" type="text" readonly>
  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="heading">Slider heading <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
  <input  name="textinput" id="heading" placeholder="Enter Slider heading" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="description">Slider Description <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
   <textarea class="form-control" id="description" name="textarea" rows="3" placeholder="Enter Description"></textarea>
  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label text-right" for="title">Title <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
  <input  name="textinput" id="title" placeholder="Enter title" class="form-control input-md" type="text">
  
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label text-right" for="alttext">Alt Text <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
  <input  name="textinput" id="alttext" placeholder="Enter Alt Text" class="form-control input-md" type="text">
  
  </div>
</div>



<div class="form-group">
  <label class="col-md-4 control-label text-right" for="status">Status <span class="tx-danger">*</span></label>  
  <div class="col-md-8">
   <select id="status" name="status" class="form-control">
       
       <option value="">---select---</option>
       <option value="1">Online</option>
       <option value="0">Offline</option>
       
   </select>
  
  </div>
</div>

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


<div id="divdata"></div>

<script type="text/javascript">

	Dropzone.options.imageUpload = {

        maxFilesize:20,

        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        
       success: function(data){
           //alert(data);
           setInterval(doSomething, 1000);
    }
    };
    
    function doSomething() {
    alert('Your image uploaded successfully');
    location.reload();
}
    function edit_rec(slide_id){
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        $("#model_img").attr('src','<?php echo base_url(); ?>assets/img/loading.gif');
        //alert(slide_id);
        $.post('http://municipalservices.in/sites/admin/CreateMediaController/getContent',{slide_id:slide_id,'csrf_test_name': csrf_value},function(data){
           // alert(data);
            var obj = JSON.parse(data);
            
            $("#slide_id").val(obj[0].slide_id);
            $("#fname").text(obj[0].file_type);
            $("#ftype").text(obj[0].image_type);
            $("#timestamp").text(obj[0].ts);
            $("#fsize").text(obj[0].file_size);
            $("#fdim").text(obj[0].image_width + " X " +obj[0].image_height);
            $("#heading").val(obj[0].heading);
            $("#title").val(obj[0].title);
            $("#alttext").val(obj[0].alttext);
            $("#description").val(obj[0].description);
            $("#status").val(obj[0].status);
            $("#filepath").val(obj[0].image_path);
            
           $("#model_img").attr('src','..'+obj[0].folder_path);
           
        });
    }
    function delete_rec(slide_id)
    {
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
       
        if(confirm('Are sure you want to delete this record'))
        {
             
            $.post('http://municipalservices.in/sites/admin/CreateMediaController/deleteContent',{slide_id:slide_id,'csrf_test_name': csrf_value},function(data)
            {
                if(data==1)
                {
                    alert('Deleted successfully');
                    location.reload();
                }
                else
                {
                    alert('unable to delete, try again');
                }
                
            });
        }
    }
    function getInfo(){
        
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var slide_id=$("#slide_id").val();
        var heading = $("#heading").val();
        var description = $("#description").val();
        var title = $("#title").val();
        var alttext = $("#alttext").val();
        var status = $("#status").val();
        //alert('id '+slide_id+ 'Header '+heading+'DESc '+description+'Tit '+title+'Alt '+alttext+'Sat '+status);
        
        if(heading == ''){
            alert('Heading is Required');
            return false;
        }
        if(description == ''){
            alert('Description is Required');
            return false;
        }
        if(title == ''){
            alert('Title is Required');
            return false;
        }
        if(alttext == ''){
            alert('Alt text is Required');
            return false;
        }
        if(status == ''){
            alert('Status is Required');
            return false;
        }
        $.post('http://municipalservices.in/sites/admin/CreateMediaController/updateImgInfo',{slide_id:slide_id,heading:heading,description:description,title:title,alttext:alttext,status:status,'csrf_test_name': csrf_value},function(data){
            //alert(data);
            if(data=='true'){
                alert('Updated successfully');
            }else{
                alert('Unable to update');
            }
        });
    }

</script>
