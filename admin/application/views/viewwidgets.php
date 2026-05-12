<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>


<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

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
    
     <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white"></div>
         <div class="card-body ">

<?php if($this->session->flashdata('message')){?>
<div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
<?php }?>


          
          <div style="display:inline-flex;">
          <div class="mypagetitile">Widgets</div>    
            <!--<a href="<?php //echo base_url(); ?>creage-widget" class="btn btn-default btn-sm mg-b-10">Add New</a>-->
           </div>   
              
              <?php 
              if(count($custom_menus) > 0)
              {
$attributes=array('method'=>'POST');

//echo form_open('ViewWidgetsController/selectDeleteWidgetData',$attributes); ?>
<br>




<div style="margin-bottom:15px; margin-top:15px;" class="bulk_btn"> 
    <?php if(($this->session->userdata('user_type')) == 'A'){ ?>
 <button type="submit" class="btn btn-primary btn-sm" onclick="deleteWidgetData()"><i class="fa fa-trash"></i> Bulk Delete</button>
    <?php } ?>
<button class="btn btn-link">Total widgets <span style="color:#53c7f0;">(<?php print_r($count['count']); ?>)</span></button>


   


</div>
  <div class="mytable ">
              <table id="datatable1" class="table table-hover table-bordered table-striped mg-b-0">
                <thead>
                  <tr class="info">
                    <?php if(($this->session->userdata('user_type')) == 'A'){ ?>  
                    <th>
                      <label class="ckbox mg-b-0">
                        <input type="checkbox" id="checkAll"><span></span>
                      </label>
                    </th>
                     <?php } ?>
                    <th>
                         S No.  
                    </th>
                    <th> Name </th>
                    <th> Author </th>
                    <th> Widget Type Name </th>
                    <th> Date </th>
                  </tr>
                </thead>
                <tbody>
                    <?php $i=1;foreach($custom_menus as $key=>$val){ ?>
                        
                    
                    <tr>
                        <?php if(($this->session->userdata('user_type')) == 'A'){ ?>  
                    <td style="width: 80px;">
                      <label class="ckbox mg-b-0">
                        <input type="checkbox" class="checkbox chkcat" value="<?php echo $val['widget_id'].'_'.$val['widget_type'].'_'.$val['widget_type_style']; ?>" name="check_list[]"><span><?php //echo $i; ?></span>
                      </label>
                    </td>
                         <?php } ?>
                    <td style="width: 80px;">
                        <span> <?php echo $i; ?> </span>
                    </td>
                    <td style="width: 200px;">
                        <div style="font-size:13px;"> <strong><?php echo $val['widget_id']; ?>&nbsp;-&nbsp;<?php echo $val['widget_name']; ?> </strong> </div>
                        <div>
							<?php if($val['is_edit_permission']=='1'){ ?> <a class="modify_option" href="<?php echo base_url(); ?>edite-widget/<?php echo encrypt_data($key); ?>/<?php echo encrypt_data($val['widget_type']); ?>/<?php echo encrypt_data($val['widget_type_style']) ;?>"> Edit </a><?php } ?> <?php if($val['is_delete_permission']=='1'){ ?> | <a class="modify_option1" class="modify_option1" onclick="delete_rec(<?php echo $key; ?>)"> Delete </a><?php } ?>  
                        </div>
                        <input type="hidden" id="id_<?php echo $val['widget_id']; ?>" value="<?php echo $val['widget_type']; ?>" />
                        <input type="hidden" id="id_<?php echo $val['widget_id']; ?>" value="<?php echo $val['widget_type_style']; ?>" />
                        
                    </td>
                    <td><?php echo $val['author'];//.' '.$val['widget_id']; ?></td>
                    <td  style="width: 150px;"><?php echo $val['widget_type_name']; ?></td>
                    <td  style="width: 150px;">
                        <div>Last Modified</div>
                        <div class="modify_date"><?php echo date('jS F, Y, H:i:s', strtotime($val['ts'])); ?></div>
                    </td>
                  </tr>
                    
                     <?php $i++;}?>
              
                </tbody>
              </table>
            </div> 

</div>

<?php //echo form_close();
}?>

</div>
</div>



<script type="text/javascript">
    function delete_rec(widget_id)
    {
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        var wd = widget_id;
        var val = $("#id_"+widget_id).val();
        //alert(widget_id+' '+val);
        var merge = wd+'_'+val;
        var check_val = jQuery.makeArray(merge);
        //alert(check_val);
        if(confirm('Are sure you want to delete this record'))
        {
            
            
            $.get('ViewWidgetsController/selectDeleteWidgetData',{check_val:check_val,'csrf_test_name': csrf_value},function(data)
            {
               //alert(data);
               if(data == '1'){
                   alert('Widget Deleted successfully');
                   location.reload();
               }else{
                  alert('Please Try Again!'); 
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
                    alert('Widget Deleted successfully');
                    location.reload();
                }
                else
                {
                    alert('Unable change the status');
                }
            });
        }
    }

    function deleteWidgetData(){
        
        
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var check_val = [];
        $(':checkbox:checked').each(function(i){
            check_val[i] = $(this).val();
        });
        if(check_val != ''){    
            if(confirm('Are sure you want to delete of this widgets')){
                //alert(check_val);
            
                $.post("ViewWidgetsController/selectDeleteWidgetData",{check_val:check_val,'csrf_test_name': csrf_value},function(data){
                    //alert(data);
                    if(data == 1){
                        alert("Widget Deleted successfully");
                        location.reload();
                    }else{
                      alert('Please Try Again!'); 
                    }
                });
            }
        }else{
            alert("Please Select atleast one Widget");
        }
        
   }
   
   $("#checkAll").change(function(){
       //alert('check All');
    $(".checkbox").prop('checked', $(this).prop("checked"));
    //$('input:checkbox').not(this).prop('checked', this.checked);
    });
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
        //$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
      
    </script>



