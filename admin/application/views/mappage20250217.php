<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mapping page</title>
  
     <link href="<?php echo base_url()?>assets/css/fontawesome/css/all.css" rel="stylesheet">
    
    <link href="<?php echo base_url()?>assets/nestable/style.css" rel="stylesheet">
    
    
   
    
<style>
    .panel-body {
    padding: 15px !important;
}
   .addmenu{ 
    margin-right: 8px; margin-bottom: 5px;
   }
   #mceu_1{width:37px !important; position:absolute; left: 12px; bottom: 65px;     height: 30px;}
   
</style>


<script>
    function searchfun()
    {
        
        
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
        var keywordcustomlink=$("#keywordcustomlink").val();
        var customlink_val=$("#customlink_val").val();
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
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
        var keywordcategories=$("#keywordcategories").val();
        var categori_val=$("#categori_val").val();
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
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
            
            <!--<div style="display:inline-flex;margin-bottom: 15px;">-->
            <!--      <div class="mypagetitile">Menus</div>    -->
            <!--        <span id="createmenu" class="btn btn-primary btn-sm mg-b-10">Create new menu</span>-->
            <!--</div>-->
        
   
        <div id="newmenu" style="display:none;">
        <div style="background-color: #FFF;padding-top: 15px;padding-bottom: 48px;box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);margin-bottom: 5px; border-radius:5px;">
        <div class="col-md-6 col-md-offset-2 form-horizontal">
            <?php echo form_open('MapPageController/saveNewMenu')?>

            <div class="form-group">
                <label class="control-label col-sm-4" for="email">Menu Name:</label>
                <div class="col-sm-6" style="padding-left:0px;">
                  <input class="form-control " type="text" placeholder="Enter Menu Name" name="menuname">
                </div>
                <div class="col-sm-1" style="padding-left:0px;"> 
                <input type="submit" name="savemenu" value="Save" class="btn btn-success btn-sm" style="margin-top:2px;">
                </div>
            </div>

        </div>
            <?php echo form_close(); ?>
        </div>
        </div>
        
        <div class="clearfix"></div>
          
        
            
            
           <div style="background-color: #d9f8fd;padding-top: 15px;padding-bottom: 10px;box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3); border-radius:5px;">
           <div class="col-md-12   form-horizontal">
               <?php  echo form_open('map-pages'); ?>
               <div class="form-group">
                 <div class="row justify-content-center">
                    <div class="col-md-3" style="padding-left:0px;">
                         <label class="control-label" for="email">Menu type:</label>
                      <select  name="menuType" id="menuType" class="form-select">
                        <option value="">---select---</option>
                        <?php $string="";foreach($menu_types->result() as $key=>$val){ if($val->menu_type_id==$menu_type_selected){$string="selected"; $menuName=$val->menu_type_desc;}else{$string="";}?>
                        <option value="<?php echo $val->menu_type_id; ?>" <?php echo $string; ?>> <?php echo $val->menu_type_desc;?> </option>
                        <?php }?>
                    </select>
                    </div>
                    
                    <div class="col-sm-1" style="padding-left:0px;"> 
                    <input type="submit" name="select" value="Select" class="btn btn-primary btn-sm" style="margin-top:33px;"> 
                    </div>
                </div>
            </div>
            
             <?php echo form_close();?>
            
        </div>
        </div>
        
        <div class="clearfix"></div>
        
    
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
            
            
       <div class="row">  
            
         <div class="col-md-4" style="padding-left: 0px;">

        <div class=" " id="accordion">
            <div class="card" style="margin-bottom:15px;">
                <div class="card-header" data-toggle="collapse" data-parent=".d-accordion" href="#pages">
                  <a class="btn" data-bs-toggle="collapse" href="#collapseOne">  Pages   </a>
                </div>
                
                <div id="pages" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        
                      <div>
                         <form>
                          <div class="input-group">
                               <input type="hidden" id="page" value="0"/>
                             <input type="text" class="form-control" id="keyword" placeholder="Search" style="height:30px; border-radius:0px;" onkeyup="searchfun()">
                            <div class="input-group-btn">
                              <button class="btn btn-default" type="submit" style="height:30px;">
                                <i class="fa fa-search"></i>
                              </button>
                            </div>
                          </div>
                        </form>  
                           
                      </div>
                      
                      
                      <div style="overflow-y: scroll;height: 300px;border:1px solid #ddd;padding:10px;">
           
            
            <form class="form-inline" id="menu-add">
		    
              <?php $i=1; foreach($publishedPages->result_array() as $key=>$val){?>
            <label class="ckbox" style="width:100%;">
            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chk"><span><?php echo $val['page_name']?></span><br>
			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
			</label>
			
			<?php $i++;}?>
			
            
       
            
            </div>
            
             
            <div class="pull-right" style="margin-top:5px;">
               <!-- <button type="button" class="btn btn-default btn-sm">Add to Menu</button>-->
                <button class="btn btn-primary btn-sm addmenu" id="addButton" >Add to menu </button>
			
            </div>
            
          
              </form>
                      
                      
                      
                    </div>
                </div>
            </div>
            
            
            
            
            <div class="card" style="margin-bottom:15px;">
                <div class="card-header" data-toggle="collapse" data-parent=".d-accordion" href="#post">
                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">  Posts   </a>
                </div>
                <div id="post" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                    
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
                         
                         <div style="overflow-y: scroll;height: 150px;border:1px solid #ddd;padding:10px;">
           
            
                            <form class="form-inline" id="add-post">
                		    
                              <?php $i=1; foreach($publishedPosts->result_array() as $key=>$val){?>
                            <label class="ckbox" style="width:100%;">
                            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chkpost"><span><?php echo $val['page_name']?></span><br>
                			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
                			</label>
                			
                			<?php $i++;}?>
                			
                            
                       
                            
                            </div>
                            
                 
                            <div class="pull-right" style="margin-top:5px;">
                                <button type="button" class="btn btn-primary btn-sm addmenu" id="addPost">Add to Menu</button>
                            </div>
                            
                            <?php echo form_close(); ?>
                         
                     
                    </div>
                
                    
                </div>
            </div>
            
            
            
            
            <div class="card" style="margin-bottom:15px;">
                <div class="card-header" data-toggle="collapse" data-parent=".d-accordion" href="#customlinks">
                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">  Custom Links  </a>
                </div>
                
                <div id="customlinks" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body pt-0 pl-0 pr-0">
                        
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
                       
                       
                        <div style="overflow-y: scroll;height: 250px;border:1px solid #ddd;padding:10px;">
           
            
                            <form class="form-inline" id="add-customlinks">
                		    
                              <?php $i=1; foreach($publishedCustomlinks->result_array() as $key=>$val){?>
                            <label class="ckbox" style="width:100%;">
                            <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chkclinks"><span><?php echo $val['page_name']?></span><br>
                			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
                			</label>
                			
                			<?php $i++;}?>
                		
                            </div>
                            
                            <div class="clearfix"></div>
                            
                 
                               <div class="pull-right" style="margin-top:5px; margin-bottom:5px;">
                                <button type="button" class="btn btn-primary btn-sm addmenu" id="addCustomLink">Add to Menu</button>
                               </div>
                                <br>
                            
                            <?php echo form_close(); ?>
                       
                       
                       <div style="min-height: 150px;border:1px solid #ddd;padding:10px; margin-top: 15px;">
                           <div class="form-horizontal">
                             <div class="form-group">
                                <label class="control-label text-left col-sm-12" for="email">URL:</label>
                                <div class="col-sm-12">
                                  <input type="url" class="form-control" id="url" placeholder="http://">
                                </div>
                             </div>
                             
                             <div class="form-group">
                                <label class="control-label text-left col-sm-12" for="email">Link Text:</label>
                                <div class="col-sm-12">
                                  <input type="text" class="form-control" id="linktext" placeholder="">
                                </div>
                             </div>
                             
                             <div class="form-group">
                                <label class="control-label text-left col-sm-12" for="email">Title:</label>
                                <div class="col-sm-12">
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
                            
                             <div class="pull-right" style="margin-top: 22px;">
                                <div style="float:left">
                               <a class="btn btn-outline-secondary btn-sm" data-target="#myModal"  onclick="media('mapPages')" style="margin-top: -5px;"><i class="fa fa-image"></i> Add Media </a>
                                <button type="button" class="btn btn-primary btn-sm addmenu" onclick="addcustumlink()">Add to Menu</button>
                                </div>
                            </div>
             
             
              </div>
              
              
              
                       
                       
                       
                        
                    </div>
                </div>
                
                
            </div>
            
            
            
            <div class="card" >
                <div class="card-header" data-toggle="collapse" data-parent=".d-accordion" href="#categories">
                   <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo"> Categories </a>
                </div>
                
                <div id="categories" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        
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
                       
                       <div style="overflow-y: scroll;height: 250px;border:1px solid #ddd;padding:10px;">
           
            
                        <form class="form-inline" id="add-cat">
            		    
                          <?php $i=1; foreach($publishedCategories->result_array() as $key=>$val){?>
                        <label class="ckbox" style="width:100%;">
                        <input type="checkbox" id="addInputSlug<?php echo $val['page_id'];?>" value="<?php echo $val['page_id']; ?>" class="chkcat"><span><?php echo $val['page_name']?></span><br>
            			<input type="hidden" id="addInputName<?php echo $val['page_id'];?>" value="<?php echo $val['page_name']?>">
            			</label>
            			
            			<?php $i++;}?>
            			
                        
                   
                        
                        </div>
                       
                      
                         
                           <div class="pull-right" style="margin-top:5px;">
                            <button type="button" class="btn btn-primary btn-sm addmenu" id="addCat">Add to Menu</button>
                        </div>
                       
                        
                    </div>
                </div>
                
                
            </div>
            
            
            
            
            
            
            
            
        </div>




 


    </div>
    
   <div class="col-md-8" style="padding-right: 0px; padding-left: 0px;">
       
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
                <span class="button-delete btn btn-outline-secondary btn-sm pull-right"
                      data-owner-id="<?php echo $i; ?>" title="Delete">
                  <i class="fas fa-times-circle"></i>
                </span>
                <span class="button-edit btn btn-outline-secondary btn-sm pull-right"
                      data-owner-id="<?php echo $i; ?>" data-toggle="modal" data-bs-toggle="modal" data-bs-target="#myModalEdit"  onclick="showMode(<?php echo $page_id; ?>)" title="Edit">
                  <i class="fas fa-edit"></i>
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
                      <i class="fas fa-times-circle"></i>
                    </span>
                    <span class="button-edit btn btn-default btn-xs pull-right"
                          data-owner-id="<?php echo $i; ?>" data-toggle="modal" data-bs-toggle="modal" data-bs-target="#myModalEdit" onclick="showMode(<?php echo $sub_page_id; ?>)" title="Edit">
                      <i class="fas fa-edit"></i>
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
                              <i class="fas fa-times-circle"></i>
                            </span>
                            <span class="button-edit btn btn-default btn-xs pull-right"
                                  data-owner-id="<?php echo $i; ?>" data-toggle="modal" data-bs-toggle="modal" data-bs-target="#myModalEdit" onclick="showMode(<?php echo $sub_sub_page_id; ?>)" title="Edit">
                              <i class="fas fa-edit"></i>
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
   
 </div>
        
        
    
   
   
    
    
    <!----------- model--->
    
    <div id="myModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header mymodhead_bg">
        <h5 class="modal-title">Navitation Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding-top: 15px !important; padding-right: 15px !important;">
          
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
    
    
    
    
    
    
     <script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script> 
    
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
	if(confirm('Do you really want to update menus'))
	{
	var aaa=$("#json-output").val();
	
	var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
	
	    
	    var menu_type=$("#menuType").val();
	
		$.post('MapPageController/updatePages',{aaa:aaa,menu_type:menu_type,'csrf_test_name': csrf_value},function(data)
		  {
			  //$("#arrformat").html(data);
			  console.log(data);
			  alert('Menus updated');
			  window.location='map-pages';
			  
	})
	}
	}
	
    function addcustumlink()
    {
        
        var menu_type=$("#menuType").val();
        var urlname=$("#url").val();
        var linktext=$("#linktext").val();
        var is_targetblank=1;
        var is_alert=0;
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        
        
        
        
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
           //alert(data);
               location.reload();
               
           
        });
        
       
    }
    
    

function showMode(page_id)
{
//alert(page_id);    
   var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
   $.get('<?php echo base_url(); ?>MapPageController/getPageInfo',{page_id:page_id,'csrf_test_name': csrf_value},function(data)
   {
       //alert(data);
      //console.log(data);
      //return;
      var obj = JSON.parse(data);
      //alert(obj.page_name);console.log(obj);
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
      //alert(obj.hover_title);
      $("#myModalEdit").modal();
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
      window.location='map-pages';
      
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
