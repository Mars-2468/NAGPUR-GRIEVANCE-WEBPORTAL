
  <script src="<?php echo base_url() ?>assets/js/bootstrap.bundle.min.js"></script>


<hr>

<div class="form-horizontal">
    
    
    
    <div class="form-group">
     <?php //echo "dfg";
     //print_r($menunames);?>
               <input type="hidden" name='widgettype' id='widgettype' value="<?php echo $widgetdet['widget_type']; ?>">
                <input type="hidden" name='widgetname'  id='widgetname' value="<?php echo $widgetdet['widgetname']; ?>">
  <label class="col-md-4 control-label" for="textinput">Select Menu Style:</label>  
  <div class="col-md-4">
     
  <select name='menu_type_style' id='menu_type_style' class="form-control">
        <option value='0'>-- Select --</option>
        <option value='1'> Side menu style</option>
        <option value='2'> Footer menu style</option>
        <option value='3'> Website polocies menu style</option>
        <option value='4'> Main menu style</option>
        
      
 </select>
 
  </div>
 
  
</div>
    
    
 
<div class="form-group">
     <?php //echo "dfg";
     //print_r($menunames);?>
  <label class="col-md-4 control-label" for="textinput">Select Menus:</label>  
  <div class="col-md-4">
     
  <select name='menu_type_id' id='menu_type_id' class="form-control">
        <option value='0'>-- Select --</option>
        
      <?php foreach($menunames as $key=>$val){?>
      <option value="<?php echo $val['menu_type_id']; ?>"> <?php echo $val['menu_type_desc']; ?></option>
      <?php } ?>
 </select>
 
  </div>
 
  
</div>
<div>
               
    <div class="card bd-teal " style="clear:both;margin:15px 0 0 0;">
        <div class="card-header bg-teal tx-white">Names</div>
        <div class="card-body">
            
            <div class="col-md-12">
                <label class="ckbox" style="width:100%;">
                    <input class="chkcat" type="checkbox" value="" id="checkAll" > <span>Select All</span>
                </label>
            </div>
            
            <?php foreach($ulbList as $key => $value ){?>
            <div class="col-md-3">
                <label class="ckbox" style="width:100%;">
                    <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" name="check_list[]" > <span><?php echo $value['ulbname']; ?></span>
                </label>
            </div>
            <?php }?>
        </div>
    
    </div>
</div>

  <hr>    
       <center>
 <div class=""><input type='button' value='Create' class='btn btn-success' id='savemenuwidgetid' onclick='savemenuwidget()'> </div>    
 
 </center>
 
</div>
<script>
    $("#checkAll").change(function(){
        //alert('check All');
        //$(".checkbox").prop('checked', $(this).prop("checked"));
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>       
       