<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!------ Include the above in your HEAD tag ---------->

<div class="sh-pagebody">

<?php if($this->session->flashdata('message')){echo $this->session->flashdata('message'); }?>

        <div class="col-md-11 col-sm-8 col-xs-9 bhoechie-tab-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group">
                <a href="#" class="list-group-item active text-center">
                 Set Homepage content
                </a>
                <a href="#" class="list-group-item text-center">
                  Menu location
                </a>
                <!--
                
                <a href="#" class="list-group-item text-center">
                  Hotel
                </a>
                <a href="#" class="list-group-item text-center">
                  Restaurant
                </a>
                <a href="#" class="list-group-item text-center">
                 Credit Card
                </a>
                
                -->
              </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active" style="padding:10px;">
                    <?php echo form_open('PageSettingController/sethomepagecontent'); ?>
                     <!-- setting homepage content -->
                     <?php  $string=""; foreach($publishedPages->result() as $key=>$val){
                     
                     if($val->page_id==$selectedpage['page_id'])
                     {
                         $string="checked";
                     }
                     else
                     {
                         $string="";
                     }
                     ?>
                     
                     <input type="radio" name="pageId" value="<?php echo $val->page_id; ?>" <?php echo $string; ?>> <?php echo $val->page_name; ?> <br>
                     
                     <?php } ?>
                     
                     <br>
                     
                     <input type="submit" name="save" value="update" class="btn btn-sm btn-primary">
                     
                     <?php form_close();?>
                     
                     <!-- end -->
                    
                </div>
                <!-- train section -->
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#55518a">Menu Location</h3>
                    </center>
                </div>
    
                <!-- hotel search -->
                <!--
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#55518a">Hotel Directory</h3>
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#55518a">Restaurant Diirectory</h3>
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#55518a">Credit Card</h3>
                    </center>
                </div>
                -->
            </div>
        </div>
 


</div>        
            
<script>
    $(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>            
          
   
