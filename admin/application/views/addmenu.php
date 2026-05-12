<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',1);
?>

<head>

<link href="<?php echo base_url()?>assets/css/fontawesome/css/all.css" rel="stylesheet">

<style>
    
	.mytable tr td{
	    
	     border-bottom: 1px #e5e5e5 solid !important;
	    
	}
    
</style>
<script>
   /*  function delete_rec(album_id)
    {
        if(confirm('Are sure you want to delete this record'))
        {
            $.post('CreateAlbumController/deleteContent',{album_id:album_id},function(data)
            {
                if(data=='1')
                {
                    alert('Successfully deleted');
                    location.reload();
                }
                else
                {
                    alert('Unable deleted');
                }
            });
        }
    }*/
</script>



  </head>

<body>
   

<div class="sh-pagebody">
    
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success text-center"> 
    <?php echo $this->session->flashdata('message');?>
    </div>
    <?php } ?>


<div class="card bd-primary mg-t-20">
          <div class="card-header bg-primary tx-white">Add Menu</div>
          <div class="card-body pd-sm-30">
              
              <?php $attributes=array('id'=>'myform');echo form_open('add-menu',$attributes);?>
              <label for="menu-type">Select Menu type:</label>
              <select name="menu_type_id" required style="height:37px;">
                  <option value="">--- select---</option>
                  <?php foreach($menudata->result() as $key=>$val){ ?>
                  
                  <option value="<?php echo $val->menu_type_id;?>"><?php echo $val->menu_type_desc;?></option>
                  
                  <?php } ?>
              </select>
              
              
              <label for="menudesc">Menu name : </label>
              <input type="text" maxlength="20" name="menu_desc" id="menu_desc" required>
              
              <input type="submit" name="save" value="save">
              <?php echo form_close(); ?>
              
              
              
              <br>
              
             
  <div class="mytable table-responsive">
              <table class="table table-hover table-bordered table-defulat mg-b-0">
                <thead>
                  <tr>
                    <th>
                      <label class="ckbox mg-b-0">
                        <input type="checkbox"><span></span>
                      </label>
                    </th>
                    <th>Menu Type</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                    
                    <?php foreach($sitemenudata->result() as $key=>$val){?>
                    
                    <tr>
                    <td>
                      <label class="ckbox mg-b-0">
                        <input type="checkbox"><span></span>
                      </label>
                    </td>
                    <td><?php echo $val->menu_type_desc; ?></td>
                    <td>
                        <div> <strong><?php echo $val->menu_name; ?></strong> </div>
                        <div> 
                        
                        <?php echo form_open('update-site-menu')?>
                        <input type="hidden" name="menuid" value="<?php echo $val->menu_id; ?>">
                       <input type="submit" name="update" value="Edit" class="sitelink">
                        <!--
                        <a class="modify_option" href="AddMenuController/editsitemenu"> Edit </a>
                        <?php echo form_close();?>
                        -->
                        
                        
                         | <a class="modify_option1" href="" onclick="delete_rec(<?php echo $val->menu_id; ?>)"> Delete </a>  </div>
                    </td>
                    <td><?php echo $val->author; ?></td>
                    <td>
                        <div>Last Modified</div>
                        <div class="modify_date"> <?php echo $val->ts; ?> </div>
                    </td>
                  </tr>
                    
                    <?php }?>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                 
                </tbody>
              </table>
            </div> 
              
              	
              	
              	
             
</div>










              
            </div>  
            <br>
            
            
            
           

	


              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              
              
             

<script type="text/javascript">

    
    function delete_rec(menu_id)
    {
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        if(confirm('Are sure you want to delete this record'))
        {
            $.post('AddMenuController/deleteMenu',{menu_id:menu_id,'csrf_test_name': csrf_value},function(data)
            {
                if(data=='1')
                {
                    alert('Successfully deleted');
                    location.reload();
                }
                else
                {
                    alert('Unable deleted');
                }
            });
        }
    }
    
   

</script>
