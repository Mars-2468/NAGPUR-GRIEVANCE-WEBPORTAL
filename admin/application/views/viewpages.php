<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>


 

<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>


 


<head>
	
	<style>

	.table-bordered {
  border: 1px #c3c3c3 solid !important;
}
	
 

	    .dropzone {
        
       min-height: 200px;
padding: 60px 20px 0px 20px;
text-align: center;
border: dashed 3px #C1C3C5;

    }
    
    
    .dropzone::before{
        position: absolute;
top: 36%;
left: 50%;
margin-left: -25px;
content: "";
width: 51px;
height: 33px;
/*background-image: url("http://municipalservices.in/sites/admin/assets/img/icn-upload.png");*/
background-size: 100%;
    }
    
    
    
    .modal-header{
        
    }
    
    label{
        font-weight:normal !important;
    }
    
   .table-hover .table-primary:hover {
     background-color: #a5c7ea !important;
    }
    
    
    .modify_option1 {
    text-decoration: none !important;
    cursor: pointer;
    font-size: 13px;
    color: #900c3f !important;
}

.modify_option1:hover {
    text-decoration: none !important;
    cursor: pointer;
    font-size: 13px;
    color: red !important;
}

.form-control, .dataTables_filter input{
    font-size:13px;
    margin-right:5px!important;
}
.dataTables_wrapper .dataTables_filter input{
    margin:0px;
}
    
	</style>

</head>

<body>
   

<div class="sh-pagebody">
    
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success text-center"> 
    <?php echo $this->session->flashdata('message');?>
    </div>
    <?php } ?>




<div class="card bd-primary ">
         <div class="card-header bg-primary tx-white"></div>
         <div class="card-body pd-sm-10">
       <?php if($this->session->userdata('user_id')==='superadmin') { ?>     
             <div style="display:inline-flex;">
          <div class="mypagetitile">Pages</div>    
            <a href="<?php echo base_url(); ?>create-page" class="btn btn-primary btn-sm mg-b-10">Add New</a>
           </div>
	   <?php } ?>

            <?php 
              if(count($custom_menus) > 0)
              {
$attributes=array('method'=>'POST');

echo form_open('HomesliderController/updateContent',$attributes); ?>
<br>

<!--<table class="table table-bordered">
	    <thead>
	        <tr>
	            <th>sno</th>
	            <th>Page Name***</th>
	            <th> Update </th>
	            <th> Publish </th>
	            <th> Draft </th>
	            <th>Delete</th> 
	        </tr>
	    </thead>
	    <tbody>
	        <?php print_r($custom_menus);$i=1;foreach($custom_menus as $key=>$val){?>
	        
	        <tr>
	           <td><?php echo $i; ?></td>
	           <td><?php echo $val['page_name']; ?></td>
	           <td><a href="<?php echo $val['controller']?>">Update</a></td>
	        </tr>
	        
	        <?php $i++;}?>
	    </tbody>
	   
	</table>-->
	
	
<!--	<center><input class="btn btn-success" type="submit" name="Update" value="Update content"></center>	-->

<?php if($this->session->userdata('user_id')==='superadmin') { ?>
<div style="margin-bottom:10px;"> Pages in Draft(<?php foreach($count_draft_page->result() as $key=>$val){  echo $val->count;  } ?>) | pages in Publish (<?php foreach($count_publish_page->result() as $key=>$val){  echo $val->count;  } ?>) </div>
<?php } ?>


  <div class="mytable">
              <table id="datatable1" class="table table-hover table-bordered table-striped mg-b-0">
                <thead>
                  <tr>
                    <th>
                      <label class="ckbox mg-b-0">
                        <input type="checkbox"><span></span>
                      </label>
                    </th>
                    <th>PageNo</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                    <?php $i=1;foreach($custom_menus as $key=>$val){
                        
                    
                    if($val['is_draft']=='0')
                    {
                        $status=1;
                        $status_string="Draft";
                        $curStatus='Published';
                        $class="mygreen";
                    }
                    else
                    {
                        $status=0;
                        $status_string="Published";
                        $curStatus='Draft';
                        $class="myred";
                    }
                    ?>
                    
                    
                    <tr>
                    <td>
                      <label class="ckbox mg-b-0">
                        <input type="checkbox"><span></span>
                      </label>
                    </td>
                    <td>
                        <div style="font-size:13px;"> <strong><?php echo $key; ?>  </strong> </div>
                     </td>
                     <td>
                        <div style="font-size:13px;"> <strong><?php echo $val['page_name']; ?>  - <span class="<?php echo $class; ?>"><?php echo $curStatus; ?></span></strong> </div>
                        <div> <a class="modify_option" href="<?php echo $val['controller']?>"> Edit - <?php echo $val['controller']?></a> | <a class="modify_option1" class="modify_option1" onclick="delete_rec(<?php echo $key; ?>)"> Delete </a> | <a class="modify_option" onclick="update_status('<?php echo $key; ?>','<?php echo $status; ?>')"> <?php echo $status_string; ?> </a> 
                        </div>
                        <div style="margin-top:8px; width: 500px; word-wrap: break-word;">Permanent Link: 
                        <span class="permlinks"><a href="<?php echo $ulb_base_url[$val['ulbid']]['base_url'];?><?php echo $val['site_controller']?>" target="_blank"><?php echo $ulb_base_url[$val['ulbid']]['base_url'];?><?php echo $val['site_controller']?></a></span> </div>
                    </td>
                    <td><?php echo $val['author']?></td>
                    <td>
                        <div>Last Modified</div>
                        <div class="modify_date"><?php echo date('jS F, Y, H:i:s', strtotime($val['ts'])); ?></div>
                    </td>
                  </tr>
                    
                     <?php $i++;}?>
                    
                    
                 
                </tbody>
              </table>
            </div> 
                   


            
            
</div>

	
<?php echo form_close(); }?>


        </div>
</div>





          
            
              
              












<script type="text/javascript">


    
    function fun1()
    {
        
        
        $('#myModal').modal('show');
    }
    
    function delete_rec(page_id)
    {
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
       
        if(confirm('Are sure you want to delete this record'))
        {
            $.post('ViewPageController/deleteContent',{page_id:page_id,'csrf_test_name': csrf_value},function(data)
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
    
    function update_status(page_id,status)
    {
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
         if(confirm('Are sure you want to change the status of this page'))
        {
            $.post('ViewPageController/updateStatus',{page_id:page_id,status:status,'csrf_test_name': csrf_value},function(data)
            {
                if(data=='1')
                {
                    alert('Status changed successfully');
                    location.reload();
                }
                else
                {
                    alert('Unable change the status');
                }
            });
        }
    }

</script>



<script>
      $(function() {
      'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      }); 
    </script>



