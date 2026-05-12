
<?php $colors=[
0=>'lightblue',
1=>'lightgreen',
2=>'lightgrey',
3=>'lightorange',
4=>'lightpink',
];

$flag=0;
?>

<div style="background-color:#f2f2f2;">

<?php foreach($mainmenus as $mkey=>$value) { 
			$pagename=str_replace(" ",'',$mainmenus[$mkey]['page_name']);
	?>
	<?php $tabcontents=$submenus[$mkey]; ?>
<?php if(!empty($tabcontents)){?>	
<div id="<?php echo $pagename;?>" class="tabcontent">
	<?php include('menu-card.php')?>
</div>
<?php } ?>
<?php } ?>

</div>

<style>
p{
	margin-bottom:0rem !important;
}
<style>
    .custom-btn {
        background-color: black !important;
        transition: background-color 0.3s ease;
    }
    .custom-btn:hover {
        background-color: green !important;
    }
</style>
</style>
<div id="Online" onmouseout="openPage('',this , '')">
	<div class="container py-4">
		<div class="row row-cols-1 row-cols-md-6 g-4 mb-3">
			<?php 
			
			$part1 = array_slice($layoutwidgets[1], 0, 6); // First 6 elements
			$part2 = array_slice($layoutwidgets[1], 6);    // Remaining elements
			
			foreach($part1 as $key=>$value){ ?>	
									
					
				<?php echo $part1[$key];?>
								
					
			<?php } ?>	
		</div>	
		<span id="dots" class="pull-right"></span>
		<div class="more" id="more">
			<div class="row row-cols-1 row-cols-md-6 g-4 mb-3">
				<?php foreach($part2 as $key=>$value){ ?>	
									
					
				<?php echo $part2[$key];?>
								
					
			<?php } ?>	
			</div>	
		</div>
			
		<div class="d-flex justify-content-end" style="cursor:pointer;color:blue;right:10px;">
			<a style="text-decoration:none;font-size:12px;" onclick="myFunction()" id="myBtn"><em>View more</em></a>
		</div>	
		
		<script>
			function myFunction() {
			  var dots = document.getElementById("dots");
			  var moreText = document.getElementById("more");
			  var btnText = document.getElementById("myBtn");

			  if (dots.style.display === "none") {
				dots.style.display = "inline";
				btnText.innerHTML = "View more"; 
				moreText.style.display = "none";
			  } else {
				dots.style.display = "none";
				btnText.innerHTML = "View less"; 
				moreText.style.display = "inline";
			  }
			}
		</script>		
		
	</div>
</div>
<!--
<div class="container-fluid text-center" style="background-image: url(assets/cdma/nmc/images/over-view-page-2.jpg);background-repeat: no-repeat;background-size: cover;padding:20px;">
  <div class="row align-items-center">
  
    <?php
  if(!empty($membersDTL)){
  foreach($membersDTL as $key=>$value) { ?>
   <div class="col">
    <div class="card"  style="border:none !important;">
      <div class="col">
      <div  class="  d-flex justify-content-center">
		<img src="<?php echo base_url() ?>../assets/cdma/testimonials/<?php echo $value->file; ?>" class="card-img-top1 text-center" alt="..." style="width:100px;height:100px">
      </div>
	  <div class="card-body">      
	  		<h6 style="color:#ff0000;text-align:center;font-size:14px;font-weight:bold;"><?php echo $value->des; ?></h6>
			<h6 style="color:#000000;text-align:center;font-size:12px;"><?php echo $value->text1; ?></h6>
	  </div>
   
    </div>
	</div>
  </div>
  <?php }
  }  ?>
 
	
  </div>
</div>
-->
<style>
.container-fluid::-webkit-scrollbar {
  display: none; /* Hide the scrollbar */
}
iframe {
  width: 500px; /* Adjust the width if needed */
}
#userList::-webkit-scrollbar {
    height: 2px;
}
#userList::-webkit-scrollbar-thumb {
    background: rgba(100, 100, 100, 0.4);
    border-radius: 10px;
}

</style>
<div  style="background-image: url(assets/cdma/nmc/images/over-view-page-2_stop.jpg);background-repeat: no-repeat;background-size: cover;padding:20px;">
	
	<div class="container-fluid py-3 d-flex justify-content-center ">
		<div class="d-flex flex-nowrap overflow-auto justify-content-around" id="userList" style="gap: 1rem;">
			<?php foreach ($membersDTL as $key => $value) { ?>
				
				<?php $des_details=($this->session->userdata('lang_Id')==1)?$membersDTL[$key]->des:$membersDTL[$key]->des_mr;?>
				
				<?php $text1_details=($this->session->userdata('lang_Id')==1)?$membersDTL[$key]->text1:$membersDTL[$key]->text1_mr;?>
					
				
				<div class="text-center text-white1 flex-shrink-0 list-group-items pointer" style="width: 160px;" data-bs-toggle="modal1" data-user-id="<?= $membersDTL[$key]->id; ?>" data-bs-target="#staticBackdrop1">
					<img 
						src="assets/cdma/testimonials/<?= $membersDTL[$key]->file; ?>" 
						alt="<?= $des_details; ?>" 
						class="img-fluid border rounded mb-2" 
						style="width: 140px; height: 140px; object-fit: contain; padding: 10px; border: 1px solid grey;"
					>
					<h6 class="mb-1 text-truncate1"><?= $des_details ?></h6>
					<p class="small1 mb-0" style="font-size:12px;font-weight:bold;">
											
						<?= strlen($text1_details < 37) ? $text1_details : '<span style="font-size: 12px;">' . $text1_details . '</span>'; ?>
										
					</p> 
				</div>
			<?php } ?>
		</div>
	</div>
</div>


<div id="latest_bar" class="pointer p-2" style="background-color:#5c5cd6 !important;">
	<h5 class="text-center text-white">	
	<?php if($this->session->userdata('lang_Id') == 1){ ?>
	Latest Updates
	<?php }else{ ?>
	नवीनतम अद्यतने
	<?php } ?>
	</h5>
</div>

<div  id="Services">

	<div  class="container py-4">

		<div class="col-md-12">

			<div class="row">

				<div class="col-md-6">
					
					<div class="col">
						<div class="card card22 card-color shadow pointer mb-3 p-4" style="width:100%;height:400px;overflow-y:hidden;" >
							<h6>							
								<?php if($this->session->userdata('lang_Id') == 1){ ?>
								Latest Updates
								<?php }else{ ?>
								बातम्या आणि अद्यतने
								<?php } ?>
							</h6>	 
							<ol class="list-group list-group-numbered">
								<div class="scroll-box">
									<div class="scroll-content">
										<?php echo $layoutwidgets[4][0]; ?>
									</div>
								</div>

								<style>
								.scroll-box {
									height: 310px;
									overflow: hidden;
									background: #f2f2f2;
									position: relative;
								}

								.scroll-content {
									position: absolute;
									width: 100%;
									animation: scrollUp 10s linear infinite;
								}

								/* ✅ Pause on hover */
								.scroll-box:hover .scroll-content {
									animation-play-state: paused;
								}

								@keyframes scrollUp {
									0% { top: 100%; }
									100% { top: -100%; }
								}
								</style>
							 </ol>
						 </div>
					</div>
					
				</div>
					
				
				<div class="col-md-6">	
				
					<div class="col">
					
						<div class="card card22 card-color shadow pointer mb-3 p-4" style="width:100%;height:400px;" >
							
							
							<?php if($this->session->userdata('lang_Id') == 1){ ?>
								What's New	
								<?php }else{ ?>
								नवीन काय आहे
								<?php } ?>
							
							<ol class="list-group list-group-numbered">
								<div class="scroll-box">
									<div class="scroll-content">

										<?php foreach ($important_links as $value) { ?>
											<div class="item"
												 onclick="window.open('<?php echo $value->url; ?>','_blank')">

												<img src="<?php echo $value->logo; ?>" width="40" height="40">
												<span><?php echo $value->des; ?></span>

											</div>
										<?php } ?>

									</div>
								</div>

								<style>
								.scroll-box {
									height: 310px;
									overflow: hidden;
									background: #f2f2f2;
									position: relative;
								}

								.scroll-content {
									position: absolute;
									width: 100%;
									animation: scrollUp 15s linear infinite;
								}

								/* ✅ Pause on hover */
								.scroll-box:hover .scroll-content {
									animation-play-state: paused;
								}

								.item {
									display: flex;
									align-items: center;
									padding: 10px;
									cursor: pointer;
								}

								.item img {
									margin-right: 10px;
									border-radius: 50%;
								}

								@keyframes scrollUp {
									0% { top: 100%; }
									100% { top: -100%; }
								}
								</style>
							</ol>
						</div>
					
					</div>	
					
				</div>	
				
			</div>
			
		</div>
		
	</div>	
	
</div>		

	
<!-- Model Start 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
-->
  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <!-- <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> -->
        <div class="modal-body">
		 <img src="img/narendra-modi.jpeg" id="userPhoto" class="card-img-top" alt="..." style="width:100%; height:250px;border:1px solid grey;padding:10px;object-fit: cover;">
          <p><h5 class="text-center text-dark" id="userName">Name</h5></p>
		  <p class="text-center text-dark" id="userDesg">Designation: </p>         
          <!-- <p class="text-center text-dark" id="userSlogan">Slogan: </p> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script>
var innerH6 = document.querySelector('.col-md-4.news-update h6');
var innerDiv = document.querySelector('.col-md-4.news-update .card');
var myDiv = document.querySelector("div.col-md-4.news-update");
var myDiv2 = document.querySelector("div.card-body.news-update-img");

// Remove 'class1'
myDiv.classList.remove("col-md-4");
myDiv2.classList.remove("news-update-img");
myDiv2.style.height="320px";
innerDiv.className = 'card1';
if (innerH6) {
  innerH6.remove();
}
</script>
	
<div id="media_bar" class="pointer p-2" style="background-color:#5c5cd6 !important;">
	<h5 class="text-center text-white">	
	<?php if($this->session->userdata('lang_Id') == 1){ ?>
	Media Gallery
	<?php }else{ ?>
	मीडिया गॅलरी
	<?php } ?>
	</h5>
</div>
<!--
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
-->


	<div  class="container py-4">

		<div class="col-md-12">

			<div class="row">
				<div class="col-md-6">		
					<div id="carouseRide" class="carousel slide" data-bs-ride="true">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<div class="card card-color shadow pointer ">
									<div class="card-header">
										<h4>
											<?php if($this->session->userdata('lang_Id') == 1){ ?>
											Facebook
											<?php }else{ ?>
											फेसबुक
											<?php } ?>
										</h4>
									</div>
									<div class="card-body  pointer mb-3 p-4" style="height:400px;overflow-y:hidden" >
										<iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo $social_links[0]['facebook_link']; ?>&tabs=timeline&width=560&height=590&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="590" style="border:none;" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
									</div>
								</div>
							</div>
							<div class="carousel-item">
								<div class="card card-color shadow pointer">
									<div class="card-header">
										<h4>
											<?php if($this->session->userdata('lang_Id') == 1){ ?>
											Twitter
											<?php }else{ ?>
											ट्विटर
											<?php } ?>
										</h4>
									</div>
									<div class="card-body  pointer mb-3 p-4" style="height:400px;overflow-y:hidden" >
										<a class="twitter-timeline" target="_blank" href="<?php echo $social_links[0]['twitter_link']; ?>?ref_src=twsrc%5Etfw"><img src="<?php echo base_url('assets/nmc/ngmc/images/nmc_twitter.jpg'); ?>" alt="Twitter" width="100%"></a> 
										<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
									</div>								
								</div>
							</div>
							<div class="carousel-item">
								<div class="card card-color shadow pointer">
									<div class="card-header">
										<h4>
											<?php if($this->session->userdata('lang_Id') == 1){ ?>
											Instagram
											<?php }else{ ?>
											इंस्टाग्राम
											<?php } ?>
										</h4>
									</div>								
									<div class="card-body  pointer mb-3 p-4" style="height:400px;overflow-y:hidden" >
										<a class="twitter-timeline" target="_blank" href="<?php echo $social_links[0]['instagram_link']; ?>?ref_src=twsrc%5Etfw"><img src="<?php echo base_url('assets/nmc/ngmc/images/instagram_nmc.jpeg'); ?>" alt="Twitter" width="100%" height="370px"></a> 
									</div>
								</div>
							</div>
						</div>
						<button class="carousel-control-prev" type="button" data-bs-target="#carouseRide" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="false" style="background-color:rgba(0,0,0,0.2) !important;"></span>
							<span class="visually-hidden" style="color:black !important;">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouseRide" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="false" style="background-color:rgba(0,0,0,0.2) !important;"></span>
							<span class="visually-hidden" style="color:black !important;">Next</span>
						</button>
					</div>
				</div>				
				<div class="col-md-6">
				
					<div class="row row-cols-1 row-cols-md-2 g-4">
					 
					 
					
							<?php foreach($layoutwidgets[6] as $key=>$value){
									echo $layoutwidgets[6][$key];
								}
							?>
						  
					
					</div>
				</div>
			</div>
		</div>	 
	</div>
</div>

<script>
.carousel .carousel-item {
    transition-duration: 3s;
}
</script>
<script>
function toggleContent(button) {
  const fullText = button.previousElementSibling;
  
  if (fullText.style.display === 'none') {
    fullText.style.display = 'block';
    button.textContent = 'less...';  // Change button text to 'View Less'
  } else {
    fullText.style.display = 'none';
    button.textContent = 'more...';  // Change button text back to 'View More'
  }
}
</script>

<script>
    // Sample user data
    const users = <?php echo json_encode($membersDTL); ?>;
	var baseUrl = window.location.origin;
    // Add click event listener to each user in the list
    document.querySelectorAll('#userList .list-group-items').forEach(item => {		
      item.addEventListener('click', function () {
        const userId = this.getAttribute('data-user-id');
		
       // alert(userId);
        // Find the user details by id
        const user = users.find(u => u.id == userId);
        
        // Populate the modal with the user's details
        document.getElementById('userPhoto').src ='assets/cdma/testimonials/'+user['file'];
        document.getElementById('userName').textContent = user['des'];
        document.getElementById('userDesg').textContent = user['text1'];
        //document.getElementById('userSlogan').textContent =  user['file'];
     
        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('userModal'));
        modal.show();
      });
    });
  </script>