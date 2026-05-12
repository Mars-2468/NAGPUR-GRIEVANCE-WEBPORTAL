<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Shift Schedule</title>
   
</head>

<body>
    
    <div class="sh-pagebody" ng-app="photogalleryapp">
    
    	
    <div class="mypagetitile">Edit Category</div>
    <hr>


                               
                                 
   <?php
    if ($this->session->flashdata('errors')){
        echo '<div class="alert alert-danger">';
        echo $this->session->flashdata('errors');
        echo "</div>";
    }
    ?>
   
                 
					<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
					<div role="alert" class="alert alert-success">
					   <button data-dismiss="alert" class="close" type="button">
						   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
					   <strong>Well done!</strong>
					   <?= $this->session->flashdata('SUCCESSMSG') ?>
					</div>
					<?php } ?>
					</br></br>
							
								     <?php foreach($edit as $key=>$value) { ?>
<?php $attributes=array('method'=>'POST','onsubmit'=>'return validateForm()');echo form_open('PostCategoryController/update_cat/'.$value['page_id'].'',$attributes);?>								     
	<!--<form method="post" class="form-horizontal"  action="<?php echo base_url() . "PostCategoryController/update_cat/" . $value['page_id']; ?>" onsubmit="return validateForm()">-->


								     <div class="form-group">
                                        <label class="control-label col-sm-3" for="email">Category Name <span style="color: #cc0000">*</span> : </label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control mytext15" name="cat_name" id="cat_name" value="<?php echo $value['page_name']; ?>"/>
                                        </div>
                                      </div>
  
								 
								     <div class="form-group"> 
                                        <div class="col-sm-offset-3 col-sm-4">
                                         	<input type="submit" name="update" value="update" class="btn btn-success" >
                                        </div>
                                      </div>
								
						           
									<!--</form>-->
									<?php echo form_close(); ?>
									 <?php } ?>
									
                              
                            
                       

</div>

<!-- /#wrap -->
<!-- global scripts
<script type="text/javascript" src="<?=base_url();?>js/components.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/custom.js"></script>
<!-- global scripts end-

<script type="text/javascript" src="<?=base_url();?>vendors/raphael/js/raphael-min.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/d3/js/d3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/c3/js/c3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/toastr/js/toastr.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/switchery/js/switchery.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/flotchart/js/jquery.flot.js" ></script>
<script type="text/javascript" src="<?=base_url();?>vendors/flotchart/js/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/flotchart/js/jquery.flot.stack.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/flotchart/js/jquery.flot.time.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/flotspline/js/jquery.flot.spline.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/flotchart/js/jquery.flot.categories.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/flotchart/js/jquery.flot.pie.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/jquery_newsTicker/js/newsTicker.js"></script>
<script type="text/javascript" src="<?=base_url();?>vendors/countUp.js/js/countUp.min.js"></script>

<!--end of plugin scripts-->

<script type="text/javascript" src="<?=base_url();?>js/jquery-ui.js"></script>
<!--end of plugin scripts-->
  <script>
  $( function() {
	  $( ".datepicker" ).datepicker({
			dateFormat: "yy-mm-dd"
		});
  });
  </script>

</body>
</html>
