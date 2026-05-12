
<div class="sh-pagebody">
	<div class="col-md-12" style="padding-left: 0px;">
		<h2 class="text-center">Edit Team Member Details</h2>
		<div class="text-center1">
			<form   method="POST" action="<?= site_url('TestimonialsController/updateTestimonials'); ?>"  enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
				<input type="hidden" name="team_id" value="<?php echo $dtl->id ?>" class="form-control">
				<input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
				<!-- custom one-time nonce -->
				<input type="hidden" name="form_nonce" value="<?= $form_nonce; ?>">
				<div class="row">
					<input type="hidden" name="category" class="form-control" value="2">
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="des1">Name: <span class="tx-danger">*</span></label>
						<input type="text" name="des" id="des" class="form-control" value="<?php echo $dtl->des ?>"  data-type="spnamesnrols" onkeyup="funInputFielTypes(this)" required>
						<div id="desX" style="font-size:10px;color:red;"></div>
					  </div>
					</div>
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="des_mr1">NameMR: <span class="tx-danger">*</span></label>
						<input type="text" name="des_mr" id="des_mr" class="form-control" value="<?php echo $dtl->des_mr ?>"  data-type="spnamesnrols" onkeyup="funInputFielTypes(this)" required>
						<div id="des_mrX" style="font-size:10px;color:red;"></div>
					  </div>
					</div>
				   
					<div class="col-md-6">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="text1_mr1">Role: <span class="tx-danger">*</span></label>
						<input type="text" name="text1" id="text1" class="form-control" value="<?php echo $dtl->text1 ?>"  data-type="spnamesnrols" onkeyup="funInputFielTypes(this)" required>
						<div id="text1X" style="font-size:10px;color:red;"></div>
					  </div>
					</div>				   
					<div class="col-md-6">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="text1_mr1">RoleMR: <span class="tx-danger">*</span></label>
						<input type="text" name="text1_mr" id="text1_mr" class="form-control" value="<?php echo $dtl->text1 ?>"  data-type="spnamesnrols" onkeyup="funInputFielTypes(this)" required>
						<div id="text1_mrX" style="font-size:10px;color:red;"></div>
					  </div>
					</div>
					
					<div class="col-md-3">
					  <div class="form-group">
						<label class="control-label col-sm-12" for="email">File: <span class="tx-danger">*</span></label>
						<input type="file" name="file" id="file" class="form-control mytext" accept="image/*"  data-type="image" onchange="funInputFielTypes(this)">
					  <div id="fileX" style="font-size:10px;color:red;"></div>
					  </div>
					</div>
					<div class="col-md-3">
					  <div class="form-group">
						  <label class="control-label col-sm-12" for="email">Image: <?php echo $dtl->file; ?><span class="tx-danger"></span></label>
						<img height="80px" src="<?php echo base_url() ?>../assets/cdma/testimonials/<?php echo $dtl->file; ?>" alt="img">
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
					  <button type="submit" name="update" value="Update" class="btn btn-success" id="submitBtn" disabled123 >Update</button>
					 <!--  <a href="<?php // echo base_url() ?>team-details" class="btn btn-danger">Cancel</a> -->
				   </div>
				</div>					
			</form>
		</div>
	</div>
	
	<!---------------------- forms close here ------------------------------->
</div>
    <!-- Add Modal text-->
    

