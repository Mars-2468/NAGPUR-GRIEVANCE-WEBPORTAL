<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
    $(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
    
</script>
    
   
<div class="sh-pagebody">
    
    <div >
        
        <div class="mypagetitile">Social Settings</div>
        
        <hr>
        
    </div>
    <?php


    if ($this->session->flashdata('errors')){
        echo '<div class="alert alert-danger">';
        echo $this->session->flashdata('errors');
        echo "</div>";
    }


    ?>
                        <?php if($this->session->flashdata('SUCCESSMSG')) { ?>
                            <div role="alert" class="alert alert-success">
                                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                                    <strong>Well done!!</strong> <?=$this->session->flashdata('SUCCESSMSG')?>
                            </div>
                        <?php } ?>
                         <?php if($this->session->flashdata('SUCCESSMSG1')) { ?>
                            <div role="alert" class="alert alert-success">
                                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                                    <strong>Well done!!</strong> <?=$this->session->flashdata('SUCCESSMSG1')?>
                            </div>
                        <?php } ?>
                        
                        
    <?php $attributes=array('method'=>'POST','onsubmit'=>'return validateForm()');echo form_open('SocialSettingsController/insert/',$attributes);?>                    
   <!--<form method="post" action="<?php echo site_url('SocialSettingsController/insert'); ?>" onsubmit="return validateForm()">-->
      
    <div class="form-horizontal">
      <?php 
     
      
      foreach($edit_linl as $key=>$value) 
     
      ?> 
   
<div class="form-group">
  <label class="col-md-3 control-label" >Facebook <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="textinput" name="facebook" id="facebook" placeholder="https://www.facebook.com/" value="<?php echo $value['facebook']; ?>" class="form-control input-md url1"  type="text" onblur="check_username()">
   </div>
  <!-- <div class="col-md-1 form-control-static">-->
  <!--    <span class="button-checkbox">-->
  <!--      <button type="button" class="btn btn-xs" data-color="primary">Enable</button>-->
  <!--      <input type="checkbox" class="hidden" checked />-->
  <!--  </span>-->
  <!--</div>-->
</div>

<div class="form-group">
  <label class="col-md-3 control-label" >Twitter <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="textinput" name="twitter" id="twitter"  placeholder="https://twitter.com/" value="<?php echo $value['twitter']; ?>" class="form-control input-md url1" type="text">
  </div>
  <!--<div class="col-md-1 form-control-static">-->
  <!--    <span class="button-checkbox">-->
  <!--      <button type="button" class="btn btn-xs" data-color="primary">Enable</button>-->
  <!--      <input type="checkbox" class="hidden" checked />-->
  <!--  </span>-->
  <!--</div>-->
</div>

<div class="form-group">
  <label class="col-md-3 control-label" >Google Plus <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="textinput" name="google" id="google" placeholder="https://plus.google.com/" value="<?php echo $value['google']; ?>" class="form-control input-md url1" type="text">
   </div>
  <!--   <div class="col-md-1 form-control-static">-->
  <!--    <span class="button-checkbox">-->
  <!--      <button type="button" class="btn btn-xs" data-color="primary">Enable</button>-->
  <!--      <input type="checkbox" class="hidden" checked />-->
  <!--  </span>-->
  <!--</div> -->
      
</div>

<div class="form-group">
  <label class="col-md-3 control-label" >LinkedIn <span class="tx-danger">*</span></label>  
  <div class="col-md-4">
  <input id="textinput" name="linkedin" id="linkedin" placeholder="https://www.linkedin.com/" value="<?php echo $value['linkedin']; ?>" class="form-control input-md url1" type="text">
     </div>
  <!--   <div class="col-md-1 form-control-static">-->
  <!--    <span class="button-checkbox">-->
  <!--      <button type="button" class="btn btn-xs" data-color="primary">Enable</button>-->
  <!--      <input type="checkbox" class="hidden" checked />-->
  <!--  </span>-->
  <!--</div>-->
</div>



<div class="form-group">
<label class="col-md-3 control-label" ></label>  
  <div class="col-md-4">
      <input type="submit" name="submit" value="Update Settings" class="btn btn-success btn-block">
                
    </div>
</div>

  </div>  
  <?php echo form_close(); ?>
   <!--</form>--> 
</div>
<script language='javascript'>
function validateForm()
{
	var errors=0;
	var er = "";
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
<script>
    $(document).ready(function()
    {
        $('#click').click(function()

        {
            $('.p').toggle();
      }); 
   });
   </script>