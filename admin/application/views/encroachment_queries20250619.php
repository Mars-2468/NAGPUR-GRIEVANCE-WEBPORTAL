<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <div class="text-center mb-3">
            <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal2">Add New</button>
        </div>
            <?php
				if ($this->session->flashdata('success')){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
						<strong> Success !</strong> <?php echo $this->session->flashdata('success');?>
					</div>
				<?php
				}
            ?>
        <hr>
        <div class="card bd-primary ">
            <div class="card-header bg-primary tx-white">All Encroachment Queries</div>
            
            <div class="card-body pd-sm-30">
			<div class="mytable table-responsive">
              <table id="datatable1" class="table table-hover table-bordered table-defulat mg-b-0">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Language</th>
                    <th>Department</th>
                    <th>Show Cause Notice</th>
                    <th>Applicant Reply</th>
                    <th>Answer</th>
                    <th>Description</th>
                    <th>Action</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach($all as $row)
                    {
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td>						
								<?php echo $languages[$row->lang_id]; ?>
														
							</td>
							<td>
								<?php echo $departments[$row->dept_id]; ?>
							</td>
							<td>							
								<?php  
								$show_cause_notice_path = explode(".", $row->show_cause_notice);
								if(in_array($show_cause_notice_path[3],['jpg','jpeg','png'])){ ?>							
									<img src="<?php echo $row->show_cause_notice;?>" style="width:100%;height:100px;"> 
								<?php }else{ ?>
								<iframe src="<?php echo base_url().$row->show_cause_notice ;?>" 
										width="250px" height="100px" style="border: none;">
								</iframe>
								<?php } ?>							
							</td>
							<td>
								<?php  
								$applicant_reply = explode(".", $row->applicant_reply);
								if(in_array($applicant_reply[3],['jpg','jpeg','png'])){ ?>							
									<img src="<?php echo $row->applicant_reply;?>" style="width:100%;height:100px;"> 
								<?php }else{ ?>
								<iframe src="<?php echo base_url().$row->applicant_reply ;?>" 
										width="250px" height="100px" style="border: none;">
								</iframe>
								<?php } ?>						
							</td>                   
							<td>							
								<?php  
								$answer = explode(".", $row->answer);
								if(in_array($answer[3],['jpg','jpeg','png'])){ ?>							
									<img src="<?php echo $row->answer;?>" style="width:100%;height:100px;"> 
								<?php }else{ ?>
								<iframe src="<?php echo base_url().$row->answer ;?>" 
										width="250px" height="100px" style="border: none;">
								</iframe>
								<?php } ?>							
							</td>
							<td><?php echo $row->description; ?></td>
							<td>
								<div><a href="<?php echo base_url() ?>edit-encroachment-queries/<?php echo $row->id; ?>" class="modify_option">Edit </a> </div>
								<div><a href="<?php echo base_url() ?>delete-encroachment-queries/<?php echo $row->id; ?>" class="modify_option1" onclick="return confirm('Are you Sure?')"> Delete </a> </div>
							</td>
							<td>
								<div>Last Modified</div>
								<div class="modify_date"><?php $yrdata= strtotime($row->created_at);  echo date('d - M-Y H:i:s', $yrdata); ?></div>
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
		<!---------------------- forms close here ------------------------------->
    </div>
		
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	
	<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal23">
  Launch demo modal
</button>-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
	
	
  

<!-- Add Modal Newspaper -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Add Encroachment Queriy</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body">
        <form action="" method="post" name="add" enctype="multipart/form-data" style="padding: 15px;">
            <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
            <div class="row">
                 
				<div class="col-md-12">
				  <div class="form-group">
					<label class="control-label col-sm-12" for="dept_id">Department: <span class="tx-danger">*</span></label>
					<select name="dept_id" id="dept_id" class="form-control mytext" required>
						<option value="">-- select department --</option>
						<?php foreach($departments as $key=>$value){ ?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>						
						<?php } ?>
					</select>                      
					</div>
				</div>      
				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Show Cause Notice: <span class="tx-danger">*</span></label>
                    <input type="file" name="show_cause_notice" class="form-control mytext" accept="image/jpeg, image/jpg, image/png, application/pdf" >
                  </div>
				</div> 	
				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Applicant Reply: <span class="tx-danger">*</span></label>
                    <input type="file" name="applicant_reply" class="form-control mytext" accept="image/jpeg, image/jpg, image/png, application/pdf" >
                  </div>
				</div> 	
				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="email">Answer: <span class="tx-danger">*</span></label>
                    <input type="file" name="answer" class="form-control mytext" accept="image/jpeg, image/jpg, image/png, application/pdf" >
                  </div>
				</div> 				
				<div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-12" for="description1">Description: <span class="tx-danger">*</span></label>
                    <textarea name="description" rows="3" class="form-control mytext" > </textarea>
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
            <div class="row">
               <div class="col-md-12 text-center">
                  <input type="submit" name="submitencroachmentqueries" id="submitencroachmentqueries" value="Submit" class="btn btn-success">
               </div>
            </div>
            
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
         </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Modal Newspaper -->
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