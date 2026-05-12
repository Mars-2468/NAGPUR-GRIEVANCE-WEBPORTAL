
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="<?php echo base_url()?>assets/imagecropplugins/resource/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/imagecropplugins/resource/cropimg.css" />
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/imagecropplugins/resource/jquery-1.12.4.min.js"></script>
    <script src="<?php echo base_url()?>assets/imagecropplugins/resource/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/imagecropplugins/resource/cropimg.jquery.js"></script>
    


<div class="sh-pagebody">
    
    <div class="mypagetitile">Crop Image</div>
<br>
<div class="row">
    <div class="col-md-12">
        <!-- image crop code-->
        
        
        <img src="<?php echo $this->session->userdata('base_url').$this->session->userdata['cropimgparams']['resource']?>" alt="crop img" class="cropimg" />
    <script>
    $(document).ready(function() {
      $('img.cropimg').cropimg({
        resultWidth:<?php echo $this->session->userdata['cropimgparams']['destinationWidth'];?>,
        resultHeight:<?php echo $this->session->userdata['cropimgparams']['destinationHeight'];?>,
        onChange: function() {
          $('#preview-info').hide();
          $('#preview-container').show();
        }
      });
});
    
  
    </script>
    <div>
        <?php echo form_open('image-text-crop');?>
        <input type="hidden" name="resource" value="<?php echo "..".$this->session->userdata['cropimgparams']['resource'];?>">
        <input type="hidden" name="destination_path" value="<?php echo "..".$this->session->userdata['cropimgparams']['destination_path'];?>">
        <input type="hidden" name="destinationWidth" value="<?php echo $this->session->userdata['cropimgparams']['destinationWidth'];?>">
        <input type="hidden" name="destinationHeight" value="<?php echo $this->session->userdata['cropimgparams']['destinationHeight'];?>">
        
        <center><input type="submit" class="btn btn-primary" name="save" value="Save"></center>
<div class="form-horizontal" style="visibility:hidden">
	<input type="text" name="imgx" value="<?php if(($this->session->userdata['cropimgparams']['x']) != '0'){echo $this->session->userdata['cropimgparams']['x'];}else{ echo -1;} ?>" id="x" class="form-control input-md" />  
    <input type="text" name="imgy" value="<?php if(($this->session->userdata['cropimgparams']['y']) != '0'){echo $this->session->userdata['cropimgparams']['y'];}else{ echo 1;} ?>" id="y" class="form-control input-md" />  
    <input type="text" name="width" value="<?php if(($this->session->userdata['cropimgparams']['w']) != '0'){echo $this->session->userdata['cropimgparams']['w'];}else{ echo 1;} ?>" id="w" class="form-control input-md" />  
    <input type="text" name="height" value="<?php if(($this->session->userdata['cropimgparams']['h']) != '0'){echo $this->session->userdata['cropimgparams']['h'];}else{ echo 1;} ?>" id="h" class="form-control input-md" />  
    <input type="text" name="widgetIdAdmin" value="<?php echo $this->session->userdata['cropimgparams']['widgetIdAdmin'];?>" id="wtAd" class="form-control input-md" />
    <input type="text" name="widgetname" value="<?php echo $this->session->userdata['cropimgparams']['widget_name'];?>" id="wt" class="form-control input-md" />
    <input type="text" name="widgetId" value="<?php echo $this->session->userdata['cropimgparams']['widgetId'];?>" id="wt" class="form-control input-md" />
    <input type="text" name="id" value="<?php echo $this->session->userdata['cropimgparams']['id'];?>" id="wt" class="form-control input-md" />
    <input type="text" name="widgetType" value="<?php echo $this->session->userdata['cropimgparams']['widgetType'];?>" id="wt" class="form-control input-md" />
    <input type="text" name="file_name" value="<?php echo $this->session->userdata['cropimgparams']['file_name'];?>" id="fn" class="form-control input-md" />
</div>


<?php echo form_close(); ?>

</div>
        
        
        <!-- close-->
    </div>
</div>

</div>
        
            
            
          
   

        
            
            
          
   
