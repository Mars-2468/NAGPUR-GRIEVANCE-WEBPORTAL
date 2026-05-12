<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script  src = "<?php echo base_url() ?>assets/js/tags.js"></script><!-- // this is for tags -->

<style>
     fieldset.scheduler-border {
border: 1px groove #ddd !important;
padding: 20px 37px 20px 37px !important;
margin: 0 0 1.5em 0 !important;
-webkit-box-shadow: 0px 0px 0px 0px #000;
box-shadow: 0px 0px 0px 0px #000;
}

legend.scheduler-border {
font-size: 14px !important;
font-weight: bold !important;
text-align: left !important;
}

legend {
width: 30% !important;
border-bottom: 0px solid #e5e5e5 !important;
margin-bottom: 0px !important;
background-color:#2f89fc;
color:#FFF;
border-radius:3px;

}

/*-------for tags css --------*/

.bootstrap-tagsinput {
  background-color: #fff;
  border: 1px solid #ccc;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  /*display: inline-block;*/
  padding: 4px 6px;
  color: #555;
  vertical-align: middle;
  border-radius: 4px;
  max-width: 100%;
  line-height: 22px;
  cursor: text;
  border:1px #ccc solid !important;
}

.bootstrap-tagsinput input {
  border: none;
  box-shadow: none;
  outline: none;
  background-color: transparent;
  padding: 0 6px;
  margin: 0;
  width: auto;
  max-width: inherit;
  width:500px;
}
.bootstrap-tagsinput.form-control input::-moz-placeholder {
  color: #777;
  opacity: 1;
}
.bootstrap-tagsinput.form-control input:-ms-input-placeholder {
  color: #777;
}
.bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
  color: #777;
}
.bootstrap-tagsinput input:focus {
  border: none;
  box-shadow: none;
}
.bootstrap-tagsinput .tag {
  margin-right: 2px;
  color: white;
}
.bootstrap-tagsinput .tag [data-role="remove"] {
  margin-left: 8px;
  cursor: pointer;
}
.bootstrap-tagsinput .tag [data-role="remove"]:after {
  content: "x";
  padding: 0px 2px;
}
.bootstrap-tagsinput .tag [data-role="remove"]:hover {
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
}
.bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
  box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
}

    
 .bootstrap-tagsinput .label{
     font-size:13px;
     font-weight:normal;
 }   
    .bootstrap-tagsinput .tag [data-role="remove"]{
        
        opacity:1;
    }
    
    .bootstrap-tagsinput .tag [data-role="remove"]::after{
        
       
    }

</style>

<div class="sh-pagebody">

<?php echo $this->session->flashdata('message');?>

<div>
<!--    <?php echo form_open('add-new-site');?>-->
<!--<div class="col-md-4">-->
    
<!--    <div class="panel panel-info">-->
<!--      <div class="panel-heading">Name of ULBs</div>-->
<!--      <div class="panel-body">-->
<!--          <?php foreach($ulblist->result() as $key=>$val){?>-->
<!--          <label class="ckbox">-->
<!--                    <input type="checkbox" id="target" name="check_list[]" value="<?php echo $val->ulbid; ?>-<?php echo $val->ulbname; ?>"><span><?php echo $val->ulbname; ?></span>-->
<!--         </label>-->
<!--          <?php }?>-->
<!--      </div>-->
<!--    </div>-->
    
<!--    <input type="submit" value="Next" name="next1" class="btn btn-primary">-->
    
<!--    <br><br><br>-->
    
<!--</div>-->

<!--<?php echo form_close(); ?>-->

   <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Create New Site</div>
         <div class="card-body ">

<div class="col-md-12">

<?php $attributes=array('method'=>'POST'); echo form_open('add-new-site',$attributes);?>

    <input type="hidden" name="ulbid<?php echo $i; ?>" value="<?php echo $arr[0]; ?>">
    
    
    <div class="form-horizontal">
    
<!--<div class="form-group">-->
<!--  <label class="col-md-4 control-label">Site Layout </label>-->
<!-- <div class="col-md-6"><select class="form-control required" name="theme">-->
<!--     <option value="">--- Select Layout--</option>-->
<!--     <?php foreach($theme_list->result() as $index2=>$val2){?>-->
<!--     <option value="<?php echo $val2->theme_id; ?>"><?php echo $val2->theme_description; ?></option>-->
<!--     <?php } ?>-->
<!--</select>-->
<!--</div>-->
<!--</div>-->

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Name of the ULB <span class="tx-danger">*</span></label>
  <div class="col-md-6 "><input type="text" class="form-control" placeholder="Enter ULB name" name="ulbname" id="ulbname" value="<?php echo $_POST['ulbname'];?>" required="required">
  
  <br>
                    <span class="myerror"> <?php echo form_error('ulbname');?></span>
  
  </div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> District <span class="tx-danger">*</span></label>
  <div class="col-md-6"><!--<input type="text" class="form-control" placeholder="Enter District Name" name="districtname" id="districtname" required>-->
  <select class="form-control" name="districtname" >
      <option value="">-- Select --</option>
      <?php foreach($destrictList->result() as $key=>$val){?>
      <option value="<?php echo $val->distid; ?>"><?php echo $val->distname; ?></option>
      <?php }?>
      
  </select>
  <br>
                    <span class="myerror"> <?php echo form_error('districtname');?></span>
  </div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> System id of the portal <span class="tx-danger">*</span></label>
  <div class="col-md-6"><input type="text" class="form-control" placeholder="System id of the portal" name="systemid" id="systemid" value="<?php echo $_POST['systemid'];?>" required="required">
   <br>
                    <span class="myerror"> <?php echo form_error('systemid');?></span>
                    </div>
 
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Department web portal url <span class="tx-danger">*</span></label>
  <div class="col-md-6"><input type="text" class="form-control" placeholder="Department web portal url" name="base_url" id="base_url" value="<?php echo $_POST['base_url'];?>" required="required">
  
  <br>
                    <span class="myerror"> <?php echo form_error('base_url');?></span>
  </div>
  
</div>

<div style="border-bottom:1px #84f2d6 solid; margin-bottom:15px;"></div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Admin concerned person name <span class="tx-danger">*</span></label>
 <div class="col-md-6"> <input type="text" class="form-control" placeholder="Admin concerned person name" name="admin_concerned_person" id="admin_concerned_person" value="<?php echo $_POST['admin_concerned_person'];?>" required="required">
 <br>
                    <span class="myerror"> <?php echo form_error('admin_concerned_person');?></span>
 
 </div>

</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label">  Designation <span class="tx-danger">*</span></label>
  <div  class="col-md-6">
      <!--<input type="text" class="form-control" placeholder="Designation" name="designation" id="designation" required>-->
      <select class="form-control" name="admin_desigantion" >
      <option value="">-- Select --</option>
      <?php foreach($designationList->result() as $key=>$val){?>
        <option value="<?php echo $val->desg_id; ?>"><?php echo $val->desg_desc; ?></option>
      <?php }?>
      
  </select>
  <br>
                    <span class="myerror"> <?php echo form_error('admin_desigantion');?></span>
   </div>
</div>

 <div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Mobile number  <span class="tx-danger">*</span></label>
  <div  class="col-md-6"><input type="text" class="form-control" placeholder="Mobile number " name="mobile" id="mobile" maxlength="10" value="<?php echo $_POST['mobile'];?>" required="required">
  
  <br>
                    <span class="myerror"> <?php echo form_error('mobile');?></span>
  
  </div>
  
</div>

<hr style="border-bottom:1px #84f2d6 solid; margin-bottom:15px;">

<!--<div class="form-group">-->
<!--  <label for="usr" class="col-md-4 control-label"> Technical person   <span class="tx-danger">*</span></label>-->
<!--  <div  class="col-md-6"><input type="text" class="form-control" placeholder="Technical person " name="tech_name" id="tech_name" required></div>-->
<!--</div>-->

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Technical concerned person name   <span class="tx-danger">*</span></label>
 <div  class="col-md-6"> <input type="text" class="form-control" placeholder="concerned person name " name="tech_concerned_person_name" id="tech_concerned_person_name" value="<?php echo $_POST['tech_concerned_person_name'];?>" required="required">
 <br>
                    <span class="myerror"> <?php echo form_error('tech_concerned_person_name');?></span>
 
 </div>

</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label">  Designation <span class="tx-danger">*</span></label>
  <div  class="col-md-6">
      <!--<input type="text" class="form-control" placeholder="Designation" name="designation" id="designation" required>-->
      <select class="form-control" name="tech_concerned_person_designation">
      <option value="">-- Select --</option>
      <?php foreach($designationList->result() as $key=>$val){?>
        <option value="<?php echo $val->desg_id; ?>"><?php echo $val->desg_desc; ?></option>
      <?php }?>
      
  </select>
  <br>
                    <span class="myerror"> <?php echo form_error('tech_concerned_person_designation');?></span>
   </div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Mobile number   <span class="tx-danger">*</span></label>
  <div  class="col-md-6"><input type="text" class="form-control" maxlength="10" placeholder="Mobile number" name="tech_concerned_person_mobile" id="tech_concerned_person_mobile" value="<?php echo $_POST['tech_concerned_person_mobile'];?>" required="required">
  
  <br>
                    <span class="myerror"> <?php echo form_error('tech_concerned_person_mobile');?></span>
  
  </div>



</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Email id   <span class="tx-danger">*</span></label>
  <div  class="col-md-6"><input type="text" class="form-control" placeholder="Email id" name="tech_concerned_person_email" id="tech_concerned_person_email" value="<?php echo $_POST['tech_concerned_person_email'];?>" required="required">
  
  <br>
                    <span class="myerror"> <?php echo form_error('tech_concerned_person_email');?></span>
  
  </div>

</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Admin username <span class="tx-danger">*</span></label>
  <div class="col-md-6"><input type="text" class="form-control" placeholder="Enter admin user id" name="user_id" autocomplete="off" required="required" value="<?php echo $_POST['user_id'];?>">
  
  <br>
                    <span class="myerror"> <?php echo form_error('user_id');?></span>
  
  </div>

</div>

<div class="form-group" >
  <label for="usr" class="col-md-4 control-label"> Admin password <span class="tx-danger">*</span></label>
 <div class="col-md-6"><input type="password" class="form-control" placeholder="Enter admin password" name="password" autocomplete="off" required="required" value="<?php echo $_POST['password'];?>">
 <br>
                    <span class="myerror"> <?php echo form_error('password');?></span>

 </div> 

</div>

  </div>  
 
</div>

</div>
</div>

<div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Following fields are SEO related</div>
         <div class="card-body ">

            
            <div class="form-horizontal">
            
            <div class="form-group" style="margin-top:15px;">
              <label for="usr" class="col-md-4 control-label">Related tags <span class="tx-danger">*</span><br>
              <span style="font-size:12px;"> Separated by Space </span>
              </label>
             <div class="col-md-6">
                 <input rows="3" data-role="tagsinput"  type="text"class="form-control" placeholder=" Tags separate by 'Space' " name="keywords" value="<?php echo $_POST['keywords'];?>" required="required">
              <br>
                    <span class="myerror"> <?php echo form_error('keywords');?></span>
            
             
             </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Description <span class="tx-danger">*</span></label>
                <div class="col-md-6">
                    <textarea rows="3" class="form-control" placeholder="Enter Site Related Description here "  name="meta_desc" value="" required="required"><?php echo $_POST['meta_desc'];?></textarea>
                    <br>
                    <span class="myerror"> <?php echo form_error('meta_desc');?></span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label">Subject <span class="tx-danger">*</span></label>
                <div class="col-md-6">
                    <textarea rows="3" class="form-control " placeholder="Enter Site Related Subject here " name="meta_subject" value="" required="required"><?php echo $_POST['meta_subject'];?></textarea>
                    <br>
                    <span class="myerror"> <?php echo form_error('meta_subject');?></span>
                    
                </div>
            </div>

                <p id="captImg" style=" position: absolute;margin-left: 410px;"><?php echo $captchaImg; ?></p><br><br><br>
                <p style=" position: absolute;margin-left: 410px;">Can't read the image? click <a href="javascript:void(0);" class="refreshCaptcha">here</a> to refresh.</p>
                <br><br>
               
                  
                  <div class="input-group" class=col-md-6">
                    
                    <input type="text"  class="form-control input-md captcha"  name="captcha" placeholder="Enter Captcha">
                 
                </div>
            </div>

        </div>
</div>


<br><br>

<center>
<div class="form-group">
  <label for="usr"></label>
  <input type="hidden" name="cnt" value="<?php echo $i; ?>">
  <input class="btn btn-success" type="submit" value="Create" name="save">
</div> 
</center>



<div class="clear-fix"></div>


<?php echo form_close(); ?>
</div>
<script>
    $(document).ready(function(){
        $('.refreshCaptcha').on('click', function(){
            $.get('<?php echo base_url().'AddnewsiteController/refresh'; ?>', function(data){
                $('#captImg').html(data);
            });
        });
    });


</script>















        
            
            
          
   
