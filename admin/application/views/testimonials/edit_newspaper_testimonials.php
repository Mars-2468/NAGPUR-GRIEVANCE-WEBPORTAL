
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <h2 class="text-center">Edit Newspaper Clippings</h2>
        <div class="text-center">
          <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                <div class="row">
                    <input type="hidden" name="category" class="form-control" value="3">
                    
                   
                   <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Title: <span class="tx-danger">*</span></label>
                        <input type="text" name="text1" class="form-control" value="<?php echo $dtl->text1 ?>" required>
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Date: <span class="tx-danger">*</span></label>
                        <input type="date" name="text2" class="form-control" value="<?php echo $dtl->text2 ?>" required>
                      </div>
                   </div>
                   
                   <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Description: <span class="tx-danger">*</span></label>
                         <textarea id="des" class="form-control" name="des" rows="4" required><?php echo $dtl->des ?></textarea>
                      </div>
                   </div>
                   
                   <!--<div class="col-md-6">-->
                   <!--   <div class="form-group">-->
                   <!--     <label class="control-label col-sm-3" for="email">Link: <span class="tx-danger"></span></label>-->
                   <!--     <input type="text" name="link" class="form-control" value="<?php echo $dtl->link ?>" required>-->
                   <!--   </div>-->
                   <!--</div>-->

                   <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="email">File: <span class="tx-danger"></span></label>
                        <input type="file" name="file" class="form-control mytext" value="">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-sm-3" for="email">Image: <span class="tx-danger"></span></label>
                          <?php 
                          if($dtl->file){
                              ?>
                              <img height="80px" src="<?php echo base_url() ?>../assets/cdma/testimonials/<?php echo $dtl->file; ?>" alt="img">
                              <?php
                          }else{
                              echo "No Image";
                          }
                          ?>
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
                      <input type="submit" name="update_02" id="submit" value="Update" class="btn btn-success">
                   </div>
                </div>
                
                </div>
             </form>
        </div>
        
		<!---------------------- forms close here ------------------------------->
    </div>
    <!-- Add Modal text-->
    

