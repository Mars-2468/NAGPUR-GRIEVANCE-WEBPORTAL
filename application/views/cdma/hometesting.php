<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">	
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/<?php echo $theme; ?>/css/demo.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/<?php echo $theme; ?>/css/jquery.accordion.css">
<style>
    /*p{
    color: #5c5c5c;
font-family: 'Open Sans', sans-serif;

font-size: 13px;
line-height: 1.8;
    }*/
</style>
<?php ini_set('display_errors',0); ?>



    

<!---- top navigation-->

<!-- slider-->
<div ng-app="home">
<?php $this->load->view($theme.'/includes/homepage/homepageslider',$sliderdata);?>
</div>
<!-- slider end -->



<!-- ministers photos --->


<?php if($ulbid==='001'){?>
<div class="container bg2">

<div>
<?php $this->load->view($theme.'/includes/homepage/publicrepresetatives');?>
<?php $this->load->view($theme.'/includes/homepage/weather');?>
</div>
<?php } ?>
</div>

<div class="clearfix"></div>



<?php 
$content="";
$previoud_divcode=0;
$i=1;
$j=1;
$k=1;

foreach($customepagelayouts->result() as $key=>$val){
    
    // put condition here 
    if($val->is_in_loop_section=='1')
    {
    
    
    if($i==1)
    {
       if($val->page_layout_id ==1 || $val->page_layout_id==2 || $val->page_layout_id==3 || $val->page_layout_id >= 7 )
        {
            $content.="<div class='container bg3'>";
            $j++;
        }
        else
        {
            //$content.="<div class='".$val->source."'>";
        }
    }

    if(($val->page_layout_id ==1 || $val->page_layout_id==2 || $val->page_layout_id==3) || $val->page_layout_id >= 7)
    {
        if($j==1)
        {
            $content.="<div class='container bg3'>";
        }
        
        if($val->page_layout_id ==1 || $val->page_layout_id==2 || $val->page_layout_id==3)
        {
            if($k==1)
            {
                $content.="<div>"; // open div for left, middle, right section
            }
            $k++;
        }
        
        
        
        
        
        $previoud_divcode=1;
        $content.="<div class='".$val->source."'>";
        foreach($layoutwidgets[$val->page_layout_id] as $key2=>$val2){
            $content.=$val2;
        }
        
        $content.="</div>";
        
        
        
         
        
       
        $j++;
    }
    else
    {
        if($val->page_layout_id !=5 && $val->page_layout_id !=6)
            {
                if($previoud_divcode==1)
                {
                $content.="</div>"; // closing div for left, middle, right section
                $content.="</div>"; // div close for container bg3
                
                }
                $content.="<div class='".$val->source."'>";
                foreach($layoutwidgets[$val->page_layout_id] as $key2=>$val2){
                    $content.=$val2;
                }
                $content.="</div>";
            }
    }
    $i++;

 }
}
 echo $content;

 ?>
 
 
 <div class="container">
	   <div class="col-md-12 social">
		   <div class="pull-right">
			   <button class="btn btn-default social_facebook"><i class="fa fa-facebook-f s_icon"></i></button>
			   <button class="btn btn-default social_twitter"><i class="fa fa-twitter s_icon"></i></button>
			   <button class="btn btn-default social_youtube"><i class="fa fa-android s_icon"></i></i></button>  
		   </div>
	   </div>
   </div>
	
   <div class="container bg5 ts-footer">
	   <div class="col-lg-12 ">
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                
                                    <?php
                                    $content="<div class='row'>";
                                     foreach($layoutwidgets[6] as $key2=>$val2){
                                         $content.="<div class='col-md-2 col-xs-12'>".$val2."</div>";
                                               
                                        }
                                    ?>
                                   
                                    <?php
                                    $content.="</div>";
                                    echo $content;
                                    ?>
                                   
                                </div>
                                
                                
                               
                            </div>
                            <div class="row no-row-space">
                                <div class="col-md-12 space_footer text-center">
                                  
                                  <?php
                                  $content="";
                                  echo $layoutwidgets[9][0];
                                  
                                  
                                  ?>
                                  
                                  
                                  
                                    <p class="copyrights">
                                        <i class="fa fa-copyright"></i>
                                    copyright © 2018 Government of Telangana. All rights reserved.                               
                                    </p>
                                    <p>Last Update: 27-07-2018, 11:41:27pm</p>
                                </div>
                            </div>
                          
                        </div>
   </div>
   
   <div class="height"></div>
    
</div><!-- /#page -->
</div><!-- /#wrapper -->
 
 





<!--
<div class="container bg3">
    
<div class="col-md-3 pad_list">

<?php foreach($layoutwidgets[1] as $key=>$val){?>
<?php echo $val; ?>
<?php }?>
    
    
   
</div>

<div class="col-md-5 pad_right paragraph_content">
    <?php foreach($layoutwidgets[2] as $key=>$val){?>
<?php echo $val; ?>
<?php }?>
</div>

<div class="col-md-4 pad_right">
     <?php foreach($layoutwidgets[3] as $key=>$val){?>
<?php echo $val; ?>
<?php }?>
</div>

</div>

-->





<!--
 <div class="container bg4">
     <?php  foreach($layoutwidgets[4] as $key=>$val){?>
<?php echo $val; ?>
<?php }?>

-->





<script>
    $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
</script>






