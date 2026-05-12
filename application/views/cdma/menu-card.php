
<style>
.flip-card {
	background-color: transparent;
	width: 100% !important;
	height: 60px !important;	
	padding:0px !important;
	border-radius: 10px !important;
	perspective: 1000px; 
}

.flip-card-inner {
	position: relative;
	width: 100%;
	height: 100%;
	text-align: center;
	transition: transform 0.6s;
	transform-style: preserve-3d;
	box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
	border-radius: 10px !important;
}

.flip-card:hover .flip-card-inner {
	transform: rotateY(180deg);
}

.flip-card-front, .flip-card-back {
	position: absolute;
	width: 100%;
	height: 100%;
	-webkit-backface-visibility: hidden;
	backface-visibility: hidden;
}

.flip-card-front {
	background-color: #ffffff;
	color: black;
	border-radius: 10px !important;
	display: flex;
    align-items: center;
}

.flip-card-back {
	margin: auto;
	background-color: #ff8c61;
	color: white;
	transform: rotateY(180deg);
	border-radius: 10px !important;
}

.p1{
	padding:0px 10px 0px 10px;	
	 vertical-align: middle;
	 text-align:left;
	 margin:auto;
	font-size:10px;
}

table tbody tr:first-child td,table tbody tr:first-child th,
table thead tr:first-child td, table thead tr:first-child th {
	background: #58ab43;  /* Green background for the first row */
	text-align: center;    /* Center-align the text */
}
		
</style>

<div class="container py-1">
	<div class="row row-cols-1 row-cols-md-6 g-2">
		<?php		 
			foreach($tabcontents as $smkey=>$smvalue) { 
			
				if(($tabcontents[$smkey]['is_custumlink']==1)&& ($tabcontents[$smkey]['is_target_blank']==2)){
					
					//echo $test=count($subsubmenus[$mkey][$smkey]);
					
					$controller=trim($tabcontents[$smkey]['site_controller'], "/");
				}else{
					$controller=trim($tabcontents[$smkey]['controller'], "/");
				}			
			
			?>
		
			<?php if(count($subsubmenus[$mkey][$smkey])){ 	

					foreach($subsubmenus[$mkey][$smkey] as $ssmkey=>$ssmvalue) { ?> 
		
						<div class="col" onclick="window.open('<?php echo $subsubmenus[$mkey][$smkey][$ssmkey]['controller'] ?>', '_blank');" title="<?php echo $submenus[$mkey][$smkey]['page_name'] ?>">
						
							<div class="card card222 flip-card card-color shadow pointer mb-1" style="max-width: 540px;background-color:<?php echo $colors[$flag];?> !important;" >
								<div class="flip-card-inner">
									<div class="flip-card-front" style="background-color:<?php echo $colors[$flag];?> !important;">
										<div class="col-md-12">
											<div class="row1 d-flex align-items-center ">
												<div class="col-sm-3 text-center" >
													  <img src="<?php echo isset($subsubmenus[$mkey][$smkey][$ssmkey]['meta_photo']) ? $subsubmenus[$mkey][$smkey][$ssmkey]['meta_photo'] : 'assets/nmc/ngmc/images/gallery.gif'; ?>" class="img-fluid rounded-start1" style="width:40px;height:40px;"  alt="...">
												</div>
												<div class="col-sm-9">
													<p class="text-left p1" style="display:flex;justify-content-center;align-items:center;">
													<?php echo $subsubmenus[$mkey][$smkey][$ssmkey]['page_name']; ?> 
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="flip-card-back">
										<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
										  <p style="text-align:center;font-weight:bold;font-size:11px;color:#000000;"><?php echo $tabcontents[$smkey]['page_name']; ?></p>
										  <p style="text-align:center;font-size:10px;"><?php echo $subsubmenus[$mkey][$smkey][$ssmkey]['page_name']; ?> </p>
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
					
						<div class="card card222 flip-card card-color shadow pointer mb-1" style="max-width: 540px;" >
							<div class="flip-card-inner1">
								<div class="flip-card-front">
									<div class="col-md-12">
										<div class="row1 d-flex align-items-center ">
											<div class="col-sm-3 text-center" >
												  <img src="<?php echo isset($tabcontents[$smkey]['meta_photo']) ? $tabcontents[$smkey]['meta_photo'] : 'assets/nmc/ngmc/images/gallery.gif'; ?>" class="img-fluid rounded-start1" style="width:40px;height:40px;"  alt="...">
											</div>
											<div class="col-sm-9">
												<p class="text-left p1"  style="vertical-align:middle;">
												<?php echo $tabcontents[$smkey]['page_name']; ?>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="flip-card-back">
								  <p  class="p1"  style="text-align:center;vertical-align:middle;"><?php echo $tabcontents[$smkey]['page_name']; ?></p>
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