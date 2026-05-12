<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>

<head>

	

	<script src="https://demo.itsolutionstuff.com/plugin/jquery.js"></script>

<!--	<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">-->

	<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

</head>

<body>
   

<div class="sh-pagebody">
    
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success text-center"> 
    <?php echo $this->session->flashdata('message');?>
    </div>
    <?php } ?>



              
             <div class="mypagetitile"> Edit Album </div>
              
              
              <hr>
              
              
              <?php foreach($edit_albam as $key=>$value) { ?>
              
              <?php $attributes=array('id'=>'myform');echo form_open('CreateAlbumController/updatealbam/',$attributes);?>
              <div class="col-md-12">
              
              <div class="col-md-4">
                  <label >Album Title: </label>
                  <input type="hidden" name="album_id" value="<?php echo $value['album_id']; ?>">
                  <input class="form-control" type="text" name="album_name" id="album_name" value="<?php echo $value['album_title']; ?>">
                  <span class="error"><?php echo form_error('album_name');?></span>
              </div>
              
              <div class="col-md-4">
                  <label >Description: </label>
                  <textarea style="margin-bottom:15px;" class="form-control" name="album_desc" id="album_desc" ><?php echo $value['album_desc']; ?></textarea>
                  <span class="error"><?php echo form_error('album_desc');?></span>
              </div>
              
              <div class="col-md-2">
                  <label> &nbsp; </label>

                  <input type="submit" name="update" value="save" class="btn btn-success btn-sm" style="margin-top:33px;">
                  
                  </div>
              
              
              
              

              
              
              
              
              
              
              </div>
               <?php echo form_close(); ?>
              <?php } ?>
             
    
    <script>
        function edite_rec(i)
        {
            var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
            
            
            var id=$("#id" + i).val();
            
            var value=$("#album" + i).text();
            var title=$("#albumtitle" + i).text();
            $.post('CreateAlbumController/updateContent',{id:id,value:value,title:title,'csrf_test_name': csrf_value},function(data)
            {
               
            });
        }
        
        
    function delete_rec(album_id)
    {
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        if(confirm('Are sure you want to delete this record'))
        {
            $.post('CreateAlbumController/deleteContent',{album_id:album_id,'csrf_test_name': csrf_value},function(data)
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

	


