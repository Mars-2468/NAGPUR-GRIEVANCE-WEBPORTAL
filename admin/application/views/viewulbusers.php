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
          <div class="mypagetitile">Users</div>    
            <a href="<?php echo base_url(); ?>site-admin-creat-user" class="btn btn-default btn-sm mg-b-10">Add New</a>
           </div>


            <?php 
             

echo form_open('HomesliderController/updateContent',$attributes); ?>
<br>

	
	
<!--	<center><input class="btn btn-success" type="submit" name="Update" value="Update content"></center>	-->


<div style="margin-bottom:10px;"> Users  InActive (<?php foreach($count_Inactive->result() as $key=>$val){  echo $val->count;  } ?>) | Users in Active (<?php foreach($count_active->result() as $key=>$val){  echo $val->count;  } ?>) </div>



  <div class="mytable table-responsive">
              <table id="datatable1" class="table table-hover table-bordered table-defulat mg-b-0">
                <thead>
                  <tr class="info">
                    <th>
                      <label class="ckbox mg-b-0">
                        <input type="checkbox"><span></span>
                      </label>
                    </th>
                     <th>Name</th>
                     <th>Author</th>
                     <th>Last Updated</th>
                     <th>Last Login</th>
                     <th>IP Address</th>
                  </tr>
                </thead>
                <tbody>
                    
                                     <?php
                                       
                                       if(count($results) > 0) 
                                       {
                                       $i = $this->uri->segment(2)+0;
                                       foreach ($results as $data)
                                       {
                                       $i++; 
                                       if($data->flag=='0')
                                            {
                                                $status=1;
                                                $status_string="Deactivated";
                                                $curStatus='Activated';
                                                $class="mygreen";
                                            }
                                            else
                                            {
                                                $status=0;
                                                $status_string="Activated";
                                                $curStatus='Deactivated';
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
                      <div style="font-size:13px;"> <strong><?php echo $data->user_name; ?> -<span class="<?php echo $class; ?>"><?php echo $curStatus; ?></span></strong> </div>
                      <div><a href="<?php echo base_url(); ?>ViewUlbUserController/editulbuser/<?php echo $data->user_id; ?>"/>Edit</a> | <a class="modify_option1" class="modify_option1" onclick="delete_rec('<?php echo $data->user_id; ?>')"> Delete </a> | <a class="modify_option" onclick="update_status('<?php echo $data->user_id; ?>','<?php echo $status; ?>')"> <?php echo $status_string; ?> </a>
                        </div>
                  </td>
                  <td><?php echo $data->author;?></td>
                  <td> 
                  <div>Last Modified</div>
                        <div class="modify_date"><?php echo date('jS F, Y, H:i:s', strtotime($data->ts)); ?></div>
                        </td>
                        
                        <?php //foreach($last_login_time->result() as $key=>$val2){ ?>
                        <td> 
                  <div>Last Login</div>
                  <?php if(date(strtotime($last_login[$data->user_id]['time']))) { ?>
                        <div class="modify_date"><?php echo date('jS F, Y, H:i:s', strtotime($last_login[$data->user_id]['time'])); ?></div>
                        <?php } else { ?>
                         <div class="modify_date">Not Login</div>
                        <?php } ?>
                        </td>
                        <td> 
                  <div>IP</div>
                        <div class="modify_date"><?php echo $last_login[$data->user_id]['ipaddress'];?></div>
                        </td>
                        <?php //} ?>
                  </tr>
                    
                     <?php $i++; } ?>
                    
                    
                 
                </tbody>
              </table>
              
               <?php } ?>
                                       <?php //echo $links; ?>
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
      //alert(user_id);
      var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
      
        if(confirm('Are sure you want to delete this record'))
        {
            $.post('ViewUlbUserController/deleteContent',{user_id:user_id,'csrf_test_name': csrf_value},function(data)
            {
               //alert(data);
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



