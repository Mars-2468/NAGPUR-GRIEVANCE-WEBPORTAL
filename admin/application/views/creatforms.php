<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>



<script>
    
function addAdvance()
{
	
//alert(addAdvance);
    var divcontent;
    
    var j = eval (document.getElementById('cnt').value);
    var i = j+1;
	
    var newdiv = document.createElement('div');
    newdiv.setAttribute('id', i);
	newdiv.setAttribute('class', 'wid-gal-list');
    divcontent="";
    
            
	divcontent=divcontent + "<div class='form-horizontal' style='margin:4px 0 0 10px;'>"+
                                "<div class='form-group'>"+ 
                                    "<div class='col-md-4' style='clear: both;'>"+
                                        "<label>Label</label>"+
                                            "<input type='text' class='form-control' id='' name='label[]'>"+
                                    "</div>"+
                                    "<div class='col-md-4'>"+
                                        "<label>Type</label>"+
                                        "<select class='form-control' id='types"+i+"' name='type[]'  onchange='show_list("+i+")'>"+
                                            "<option value='0'>- Select -</option>"+
                                            "<?php foreach($category_forms_types as $key=> $val){ ?>"+
    	                                    "<option value='<?php echo $val['id']; ?>'><?php echo $val['description'];?></option>"+
    	                                    "<? }?>"+
                                        "</select>"+
                                    "</div>"+
            
                                    "<div class='col-md-3'>"+
                                        "<label>Data Type</label>"+
                                        "<select class='form-control' id='data_type' name='data_type[]'>"+
                                            "<option value='0'>- Select -</option>"+
                                            "<?php foreach($category_forms_datatype as $key=> $val){ ?>"+
                                        	"<option value='<?php echo $val['id']; ?>'><?php echo $val['description'];?></option>"+
                                        	"<? }?>"+
                                        "</select>"+
                                    "</div>"+
                                    "<div class='col-md-1' style='padding-top: 26px;padding-left:0px;'>"+
                                        "<input type='button' class='btn btn-success btn-sm' value='+' onclick='addAdvance()' style='margin-right: 5px;'>"+
                                        "<input type='button' class='btn btn-danger btn-sm' value=' - ' onclick='fnRemove(" + i +");' />"+
                                    "</div>"+
                                "</div>"+
                                   
                                "<input type='hidden' name='addTypecnt[]' value='0' id='addTypecnt"+i+"'>"+
                                "<div class='row' style='display:none;' id='showOptionsRowDiv"+i+"'>"+
                                    "<div class='col-md-4'></div>"+
                                    "<div class='col-md-4' id='show_options"+i+"'></div>"+
                                "</div>"+
                            "</div>"+
                            "<div class='clearfix'></div>"+
                            "<span id='options"+i+"'></span>"+
                            "</div>"+
                            "<input type='hidden' value='0'  name='optioncount"+i+"'  id='optioncount"+i+"'/>";
            
         newdiv.innerHTML = divcontent;                                  
			document.getElementById('addLabelDiv').appendChild(newdiv);
   
			document.getElementById('cnt').value = eval (document.getElementById('cnt').value) + 1 ;
			//$(".datepick").datepicker({dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true,maxDate: '0',minDate: "-6M"});
    
  }
  
  function fnRemove(arg)
{
    
    var d1=document.getElementById(arg).parentNode;
    var d2=document.getElementById(arg);
    d1.removeChild(d2); 
    var arg=arg-1;
}

</script>

<script>

function show_list(i){
    //alert(i);
    var types=$("#types" +i).val();
    //alert(types);
    
    var data = '';
    if(types =='select' || types == 'checkbox' || types == 'radio') {
        $("#addTypecnt"+i).val('1');
        $("#showOptionsRowDiv"+i).show();   
        data += "<div class='form-horizontal wid-gal-list' style='padding-top:8px;margin-bottom: 9px;'>"+
                            "<div class='row'>"+
                                "<div class='col-md-8' style='margin: 0px 0 0 24px;'>"+
                                    "<div class='form-group'>"+
                                        "<label for='email'>option:</label>"+
                                        "<input type='text' class='form-control' name='options"+i+"1' id='TypeName_"+i+"1'>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-md-1' style='margin: 26px 0 0 0px;'>"+
                                    "<input type='button' class='btn btn-success btn-sm' onclick='addTypeDy("+i+")' value=' + '>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
        $("#show_options"+i).html(data);                
   
    }else{
        $("#showOptionsRowDiv"+i).hide();
        $("#show_options"+i).html('');
        $("#addTypecnt"+i).val('0');
    }
}
function addTypeDy(i){
    //alert(i);
    var k = eval(document.getElementById('addTypecnt'+i).value);
    k = k+1;
    //alert(k);
    var newdiv = document.createElement('div');
    newdiv.setAttribute('id', 'addType_'+i+'_'+k);
	newdiv.setAttribute('class', 'wid-gal-list');
    
    
    var addTypeDiv = '';
    
    addTypeDiv += "<div class='form-horizontal' style='margin-top:10px;margin-bottom: 9px'>"+
                        "<div class='row'>"+
                            "<div class='col-md-7' style='margin: 0px 0 0 24px;'>"+
                                "<div class='form-group'>"+
                                    "<label for='email'>option:</label>"+
                                    "<input type='text' class='form-control' name='options"+i+""+k+"' id='TypeName_"+i+""+k+"'>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-md-4' style='margin: 26px 0 0 0px;'>"+
                                "<input type='button' class='btn btn-success btn-sm' style='margin-right: 5px;' onclick='addTypeDy("+i+")' value=' + '>"+
                                "<input type='button' class='btn btn-danger btn-sm' value=' - ' onclick='addTypeRemoveDy("+i+","+k+");' />"+
                            "</div>"+
                        "</div>"+
                    "</div>";
                    
    newdiv.innerHTML = addTypeDiv;                                  
	document.getElementById('show_options'+i).appendChild(newdiv);    
	document.getElementById('addTypecnt'+i).value = eval (document.getElementById('addTypecnt'+i).value) + 1 ;
}
function addTypeRemoveDy(i,k){
    //alert(i+" "+k);
    var divId = 'addType_'+i+'_'+k; 
    var d1=document.getElementById(divId).parentNode;
    var d2=document.getElementById(divId);
    d1.removeChild(d2); 
    var k = k-1;
    
    
}    
</script>

<?php //print_r($selectedValue); //echo count($pageResult); ?>
<div class="sh-pagebody">
    <?php echo $this->session->flashdata('message'); ?>
    <!--<form method="post" id="pageSelectedForm" action="<?php  //"CreatFormController/getSelectOptionContent/" ?>"/>-->
    
    <?php $attributes=array('method'=>'POST'); echo form_open('CreatFormController/getSelectOptionContent/',$attributes);?>
    
    <input type="hidden" name="formsubmit" value="1" id="formsubmit">
    <div class="card bd-primary">
        <div class="card-header bg-primary tx-white"></div>
        <div class="card-body">
        
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <?php //print_r($category_forms_datatype); ?>
                    <div class="form-horizontal" >
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="custom_menus_list">option:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="selectedValue" name="selectedValue" onchange="pageSelectedValue()">
                                    <option value="">-Select-</option>
                                    <?php foreach($page_names->result_array() as $key=>$val){ 
                                        if($selectedValue == $val['page_id']){
                                    ?>        
                                            <option value="<?php echo $val['page_id']; ?>" selected><?php echo $val['page_name']; ?></option>
                                    <?php        
                                        }else{    
                                    ?>
                                    <option value="<?php echo $val['page_id']; ?>"><?php echo $val['page_name']; ?></option> 
                                    <? }
                                    }
                                    ?>	
                                
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--</form>-->
    <?php echo form_close();?>
    <hr style="margin-top: 8px !important;">
    
    <?php $attributes=array('method'=>'POST'); echo form_open('CreatFormController/add_forms/',$attributes);?>
    
    <!--<form method="post" action="<?php //echo base_url(). "CreatFormController/add_forms/" ?>"/>-->
    
    <input type="hidden" value="<?php print_r($selectedValue); ?>" id="pageIdValue" name="pageIdValue" />        
    <input type="hidden" name="cnt" value="<?php if(count($pageResult) > 1){ echo count($pageResult)-1;}else{ echo 0; }  ?>" id="cnt">
    <input type="hidden" name="staticDyValue" value="<?php if(count($pageResult) > 1){ echo 1;}else{ echo 0; }  ?>" id="staticDyValue">
    <div class="card bd-primary">
        <div class="card-header bg-primary tx-white"></div>        
            <div id="dymanicDataDiv" style="">
                <?php 
                    $i = 0;
                    foreach($pageResult as $key=>$value){
                        $stringtype = "";
                        $stringdatatype = "";
                ?>
                <div style="border:1px solid #ccc;padding: 10px;" id="<?php echo $i; ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Label:</label>
                                <input type="text" class="form-control" value="<?php echo $value['label']; ?>" id="labelName" name="label[]">
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Type:</label>
                                <select class="form-control" id="types<?php echo $i;?>" onchange="show_list(<?php echo $i;?>)" name="type[]">
                                    <option value="0">-Select-</option>
                                    <?php 
                                        foreach($category_forms_types as $key=> $val){
                                            if($value['type'] == $val['id']){
                                                $stringtype = "selected";
                                    ?>
                                    <option value="<?php echo $val['id']; ?>" <?php echo $stringtype; ?> ><?php echo $val['description'];?></option>
                                    <?php
                                            }else{
                                    ?>            
                                    <option value="<?php echo $val['id']; ?>"  ><?php echo $val['description'];?></option>            
                                    <?php
                                            }
                                    ?>
                                    
                                    
                                    <? }?>
                                
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">Data Type:</label>
                                <select class="form-control" id="data_type" name="data_type[]">
                                    <option value="0">-Select-</option>
                                    <?php foreach($category_forms_datatype as $key=> $val){ 
                                       if($value['data_type'] == $val['id']){
                                            $stringdatatype = "selected";
                                    ?>
                                        <option value="<?php echo $val['id']; ?>" <?php echo $stringdatatype; ?> ><?php echo $val['description'];?></option>
                                    <?php
                                        }else{
                                    ?>            
                                        <option value="<?php echo $val['id']; ?>"  ><?php echo $val['description'];?></option>            
                                    <?php
                                        }
                                    }?>
                                
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-1" style="margin-top: 26px;padding-left:0px;">
                            <input type='button' class="btn btn-success btn-sm" onclick="addAdvance()" value=" + ">
                            <input type='button' class='btn btn-danger btn-sm' value=' - ' onclick='fnRemove("<?php echo $i; ?>");' />
                        </div>
                    </div>
                    <input type="hidden" name="addTypecnt[]" value="<?php echo count($value['0']);?>" id="addTypecnt<?php echo $i;?>">
                    <div class="row" style="" id="showOptionsRowDiv<?php echo $i; ?>">
                        
                        <div class="col-md-4"></div>
                        <div class="col-md-4" id="show_options<?php echo $i; ?>">
                            <?php 
                                    $j = 1;
                                    foreach($value['0'] as $key => $val){
                                        
                            ?>
                            <div class='form-horizontal' style='margin-top:10px;' id='addType_<?php echo $i."_".$j; ?>'>
                            <div class='row'>
                                <div class='col-md-7' style='margin: 0px 0 0 24px;'>
                                    <div class='form-group'>
                                        <label for='email'>option:</label>
                                        <input type='text' value='<?php echo $val['option_desc']; ?>' class='form-control' name='options<?php echo $i.$j; ?>' id='TypeName_<?php echo $i.$j; ?>'>
                                    </div>
                                </div>
                                <div class='col-md-4' style='margin: 26px 0 0 0px;'>
                                    <input type='button' class='btn btn-success btn-sm' style='margin-right: 5px;' onclick='addTypeDy(<?php echo $i; ?>)' value=' + '>
                                    <input type='button' class='btn btn-danger btn-sm' value=' - ' onclick='addTypeRemoveDy(<?php echo $i.",".$j; ?>);' />
                                </div>
                            </div>
                        </div>
                        <?php
                                $j++;
                                    }
                                
                            
                            ?>
                        </div>
                    </div>
                
                </div>
                    
                <?
                    $i++;
                }?>
            </div>
            
            <div class="" id="advance_div">
                <div style="border:1px solid #ccc;padding: 10px;">
                
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Label:</label>
                                <input type="text" class="form-control" id="labelName" name="label[]">
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Type:</label>
                                <select class="form-control" id="types0" onchange="show_list(0)" name="type[]">
                                    <option value="0">-Select-</option>
                                    <?php foreach($category_forms_types as $key=> $val){ ?>
                                    <option value="<?php echo $val['id']; ?>"><?php echo $val['description'];?></option>
                                    <? }?>
                                
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">Data Type:</label>
                                <select class="form-control" id="data_type" name="data_type[]">
                                    <option value="0">-Select-</option>
                                    <?php foreach($category_forms_datatype as $key=> $val){ ?>
                                    <option value="<?php echo $val['id']; ?>"><?php echo $val['description'];?></option>
                                    <? }?>
                                
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-1" style="margin-top: 26px;padding-left:0px;">
                            <input type='button' class="btn btn-success btn-sm" onclick="addAdvance()" value=" + ">
                        </div>
                    </div>
                    <input type="hidden" name="addTypecnt[]" value="0" id="addTypecnt0">
                    <div class="row" style="display:none;" id="showOptionsRowDiv0">
                        
                        <div class="col-md-4"></div>
                        <div class="col-md-4" id="show_options0"></div>
                    </div>
                
                </div>
            
            </div>
            
            <div id="addLabelDiv"></div>
        
        </div>
    </div>
    </br></br>
   <center>   <input type="submit" name="save" class="btn btn-success btn-sm"></center>
    <!--</form>-->
    
    <?php echo form_close(); ?>
    
</div>
<script>
    /*function typeId(k){
        //alert("click");
        var typeValue = $("#type" +k).val();
        //alert(typeValue);
        $("#addTypecnt0").val('1');
        var checkDiv = '';
        if(typeValue == 'checkbox' || typeValue == 'radio' || typeValue == 'select'){
            checkDiv += "<div class='form-horizontal wid-gal-list' style='padding-top:8px;'>"+
                            "<div class='row'>"+
                                "<div class='col-md-8' style='margin: 0px 0 0 24px;'>"+
                                    "<div class='form-group'>"+
                                        "<label for='email'>option:</label>"+
                                        "<input type='text' class='form-control' name='options[]' id='TypeName_00'>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-md-1' style='margin: 26px 0 0 0px;'>"+
                                    "<input type='button' class='btn btn-success btn-sm' onclick='addTypeDy()' value=' + '>"+
                                "</div>"+
                            "</div>"+
                        "</div>";  
            $("#showOptionsRowDiv").show();
            $("#show_options").html(checkDiv);
        }else{
            $("#showOptionsRowDiv").hide();
            $("#show_options").html('');
            $("#addTypecnt0").val('0');
        }
        
    }
    
    function addType(){
        //alert('ok');
        var j = eval(document.getElementById('addTypecnt0').value);
        var i = i+1;
        
        var newdiv = document.createElement('div');
        newdiv.setAttribute('id', 'addType_'+i);
    	newdiv.setAttribute('class', 'wid-gal-list');
        
        
        var addTypeDiv = '';
        
        addTypeDiv += "<div class='form-horizontal' style='margin-top:10px;'>"+
                            "<div class='row'>"+
                                "<div class='col-md-7' style='margin: 0px 0 0 24px;'>"+
                                    "<div class='form-group'>"+
                                        "<label for='email'>option:</label>"+
                                        "<input type='text' class='form-control' name='options[]' id='TypeName_0"+i+"'>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-md-4' style='margin: 26px 0 0 0px;'>"+
                                    "<input type='button' class='btn btn-success btn-sm' style='margin-right: 5px;' onclick='addType()' value=' + '>"+
                                    "<input type='button' class='btn btn-danger btn-sm' value=' - ' onclick='addTypeRemove(" + i +");' />"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                        
        newdiv.innerHTML = addTypeDiv;                                  
			document.getElementById('show_options').appendChild(newdiv);    
			document.getElementById('addTypecnt0').value = eval (document.getElementById('addTypecnt0').value) + 1 ;
    }
    function addTypeRemove(id){
        var divId = 'addType_'+id; 
         var d1=document.getElementById(divId).parentNode;
        var d2=document.getElementById(divId);
        d1.removeChild(d2); 
        var id=id-1;
    }*/
    function pageSelectedValue(){
        document.getElementById('pageSelectedForm').submit();
        //var pageVal = $("#selectedValue").val();
        //alert(pageVal);
      //  $("#pageIdValue").val(pageVal);
    }    
</script>
<script>
    var count = "<?php echo count($pageResult); ?>";
    //alert(count);
    if(count >= 1){
        $("#advance_div").hide();
        $("#dymanicDataDiv").show();
    }else{
        $("#advance_div").show();
        $("#dymanicDataDiv").hide();
    }
</script>