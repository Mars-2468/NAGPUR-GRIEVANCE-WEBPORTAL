
<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <h2 class="text-center">Edit Important Link Details</h2>
        <div class="text-center1">
			<form action="<?php echo base_url('ImpLinksController/updateImpLinkRecord') ?>" method="post" name="add" enctype="multipart/form-data" style="padding: 15px; border: 2px solid">
                <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
                 <!-- custom one-time nonce -->
				<input type="hidden" name="form_nonce" value="<?= $form_nonce; ?>">
				<input type="hidden" name="id" value="<?php echo $dtl->id; ?>" class="form-control">
                <div class="row">
                    
					<div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-sm-12" for="logo4">Title: <span class="tx-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control mytext" value="<?php echo $dtl->title ?>" data-type="text" onkeyup="funInputFielTypes(this)" required>
						<span id="titleX" style="font-size:10px;color:red;"></span>
					 </div>
                    </div>
					
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-sm-12" for="logo3">Description: <span class="tx-danger">*</span></label>
                        <input type="text" name="des" id="des" class="form-control mytext" value="<?php echo $dtl->des ?>" data-type="text" onkeyup="funInputFielTypes(this)" required>
                        <span id="desX" style="font-size:10px;color:red;"></span>
					  </div>
                    </div>
                   
           
				   <div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-3" for="logo2">LinkUrl: <span class="tx-danger">*</span></label>
						<input type="text" name="linkurl" id="linkurl" class="form-control mytext" value="<?php echo $dtl->url ?>" data-type="url" onkeyup="funInputFielTypes(this)" required>
						<span id="linkurlX" style="font-size:10px;color:red;"></span>
					  </div>
				   </div> 
				    <div class="col-md-12">
					  <div class="form-group">
						<label class="control-label col-sm-3" for="logo1">Logo: <span class="tx-danger"></span></label>
						<input type="file" name="logo" id="logo" class="form-control mytext" data-type="image" onchange="funInputFielTypes(this)" accept="image/jpeg, image/jpg, image/png" >
						<span id="logoX" style="font-size:10px;color:red;"></span>
					  </div>
					  
					  <img src="<?php echo base_url().$dtl->logo ;?>" alt="<?php echo $dtl->title;?>" style="width:150px;height:150px;" />
				   </div> 
			   
					<?php $languages=[''=>'Select',1=>'English',2=>'Marathi']; ?>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-3" for="email">Language: <span class="tx-danger">*</span></label>
							<select name="lang_id" id="lang_id" class="form-control mytext" required>
								<?php foreach($languages as $key=>$value)
								{ if($dtl->lang_id==$key){ ?>
								<option value="<?php echo $dtl->lang_id; ?>" selected><?php echo $value; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>						
								<?php } } ?>
							</select>
						</div>
					</div>
                </div>
                <div class="row">
                   <div class="col-md-12 text-center">
                      <input type="submit" name="updateimplinks" id="submitBtn" value="Update" class="btn btn-success" disabled>
                      <a href="<?php echo base_url() ?>imp-links" class="btn btn-danger">Cancel</a>
                   </div>
                </div>
            </form>
		</div>
	</div>
	<!---------------------- forms close here ------------------------------->
</div>
    <!-- Add Modal text-->
    

