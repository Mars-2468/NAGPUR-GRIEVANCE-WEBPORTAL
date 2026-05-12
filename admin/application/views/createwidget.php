<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>




<div class="sh-pagebody">

<?php if($this->session->flashdata('message')){?>
    
    <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
    <?php }?>

<div class="">
    <div class="col-md-12">
       
        <?php echo form_open('creage-widget'); ?>
        
        <div class="card bd-primary mg-t-20">
         <div class="card-header bg-primary tx-white">Create Widget</div>
         <div class="card-body pd-sm-30">
             
           <div class="form-horizontal">
        <div class="row">
            
          <label class="col-md-2 text-right pt-2 control-label" style="padding-left:0px; padding-right:0px;">Widget Name</label>  
          <div class="col-md-3">
          <input name="widgetname" id="widgetname" placeholder="Enter Widget Name...." value="<?php echo $this->input->post('widgetname');?>" data-type="text" onkeyup="funInputFielTypes(this)" class="form-control input-md" type="text"  autocomplete="off">
          <div style="font-size:10px;color:red;" id="widgetnameX"></div>
		  </div>
          
          <label class="col-md-1 text-right pt-2 control-label" style="padding-left:0px; padding-right:0px;">Widget Type</label>  
          
          <div class="col-md-3">
              
           <select name="widget_type" id="widget_type" class="form-select">
            <option value="0">-- Select --</option>
            <?php $string='';foreach($widgettypes->result() as $key=>$val){ 
            if($val->widget_type_id==$widgetdet['widget_type'])
            {
                $string='selected';
            }
            else
            {
                $string='';
            }
            
            ?>
            <option value="<?php echo $val->widget_type_id;?>" <?php echo $string; ?>><?php echo $val->widget_type_desc;?></option>
            <?php } ?>
            
        </select>
        
          </div>
          
          <div class="col-md-1"> <input type="submit" class="btn btn-primary" name="next" id="submitBtn" value="Next" disabled></div>
          
        </div>
        
        </div>   
        
        <div id="widgetNameValidationError" style="display:none;" class="alert alert-danger">
            <center><span id="widgetNameValidationSpan"></span></center>
        </div>
        
      <?php echo form_close(); ?>  
        
        
        <div class="">
    
    <div class="">
        
        <?php
        
        
        switch($widgetdet['widget_type'])
        {
            case 1:
                $this->load->view('customwidgets/menuwidget',$widgetdet);
                break;
            case 2:
                $this->load->view('customwidgets/textwidget',$widgetdet);
                break;
            case 3:
                break;
            case 4:
                $this->load->view('customwidgets/gallerywidget',$widgetdet);
                break;
            case 5:
                $this->load->view('customwidgets/imagetextwidget',$widgetdet);
                break;
            case 6:
                $this->load->view('customwidgets/menuwidget',$widgetdet);
                break;
            case 7:
                $this->load->view('customwidgets/startupwidget',$widgetdet);
                break; 
            case 8:
                $this->load->view('customwidgets/tabwidget',$widgetdet);
                break;
            case 9:
                 $this->load->view('customwidgets/postwidget',$widgetdet);
              //  $this->load->view('customwidgets/partnerswidget',$widgetdet);
                break;
            case 10:
                $this->load->view('customwidgets/pagewidget',$widgetdet);
                break;
            case 11:
                $this->load->view('customwidgets/menuwidget',$widgetdet);
                break;
            case 12:
                $this->load->view('customwidgets/slider_post_widget',$widgetdet);
                break;
             case 13:
                $this->load->view('customwidgets/textwidget',$widgetdet);
                break;  
                
             case 14:
                $this->load->view('customwidgets/postwidget',$widgetdet);
                break; 
            case 15:
                $this->load->view('customwidgets/textwidget',$widgetdet);
                break; 
            case 16:
                $this->load->view('customwidgets/textwidget',$widgetdet);
                break; 
            case 17:
                $this->load->view('customwidgets/textwidget',$widgetdet);
                break; 
                
        }
        
        ?>
    </div>
    
</div>
       </div>
        </div>
    <br>
       
        
    </div>
</div>




</div>

<!--
<div class="row">
    <div class="col-md-12">
        <span id="result"></span>
    </div>
</div>
-->


<script>
    
    function widgetNameValidation(){
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        var widgetName = $("#widgetname").val();
      	   
	    const regexWName = /^[A-Za-z\s]+$/;
			   
        if(widgetName == ''){
            $("#submitBtn").hide();
            $("#widgetNameValidationError").show();
    	 	$("#widgetNameValidationSpan").html('Please Enter Widget Name');
            return false;
        }else if(!regexWName.test(widgetName)){ 
			$("#submitBtn").hide();
			$("#widgetNameValidationError").show();
    	 	$("#widgetNameValidationSpan").html('Name can only contain letters and spaces!,Please Re-enter Widget Name');
            return false;
        }else{ 
            $("#widgetNameValidationError").hide();
            $("#submitBtn").show();
    	 	$("#widgetNameValidationSpan").html('');
            $.post('CreateWidgetController/widgetNameValidation',{widgetname:widgetName,'csrf_test_name': csrf_value},function(data){
                //alert(data);
                if(data == 'true'){
                    $("#submitBtn").hide();
                    $("#widgetNameValidationError").show();
    	 	        $("#widgetNameValidationSpan").html('Widget Name Already Exists!'); 
                }
            });
        }
        
    }    
        
        function savemenuwidget()
        {
            alert("dfdfh");
            var check_val = [];
            var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
            var widgetname=$("#widgetname").val();
            alert(widgetname);
            var widgettype=$("#widget_type").val();
            var menu_type_id=$("#menu_type_id").val();
            var menu_type_style = $("#menu_type_style").val();
           
            $('.checkbox1:checked').each(function(i){
              check_val[i] = $(this).val();
            });
            //alert(menu_type_id);
            var len = check_val.length;
            //alert(len);
            //return;
            
            if(widgetname ==='')
            {
                alert('Enter Widget Name');
                return false;
            }
            if(widgettype =='0')
            {
                alert('Select Widget Type');
                return false;
            }
            
            if(menu_type_id =='0')
            {
                alert('Select Menu Type');
                return false;
            }
            if(menu_type_style =='0')
            {
                alert('Select Menu style Type');
                return false;
            }
            
            
                
            if(len > 0){
                if(widgettype=='1' || widgettype=='6' || widgettype=='11')
                {
                    //alert(widgettype);
                    $.get('CreateWidgetController/saveMenuwidget',{menu_type_style:menu_type_style,widgetname:widgetname,widgettype:widgettype,menu_type_id:menu_type_id,ulb_check_list:check_val,menu_type_style:menu_type_style,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},function(data)
                    {
                       //alert(data);
                       location.reload();
                    });
                }
            }else{
                alert("Please Select alteast One ULB");
            }
            
        }
</script>
 
 



        

            
            
          
   
