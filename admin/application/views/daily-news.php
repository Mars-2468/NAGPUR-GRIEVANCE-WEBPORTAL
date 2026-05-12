<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <script src="<?php echo base_url(); ?>/assets/js/custome/cryptojs/rollups/md5.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/custome/cryptojs/components/md5.js"></script>
    <script>
        function validateForm()
        {
               
                var pwd=$("#password").val();
                var encpwd=CryptoJS.MD5(pwd);
                if($("#fk").val(encpwd))
                {
                   return true;
                }
        }
    </script>
<div class="sh-pagebody">
     <?php if($this->session->flashdata('message')){?>
            <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
        <?php }?>
    
    <?php $attributes=array('id'=>'form1','autocomplete'=>'off','onsubmit'=>' return validateForm()'); echo form_open_multipart('',$attributes);?>
        <!--<div class="form-group col-md-3">-->
        <!--    <label class=" control-label" for="textinput">User ID</label>  -->
        <!--    <div class="">-->
        <!--        <input id="user_id" name="user_id" placeholder="Enter User ID" class="form-control input-md mytext" type="text" required>-->
        <!--    </div>-->
        <!--</div>-->
          
        <h4>Daily News</h4>
                
                <br>
         
         <div class="row justify-content-center">
                            <form action="" method="post" enctype="multipart/form-data">
                               <div class="form-group col-md-3">
            			    	<label>Date</label>
            				    <input type="date" class="form-control" id ="Date" name="Date" value="" placeholder=" " required>
            				   </div>
            				   
            		           <div class="form-group col-md-3">
            			    	<label>Type of News</label>
            				     <select class="form-control" name="NewsType" id="NewsType" required>
            				         <option>- Select - </option>
            				         <option> Positive </option>
            				         <option> Negative </option>
            				     </select>
            				   </div>
            		        
                              <div class="form-group col-md-3">
            			    	<label>Paper Name</label>
            				     <select class="form-control" name="PaperName" id="PaperName" required>
            				         <option value="">- Select - </option>
            				         <option value="1"> Namaste Telangana </option>
            				         <option value="2"> Eenadu </option>
            				         <option value="3"> Sakshi </option>
            				         <option value="4"> Andhrajyothi </option>
            				         <option value="5"> Andhrabhoomi </option>
            				         <option value="6"> Andhraprabha </option>
            				         <option value="7"> Varta </option>
            				         <option value="8"> Velugu </option>
            				         <option value="9"> Mana Telangana </option>
            				         <option value="10"> Nava Telangana </option>
            				         <option value="11"> Satya News </option>
            				         <option value="12"> Addab Hyderabad </option>
            				         <option value="13"> Prahanjanam </option>
            				         <option value="14"> Other </option>
            				     </select>
            				   </div>
            				   
            				    <div class="form-group col-md-3">
            			    	<label>Upload</label>
            				    <input type="file" class="form-control" name="f1" id="f1" value="" placeholder=" " required>
            				   </div>
            			        
                   </div>
         
        
                <center>
                        
                        <input type="submit" value="Submit" class="btn btn-success" name="submit" id="butundisab" />
                </center>
        
        </form>
        
        <br><br><br><br>
        
        <table class="table table-bordered main-table" style=" " id="main-table">
	         
	        <thead> 
	            <tr >
	                <td style="width: 60px;">S No.</td>
	                <td style="width: 100px;">Date</td>
	                <td style="width: 150px;">Type of News</td>
	                <td style="width: 150px;">Paper Name</td>
	                <td style="width: 150px;">Upload</td>
	            </tr>
	      </thead>
	      
	        <tbody>
                <tr>
                    <td>1</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td
                    <td>-</td>
                </tr>
	            	
	        </tbody>
	   </table>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    <?php echo form_close(); ?>
    
    <?php if($password != ''){ ?>
        <div>
            <?php echo sha1(sha1_bin($password)) ?>
        </div>
    <?php } ?>
</div>


  <script>
$(document).ready(function() {
    $('#butundisab').click(function(event){
    
        data = $('.password').val();
        
        //alert(data);
        
        var len = data.length;
        
        //alert(len); 
        
        if(len < 1) {
            
           // alert("Password cannot be blank");
            // Prevent form submission
            
            event.preventDefault();
        }
         
        if($('.password').val() != $('.password_again').val()) {
            //alert("Password and Confirm Password don't match");
            $('#disp').show();
            // Prevent form submission
            event.preventDefault();
        }
         
    });
});
</script>