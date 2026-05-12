<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',1);
?>

<head>

<link href="<?php echo base_url()?>assets/css/fontawesome/css/all.css" rel="stylesheet">

<style>
    
    .table-bordered {
  border: 1px #c3c3c3 solid !important;
}
	
	.mytable tr td {
	    
	     border-bottom: 1px #e5e5e5 solid !important;
	    
	}
    
</style>


  </head>

<body>
   

<div class="sh-pagebody">
    
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success text-center"> 
    <?php echo $this->session->flashdata('message');?>
    </div>
    <?php } ?>


<div class="card bd-primary mg-t-20">
          <div class="card-header bg-primary tx-white">Edit Menu</div>
          <div class="card-body pd-sm-30">
              
              <?php foreach($sitemenueditdata->result() as $key=>$value) { ?>
              
              <?php $attributes=array('id'=>'myform');echo form_open('AddMenuController/update_sitemenu/'.$value->menu_id.'',$attributes);?>
              
              <label for="menu-type">Select Menu type:</label>
              <select name="menu_type_id" required style="height:37px;">
                  <option value="">--- select---</option>
                  
                  <?php foreach($menudata->result() as $key=>$val) {
                      
                  if($val->menu_type_id==$value->menu_type_id) { ?>
                  
                  <option value="<?php echo $val->menu_type_id;?>" selected><?php echo $val->menu_type_desc;?></option>
                  
                  <?php } else { ?>
                  
                  <option value="<?php echo $val->menu_type_id;?>"><?php echo $val->menu_type_desc;?></option>
                  
                  <?php } } ?>
              </select>
              
              
              <label for="menudesc">Menu name : </label>
              <input type="text" maxlength="20" name="menu_desc" id="menu_desc" required value="<?php echo $value->menu_name; ?>">
              
              <input type="submit" name="save" value="Update">
              <?php echo form_close(); ?>
              
              
              <?php } ?>
              <br>
              
                   	
             
</div>
       </div>  
            <br>
     