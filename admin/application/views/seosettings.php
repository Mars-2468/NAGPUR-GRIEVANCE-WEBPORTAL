<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style>
 
 .panel.with-nav-tabs .nav-tabs{
	border-bottom: none;
}
.panel-heading {
    padding: 0px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}

.with-nav-tabs.panel-info .nav-tabs > li > a,
.with-nav-tabs.panel-info .nav-tabs > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li > a:focus {
	color: #31708f;
}
.with-nav-tabs.panel-info .nav-tabs > .open > a,
.with-nav-tabs.panel-info .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-info .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-info .nav-tabs > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li > a:focus {
	color: #31708f;
	background-color: #bce8f1;
	border-color: transparent;
}
.with-nav-tabs.panel-info .nav-tabs > li.active > a,
.with-nav-tabs.panel-info .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.active > a:focus {
	color: #31708f;
	background-color: #fff;
	border-color: #bce8f1;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #d9edf7;
    border-color: #bce8f1;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #31708f;   
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #bce8f1;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #31708f;
}
 </style>

<div class="sh-pagebody">
    
    <!--<form class="form-horizontal">-->
    
   
    
    <div class="mypagetitile">SEO Settings</div>
     <?php if($this->session->flashdata('SUCCESSMSG')) { ?>
                            <div role="alert" class="alert alert-success">
                                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                                    <strong>Well done!!</strong> <?=$this->session->flashdata('SUCCESSMSG')?>
                            </div>
                        <?php } ?>
<?php
    if ($this->session->flashdata('errors')){
        echo '<div class="alert alert-danger">';
        echo $this->session->flashdata('errors');
        echo "</div>";
    }
    ?>
    
        <?php $attributes=array('method'=>'POST');echo form_open('SeoSettingsController/insert/',$attributes);?>
        <!--<form class="form-horizontal" method="post" action="<?php echo site_url('SeoSettingsController/insert'); ?>" >-->
            
            
            <div class="panel with-nav-tabs panel-info mg-t-30">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1info" data-toggle="tab">Google Analytics</a></li>
                            <li><a href="#tab2info" data-toggle="tab">SEO Meta Tags</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        
                        <div class="tab-pane fade in active" id="tab1info">
                            <?php foreach($seo_edit as $key=>$value1) ?>
                            <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Google Analytics Script: <span class="tx-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <textarea class="form-control mytext15" rows="6" id="google_analytic" name="google_analytic" placeholder="<script>Google Analytics Script</script>"><?php echo $value1['google_analytic_script']; ?></textarea>
                                    </div>
                                </div>
                                
                            <div class="form-group">
                                    <label class="control-label col-sm-3" for="email"></label>
                                    <div class="col-sm-8">
                                      <!--<button type="button" class="btn btn-success btn-block">Update</button>-->
                                      
                                      <!--<input type="submit" name="google_analy" value="Update" class="btn btn-success btn-block" onclick="return validateForm()">-->
                                    </div>
                                </div>
                                
                                
                        </div>
                        
                        <div class="tab-pane fade" id="tab2info">
                            
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Website Meta Keywords: <span class="tx-danger">*</span> <br> <span style="font-size:12px;"> Separated by comma(,) </span> </label>
                                    <div class="col-sm-8">
                                      <textarea class="form-control" rows="6" name="website_meta_ky" id="website_meta_ky" placeholder="Ex (Ocean,sea,etc)"><?php echo $value1['website_meta_ky']; ?></textarea>
                                    </div>
                                </div>
                                
                               <div class="form-group">
                                    <label class="control-label col-sm-3"  for="email">Website Meta Description: <span class="tx-danger">*</span> <br> <span style="font-size:12px;"> (Less than 160 Characters) </span> </label>
                                    <div class="col-sm-8">
                                      <textarea class="form-control" rows="6" maxlength="160" name="website_meta_desc" id="website_meta_desc" placeholder="Enter Description"><?php echo $value1['website_meta_desc']; ?></textarea>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Website Meta Subject: <span class="tx-danger">*</span></label>
                                    <div class="col-sm-8">
                                      <textarea class="form-control" rows="6" name="website_meta_sub" id="website_meta_sub" placeholder="Enter Subject"><?php echo $value1['website_meta_sub']; ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email"></label>
                                    <div class="col-sm-8">
                                      <!--<button type="button" class="btn btn-success btn-block">Update</button>-->
                                       
                                    </div>
                                </div>
                                
                                
                                
                             
                        </div>
                    </div>
                    <input type="submit" name="seo_meta" value="Update" class="btn btn-success btn-block" onclick="return validateForm1()">
                </div>
            </div>
        <!--</form>-->
    <?php echo form_close(); ?>   
<br/>





</div>
   <script language='javascript'>
function validateForm()
{
	var errors=0;
	var er = "";
$(".mytext15").each(function()
	{
	    //	var letters = /^[A-Za-z]+$/;  
		var val_field=$(this).val();
      	if(val_field == "")  
      	{  
      		($(this)).css({"background-color": "pink"});
      		errors++;
			er += 'Name, ';
      	}  
      	else 
      	{  
      		($(this)).css({"background-color": "white"});
      	}  
	});
	
	 $(".mytext2").each(function()
    {
		var pattern = /^[a-zA-Z\\s\\,]+$/;
		var val_field=$(this).val();
		if(val_field.match(pattern))
		{
			var a=val_field.length;
			if(a<10 && a>10)
			{
				($(this)).css({"background-color": "pink"});
				errors++;
				//er += 'Mobile';
			}
			else
			{
				($(this)).css({"background-color": "white"});
			}
		}
		else
		{
			($(this)).css({"background-color": "pink"});
			errors++;
			er += 'Text Area , ';
		}
	});
	
	
	
	if(errors==0)
	{
		return true;
	}
	else
	{
	    alert("Please Enter Correct Value in following High-lighted Fields - "+errors );
       	return false;
	}
}
</script>
   


 <script language='javascript'>
function validateForm1()
{
	/*var errors=0;
	var er = "";

	 $(".mytext3").each(function()
    {
		var pattern = /^[a-zA-Z\\s\\,]+$/;
		var val_field=$(this).val();
		if(val_field.match(pattern))
		{
			var a=val_field.length;
			if(a<10 && a>10)
			{
				($(this)).css({"background-color": "pink"});
				errors++;
				//er += 'Mobile';
			}
			else
			{
				($(this)).css({"background-color": "white"});
			}
		}
		else
		{
			($(this)).css({"background-color": "pink"});
			errors++;
			er += 'Text Area , ';
		}
	});
	
	
	
	if(errors==0)
	{
		return true;
	}
	else
	{
	    alert("Please Enter Correct Value in following High-lighted Fields - "+errors );
       	return false;
	}*/
}
</script>