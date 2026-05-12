<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <div class="text-center">
            <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal2">Add New</button>
        </div>
            <?php
            if ($this->session->flashdata('success')) 
             {
              ?>
              <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong> Success !</strong> <?php echo $this->session->flashdata('success');?>
            </div>
              <?php
              }
              ?>
            <hr>
        <div class="card bd-primary ">
            <div class="card-header bg-primary tx-white">All important links</div>
            
            <div class="card-body pd-sm-30">
				 <div class="mytable table-responsive">
              <table id="datatable1" class="table table-hover table-bordered table-defulat mg-b-0">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Language</th>
                    <th>Logo</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach($all as $row)
                    {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
						
						<?php if($row->lang_id==1){ ?>
						<span>English</span>
						<?php } else { ?>
						<span>Marathi</span>
						<?php } ?>
						
						</td>
                        <td><img src="<?php echo $row->logo; ?>" alt="<?php echo $row->title; ?>" style="width:50px;height:50px;border-radius:50px;"></td>
                        <td><?php echo $row->title; ?></td>
                        <td><?php echo $row->des; ?></td>
                   
                        <td><?php echo $row->status; ?></td>
                        <td>
                            <div><a href="<?php echo base_url() ?>edit-imp-links/<?php echo $row->id; ?>" class="modify_option">Edit </a> </div>
                            <div><a href="<?php echo base_url() ?>ImpLinksController/delete/<?php echo $row->id; ?>" class="modify_option1" onclick="return confirm('Are you Sure?')"> Delete </a> </div>
                        </td>
                        <td>
                            <div>Last Modified</div>
                            <div class="modify_date"><?php $yrdata= strtotime($row->created_at);  echo date('d - M-Y H:i:s', $yrdata); ?></div>
                        </td>
                  </tr>
                   <?php
                   $i++;
                    }
                    ?>
                </tbody>
              </table>
            </div> 
                
            </div>
        </div>
		<!---------------------- forms close here ------------------------------->
    </div>
	
	
	
	
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	
	 Button trigger modal 
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal23">
  Launch demo modal
</button>-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
	
	
  

<!-- Add Modal Newspaper -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title" id="exampleModalLabel2">Add Important Link Details</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body">
        <form action="<?php echo base_url('ImpLinksController/addImpLinkRecord') ?>" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
            <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
            <!-- custom one-time nonce -->
			<input type="hidden" name="form_nonce" value="<?= $form_nonce; ?>">
			<div class="row">
                
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Title: <span class="tx-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control mytext" data-type="text" onkeyup="funInputFielTypes(this)" required>
                   <span id="titleX" style="font-size:10px;color:red;"></span>
				  </div>
               </div>
               
               <!--<div class="col-md-12">-->
               <!--   <div class="form-group">-->
               <!--     <label class="control-label col-sm-3" for="email">Date: <span class="tx-danger">*</span></label>-->
               <!--     <input type="date" name="text2" class="form-control" value="" required>-->
               <!--   </div>-->
               <!--</div>-->
               
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Description: <span class="tx-danger">*</span></label>
                    <textarea id="des" class="form-control mytext" name="des" rows="4" cols="50" data-type="text" onkeyup="funInputFielTypes(this)"required ></textarea>
                   <span id="desX" style="font-size:10px;color:red;"></span>
				  </div>
               </div>
               

               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">LinkUrl: <span class="tx-danger">*</span></label>
                    <input type="text" name="linkurl" id="linkurl" class="form-control mytext"  data-type="url" onkeyup="funInputFielTypes(this)" required>
                   <span id="linkurlX" style="font-size:10px;color:red;"></span>
				  </div>
               </div> 
				
			   <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Logo: <span class="tx-danger">*</span></label>
                    <input type="file" name="logo"  id="logo" class="form-control mytext"  data-type="image" onchange="funInputFielTypes(this)" accept="image/jpeg, image/jpg, image/png" >
                  <span id="logoX" style="font-size:10px;color:red;"></span>
				  </div>
               </div> 
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Language: <span class="tx-danger">*</span></label>
                        <select name="lang_id" id="lang_id" class="form-control mytext" required>
							<option value="">-- select--</option>
							<option value="1">English</option>
							<option value="2">Marathi</option>
						</select>
                  </div>
               </div>

            </div>
            <div class="row">
               <div class="col-md-12 text-center">
                  <input type="submit" name="submitimplinks" id="submitBtn" value="Submit" class="btn btn-success" disabled>
               </div>
            </div>
            
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
         </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Modal Newspaper -->
<script>
    
    function edit_text_click(id)
    {
        //alert(id);
        // var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        // $.ajax({
        //     type: "POST",
        //     url:'<?php echo base_url() ?>TestimonialsController/edit_value',
        //     data: {
        //         "csrf_test_name": csrf_value,
        //         "editid": id
        //         },
        //     dataType: 'JSON',
        //     success: function (data) {
        //         //$('#edit_id').val(data.id);
        //     }
        // });
        // if(confirm('Are sure you want to delete this record'))
        // {
        //     $.post('AddMenuController/deleteMenu',{menu_id:menu_id,'csrf_test_name': csrf_value},function(data)
        //     {
        //         if(data=='1')
        //         {
        //             alert('Successfully deleted');
        //             location.reload();
        //         }
        //         else
        //         {
        //             alert('Unable deleted');
        //         }
        //     });
        // }
    }
</script>

<script>
      $(function() {
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        //$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
      
    </script>