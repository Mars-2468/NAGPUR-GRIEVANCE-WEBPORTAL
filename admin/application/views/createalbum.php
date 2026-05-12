<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>

<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
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

<div class="mypagetitile">Edit Album</div>
<hr>


              
              <?php
              $attributes=array('method'=>'POST');
              echo form_open('create-album',$attributes);
              ?>
              
              <?php
              echo form_close();
              
              if(count($albumdata) > 0)
              {
              ?>
              
            <br>
            <table class="table table-hover table-bordered mg-b-0">
            	    <thead>
            	        <tr>
            	            <th>sno</th>
            	            <th>Album Title</th>
            	            <th>Album Description</th>
            	            <th>Created Time</th>
            	            <th>Update</th>
            	            <th>Delete</th>
            	            
            	        </tr>
            	    </thead>
            	    <tbody>
            	        <?php $i=1;foreach($albumdata as $key=>$val){?>
            	        <input type="hidden" name="id<?php echo $i; ?>" id="id<?php echo $i; ?>" value="<?php echo $val['album_id']; ?>">
            	        <input type="hidden" name="id<?php echo $i; ?>" id="idss<?php echo $val['album_id']; ?>" value="<?php echo $val['album_id']; ?>">
            	        <tr>
            	            <td><?php echo $i; ?></td>
            	            <td contenteditable="true" id="albumtitle<?php echo $i; ?>" onkeyup="edite_rec(<?php echo $i; ?>)"><?php echo $val['album_title']; ?></td>
            	            <td contenteditable="true" id="album<?php echo $i; ?>" onkeyup="edite_rec(<?php echo $i; ?>)"><?php echo $val['album_desc']; ?></td>
            	            <td><?php echo $val['ts']; ?></td>
                            <td>
                         <?php echo form_open('Edit-albam')?>
                        <input type="hidden" name="menuid" value="<?php echo $val->menu_id; ?>">
                        <input type="hidden" name="eid" id="eid">
                        <!-- <input type="submit" name="update" value="Edit" class="btn btn-primary btn-sm">-->
                         <button type="button" class="btn btn-primary btn-sm" id="editid<?php echo $val['album_id']; ?>"  onclick="edit_bil(<?php echo $val['album_id']; ?>)" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil" style="font-size:15px;"></i> Edit</button>
                        
                                               
                        <!-- Modal -->
                        
                        <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Edit Album</h4>
                              </div>
                              <div class="modal-body" style="padding: 15px !important;font-size:13px;">
                                   <div class="form-group">
                                    <label for="email">Album Title:</label>
                                    <input type="email" class="form-control" name="album_title" id="album_title">
                                  </div>
                                  
                                  <div class="form-group">
                                    <label for="email">Description:</label>
                                    <textarea class="form-control" rows="5" name="album_desc" id="album_desc"></textarea>
                                  </div>
                                  
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-danger">Cancel</button>
                              </div>
                            </div>
                        
                          </div>
                        </div>
                       
                       
                        <?php echo form_close();?>
                             </td> 
            	            <td><button class="btn btn-danger btn-sm" type="button" onclick="delete_rec(<?php echo $val['album_id']; ?>)"><i class="fa fa-trash" style="font-size:15px;"></i></button></td>
            	        </tr>
            	        
            	        <?php $i++; }?>
            	    </tbody>
            	    
            	   
            	</table>
	
	 <?php }?>
    
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
<script>
function edit_bil(id)
{
   var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
      
                    type:'POST',
                    url:'<?php echo base_url(); ?>CreateAlbumController/fech',
                    data:'id='+ id +'&csrf_test_name' + csrf_value,
                    success:function(html){
                    
                         $('#album_title').html(html);
                         $('#album_desc').html(html);
                         
                    }
                });  
   
}
</script>

	


