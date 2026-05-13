{include file='header.tpl'}
{literal}
<script>
	function validateForm1() {			
			
		var fileInput1 = $('#f1')[0].files[0];
		var fileInput2 = $('#f2')[0].files[0];
		
        var errorMessage1 = $('#errorMessage1');
        var errorMessage2 = $('#errorMessage2');
       
        // Allowed file types (you can modify this based on your needs)
		
        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        var maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
		
    //alert(allowedTypes.includes(fileInput1.type));
	
        // Clear previous error and preview
        errorMessage1.text('');
        errorMessage2.text('');
       		
		if(!allowedTypes.includes(fileInput1.type)) {
            errorMessage1.text('Invalid file type. Allowed types are JPG, PNG,JPEG, and PDF.');
            return false;
        }else if(fileInput1.size > maxFileSize) {
            errorMessage1.text('File size exceeds the 2MB limit.');
            return false;
        } else if(!allowedTypes.includes(fileInput2.type)) {
            errorMessage2.text('Invalid file type. Allowed types are JPG, PNG,JPEG, and PDF.');
            return false;
        }else if(fileInput2.size > maxFileSize) {
            errorMessage2.text('File size exceeds the 2MB limit.');
            return false;
        } else {
			return true;
		}		
		
	}
</script>	
{/literal}


<div class="row">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>UPDATE COMMISSIONER CONTACT DETAILS</h4>
			</div>		
			<div class="inner no-radius">
			
			{if $flash}
				<div class="{$flash.class}">
				<button class="close" data-close="alert"></button>
					{$flash.msg}
				</div>
			{/if}
			
				<form name='' method='POST' action='update_comm_contact.php' class="form-horizontal" onSubmit="return validateForm12)"  enctype="multipart/form-data">
					<input type="hidden" name="token" value="{$token_id}" />

					<input type='hidden' name='previous_image' value="{$data.file_url}">
					<input type='hidden' name='previous_image' value="{$data.file_url}">
					<input type='hidden' name='id' value="{$data.id}">

					<input type='hidden' name='previous_building_image' value="{$data.officebuilding}">

					<div class="form-group">						
						<label class="control-label col-md-4">HO/ Ward Office Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input name="comm_name" type="text" id="comm_name" data-required="1" class="form-control" value="{$data.comm_name}" placeholder="Enter HO/ Ward Office Name" autocomplete="off" data-type="text" onkeyup="funInputFielTypes(this)" required="required">
							<div style="font-size:10px;color:red;" id="comm_nameX"></div>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Name In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input name="comm_name_marathi" type="text" id="comm_name_marathi" data-required="1" class="form-control" value="{$data.comm_name_marathi}" placeholder="Enter Name In Marathi" autocomplete="off" data-type="text" onkeyup="funInputFielTypes(this)" required="required">
							<div style="font-size:10px;color:red;" id="comm_name_marathiX"></div>
						</div>
					</div>
					<div class="form-group">						
						<label class="control-label col-md-4">Mobile Number <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input name="mobile" type="text" id="mobile1" class="form-control int1 num" value="{$data.mobile}" onblur="validation2()" placeholder="Enter Mobile Number" autocomplete="off" data-type="mobile1" onkeyup="funInputFielTypes2(this)" />
							<div style="font-size:10px;color:red;" id="mobileX"></div>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Select Department <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<select name="user_type" class="form-control" autocomplete="off" required="required">
								<option selected disabled>-- Select Designation --</option>
								{foreach from=$departments key=des item=department}
									<option value="{$department.id}" {if $data.user_type eq $department.id} selected {/if}>{$department.title}</option>
								{/foreach}
							</select>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Designation Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input name="designation" type="text" data-required="1" class="form-control" value="{$data.designation}" placeholder="Enter Designation Name" autocomplete="off" data-type="text" onkeyup="funInputFielTypes(this)" required="required" />
							<div style="font-size:10px;color:red;" id="designationX"></div>
						</div>
					</div>	

					<div class="form-group">						
						<label class="control-label col-md-4">Upload Photo <span class="required" style="color:red">  </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input name='f1' class="form-control" id='f1' type="file"  autocomplete="off" data-type="image1" onchange="funInputFielTypes1(this)"  />
							<div style="font-size:10px;color:red;" id="f1X"></div>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Previous Photo <span class="required" style="color:red">  </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<img id="img1Preview" src='{if $data.file_url eq ''}default-user.png{else} {$data.file_url} {/if}' width="75px" height="75px" autocomplete="off" required="required">
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Email ID <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input type="email" id="email" name="email" class="form-control" value="{$data.email}" placeholder="Enter Email ID" data-type="email2" onkeyup="funInputFielTypes2(this)" autocomplete="off" />
							<div style="font-size:10px;color:red;" id="emailX"></div>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Land Line <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input type="text" id="land_line" name="land_line"  class="form-control" value="{$data.land_line}" placeholder="Enter Land Line" data-type="landline2" onkeyup="funInputFielTypes2(this)" autocomplete="off" />
							<div style="font-size:10px;color:red;" id="land_lineX"></div>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Fax <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input type="text" id="fax" name="fax" class="form-control" value="{$data.fax}" placeholder="Enter Fax" data-type="fax2" onkeyup="funInputFielTypes2(this)" autocomplete="off" />
							<div style="font-size:10px;color:red;" id="faxX"></div>
						</div>
					</div>

					<div class="form-group">					
						<label class="control-label col-md-4">Address <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<!-- <textarea class="form-control" name="address">{$data[$k].address}</textarea> -->
							<textarea name='address' id='address' rows="2" cols="50" class="form-control" placeholder="Enter Address" data-type="address" onkeyup="funInputFielTypes(this)" autocomplete="off">{$data.address}</textarea>
							<div style="font-size:10px;color:red;" id="addressX"></div>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Address In Marathi <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<!-- <textarea class="form-control" name="address_marathi">{$data[$k].address_marathi}</textarea> -->
							<textarea name='address_marathi' id='address_marathi' rows="2" cols="50"  class="form-control" placeholder="Enter Address In Marathi" data-type="address" onkeyup="funInputFielTypes(this)" autocomplete="off">{$data.address_marathi}</textarea>
							<div style="font-size:10px;color:red;" id="address_marathiX"></div>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Map Link <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<!-- <textarea class="form-control" name="link">{$data[$k].link}</textarea> -->
							<textarea name='link' id='link' rows="2" cols="50" class="form-control" placeholder="Enter Map Link" data-type="url2" onkeyup="funInputFielTypes2(this)" autocomplete="off">{$data.link}</textarea>
							<div style="font-size:10px;color:red;" id="linkiX"></div>
						</div>
					</div>

					<div class="form-group">						
						<label class="control-label col-md-4">Office Building Photo <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input name='f2' class="form-control" id='f2' type="file" data-type="image2" onkeyup="funInputFielTypes2(this)" autocomplete="off" />
							<div style="font-size:10px;color:red;" id="f2X"></div>
						</div>
					</div>

					<div class="form-group">					
						<label class="control-label col-md-4">Previous Office Building Photo <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<img id="img2Preview" src='{if $data.officebuilding eq ''}default-img.png{else} {$data.officebuilding} {/if}' width="75px" height="75px" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group">						
						<label class="control-label col-md-4">Priority<span class="required" style="color:red"></span> <span style="margin-left:10px;"> : </span> </label>
						<div class="col-md-4">
							<input name="sortorder" type="text" id="sortorder" class="form-control" value="{$data.sortorder}" placeholder="Enter the priority number" autocomplete="off" data-type="text2" onkeyup="funInputFielTypes2(this)" >
							<div style="font-size:10px;color:red;" id="sortorderX"></div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
							<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward' id="submitBtn" disabled123>Update</button>
							<!-- <button type="reset" class="btn btn-danger">Cancel</button> -->
							<a href="comm_contact.php" class="btn btn-danger">Back</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
{include file='footer.tpl'}
{literal}
<script>
document.getElementById('f1').addEventListener('change', function() {
    let input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let preview = document.getElementById('img1Preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
});
document.getElementById('f2').addEventListener('change', function() {
    let input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let preview = document.getElementById('img2Preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}); 
</script>

{/literal}