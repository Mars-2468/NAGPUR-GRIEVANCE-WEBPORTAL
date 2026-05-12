
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <h2 class="text-center">Edit Recent Announcements / Text Widgets Post</h2>
        <div class="text-center">
          <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                <div class="row">
                    <input type="hidden" name="category" class="form-control" value="2">
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Select Type: <span class="tx-danger">*</span></label>
                        <select class="form-control" name="cat">
                            <option value="3" <?php if($dtl->cat == 3) echo "selected"; ?>>Press Release</option>
                            <option value="1" <?php if($dtl->cat == 1) echo "selected"; ?>>Announcements</option>
                            <option value="2" <?php if($dtl->cat == 2) echo "selected"; ?>>Text Widgets</option>
                        </select>
                      </div>
                   </div>
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-sm-3" for="email">Menu Title: <span class="tx-danger">*</span></label>
                          <input type="text" name="title" class="form-control" value="<?php echo $dtl->title; ?>">
                      </div>
                   </div>
                   
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-sm-3" for="email">Link: <span class="tx-danger">*</span></label>
                          <input type="text" name="link" class="form-control" value="<?php echo $dtl->link; ?>">
                      </div>
                   </div>
                   
                   <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-sm-12" for="email">Open Window: <span class="tx-danger">*</span></label>
                        <select class="form-control" name="open">
                            <option value="1" <?php if($dtl->open == '1') {echo 'selected';} ?>>Same Window</option>
                            <option value="2" <?php if($dtl->open == '2') {echo 'selected';} ?>>New Window</option>
                        </select>
                      </div>
                   </div>
               
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-sm-12" for="email">Status <span class="tx-danger">*</span></label>
                            <select class="form-control" id="status" name="status">
                              <option value="Enable" <?php if($dtl->status == 'Enable') {echo 'selected';} ?>>Enable</option>
                              <option value="Disable" <?php if($dtl->status == 'Disable') {echo 'selected';} ?>>Disable</option>
                            </select>
                      </div>
                   </div>

                </div>
                <div class="row">
                   <div class="col-md-12 text-center">
                      <input type="submit" name="update_01" id="submit" value="Update" class="btn btn-success">
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
    

