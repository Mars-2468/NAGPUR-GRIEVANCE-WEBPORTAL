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
            <div class="card-header bg-primary tx-white">All Team Bembers</div>
            
            <div class="card-body pd-sm-30">
				 <div class="mytable table-responsive">
              <table id="datatable1" class="table table-hover table-bordered table-defulat mg-b-0">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Image</th>
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
					<td><?php if($this->session->userdata('langId')==1){ echo $row->text1;}else{ echo $row->text1_mr; } ?></td>
                        <td><?php if($this->session->userdata('langId')==1){  echo $row->des; }else{ echo $row->des_mr;} ?></td>
                        <td>
                        <?php
                        if($row->category == 1){
                         ?>
                            <iframe width="220" height="155"
                                src="https://www.youtube.com/embed/<?php echo $row->file; ?>">
                            </iframe>
                           <?php
                        }if($row->category == 2){
                           ?>
                            <img height="80px" src="<?php echo base_url() ?>../assets/cdma/testimonials/<?php echo $row->file; ?>" alt="img">
                           <?php
                        }if($row->category == 3){
                            if($row->file)
                            {
                                ?>
                                <img height="80px" src="<?php echo base_url() ?>../assets/cdma/testimonials/<?php echo $row->file; ?>" alt="img">
                                <?php
                            }else{
                                echo "No Image";
                            }
                            ?>
                            <?php
                        }
                        ?>
                        </td>
                        <td><?php echo $row->status; ?></td>
                        <td>
                            <div><a href="<?php echo base_url() ?>edit-team-details/<?php echo $row->id; ?>" class="modify_option">Edit </a> </div>
                            <div><a href="<?php echo base_url() ?>TestimonialsController/delete/<?php echo $row->id; ?>" class="modify_option1" onclick="return confirm('Are you Sure?')"> Delete </a> </div>
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
<!--
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
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
	
	
	
    <!-- Add Modal text-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Text Testimonials</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           <div class="modal-body">
            <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                <div class="row">
                   <!--<div class="col-md-12">-->
                   <!--   <div class="form-group">-->
                   <!--       <label class="control-label col-sm-12" for="email">Select Video / Text <span class="tx-danger">*</span></label>-->
                   <!--         <select class="form-control" id="category" name="category">-->
                   <!--           <option value="2">Text</option>-->
                   <!--         </select>-->
                   <!--   </div>-->
                   <!--</div>-->
                    <input type="hidden" name="category" class="form-control" value="2">
                   <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Description: <span class="tx-danger">*</span></label>
                        <input type="text" name="des" class="form-control" value="" required>
                      </div>
                   </div>
                   
                   <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Text 1: <span class="tx-danger">*</span></label>
                        <input type="text" name="text1" class="form-control" value="" required>
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Text 2: <span class="tx-danger">*</span></label>
                        <input type="text" name="text2" class="form-control" value="" required>
                      </div>
                   </div>
                   
                   <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Link: <span class="tx-danger">*</span></label>
                        <input type="text" name="link" class="form-control" value="" required>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Image: <span class="tx-danger">*</span></label>
                        <input type="file" name="file" class="form-control mytext" required="required" value="">
                      </div>
                   </div>

                </div>
                <div class="row">
                   <div class="col-md-12 text-center">
                      <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-success">
                   </div>
                </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
             </form>
          </div>
        </div>
      </div>
    </div>
<!-- Add Modal text-->

<!-- Add Modal video-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Video Testimonials </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
        <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
            <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
            <div class="row">
                <input type="hidden" name="category" class="form-control" value="1">
               
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Link: <span class="tx-danger">*</span></label>
                    <input type="text" name="link" class="form-control" value="" Placeholder="Enter Link" required>
                  </div>
               </div>

            </div>
            <div class="row">
               <div class="col-md-12 text-center">
                  <input type="submit" name="videosubmit" id="videosubmit" value="Submit" class="btn btn-success">
               </div>
            </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Modal video-->

<!-- Add Modal Newspaper -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title" id="exampleModalLabel2">Add Team Member Details</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body">
        <form action="<?= site_url('TestimonialsController/addTestimonials'); ?>" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
            <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
            <!-- custom one-time nonce -->
			<input type="hidden" name="form_nonce" value="<?= $form_nonce; ?>">
			
			<div class="row">
                <input type="hidden" name="category" class="form-control" value="2">
                
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Role: <span class="tx-danger">*</span></label>
                    <input type="text" name="text1" id="text1" class="form-control" data-type="spnamesnrols" onkeyup="funInputFielTypes(this)" required>
					<span id="text1X" style="font-size:10px;color:red;"></span>
				  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">RoleMR: <span class="tx-danger">*</span></label>
                    <input type="text" name="text1_mr" id="text1_mr" class="form-control" data-type="spnamesnrols" onkeyup="funInputFielTypes(this)" required>
					<span id="text1_mrX" style="font-size:10px;color:red;"></span>
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
                    <label class="control-label col-sm-3" for="email">Name: <span class="tx-danger">*</span></label>
                    <textarea id="des" class="form-control" name="des" id="des" rows="4" cols="50" required data-type="spnamesnrols"  onkeyup="funInputFielTypes(this)"></textarea>
					<span id="desX" style="font-size:10px;color:red;"></span>
				 </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">NameMR: <span class="tx-danger">*</span></label>
                    <textarea id="des_mr" class="form-control" name="des_mr" id="des_mr" rows="4" cols="50" required data-type="spnamesnrols"  onkeyup="funInputFielTypes(this)"></textarea>
					<span id="des_mrX" style="font-size:10px;color:red;"></span>
				 </div>
               </div>
               

               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Image: <span class="tx-danger"></span></label>
                    <input type="file" name="file" id="file" class="form-control mytext" accept="image/png, image/jpg, image/jpeg" data-type="image" onchange="funInputFielTypes(this)">
                  <span id="fileX" style="font-size:10px;color:red;"></span>
				  </div>
               </div>

            </div>
            <div class="row">
               <div class="col-md-12 text-center">
                  <input type="submit" name="submitnewspaper" id="submitBtn" value="Submit" class="btn btn-success" disabled>
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