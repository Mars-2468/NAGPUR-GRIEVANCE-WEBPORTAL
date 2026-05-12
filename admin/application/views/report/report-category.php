
 
<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
 
   
  <script src="<?php echo base_url() ?>assets/js/bootstrap.bundle.min.js"></script>


<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <div class="text-center">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1">Add New</button>
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
            <div class="card-header bg-primary tx-white">All Reports Categories</div>
            
            <div class="card-body pd-sm-30">
				 <div class="mytable">
              <table id="datatable1" class="table table-hover table-bordered table-striped mg-b-0">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Details Images</th>
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
                        <td><?php echo $row->title; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><img height="80px" src="<?php echo base_url() ?>../assets/reports/<?php echo $row->img; ?>" alt="img"></td>
                        
                        <td><?php echo $row->status; ?></td>
                        <td>
                            <div><a href="<?php echo base_url() ?>report-category-details/<?php echo $row->id; ?>" class="modify_option">Details </a> </div>   
                        </td>
                        <td>
                            <div><a href="<?php echo base_url() ?>edit-report-category/<?php echo $row->id; ?>" class="modify_option">Edit </a> </div>
                            <div><a href="<?php echo base_url() ?>ReportController/deletereportcategory/<?php echo $row->id; ?>" class="modify_option1" onclick="return confirm('Are you Sure?')"> Delete </a> </div>
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
   

<!-- Add Modal video-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"  >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Report</h5>
        <button type="button" class="close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
        <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
            <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
            <div class="row">
                
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Open Window: <span class="tx-danger">*</span></label>
                    <select class="form-control" name="cat">
                        <option value="1">Monthly</option>
                        <option value="2">Quarterly</option>
                        <option value="3">Yearly</option>
                    </select>
                  </div>
               </div>
               
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Title: <span class="tx-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="" Placeholder="Enter Menu Title" required>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Image: <span class="tx-danger">*</span></label>
                    <input type="file" name="file" class="form-control" value="" Placeholder="Enter Menu Title" required>
                  </div>
               </div>
               
               
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Open Window: <span class="tx-danger">*</span></label>
                    <select class="form-control" name="open">
                        <option value="1">Same Window</option>
                        <option value="2">New Window</option>
                    </select>
                  </div>
               </div>
               

            </div>
            <div class="row">
               <div class="col-md-12 text-center">
                  <input type="submit" name="submit" id="applynow" value="Submit" class="btn btn-success">
               </div>
            </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Modal video-->

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