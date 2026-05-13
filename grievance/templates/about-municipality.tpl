{include file='header.tpl'}
{literal}
<style>
	.sidebar .menu li a {
		text-decoration: none !important;
	}
</style>
<script>
	function validateForm() {


		description = $("#description").val();

		if (description == '') {
			alert("Please Enter Description");
			return false;
		} else {
			return true;
		}



	}


	function fill(cat_id, descriptin, dept_id) {

		document.add_category.cat_id.value = cat_id;
		document.add_category.description.value = descriptin;
		document.add_category.type.value = 1;
		$("#dept_id").val(dept_id);

	}
</script>
{/literal}

<div class="row ">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>ABOUT MUNICIPALITY DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form name='add_category' method='POST' action='about-municipality.php' class="form-horizontal">
					<input type="hidden" name="token" value="{$token_id}" />
					<div class="form-body">
						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}

						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">English</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Marathi</button>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
								<div class="form-group">
									<div class="col-md-12">
										<textarea class="wysihtml5 form-control" rows="10" name="description" id="description" placeholder="Enter Description" autocomplete="off"  data-type="spcontent" onkeyup="funInputFielTypes(this)" required>{$description}</textarea>
									<div style="font-size:10px;color:red;" id="descriptionX"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<textarea class="wysihtml5 form-control" rows="10" name="desc2" id="desc2" placeholder="Enter Description" autocomplete="off"  data-type="spcontent" onkeyup="funInputFielTypes(this)" required>{$administrative_desc}</textarea>
									<div style="font-size:10px;color:red;" id="desc2X"></div>
									</div>
								</div>
							</div>
							<!-- <div class="tab-pane" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
								<div class="form-group">
									<div class="col-md-12">
										<textarea class="wysihtml5 form-control" rows="10" name="description_marathi" id="description_marathi" placeholder="Enter Mararthi Description" autocomplete="off" data-type="spcontent" onkeyup="funInputFielTypes(this)" required>{$description_marathi}</textarea>
									<div style="font-size:10px;color:red;" id="description_marathiX"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<textarea class="wysihtml5 form-control" rows="10" name="desc2_marathi" id="desc2_marathi" placeholder="Enter Mararthi Description" autocomplete="off" data-type="spcontent" onkeyup="funInputFielTypes(this)" required>{$administrative_desc_marathi}</textarea>
									<div style="font-size:10px;color:red;" id="ddesc2_marathiX"></div>
									</div>
								</div>
							</div> -->
						</div>
					</div>

					<div class="form-actions fluid">
						<!-- <div class="col-md-offset-3 col-md-9"> -->
						<div align="center">
							<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward' id="submitBtn" disabled>Update</button>
							<button type="reset" class="btn btn-danger">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>


{include file='footer_print.tpl'}
{include file='footer.tpl'}
