<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
   
  <script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script>
    
    
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/fontawesome/css/all.css">
    
    <link href="<?php echo base_url()?>assets/nestable/style.css" rel="stylesheet">

   


<style>
    .panel-body {
    padding: 3px !important;
}
   .addmenu{ 
    margin-right: 8px; margin-bottom: 5px;
   }
   
   .widget_lay_bg{
        background-color: #f0f2eb;
        min-height: 70px;
}
   
</style>

 <script>
     function search_widgetfun(){
         
         
         
         
        var keyword_widget=$("#keyword_widget").val();
        var ulbid=$("#ulbid").val();
           // alert(ulbid);
          //  alert(keyword_widget);
            $.ajax({
                    type:'POST',
                    url:'<?php echo base_url(); ?>WidgetLayoutMapController/ajax_pages_search',
                    data:'keyword_widget='+keyword_widget + '&ulbid=' + ulbid,
                    success:function(html){
                        //alert(html);
                        $('#menu-add').html(html);
                        
                    }
            
        });
        
    }
    </script>

  </head>
  <body>
      <?php //print_r($publishedPages->result_array()); ?>
    <div class="sh-pagebody">


<div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Widget Mapping</div>
         <div class="card-body ">

    
        
        <div class="widget_lay_bg">
            
            <div class="col-sm-12  form-horizontal">
                
                <?php  echo form_open('widget-layout-map'); ?>
                <div class="row pt-3">
                    <label class="control-label col-sm-2 text-right pt-2">Page sections</label>
                    <div class="col-sm-3" style="padding-left:0px;">
                      <select name="menuType" id="menuType" class="form-select" >
                        <option value="">---Select---</option>
                        <?php $string="";foreach($menu_types->result() as $key=>$val){ if($val->page_layout_id==$menu_type_selected){$string="selected"; $menuName=$val->page_layout_desc;}else{$string="";}?>
                        <option value="<?php echo $val->page_layout_id; ?>" <?php echo $string; ?>> <?php echo $val->page_layout_desc;?> </option>
                        <?php }?>
                      </select>
                    </div>
                    
                    
                    <label class="control-label col-sm-1 text-right pt-2"  >SITE</label>
                    <div class="col-sm-3" style="padding-left:0px;">
                      <select name="ulbid" id="ulbid" class="form-select">
                        <option value="">---Select---</option>
                        <?php $string="";foreach($ulblist->result() as $key=>$val){ if($ulbidselected== $val->ulbid){$string="selected";}else{$string="";}?>
                        <option value="<?php echo $val->ulbid; ?>" <?php echo $string; ?>> <?php echo $val->ulbname;?> </option>
                        <?php }?>
                      </select>
                    </div>
                    
                    <div class="col-sm-1" style="padding-left:0px;">
                        <input type="submit" name="select" value="Select" style="margin-top: 2px;" class="btn btn-success btn-sm">
                    </div>
                    
                </div>

                <?php echo form_close();?>
            </div>
            
        </div>
        
        <div class="clearfix"></div>
        
    <hr style="margin-top:0px !important; margin-bottom: 11px;">

    

      <div class="row output-container" style="display:none;">
        <div class="col-md-offset-1 col-md-10">
          <h2 class="text-center">Output:</h2>
          <form class="form">
            <textarea class="form-control" id="json-output" rows="5"></textarea>
          </form>
		  <form>
		  <span id="arrformat"></span>
		  </form>
        </div>
      </div>

    
    <!--start-->
  
  <div class="row">
  
  
    <div class="col-md-4" style="padding-left: 0px;">

        <div id="accordion">
          
           <div class="card" >
              <div class="card-header" data-toggle="collapse" data-parent="" href="#Widgets">
                Widgets  
              </div>
              <div id="" class="collapse show" data-bs-parent="#accordion">
                <div class="card-body">
                    
                    <div>
                
                    <form>
                      <div class="input-group">
                            <input type="hidden" id="customlink_val" value="1"/>
                            <input type="text" class="form-control" id="keyword_widget" placeholder="Search" style="height:30px; border-radius:0px;" onkeyup="search_widgetfun()">
                            <div class="input-group-btn">
                              <button class="btn btn-default" type="button" style="height:30px;">
                                <i class="fa fa-search"></i>
                              </button>
                            </div>
                      </div>
                </form>  
               
           </div>
                   
            <div style="overflow-y: scroll;height: 300px;border:1px solid #ddd;padding:10px;margin:8px;">
           
            
            <form class="form-inline" id="menu-add">
		    
             <?php $i=1; foreach($publishedPages->result_array() as $key=>$val){?>
            <label class="ckbox" style="width:100%;">
            <input type="checkbox" id="addInputSlug<?php echo $val['widget_id'];?>" value="<?php echo $val['widget_id']; ?>" class="chk"><span><?php echo $val['widget_name']?></span><br>
			<input type="hidden" id="addInputName<?php echo $val['widget_id'];?>" value="<?php echo $val['widget_name']?>">
			</label>
			
			<?php $i++;}?>
            
           
			   
           
          
              </form>
              
        </div> 
                   
                </div>
                
                <div class="card-footer">
                    <div class="">
               <!-- <button type="button" class="btn btn-default btn-sm">Add to Menu</button>-->
                <button class="btn btn-secondary btn-sm addmenu" id="addButton" >Add to menu </button>
			
            </div> 
                    
                </div>
                
                 
              </div>
            </div>
            
        
        </div>

    </div>
    
   <div class="col-md-8" style="padding-right: 0px;">
       
       <div style="border:1px solid #ccc;">
           
        <div class="menu_st">
        <div class="row">
            <div class="col-md-8 form-horizontal">
                <div class="form-group">
                    <i class="control-label col-sm-4" for="email">Menu Name:</i>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="menuName" placeholder="" value="<?php echo $menuName; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div>
                
                <input type="button" class="btn btn-warning btn-sm" onclick="savebutton()" value="Save menu">
                <!--<button type="button" class="btn btn-warning btn-sm">Save Menu</button>-->
                </div>
            </div>
        </div>
    </div>
    
    <div class="menu_pad">
        
    <div class="menu_titile">Menu Structure</div>
      <p style="font-size:12px;">Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.</p>
      
           
               
          <div class="dd nestable" id="nestable">
            <ol class="dd-list">
                
                <?php $i=1;  
                if(isset($parentMenus[0]))
                {
                foreach($parentMenus[0] as $main_menu_id=>$val_array1){
                foreach($val_array1 as $page_id=>$main_menus_descarray){
                ?>
                <li class="dd-item" data-id="<?php echo $i; ?>" data-name="<?php echo $main_menus_descarray['page_name']; ?>" data-slug="<?php echo $page_id; ?>" data-new="0" data-deleted="0">
                   
                   
                <div class="dd-handle"><?php echo $main_menus_descarray['page_name']; ?> <span class="pull-right menu_page"> <?php echo $main_menus_descarray['page'];?> </span> </div>
                <span class="button-delete btn btn btn-outline-secondary btn-sm pull-right"
                      data-owner-id="<?php echo $i; ?>" title="Delete">
                  
                  <i class="fas fa-times-circle"></i>
                </span>
                <span class="button-edit btn btn btn-outline-secondary btn-sm pull-right"
                      data-owner-id="<?php echo $i; ?>" data-bs-toggle="modal"  data-bs-target="#myModal" onclick="showMode(<?php echo $page_id; ?>)" title="Edit">
                  <i class="fas fa-edit"></i>
                </span>
                
                <!-- ----- first child menus -->
                
                <?php if(count($subMenus[0][$main_menu_id]) > 0){$i++;?>
                
                <ol class="dd-list">
                  <!--  Item4 -->
                  <?php foreach($subMenus[0][$main_menu_id] as $submenuid=>$val_array2){
                  foreach($val_array2 as $sub_page_id=>$sub_menus_descarray){?>
                  <li class="dd-item" data-id="<?php echo $i; ?>" data-name="<?php echo $sub_menus_descarray['page_name']; ?>" data-slug="<?php echo $sub_page_id; ?>" data-new="0" data-deleted="0">
                    <div class="dd-handle"><?php echo $sub_menus_descarray['page_name']; ?> <span class="pull-right menu_page"><?php echo $sub_menus_descarray['page'];?></span> </div>
                    <span class="button-delete btn btn btn-outline-secondary btn-sm pull-right"
                          data-owner-id="<?php echo $i; ?>" title="Delete">
                      <i class="fas fa-times-circle"></i>
                    </span>
                    <span class="button-edit btn btn btn-outline-secondary btn-sm pull-right"
                          data-owner-id="<?php echo $i; ?>" data-bs-toggle="modal" onclick="showMode(<?php echo $sub_page_id; ?>)" title="Edit">
                     <i class="fas fa-edit"></i>
                    </span>
                    
                    <!-- ----- second child menus -->
                    
                    <?php if(count($subSubMenus[0][$main_menu_id][$submenuid]) > 0){$i++;?>
                    
                    <ol class="dd-list">
                          <!-- - Item4 - -->
                          
                          <?php foreach($subSubMenus[0][$main_menu_id][$submenuid] as $subsubmenuid=>$val_array3){
                                foreach($val_array3 as $sub_sub_page_id=>$sub_sub_menus_descarray){?>
                          <li class="dd-item" data-id="<?php echo $i; ?>" data-name="<?php echo $sub_sub_menus_descarray['page_name']; ?>" data-slug="<?php echo $sub_sub_page_id; ?>" data-new="0" data-deleted="0">
                            <div class="dd-handle"><?php echo $sub_sub_menus_descarray['page_name']; ?> <span class="pull-right menu_page"> <?php echo $sub_sub_menus_descarray['page'];?> </span> </div>
                            <span class="button-delete btn btn-outline-secondary btn-sm pull-right"
                                  data-owner-id="<?php echo $i; ?>" title="Delete">
                             <i class="fas fa-times-circle"></i>
                            </span>
                            <span class="button-edit btn btn-outline-secondary btn-sm pull-right"
                                  data-owner-id="<?php echo $i; ?>" data-bs-toggle="modal" onclick="showMode(<?php echo $sub_sub_page_id; ?>)" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </li>
                          <?php $i++; }}?>
                  </ol>
                  
                  <?php $i++;}?>
                    
                    
                    <!--  second chile menus close-->
                    
                    
                    
                    
                  </li>
                  <?php  $i++;}}?>
                  
                  
                 </ol>
                 
                 <?php $i++;}?>
                 <!--first child close -->
                
                </li>
               
               <?php   $i++;}}}?>
               
			</ol>
			
			

        
    </div>
    
    </div>
    
    <div class="menu_st">
        
       
        <input type="button" class="btn btn-warning btn-sm pull-right" onclick="savebutton()" value="Save menu">
        
            </div>
			
    </div>
    </div>
    
  </div>  
    <!-- --------- model-->
    
    <div id="myModal" class="modal fade"  >
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header mymodhead_bg">
          <h5 class="modal-title">Page</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body" style="padding-top: 15px !important;">
          
                    <div class="col-md-12">
                          <div class="form-group">
                            <i for="email">Navigation Label:</i>
                            <input type="hidden" id="page_id">
                            <input type="text" class="form-control" id="page_name">
                          </div>
                   </div>
                   <div class="col-md-12">
                       <div class="form-group">
                            <i for="email">Title Attribute:</i>
                            <input type="text" class="form-control" id="page_title">
                          </div>
                   </div>
                   
                   <div class="col-md-12">
                       <div class="form-group">
                       <i>Url</i>
                       <input type="text" class="form-control" id="" >
                       </div> 
                   </div>       
                   
                   <div class="clearfix"></div>
                   
                   <div style="padding-left: 16px;">
                   <label class="ckbox">
                    <input type="checkbox" id="target" value="1"><span>Open link in a new window/tab</span>
                   </label>
                   </div>
                   
                   <hr>
                   
                    
					
      </div>
      <div class="modal-footer">
        <div style="padding-left: 16px;"> <a class="modify_option" href="#" onclick="updatePage()"> Save </a> | <a class="modify_option1" onclick=""> Remove </a> 
		</div>
      </div>
    </div>

  </div>
</div>
    
    
    
    
    
 </div>
</div>   
    
    
    
    

 
    
    <script src="<?php echo base_url()?>assets/nestable/jquery.nestable.js"></script>
    
    <script src="<?php echo base_url()?>assets/nestable/jquery.nestable++.js"></script>
    
    <script>
      $('#nestable').nestable({
        maxDepth: 1
      })
        .on('change', updateOutput);
    </script>
	<script>
	function savebutton()
	{
	    
	 var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';   
	    
	if(confirm('Do you really want to update menus'))
	{
	var aaa=$("#json-output").val();
	
	var ulbid=$("#ulbid").val();
	
	    
	    var menu_type=$("#menuType").val();
	
		$.get('WidgetLayoutMapController/updatePages',{aaa:aaa,menu_type:menu_type,ulbid:ulbid, 'csrf_test_name': csrf_value},function(data)
		  {
			  //$("#arrformat").html(data);
			  console.log(data);
			  alert('Menus updated');
			  
			  
	})
	}
	}
	
    function addcustumlink()
    {
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        
        var menu_type=$("#menuType").val();
        var urlname=$("#url").val();
        var linktext=$("#linktext").val();
        
        
        if(linktext=='')
        {
            alert('Enter linktext');
            return false;
        }
        
        if($("#target").is(":checked"))
        {
            is_targetblank=1;
            return false;
        }
        
        
            
        
        $.post('MapPageController/createCustomLink',{urlname:urlname,linktext:linktext,menu_type:menu_type,'csrf_test_name':csrf_value},function(data)
        {
           
               location.reload();
               
           
        });
        
       
    }
    
    

function showMode(page_id)
{
    
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    
   $.post('MapPageController/getPageInfo',{page_id:page_id,'csrf_test_name':csrf_value},function(data)
   {
      var obj = JSON.parse(data);
      $("#page_id").val(page_id);
      $("#page_name").val(obj.page_name);
      $("#page_title").val(obj.page_title);
      if(obj.is_target_blank=='1')
      {
          
          $('#target').prop('checked',true);
      }
      else
      {
          $('#target').removeProp('checked');
      }
   });
   
   
    $("#myModal").modal();
}

function updatePage()
{
   var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    var page_id=$("#page_id").val();
    var page_name=$("#page_name").val();
    var page_title=$("#page_title").val();
    var is_targetblank=0;
    if(page_name=='')
    {
        alert('Enter navigation label');
        return false;
    }
    if(page_title=='')
    {
        alert('Enter Page Title');
        return false;
    }
    
     if($("#target").is(":checked"))
        {
            
            is_targetblank=1;
        }
        
     $.post('MapPageController/updatePageInfo',{page_id:page_id,page_name:page_name,page_title:page_title,is_targetblank:is_targetblank,'csrf_test_name':csrf_value},function(data)
   {
      
      alert(data);
      <?php //redirect('widget-layout-map'); ?>
      
   });
   
    
}

$(document).ready(function()
{
    $("#addPost").click(function(e)
    {
        e.preventDefault();
        addToPost();
    });
    
     $("#addCat").click(function(e)
    {
        e.preventDefault();
        addToCat();
    });
     $("#addButton").click(function(e)
    {
        e.preventDefault();
        addToMenu();
    });
    
    
});
	</script>
  </body>
</html>
