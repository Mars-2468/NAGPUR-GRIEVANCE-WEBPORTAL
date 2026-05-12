<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <!-- <div class="text-center">
            <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal2">Add New</button>
        </div> -->
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
            <div class="card-header bg-primary tx-white">All Sliders</div>
            
            <div class="card-body pd-sm-30">
				 <div class="mytable table-responsive">
              <table id="datatable1" class="table table-hover table-bordered table-defulat mg-b-0">
                <thead>
                  <tr>
                    <th>Sl No</th>                   
                    <th>Page Id</th>
                    <th>Title</th>
                    <th>Slider Image</th>
                    <th>Priority</th>
                    <th>Action</th>
                    <th>Date</th>
                    <th>Visibility</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach($sliderposts as $key=>$value)
                    {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
						<td><?php echo $value['page_id']; ?></td>
						<td><?php echo $value['page_title']; ?></td>
                        <td><img src="<?php echo $value['image_path']; ?>" alt="<?php echo $value['page_title']; ?>" style="width:150px;height:50px;"></td>
						<td><?php echo !empty($value['priority'])?$value['priority']:'-'; ?></td>
						<td>
                          <!--  <div><a href="<?php echo base_url() ?>edit-imp-links/<?php echo $value['page_id']; ?>" class="modify_option">Edit </a> </div> -->
                            <div><a href="<?php echo base_url() ?>SliderListController/delete/<?php echo $value['page_id']; ?>" class="modify_option1" onclick="return confirm('Are you Sure?')"> Delete </a> </div>
                        </td>
                        <td>
                            <div>Last Modified</div>
                            <div class="modify_date"><?php $yrdata= strtotime($value['datetime']);  echo date('d - M-Y H:i:s', $yrdata); ?></div>
                        </td>
						<td><button id="toggleBtn<?php echo $value['page_id']; ?>" class="btn btn-danger" onclick="onOffButton(this)">OFF</button></td>
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
	
	
	

<script>
function onOffButton(btn)
{
    var csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfValue = '<?php echo $this->security->get_csrf_hash(); ?>';

    // Extract numeric page_id from button id
    var page_id = btn.id.replace(/\D/g, '');

    if (!page_id) {
        alert('Invalid page id');
        return;
    }

    $.ajax({
        url: "<?php echo base_url('SliderListController/updateSlider'); ?>",
        type: "POST",
        data: {
            page_id: page_id,
            [csrfName]: csrfValue
        },
        success: function (data) {
            data = data.trim(); // important for CI output

            if (data === '1') {
                btn.innerText = "ON";
                btn.classList.remove("btn-danger");
                btn.classList.add("btn-success");
            } else if (data === '0') {
                btn.innerText = "OFF";
                btn.classList.remove("btn-success");
                btn.classList.add("btn-danger");
            }
        },
        error: function () {
            alert('Server error');
        }
    });
}
</script>
	
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
	
	
  

<!-- Add Modal Newspaper -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Add Important Link Details</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body">
        <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
            <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
            <div class="row">
                
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Title: <span class="tx-danger">*</span></label>
                    <input type="text" name="title" class="form-control mytext" value="" required>
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
                    <textarea id="des" class="form-control mytext" name="des" rows="4" cols="50" required></textarea>
                  </div>
               </div>
               

               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">LinkUrl: <span class="tx-danger">*</span></label>
                    <input type="text" name="linkurl" class="form-control mytext" value="" required>
                  </div>
               </div> 
				
			   <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Logo: <span class="tx-danger">*</span></label>
                    <input type="file" name="logo" class="form-control mytext" value="" accept="image/jpeg, image/jpg, image/png" >
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
                  <input type="submit" name="submitimplinks" id="submitimplinks" value="Submit" class="btn btn-success">
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