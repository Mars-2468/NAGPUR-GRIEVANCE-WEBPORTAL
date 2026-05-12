<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	
	
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <h2 class="text-center">Edit Encroachment Queries Details</h2>
        <div class="text-center1">
			<form action="<?php echo base_url();?>EncroachmentQueriesController/updateRecord" method="post" name="add" enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                <input type="hidden" name="id" value="<?php echo $dtl->id; ?>" class="form-control">
                <input type="hidden" name="main_menu_id" value="<?php echo $dtl->main_menu_id; ?>" class="form-control">
                <input type="hidden" name="zonal_dept_id" value="<?php echo $dtl->page_id; ?>" class="form-control">
                <div class="row">
                    
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="lang">Zonal Offices/Departments:<span class="tx-danger">*</span></label>
													
							<input type="text"  class="form-control mytext" value="<?php echo $zones_departments_list[$dtl->main_menu_id]; ?>" readonly required>
							
					  </div>
					</div> 
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="lang">Zonal Office/Department: <span class="tx-danger">*</span></label>
					
									<input type="text" class="form-control mytext" value="<?php echo $zones_departments_arraylist[$dtl->page_id]; ?>" readonly required>
					
					  </div>
					</div> 
          
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-12" for="email">Show Cause Notice: <span class="tx-danger">*</span></label>
							<input type="file" name="show_cause_notice" class="form-control mytext" accept="image/jpeg, image/jpg, image/png, application/pdf" >
						</div>
						<?php  $extension = pathinfo($dtl->show_cause_notice, PATHINFO_EXTENSION); 
							if($extension=='pdf'){
						?>
							<iframe src="<?php echo base_url().$dtl->show_cause_notice ;?>" 
									width="50%" height="200px" style="border: none;">
							</iframe>
						<?php }else{ ?>
							<img src="<?php echo base_url().$dtl->show_cause_notice ;?>" alt="<?php echo $dtl->show_cause_notice;?>" style="width:150px;height:150px;" />
						<?php } ?>
					</div> 	
					
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="email">Applicant Reply: <span class="tx-danger">*</span></label>
						<input type="file" name="applicant_reply" class="form-control mytext" accept="image/jpeg, image/jpg, image/png, application/pdf" >
					  </div>
						<?php  $extension = pathinfo($dtl->applicant_reply, PATHINFO_EXTENSION); 
							if($extension=='pdf'){
						?>
							<iframe src="<?php echo base_url().$dtl->applicant_reply ;?>" 
									width="50%" height="200px" style="border: none;">
							</iframe>
						<?php }else{ ?>
							<img src="<?php echo base_url().$dtl->applicant_reply ;?>" alt="<?php echo $dtl->applicant_reply;?>" style="width:150px;height:150px;" />
						<?php } ?>					
					</div> 	
					
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="email">Answer: <span class="tx-danger">*</span></label>
						<input type="file" name="answer" class="form-control mytext" accept="image/jpeg, image/jpg, image/png, application/pdf" >
					  </div>
						<?php  $extension = pathinfo($dtl->answer, PATHINFO_EXTENSION); 
							if($extension=='pdf'){
						?>
							<iframe src="<?php echo base_url().$dtl->answer ;?>" 
									width="50%" height="200px" style="border: none;">
							</iframe>
						<?php }else{ ?>
							<img src="<?php echo base_url().$dtl->answer;?>" alt="<?php echo $dtl->answer;?>" style="width:150px;height:150px;" />
						<?php } ?>	
					</div> 	
					
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="email">Description: <span class="tx-danger">*</span></label>
						<textarea name="description" rows="3" class="form-control mytext" ><?php echo $dtl->description; ?> </textarea>
                 	  </div>
						
					</div> 
					
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="email">Language: <span class="tx-danger">*</span></label>
							<select name="lang_id" id="lang_id" class="form-control mytext" required>
								<?php foreach($languages as $key=>$value)
								{ if($dtl->lang_id==$key){ ?>
								<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>						
								<?php } } ?>
							</select>
					  </div>
					</div>
                </div>
                <div class="row">
                   <div class="col-md-12 text-center">
                      <input type="submit" name="updateencroachmentqueries" id="updateencroachmentqueries" value="Update" class="btn btn-success">
                      <a href="<?php echo base_url() ?>encroachment-queries" class="btn btn-danger">Cancel</a>
                   </div>
                </div>
            </form>
		</div>
	</div>
	<!---------------------- forms close here ------------------------------->
</div>
    <!-- Add Modal text-->
    
<script>
var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
    $('#main_menu_id').on('change', function() {
        var zoneDeptID = $(this).val();
		alert(zoneDeptID);
        $.ajax({
            url: '<?php echo base_url("UserController/get_zonal_or_depts"); ?>',
            type: 'POST',
            data: { main_menu_id: zoneDeptID, [csrfName]: csrfHash  },
            dataType: 'json',
            success: function(data) {
                $('#zonal_dept_id').empty().append('<option value="">Select Zonal Office or Deparement</option>');
                $.each(data, function(key, value) {
                    $('#zonal_dept_id').append('<option value="'+ value.page_id +'">'+ value.sub_menu_desc +'</option>');
                });
            },
			error: function(xhr, status, error) {
				console.error("AJAX Error:", error); // See if there's a server-side error
			}
        });
    });
</script>