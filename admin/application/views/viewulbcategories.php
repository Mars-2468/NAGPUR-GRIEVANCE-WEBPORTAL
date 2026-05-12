<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>


<link href="<?php echo base_url() ?>assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<script src="<?php echo base_url() ?>assets/lib/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/lib/datatables-responsive/dataTables.responsive.js"></script>


<head>
	
	<style>
	
	table tr:nth-child(odd) {
 background-color: #FFF;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}
	
	
	
	
	.dataTables_filter input{
	    margin-right: 64px;
    font-size: 13px;
    width: 98%;
	}

	.table-bordered {
  border: 1px #c3c3c3 solid !important;
}
	
	/*.mytable tr td{
	    
	     border-bottom: 1px #e5e5e5 solid !important;
	    
	}*/

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
            
        <div style="display:inline-flex;">
          <div class="mypagetitile">User Categories</div>    
            <a href="<?php echo base_url(); ?>user-categories" class="btn btn-default btn-sm mg-b-10">Add New</a>
           </div>


            <?php 
             

echo form_open('HomesliderController/updateContent',$attributes); ?>
<br>

	
	
<!--	<center><input class="btn btn-success" type="submit" name="Update" value="Update content"></center>	-->


<!--<div style="margin-bottom:10px;"> Users  InActive (<?php //foreach($count_Inactive->result() as $key=>$val){  echo $val->count;  } ?>) | Users in Active (<?php //foreach($count_active->result() as $key=>$val){  echo $val->count;  } ?>) </div>-->



  <div class="mytable table-responsive">
              <table id="datatable1" class="table table-hover table-bordered table-defulat mg-b-0">
                <thead>
                  <tr class="info">
                    <th>
                      <label class="ckbox mg-b-0">
                        <input type="checkbox"><span></span>
                      </label>
                    </th>
                     <th>Category Name</th>
                     <th>Author</th>
                     <th>Last Updated</th>
                  </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1;foreach($users_data->result() as $key=>$val){
                    //$class="mygreen";
                    if($val->flag=='0')
                    {
                        $status=1;
                        $status_string="InActive";
                        $curStatus='Active';
                        $class="mygreen";
                    }
                    else
                    {
                       $status=0;
                        $status_string="Active";
                        $curStatus='InActive';
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
                      <div style="font-size:13px;"> <strong><?php echo $val->user_category_name; ?> <span class="<?php //echo $class; ?>"><?php //echo $curStatus; ?></span></strong> </div>
                      <div><a href="<?php echo base_url(); ?>UserViewCategoryController/editulbuser_category/<?php echo $val->id; ?>"/>Edit</a> | <a class="modify_option1" class="modify_option1" onclick="delete_rec('<?php echo $val->id; ?>')"> Delete </a>  <a class="modify_option" > <?php //echo $status_string; ?> </a>
                        </div>
                  </td>
                  <td><?php echo $val->author;?></td>
                  <td> 
                  <div>Last Modified</div>
                        <div class="modify_date"><?php echo date('jS F, Y, H:i:s', strtotime($val->ts)); ?></div>
                        </td>
                  </tr>
                    
                     <?php $i++; } ?>
                    
                    
                 
                </tbody>
              </table>
    </div> 
                   


            
            
</div>

	
<?php echo form_close();  ?>


        </div>
</div>





          
            
              
              












<script type="text/javascript">


    
    function fun1()
    {
        
        
        $('#myModal').modal('show');
    }
    
    
    
    function update_status(user_id,status)
    {
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        
         if(confirm('Are sure you want to change the status of this page'))
        {
            $.post('ViewUlbUserController/updateStatus',{user_id:user_id,status:status,'csrf_test_name': csrf_value},function(data)
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
    function delete_rec(user_id)
    {
      var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        if(confirm('Are sure you want to delete this record'))
        {
            $.post('UserViewCategoryController/deleteContent',{user_id:user_id,'csrf_test_name': csrf_value},function(data)
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



