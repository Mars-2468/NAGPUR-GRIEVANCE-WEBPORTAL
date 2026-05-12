
<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<div class="sh-pagebody1">
    <div class="col-md-12">

    <div class="text-center mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
            Add New
        </button>
    </div>

    <?php if ($this->session->flashdata('success')) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>

    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            All Users List
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table id="datatable1" class="table table-bordered table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Sl No</th>
                            <th>User Id</th>
                            <th>User Name</th>
                            <th>User Mobile</th>
                            <th>User Email</th>
                            <th>User Type</th>
                            <th class="text-center">User Password</th>
                            <th>User Designation</th>           
                            <th>Action</th>                  
                            <th>Zone/Dept Map</th>                  
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach($all as $row) { 
						
						if(strcmp($row->user_id,'devspace')){
						?>
						
                        <tr>
                            <td><?= $i; ?></td>
                            <td><a href="user-assigned-dept-and-zone-list/<?= $row->user_id; ?>" class="text-primary"><?= $row->user_id; ?></a></td>
                            <td><?= $row->user_name; ?></td>
                            <td><?= $row->user_mobile; ?></td>

                            <!-- Wrap long email -->
                            <td style="white-space: normal; word-break: break-word;">
                                <?= $row->user_email; ?>
                            </td>

                            <td><?= $row->user_type; ?></td>

                            <!-- PASSWORD COLUMN FIXED -->
                            <td class="text-center">
                                <?php if(!in_array($row->user_id,['superadmin','devspace'])){ ?>

                                    <div class="d-flex flex-column align-items-center gap-1">

                                        <i class="fa fa-eye"
                                           style="cursor:pointer;"
                                           id="toggleIcon<?= $row->user_id;?>"
                                           onclick="toggleDiv('<?= $row->user_id;?>')"></i>

                                        <div id="details<?= $row->user_id;?>" style="display:none;">
                                            <span id="pwd_gen_<?= $row->user_id;?>">
                                                <?= $row->show_pwd;?>
                                            </span>
                                        </div>

                                        <button class="btn btn-success btn-sm"
                                                onclick="confirmPasswordGen('<?= $row->user_id; ?>')">
                                            Re-Generate
                                        </button>

                                    </div>

                                <?php } else { ?>
                                    <span>***</span>
                                <?php } ?>
                            </td>

                            <td><?= ($row->designation_id==0)?'Developer':$designations[$row->designation_id]; ?></td>

                            <td>
                                <?php if(in_array($row->user_id,['superadmin','devspace'])){ ?>
                                    <span>--</span>
                                <?php } else { ?>
                                    <?php if($row->has_access==0){ ?>                            
                                        <a class="btn btn-success btn-sm"
                                           onclick="return confirm('Are you sure?')"
                                           href="UserController/updateUserAccess/<?= $row->user_id; ?>/enable">
                                           Enable
                                        </a>
                                    <?php } else { ?>
                                        <a class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure?')"
                                           href="UserController/updateUserAccess/<?= $row->user_id; ?>/disable">
                                           Disable
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            </td>

                            <td>
                                <?php if(!in_array($row->user_id,['superadmin','devspace'])){ ?>
                                    <button class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#userModal"
                                            onclick='userFun(<?= json_encode($row) ?>)'>
                                        Map
                                    </button>
                                <?php } ?>
                            </td>

                        </tr>
                        <?php }
						$i++; } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
	
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>

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
	
<!-- Reusable Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
<form action="<?php echo base_url('UserController/updateUserZoneDept') ?>" method="POST" enctype="multipart/form-data" id="zoneDeptForm"> 
  <!-- CSRF Token -->
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
     
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Modal title</h5>
<!--     
	 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
-->
      </div>

      <div class="modal-body" id="modalBody">
        <!-- Dynamic content goes here -->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
</form>
    </div>
  </div>
</div>	
  
<!-- Add Modal Newspaper -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title" id="exampleModalLabel2">Register New User</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body">
        <form action="<?php echo base_url('UserController/addUserRecord') ?>" method="post" name="add" enctype="multipart/form-data" file="true" style="padding: 15px;">
            <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>" class="form-control">
			<!-- custom one-time nonce -->
			<input type="hidden" name="form_nonce" value="<?= $form_nonce; ?>">
	
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
                    <label class="control-label col-sm-6" for="user_id">User Id: <span class="tx-danger">*</span></label>
                    <input type="text" name="user_id" id="user_id" class="form-control mytext"  data-type="text" onkeyup="funInputFielTypes(this)" required>
					<div style="font-size:10px;color:red;" id="user_idX"></div>
                  </div>
               </div> 
				<?php $usertypes=array('A'=>'A','D'=>'D','U'=>'U'); ?>
			   <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-6" for="lang">User Type: <span class="tx-danger">*</span></label>
                        <select name="user_type" id="user_type" class="form-control mytext" required>
							<option value="">-- select type --</option>
							<?php foreach($usertypes as $key=>$value){?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
                  </div>
               </div>			   
			   <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-6" for="user_name">User Name: <span class="tx-danger">*</span></label>
                    <input type="text" name="user_name" id="user_name" class="form-control mytext" data-type="text" onkeyup="funInputFielTypes(this)" required>
					<div style="font-size:10px;color:red;" id="user_nameX"></div>
                  </div>
               </div>
			   <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-6" for="user_mobile">User Mobile: <span class="tx-danger">*</span></label>
                    <input type="text" name="user_mobile" minlength="10" maxlength="10" id="user_mobile" class="form-control mytext" data-type="mobile" onkeyup="funInputFielTypes(this)" required>
					<div style="font-size:10px;color:red;" id="user_mobileX"></div>
				  </div>
               </div>
			   <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-6" for="user_email">User Email: <span class="tx-danger">*</span></label>
                    <input type="text" name="user_email" id="user_email" class="form-control mytext" data-type="email" onkeyup="funInputFielTypes(this)" required>
					<div style="font-size:10px;color:red;" id="user_emailX"></div>
				  </div>
               </div>
         
               <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-6" for="lang">User Category: <span class="tx-danger">*</span></label>
                        <select name="user_category" id="user_category" class="form-control mytext" required>
							<option value="">-- select category --</option>
							<?php foreach($categories as $key=>$value){?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
                  </div>
               </div> 
			  
			   <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-6" for="fileurl">Photo: <span class="tx-danger">*</span></label>
                    <input type="file" name="photo_url" id="photo_url" class="form-control mytext" data-type="image" onchange="funInputFielTypes(this)" accept="image/jpeg, image/jpg, image/png" >
					<div style="font-size:10px;color:red;" id="photo_urlX"></div>
				  </div>
               </div> 
               
			    <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-sm-6" for="lang">User Designation: <span class="tx-danger">*</span></label>
                        <select name="designation_id" id="designation_id" class="form-control mytext" required>
							<?php foreach($designations as $key=>$value)
								{ if($key==9){ ?>
								<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>						
								<?php } } ?>
						</select>
                  </div>
               </div> 
			   
            </div>
            <div class="row mt-3">
               <div class="col-md-12 text-center">
                  <input type="submit" name="submituserdetails" id="submitBtn" value="Submit" class="btn btn-success" disabled>
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
    
	function confirmPasswordGen(user_id) {
		if (confirm("Are you sure you want to re-generate the password?")) {
			funPasswordGen(user_id); // call your original function
		}
	}
	
    function funPasswordGen(ele)
    {
		//alert(ele);
    
         var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
         $.ajax({
             type: "POST",
             url:'<?php echo base_url() ?>UserController/userPasswordGen',
             data: {
                 "csrf_test_name": csrf_value,
                 "user_id": ele
                 },
             dataType: 'JSON',
             success: function (data) {
              			
				 location.reload();
				 
             }
         });
    
    }
</script>
<script>
  // Pass PHP array as JS object (safe for use in the browser)
  const zoneDepartmentsOptions = <?= json_encode($zone_departments_options) ?>;

  function userFun(data) {
    document.getElementById('userModalLabel').textContent = "Zone or Department Map for user";

    // Generate options dynamically from JS object
    let menuOptions = `<option selected disabled>Select Zone/Department</option>`;
    for (const [key, value] of Object.entries(zoneDepartmentsOptions)) {
      menuOptions += `<option value="${key}">${value}</option>`;
    }

    document.getElementById('modalBody').innerHTML = `
      <div class="p-3">
	   <input type="hidden" name="input_user_id" id="input_user_id" value="${data.user_id}" class="form-control" >
  
        <p><strong>User ID:</strong> ${data.user_id}</p>
        <p><strong>User Name:</strong> ${data.user_name}</p>

        <p>
          <select class="form-select" name="zone_dept_ids[]" id="zone_dept_id" aria-label="Mainmenu data select" multiple>
            ${menuOptions}
          </select>
        </p>  

     
      </div>  
    `;
  }
</script>
<script>
var baseUrl = "<?= base_url(); ?>";
    $('#main_menu_id').on('change', function() {
        var zoneDeptID = $(this).val();
	var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
	var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
		//alert(zoneDeptID);
        $.ajax({
            url: baseUrl +'UserController/get_zonal_or_depts',
            type: 'POST',
            data: { main_menu_id: zoneDeptID , [csrfName]: csrfHash },
            dataType: 'json',
            success: function(data) {
                $('#zonal_dept_id').empty().append('<option value="">Select Zonal Office or Deparement</option>');
                $.each(data['data'], function(key, value) {
                    $('#zonal_dept_id').append('<option value="'+ value.page_id +'">'+ value.sub_menu_desc +'</option>');
                });
				
				csrfName = data['data'].csrfName;
				csrfHash = data['data'].csrfHash;	
				
            },
			error: function(xhr, status, error) {
				console.error("AJAX Error:", error); // See if there's a server-side error
			}
        });
    });
</script>
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
	
<script>
  function toggleDiv(uid) {
	  
    const div = document.getElementById("details"+uid);	
    const icon = document.getElementById('toggleIcon' + uid);

    if (div.style.display === 'none' || div.style.display === '') {
        div.style.display = 'block';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        div.style.display = 'none';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
	
  }
</script>