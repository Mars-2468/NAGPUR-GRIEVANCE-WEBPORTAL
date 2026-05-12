<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">	
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/<?php echo $theme; ?>/css/demo.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/<?php echo $theme; ?>/css/jquery.accordion.css">



<?php //print_r($leftsubsubmenus['leftsubsubmenus']); ?>
	<!-- Contenedor -->
		<!--<ul id="accordion" class="accordion">-->
		<!--    <?php foreach($leftmainmenus as $key=>$mainmenu_det){ ?>-->
		<!--	<li>-->
		<!--		<div class="link"><?php echo $mainmenu_det['page_name']; ?><i class="fa fa-chevron-down"></i></div>-->
		<!--		<?php if(count($leftsubmenus['leftsubmenus'][$key])> 0){?>-->
		<!--		<ul class="submenu">-->
		<!--		    <?php foreach($leftsubmenus['leftsubmenus'][$key] as $key2=>$submenu_det){?>-->
		<!--			<li><a href="<?php echo  base_url().$submenu_det['site_controller']; ?>"><?php echo $submenu_det['page_name']; ?></a></li>-->
					
		<!--			<?php }?>-->
		<!--		</ul>-->
		<!--		<?php }?>-->
		<!--	</li>-->
		<!--	<?php }?>-->
			
		
		<!--</ul>-->
		
<!--<div id="cssmenu" class="blue3">
  <ul>
      <?php foreach($leftmainmenus as $key=>$mainmenu_det){ ?>
      <?php if(count($leftsubmenus['leftsubmenus'][$key]) > 0){?>
       <li class="has-sub"><a href="<?php echo base_url().$mainmenu_det['site_controller']; ?>"> <?php echo $mainmenu_det['page_name']; ?> </a>
       
     
        <ul style="display: none;">
            <?php foreach($leftsubmenus['leftsubmenus'][$key] as $key2=>$submenu_det){?>
            <?php if(count($leftsubsubmenus['leftsubsubmenus'][$key][$key2]) > 0){?>
           <li class="has-sub">
               <a href="<?php echo base_url().$submenu_det['site_controller']; ?>"><?php echo $submenu_det['page_name']?></a>
              <ul style="display: none;">
                  <?php foreach($leftsubsubmenus['leftsubsubmenus'][$key][$key2] as $key3=>$subsubmenu_det){?>
                 <li><a href="<?php echo base_url().$subsubmenu_det['site_controller']; ?>"> <?php echo $subsubmenu_det['page_name']; ?></a></li>
                 
                 <?php } ?>
              </ul>
           </li>
           <?php }else{?>
           <li><a href="<?php echo base_url().$submenu_det['site_controller']; ?>"><?php echo $submenu_det['page_name']?></a></li>
           <?php } }?>
        </ul>
     </li>
      <?php }else{ ?>
     <li class=""><a href="<?php echo base_url().$mainmenu_det['site_controller']; ?>"> <?php echo $mainmenu_det['page_name']; ?> </a></li>
     
    <?php }} ?>
    
  </ul>
</div>-->


<section id="multiple" class="menu_top" data-accordion-group>
  <section data-accordion>
      <article data-accordion>
        <button class="full_width" data-control>2nd Level</button>
        <div data-content class="menu_style">
          <article>Item1</article>
          <article>Item2</article>
          <article data-accordion>
            <button class="full_width" data-control>Item3</button>
            <div data-content class="menu_style1">
              <article>Item</article>
            </div>
          </article>
        </div>
      </article>
  </section>
  
  <section data-accordion>
      <article data-accordion>
        <button class="full_width" data-control>2nd Level</button>
        <div data-content class="menu_style">
          <article>Item1</article>
          <article>Item2</article>
          <article data-accordion>
            <button class="full_width" data-control>Item3</button>
            <div data-content class="menu_style1">
              <article>Item</article>
            </div>
          </article>
        </div>
      </article>
  </section>
  
</section>