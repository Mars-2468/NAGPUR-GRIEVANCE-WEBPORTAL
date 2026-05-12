<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>

	
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <h2 class="text-center">Add Encroachment Queries Details</h2>
        <div class="text-center1">
			<form action="<?php echo base_url();?>EncroachmentQueriesController/saveRecord" method="post" name="add" enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                
                <div class="row">
				
					<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="lang">Zonal Offices/Departments: <span class="tx-danger">*</span></label>
                        <select name="main_menu_id" id="main_menu_id" class="form-control mytext" required>
							<option value="">-- select --</option>
							<?php foreach($zones_departments_list as $key=>$value){ ?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
                  </div>
				</div> 
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="lang">Zonal Office/Department: <span class="tx-danger">*</span></label>
                        <select name="zonal_dept_id" id="zonal_dept_id" class="form-control mytext" required>
							<option value="">-- select --</option>							
						</select>
                  </div>
				</div>   
				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Show Cause Notice: <span class="tx-danger">*</span></label>
                    <input type="file" name="show_cause_notice" id="show_cause_notice" class="form-control mytext"  data-type="imfile" onchange="funInputFielTypes(this)" accept="image/jpeg, image/jpg, image/png, application/pdf" >
					<div style="font-size:10px;color:red;" id="show_cause_noticeX"></div>
				  </div>
				</div> 	
				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Applicant Reply: <span class="tx-danger">*</span></label>
                    <input type="file" name="applicant_reply" id="applicant_reply" class="form-control mytext" data-type="imfile" onchange="funInputFielTypes(this)" accept="image/jpeg, image/jpg, image/png, application/pdf" >
					<div style="font-size:10px;color:red;" id="applicant_replyX"></div>
				  </div>
				</div> 	
				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Answer: <span class="tx-danger">*</span></label>
                    <input type="file" name="answer" id="answer" class="form-control mytext" data-type="imfile" onchange="funInputFielTypes(this)" accept="image/jpeg, image/jpg, image/png, application/pdf" >
                  <div style="font-size:10px;color:red;" id="answerX"></div>
				  </div>
				</div> 				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="description1">Description: <span class="tx-danger">*</span></label>
                    <textarea name="description" id="description" rows="3" class="form-control mytext" data-type="text" onkeyup="funInputFielTypes(this)" > </textarea>
                   <div style="font-size:10px;color:red;" id="descriptionX"></div>
				  </div>
				</div> 
				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Language: <span class="tx-danger">*</span></label>
                        <select name="lang_id" id="lang_id" class="form-control mytext" required>
							<option value="">-- select--</option>
							<option value="1">English</option>
							<option value="2">Marathi</option>
						</select>
                  </div>
				</div>

            </div>
          
			
                   <div class="col-md-12 text-center">
                      <input type="submit" name="submitencroachmentqueries" id="submitBtn" disabled value="Submit" class="btn btn-success">
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
		//alert(zoneDeptID);
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