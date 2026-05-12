<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>

<head>

	

	<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>

<!--	<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">-->

	<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

</head>

<body>
   

<div class="sh-pagebody">
    
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success text-center"> 
    <?php echo $this->session->flashdata('message');?>
    </div>
    <?php } ?>



           <hr>
              <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Update User</div>
               <div class="card-body ">
              <?php foreach($edit_users_data->result() as $key=>$value) { ?>
             
             <?php $attributes=array('method'=>'POST','onsubmit'=>'return validateForm()');echo form_open('ViewUlbUserController/update_user/'.$value->user_id.'',$attributes);?>
             
              <!--<form method="post" class="form-horizontal"  action="<?php echo base_url() . "ViewUlbUserController/update_user/" . $value->user_id; ?>"  onsubmit="return validateForm()">-->
              
             <div class="">
             <div class="form-horizontal">
                 <input type="hidden" name="user_id" id="user_id" value="<?php echo $value->user_id; ?>"/>
                 <div>
                 <div class="col-md-6" >
                     <div class="form-group">
                  <label class="col-md-6 control-label">Person Name <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="textinput" name="user_name" placeholder="Enter Person Name" class="form-control input-md" type="text" tabindex="1" required="required" value='<?php echo $value->user_name;?>'>
                    
                  </div>
                </div>
               <div class="form-group">
                  <label class="col-md-6 control-label">Mobile No <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="textinput" name="user_mobile" placeholder="Enter valid Mobile No" class="form-control input-md" type="text" tabindex="3" pattern="[789][0-9]{9}" value='<?php echo $value->user_mobile;?>'>
                    
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
                          if($value->designation_id==$val->desg_id){ ?>
                          <option value="<?php echo $val->desg_id; ?>" selected><?php echo $val->desg_desc; ?></option>
                          <?php } else {  ?>
                           <option value="<?php echo $val->desg_id; ?>"><?php echo $val->desg_desc; ?></option>
                          <?php } } ?>
                          
                      </select>
                  
                </div>
                </div>
                     
                <div class="form-group">
                  <label class="col-md-6 control-label">Email ID <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="textinput" name="user_email" placeholder="Enter ValidEmail ID" class="form-control input-md" type="email" tabindex="4" required="required" value='<?php echo $value->user_email;?>'>
                    
                </div>
             </div>
                
            </div>
                
            <div class="col-md-6">
                    <span id="user_result"></span> 
                <div class="form-group">
                  <label class="col-md-6 control-label">User ID <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="userid" name="userid" placeholder="Enter User ID" class="form-control input-md" type="text" tabindex="4" required="required" value='<?php echo $value->user_id;?>'>
                    
                </div>
                </div>
                
            </div>
            
            <div class="" style="clear:both;">   
            <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-6 control-label">User Type <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                   <select name="is_custom_user" id="is_custom_user" tabindex="2" class="form-control" required="required" onchange="show_user_fun()">
                          
                          <option value="">--- select---</option>
                         <option <?php echo ($value->is_custom_user == 'No') ? ' selected="selected"' : ''; ?> value="No">No</option>
                         <option <?php echo ($value->is_custom_user == 'Yes') ? ' selected="selected"' : ''; ?> value="Yes">Yes</option>
                    </select>
                  </div>
                  
                </div>
            </div>
                <?php if($value->is_custom_user == 'No') { ?>
                
            <div class="col-md-6" id="show_categories">
                <div class="form-group">
                  <label class="col-md-6 control-label">Category Name<span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                   <select name="user_category" id="user_category" tabindex="2" class="form-control"  onchange="show_user_fun()">
                          <option value="">--- select---</option>
                          <?php foreach($getuser_categories->result() as $key=>$val){ 
                          if($value->user_category==$val->id){ ?>
                          <option value="<?php echo $val->id; ?>" selected><?php echo $val->user_category_name; ?></option>
                          <?php } else { ?>
                           <option value="<?php echo $val->id; ?>"><?php echo $val->user_category_name; ?></option>
                          <?php } } ?>
                          
                         
                          
                      </select>
                    </div>
                  
                </div>
            </div>
            <?php } else { ?>
            
            <div class="col-md-6" id="show_categories" style="display:none;">
                <div class="form-group">
                  <label class="col-md-6 control-label">Category Name<span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                   <select name="user_category" id="user_category" tabindex="2" class="form-control"  onchange="show_user_fun()">
                          <option value="">--- select---</option>
                          <?php foreach($getuser_categories->result() as $key=>$val){?>
                          <option value="<?php echo $val->id; ?>"><?php echo $val->user_category_name; ?></option>
                          <?php }?>
                          
                         
                          
                      </select>
                    </div>
                  
                </div>
            </div>
            
            <?php } ?>
                
        </div>
      </div> 
                
    <hr style="clear:both;">
                
                
                 
    </div>
    </div>
    <?php } ?>
             
              <hr style="clear:both;">
             
        <div id="error"><span id="error_message"></span></div>
        <?php if($value->is_custom_user == 'Yes'){ ?>
             <div id="show_custom_user">
                 
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
                       <?php if($mainmenudetails->is_single_content_page=='1') { ?>
                         <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="menu_checkbox" id="menu_checkbox<?php echo $mainvar;?>" onclick="menu_check_all(<?php echo $mainvar; ?>);" name="create<?php echo $i; ?>"  value="<?php echo $mainmenudetails->main_menu_id."_0"; ?>" <?php echo $chkedmainmenu[$mainmenudetails->main_menu_id]['checked'];?>><span></span></label> </td>
                         
                        <?php } ?>
                    </tr>
                    <?php foreach($user_permission_subpages[$mainmenudetails->main_menu_id] as $submenuid=>$submenudetails){ ?>
                    <tr class="td_bg">
                        <td></td>
                        <td> &nbsp; &nbsp; - <?php echo $submenudetails['page_name']; ?></td>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="menu_checkbox sub_menu_chkbox<?php echo $mainvar; ?>" id="sub_menu_chkbox<?php echo $mainvar; ?>" name="create<?php echo $i; ?>" value="<?php echo $mainmenudetails->main_menu_id."_".$submenuid; ?>" <?php echo $chkedsubmenu[$submenuid]['checked'];?>><span></span></label> </td>
                         
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
                        
                        <th> <input type="checkbox" class="widget_checked_all"><span></span> Edit</th>
                       
                    </tr>
                    </thead>
                    
                    <?php
                    
                         $j=1;
                    foreach($widgetList->result() as $key=>$val) {
                       
                    ?>
                    <tr > 
                        <td><i class="fa fa-trello"></i></td>
                        <td style="color:#000;"> <?php echo $val->widget_name; ?> </td>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="widget_checkbox" name="widget<?php echo $j; ?>" value="<?php echo $val->widget_id; ?>" <?php echo $chkedwidgets[$val->widget_id]['checked'];?>><span></span></label> </td>
                        
                    </tr>
                    <?php  $j++; } ?>
                   <input type="hidden" name="widgetCount" value="<?php echo $j; ?>">
                    
                    
    </table>
                 
    </div>
            </div>
            </div>
            <?php }  else { ?>
            
            <div id="show_custom_user" style="display:none;">
                 
             <div style="clear:both;">
                 
                 <!------ pages ---->
                 
            <div class="col-md-6" style="padding-left: 0px;">
                <table class="table table-hover table-bordered table-primary mg-b-0">
                  <thead class="bg-info">
                    <tr>
                        <td>
                            <label class="ckbox mg-b-0">
                            <input type="checkbox"><span></span>
                          </label>
                        </td>
                        <th style="font-size:16px; font-weight:normal;">Pages</th>
                        <th> Permission </th>
                       
                    </tr>
                    </thead>
                    
                    <tbody>
                        
                       <?php
                           $i=1; 
                        foreach($user_permission_pages->result() as $mainmenuid=>$mainmenudetails)
                        {
                        
                        ?>
                    <tr>
                        <td><i class="fa fa-file"></i></td>
                        <td style="color:#000;"><?php echo $mainmenudetails->main_menu_name; ?></td>
                       <?php if($mainmenudetails->is_single_content_page=='1') { ?>
                         <td> <label class="ckbox mg-b-0"> <input type="checkbox" name="create<?php echo $i; ?>"  value="<?php echo $mainmenudetails->main_menu_id."_0"; ?>" <?php echo $chkedmainmenu[$mainmenudetails->main_menu_id]['checked'];?>><span></span></label> </td>
                         
                        <?php } ?>
                    </tr>
                    <?php foreach($user_permission_subpages[$mainmenudetails->main_menu_id] as $submenuid=>$submenudetails){ ?>
                    <tr class="td_bg">
                        <td></td>
                        <td> &nbsp; &nbsp; - <?php echo $submenudetails['page_name']; ?></td>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" name="create<?php echo $i; ?>" value="<?php echo $mainmenudetails->main_menu_id."_".$submenuid; ?>" <?php echo $chkedsubmenu[$submenuid]['checked'];?>><span></span></label> </td>
                         
                    </tr>
                    
                    <?php $i++; } $i++;} // user permission pages loop is closed 
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
                            <label class="ckbox mg-b-0">
                            <input type="checkbox"><span></span>
                          </label>
                        </td>
                        <th style="font-size:16px; font-weight:normal;">Widgets</th>
                        
                        <th>Edit</th>
                       
                    </tr>
                    </thead>
                    
                    <?php
                    
                         $j=1;
                    foreach($widgetList->result() as $key=>$val) {
                       
                    ?>
                    <tr > 
                        <td><i class="fa fa-trello"></i></td>
                        <td style="color:#000;"> <?php echo $val->widget_name; ?> </td>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" name="widget<?php echo $j; ?>" value="<?php echo $val->widget_id; ?>" <?php echo $chkedwidgets[$val->widget_id]['checked'];?>><span></span></label> </td>
                        
                    </tr>
                    <?php  $j++; } ?>
                   <input type="hidden" name="widgetCount" value="<?php echo $j; ?>">
                    
                    
    </table>
                 
    </div>
            </div>
            </div>
            
            <?php } ?>
             
             <hr style="clear:both;">
             
          <center>   <input type="submit" name="save" class="btn btn-success btn-sm" id="butundisab"></center>
               <!--</form>-->
              
               <?php echo form_close(); ?>
              
              <?php //} ?>
             
     </div> 
     </div>
   

<script>  
$(document).ready(function(){  
     $('#userid').change(function(){
         
         var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
         
          var user = $('#userid').val();  
          var exist_user=$('#user_id').val();
 //alert(email);
          if(user != '')
          {
               $.ajax({
                    url:"<?php echo base_url(); ?>ViewUlbUserController/check_userid_avalibility",  
                    method:"POST",  
                    data:{user:user,exist_user:exist_user,'csrf_test_name': csrf_value}, 
                    success:function(data){
                        //alert(data);
                        if(data==0){
                         $('#user_result').html('<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> User Id Already register</label>');  
                        $('#butundisab').prop('disabled', true);
                        } else if(data==1) {
                            $('#user_result').html('');  
                            $('#butundisab').prop('disabled', false);
                        }
                        
                        }
               });  
          }  
     });  
});  
</script> 

 <script>
              function show_user_fun(){
                 // alert(3434535);
                  var id=$("#is_custom_user").val();
                  
                  if(id=='Yes'){
                      $("#show_custom_user").show();
                       $("#show_categories").hide();
                  }
                  else {
                      
                      $("#show_custom_user").hide();
                      $("#show_categories").show();
                  }
                  
              }
          </script>
          
          <script>
                function validateForm()
                {
                    var errors=0;
                    if($('#is_custom_user').val()=='Yes'){
                        if ($('input[type=checkbox]:checked').length > 0) {
                            
                        } else {
                            errors++;
                            $("#error_message").text('Please select any one of the checkbox below');
                            $("#error").addClass('alert alert-danger');
                        }
                    }
                        
                        if(errors > 0)
                        {
                            return false;
                        }
                    
                }
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

