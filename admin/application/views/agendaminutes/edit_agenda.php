
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <h2 class="text-center">Edit Schemes Sub Category Details</h2>
        <div class="text-center">
          <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                <div class="row">
                    
               <div class="col-md-12">
                  <div class="form-group">
                      <label class="control-label col-sm-12" for="email">Category<span class="tx-danger">*</span></label>
                        <select class="form-control" id="category" name="category" required>
                          <option value="">---Select Category---</option>
                          <?php
                          foreach($cats as $row)
                          {
                          ?>
                          <option value="<?php echo $row->id; ?>" <?php if($row->id == $dtl->category_id) { echo "selected"; } ?>><?php echo $row->category; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                  </div>
               </div>
               
               <div class="col-md-12">
                  <div class="form-group">
                      <label class="control-label col-sm-12" for="email">Heading <span class="tx-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?php echo $dtl->text; ?>" required>
                  </div>
               </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <label class="control-label col-sm-12" for="email">Link <span class="tx-danger"></span></label>
                    <input type="text" name="link" class="form-control" value="<?php echo $dtl->link; ?>" >
                  </div>
               </div>
               
                <div class="col-md-12">
                  <div class="form-group">
                      <label class="control-label col-sm-12" for="email">Open in <span class="tx-danger">*</span></label>
                        <select class="form-control" id="open" name="open" required>
                          <option value="1" <?php if($dtl->open == '1') {echo 'selected';} ?>>Same Page</option>
                          <option value="2" <?php if($dtl->open == '2') {echo 'selected';} ?>>Other Page</option>
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
                      <input type="submit" name="update" id="submit" value="Update" class="btn btn-success">
                   </div>
                </div>
                
                </div>
             </form>
        </div>
        
		<!---------------------- forms close here ------------------------------->
    </div>
    <!-- Add Modal text-->
    

