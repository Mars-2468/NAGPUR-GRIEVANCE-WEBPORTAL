<script>
    
function validateForm()
{
errors=0;

$(".mytext").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});



$(".dropdown").each(function(){
	
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
		
    	
	if(errors==0)
	{
		return true;
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
}
</script>

<script>
    
    function addAdvance()
{
	



    var divcontent;
    var i = document.getElementById('cnt').value;
    var j = i-1;
	
     var newdiv = document.createElement('div');
     newdiv.setAttribute('id', i);
	 newdiv.setAttribute('class', 'wid-gal-list');
     divcontent="";
    
           
// 			divcontent=divcontent + "<div class='col-md-1' style='margin-top:18px;'>";
//             divcontent=divcontent + "";
//             divcontent=divcontent + "</div>"; 
            
            
            divcontent=divcontent + "<div class='form-group col-md-3' style='padding-left:0px;'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'>Upload Photo</label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input  name='userfile[]' class='input-file mytext FileUpload" + i +"' type='file' onchange='checkimage(" + i +");'>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            
           /* divcontent=divcontent + "<div class='form-group col-md-2'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'>Paste Url</label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input id='image_url' name='image_url[]' placeholder='Enter url here' class='form-control input-md' type='text'>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";*/
            
            
            
            
            divcontent=divcontent + "<div class='form-group col-md-3'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'> Title </label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input id='title' name='title[]' placeholder='Enter title here' class='form-control input-md mytext' type='text'>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            divcontent=divcontent + "<div class='form-group col-md-3'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'>Page Url</label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input id='page_url' name='page_url[]' placeholder='Enter url here' class='form-control input-md mytext' type='text'>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            
            divcontent=divcontent + "<div class='form-group col-md-2'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'>Open window</label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<select id='target' name='target[]' class='form-control dropdown'>";
            
            divcontent=divcontent + "<option value='0'>- Select -</option>";
            divcontent=divcontent + "<option value='1'>Open same window</option>";
            divcontent=divcontent + "<option value='2'>Open other window</option>";
            
            divcontent=divcontent + "</select>";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            
            divcontent=divcontent + "<div class='form-group col-md-1'>";
            divcontent=divcontent + "<label class='control-label' for='textinput'></label>";
            divcontent=divcontent + "<div class=''>";
            divcontent=divcontent + "<input type='button' class='btn btn-danger' value=' - ' onclick='fnRemove(" + i +");' />";
            divcontent=divcontent + "</div>";
            divcontent=divcontent + "</div>";
            
            
        divcontent=divcontent + "</div>";
    divcontent=divcontent + "</div>";
            
           
            
    

			newdiv.innerHTML = divcontent;                                  
			document.getElementById('advance_div').appendChild(newdiv);
   
			document.getElementById('cnt').value = eval (document.getElementById('cnt').value) + 1 ;
			$(".datepick").datepicker({dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true,maxDate: '0',minDate: "-6M"});
    
  }
  
  function fnRemove(arg)
{
	
	
	
	
    var d1=document.getElementById(arg).parentNode;
    var d2=document.getElementById(arg);
    d1.removeChild(d2); 
    var arg=arg-1;
 
   }
    
</script>


<style>
 
#mceu_1 {
    width: 37px !important;
     position:relative; !important;
    /*left: 10px;*/
    /*bottom: 65px;
    height: 30px;*/
}
    
</style>

<hr>
<?php $attributes=array('onsubmit'=>'return validateForm()'); echo form_open_multipart('CreateWidgetController/saveMediaGallerywidget',$attributes); ?>


<input type="hidden" name="cnt" value="0" id="cnt">
<input type="hidden" name="widgettype" value="<?php echo $widgetdet['widget_type']; ?>">
<input type="hidden" name="widgetname" value="<?php echo $widgetdet['widgetname']; ?>">

    


    <div class="card bd-teal ">
        <div class="card-header bg-teal tx-white">Add photos</div>
        <div class="card-body ">
        
            <div class="" id="advance_div">
                
                <div class="wid-gal-list">
                
                
                    <div class="form-group col-md-3" style="padding-left:0px;">
                        <label class="control-label " for="textinput">Upload Photo</label>  
                        <div class="">
                            <input  name="userfile[]" class="input-file mytext FileUpload" type="file"  onchange="checkimagetype();"/>
                        </div>
                    </div>
                    
                   <!-- <div class="form-group col-md-2">
                        <label class=" control-label" for="textinput">Paste Image Url</label>  
                        <div class="">
                            <input id="image_url" name="image_url[]" placeholder="Enter url here" class="form-control input-md" type="text">
                        </div>
                    </div>-->
                    
                    <div class="form-group col-md-3">
                        <label class=" control-label" for="textinput"> Title </label>  
                        <div class="">
                            <input id="title" name="title[]" placeholder="Enter title here" class="form-control input-md mytext" type="text">
                        </div>
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label class=" control-label" for="textinput">Page Url</label>  
                        <div class="">
                            <input id="page_url" name="page_url[]" placeholder="Enter url here" class="form-control input-md mytext" type="text">
                        </div>
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label class=" control-label" for="textinput">Open window</label>  
                        <div class="">
                            <select id="target" name="target[]" class="form-control dropdown">
                                <option value="0">- Select -</option>
                                <option value="1">Open same window</option>
                                <option value="2">Open other window</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-1">
                        <label class=" control-label" for="textinput"></label>  
                        <div class="">
                            <input type='button' class="btn btn-success" style="margin-top:6px;" onclick="addAdvance()" value=" + ">
                        </div>
                    </div>
                    
                </div>
            </div>
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
                        <input class="chkcat checkbox1" type="checkbox"  value="<?php echo $value['ulbid']; ?>" name="ulb_check_list[]" > <span><?php echo $value['ulbname']; ?></span>
                    </label>
                </div>
                <?php }?>
            </div>
        
        </div>
    </div>
    <br>
    <div style="width:100%; text-align:center; clear:both;">
    <input type="submit" name="save" value="Create" class="btn btn-success btn-sm">
    </div>
    

<?php echo form_close();?>


<script>

   function checkimagetype(){
                   
       // var id=$(".FileUpload" +i).val();
        
        var ext = $(".FileUpload").val().split('.').pop().toLowerCase();
         //alert(ext);
         if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
             alert("Upload only image formats");
             $(".FileUpload").val('')
         }
        
    }
  
</script>

<script>

   function checkimage(i){
                   
       // var id=$(".FileUpload" +i).val();
        
        var ext = $(".FileUpload" +i).val().split('.').pop().toLowerCase();
         //alert(ext);
         if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
             alert("Upload only image formats");
             $(".FileUpload" +i).val('')
         }
        
    }
    
    $("#checkAll").change(function(){
        //alert('check All');
        //$(".checkbox").prop('checked', $(this).prop("checked"));
        $('input:checkbox').not(this).prop('checked', this.checked);
    });  
</script>





