<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nestable++</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="<?php echo base_url()?>assets/nestable/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
  </head>
  <body>
    <div class="sh-pagebody">
        
    <div style="display:inline-flex;">
          <div class="mypagetitile">News</div>    
            <a href="create-news" class="btn btn-default btn-sm mg-b-10">Add New</a>
           </div> 
    <hr>
        
        <div class="row">
            
            <div class="col-md-12">
                <!--
                <?php  echo form_open('map-pages'); ?>
                <label for="menutype">Menu type :</label>
                <select name="menuType" id="menuType">
                    <option value="">---select---</option>
                    <?php $string="";foreach($menu_types->result() as $key=>$val){ if($val->menu_type_id==$menu_type_selected){$string="selected"; $menuName=$val->menu_type_desc;}else{$string="";}?>
                    <option value="<?php echo $val->menu_type_id; ?>" <?php echo $string; ?>> <?php echo $val->menu_type_desc;?> </option>
                    <?php }?>
                </select>
                
                <input type="submit" name="select" value="select" class="btn btn-default btn-xs">
                
                <?php echo form_close();?>
                -->
            </div>
            
        </div>
        
    <hr>

    

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
  
    <div class="col-md-4">

  <div class="panel-group" id="accordion" style="cursor: pointer;">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand">
           <div class="right-arrow pull-right">+</div>
          <a href="#" style="text-decoration: none;font-size: 13px;font-weight: bold;">Pages</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">
           
           <div style="overflow-y: scroll;height: 150px;border:1px solid #ddd;padding:10px;margin:8px;">
           
            
            <form class="form-inline" id="menu-add">
		    
              <?php $i=1; foreach($publishedPages->result_array() as $key=>$val){?>
            <label class="ckbox" style="width:100%;">
            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chk"><span><?php echo $val['page_name']?></span><br>
			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
			</label>
			
			<?php $i++;}?>
			
            
       
            
            </div>
            
             
            <div class="pull-right">
               <!-- <button type="button" class="btn btn-default btn-sm">Add to Menu</button>-->
                <button class="btn btn-default btn-xs" id="addButton" >Add to menu </button>
			
            </div>
          
              </form>
              
        </div>
      </div>
    </div>
    
    <!---- posts --->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#" style="text-decoration: none;font-size: 13px;font-weight: bold;">Posts</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
           
           <div style="overflow-y: scroll;height: 150px;border:1px solid #ddd;padding:10px;margin:8px;">
           
            
            <form class="form-inline" id="add-post">
		    
              <?php $i=1; foreach($publishedPosts->result_array() as $key=>$val){?>
            <label class="ckbox" style="width:100%;">
            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chkpost"><span><?php echo $val['page_name']?></span><br>
			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
			</label>
			
			<?php $i++;}?>
			
            
       
            
            </div>
            
 
               <div class="pull-right">
                <button type="button" class="btn btn-default btn-xs" id="addPost" onclick="addpostsubmit()">Add to Menu</button>
            </div>
           
           
        </div>
      </div>
    </div>
    
    <!-- close --->
    
    <!-- custom links --->
    
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#" style="text-decoration: none;font-size: 13px;font-weight: bold;">Custom Links</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body form-horizontal">
             <div class="form-group">
                <i class="control-label col-sm-4" for="email">URL:</i>
                <div class="col-sm-8">
                  <input type="url" class="form-control" id="url" placeholder="http://">
                </div>
             </div>
             
             <div class="form-group">
                <i class="control-label col-sm-4" for="email">Link Text:</i>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="linktext" placeholder="">
                </div>
             </div>
            
            <div class="pull-right">
                <button type="button" class="btn btn-default btn-xs" onclick="addcustumlink()">Add to Menu</button>
            </div>
            
        </div>
      </div>
    </div>
    
    <!-- custom links -->
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse4" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#" style="text-decoration: none;font-size: 13px;font-weight: bold;">Categories</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
        <div class="panel-body">
            
           <div style="overflow-y: scroll;height: 150px;border:1px solid #ddd;padding:10px;margin:8px;">
           
            
            <form class="form-inline" id="add-cat">
		    
              <?php $i=1; foreach($publishedCategories->result_array() as $key=>$val){?>
            <label class="ckbox" style="width:100%;">
            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chkcat"><span><?php echo $val['page_name']?></span><br>
			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
			</label>
			
			<?php $i++;}?>
			
            
       
            
            </div>
           
          
             
               <div class="pull-right">
                <button type="button" class="btn btn-default btn-xs" id="addCat">Add to Menu</button>
            </div>
          
           
           
            
        </div>
      </div>
    </div>
  </div> 


    </div>
    
   <div class="col-md-8">
       
       <div style="border:1px solid #ccc;">
           
        <div class="menu_st">
        
        <div class="col-md-8 form-horizontal">
            <!--<div class="form-group">-->
            <!--    <i class="control-label col-sm-4" for="email">Menu Name:</i>-->
            <!--    <div class="col-sm-8">-->
            <!--      <input type="text" class="form-control" id="menuName" placeholder="" value="<?php echo $menuName; ?>" readonly>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
        <div class="col-md-4">
            <div>
            <input type="button" class="btn btn-warning btn-sm" onclick="savebutton()" value="Save menu">
            <!--<button type="button" class="btn btn-warning btn-sm">Save Menu</button>-->
            </div>
        </div>
        
    </div>
    
    <div class="menu_pad">
        
    <div class="menu_titile">News Structure</div>
      <p style="font-size:12px;">Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.</p>
      
           
               
          <div class="dd nestable" id="nestable">
            <ol class="dd-list">
                
                <?php $i=1;  foreach($parentMenus[0] as $main_menu_id=>$val_array1){
                foreach($val_array1 as $page_id=>$main_menus_descarray){
                ?>
                <li class="dd-item" data-id="<?php echo $i; ?>" data-name="<?php echo $main_menus_descarray['page_name']; ?>" data-slug="<?php echo $page_id; ?>" data-new="0" data-deleted="0">
                   
                   
                    
                    
                    
                <div class="dd-handle"><?php echo $main_menus_descarray['page_name']; ?> <span class="pull-right menu_page"> <?php echo $main_menus_descarray['page'];?> </span> </div>
                <span class="button-delete btn btn-default btn-xs pull-right"
                      data-owner-id="<?php echo $i; ?>" title="Delete">
                  <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                </span>
                <span class="button-edit btn btn-default btn-xs pull-right"
                      data-owner-id="<?php echo $i; ?>" data-toggle="modal"  onclick="showMode(<?php echo $page_id; ?>)" title="Edit">
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </span>
                
                <!------- first child menus --->
                
                <?php if(count($subMenus[0][$main_menu_id]) > 0){$i++;?>
                
                <ol class="dd-list">
                  <!--- Item4 --->
                  <?php foreach($subMenus[0][$main_menu_id] as $submenuid=>$val_array2){
                  foreach($val_array2 as $sub_page_id=>$sub_menus_descarray){?>
                  <li class="dd-item" data-id="<?php echo $i; ?>" data-name="<?php echo $sub_menus_descarray['page_name']; ?>" data-slug="<?php echo $sub_page_id; ?>" data-new="0" data-deleted="0">
                    <div class="dd-handle"><?php echo $sub_menus_descarray['page_name']; ?> <span class="pull-right menu_page"><?php echo $sub_menus_descarray['page'];?></span> </div>
                    <span class="button-delete btn btn-default btn-xs pull-right"
                          data-owner-id="<?php echo $i; ?>" title="Delete">
                      <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </span>
                    <span class="button-edit btn btn-default btn-xs pull-right"
                          data-owner-id="<?php echo $i; ?>" data-toggle="modal" onclick="showMode(<?php echo $sub_page_id; ?>)" title="Edit">
                      <i class="fa fa-pencil" aria-hidden="true"></i>
                    </span>
                    
                    <!------- second child menus --->
                    
                    <?php if(count($subSubMenus[0][$main_menu_id][$submenuid]) > 0){$i++;?>
                    
                    <ol class="dd-list">
                          <!--- Item4 --->
                          
                          <?php foreach($subSubMenus[0][$main_menu_id][$submenuid] as $subsubmenuid=>$val_array3){
                                foreach($val_array3 as $sub_sub_page_id=>$sub_sub_menus_descarray){?>
                          <li class="dd-item" data-id="<?php echo $i; ?>" data-name="<?php echo $sub_sub_menus_descarray['page_name']; ?>" data-slug="<?php echo $sub_sub_page_id; ?>" data-new="0" data-deleted="0">
                            <div class="dd-handle"><?php echo $sub_sub_menus_descarray['page_name']; ?> <span class="pull-right menu_page"> <?php echo $sub_sub_menus_descarray['page'];?> </span> </div>
                            <span class="button-delete btn btn-default btn-xs pull-right"
                                  data-owner-id="<?php echo $i; ?>" title="Delete">
                              <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                            </span>
                            <span class="button-edit btn btn-default btn-xs pull-right"
                                  data-owner-id="<?php echo $i; ?>" data-toggle="modal" onclick="showMode(<?php echo $sub_sub_page_id; ?>)" title="Edit">
                              <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                          </li>
                          <?php $i++; }}?>
                  </ol>
                  
                  <?php $i++;}?>
                    
                    
                    <!--- second chile menus close-->
                    
                    
                    
                    
                  </li>
                  <?php  $i++;}}?>
                  
                  
                 </ol>
                 
                 <?php $i++;}?>
                 <!---first child close --->
                
                </li>
               
               <?php   $i++;}}?>
               
			</ol>
			
			

        
    </div>
    
    </div>
    
    <div class="menu_st">
        
       
        
        
            </div>
			
    </div>
    </div>
    
    
    <!----------- model--->
    
    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header mymodhead_bg">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Page</h5>
      </div>
      <div class="modal-body" style="padding-top: 15px !important;">
          
                    <div class="col-md-6">
                          <div class="form-group">
                            <i for="email">Navigation Label:</i>
                            <input type="hidden" id="page_id">
                            <input type="text" class="form-control" id="page_name">
                          </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                            <i for="email">Title Attribute:</i>
                            <input type="text" class="form-control" id="page_title">
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
    
    
    
    
    
    
    
    
    
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
	if(confirm('Do you really want to update menus'))
	{
	var aaa=$("#json-output").val();
	
	//alert(aaa);
	
	    
	    //var menu_type=$("#menuType").val();
	    menu_type='';
	
		$.post('AddNewsController/updatePages',{aaa:aaa},function(data)
		  {
			  //$("#arrformat").html(data);
			  alert('Menus updated');
			  location.reload();
	})
	}
	}
	
    function addcustumlink()
    {
        var menu_type=1;
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
        }
        
        if(is_valid_url(urlname))
        {
            
        
        $.post('AddNewsController/createCustomLink',{urlname:urlname,linktext:linktext,menu_type:menu_type},function(data)
        {
           if(data=='1')
           {
               location.reload();
           }
        });
        }
        else
        {
            alert('Enter a valid url');
            return false;
        }
    }
    
    function is_valid_url(url) {
    return /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url);;
}

function showMode(page_id)
{
   $.post('MapPageController/getPageInfo',{page_id:page_id},function(data)
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
        
     $.post('MapPageController/updatePageInfo',{page_id:page_id,page_name:page_name,page_title:page_title,is_targetblank:is_targetblank},function(data)
   {
      
      alert(data);
      
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
    
    
});
	</script>
  </body>
</html>
