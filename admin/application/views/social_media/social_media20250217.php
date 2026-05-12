<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>




<div class="sh-pagebody">
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
    <form name="" action="<?php echo base_url();?>SocialMediaController/update_links" method="POST">
        <div class="row">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>"
                value="<?php echo $this->security->get_csrf_hash();?>">
            <div class="form-group col-md-12">
                <label class=" control-label" for="textinput">Facebook Link: <span class="tx-danger">*</label>
                <div class="">

                <input type="text" class="form-control"  name="facebook_link" value="<?php echo $edit_social_media->facebook_link;?>">

                </div>
            </div>

            <div class="form-group col-md-12">
                <label class=" control-label" for="textinput">Twitter Link: <span class="tx-danger">*</label>
                <div class="">
                <input type="text" class="form-control"  name="twitter_link" value="<?php echo $edit_social_media->twitter_link;?>">
                </div>
            </div>


            <div class="col-md-1">
              <input type="hidden" name="id" value="<?php echo $edit_social_media->distid;?>">
                <input type="submit" value="Update" name="submit" id="butundisab" class="btn btn-sm btn-primary"
                    style="margin-top:32px;" />
            </div>
        </div>
    </form>

    <div class="col-md-12" style="padding-left: 0px;">


       
      
        <!---------------------- forms close here ------------------------------->
    </div>
    <!-- Add Event-->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Map Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
                        <input type="hidden" name="csrf_test_name"
                            value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Title: <span
                                            class="tx-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?php echo $all[0]->title ?>" Placeholder="Enter Title Name" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Link: <span
                                            class="tx-danger">*</span></label>
                                    <input type="text" name="link" class="form-control"
                                        value="<?php echo $all[0]->link ?>" Placeholder="Enter Link" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Map Image: <span
                                            class="tx-danger"></span></label>
                                    <input type="file" name="file" class="form-control" value=""
                                        Placeholder="Map Image">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="email">Open Window <span
                                            class="tx-danger">*</span></label>
                                    <select class="form-control" id="open" name="open">
                                        <option value="1" <?php if($all[0]->open == '1') {echo 'selected';} ?>>Same
                                            Window</option>
                                        <option value="2" <?php if($all[0]->open == '2') {echo 'selected';} ?>>Other
                                            Window</option>
                                    </select>
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

<!-- Add Modal video-->

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