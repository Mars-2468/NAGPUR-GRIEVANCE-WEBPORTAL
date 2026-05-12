  <!-- Responsive Grid -->


<div class="container py-1">
	<div class="row row-cols-1 row-cols-md-4 g-2">
		<?php		 
			foreach($tabcontents as $smkey=>$smvalue) { 
			
				if(($tabcontents[$smkey]['is_custumlink']==1)&& ($tabcontents[$smkey]['is_target_blank']==2)){
					
					//echo $test=count($subsubmenus[$mkey][$smkey]);
					
					$controller=trim($tabcontents[$smkey]['controller'], "/");
				}else{
					$controller=trim($tabcontents[$smkey]['controller'], "/");
				}			
			
			?>
		
			<?php if(count($subsubmenus[$mkey][$smkey])){ 	

					foreach($subsubmenus[$mkey][$smkey] as $ssmkey=>$ssmvalue) { ?> 
					<div class="col" onclick="window.open('<?php echo $subsubmenus[$mkey][$smkey][$ssmkey]['controller'] ?>', '_blank');" title="<?php echo $submenus[$mkey][$smkey]['page_name'] ?>">
						<div class="card card22 card-color shadow pointer mb-1" style="max-width: 540px;background-color:<?php echo $colors[$flag];?>" >
							<div class="col-md-12">
								<div class="d-flex justify-content-start">
									<div class="col-md-4 p-2">
									  <img src="assets/nmc/ngmc/images/gallery.gif" class="img-fluid rounded-start1" style="width:60px;height:60px;"  alt="...">
									</div>
									<div class="col-md-8 small p-1 d-flex justify-content-start text-primary align-items-center">
										<?php echo $subsubmenus[$mkey][$smkey][$ssmkey]['page_name']; ?> 			  
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					}
					$flag++;
				}else{ ?>
					<div class="col" onclick="window.open('<?php echo $controller;?>', '_blank');">				
						<div class="card card22 card-color shadow pointer mb-1" style="max-width: 540px;">
							<div class="col-md-12">
								<div class="d-flex justify-content-start">
									<div class="col-md-4 p-2">
									  <img src="assets/nmc/ngmc/images/gallery.gif" class="img-fluid rounded-start1" style="width:60px;height:60px;"  alt="...">
									</div>
									<div class="col-md-8 small p-1 d-flex justify-content-start text-primary align-items-center">
										<?php echo $tabcontents[$smkey]['page_name']; ?>				  
									</div>
								</div>
							</div>
						</div>
					</div>
				 <?php } ?>
				
				<!--
				<div class="card card22 card-color shadow mb-3 pointer" style="max-width: 18rem;min-height:100px;">	 
				  <div class="card-body text-primary  d-flex justify-content-center align-items-center">
					<p class="card-title pointer" style="text-align:center;"><?php //echo $tabcontents[$smkey]['page_name']; ?></p>
				  </div>
				</div>	
				-->
				
			 
			
			  
		<?php } ?>
		
	</div>
</div>
