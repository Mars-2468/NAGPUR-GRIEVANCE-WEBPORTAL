<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>
    
    
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
    
<div class="sh-pagebody">
    
   <div class="mypagetitile"> Add Service </div>
    
    <hr>
     <?php


    if ($this->session->flashdata('errors')){
        echo '<div class="alert alert-danger">';
        echo $this->session->flashdata('errors');
        echo "</div>";
    }


    ?>
    <?php
    if ($this->session->flashdata('SUCCESSMSG')){
        echo '<div class="alert alert-success">';
        echo $this->session->flashdata('SUCCESSMSG');
        echo "</div>";
    }
    ?>
    

    
    
    <div class="col-md-12">
            <div class="panel with-nav-tabs panel-success">
                <div class="panel-heading mypad">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1success" data-toggle="tab">Widget 1</a></li>
                            <li><a href="#tab2success" data-toggle="tab">Widget 2</a></li>
                            <li><a href="#tab3success" data-toggle="tab">Widget 3</a></li>
                            <li><a href="#tab4success" data-toggle="tab">Widget 4</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1success">
                            
                             <div class="form-horizontal">
                                 
                                 
 <?php $attributes=array('method'=>'POST','id'=>'addbanerform','onsubmit'=>'return validateForm()'); echo form_open_multipart('RightserviceController/insert',$attributes); ?>                                
 <!--<form class="form-horizontal" id="addbanerform" method="post" action="<?php echo site_url('RightserviceController/insert'); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">-->
 
 <?php  foreach($report1 as $key1=>$value1) ?>
 <div class="form-group">
 <label class="col-md-3 control-label">Upload Image: <span class="tx-danger">*</span></label>  
 <div class="col-md-4">
 <input id="picture" name="picture"  class="input-file" type="file" >
 <span id="bannererr"></span>
 </div>
 
 <div class="col-md-3" >
    <div> <input type="hidden" name="id1" value="<?php echo $value1['id']; ?>"></div>
 </div>
 
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label"> </label>  
  <div class="col-md-4" >
  <img src="http://municipalservices.in/sites/admin/assets/uploads/<?php echo $this->session->userdata('ulbid'); ?>/<?php echo $value1['picture']; ?>"  class="img-responsive" width="180" height="100">
  <span style="color:#8ea6b4; font-size:12px;"><i class="fa fa-arrow-up"></i> This is Previous Image</span>
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Enter Service title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="service_title" name="service_title" placeholder="Enter service title" class="form-control input-md mytext15" type="text" value="<?php echo $value1['title']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Page link: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="page_link" name="page_link" placeholder="Enter page link" class="form-control input-md url1" type="text" value="<?php echo $value1['page_link']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Image title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="img_title" name="img_title" placeholder="Enter image title" class="form-control input-md mytext15" type="text" value="<?php echo $value1['image_title']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Open With Window: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <select name="window" id="window" class="form-control input-md mytext15">
  <option value="">----Select Window----</option>
   <?php
 
          $conn=mysqli_connect('localhost','municipalservce_ulbcsms','FUSIA8iiBjGm','municipalservce_ulbcms');
         $sql="select * from  window_mst";
         $res=mysqli_query($conn,$sql);
         while($row=mysqli_fetch_array($res))
         {
         if($row['window_id']==$value1['window'])
         {
         ?>
           <option value="<?php echo $row['window_id']; ?>" selected><?php echo $row['window_desc']; ?></option>  
      <?php }
      else
      {?>
           <option value="<?php echo $row['window_id']; ?>"><?php echo $row['window_desc']; ?></option> 
     <?php  }
      } 
      ?>
  
   </select>
   </div>
 </div>
 
  <div class="form-group">
  <label class="col-md-3 control-label">Image Alternative text: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="img_text" name="img_text" placeholder="Enter service Alt text" class="form-control input-md mytext15" type="text" value="<?php echo $value1['image_title']; ?>">
  </div>
  </div>
 
 
 
 
 <div class="form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
 <input type="submit" name="submit1" value="Submit" class="btn btn-success btn-block">
   </div>
 </div>
 
 <?php echo form_close(); ?>
 <!--</form>-->
        
    </div>
                            
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <div class="tab-pane fade" id="tab2success">
                            
                             <div class="form-horizontal">
                                 
 <?php $attributes=array('method'=>'POST','id'=>'addbanerform','onsubmit'=>'return validateForm()'); echo form_open_multipart('RightserviceController/insert',$attributes); ?>                                
 <!--<form class="form-horizontal" id="addbanerform" method="post" action="<?php echo site_url('RightserviceController/insert'); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">-->
 <?php  foreach($report2 as $key2=>$value2) ?>
 <div class="form-group">
 <label class="col-md-3 control-label">Upload Image: <span class="tx-danger">*</span></label>  
 <div class="col-md-4">
 <input id="picture" name="picture"  class="input-file" type="file">
 
 </div>
 
 </div>
 <div> <input type="hidden" name="id2" value="<?php echo $value2['id']; ?>"></div>
 
  <div class="form-group">
  <label class="col-md-3 control-label"> </label>  
  <div class="col-md-4" >
  <img src="http://municipalservices.in/sites/admin/assets/uploads/<?php echo $this->session->userdata('ulbid'); ?>/<?php echo $value2['picture']; ?>"  class="img-responsive" width="180" height="100">
  <span style="color:#8ea6b4; font-size:12px;"><i class="fa fa-arrow-up"></i> This is Previous Image</span>
   </div>
 </div>
 
 
 <div class="form-group">
  <label class="col-md-3 control-label">Enter Service title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="service_title" name="service_title" placeholder="Enter service title" class="form-control input-md mytext15" type="text" value="<?php echo $value2['title']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Page link: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="page_link" name="page_link" placeholder="Enter page link" class="form-control input-md url1" type="text" value="<?php echo $value2['page_link']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Image title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="img_title" name="img_title" placeholder="Enter image title" class="form-control input-md mytext15" type="text" value="<?php echo $value2['image_title']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Open With Window: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <select name="window" id="window" class="form-control input-md mytext15">
  <option value="">----Select Window----</option>
   <?php
 
          $conn=mysqli_connect('localhost','municipalservce_ulbcsms','FUSIA8iiBjGm','municipalservce_ulbcms');
         $sql="select * from  window_mst";
         $res=mysqli_query($conn,$sql);
         while($row=mysqli_fetch_array($res))
         {
         if($row['window_id']==$value2['window'])
         {
         ?>
           <option value="<?php echo $row['window_id']; ?>" selected><?php echo $row['window_desc']; ?></option>  
      <?php }
      else
      {?>
           <option value="<?php echo $row['window_id']; ?>"><?php echo $row['window_desc']; ?></option> 
     <?php  }
      } 
      ?>
  
   </select>
   </div>
 </div>
 
  <div class="form-group">
  <label class="col-md-3 control-label">Image Alternative text: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="img_text" name="img_text" placeholder="Enter service Alt text" class="form-control input-md mytext15" type="text" value="<?php echo $value2['image_text']; ?>">
  </div>
  </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
 <input type="submit" name="submit2" value="Submit" class="btn btn-success btn-block">
   </div>
 </div>
 <?php echo form_close(); ?>
 <!--</form>-->
        
    </div>
                            
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <div class="tab-pane fade" id="tab3success">
                            
                             <div class="form-horizontal">
 <?php $attributes=array('method'=>'POST','id'=>'addbanerform','onsubmit'=>'return validateForm()'); echo form_open_multipart('RightserviceController/insert',$attributes); ?>                                
 <!--<form class="form-horizontal" id="addbanerform" method="post" action="<?php echo site_url('RightserviceController/insert'); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">-->
 
 <?php  foreach($report3 as $key3=>$value3) ?>
 <div class="form-group">
 <label class="col-md-3 control-label">Upload Image: <span class="tx-danger">*</span></label>  
 <div class="col-md-4">
 <input id="picture" name="picture"  class="input-file" type="file" >
 
 <span id="bannererr"></span>
 </div>
 </div>
 
  <div> <input type="hidden" name="id3" value="<?php echo $value3['id']; ?>"></div>

 <div class="form-group">
  <label class="col-md-3 control-label"> </label>  
  <div class="col-md-4" >
  <img src="http://municipalservices.in/sites/admin/assets/uploads/<?php echo $this->session->userdata('ulbid'); ?>/<?php echo $value3['picture']; ?>"  class="img-responsive" width="180" height="100">
  <span style="color:#8ea6b4; font-size:12px;"><i class="fa fa-arrow-up"></i> This is Previous Image</span>
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Enter Service title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="service_title" name="service_title" placeholder="Enter service title" class="form-control input-md mytext15" type="text" value="<?php echo $value3['title']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Page link: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="page_link" name="page_link" placeholder="Enter page link" class="form-control input-md url1" type="text" value="<?php echo $value3['page_link']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Image title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="img_title" name="img_title" placeholder="Enter image title" class="form-control input-md mytext15" type="text" value="<?php echo $value3['image_title']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Open With Window: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <select name="window" id="window" class="form-control input-md mytext15">
  <option value="">----Select Window----</option>
   <?php
 
          $conn=mysqli_connect('localhost','municipalservce_ulbcsms','FUSIA8iiBjGm','municipalservce_ulbcms');
         $sql="select * from  window_mst";
         $res=mysqli_query($conn,$sql);
         while($row=mysqli_fetch_array($res))
         {
         if($row['window_id']==$value3['window'])
         {
         ?>
           <option value="<?php echo $row['window_id']; ?>" selected><?php echo $row['window_desc']; ?></option>  
      <?php }
      else
      {?>
           <option value="<?php echo $row['window_id']; ?>"><?php echo $row['window_desc']; ?></option> 
     <?php  }
      } 
      ?>
  
   </select>
   </div>
 </div>
 
  <div class="form-group">
  <label class="col-md-3 control-label">Image Alternative text: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="img_text" name="img_text" placeholder="Enter service Alt text" class="form-control input-md mytext15" type="text" value="<?php echo $value3['image_text']; ?>">
  </div>
  </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
 <input type="submit" name="submit3" value="Submit" class="btn btn-success btn-block">
   </div>
 </div>
 <?php echo form_close(); ?>
 <!--</form>-->
        
    </div>
  </div>
    <div class="tab-pane fade" id="tab4success">
                           
                            <div class="form-horizontal">
 <?php $attributes=array('method'=>'POST','id'=>'addbanerform','onsubmit'=>'return validateForm()'); echo form_open_multipart('RightserviceController/insert',$attributes); ?>                               
 <!--<form class="form-horizontal" id="addbanerform" method="post" action="<?php echo site_url('RightserviceController/insert'); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">-->
 
 <?php  foreach($report4 as $key4=>$value4) ?>
 <div class="form-group">
 <label class="col-md-3 control-label">Upload Image: <span class="tx-danger">*</span></label>  
 <div class="col-md-4">
 <input id="picture" name="picture"  class="input-file" type="file">
 <span id="bannererr"></span>
 </div>
 </div>
  <div> <input type="hidden" name="id4" value="<?php echo $value4['id']; ?>"></div>

 <div class="form-group">
  <label class="col-md-3 control-label"> </label>  
  <div class="col-md-4" >
  <img src="http://municipalservices.in/sites/admin/assets/uploads/<?php echo $this->session->userdata('ulbid'); ?>/<?php echo $value4['picture']; ?>"  class="img-responsive" width="180" height="100">
  <span style="color:#8ea6b4; font-size:12px;"><i class="fa fa-arrow-up"></i> This is Previous Image</span>
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Enter Service title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="service_title" name="service_title" placeholder="Enter service title" class="form-control input-md mytext15" type="text" value="<?php echo $value4['title']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Page link: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="page_link" name="page_link" placeholder="Enter page link" class="form-control input-md url1" type="text" value="<?php echo $value4['page_link']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Image title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="img_title" name="img_title" placeholder="Enter image title" class="form-control input-md mytext15" type="text" value="<?php echo $value4['image_title']; ?>">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Open With Window: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <select name="window" id="window" class="form-control input-md mytext15">
  <option value="">----Select Window----</option>
   <?php
 
          $conn=mysqli_connect('localhost','municipalservce_ulbcsms','FUSIA8iiBjGm','municipalservce_ulbcms');
         $sql="select * from  window_mst";
         $res=mysqli_query($conn,$sql);
         while($row=mysqli_fetch_array($res))
         {
         if($row['window_id']==$value4['window'])
         {
         ?>
           <option value="<?php echo $row['window_id']; ?>" selected><?php echo $row['window_desc']; ?></option>  
      <?php }
      else
      {?>
           <option value="<?php echo $row['window_id']; ?>"><?php echo $row['window_desc']; ?></option> 
     <?php  }
      } 
      ?>
  
   </select>
   </div>
 </div>
 
  <div class="form-group">
  <label class="col-md-3 control-label">Image Alternative text: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="img_text" name="img_text" placeholder="Enter service Alt text" class="form-control input-md mytext15" type="text" value="<?php echo $value4['image_text']; ?>">
  </div>
  </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
 <input type="submit" name="submit4" value="Submit" class="btn btn-success btn-block">
   </div>
 </div>
 <?php echo form_close(); ?>
 <!--</form>-->
        
    </div>
                           
                       </div>
                    </div>
                </div>
            </div>
        </div>
    

</div>


<script language='javascript'>
function validateForm()
{
	var er = "";
$(".mytext15").each(function()
	{
	   
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
	
	$(".combo").each(function()
	{
		var val_field=$(this).val();
		if(val_field=='0')
		{
		    ($(this)).css({"background-color": "pink"});
		    errors++;
		}
		else
		{
		    ($(this)).css({"background-color": "white"});
		}
	});
$(".url1").each(function()
	{
		var pattern="https?://.+";
		var val_field=$(this).val();
		if(!val_field.match(pattern))
		{
		    ($(this)).css({"background-color": "pink"});
		    errors++;
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

