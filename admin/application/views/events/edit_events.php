
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <h2 class="text-center">Edit Calendar Event</h2>
        <div class="text-center">
          <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                <div class="row">
                    <input type="hidden" name="category" class="form-control" value="2">
                   
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label" for="email">Title: <span class="tx-danger">*</span></label>
                          <input type="text" name="title" class="form-control" value="<?php echo $dtl->title; ?>">
                      </div>
                   </div>
                   
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label " for="email">Date: <span class="tx-danger">*</span></label>
                          <input type="date" name="dt" class="form-control" value="<?php echo $dtl->start; ?>">
                      </div>
                   </div>
                   
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-sm-12" for="email">Status <span class="tx-danger">*</span></label>
                            <select class="form-control" id="status" name="status">
                              <option value="1" <?php if($dtl->status == '1') {echo 'selected';} ?>>Enable</option>
                              <option value="0" <?php if($dtl->status == '0') {echo 'selected';} ?>>Disable</option>
                            </select>
                      </div>
                   </div>

                </div>
                <div class="row">
                   <div class="col-md-12 text-center">
                      <input type="submit" name="update" id="submit" value="Update" class="btn btn-success">
                   </div>
                </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
             </form>
        </div>
        
		<!---------------------- forms close here ------------------------------->
    </div>
    <!-- Add Modal text-->
    

