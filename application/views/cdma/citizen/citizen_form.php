<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>7 Star Citizen </title>
	<?php include('includes/styles.php'); ?>

</head>

<body class="sb-nav-fixed">
	<?php include('includes/navbar.php'); ?>

	<div id="layoutSidenav">


		<?php include('includes/sidemenu.php'); ?>
		<div id="layoutSidenav_content">
			<main>
				<div class="container-fluid px-4">
					<h3 class="mt-4"> Citizen Form</h3>

					<!-- <?php if (isset($error) && !empty($error)) : ?>
						<div class="alert alert-danger" role="alert">
							<?php echo $error; ?>
						</div>
					<?php endif; ?> -->
					<?php
					// Check if the 'success' flashdata is set
					if ($this->session->flashdata('success')) {
						echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
					}

					// Check if the 'error' flashdata is set
					if ($this->session->flashdata('error')) {
						echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
					}
					?>


					<div class="card mb-4 mt-4">
						<div class="card-header">
							<!--<i class="fas fa-file me-1"></i>-->

						</div>

						<div class="card-body">
							<form name="" method="POST" action="<?php echo base_url(); ?>citizen/store" enctype="multipart/form-data">

								<div class="row">
									<div class="col-md-4">
										<div class="mb-3 mt-3">
											<label for="applicant_name" class="form-label">Name of the applicant <span class="error">*</span></label>
											<div class="input-group">
												<span class="input-group-text"><i class="fa fa-user"></i></span>
												<input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter Name of the applicant" value="<?= set_value('applicant_name') ?>">
											</div>
											<?= form_error('applicant_name', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="col-md-3">
										<div class="mb-3 mt-3">
											<label for="mobile_no" class="form-label">Mobile No <span class="error">*</span></label>
											<input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No" value="<?= set_value('mobile_no') ?>">
											<?= form_error('mobile_no', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="col-md-3">
										<div class="mb-3 mt-3">
											<label for="property_no" class="form-label">Property No <span class="error">*</span></label>
											<input type="text" class="form-control" id="property_no" name="property_no" placeholder="Enter Property No" value="<?= set_value('property_no') ?>">
											<?= form_error('property_no', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="col-md-4">
										<div class="mb-3 mt-0">
											<label for="email_id" class="form-label">Email Id <span class="error">*</span></label>
											<input type="text" class="form-control" id="email_id" name="email_id" placeholder="Enter Email Id" value="<?= set_value('email_id') ?>">
											<?= form_error('email_id', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="col-md-12">
										<div class="mb-3 mt-0">
											<label for="property_tax" class="form-label mt-3">Do you pay your property tax on time and online <span class="error">*</span></label>
											<div class="row mt-2">
												<div class="col-md-1 col-4">
													<div class="form-check">
														<input type="radio" class="form-check-input" id="property_tax_yes" name="property_tax" value="1" <?= set_radio('property_tax', '1', ($this->input->post('property_tax') == '1')); ?>>
														<label class="form-check-label" for="property_tax_yes">Yes</label>
													</div>
												</div>
												<div class="col-md-2 col-4">
													<div class="form-check">
														<input type="radio" class="form-check-input" id="property_tax_no" name="property_tax" value="0" <?= set_radio('property_tax', '0', ($this->input->post('property_tax') == '0')); ?>>
														<label class="form-check-label" for="property_tax_no">No</label>
													</div>
												</div>
												<div class="col-md-4" id="proofField1" style="display: <?= ($this->input->post('property_tax') == '1') ? 'block' : 'none'; ?>">
													<div class="mb-2 mt-2">
														<input type="file" class="form-control" id="property_tax_proof" name="property_tax_proof">
													</div>
													<?= form_error('property_tax_proof', '<div class="text-danger">', '</div>'); ?>
												</div>
											</div>
											<?= form_error('property_tax', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="col-md-12 m">
										<div class="mb-3 mt-3">
											<label for="solar_energy" class="form-label">Are you currently adopting solar energy in your household, If yes, submit the proof <span class="error">*</span> </label>
											<div class="row align-items-center">
												<div class="col-md-3">
													<div class="row mt-2">
														<div class="col-md-4 col-4">
															<div class="form-check">
																<input type="radio" class="form-check-input" id="solar_energy_yes" name="solar_energy" value="1" <?= set_radio('solar_energy', '1', ($this->input->post('solar_energy') == '1')); ?>>
																<label class="form-check-label" for="solar_energy_yes">Yes</label>
															</div>
														</div>
														<div class="col-md-4 col-4">
															<div class="form-check">
																<input type="radio" class="form-check-input" id="solar_energy_no" name="solar_energy" value="0" <?= set_radio('solar_energy', '0', ($this->input->post('solar_energy') == '0')); ?>>
																<label class="form-check-label" for="solar_energy_no">No</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4" id="proofField2" style="display: <?= ($this->input->post('solar_energy') == '1') ? 'block' : 'none'; ?>">
													<div class="mb-2 mt-2">
														<input type="file" class="form-control" id="solar_energy_proof" name="solar_energy_proof">
													</div>
													<?= form_error('solar_energy_proof', '<div class="text-danger">', '</div>'); ?>
												</div>
											</div>
											<?= form_error('solar_energy', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<!-- LED Lights -->
									<div class="col-md-12 m">
										<div class="mb-3 mt-0">
											<label for="led_lights" class="form-label mt-3">Do you use LED lights in your home <span class="error">*</span></label>
											<div class="row mt-2 ">
												<div class="col-md-1 col-4">
													<div class="form-check">
														<input type="radio" class="form-check-input" id="led_lights_yes" name="led_lights" value="1" <?= set_radio('led_lights', '1', ($this->input->post('led_lights') == '1')); ?>>
														<label class="form-check-label" for="led_lights_yes">Yes</label>
													</div>
												</div>
												<div class="col-md-2 col-4">
													<div class="form-check">
														<input type="radio" class="form-check-input" id="led_lights_no" name="led_lights" value="0" <?= set_radio('led_lights', '0', ($this->input->post('led_lights') == '0')); ?>>
														<label class="form-check-label" for="led_lights_no">No</label>
													</div>
												</div>
												<div class="col-md-4" id="proofField3" style="display: <?= ($this->input->post('led_lights') == '1') ? 'block' : 'none'; ?>">
													<div class="mb-2 mt-2 ">
														<input type="file" class="form-control" id="led_lights_proof" name="led_lights_proof">
													</div>
													<?= form_error('led_lights_proof', '<div class="text-danger">', '</div>'); ?>
												</div>
											</div>
											<?= form_error('led_lights', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<!-- Segregate Waste -->
									<div class="col-md-12 m">
										<div class="mb-3 mt-3">
											<label for="segregate_waste" class="form-label">Do you segregate waste and self-dispose of bio-waste in your household, If yes, submit the proof <span class="error">*</span></label>
											<div class="row align-items-center">
												<div class="col-md-3">
													<div class="row mt-2">
														<div class="col-md-4 col-4">
															<div class="form-check">
																<input type="radio" class="form-check-input" id="segregate_waste_yes" name="segregate_waste" value="1" <?= set_radio('segregate_waste', '1', ($this->input->post('segregate_waste') == '1')); ?>>
																<label class="form-check-label" for="segregate_waste_yes">Yes</label>
															</div>
														</div>
														<div class="col-md-4 col-4">
															<div class="form-check">
																<input type="radio" class="form-check-input" id="segregate_waste_no" name="segregate_waste" value="0" <?= set_radio('segregate_waste', '0', ($this->input->post('segregate_waste') == '0')); ?>>
																<label class="form-check-label" for="segregate_waste_no">No</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4" id="proofField4" style="display: <?= ($this->input->post('segregate_waste') == '1') ? 'block' : 'none'; ?>">
													<div class="mb-2 mt-2 ">
														<input type="file" class="form-control" id="segregate_waste_proof" name="segregate_waste_proof">
													</div>
													<?= form_error('segregate_waste_proof', '<div class="text-danger">', '</div>'); ?>
												</div>
											</div>
											<?= form_error('segregate_waste', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<!-- Balcony Plantation -->
									<div class="col-md-12 m">
										<div class="mb-3 mt-3">
											<label for="balcony_plantation" class="form-label">Do you undertake terrace and balcony plantation as part of your sustainable living practices, If yes, submit the proof <span class="error">*</span></label>
											<div class="row align-items-center">
												<div class="col-md-3">
													<div class="row mt-2">
														<div class="col-md-4 col-4">
															<div class="form-check">
																<input type="radio" class="form-check-input" id="balcony_plantation_yes" name="balcony_plantation" value="1" <?= set_radio('balcony_plantation', '1', ($this->input->post('balcony_plantation') == '1')); ?>>
																<label class="form-check-label" for="balcony_plantation_yes">Yes</label>
															</div>
														</div>
														<div class="col-md-4 col-4">
															<div class="form-check">
																<input type="radio" class="form-check-input" id="balcony_plantation_no" name="balcony_plantation" value="0" <?= set_radio('balcony_plantation', '0', ($this->input->post('balcony_plantation') == '0')); ?>>
																<label class="form-check-label" for="balcony_plantation_no">No</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4" id="proofField5" style="display: <?= ($this->input->post('balcony_plantation') == '1') ? 'block' : 'none'; ?>">
													<div class="mb-2 mt-2 ">
														<input type="file" class="form-control" id="balcony_plantation_proof" name="balcony_plantation_proof">
													</div>
													<?= form_error('balcony_plantation_proof', '<div class="text-danger">', '</div>'); ?>
												</div>
											</div>
											<?= form_error('balcony_plantation', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<!-- Harvesting Rainwater -->
									<div class="col-md-12 m">
										<div class="mb-3 mt-3">
											<label for="harvesting_rainwater" class="form-label">Do you engage in the practice of harvesting rainwater, If yes, submit the proof <span class="error">*</span></label>
											<div class="row align-items-center">
												<div class="col-md-3">
													<div class="row mt-2">
														<div class="col-md-4 col-4">
															<div class="form-check">
																<input type="radio" class="form-check-input" id="harvesting_rainwater_yes" name="harvesting_rainwater" value="1" <?= set_radio('harvesting_rainwater', '1', ($this->input->post('harvesting_rainwater') == '1')); ?>>
																<label class="form-check-label" for="harvesting_rainwater_yes">Yes</label>
															</div>
														</div>
														<div class="col-md-4 col-4">
															<div class="form-check">
																<input type="radio" class="form-check-input" id="harvesting_rainwater_no" name="harvesting_rainwater" value="0" <?= set_radio('harvesting_rainwater', '0', ($this->input->post('harvesting_rainwater') == '0')); ?>>
																<label class="form-check-label" for="harvesting_rainwater_no">No</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4" id="proofField6" style="display: <?= ($this->input->post('harvesting_rainwater') == '1') ? 'block' : 'none'; ?>">
													<div class="mb-2 mt-2 ">
														<input type="file" class="form-control" id="harvesting_rainwater_proof" name="harvesting_rainwater_proof">
													</div>
													<?= form_error('harvesting_rainwater_proof', '<div class="text-danger">', '</div>'); ?>
												</div>
											</div>
											<?= form_error('harvesting_rainwater', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>

									<div class="col-md-12">
										<div class="mb-3 mt-0">
											<label for="co_owners" class="form-label mt-3">Does your property have women in your family as co-owner(s) <span class="error">*</span></label>
											<div class="row mt-2">
												<div class="col-md-1 col-4">
													<div class="form-check">
														<input type="radio" class="form-check-input" id="co_owners_yes" name="co_owners" value="1" <?= set_radio('co_owners', '1', ($this->input->post('co_owners') == '1')); ?>>
														<label class="form-check-label" for="co_owners_yes">Yes</label>
													</div>
												</div>
												<div class="col-md-2 col-4">
													<div class="form-check">
														<input type="radio" class="form-check-input" id="co_owners_no" name="co_owners" value="0" <?= set_radio('co_owners', '0', ($this->input->post('co_owners') == '0')); ?>>
														<label class="form-check-label" for="co_owners_no">No</label>
													</div>
												</div>
												<div class="col-md-4" id="proofField7" style="display: <?= ($this->input->post('co_owners') == '1') ? 'block' : 'none'; ?>">
													<div class="mb-2 mt-2 ">
														<input type="file" class="form-control" id="co_owners_proof" name="co_owners_proof">
													</div>
													<?= form_error('co_owners_proof', '<div class="text-danger">', '</div>'); ?>
												</div>
											</div>
											<?= form_error('co_owners', '<div class="text-danger">', '</div>'); ?>
										</div>
									</div>


									<div class="col-md-3 mt-5">
										<button type="submit" class="btn btn-success w-50">Submit</button>
									</div>
								</div>

							</form>


						</div>
					</div>
				</div>
			</main>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<?php include('includes/scripts.php'); ?>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script>
		$(document).ready(function() {
			// Property Tax
			$('input[name="property_tax"]').change(function() {
				if ($(this).val() == 1) {
					$('#proofField1').show();
				} else {
					$('#proofField1').hide();
				}
			});

			// Solar Energy
			$('input[name="solar_energy"]').change(function() {
				if ($(this).val() == 1) {
					$('#proofField2').show();
				} else {
					$('#proofField2').hide();
				}
			});

			// LED Lights
			$('input[name="led_lights"]').change(function() {
				if ($(this).val() == 1) {
					$('#proofField3').show();
				} else {
					$('#proofField3').hide();
				}
			});

			// Segregate Waste
			$('input[name="segregate_waste"]').change(function() {
				if ($(this).val() == 1) {
					$('#proofField4').show();
				} else {
					$('#proofField4').hide();
				}
			});

			// Balcony Plantation
			$('input[name="balcony_plantation"]').change(function() {
				if ($(this).val() == 1) {
					$('#proofField5').show();
				} else {
					$('#proofField5').hide();
				}
			});

			// Harvesting Rainwater
			$('input[name="harvesting_rainwater"]').change(function() {
				if ($(this).val() == 1) {
					$('#proofField6').show();
				} else {
					$('#proofField6').hide();
				}
			});

			// Co-owners
			$('input[name="co_owners"]').change(function() {
				if ($(this).val() == 1) {
					$('#proofField7').show();
				} else {
					$('#proofField7').hide();
				}
			});
		});
	</script>


</body>

</html>