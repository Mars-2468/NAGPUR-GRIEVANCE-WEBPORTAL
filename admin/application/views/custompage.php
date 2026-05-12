<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 0);
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>

<script src="<?php echo base_url() ?>assets/editors2/jquery.tinymce.min.js"></script>
<script src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
<script src="<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>

<script>


	tinymce.init({
		//selector: "textarea#default",theme: "modern",width: 850,height: 500,
		selector: "textarea#content_new",
		theme: "modern",
		height: 500,
		theme: "modern",
		// width: 680,
		// height: 200,
		relative_urls: true,
		//remove_script_host: true,
		// document_base_url: BASE_URL,
		plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
			"table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
		],
		toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
		toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
		image_advtab: true,

	});


	tinymce.init({
		selector: "#richTextArea",
		theme: "modern",
		width: 710,
		height: 500,

		theme: "modern",		
		relative_urls: true,	
		plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
			"table contextmenu directionality emoticons paste textcolor responsivefilemanager code autolink"
		],
		toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
		toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
		image_advtab: true,

		/*external_filemanager_path: BASE_URL + "filemanager/",
		filemanager_title: "Media Gallery",
		external_plugins: {"filemanager": BASE_URL + "filemanager/plugin.min.js"},*/


	});
</script>

<style>
	#mceu_59-t0,
	#mceu_66-t0,
	#mceu_58-t0 {
		display: none;
	}

	#mceu_47 #mceu_22 {
		display: none;
	}

	#mceu_43 {
		display: none;
	}

	#mceu_17 {
		display: none;
	}

	#mceu_34 {
		display: none;
	}

	.panel-body {
		padding: 10px;
	}

	.mycalender i {
		position: absolute;
		left: 8px;
		top: 6px;
		pointer-events: none;
		font-size: 1.5em;
		cursor: pointer;
	}

	.mycalender {
		position: relative;
	}


	.add-on .input-group-btn>.btn {
		border-left-width: 0;
		left: -2px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
	}

	/* stop the glowing blue shadow */
	.add-on .form-control:focus {
		box-shadow: none;
		-webkit-box-shadow: none;
		border-color: #cccccc;
	}



	.bootstrap-tagsinput {
		background-color: #fff;
		border: 1px solid #ccc;
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		/*display: inline-block;*/
		padding: 4px 6px;
		color: #555;
		vertical-align: middle;
		border-radius: 0px;
		max-width: 100%;
		line-height: 22px;
		cursor: text;
	}

	.bootstrap-tagsinput input {
		border: none;
		box-shadow: none;
		outline: none;
		background-color: transparent;
		padding: 0 6px;
		margin: 0;
		width: auto;
		max-width: inherit;
	}

	.bootstrap-tagsinput.form-control input::-moz-placeholder {
		color: #777;
		opacity: 1;
	}

	.bootstrap-tagsinput.form-control input:-ms-input-placeholder {
		color: #777;
	}

	.bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
		color: #777;
	}

	.bootstrap-tagsinput input:focus {
		border: none;
		box-shadow: none;
	}

	.bootstrap-tagsinput .tag {
		margin-right: 2px;
		color: white;
	}

	.bootstrap-tagsinput .tag [data-role="remove"] {
		margin-left: 8px;
		cursor: pointer;
	}

	.bootstrap-tagsinput .tag [data-role="remove"]:after {
		content: "x";
		padding: 0px 2px;
	}

	.bootstrap-tagsinput .tag [data-role="remove"]:hover {
		box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
	}

	.bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
		box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
	}


	.bootstrap-tagsinput .label {
		font-size: 13px;
		font-weight: normal;
	}

	.bootstrap-tagsinput .tag [data-role="remove"] {

		opacity: 1;
	}

	.bootstrap-tagsinput .tag [data-role="remove"]::after {

		font-family: arial;
	}



	.snip1550 {
		position: relative;
		display: inline-block;
		overflow: hidden;
		margin: 6px -10px !important;
		min-width: 176px;
		max-width: 175px;
		width: 100%;
		font-size: 16px;
		line-height: 1.2em;
	}




	.icon {
		height: 127px;
		border: 1px #dfdfdf solid;
		background-color: #efefef;
	}


	.icon i {
		display: table-cell;
		font-size: 30px;
		vertical-align: middle;
		color: #000;
		padding-top: 44px;
		padding-left: 60px;
		padding-bottom: 49px;
		text-align: center;
	}


	.input-group {
		padding-right: 15px !important;
		padding-left: 15px !important;
	}


	.form-control {
		border-radius: 0px !important;
	}

	.panel-title {
		font-size: 14px !important;
	}

	.modal-body {
		padding: 17px !important;
	}
</style>

<body>

	<div class="sh-pagebody">

		<?php if ($this->session->flashdata('message')) { ?>
			<div class="alert alert-success text-center">
				<?php echo $this->session->flashdata('message'); ?>
			</div>
		<?php } ?>
		<?php if ($this->session->flashdata('error_message')) { ?>
			<div class="alert alert-danger text-center">
				<?php echo $this->session->flashdata('error_message'); ?>
			</div>
		<?php } ?>

		<?php echo form_open_multipart('update-custome-page') ?>
		
		<input type="hidden" name="is_draft" id="is_draft" value="0">
		<div class="row">

			<div class="col-md-9">

				<div class="card bd-primary">

					<div class="card-header bg-primary tx-white">Edit Page / Post</div>

					<div class="card-body pd-sm-30">

						<div class="mypagetitile">

							<select name="lang_id" name="" id="" class="form-control tel_font">
								<option value="">-- select --</option>
								<option value="1" <?php if ($content[0]['langId'] == '1') {
														echo "selected";
													} ?>>English</option>
								<option value="2" <?php if ($content[0]['langId'] == '2') {
														echo "selected";
													} ?>>Marathi</option>
							</select>
						</div>

						<div class="mypagetitile">

							<input class="form-control tel_font" name="page_name" id="page_name" type="text" value="<?php echo $content[0]['page_name']; ?>"  data-type="text" onkeyup="funInputFielTypes(this)">
							 <div style="font-size:10px;color:red;" id="page_nameX"></div>
						</div>

						<div style="margin-top:8px;">Permalink:<?php echo $content[0]['page_id']; ?> - <span class="permlinks"><a href="<?php echo $ulb_base_url[$content[0]['ulbid']]['base_url']; ?><?php echo $content[0]['site_controller']; ?>" target="_blank"><?php echo $ulb_base_url[$content[0]['ulbid']]['base_url']; ?><?php echo $content[0]['site_controller']; ?></a></span>

							<input type="button" class="btn btn-outline-dark btn-sm" value="Edit" id="editbtn">

							<input id="editarea" style="display:none;" type="text" value="<?php echo $content[0]['controller']; ?>">

							<input id="donehide" style="display:none;" type="button" class="btn btn-default btn-xs" value="Done">

						</div>

						</br>
						<div class="mypagetitile">

							<input class="form-control tel_font" name="hover_title" id="hover_title" type="text" placeholder="hover title" value="<?php echo $content[0]['hover_title']; ?>"  data-type="text" onkeyup="funInputFielTypes(this)">
							<div style="font-size:10px;color:red;" id="hover_titleX"></div>
						</div>

						<hr>

						<div>
							<a class="btn btn-secondary btn-sm text-white" data-bs-toggle="modal" onclick="media()"><i class="fa fa-image"></i> Add Media </a>
						</div>

						<br>


						<?php
						if ($content[0]['content'] != '') {
							$replaceUrl = "/assets/";
							$content[0]['content'] = str_replace($replaceUrl, '../assets/', $content[0]['content']);
						}

						?>

						<input type="hidden" name="pageid" id="pageid" value="<?php echo $content[0]['page_id']; ?>">
						<input type="hidden" name="page" value="<?php echo $content[0]['controller']; ?>">
						<!--<textarea id="richTextArea" name="content" style="width:100%; height:400px;"><?php if ($content[0]['content'] != '') {
																												echo $content[0]['content'];
																											} ?></textarea>-->
						<div class="">
							
							<textarea id="content_new" name="content_new" style="width:100%; height:400px;" data-type="sptext22" onkeyup="funInputFielTypes22(this)"><?php echo $content[0]['content'] ?></textarea>
												 <div style="font-size:10px;color:red;" id="content_newX"></div>
						</div>
						<br>

						<div class="form-horizontal">

							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Related Tags:<span class="tx-danger">*</span> <br> <span style="font-size:12px;"> Separated by Space </span></label>

								<div class="col-sm-9">
									<input type="text" class="form-control mytext" placeholder="Ex (Sports, national , words , poltics)" name="ptags" id="ptags" data-role="tagsinput" value="<?php echo $content[0]['pagekeywords'] ?>"  data-type="text" onkeyup="funInputFielTypes(this)">
									<div style="font-size:10px;color:red;" id="ptagsX"></div>
								</div>

							</div>


							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Description: <span class="tx-danger">*</span> <br> </label>
								<div class="col-sm-9">
									<textarea rows="3" class="form-control mytext" placeholder="Enter Page Related Description here " name="meta_desc" id="meta_desc" required   data-type="sptext" onkeyup="funInputFielTypes(this)"><?php echo $content[0]['meta_desc'] ?></textarea>
									<div style="font-size:10px;color:red;" id="meta_descX"></div>

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3" for="email">Subject <span class="tx-danger">*</span> <br> </label>
								<div class="col-sm-9">
									<textarea rows="3" class="form-control mytext" placeholder="Enter Page subject here " name="meta_subject" id="meta_subject" required   data-type="sptext" onkeyup="funInputFielTypes(this)"><?php echo $content[0]['meta_subject'] ?></textarea>
									<div style="font-size:10px;color:red;" id="meta_subjectX"></div>
								</div>
							</div>
							<?php if(!empty($slider_data[0]['thumbnail_path'])) { ?>
									<div class="form-group">
										<label class="control-label col-sm-3" for="email">Photo <span class="tx-danger"></span> <br> </label>
										<div class="col-sm-9">
											<input type="file" class="form-control mytext" placeholder="upload photo" id="image_path" name="image_path" data-role="tagsinput" />
											<span class="myerror"><?php echo form_error('image_path'); ?> </span>
										</div>
									</div>

									<div class="form-group">
									<label class="control-label col-sm-3" for="email">Photo Preview <span class="tx-danger"></span> <br> </label>
										<div class="col-sm-9">
											<img src="<?php echo $slider_data[0]['thumbnail_path'] ?>"  style="width:100px;height:100px;" />
										</div>
									</div>
							<?php } ?>
						</div>

					</div>
				</div>

				<!-- form data here -->

				<?php
				$i = 1;
				foreach ($categories as $key => $val) {

					$arr[$key] = $val;


				?>

					<input type="hidden" name="category_id<?php echo $key; ?>" value="<?php echo $val; ?>">
					<input type="hidden" name="category_desc<?php echo $key; ?>" value="<?php echo $val; ?>">
					<input type="hidden" name="tbl<?php echo $key; ?>" value="<?php echo $tbls[$key]; ?>">
					<div style="display:none;" id="<?php echo $key; ?>" class="hidden_divs">

						<div class="card1 bd-primary mg-t-20">
<!--
							<div class="card-header bg-primary tx-white"><?php echo $val; ?> Details</div>
-->
							<div class="card-body1 pd-sm-30">

								<div class="form-horizontal">

									 <?php /* echo  $formcontent = "";
									foreach ($forms[$key] as $sno => $label) { 

										if ($label['type'] == "text") {
											$formcontent .= "<div class='form-group'>";
											$formcontent .= "<label class='col-md-5 control-label' for='" . $label['label'] . "'>" . $label['label'] . " <span class='tx-danger'>*</span></label>";
											$formcontent .= "<div class='col-md-6'>";
											$formcontent .= "<input id='" . $label['id'] . "' name='" . $label['name'] . $key . "' placeholder='" . $label['label'] . "' class='form-control input-md " . $label['class'] . " " . $key . "'  type='" . $label['type'] . "' value='" . $category_details[$key][0][$label['name']] . "'>";
											$formcontent .= "</div>";
											$formcontent .= "</div>";
										}
										if ($label['type'] == "file") {


											$ext = pathinfo($category_details[$key][0][$label['name']], PATHINFO_EXTENSION);
											$ext_array = array('jpg', 'png', 'gif', 'jpeg');
											if (in_array($ext, $ext_array)) {
												$file = "<img src='.." . $category_details[$key][0][$label['name']] . "' width='75px' height='75px'>";
											} else {
												$file = "<p>File Not Uploded</p>";
												// 	$file="<a href='".$this->session->userdata('base_url').$category_details[$key][0][$label['name']]."' target='_blank'>Download file</a>";
											}

											$formcontent .= "<div class='form-group'>";
											$formcontent .= "<label class='col-md-5 control-label' for='" . $label['label'] . "'>" . $label['label'] . " <span class='tx-danger'>*</span></label>";
											$formcontent .= "<div class='col-md-6'>";
											$formcontent .= "<input id='" . $label['id'] . "' name='" . $label['name'] . $key . "' placeholder='" . $label['label'] . "' class='form-control input-md " . $label['class'] . " " . $key . "'  type='" . $label['type'] . "' value='" . $category_details[$key][0][$label['name']] . "'>";
											$formcontent .= "</div>";
											$formcontent .= "</div>";

											$formcontent .= "<div class='form-group'>";
											$formcontent .= "<label class='col-md-5 control-label' for='" . $label['label'] . "'>" . $label['label'] . " Previous image </label>";
											$formcontent .= "<div class='col-md-6'>";
											$formcontent .= $file;
											$formcontent .= "<input type='hidden' name='prev" . $label['name'] . $key . "' value='" . $category_details[$key][0][$label['name']] . "'>";
											$formcontent .= "</div>";
											$formcontent .= "</div>";
										}
										if ($label['type'] == "select") {

											$select_string = "";
											$formcontent .= "<div class='form-group'>";
											$formcontent .= "<label class='col-md-5 control-label' for='" . $label['label'] . "'>" . $label['label'] . " <span class='tx-danger'>*</span> </label>";
											$formcontent .= "<div class='col-md-6'>";
											$formcontent .= "<select id='" . $label['id'] . "' name='" . $label['name'] . $key . "'  class='form-control input-md " . $label['class'] . " " . $val->category_id . "'>";
											$formcontent .= "<option value='0'>---select---</option>";
											foreach ($select_options[$sno] as $option_id => $option_value) {


												if ($option_id == $category_details[$key][0][$label['name']]) {
													$select_string = "selected";
												} else {
													$select_string = "";
												}
												$formcontent .= "<option value='" . $option_id . "' " . $select_string . ">" . $option_value['option_desc'] . "</option>";
											}

											$formcontent .= "</select>";
											$formcontent .= "</div>";
											$formcontent .= "</div>";
										}
									}
									echo $formcontent; */ ?>


								</div>

							</div>

						</div>

					</div>

				<?php $i++;
				} ?>


				<!-- close here -->




			</div>





			<div class="col-md-3" style="padding-right: 0px; padding-left: 0px;">

				<div class=" " id="accordion">


					<div class="card" style="margin-bottom:15px;">
						<div class="card-header">
							Publish
						</div>
						<div id="publish" class="collapse show" data-bs-parent="#accordion">
							<div class="card-body">
								<center>
									<input type="submit" name="save" value="Save to Draft" class="btn btn-primary btn-sm" id="draft" onclick="go_draft()" disabled>
									<input type="submit" name="save" value="Publish" id="submitBtn" disabled1 class="btn btn-success btn-sm">
								</center>
							</div>


						</div>
					</div>

					<!--------------- inner page layouts---->

					<div class="card">
						<div class="card-header">
							Page Attributes
						</div>
						<div id="layouts" class="collapse show" data-bs-parent="#accordion">
							<div class="card-body">

								<div class="form-group">
									<label>Select layout</label>
									<select class="form-select" id="sel1" name="layoutid">
										<?php $string = "";
										foreach ($layoutlists as $key => $val) {
											if ($content[0]['page_sidebars_id'] == $key) {
												$string = "selected";
											} else {
												$string = "";
											}


										?>
											<option value="<?php echo $key; ?>" <?php echo $string; ?>><?php echo $val; ?></option>

										<?php } ?>
									</select>
								</div>

							</div>
							<?php
							if ($content[0]['is_target_blank'] == 2) {
								$checked = "checked";
							} else {
								$checked = "";
							}
							?>

							<div class="panel-body">
								<label class="ckbox" style="font-size:13px;">
									<input type="checkbox" id="target" name="is_target_blank" value="2" <?php echo $checked; ?>><span>Open link in a new window / Tab</span>
								</label>
							</div>
						</div>
					</div>


					<!---- close----->



					<?php

					if ($content[0]['is_custumlink'] == '2') { ?>

						<div class="panel panel-default">
							<div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#aboutus">
								<h4 class="panel-title"><strong> Categories </strong><i class="fa fa-chevron-up pull-right"></i></h4>
							</div>
							<div id="aboutus" class="">
								<div class="panel-body">

									<?php $i = 1;
									foreach ($arr as $key => $val) {



									?>
										<label class="ckbox" style="width:100%;">

											<!--17-04-24 <input type="checkbox" value="<?php echo $key; ?>" class="chkcat" name="categories[]" onclick="fun1();" <?php echo $categories_selcted[$key]['checked']; ?>><span><?php echo $val; ?>...</span><br> -->
											<input type="checkbox" value="<?php echo $key; ?>" class="chkcat" name="categories[]" onclick="fun1();" <?php echo $categories_selcted[$key]['checked']; ?>><span><?php echo $val; ?></span><br>
										</label>

									<?php $i++;
									} ?>

								</div>
							</div>
						</div>
					<?php } ?>


				</div>


			</div>










		</div>


		<hr>


		<!--<h2>About Municipality</h2>-->




	<?php echo form_close(); ?>








	</div>






	<script>
		$(document).ready(function() {
			$(".datepicker").datepicker({
				minDate: '0'
			});


			$("#enableDate").click(function() {
				var enableDateStatus = $("#enableDateStatus").val();


				$("#period").toggle();
			});


			$("#datepickerfrom").datepicker({
				changeMonth: true,
				changeYear: true,
				minDate: 0,
				dateFormat: 'dd-mm-yy',
				onSelect: function(selectedDate) {
					$("#datepickerto").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#datepickerto").datepicker({
				changeMonth: true,
				changeYear: true,
				minDate: 0,
				dateFormat: 'dd-mm-yy',
				onSelect: function(selectedDate) {
					$("#datepickerfrom").datepicker("option", "maxDate", selectedDate);
				}
			});




			$("#getcatform").click(function() {
				/* var category_id=$("#category_id").val();
					$.post('CreatePostController/getTenderForm',{category_id:category_id},function(data)
					{
					$("#result").html(data);
				});*/

				$("#category_form").submit();


			});


			fun1();


		});

		function fun1() {
			$(".hidden_divs").css('display', 'none');
			$(".reqclass").removeClass('mytext');
			$("input[type=checkbox]:checked").each(function(i) {

				$("#" + $(this).val()).css('display', 'block');
				$("." + $(this).val()).addClass('mytext');




			});
		}
	</script>


	<script language='javascript'>
		$(document).ready(function() {
			$("#donehide").click(function() {
				var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';

				var pagename = $("#editarea").val();
				var pageid = $("#pageid").val();


				if (pagename === '') {
					alert('Please enter text');
					return false;

				}


				$.post('<?php echo base_url(); ?>/CustomePageController/updatePagename', {
					pagename: pagename,
					pageid: pageid,
					'csrf_test_name': csrf_value
				}, function(data) {

					$("#editarea").css('display', 'none');
					$("#editbtn").css('display', '-webkit-inline-box');

					alert('updated successfully');
					window.location = data;
				});

			});
		});
	</script>

	<script>
		function go_draft() {

			$("#is_draft").val('1');
			$("#category_form").find('[type="submit"]').trigger('click');
			//$("#category_form").find('[type="button"]').trigger('click');
			//$("#category_form").submit();
		}
	</script>