<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <div class="sh-pagebody">
                <?php if($this->session->flashdata('message')){?>
                <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
                <?php }?>
                
               <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Edit Profile</div>
         <div class="card-body ">
             <?php $attributes=array('onsubmit'=>'return validateForm()','method'=>'POST'); echo form_open('UpdateprofileController/update_userprofile',$attributes); ?>
           
                 <!--<form action="<?php //echo base_url(); ?>UpdateprofileController/update_userprofile" method="POST" >-->
             <?php foreach($edituser as $value1) 
             
             ?>
             <input type="hidden" name="user_id1" value="<?php echo $value1->user_id;  ?>">
             <div class="">
             <div class="form-horizontal">
                 
                 <div>
            <div class="col-md-6">
                     <div class="form-group">
                  <label class="col-md-6 control-label">Person Name <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="textinput" name="person_name" id="person_name" value="<?php echo $value1->user_name;  ?>" placeholder="Enter Person Name" class="form-control input-md" type="text" tabindex="1" required="required">
                    
                  </div>
                </div>
               <div class="form-group">
                  <label class="col-md-6 control-label">Mobile No <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="textinput" name="mobile" id="mobile" value="<?php echo $value1->user_mobile;  ?>" placeholder="Enter valid Mobile No" class="form-control input-md" type="text" tabindex="3" pattern="[789][0-9]{9}" required="required">
                    
                  </div>
                </div> 
            </div>
                
            <div class="col-md-6">
                     
            <div class="form-group">
                  <label class="col-md-6 control-label">Designation <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                      <select name="designation_id" id="designation_id" tabindex="2" class="form-control" required="required">
                          <option value="">--- select---</option>
                          <?php foreach($designationList->result() as $key=>$val){
                          
                          if($val->desg_id==$value1->designation_id){
                          ?>
                          <option value="<?php echo $val->desg_id; ?>" selected><?php echo $val->desg_desc; ?></option>
                          
                          <?php }else{ ?>
                          
                          <option value="<?php echo $val->desg_id; ?>"><?php echo $val->desg_desc; ?></option>
                          
                          
                        <?php }  } ?>
                          
                      </select>
                  
                    
                  </div>
                </div>
                     
            <div class="form-group">
                  <label class="col-md-6 control-label">Email ID<span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="textinput" name="email" id="email" value="<?php echo $value1->user_email;  ?>" placeholder="Enter valid email ID" class="form-control input-md" type="email" tabindex="4" required="required">
                    
                  </div>
                </div>
                     
            </div>
               </div> 
                
                <hr style="clear:both;">
                
           <div class="" style="clear:both;">
                <div id="div_user_result"  style="display:none;margin-bottom: 19px;">
                    <center><span id="div_user_result_span" class="alert alert-danger"></span></center>
                </div>
                <div class="col-md-6">
                     
                <div class="form-group">
                  <label class="col-md-6 control-label">User Name <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="user_id" name="user_id" placeholder="Enter User Name" value="<?php echo $value1->user_id;  ?>" class="form-control input-md" type="text" tabindex="5" required="required">
                    
                  </div>
                </div>
                </div>
                
                <!--<div class="col-md-6">-->
                <!--<div class="form-group">-->
                <!--  <label class="col-md-6 control-label">Password <span class="tx-danger">*</span></label>  -->
                <!--  <div class="col-md-6">-->
                <!--  <input id="textinput" name="password" id="password" value="<?php echo $value1->show_pwd;  ?>" placeholder="Enter Password" class="form-control input-md password" type="password" tabindex="6" required="required">-->
                    
                <!--  </div>-->
                <!--</div>-->
                <!--<div class="form-group">-->
                <!--  <label class="col-md-6 control-label">Re Enter Password <span class="tx-danger">*</span></label>  -->
                <!--  <div class="col-md-6">-->
                <!--  <input id="textinput" name="password_again" id="password_again" value="<?php echo $value1->show_pwd;  ?>" placeholder="Enter password_again" class="form-control input-md password_again" type="password" tabindex="6" required="required">-->
                <!--    <div style="display:none;" id="disp">-->
                <!--<span style='color: red'>Password and Confirm Password don't match</span>-->
                <!--</div>-->
                <!--  </div>-->
                <!--</div>-->
                <!--</div>-->
                
        </div>
        <!--
        <div class="" style="clear:both;">
            <?php //print_r($ulbList); ?>
                <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-6 control-label">User Level<span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                      <select name="user_level_id" id="user_level_id" tabindex="2" class="form-control" required="required">
                          <option value="">--- select---</option>
                          <?php foreach($userLevel as $key=>$val){?>
                          <option value="<?php echo $val['user_level_id']; ?>"><?php echo $val['user_level_name']; ?></option>
                          <?php }?>
                          
                      </select>
                  </div>
                </div>
            </div>
            <?php if($this->session->userdata('user_type') == 'A'){ ?>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-6 control-label">Municipality<span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                      <select name="municipality" id="municipality" tabindex="2" class="form-control" required="required">
                          <option value="">--- select---</option>
                          <?php foreach($ulbList as $key=>$val){?>
                          <option value="<?php echo $val['ulbid']; ?>"><?php echo $val['ulbname']; ?></option>
                          <?php }?>
                          
                      </select>
                  </div>
                </div>
            </div>
            <?php } ?>
        </div>     
        <div class="" style="clear:both;">   
            <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-6 control-label">User Type <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                   <select name="is_custom_user" id="is_custom_user" tabindex="2" class="form-control" required="required" onchange="show_user_fun()">
                          
                          <option value="">--- select---</option>
                          <option value="No">Select User Category</option>
                          <option value="Yes">Custom User</option>
                    </select>
                  </div>
                  
                </div>
            </div>
                
            <div class="col-md-6" id="show_categories" style="display:none;">
                
            </div>
                
        </div>
              -->   
                 
                 
             </div>
             </div>
             
             <hr style="clear:both;">
             
             <div id="error"><span id="error_message"></span></div>
             <div id="show_custom_user" style="display:none;">
             <div style="clear:both;">
                 
                 <!------ pages ---->
                 
                 <div class="col-md-6" style="padding-left: 0px;">
                <table class="table table-hover table-bordered table-primary mg-b-0">
                    <thead class="bg-info">
                    <tr>
                        <td>
                            <!--<label class="ckbox mg-b-0">
                            <input type="checkbox"><span></span>
                          </label>-->
                        </td>
                        <th style="font-size:16px; font-weight:normal;">Pages</th>
                        <th><input type="checkbox" class="menu_checked_all"> Permission </th>
                       
                    </tr>
                    </thead>
                    
                    <tbody>
                        
                       <?php
                           $i=1; 
                            $mainvar=0;
                        foreach($user_permission_pages->result() as $mainmenuid=>$mainmenudetails)
                        {
                        
                        ?>
                    <tr>
                        <td><i class="fa fa-file"></i></td>
                        <td style="color:#000;"><?php echo $mainmenudetails->main_menu_name; ?></td>
                        <?php //if($mainmenudetails->is_single_content_page=='1'){?>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="menu_checkbox" id="menu_checkbox<?php echo $mainvar;?>" onclick="menu_check_all(<?php echo $mainvar; ?>);" name="create<?php echo $i; ?>" value="<?php echo $mainmenudetails->main_menu_id."_0"; ?>"><span></span></label> </td>
                        <?php //} ?>
                      
                       
                        
                    </tr>
                    <?php foreach($user_permission_subpages[$mainmenudetails->main_menu_id] as $submenuid=>$submenudetails){ ?>
                    <tr class="td_bg">
                        <td></td>
                        <td> &nbsp; &nbsp; - <?php echo $submenudetails['page_name']; ?></td>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="menu_checkbox sub_menu_chkbox<?php echo $mainvar; ?>" id="sub_menu_chkbox<?php echo $mainvar; ?>" name="create<?php echo $i; ?>" value="<?php echo $mainmenudetails->main_menu_id."_".$submenuid; ?>"><span></span></label> </td>
                         
                    </tr>
                    
                    <?php $i++; } $i++; $mainvar++; } // user permission pages loop is closed 
                   ?>
                    <input type="hidden" name="pagecount" value="<?php echo $i; ?>">
                    </tbody>
                    
                </table>
                 
                 </div>
             <div class="col-md-6" style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-hover table-bordered table-primary mg-b-0">
                    <thead class="bg-info">
                    <tr>
                        <td>
                            <!--<label class="ckbox mg-b-0">
                            <input type="checkbox"><span></span>
                          </label>-->
                          
                        </td>
                        <th style="font-size:16px; font-weight:normal;">Widgets</th>
                        
                        <th><input type="checkbox" class="widget_checked_all"><span></span> Edit</th>
                       
                    </tr>
                    </thead>
                    
                    <?php $j=1;foreach($widgetList->result() as $key=>$val){?>
                    <tr > 
                        <td><i class="fa fa-trello"></i></td>
                        <td style="color:#000;"> <?php echo $val->widget_name; ?> </td>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="widget_checkbox" name="widget<?php echo $j; ?>" value="<?php echo $val->widget_id; ?>"><span></span></label> </td>
                        
                    </tr>
                    <?php $j++;} ?>
                   <input type="hidden" name="widgetCount" value="<?php echo $j; ?>">
                    
                    
                </table>
                 
                 </div>
                 
                 
             </div>
             <hr style="clear:both;">
             </div>
             
           <center>   <input type="submit" name="save" class="btn btn-success btn-sm" id="butundisab"  value="Save"></center>
             
             
            
        <?php echo form_close(); ?>
      </div>
        </div>
        
      
      </div>
            
            <script>
                function validateForm()
                {
                    var errors=0;
                    $("#person_name").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    $("#mobile").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    $("#designation_id").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    $("#email").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    $("#user_id").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    $("#password").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    $("#user_level_id").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    $("#municipality").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    /*$("#user_category").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });*/
                    $("#is_custom_user").each(function(){
                        var val_field=$(this).val();
                		if(val_field==''){
                			($(this)).css({"background-color": "pink"});
                			errors++;
                		}else{
                			($(this)).css({"background-color": "white"});
                		}
                    });
                    if($('#is_custom_user').val()=='Yes'){
                        if ($('input[type=checkbox]:checked').length > 0) {
                            
                        } else {
                            errors++;
                            $("#error_message").text('Please select User Type');
                            $("#error").addClass('alert alert-danger');
                        }
                    }
                        
                    if(errors!=0){
                		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
                		return false;
                	}
                    
                }
            </script>
          
          <script>
              function show_user_fun(){
                 // alert(3434535);
                  var id=$("#is_custom_user").val();
                  
                  if(id=='Yes'){
                      $("#show_custom_user").show();
                      $("#user_category").html('');
                      $("#show_categories").html('');
                       $("#show_categories").hide();
                  }
                  else {
                      
                      $("#show_custom_user").hide();
                      var data = '';
                        data += '<div class="form-group">'+
                                    '<label class="col-md-6 control-label">Category Name<span class="tx-danger">*</span></label>'+
                                    '<div class="col-md-6">'+
                                        '<select name="user_category" id="user_category" tabindex="2" class="form-control" required="required"  >'+
                                            '<option value="">--- select---</option>'+
                                                <?php foreach($getuser_categories->result() as $key=>$val){?>
                                            '<option value="<?php echo $val->id; ?>"><?php echo $val->user_category_name; ?></option>'+
                                                <?php }?>
                                        '</select>'+
                                    '</div>'+
                                '</div>';
                    $("#show_categories").html(data);            
                      $("#show_categories").show();
                  }
                  
              }
          </script>
          
          <script>  
$(document).ready(function(){  
     $('#user_id').keyup(function(){
          var user = $('#user_id').val();  
          var exist_user=$('#userid').val();
 //alert(email);
          if(user != '')
          {
               $.ajax({
                    url:"<?php echo base_url(); ?>UpdateprofileController/check_userid_avalibility",  
                    method:"POST",  
                    data:{user:user,exist_user:exist_user}, 
                    success:function(data){
                        //alert(data);
                        if(data==0){
                            $('#div_user_result').show();
                            $('#div_user_result_span').html('User Id Already register');  
                            $('#butundisab').prop('disabled', true);
                        } else if(data==1) {
                            $('#div_user_result').hide();
                            $('#div_user_result_span').html('');  
                            $('#butundisab').prop('disabled', false);
                        }
                        
                        }
               });  
          }  
     });  
});  
</script> 


<script>
    
            $('.menu_checked_all').on('change', function() {
                
                $('.menu_checkbox').prop('checked', $(this).prop("checked"));    
        });
        
</script>

<script>
function menu_check_all(i)
{

	if ($("#menu_checkbox" +i).is(':checked')) {
	
            $('.sub_menu_chkbox' + i).each(function () {
            
                $(this).prop("checked",true);
            });

        } else {
        
            $('.sub_menu_chkbox' + i).each(function () {
                $(this).prop("checked",false);
            });
        }
 


}

</script>
    
        <script>
    
            $('.widget_checked_all').on('change', function() {
                
                $('.widget_checkbox').prop('checked', $(this).prop("checked"));    
        });
        
</script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>



	