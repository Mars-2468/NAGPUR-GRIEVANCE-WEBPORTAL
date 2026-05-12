<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>

<head>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	

	<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>

    <!-<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">-->

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
              
              
              
              
              
              <!--
              <div class="form-horizontal">
                  
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Album Title:</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text" name="album_name" id="album_name" >
                      <span class="error"><?php echo form_error('album_name');?></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Description:</label>
                    <div class="col-sm-9">
                       <textarea  class="form-control" name="album_desc" id="album_desc" > </textarea>
                       <span class="error"><?php echo form_error('album_desc');?></span>
                    </div>
                </div>
                

                    <div class="col-sm-4 col-sm-offset-6">
                       <input type="submit" name="save" value="save" class="btn btn-success btn-sm">
                    </div>
             
                  

              </div>  -->
              
             
              
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
                            <td><a 
                            href="javascript:;"
                            data-id="<?php echo $val['album_id'] ?>"
                            data-nama="<?php echo $val['nama'] ?>"
                            data-album_title="<?php echo $val['album_title'] ?>"
                            data-album_desc="<?php echo $val['album_desc'] ?>"
                            data-toggle="modal" data-target="#edit-data">
                            <button  data-toggle="modal" data-target="#ubah-data" class="btn btn-info">Ubah</button>
                            </a></td>
						<a href="#" class="btn btn-danger">Hapus</a>
            	            <td><button class="btn btn-danger btn-sm" type="button" onclick="delete_rec(<?php echo $val['album_id']; ?>)"><i class="fa fa-trash" style="font-size:15px;"></i></button></td>
            	        </tr>
            	        
            	        <?php $i++; }?>
            	    </tbody>
            	    
            	   
            	</table>
	
	
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit-data" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	                <h4 class="modal-title">Ubah Data</h4>
	            </div>
	            
	            
<?php $attributes=array('method'=>'POST'); echo form_open_multipart('admin/ubah',$attributes); ?>	            
	                <!--<form class="form-horizontal" action="<?php echo base_url('admin/ubah')?>" method="post" enctype="multipart/form-data" role="form">-->
		               <div class="modal-body">
		                    <div class="form-group">
		                        <label class="col-lg-2 col-sm-2 control-label">Nama</label>
		                        <div class="col-lg-10">
		                        	<input type="hidden" id="id" name="id">
		                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Tuliskan Nama">
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-lg-2 col-sm-2 control-label">Alamat</label>
		                        <div class="col-lg-10">
		                        	<textarea class="form-control" id="album_title" name="album_title" placeholder="Tuliskan Alamat"></textarea>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-lg-2 col-sm-2 control-label">Pekerjaan</label>
		                        <div class="col-lg-10">
		                            <input type="text" class="form-control" id="album_desc" name="album_desc" placeholder="Tuliskan Pekerjaan">
		                        </div>
		                    </div>
		                </div>
		                <div class="modal-footer">
		                    <button class="btn btn-info" type="submit"> Simpan&nbsp;</button>
		                    <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
		                </div>
		                <?php echo form_close(); ?>
	                <!--</form>-->
	            </div>
	        </div>
	    </div>
	</div>


	
	
   
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
                    data:'id='+id + '&csrf_test_name=' + csrf_value,
                    success:function(html){
                    //alert(html);
                         $('#album_title').html(html);
                         $('#album_desc').html(html);
                    }
                });  
                }
                </script>

	<script>
	    $(document).ready(function() {
	        $('#edit-data').on('show.bs.modal', function (event) {
	            var div = $(event.relatedTarget) 
	            var modal  = $(this)
	            modal.find('#album_id').attr("value",div.data('album_id'));
	            modal.find('#nama').attr("value",div.data('nama'));
	            modal.find('#album_title').html(div.data('album_title'));
	            modal.find('#album_desc').attr("value",div.data('album_desc'));
	        });
	    });
	</script>


