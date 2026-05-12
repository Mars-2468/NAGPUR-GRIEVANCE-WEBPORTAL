<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>

<head>

	<title>Codeigniter - Multiple Image upload using dropzone.js</title>

	<script src="https://demo.itsolutionstuff.com/plugin/jquery.js"></script>

	<link rel="stylesheet" href="https://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>


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
    
    
    
</style>



</head>

<body>
   

<div class="sh-pagebody">
    
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success text-center"> 
    <?php echo $this->session->flashdata('message');?>
    </div>
    <?php } ?>



          <div class="mypagetitile"> Home Page Gallery</div>
         
              <br><br>
              
              <?php $attributes= array('class'=>'dropzone','id'=>'imageUpload'); echo form_open_multipart('HomeGalleryController/imageUploadPost',$attributes);?>
              
              <img src="https://municipalservices.in/sites/admin/assets/img/icn-upload.png">
              <center><h3>Upload Multiple Image By Click On Box</h3></center>
              
              	<?php echo form_close();?>
              
              
              <?php 
              if(count($sliderList) > 0)
              {
$attributes=array('method'=>'POST');

echo form_open('HomeGalleryController/updateContent',$attributes); ?>


<br>
<table class="table table-hover table-bordered  mg-b-0">
	    <thead>
	        <tr>
	            <th>sno</th>
	            <th>Image Name</th>
	            <th>Description</th>
	            <th>Title</th>
	            <th>Delete</th>
	        </tr>
	    </thead>
	    <tbody>
	        <?php $i=1;foreach($sliderList as $key=>$val){?>
	        <input type="hidden" name="slide[]" value="<?php echo $val['slide_id']; ?>">
	        <tr>
	            <td><?php echo $i;?></td>
	            <td><img src="<?php echo base_url(); ?>assets/gallery/<?php echo $val['image_path'];?>" width="70" height="70"></td>
	            <td><textarea class="form-control" type="text" name="description[]"><?php echo $val['slide_desc'];?></textarea></td>
	            <td><input class="form-control" type="text" name="title[]" value="<?php echo $val['title'];?>"></td>
	            <td> 
	            
	            
	            
	            <button class="btn btn-danger btn-sm" type="button" onclick="delete_rec(<?php echo $val['slide_id']; ?>)"><i class="fa fa-trash" style="font-size:15px;"></i></button></td>
	        </tr>
	        
	        <?php $i++;}?>
	    </tbody>
	   
	</table>
	
	
	<center><input class="btn btn-success" type="submit" name="Update" value="Update content"></center>	
              
                    
            
</div>

	
	
</div>

	

<?php echo form_close(); }?>

<script type="text/javascript">

	Dropzone.options.imageUpload = {

        maxFilesize:1,

        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        
       success: function(){
           setInterval(doSomething, 1000);
    }
    };
    
    function doSomething() {
    alert('Your images uploaded successfully');
    location.reload();
}
    
    function delete_rec(slide_id)
    {
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        if(confirm('Are sure you want to delete this record'))
        {
            $.post('HomeGalleryController/deleteContent',{slide_id:slide_id,'csrf_test_name': csrf_value},function(data)
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
