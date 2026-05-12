
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <h2 class="text-center">Edit Contact Info</h2><?php
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
        <div class="text-center">
          <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                <div class="row">
                    <input type="hidden" name="category" class="form-control" value="2">
                   
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-sm-3" for="email">Email: <span class="tx-danger"></span></label>
                          <input type="email" name="email" class="form-control" value="<?php echo $dtl->email; ?>">
                      </div>
                   </div>
                   
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-sm-3" for="email">Phone: <span class="tx-danger"></span></label>
                          <input type="text" name="phone" class="form-control" value="<?php echo $dtl->phone; ?>">
                      </div>
                   </div>
                   
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-sm-3" for="email">Phone: <span class="tx-danger"></span></label>
                          <input type="text" name="address" class="form-control" value="<?php echo $dtl->address; ?>">
                      </div>
                   </div>
                   

                </div>
                <div class="row">
                   <div class="col-md-12 text-center">
                      <input type="submit" name="update" id="submit" value="Update" class="btn btn-success">
                   </div>
                </div>
                
                </div>
                <!--<div class="modal-footer">-->
                <!--    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <!--</div>-->
             </form>
        </div>
        
		<!---------------------- forms close here ------------------------------->
    </div>
    <!-- Add Modal text-->
    

