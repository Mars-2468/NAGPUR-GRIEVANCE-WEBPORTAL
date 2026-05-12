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
         <div class="card-header bg-primary tx-white">Update New Site</div>
         <div class="card-body ">




<div class="col-md-12">
    
    
<?php $attributes=array('method'=>'POST'); echo form_open('AddnewsiteController/update_add_new_site',$attributes);?>
    <!--<form method="POST" action="<?php echo base_url();?>AddnewsiteController/update_add_new_site">-->
   
    <?php foreach($edit_sites->result() as $key=>$values) { ?>


    <input type="hidden" name="ulb" value="<?php echo $values->ulbid; ?>">
  
  
    
    <input type="hidden" name="ulbid<?php echo $i; ?>" value="<?php echo $arr[0]; ?>">
    
    
    <div class="form-horizontal">
    
<!--<div class="form-group">-->
<!--  <label class="col-md-4 control-label">Site Layout </label>-->
<!-- <div class="col-md-6"><select class="form-control required" name="theme">-->
<!--     <option value="">--- Select Layout--</option>-->
<!--     <?php foreach($theme_list->result() as $index2=>$val2){ ?>-->
<!--     <option value="<?php echo $val2->theme_id; ?>"><?php echo $val2->theme_description; ?></option>-->
<!--     <?php } ?>-->
<!--</select>-->
<!--</div>-->
<!--</div>-->

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Name of the ULB <span class="tx-danger">*</span></label>
  <div class="col-md-6 "><input type="text" class="form-control" placeholder="Enter ULB name" value="<?php echo $values->ulbname;?>" name="ulbname" id="ulbname" required ></div>
  
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> District <span class="tx-danger">*</span></label>
  <div class="col-md-6"><!--<input type="text" class="form-control" placeholder="Enter District Name" name="districtname" id="districtname" required>-->
  
  <select class="form-control" name="districtname">
      <option value="">-- Select --</option>
      
      <?php foreach($destrictList->result() as $key=>$val){
          
      if($values->distid==$val->distid) { ?>
      
      <option value="<?php echo $val->distid; ?>" selected><?php echo $val->distname; ?></option>
      <?php } else { ?>
       <option value="<?php echo $val->distid; ?>"><?php echo $val->distname; ?></option>
      <?php } } ?>
      
  </select>
  
  </div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> System id of the portal <span class="tx-danger">*</span></label>
  <div class="col-md-6"><input type="text" class="form-control" placeholder="System id of the portal" name="systemid" id="systemid" required value="<?php echo $values->ulbid;?>"></div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Department web portal url <span class="tx-danger">*</span></label>
  <div class="col-md-6"><input type="text" class="form-control" placeholder="Department web portal url" name="base_url" id="base_url" required value="<?php echo $values->base_url;?>"></div>
</div>

<div style="border-bottom:1px #84f2d6 solid; margin-bottom:15px;"></div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Admin concerned person name <span class="tx-danger">*</span></label>
 <div class="col-md-6"> <input type="text" class="form-control" placeholder="Admin concerned person name" name="admin_concerned_person" id="admin_concerned_person" required value="<?php echo $values->concerned_person;?>"> </div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label">Designation<span class="tx-danger">*</span></label>
  
  <div class="col-md-6">
      <!--<input type="text" class="form-control" placeholder="Designation" name="designation" id="designation" required>-->
      <select class="form-control" name="admin_desigantion">
      <option value="">-- Select --</option>
      <?php foreach($designationList->result() as $key=>$val) {
      if($values->designation==$val->desg_id) { ?>
        <option value="<?php echo $val->desg_id; ?>" selected><?php echo $val->desg_desc; ?></option>
      <?php } else { ?>
      <option value="<?php echo $val->desg_id; ?>"><?php echo $val->desg_desc; ?></option>
      <?php } } ?>
      
  </select>
   </div>
</div>


    
 <div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Mobile number  <span class="tx-danger">*</span></label>
  <div  class="col-md-6"><input type="text" class="form-control" placeholder="Mobile number " name="mobile" id="mobile" required value="<?php echo $values->mobile;?>"></div>
</div>

<hr style="border-bottom:1px #84f2d6 solid; margin-bottom:15px;">

<!--<div class="form-group">-->
<!--  <label for="usr" class="col-md-4 control-label"> Technical person   <span class="tx-danger">*</span></label>-->
<!--  <div  class="col-md-6"><input type="text" class="form-control" placeholder="Technical person " name="tech_name" id="tech_name" required></div>-->
<!--</div>-->

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Technical concerned person name   <span class="tx-danger">*</span></label>
 <div  class="col-md-6"> <input type="text" class="form-control" placeholder="concerned person name " name="tech_concerned_person_name" id="tech_concerned_person_name" required value="<?php echo $values->tech_concerned_person_name;?>"></div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label">Designation<span class="tx-danger">*</span></label>
  <div class="col-md-6">
      <!--<input type="text" class="form-control" placeholder="Designation" name="designation" id="designation" required>-->
      <select class="form-control" name="tech_concerned_person_designation">
      <option value="">-- Select --</option>
      <?php foreach($designationList->result() as $key=>$val) {
      if($values->tech_concerned_person_designation==$val->desg_id) { ?>
        <option value="<?php echo $val->desg_id; ?>" selected><?php echo $val->desg_desc; ?></option>
      <?php } else { ?>
       <option value="<?php echo $val->desg_id; ?>"><?php echo $val->desg_desc; ?></option>
      <?php } } ?>
  </select>
   </div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Mobile number   <span class="tx-danger">*</span></label>
  <div  class="col-md-6"><input type="text" class="form-control" placeholder="Mobile number" name="tech_concerned_person_mobile" id="tech_concerned_person_mobile" required value="<?php echo $values->tech_concerned_person_mobile;?>"></div>
</div>

<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Email id   <span class="tx-danger">*</span></label>
  <div  class="col-md-6"><input type="text" class="form-control" placeholder="Email id" name="tech_concerned_person_email" id="tech_concerned_person_email" required value="<?php echo $values->tech_concerned_person_email;?>"></div>
</div>

    
<!--<div class="form-group">
  <label for="usr" class="col-md-4 control-label"> Admin username <span class="tx-danger">*</span></label>
  <div class="col-md-6"><input type="text" class="form-control" placeholder="Enter admin user id" name="user_id" required value="<?php echo $values->concerned_person;?>"></div>
</div>

<div class="form-group" >
  <label for="usr" class="col-md-4 control-label"> Admin password <span class="tx-danger">*</span></label>
 <div class="col-md-6"><input type="password" class="form-control" placeholder="Enter admin password" name="password" required value="<?php echo $values->concerned_person;?>"></div> 
</div>-->

   
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
                 <input rows="3" data-role="tagsinput"  type="text"class="form-control" placeholder=" Tags separate by 'Space' " name="keywords" value="<?php echo $values->keywords;?>" >
             </div>
            </div>
            
            
            <div class="form-group">
                <label class="col-md-4 control-label">Description <span class="tx-danger">*</span></label>
                <div class="col-md-6">
                    <textarea rows="3" class="form-control" placeholder="Enter Site Related Description here " name="meta_desc" required="required"><?php echo $values->description;?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label">Subject <span class="tx-danger">*</span></label>
                <div class="col-md-6">
                    <textarea rows="3" class="form-control " placeholder="Enter Site Related Subject here " name="meta_subject" required="required"><?php echo $values->subject;?></textarea>
                    
                </div>
            </div>

            
            </div>



        </div>
</div>


<br><br>

<center>
<div class="form-group">
  <label for="usr"></label>
  <input type="hidden" name="cnt" value="<?php echo $i; ?>">
  <input class="btn btn-success" type="submit" value="Update" name="save">
</div> 
</center>



<div class="clear-fix"></div>


<?php echo form_close(); ?>
<!--</form>-->
<?php } ?>
</div>















        
            
            
          
   
