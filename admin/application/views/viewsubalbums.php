<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


      <div class="sh-pagebody">
      
      <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white"></div>
         <div class="card-body ">
      
      
      <div id="message"></div>
      
      <div style="display:inline-flex;">
          <div class="mypagetitile">View Sub Albums</div>    
           
      </div>
      
      
      <br>
     
<div  id="albumarea" style="display:none;">
     <hr>
      <div class="col-md-8 col-md-offset-2" >
          
   
  </div>
</div>

<div  id="subalbumarea">
     <hr>
      <div class="col-md-8 col-md-offset-2" >
          
    <div>
        <form class="form-horizontal">
        <div class="form-group">
               
               
                <div class="col-md-5">
                    <label class="control-label" for="textinput"> Select Album </label>
                    <select name ="albumid" id="albumid" class="form-control">
                        <option value="">--- select-- </option>
                        <?php foreach($albums_list->result() as $key=>$val){?>
                        <option value="<?php echo $val->album_id; ?>"> <?php echo $val->album_desc; ?> </option>
                        <?php } ?>
                    </select>
                </div>
              
              
              <div class="col-md-5">
              <label class="control-label" for="textinput">Sub Album Name</label>  
              <input id="subalbumname" name="subalbumname" placeholder="Enter sub album name" class="form-control input-md" type="text" required="reqiured" />
              </div>
              <div class="col-md-1"><input type="button" id="addsubalbum" value="Add Sub Album" class="btn btn-success btn-sm"></div>
        </div>
        <div id="add_album_err_msg_div"><span id="add_album_err_msg" style="color:red;padding-left:128px;"></span></div>
        </form>
    </div> 
  </div>
</div>
      <hr style="clear:both;">
      
     <div ng-app="viewAlbumsApp"><!--- angular app-->
     <div ng-controller="viewAlbumsController"><!-- angular controller-->
     
     
     
     
     
     
     <?php foreach($albums_list->result() as $key=>$val){?>
     
     <div><?php echo $val->album_desc; ?></div>
     <?php foreach($sub_album_list[$val->album_id] as $sub_album_id=>$subalbumdet){?>
     <div>
      <div class="alb_list_bg" style="clear:both;">
		
		<div class="photoalbum-list">
		<div class="col-md-1"><img src="assets/img/photo_icon.png" width="40" height="40" style="margin-top: 11px;"></div>
		<div style="display:none;">{{x.album_id}}</div>
		<div class="col-md-5 right_bor" id="album_desc_header_div">
		    <!--<table>
		        <tr row_id="{{x.album_id}}">
		            <td>
		                <div class="listalbum_title row_data" edit_type="click" id="album_desc_name_{{x.album_id}}"> <?php echo $subalbumdet['sub_album_name']; ?> </div>
		                <div class=""><span class="album_name"> Album Name </span> &nbsp; | &nbsp;<span class="album_name">Last Updated </span>: <span class="album_date">  <?php echo $subalbumdet['lastUpdatedTS']; ?> </span></div>
            		    <div id="edit_delete_div_{{x.album_id}}" class="edit_delete_div"><a href="#" class="btn_edit" id="{{x.album_id}}">Edit</a> &nbsp; | &nbsp; <a href="#" class="btn_delete">Delete</a> </div>
            		    <div style="display:none;" class="save_cancel_div"><a href="#" class="btn_save">Save</a> &nbsp; | &nbsp; <a href="#" class="btn_cancel">Cancel</a> </div>
            		    <div style="display:none;" class="error_msg_div"><span id="error_msg_span" style="color:red;"></span></div>
		            </td>
		        </tr>
		    </table>-->
		    
		    <table>
		        <tr row_id="<?php echo $data['album_id'] ?>">
		            <td>
		                <div class="listalbum_title row_data" edit_type="click" id="album_desc_name_<?php echo $data['album_id'] ?>"><?php echo $data['album_desc'] ?></div>
		                <div class=""><span class="album_name"> Album Name </span> &nbsp; | &nbsp;<span class="album_name">Last Updated </span>: <span class="album_date"> <?php echo $data['lastUpdatedBy'] ?> </span></div>
            		    <div id="edit_delete_div" class="edit_delete_div"><a href="#" class="btn_edit" id="album_id">Edit</a> &nbsp; | &nbsp; <a href="#" class="btn_delete">Delete</a> </div>
            		    <div style="display:none;" class="save_cancel_div"><a href="#" class="btn_save">Save</a> &nbsp; | &nbsp; <a href="#" class="btn_cancel">Cancel</a> </div>
            		    <div style="display:none;" class="error_msg_div"><span id="error_msg_span" style="color:red;"></span></div>
		            </td>
		        </tr>
		    </table>
		    
		</div>
		<div class="col-md-2 right_bor">
		    <div class="listalbum_title"><?php echo $subalbumdet['lastUpdatedBy']; ?></div>
		    <div class="album_name">Last Updated By</div>
		    
		</div>
		<div class="col-md-2 right_bor">
		    <div class="imgs_count"><i class="fa fa-image"></i> <?php echo $album_photos_count[$val->album_id][$sub_album_id]['count']?> Photos uploaded</div>
		    <div class="album_name">No of photos uploaded  </div>
		</div>
		
		<div class="col-md-2">
		    <center>
		    <a href="create-subphoto-gallery/<?php echo $val->album_id; ?>/<?php echo $sub_album_id; ?>" class="btn btn-success btn-xs " style="margin-top: 7px;">View / Add Photos</a>
		    </center>
		</div>    
		
		</div>
	</div>
</div>
<?php } ?>
<?php } ?>




</div><!-- angular controller end -->


</div><!-- angular app end-->
        <script src="<?php echo base_url()?>assets/angularjs/angular.min.js"></script>
        <script src="<?php echo base_url()?>assets/angularjs/apps.js"></script>
        <script src="<?php echo base_url()?>assets/angularjs/viewalbumcontroller.js"></script>


 </div>
  </div>


 </div>
 
 <script>
$(document).ready(function(){
    //var album_id_text;
    $("#newalbum").click(function(){
        $("#albumarea").slideToggle();
        $("#subalbumarea").css('display','none');;
    });
    
    $("#newsubalbum").click(function(){
        $("#subalbumarea").slideToggle();
        $("#albumarea").css('display','none');
    });
    
    
    $("#add_album_err_msg_div").hide();
 	$("#add_album_err_msg").hide();
 	$("#add_album_err_msg").html('');
    
    $("#albumname").keyup(function(){
        //alert("keyup");
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var albumname=$("#albumname").val();
        //alert(albumname);
        if(albumname =='')
        {
            $("#add_album_err_msg_div").show();
    	 	$("#add_album_err_msg").show();
    	 	$("#add_album_err_msg").html('Please Enter Album Name');
            return false;
        }else{
            $("#add_album_err_msg_div").hide();
         	$("#add_album_err_msg").hide();
         	$("#add_album_err_msg").html('');
            $.post('ViewAlbumsController/checkingAlbumName',{album_desc:albumname,'csrf_test_name': csrf_value},function(data){
                if(data == 'true'){
                    $("#add_album_err_msg_div").show();
            	 	$("#add_album_err_msg").show();
            	 	$("#add_album_err_msg").html('Album Name Already Exists!');
                }
            });
        }
    });
    $("#addalbum").click(function()
    {
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var albumname=$("#albumname").val();
        if(albumname =='')
        {
            //alert('Please enter album name');
            $("#add_album_err_msg_div").show();
    	 	$("#add_album_err_msg").show();
    	 	$("#add_album_err_msg").html('Please Enter Album Name');
            return false;
        }
        
        $.get('ViewAlbumsController/checkingAlbumName',{album_desc:albumname,'csrf_test_name': csrf_value},function(data){
          
            //alert(data);
            if(data != 'true'){  
                $.get('ViewAlbumsController/addAlbum',{albumname:albumname,'csrf_test_name': csrf_value},function(data)
                {
                    //alert(data);
                    location.reload();
                    $("#add_album_err_msg_div").hide();
            	 	$("#add_album_err_msg").hide();
            	 	$("#add_album_err_msg").html('');
                });
            }else{
                $("#add_album_err_msg_div").show();
        	 	$("#add_album_err_msg").show();
        	 	$("#add_album_err_msg").html('Album Name Already Exists!');
            }
            
        });
         
    });
    
    
    $("#addsubalbum").click(function()
    {
        var album_id = $("#albumid").val();
        var subalbumname  = $("#subalbumname").val();
        $.get('ViewSubAlbumsController/addSubAlbum',{album_id:album_id,subalbumname:subalbumname},function(data)
        {
            $("#message").html(data);
        });
        //return false;
    });
    
    $(document).on('click', '.btn_edit', function(event){
        event.preventDefault();
        //alert("edit");
        var tbl_row = $(this).closest('tr');
		album_id_text = tbl_row.attr('row_id');
        //alert(album_id_text);
		tbl_row.find('.save_cancel_div').show();
        
		//hide edit button
		tbl_row.find('.edit_delete_div').hide(); 

        tbl_row.find(".error_msg_div").hide();
	 	tbl_row.find("#error_msg_span").hide();
	 	tbl_row.find("#error_msg_span").html('');
		//make the whole row editable
		tbl_row.find('.row_data')
		.attr('contenteditable', 'true')
		.attr('edit_type', 'button')
		.addClass('albname_edit_text')
		.css('padding','3px')

		//--->add the original entry > start
		tbl_row.find('.row_data').each(function(index, val) 
		{  
			//this will help in case user decided to click on cancel button
			$(this).attr('original_entry', $(this).html());
		});
    });
    /*alert("album_desc_name_"+album_id_text);
    $("#album_desc_name_"+album_id_text).click(function(){
        alert('cfcf');
        var desc = $("#album_desc_name_"+album_id_text).val();
        alert(desc);
    });*/
    $(document).on('click', '.btn_save', function(event){
  		event.preventDefault();
  		var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
	 	var tbl_row = $(this).closest('tr');
		var save_album_id = tbl_row.attr('row_id');
        
        var album_desc = $("#album_desc_name_"+save_album_id).text();
        var save_album_desc = $.trim(album_desc);
        //alert(save_album_desc);
        if(save_album_desc =='')
        {
            //alert('Please enter album name');
            tbl_row.find(".error_msg_div").show();
    	 	tbl_row.find("#error_msg_span").show();
    	 	tbl_row.find("#error_msg_span").html('Please Enter Album Name');
            return false;
        }
        $.post('ViewAlbumsController/checkingAlbumName',{album_desc:save_album_desc,'csrf_test_name': csrf_value},function(data){
            //alert(data);
            //var obj = JSON.parse(data);
            //var album_desc_check = obj[0].album_desc;
            if(data != 'true'){
                $.post('ViewAlbumsController/updateAlbumName',{album_id:save_album_id,album_desc:save_album_desc,'csrf_test_name': csrf_value},function(data){
                    //alert(data);
                    if(data=='true'){
                        alert('Updated successfully');
                        tbl_row.find('.save_cancel_div').hide();
        
        				//hide edit button
        				tbl_row.find('.edit_delete_div').show();
                        
                        tbl_row.find(".error_msg_div").hide();
                	 	tbl_row.find("#error_msg_span").hide();
                	 	tbl_row.find("#error_msg_span").html('');
        				tbl_row.find('.row_data')
        				.attr('contenteditable', 'false')
        				.attr('edit_type', '')
        				.removeClass('albname_edit_text')
        				.css('padding','') 
                    }else{
                        alert('Unable to update');
                    }
                });
            }else{
                //alert("Album Name Already Exists!");
                tbl_row.find(".error_msg_div").show();
        	 	tbl_row.find("#error_msg_span").show();
        	 	tbl_row.find("#error_msg_span").html('Album Name already Exists!');
            }
        });
  	});
  	$(document).on('click', '.btn_cancel', function(event){
  		event.preventDefault();
  		
  		var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
	 	var tbl_row = $(this).closest('tr');
        var album_id = tbl_row.attr('row_id');

        $.post('ViewAlbumsController/getAlbumName',{album_id:album_id,'csrf_test_name': csrf_value},function(data){
            //alert(data);
            var obj = JSON.parse(data);
            $("#album_desc_name_"+album_id).text(obj[0].album_desc);
            tbl_row.find('.save_cancel_div').hide();

    		//hide edit button
    		tbl_row.find('.edit_delete_div').show();
            tbl_row.find(".error_msg_div").hide();
    	 	tbl_row.find("#error_msg_span").hide();
    	 	tbl_row.find("#error_msg_span").html('');
    		tbl_row.find('.row_data')
    		.attr('contenteditable', 'false')
    		.attr('edit_type', '')
    		.removeClass('albname_edit_text')
    		.css('padding','')
        });
  	});
  	$(document).on('click','.btn_delete', function(event){
  		event.preventDefault();
  		
  		
  		var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
  		var tbl_row = $(this).closest('tr');
		var album_id = tbl_row.attr('row_id');
		tbl_row.find(".error_msg_div").hide();
	 	tbl_row.find("#error_msg_span").hide();
	 	tbl_row.find("#error_msg_span").html('');
		if(confirm('Are sure you want to delete this record'))
        {
    		$.post('ViewAlbumsController/deleteAlbum',{album_id:album_id,'csrf_test_name': csrf_value},function(data){
    		    //alert(data);
                if(data==1){
                    alert('Deleted successfully');
                    location.reload();
                    
                }else{
                     alert('Deleted successfully');
                    location.reload();
                }
    		    
    		});
        }
  	});
});
</script>
      
      
      
      
      
      
      
      
      
      
      
   
