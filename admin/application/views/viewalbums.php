<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


      <div class="sh-pagebody">
      
      <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white"></div>
         <div class="card-body ">
      
      
      <div id="message"></div>
      
      <div style="display:inline-flex;">
          <div class="mypagetitile">View Albums</div>    
            <a id="newalbum" class="btn text-white btn-primary btn-sm mg-b-10">Add album</a>
            <!--<a id="newsubalbum" class="btn btn-default btn-sm mg-b-10">Add sub album</a>-->
      </div>
      
      
      <br>
     
<div  id="albumarea" style="display:none;">
     <hr>
      <div class="col-md-12" >
          
    <div>
        <form class="form-horizontal">
            <div class="row">
                <div class="col-md-3">
                   <div class="form-group ml-0 mr-0">
              <label class="control-label" for="textinput">Date</label>  
              <div>
              <input id="cdate" name="cdate" placeholder="Enter Date" class="form-control input-md" type="date" required="reqiured" />
              </div>
             
        </div>  
                </div>
                 <div class="col-md-3">
                   <div class="form-group ml-0 mr-0">
              <label class="control-label" for="textinput">Name of Program</label>  
              <div>
              <input id="albumname" name="albumname" placeholder="Enter Name of Program" class="form-control input-md" type="text" data-type="text" onkeyup="funInputFielTypes(this)" required="reqiured" />
             <div style="font-size:10px;color:red;" id="albumnameX"></div>
			 </div>
             
        </div>  
                </div>
               <!-- <div class="col-md-3">
                   <div class="form-group ml-0 mr-0">
              <label class="control-label" for="textinput">Mandal</label>  
              <div>
              <input id="mandal" name="mandal" placeholder="Enter Mandal" class="form-control input-md" type="text" required="reqiured" />
              </div>
             
        </div>  
                </div>
                  <div class="col-md-3">
                   <div class="form-group ml-0 mr-0">
              <label class="control-label" for="textinput">Village</label>  
              <div>
              <input id="village" name="village" placeholder="Enter Village" class="form-control input-md" type="text" required="reqiured" />
              </div>
             
        </div>  
                </div>
                  <div class="col-md-3">
                   <div class="form-group ml-0 mr-0">
              <label class="control-label" for="textinput">Contact Person Name</label>  
              <div>
              <input id="cname" name="cname" placeholder="Enter Contact Person Name" class="form-control input-md" type="text" required="reqiured" />
              </div>
             
        </div>  
                </div> 
                <div class="col-md-3">
                   <div class="form-group ml-0 mr-0">
              <label class="control-label" for="textinput">Mobile No</label>  
              <div>
              <input id="cmobile" name="cmobile" placeholder="Enter Mobile No" class="form-control input-md" maxlength="10" type="number" required="reqiured" />
              </div>
             
        </div>  
                </div>-->
                 <!-- <div class="col-md-3">
                   <div class="form-group ml-0 mr-0">
              <label class="control-label" for="textinput">Upload Photos</label>  
              <div>
              <input id="albumname" name="albumname" placeholder="Enter Upload Photos" class="form-control input-md" type="file" required="reqiured" />
              </div>
             
        </div>  
                </div>-->
                 <div class="col-md-12">
                     <center>
                     <input type="button" id="submitBtn" value="Add" class="btn btn-success btn-sm">
                     </center>
                     </div>
            </div>
            <br>
             <br>
       
        <div id="add_album_err_msg_div"><span id="add_album_err_msg" style="color:red;padding-left:128px;"></span></div>
        </form>
    </div> 
  </div>
</div>

<div  id="subalbumarea" style="display:none;">
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
<?php foreach($albums_list->result() as $key=>$val){?>
      <hr style="clear:both;">
      
     <div><!--- angular app-->
     <div><!-- angular controller-->
       
     <div>
      <div class="alb_list_bg" style="clear:both;">
		
		<div class="photoalbum-list">
		<div class="col-md-1"><img src="assets/img/photo_icon.png" width="40" height="40" style="margin-top: 11px;"></div>
		<div style="display:none;"></div>
		<div class="col-md-5 right_bor" id="album_desc_header_div">
		    <table>
		        <tr row_id="<?php echo $val->album_id; ?>">
		            <td>
		                <div class="listalbum_title row_data" edit_type="click" id="album_desc_name_<?php echo $val->album_id; ?>"><?php echo $val->album_desc; ?></div>
		                <div class=""><span class="album_name"> Album Name </span> &nbsp; | &nbsp;<span class="album_name">Last Updated </span>: <span class="album_date"> <?php echo $val->lastUpdatedBy; ?> </span></div>
            		    <div id="edit_delete_div" class="edit_delete_div"><a href="#" class="btn_edit" id="album_id">Edit</a> &nbsp; | &nbsp; <a href="#" class="btn_delete">Delete</a> </div>
            		    <div style="display:none;" class="save_cancel_div"><a href="#" class="btn_save">Save</a> &nbsp; | &nbsp; <a href="#" class="btn_cancel">Cancel</a> </div>
            		    <div style="display:none;" class="error_msg_div"><span id="error_msg_span" style="color:red;"></span></div>
		            </td>
		        </tr>
		    </table>
		    <!--<div class="listalbum_title row_data" edit_type="click" id="album_desc_name_{{x.album_id}}"> {{x.album_desc}}</div>-->
		    <!--<div class=""><span class="album_name"> Album Name </span> &nbsp; | &nbsp;<span class="album_name">Last Updated </span>: <span class="album_date">  {{x.lastUpdatedTS}} </span></div>-->
		    <!--<div id="edit_delete_div_{{x.album_id}}"><a href="#" onclick='edit("'{{x.album_id}}'")' id="{{x.album_id}}">Edit</a> &nbsp; | &nbsp; <a href="#" class="btn_delete_{{x.album_id}}">Delete</a> </div>-->
		    <!--<div style="display:none;" id="save_cancel_div_{{x.album_id}}"><a href="#" class="btn_save_{{x.album_id}}">Save</a> &nbsp; | &nbsp; <a href="#" class="btn_cancel_{{x.album_id}}">Cancel</a> </div>-->
		</div>
		<div class="col-md-2 right_bor">
		    <div class="listalbum_title"><?php echo date('d-m-Y h:i:s',strtotime($val->ts)); ?></div>
		    <?php echo $val->lastUpdatedBy; ?>
		    <div class="album_name">Last Updated By</div>
		    
		</div>
	<div class="col-md-2 right_bor">
		    <div class="imgs_count"><i class="fa fa-image"></i> <?php echo $counts[$val->album_id]['count']; ?></div>
		    <div class="album_name">No of photos uploaded  </div>
		</div>
		
		<div class="col-md-2 d-flex align-items-center">
		    <center>
		        
		    <a href="create-photo-gallery/<?php echo $val->album_id; ?>" class="btn btn-success btn-sm " style="margin-top: 7px;">View / Add Photos</a>
		    
		    
		    <?php //echo $data['album_id'] ?>
		    
		    </center>
		</div>    
		
		</div>
	</div>
</div>	
</div><!-- angular controller end -->


</div>

<?php } ?>













<!-- angular app end-->
        <!--<script src="<?php echo base_url()?>assets/angularjs/angular.min.js"></script>
        <script src="<?php echo base_url()?>assets/angularjs/apps.js"></script>
        <script src="<?php echo base_url()?>assets/angularjs/viewalbumcontroller.js"></script>-->


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
            $.get('ViewAlbumsController/checkingAlbumName',{album_desc:albumname,'csrf_test_name': csrf_value},function(data){
                if(data == 'true'){
                    $("#add_album_err_msg_div").show();
            	 	$("#add_album_err_msg").show();
            	 	$("#add_album_err_msg").html('Album Name Already Exists!');
                }
            });
        }
    });
    $("#submitBtn").click(function()
    {
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var albumname=$("#albumname").val();
        // var cname=$("#cname").val();
        // var cmobile=$("#cmobile").val();
        // var mandal=$("#mandal").val();
        // var village=$("#village").val();
        var cdate=$("#cdate").val();
        if(albumname =='')
        {
            //alert('Please enter album name');
            $("#add_album_err_msg_div").show();
    	 	$("#add_album_err_msg").show();
    	 	$("#add_album_err_msg").html('Please Enter Album Name');
            return false;
        }
    //     if(cmobile.length != 10){
    //          $("#add_album_err_msg_div").show();
    // 	 	$("#add_album_err_msg").show();
    // 	 	$("#add_album_err_msg").html('Enter Valid Mobile Number');
    //         return false;
    //     }
    alert(albumname);
        
        $.get('ViewAlbumsController/checkingAlbumName',{album_desc:albumname,'csrf_test_name': csrf_value},function(data){
          
            alert(data);
            if(data != 'true'){  
                
                $.get('ViewAlbumsController/submitBtn',{cdate:cdate,albumname:albumname,'csrf_test_name': csrf_value},function(data)
                {
                    alert(data);
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
        $.get('ViewAlbumsController/addSubAlbum',{album_id:album_id,subalbumname:subalbumname},function(data)
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
        $.get('ViewAlbumsController/checkingAlbumName',{album_desc:save_album_desc,'csrf_test_name': csrf_value},function(data){
            //alert(data);
            //var obj = JSON.parse(data);
            //var album_desc_check = obj[0].album_desc;
            if(data != 'true'){
                $.get('ViewAlbumsController/updateAlbumName',{album_id:save_album_id,album_desc:save_album_desc,'csrf_test_name': csrf_value},function(data){
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

        $.get('ViewAlbumsController/getAlbumName',{album_id:album_id,'csrf_test_name': csrf_value},function(data){
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
    		$.get('ViewAlbumsController/deleteAlbum',{album_id:album_id,'csrf_test_name': csrf_value},function(data){
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
      
      
      
      
      
      
      
      
      
      
      
   
