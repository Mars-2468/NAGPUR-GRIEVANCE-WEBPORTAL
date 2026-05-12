

<div class="sh-pagebody" ng-app="photogalleryapp">
    
    <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Add Category</div>
         <div class="card-body pd-sm-10">  
    

 <div class="clearfix"></div>                   
                                 
   <?php
    if ($this->session->flashdata('errors')){
        echo '<div class="alert alert-danger">';
        echo $this->session->flashdata('errors');
        echo "</div>";
    }
    ?>
   
					<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
					<div role="alert" class="alert alert-success content">
					   <button data-dismiss="alert" class="close" type="button">
						   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
					   <strong>Well done!</strong>
					   <?php $this->session->flashdata('SUCCESSMSG') ?>
					</div>
					<?php } ?>
					</br></br>
					
					
				<?php $attributes=array('method'=>'POST', 'onsubmit'=>'return validateForm()'); echo form_open('PostCategoryController/add_cat',$attributes); ?>	
				<!--<form method="post" class="form-horizontal"  action="<?php echo site_url('PostCategoryController/add_cat'); ?>" onsubmit="return validateForm()">-->
					
					<div class="col-md-10 col-md-offset-1">
					
					<div class="col-md-8">			     
					<div class="form-group">
                        <label class="control-label col-sm-5" for="email">Category Name <span style="color: #cc0000">*</span> : </label>
                        <div class="col-sm-7">
                        <input type="text" class="form-control mytext15" name="cat_name" id="cat_name" value=""/ required="required">
                        <br>
                    <span class="myerror"> <?php echo form_error('cat_name');?></span>
                        </div>
                    </div>
                    </div>
                    
                    <div class="col-md-4">                  
                    <div class="form-group"> 
                             <input type="submit" name="submit" class="btn btn-success" value="Submit">
                    </div>
                    </div>
                    
                    </div>
                                    
					</br></br></br>
					<?php echo form_close(); ?>
				<!--</form>-->
								
<div>
    
 
		<?php foreach($report as $key=>$value) {?>
		<div class="alb_list_bg" style="clear:both;">
    		<div class="photoalbum-list">
        		<div class="col-md-1"><img src="assets/img/categories_icon.png" width="40" height="40" style="margin-top: 0px;"></div>
        		<div class="col-md-5 ">
        		    <div class="category_title ng-binding row_data" edit_type="click" id="page_name_page_<?php echo $value->page_id; ?>"> <?php echo $value->page_name; ?></div>
        		    <div class=""><span class="album_name"> Category Name </span> &nbsp; </div>
        		    <div style="display:none;" id="err_msg_category_name_div_<?php echo $value->page_id; ?>"><span style="color:red;padding-left:18px;" id="err_msg_category_name_<?php echo $value->page_id; ?>"></span></div>
        		    <div style="display:none;" id="success_msg_category_name_div_<?php echo $value->page_id; ?>"><span style="color:green;padding-left:18px;" id="success_msg_category_name_<?php echo $value->page_id; ?>"></span></div>
        		</div>
        		<div class="col-md-2">
        		    <div class="listalbum_title ng-binding"></div>
        		    <div class="listalbum_title ng-binding" ><?php echo $value->author;?></div>
        		    <div class="album_name">Created By</div>
        		</div>
        		<div style="margin-top:15px;" class="col-md-4" id="edit_div_<?php echo $value->page_id; ?>">
        		    <button type="button" class="btn btn-info btn-sm btn_edit" id="<?php echo $value->page_id; ?>" ><i class="fa fa-pencil"></i> Edit</button>
        		    <button type="button" class="btn btn-danger btn-sm btn_delete" id="<?php echo $value->page_id; ?>" ><i class="fa fa-trash"></i> Delete</button>
        		</div>
        		<div  class="col-md-5" id="save_cancel_div_<?php echo $value->page_id; ?>" style="display:none;margin-top:15px;">
        		    <button type="button" class="btn btn-success btn-sm btn_save"  id="<?php echo $value->page_id; ?>" ><i class="fa fa-check"></i> Save</button>
        		    <button type="button" class="btn btn-warning btn-sm btn_cancel"  id="<?php echo $value->page_id; ?>" ><i class="fa fa-times"></i> Cancel</button>
        		</div>
    		</div>
		</div>
		<?php  } ?>
	 
</div>

</div>
</div>

</div>
<script>
    $(document).ready(function(){ 
    
        $(document).on('click', '.btn_edit', function(event){
            var id = $(this).attr('id');
            var vv = $("#page_name_page_"+id).text();
           
            $("#save_cancel_div_"+id).show();
            $("#edit_div_"+id).hide();
            
            $("#page_name_page_"+id).attr('contentEditable', 'true')
				.attr('edit_type', 'button')
				.addClass('albname_edit_text')
				.css('padding','3px')
			$("#page_name_page_"+id).find('.row_data').each(function(index, val) 
			{  
				//this will help in case user decided to click on cancel button
				$(this).attr('original_entry', $(this).html());
			}); 	
        });
        
        $(document).on('click', '.btn_save', function(event){
            
            var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';

            var id = $(this).attr('id');
            var modal_category_name1 = $("#page_name_page_"+id).text();
            var modal_category_name = $.trim(modal_category_name1);
            //alert('modal_category_name is '+modal_category_name);
            if(modal_category_name == ''){
                $("#err_msg_category_name_div_"+id).show();
                $("#err_msg_category_name_"+id).html('Category Name is Required');
                return false;
            }
            
            $.post('http://municipalservices.in/sites/admin/PostCategoryController/checkingcatInfo',{id:id,md_cat_name:modal_category_name,'csrf_test_name': csrf_value},function(data){
                //alert(data);
                if (data != 'true'){
                    $("#err_msg_category_name_div_"+id).hide();
                    $("#err_msg_category_name_"+id).html('');
                    $.post('http://municipalservices.in/sites/admin/PostCategoryController/updatecatInfo',{id:id,md_cat_name:modal_category_name,'csrf_test_name': csrf_value},function(data){
                        //alert(data);
                        if(data=='true'){
                            alert('Updated successfully');
                            location.reload();
                            
                        }else{
                            alert('Unable to update');
                        }
                    });
                }else{
                    $("#err_msg_category_name_div_"+id).show();
                    $("#err_msg_category_name_"+id).html("Category Name already Exists!");
                }
            });
        });
        $(document).on('click', '.btn_cancel', function(event){
            
            
            var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';

            var id = $(this).attr('id');
            //alert(id);
           /* $("#err_msg_category_name_div_"+id).hide();
            $("#err_msg_category_name_"+id).html('');
            $("#save_cancel_div_"+id).hide();
            $("#edit_div_"+id).show();
            $("#page_name_page_"+id).attr('contentEditable', 'false')
			.attr('edit_type', '')
			.removeClass('albname_edit_text')
			.css('padding','')*/
            
            $.post('http://municipalservices.in/sites/admin/PostCategoryController/gettingcatInfo',{id:id,'csrf_test_name': csrf_value},function(data){
                //alert(data);
                
                var obj = JSON.parse(data);
                $("#page_name_page_"+id).text(obj[0].page_name);
                
                $("#err_msg_category_name_div_"+id).hide();
                $("#err_msg_category_name_"+id).html('');
                $("#save_cancel_div_"+id).hide();
                $("#edit_div_"+id).show();
                $("#page_name_page_"+id).attr('contentEditable', 'false')
				.attr('edit_type', '')
				.removeClass('albname_edit_text')
				.css('padding','')
            });
            
        });
        $(document).on('click','.btn_delete', function(event){
            
            
            var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';

            var id = $(this).attr('id');
            var modal_category_name = $("#page_name_page_"+id).text();
           
            //alert(id+" "+modal_category_name);
            $("#err_msg_category_name_div_"+id).hide();
            $("#err_msg_category_name_"+id).html('');
            
            if(confirm('Are sure you want to delete this record')){
        		$.post('http://municipalservices.in/sites/admin/PostCategoryController/deletecatInfo',{id:id,'csrf_test_name': csrf_value},function(data){
        		    //alert(data);
                    if(data=='true'){
                        alert('Deleted successfully');
                        location.reload();
                        
                    }else{
                        alert('Unable to update');
                    }
        		    
        		});
            }
        });
    });
</script>
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">
        <div class="modal-header mymodhead_bg">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Edit</h5>
        </div>
        <div class="modal-body" style="padding: 15px !important;">
            
            <!--<form method="post" class="form-horizontal" >
								     
				<div class="form-group">
                    <label class="control-label col-sm-4" for="modal_category_name">Category Name <span style="color: #cc0000">*</span> : </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control mytext15" name="modal_category_name" id="modal_category_name" value="" required/>
                    </div>
                    <div style="display:none;" id="err_msg_category_name_div"><span style="color:red;padding-left:18px;" id="err_msg_category_name"></span></div>
                </div>
                                      
                <div class="form-group"> 
                     <div class="col-sm-offset-3 col-sm-8">
                         <input type="submit" name="Save Changes" onsubmit=""  class="btn btn-success">
                         <button type="button" name="Save Changes" onclick="getInfo()"  class="btn btn-success">Save Changes</button>
                         <button type="submit" class="btn btn-default" >Cancel</button>
                     </div>               
                </div>                   
                                    
				</br></br>
			</form>-->
            
            <div class="col-md-12 form-horizontal">
                <input type="hidden" id="page_name_id" value="" />
                <div class="form-group">
                    <label for="email">Category Name <span style="color: #cc0000">*</span> :</label>
                    <input type="text" class="form-control" id="modal_category_name" placeholder="" required />
                    <div style="display:none;" id="err_msg_category_name_div"><span style="color:red;padding-left:18px;" id="err_msg_category_name"></span></div>
                </div>
            </div>
        </div>
        <div class="modal-footer form-group">
            
          <button type="submit" class="btn btn-success" onclick="getInfo()" >Save Changes</button>
          <button type="reset" class="btn btn-default" >Cancel</button>
        </div>
      </div>
    </div>
  </div>

 