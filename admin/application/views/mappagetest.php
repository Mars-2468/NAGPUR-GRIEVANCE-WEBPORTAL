<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mapping page</title>

    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="<?php echo base_url()?>assets/nestable/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->


<style>
    .panel-body {
    padding: 3px !important;
}
   .addmenu{ 
    margin-right: 8px; margin-bottom: 5px;
   }
   #mceu_1{width:37px !important; position:absolute; left: 12px; bottom: 65px;     height: 30px;}
   
</style>

<script>
    function searchfun(){
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var keyword=$("#keyword").val();
        var page_val=$("#page").val();
        //alert(page_val);
       
            $.ajax({
                    type:'POST',
                    url:'<?php echo base_url(); ?>MapPageTestController/ajax_pages_search',
                    data:'keyword='+keyword + '&page_val=' + page_val + '&csrf_test_name=' + csrf_value,
                    success:function(html){
                        //alert(html);
                        $('#menu-add').html(html);
                        
                    }
            
        });
        
    }
    </script>
    
    <script>
    function searchpostfun(){
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var keywordpost=$("#keywordpost").val();
        var post_val=$("#post_val").val();
        //alert(post_val);
            $.ajax({
                    type:'POST',
                    url:'<?php echo base_url(); ?>MapPageTestController/ajax_pages_search',
                    data:'keywordpost='+keywordpost + '&post_val=' + post_val + '&csrf_test_name=' + csrf_value,
                    success:function(html){
                        //alert(html);
                        $('#add-post').html(html);
                        
                    }
            
        });
        
    }
    </script>
    
    <script>
     function searchcustomlinksfun(){
         
         
         var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var keywordcustomlink=$("#keywordcustomlink").val();
        var customlink_val=$("#customlink_val").val();
        //alert(customlink_val);
            $.ajax({
                    type:'POST',
                    url:'<?php echo base_url(); ?>MapPageTestController/ajax_pages_search',
                    data:'keywordcustomlink='+keywordcustomlink + '&customlink_val=' + customlink_val + '&csrf_test_name=' + csrf_value,
                    success:function(html){
                        //alert(html);
                        $('#add-customlinks').html(html);
                        
                    }
            
        });
        
    }
    </script>
    
    <script>
    function searchcategoriesfun(){
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var keywordcategories=$("#keywordcategories").val();
        var categori_val=$("#categori_val").val();
       //alert(categori_val);
            $.ajax({
                    type:'POST',
                    url:'<?php echo base_url(); ?>MapPageTestController/ajax_pages_search',
                    data:'keywordcategories='+keywordcategories + '&categori_val=' + categori_val + '&csrf_test_name=' + csrf_value,
                    success:function(html){
                        //alert(html);
                        $('#add-cat').html(html);
                        
                    }
            
        });
        
    }
</script>

  </head>
  <body>
    <div class="sh-pagebody">
        
  <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white"></div>
         <div class="card-body pd-sm-10">      

            <div>
            <?php echo $this->session->flashdata('message');?>
           </div>

            
            
            <div style="display:inline-flex;">
          <div class="mypagetitile">Menus</div>    
            <span id="createmenu" class="btn btn-default btn-sm mg-b-10">Create new menu</span>
        </div>
        
        <hr>
        <div id="newmenu" style="display:none;">
            <?php echo form_open('MapPageController/saveNewMenu')?>
            
        <div class="row form-horizontal">
            <label class="col-md-1 control-label" style="padding:0px;">Menu Name</label>
          <div class="col-md-2">  <input class="form-control " type="text" placeholder="Enter Menu Name" name="menuname"> </div>
           <div class="col-md-1"> <input type="submit" name="savemenu" value="save" class="btn btn-default btn-sm"></div>
           
        </div>
            <?php echo form_close(); ?>
            <hr>
        </div>
            
            
            
           <div class="row">
            
            <div class="col-md-12">
                <div class="">
                <?php  echo form_open('map-pages'); ?>
               Menu type
                <select class="" name="menuType" id="menuType">
                    <option value="">---select---</option>
                    <?php $string="";foreach($menu_types->result() as $key=>$val){ if($val->menu_type_id==$menu_type_selected){$string="selected"; $menuName=$val->menu_type_desc;}else{$string="";}?>
                    <option value="<?php echo $val->menu_type_id; ?>" <?php echo $string; ?>> <?php echo $val->menu_type_desc;?> </option>
                    <?php }?>
                </select>
                
               <input type="submit" name="select" value="select" class="btn btn-default btn-xs"> 
                
                <?php echo form_close();?>
            </div>
            
            </div>
            
        </div>
        
    
<br>


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
            
            
            
            
         <div class="col-md-4" style="padding-left: 0px;">

  <div class="panel-group  d-accordion" >
    <div class="panel panel-default">
      <!--<div class="panel-heading">-->
      <!--  <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand">-->
      <!--     <div class="right-arrow pull-right">+</div>-->
      <!--    <a href="#" style="text-decoration: none;font-size: 13px;font-weight: bold;">Pages</a>-->
      <!--  </h4>-->
      <!--</div>-->
      
      <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#publish">
                <h4 class="panel-title">Pages <i class="fa fa-chevron-up pull-right"></i></h4>
      </div>
      
      
      <div id="publish" class="panel-collapse collapse in">
        <div class="panel-body">
            
            <div>
                
             <form>
  <div class="input-group">
      <input type="hidden" id="page" value="0"/>
    <input type="text" class="form-control" id="keyword" placeholder="Search" style="height:30px; border-radius:0px;" onkeyup="searchfun()">
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
            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chk"><span><?php echo $val['page_name']?></span><br>
			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
			</label>
			
			<?php $i++;}?>
			
            
       
            
            </div>
            
            
            <div class="pull-right">
               <!-- <button type="button" class="btn btn-default btn-sm">Add to Menu</button>-->
                <button class="btn btn-default btn-xs addmenu" id="addButton" >Add to menu </button>
			
            </div>
          
              </form>
              
        </div>
      </div>
    </div>
    
    <!---- posts --->
    <div class="panel panel-default">
      
      <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#posts">
                <h4 class="panel-title">Posts <i class="fa fa-chevron-up pull-right"></i></h4>
      </div>
      
      
      <div id="posts" class="panel-collapse collapse">
        <div class="panel-body">
           
          <div>
                
             <form>
  <div class="input-group">
       <input type="hidden" id="post_val" value="2"/>
    <input type="text" class="form-control" id="keywordpost" placeholder="Search" style="height:30px; border-radius:0px;" onkeyup="searchpostfun()">
    <div class="input-group-btn">
      <button class="btn btn-default" type="button" style="height:30px;">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </div>
</form>  
               
           </div>
           
           <div style="overflow-y: scroll;height: 150px;border:1px solid #ddd;padding:10px;margin:8px;">
           
            
            <form class="form-inline" id="add-post">
		    
              <?php $i=1; foreach($publishedPosts->result_array() as $key=>$val) { ?>
            <label class="ckbox" style="width:100%;">
            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chkpost"><span><?php echo $val['page_name']?></span><br>
			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
			</label>
			
			<?php $i++; } ?>
			
            
        </div>
            
 
               <div class="pull-right">
                <button type="button" class="btn btn-default btn-xs addmenu" id="addPost">Add to Menu</button>
            </div>
            
            <?php echo form_close(); ?>
           
           
        </div>
      </div>
    </div>
    
    <!-- close --->
    
    <!-- custom links --->
    
    
    <div class="panel panel-default">
      <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#custom">
                <h4 class="panel-title">Custom Links <i class="fa fa-chevron-up pull-right"></i></h4>
              </div>
      
      <div id="custom" class="panel-collapse collapse">
           
        <div class="panel-body form-horizontal">
            
            <div>
                
             <form>
  <div class="input-group">
      <input type="hidden" id="customlink_val" value="1"/>
    <input type="text" class="form-control" id="keywordcustomlink" placeholder="Search" style="height:30px; border-radius:0px;" onkeyup="searchcustomlinksfun()">
    <div class="input-group-btn">
      <button class="btn btn-default" type="button" style="height:30px;">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </div>
</form>  
               
           </div>
            
            
            <div style="overflow-y: scroll;height: 150px;border:1px solid #ddd;padding:10px;margin:8px;">
           
            
            <form class="form-inline" id="add-customlinks">
		    
              <?php $i=1; foreach($publishedCustomlinks->result_array() as $key=>$val){?>
            <label class="ckbox" style="width:100%;">
            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chkclinks"><span><?php echo $val['page_name']?></span><br>
			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
			</label>
			
			<?php $i++;}?>
		
            </div>
            <div class="clearfix"></div>
            
 
               <div class="pull-right">
                <button type="button" class="btn btn-default btn-xs addmenu" id="addCustomLink">Add to Menu</button>
                </div>
                <br>
            
            <?php echo form_close(); ?>
            
            
            
            
            <div style="min-height: 150px;border:1px solid #ddd;padding:10px;margin:8px;">
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
             
             <div class="form-group">
                <i class="control-label col-sm-4" for="email">Title:</i>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="linktitle" placeholder="Title">
                </div>
             </div>
             
             <div class="form-group">
              
                <div class="col-sm-12">
                         
                         <label class="ckbox" style="width:100%;">
                                <input type="checkbox" id="target" value="2" ><span>Open in new window / tab </span><br>
                                
                        </label>
                </div>
             </div>
             
             <div class="form-group">
                
                <div class="col-sm-12">
                         <label class="ckbox" style="width:100%;">
                                <input type="checkbox" id="is_alert" value="1" ><span> Alert for Open link in a new window / Tab </span><br>
                                
                        </label>
                </div>
             </div>
             
         
             
             
              </div>
             
            
            <div class="pull-right">
                <div style="float:left">
                <?php $this->load->view('filemanager.php');?>
                <button type="button" class="btn btn-default btn-xs addmenu" onclick="addcustumlink()">Add to Menu</button>
                </div>
            </div>
            
        </div>
      </div>
     
    </div>
    
    <!-- custom links -->
    
    <div class="panel panel-default">
      
      
      <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion" href="#categories">
                <h4 class="panel-title">Categories <i class="fa fa-chevron-up pull-right"></i></h4>
      </div>
      
      <div id="categories" class="panel-collapse collapse">
        <div class="panel-body">
            
            <div>
                
             <form>
  <div class="input-group">
      <input type="hidden" id="categori_val" value="3"/>
    <input type="text" class="form-control" id="keywordcategories" placeholder="Search" style="height:30px; border-radius:0px;" onkeyup="searchcategoriesfun()">
    <div class="input-group-btn">
      <button class="btn btn-default" type="button" style="height:30px;">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </div>
</form>  
               
           </div>
            
            
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
                <button type="button" class="btn btn-default btn-xs addmenu" id="addCat">Add to Menu</button>
            </div>
          
           
           
            
        </div>
      </div>
    </div>
  </div> 


    </div>
    
   <div class="col-md-8" style="padding-right: 0px;     padding-left: 0px;">
       
       <div style="border:1px solid #ccc;">
           
        <div class="menu_st">
        
        <div class="col-md-8 form-horizontal">
            <div class="form-group">
                <i class="control-label col-sm-4" for="email">Menu Name:</i>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="menuName" placeholder="" value="<?php echo $menuName; ?>" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div>
            <input type="button" class="btn btn-warning btn-sm" onclick="savebutton()" value="Save menu">
            <!--<button type="button" class="btn btn-warning btn-sm">Save Menu</button>-->
            </div>
        </div>
        
    </div>
    
    <div class="menu_pad">
        
    <div class="menu_titile">Menu Structure</div>
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
        
       
        <input type="button" class="btn btn-warning btn-sm pull-right" onclick="savebutton()" value="Save menu">
        
            </div>
			
    </div>
    </div>    
            
            
            
            
            
            
            
            
            
            
            
            
        
        
        
         </div>
   
 </div>
        
        
    
    <!--start-->
  
   
    
    
    <!----------- model--->
    
    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header mymodhead_bg">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Navitation Details</h5>
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
                   
                   <div class="col-md-12">
                       <div class="form-group">
                            <i for="email">Url</i>
                            <input type="text" class="form-control" id="page_url" placeholder="Paste url here">
                          </div>
                   </div>
                   
                   <div class="col-md-12">
                       <div class="form-group">
                            <i for="email">Title</i>
                            <input type="text" class="form-control" id="hover_title" placeholder="Title">
                          </div>
                   </div>
                   
                   
                   <div class="clearfix"></div>
                   
                   <div style="padding-left: 16px; font-size:13px;">
                   <label class="">
                    <input type="checkbox" id="target_update" value="2"><span>Open link in a new window / Tab</span>
                   </label>
                   </div>
                   
                    <div style="padding-left: 16px; font-size:13px;">
                   <label class="">
                    <input type="checkbox" id="is_alert_update" value="1"><span>Alert for Open link in a new window / Tab</span>
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
        maxDepth: 3
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
	
	
	
	    
	    var menu_type=$("#menuType").val();
	
		$.post('MapPageController/updatePages',{aaa:aaa,menu_type:menu_type,'csrf_test_name': csrf_value},function(data)
		  {
			  //$("#arrformat").html(data);
			  console.log(data);
			  alert('Menus updated');
			  location.reload();
			  
	})
	}
	}
	
    function addcustumlink()
    {
       
       
       var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>'; 
        var menu_type=$("#menuType").val();
        var urlname=$("#url").val();
        var linktext=$("#linktext").val();
        var is_targetblank=1;
        var is_alert=0;
        
        
        
        
        
        
        if(linktext=='')
        {
            alert('Enter linktext');
            return false;
        }
        
        if($("#target").is(":checked"))
        {
            is_targetblank=2;
            
        }
        
        if($("#is_alert").is(":checked"))
        {
            is_alert=1;
           
        }
        
        
        
            
        
        $.post('MapPageController/createCustomLink',{urlname:urlname,linktext:linktext,menu_type:menu_type,is_alert:is_alert,is_targetblank:is_targetblank,'csrf_test_name': csrf_value},function(data)
        {
           alert(data);
               location.reload();
               
           
        });
        
       
    }
    
    

function showMode(page_id)
{
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    
   $.post('MapPageController/getPageInfo',{page_id:page_id,'csrf_test_name': csrf_value},function(data)
   {
      var obj = JSON.parse(data);
      $("#page_id").val(page_id);
      $("#page_name").val(obj.page_name);
      $("#page_title").val(obj.page_title);
      $("#page_url").val(obj.site_controller);
      $("#hover_title").val(obj.hover_title);
      
      
      
      if(obj.is_target_blank=='2')
      {
          
          $('#target_update').prop('checked',true);
      }
      else
      {
          $('#target_update').removeProp('checked');
      }
      
      if(obj.is_alert=='1')
      {
         
          $('#is_alert_update').prop('checked',true);
      }
      else
      {
          $('#is_alert_update').removeProp('checked');
      }
      
      $("#myModal").modal();
   });
   
   
    
}

function updatePage()
{
   var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    var page_id=$("#page_id").val();
    var page_name=$("#page_name").val();
    var page_title=$("#page_title").val();
    var page_url=$("#page_url").val();
    var hover_title=$("#hover_title").val();
    var is_targetblank=1;
    var is_alert=0;
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
    
     if($("#target_update").is(":checked"))
        {
            
            is_targetblank=2;
        }
        
        if($("#is_alert_update").is(":checked"))
        {
            
            is_alert=1;
        }
        
     $.post('MapPageController/updatePageInfo',{page_id:page_id,page_name:page_name,page_title:page_title,is_targetblank:is_targetblank,is_alert:is_alert,page_url:page_url,hover_title:hover_title,'csrf_test_name': csrf_value},function(data)
   {
      
      alert('Updated successfully');
      location.reload();
      
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
    
     $("#addCustomLink").click(function(e)
    {
        e.preventDefault();
        addToLink();
    });
    
    $("#createmenu").click(function()
    {
        $("#newmenu").toggle();
    });
    
    
});
	</script>
  </body>
</html>
