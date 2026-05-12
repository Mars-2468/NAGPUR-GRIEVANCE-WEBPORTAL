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
		<form name="" action="<?php echo base_url();?>FAQController/add_faqs" method="POST" onSubmit="return validateForm()">
			<div class="row">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>"
					value="<?php echo $this->security->get_csrf_hash();?>">
				
				<!-- custom one-time nonce -->
				<input type="hidden" name="form_nonce" value="<?= $form_nonce; ?>">
	
	
				<div class="form-group col-md-12">
					<label class=" control-label" for="textinput">Question<span class="tx-danger">*</label>
					<div class="">

						<textarea name="question" id="question" required="required" class="form-control" data-type="text" onkeyup="funInputFielTypes(this)" ><?php echo $edit_faqs->question;?></textarea>
						<div style="font-size:10px;color:red;" id="questionX"></div>
					</div>
				</div>

				<div class="form-group col-md-12">
					<label class=" control-label" for="textinput">Answer <span class="tx-danger">*</label>
					<div class="">
						<textarea name="answer" id="answer" required="required" class="form-control"  data-type="text" onkeyup="funInputFielTypes(this)" ><?php echo $edit_faqs->answer;?></textarea>
					<div style="font-size:10px;color:red;" id="answerX"></div>
					</div>
				</div>

				<div class="form-group col-md-3">
					<label class=" control-label" for="textinput">Status<span class="tx-danger">*</span> </label>
					<div class="">

						<select name="status" class="form-select" required="required">
							<option>Select</option>
							<option value="1" <?php if($edit_faqs->status == "1") { echo "selected"; } ?>>Active</option>
							<option value="2" <?php if($edit_faqs->status == "2") { echo "selected"; } ?>>In-active</option>
						</select>
					</div>
				</div>


				<div class="col-md-1">
				  <input type="hidden" name="id" value="<?php echo $edit_faqs->id;?>">
					<input type="submit" value="Submit" name="submit" id="submitBtn" disabled class="btn btn-sm btn-primary"
						style="margin-top:32px;" />
				</div>
			</div>
		</form>

		<div class="col-md-12" style="padding-left: 0px;">


			<hr>
			<?php if($this->uri->segment(2)==""){ ?>
			<div class="card bd-primary ">
				<div class="card-header bg-primary tx-white">All Complaint Details</div>

				<div class="card-body pd-sm-30">
					<div class="table table-responsive">
						<table id="datatable" class="table table-hover table-bordered table-striped mg-b-0">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Question</th>
									<th>Answer</th>
									<th>Status</th>
									<th>Date</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i = 1;
									foreach($faqs as $row){
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td> <?php echo $row['question']; ?> </td>
										<td> <?php echo $row['answer']; ?> </td>
										<td> <?php if($row['status'] == "1"){ echo "Active"; } else{echo "In-Active"; } ?> </td>


										<td><?php $yrdata= strtotime($row['created_at']);  echo date('d - M-Y H:i:s', $yrdata); ?></td>
										<td>
											<a href="<?php echo base_url();?>faq-details/<?php  echo $row['id']; ?>"> Edit</a>
											<a href="<?php echo base_url();?>faq-delete/<?php  echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item')"> Delete</a>
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
			<?php } ?>
		</div>
		<!---------------------- forms close here ------------------------------->
		
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

							

							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
</div>

<!-- Add Modal video-->

<script>
/* $(function() {
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

}); */




	function validateForm1() {
        //alert();
        errors = 0;

        $("#question").each(function() {

            var question = $(this).val();
            var qsn = $('#qsn').val();
			//alert(question);
            if (question == '') {
                errors++;
				qsn.text('html tags not allowed!');
				return false;
            } else{			
                question = removeOperatorsAtBeginning(question);				
                question = stripHTMLTags(question);	
				question = removeOperatorsAtBeginning(question);					
				$(this).val(question);				
            }
			
        });

		$("#answer").each(function() {

            var answer = $(this).val();
			 var ans = $('#ans').val();
            if (answer == '') {
                errors++;
				ans.text('html tags not allowed!');
				return false;
            } else{			
           
				answer = removeOperatorsAtBeginning(answer);				
                answer = stripHTMLTags(answer);	
				answer = removeOperatorsAtBeginning(answer);
				$(this).val(answer);			
            }
			
        });



        if (errors == 0) {
            return true;
        } else {
            alert("Please Enter Correct Value in High-lighted Fields - " + errors);
            return false;
        }
    }
	
	function stripHTMLTags(inputString) {
	  return inputString.replace(/<\/?[^>]+(>|$)/g, "");  // Removes all HTML tags
	}

	function removeOperatorsAtBeginning(inputString) {
	  // Regular expression to remove operators at the beginning of the string
	  return inputString.replace(/^[+\-*/%^&|!=]+/, "").trim();
	}
    </script>
	
	
	
 <script>
	const isValidText = /^[A-Za-z0-9\s-_]+$/;
	const isValidDesc = /^[a-zA-Z0-9.,!?()'"\s-]+$/;
	
	
    function questionFun() {
		
		$("#questiontext").each(function() {

            var field_val = $(this).val();
			
            if (!isValidDesc.test(field_val)) {
                alert('Invalid text!');
				$(this).val('');
                return false;
            } 
			
        });
	}
	
	
	function answerFun() {
		
		$("#answertext").each(function() {

            var field_val = $(this).val();
			
            if (!isValidDesc.test(field_val)) {
                alert('Invalid text!');
				$(this).val('');
                return false;
            } 
			
        });
	}
	
	
	
    </script>