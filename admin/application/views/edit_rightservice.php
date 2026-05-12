<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>


       
       
       
       
<div class="sh-pagebody">
    
   <div class="mypagetitile"> Edit Service </div>
    
    <hr>
    <?php
    
    
    if ($this->session->flashdata('errors')){
        echo '<div class="alert alert-danger">';
        echo $this->session->flashdata('errors');
        echo "</div>";
    }

    
    if ($this->session->flashdata('SUCCESSMSG')){
        echo '<div class="alert alert-success">';
        echo $this->session->flashdata('SUCCESSMSG');
        echo "</div>";
    }
    ?>
    
    <div class="form-horizontal">
        
         <?php $attributes=array('method'=>'POST','id'=>'addbanerform','onsubmit'=>'return validateForm()'); echo form_open_multipart('RightserviceController/update',$attributes);
              ?>
        
    <!-- <form class="form-horizontal" method="post" id="addbanerform"  action="<?php echo site_url('RightserviceController/update'); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">-->
         <?php foreach($edit_ser as $key=>$value) {
        
         ?>
         <input type="hidden" name="ids" value="<?php echo $value['id']; ?>">
 <div class="form-group">
  <label class="col-md-3 control-label">Upload Image: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="picture" name="picture" class="input-file" type="file">
<?php echo $value['picture']; ?>
 
   </div>
 </div>
 
 
 <div class="form-group">
  <label class="col-md-3 control-label">Enter Service title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="" name="service_title" placeholder="Enter service title" value="<?php echo $value['title']; ?>"  class="form-control input-md mytext15" type="text">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Page link: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="" name="page_link" placeholder="Enter page link" value="<?php echo $value['page_link']; ?>" class="form-control input-md url1" type="text">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label">Image title: <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="" name="img_title" placeholder="Enter image title" value="<?php echo $value['image_title']; ?>" class="form-control input-md mytext15" type="text">
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
         if($row['window_id']==$value['window'])
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
  <input id="" name="img_text" placeholder="Enter service Alt text" value="<?php echo $value['image_text']; ?>" class="form-control input-md mytext15" type="text">
   </div>
 </div>
 
 <div class="form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
 <input type="submit" name="update" value="Update" class="btn btn-success btn-block">
   </div>
 </div>
 <?php } ?>
 <?php echo form_close();?>
 <!--</form>-->
        
    </div>
    
    
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
	
	$(".imag").each(function()
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
