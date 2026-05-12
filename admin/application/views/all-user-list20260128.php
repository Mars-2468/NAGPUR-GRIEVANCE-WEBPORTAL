
<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<div class="sh-pagebody">
    <div class="col-md-12" style="padding-left: 0px;">
        <div class="text-center mb-3">
            <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal2">Add New</button>
        </div>
            <?php
            if ($this->session->flashdata('success')) 
             {
              ?>
              <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong> Success !</strong> <?php echo $this->session->flashdata('success');?>
            </div>
              <?php
              }
              ?>
            <hr>
        <div class="card bd-primary ">
            <div class="card-header bg-primary tx-white">All Public Notices</div>
            
            <div class="card-body pd-sm-30">
				 <div class="mytable table-responsive">
              <table id="datatable1" class="table table-hover table-bordered table-defulat1 mg-b-0">
                <thead>
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
                    <?php
                    $i = 1;
                    foreach($all as $row)
                    {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row->user_id; ?></td>
                        <td><?php echo $row->user_name; ?></td>
                        <td><?php echo $row->user_mobile; ?></td>
                        <td><?php echo $row->user_email; ?></td>
                        <td><?php echo $row->user_type; ?></td>
                        <td>
						<div class="d-flex justify-content-around align-items-center m-3">
						<div class="m-2">
						<?php if($row->user_id!='superadmin'){?>
						
							<i class="fa fa-eye" id="toggleIcon<?php echo $row->user_id;?>" onclick="toggleDiv('<?php echo $row->user_id;?>')"></i>

							<div id="details<?php echo $row->user_id;?>" style="display: none; margin-top: 10px;">
								<span id="pwd_gen_<?php echo $row->user_id;?>"><?php echo $row->show_pwd;?></span>
							</div>	
							
						<?php }else{?>
							<span>***</span>
						<?php }?>
						</div>	
						<div  class="m-2">
						<?php if($row->user_id!='superadmin'){?>
							<button type="button" class="btn btn-success" onclick="confirmPasswordGen('<?php echo $row->user_id; ?>')">re-Generate</button>
						<?php }else{?>
						<span>***</span>
						<?php }?>
						</div>
						</div>
						
						</td>
                        <td><?php echo $designations[$row->designation_id]; ?></td>
                       					
                        <td>
							<!--
								<div><a href="<?php echo base_url() ?>edit-user/<?php echo $row->user_id; ?>" class="modify_option">Edit </a> </div>
								<div><a href="<?php echo base_url() ?>UerController/delete/<?php echo $row->id; ?>" class="modify_option1" onclick="return confirm('Are you Sure?')"> Delete </a> </div>
							--> 
							<?php if(!strcmp($row->user_id,"superadmin")){?>
								<h5 class="text-center">--</h5>
							<?php }else{ ?>
							<?php if($row->has_access==0){ ?>							
								<a class="btn btn-success" onclick="return confirm('Are you sure you want to proceed?')" href="UserController/updateUserAccess/<?php echo $row->user_id; ?>/enable">Enable</a>
							<?php }else{ ?>
								<a class="btn btn-danger" onclick="return confirm('Are you sure you want to proceed?')" href="UserController/updateUserAccess/<?php echo $row->user_id; ?>/disable">Disable</a>						
							<?php } ?>
							<?php } ?>
					   </td>
					   <td>
					          <?php if(strcmp($row->user_id,"superadmin")){?>
								
							 
									 <button type="button" 
											  class="btn btn-primary" 
											  data-bs-toggle="modal" 
											  data-bs-target="#userModal" 
											  onclick='userFun(<?= json_encode($row) ?>)'>
										Zone/Dept Map
									  </button>

							<?php } ?>
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

<!--
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	
	 Button trigger modal 
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
	
<!-- Reusable Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
<form action="<?php echo base_url('UserController/updateUserZoneDept') ?>" method="POST" enctype="multipart/form-data" id="zoneDeptForm"> 
  <!-- CSRF Token -->
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
     
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
               
               <!--<div class="col-md-12">-->
               <!--   <div class="form-group">-->
               <!--     <label class="control-label col-sm-3" for="lang">Date: <span class="tx-danger">*</span></label>-->
               <!--     <input type="date" name="text2" class="form-control" value="" required>-->
               <!--   </div>-->
               <!--</div>-->
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
               // $('#pwd_gen_'+ele).html(data.pwd);				
				//alert(data['user_id']);
				//window.location=url;
				// $('#pwd_gen_' + ele).css('background-color', 'green');
				
				 location.reload();
				 
             }
         });
       
/* 	   if(confirm('Are sure you want to delete this record'))
         {
             $.post('UserController/userPasswordGen',{menu_id:menu_id,'csrf_test_name': csrf_value},function(data)
             {
                 if(data=='1')
                 {
                     alert('Successfully deleted');
                     location.reload();
                 }
                 else
                 {
                     alert('Unable deleted');
                 }
             });
         } */
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
	   <input type="hidden" name="input_user_id" id="input_user_id" value="${data.user_id}" class="form-control">
  
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