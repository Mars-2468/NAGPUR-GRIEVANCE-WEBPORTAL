
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <div class="text-center">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add</button>
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
            <?php
            if ($this->session->flashdata('error')) 
             {
              ?>
              <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong> Sorry !</strong> <?php echo $this->session->flashdata('error');?>
            </div>
              <?php
              }
              ?>
            <hr>
        <div class="card bd-primary ">
            <div class="card-header bg-primary tx-white">All Startups / Partners</div>
            
            <div class="card-body pd-sm-30">
				 <div class="mytable table-responsive">
              <table id="datatable1" class="table table-hover table-bordered table-defulat mg-b-0">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach($all_startups_partners as $row)
                    {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                        <?php
                        if($row->category == 1){
                            echo "Startups";
                        }else{
                            echo "Partners";
                        }
                        ?>
                        </td>
                        <td><img height="80px" src="<?php echo base_url() ?>../assets/cdma/startups-partners/<?php echo $row->file; ?>" alt="img"></td>
                        <td>
                            <div><a href="<?php echo base_url() ?>delete-startups-partners/<?php echo $row->id; ?>" class="modify_option1" onclick="return confirm('Are you Sure?')"> Delete </a> </div>
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
    <!-- Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Startups / Partners</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           <div class="modal-body">
            <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                <div class="row">
                   <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-sm-12" for="email">Select Startups / Partners<span class="tx-danger">*</span></label>
                            <select class="form-control" id="category" name="category">
                              <option value="1">Startups</option>
                              <option value="2">Partners</option>
                            </select>
                      </div>
                   </div>

                   <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-sm-12" for="email">File Icon(100*100): <span class="tx-danger">*</span></label>
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
<!-- Add Modal -->

