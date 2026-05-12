<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <div class="sh-pagebody">
                <div>
                <?php echo $this->session->flashdata('message');?>
                </div>
               <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Create User</div>
         <div class="card-body ">
              <?php foreach($edit_users_data->result() as $key=>$val) { ?>
              
              <?php $attributes=array('method'=>'POST','onsubmit'=>'return validateForm()');echo form_open('UserViewCategoryController/update_user_category/'.$val->id.'',$attributes);?>
              
        <!--<form method="post" class="form-horizontal"  action="<?php echo base_url() . "UserViewCategoryController/update_user_category/" . $val->id; ?>"  onsubmit="return validateForm()">-->
        
       
             <div class="">
             <div class="form-horizontal">
                 
            <hr style="clear:both;">
                
        <div class="" style="clear:both;">
                <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-6 control-label">User Category  <span class="tx-danger">*</span></label>  
                  <div class="col-md-6">
                  <input id="textinput" name="user_category_name" placeholder="Enter User Category Name" class="form-control input-md" type="text" tabindex="5" required="required" value="<?php echo $val->user_category_name; ?>">
                    
            </div>
                </div>
                </div>
                
                 </div>
             </div>
             </div>
             <?php } ?>
             
             <hr style="clear:both;">
             
             <div id="error"><span id="error_message"></span></div>
             
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
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="menu_checkbox" id="menu_checkbox<?php echo $mainvar;?>" onclick="menu_check_all(<?php echo $mainvar; ?>);" name="create<?php echo $i; ?>" value="<?php echo $mainmenudetails->main_menu_id."_0"; ?>" <?php echo $chkedmainmenu[$mainmenudetails->main_menu_id]['checked'];?>><span></span></label> </td>
                        <?php //} ?>
                      
                       
                        
                    </tr>
                    <?php foreach($user_permission_subpages[$mainmenudetails->main_menu_id] as $submenuid=>$submenudetails){ ?>
                    <tr class="td_bg">
                        <td></td>
                        <td> &nbsp; &nbsp; - <?php echo $submenudetails['page_name']; ?></td>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="menu_checkbox sub_menu_chkbox<?php echo $mainvar; ?>" id="sub_menu_chkbox<?php echo $mainvar; ?>" name="create<?php echo $i; ?>" value="<?php echo $mainmenudetails->main_menu_id."_".$submenuid; ?>" <?php echo $chkedsubmenu[$submenuid]['checked'];?>><span></span></label> </td>
                         
                    </tr>
                    
                    <?php $i++; } $i++; $mainvar++;} // user permission pages loop is closed 
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
                        
                    <th><input type="checkbox" class="widget_checked_all"> Edit</th>
                       
                    </tr>
                    </thead>
                    
                    <?php $j=1;foreach($widgetList->result() as $key=>$val) { ?>
                    <tr > 
                        <td><i class="fa fa-trello"></i></td>
                        <td style="color:#000;"> <?php echo $val->widget_name; ?> </td>
                        <td> <label class="ckbox mg-b-0"> <input type="checkbox" class="widget_checkbox" name="widget<?php echo $j; ?>" value="<?php echo $val->widget_id; ?>" <?php echo $chkedwidgets[$val->widget_id]['checked'];?>><span></span></label> </td>
                        
                    </tr>
                    <?php $j++;} ?>
                   <input type="hidden" name="widgetCount" value="<?php echo $j; ?>">
                   
                </table>
                 
                </div>
                 
                 
             </div>
             
             <hr style="clear:both;">
             
          <center>   <input type="submit" name="save" class="btn btn-success btn-sm"></center>
             
             
             
        <?php echo form_close(); ?>
        <!--</form>-->
      </div>
        </div>
      </div>
            
            <script>
                function validateForm()
                {
                    var errors=0;
                    
                        if ($('input[type=checkbox]:checked').length > 0) {
                            
                        } else {
                            errors++;
                            $("#error_message").text('Please select any one of the checkbox below');
                            $("#error").addClass('alert alert-danger');
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
   
