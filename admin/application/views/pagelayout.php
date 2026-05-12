<?php ini_set('display_errors',0); ?>
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
  
    <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white"></div>
         <div class="card-body ">
    
   <div class="">
       
       <div style="">
           
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
            <input type="button" class="btn btn-warning btn-sm" onclick="savebutton()" value="Save Layout">
            <!--<button type="button" class="btn btn-warning btn-sm">Save Menu</button>-->
            </div>
        </div>
        
    </div>
    
    <div class="menu_pad">
       
    <div class="menu_titile">Page Layout Structure</div>
      <p style="font-size:12px;">Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.</p>
      
           
               
          <div class="dd nestable" id="nestable">
            <ol class="dd-list">
                
                <?php $i=1;  foreach($parentMenus[0] as $main_menu_id=>$val_array1){
                foreach($val_array1 as $page_id=>$main_menus_descarray){
                ?>
                <li class="dd-item" data-id="<?php echo $i; ?>" data-name="<?php echo $main_menus_descarray['page_name']; ?>" data-slug="<?php echo $page_id; ?>" data-new="0" data-deleted="0">
                  <div class="dd-handle dd-handle2"><?php echo $main_menus_descarray['page_name']; ?> <span class="pull-right menu_page"> <?php echo $main_menus_descarray['page'];?> </span> </div>
                </li>
               
               <?php   $i++;}}?>
               
			</ol>
			
			

        
    </div>
    
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
	    
	    
	    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
	if(confirm('Do you really want to update menus'))
	{
	var aaa=$("#json-output").val();
	
//	alert(aaa);
	
	    
	    //var menu_type=$("#menuType").val();
	    menu_type='';
	
		$.post('PageLayourController/updatePages',{aaa:aaa,'csrf_test_name': csrf_value},function(data)
		  {
			  //$("#arrformat").html(data);
			  alert('Layouts updated successfully');
			  location.reload();
	})
	}
	}
	
    function addcustumlink()
    {
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
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
            
        
        $.post('AddNewsController/createCustomLink',{urlname:urlname,linktext:linktext,menu_type:menu_type,'csrf_test_name': csrf_value},function(data)
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
    
    
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
   $.post('MapPageController/getPageInfo',{page_id:page_id,'csrf_test_name': csrf_value},function(data)
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
        
     $.post('MapPageController/updatePageInfo',{page_id:page_id,page_name:page_name,page_title:page_title,is_targetblank:is_targetblank,'csrf_test_name': csrf_value},function(data)
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
