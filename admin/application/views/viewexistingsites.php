 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <script  src = "<?php echo base_url() ?>assets/js/tags.js"></script><!-- // this is for tags -->
  
 


<style>
    
table tr:nth-child(odd) {
 background-color: #FFF;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}

.modal-body {
    padding: 0px !important;
}
    
    @media (min-width: 768px) {
  .modal-xl {
    width: 90%!important; 
   max-width:1200px!important; 
  }
}


/*-------for tags css --------*/

.bootstrap-tagsinput {
  background-color: #fff;
  border: 1px solid #ccc;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  /*display: inline-block;*/
  padding: 4px 6px;
  color: #555;
  vertical-align: middle;
  border-radius: 4px;
  max-width: 100%;
  line-height: 22px;
  cursor: text;
  border:1px #ccc solid !important;
}

.bootstrap-tagsinput input {
  border: none;
  box-shadow: none;
  outline: none;
  background-color: transparent;
  padding: 0 6px;
  margin: 0;
  width: 100%;
  max-width: inherit;
}
.bootstrap-tagsinput.form-control input::-moz-placeholder {
  color: #777;
  opacity: 1;
}
.bootstrap-tagsinput.form-control input:-ms-input-placeholder {
  color: #777;
}
.bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
  color: #777;
}
.bootstrap-tagsinput input:focus {
  border: none;
  box-shadow: none;
}
.bootstrap-tagsinput .tag {
  margin-right: 2px;
  color: white;
}
.bootstrap-tagsinput .tag [data-role="remove"] {
  margin-left: 8px;
  cursor: pointer;
}
.bootstrap-tagsinput .tag [data-role="remove"]:after {
  content: "x";
  padding: 0px 2px;
}
.bootstrap-tagsinput .tag [data-role="remove"]:hover {
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
}
.bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
  box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
}

    
 .bootstrap-tagsinput .label{
     font-size:13px;
     font-weight:normal;
 }   
    .bootstrap-tagsinput .tag [data-role="remove"]{
        
        opacity:1;
    }
    
    .bootstrap-tagsinput .tag [data-role="remove"]::after{
        
        font-family:arial;
    }
    
----------- End styles for tags-----------    
    
    

    
    
    
</style>


<div class="sh-pagebody">
    
    <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Existing Sites</div>
         <div class="card-body ">



<?php echo $this->session->flashdata('message');?>
<?php
 foreach($siteAdminList->result() as $key=>$val)
	    {
	        $siteadminlist[$val->ulbid][$val->user_id]['user_id']=$val->user_id;
	    }
	    
	   // foreach($allsubmenus->result() as $key=>$val)
	   // {
	   //     $sitesubmenulist[$val->main_menu_id][$val->sub_menu_id]['sub_menu_desc']=$val->sub_menu_desc;
	   // }
?>

<div class="row">
    <div class="col-md-12" style="font-size:13px;">
        <table id="datatable1" class="table table-hover table-bordered table-striped " border="1" style="border-collapse:collapse;">
            <tr class="info table-info">
                <th><strong>Sl No</strong></th>
                <th><strong>ULB</strong></th>
                <th><strong>Site name</strong></th>
                <th><strong>Site Url</strong></th>
                <th><strong>Site admin</strong></th>
                <th><strong>Action</strong></th>
            </tr>
            
            <?php $i=1;foreach($existedSiteList->result() as $key=>$val){?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $val->ulbname;?></td>
                <td><?php echo $val->site_name;?></td>
                <td><?php echo $val->base_url.$val->ulbid."/home-page"; ?></td>
                <td>
                    <?php 
                    foreach($siteadminlist[$val->ulbid] as $user_id=>$userdetails)
                    {
                        ?>
                        <a href='<?php base_url(); ?>change-settings/<?php echo $val->ulbid; ?>/1/<?php echo $user_id; ?>'> <?php echo $user_id; ?> - Page permissions</a>
                        <br>
                        <?php
                    }
                    ?>
                </td>
                <td><a href="<?php echo base_url(); ?>edite-new-sites/<?php echo $val->ulbid; ?>"/>Edit</a></td>
                
            </tr>
            <?php $i++;} ?>
            
        </table>
    </div>
</div>


</div>
</div>













        
            
            
          
   
