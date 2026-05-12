<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NMC</title>
 <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"> 
  -->
  <link href="<?php echo base_url(); ?>assets/nmc/css/bootstrap-fte.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/nmc/ngmc/cust-style.css" rel="stylesheet">
 <!-- <script type="text/javascript" src="assets/nmc/ngmc/cust-js.js"></script>

	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
 -->
 <script src="assets/nmc/js/jquery-tso.min.js" ></script>
<!--	
 DATATABLE JS -->
<style>#more{display:none}</style>

 <link href="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/css/style.css" rel="stylesheet">


  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- scripts -->
  <script src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/js/megamenu.js"></script>
  <script src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/js/jquery.dataTables.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/js/bootstrap.bundle.min.js"></script>

 <script src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/js/jquery.dataTables.min.js"></script>
 
 <script src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/js/jquery.js"></script>
 
  <script src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/js/extrajquery.js"></script>

  <script src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/nmc/js/jquery-ui.js"></script>

  <link rel="icon" href="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/TSFC/images/favicon.png" />

	<!-- 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/nmc/fontawesome/css/all.min.css" />

 <link rel="stylesheet" type="text/css" id="fontsizesheet" href="#">
  <link rel="stylesheet" type="text/css" id="themesheet" href="">
<!--
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
-->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/nmc/css/slick-oeo.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/nmc/css/slick-theme-oeo.css" />


  <!-- //////JSB////// -->
  <style>
    .top_blue {
      background: #033057;
      padding: 11px 6px 3px 7px;
      border: solid 1px #fff;
    }

    .top_orange {
      background: #e8751a;
      padding: 11px 6px 3px 7px;
      border: solid 1px #fff;
    }

    .top_green {
      background: #388e3c;
      padding: 11px 6px 3px 7px;
      border: solid 1px #fff;
    }

    .slick-slide {
      height: 120px !important;
    }

    .img1,
    .img2,
    .img3,
    .img4,
    .img5 {
      background-repeat: no-repeat;
      border-radius: 5px;
      color: white;
      display: flex;
      align-items: center;
      padding-top: 15px;
      padding-bottom: 15px;
      height: 150px;
      margin: 5px;
    }

    .five-cards {
      width: 95%;
      margin: 0 auto;
    }

    .slick-prev:before {
      content: '←' !important;
      color: #e06e0d !important;
    }

    .slick-next:before {
      content: '→' !important;
      color: #e06e0d !important;
    }

    .table>:not(caption)>*>* {
      border: 1px solid #ccc;
    }

	.navbar-toggler-icon {
		display: inline-block;
		width: 1.5em;
		height: 0.5em  !important;
		vertical-align: middle;
		background-image: var(--bs-navbar-toggler-icon-bg);
		background-repeat: no-repeat;
		background-position: center;
		background-size: 100%;
	}

    @media (max-width: 767px) {
      .dropdown-menu {
        position: fixed;
        top: auto;
        left: auto;
        right: auto;
        width: auto;
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
		background:#dadac4;
      }
    }
	
	@media only screen and (max-width: 600px) {
		/* Make the dropdown content visible on mobile devices */ 
		.dropdown-content {
			display: block;
		}

		.slick-prev {
			display: none !important;
		}
		
		.slick-next {
			display: none !important;
		}
	}

	.navbar{
		--bs-navbar-padding-y: 0.0rem !important;
	}
	
	input::placeholder {
	  color: #999;
	}
	
	form#formid{
		height:22px !important;
	}
	
	.navbar-nav .nav-item {    
		border-right: none !important;		
	}	
	
	nav{		
		min-height: 1.6rem !important;
	}


	.navbar-nav {
		 --bs-nav-link-padding-y: 0.0rem !important;
			z-index: 1050;
			position: relative;
			background-color:#FFF;	 
	}
	.nav-link {
		display: block; 
		padding:1px 5px !important; 
		font-size: var(--bs-nav-link-font-size);
		font-weight: var(--bs-nav-link-font-weight);
		color: var(--bs-nav-link-color);
		text-decoration: none;
		
		z-index: 1050;
		position: relative;
		background-color:#FFF;	 
		
	  //  background: 0 0;
		border: 0;
		transition: color .1sease-in-out, background-color .1sease-in-out, border-color .1sease-in-out;
	}	

	#nav_bar>.container-fluid>.navbar-nav>.nav-item>.nav-link {
		display: none !important;	
		
		
	}

	/*
	media queries for all devices
	*/

	.imgtop {
		margin-top:-22px !important;
	}

	.custlogo{
		height:50%;
		width:50%;
		object-fit: 
		contain;padding:15px;
	}

	@media only screen and (min-width: 1200px) and (max-width: 1299px) {
        /* styles for browsers larger than 1024px; */
		.imgtop {
			margin-top:-12px !important;
			width:120px;
			height:60px;
		}
		
		.custlogo{
			height:50%;
			width:50%;
			object-fit: 
			contain;padding:15px;
		}
    }
	@media only screen and (min-width: 1100px) and (max-width: 1199px) {
        /* styles for browsers larger than 1024px; */
		.imgtop {
			margin-top:-5px !important;			
		}
		
		.custlogo{
			height:50%;
			width:50%;
			object-fit: 
			contain;padding:15px;
		}
    }
	@media only screen and (min-width: 1000px) and (max-width: 1099px) {
        /* styles for browsers larger than 1024px; */
		.imgtop {
			margin-top:-25px !important;		
		}
		
		.custlogo{
			height:60%;
			width:60%;
			object-fit: 
			contain;padding:15px;
		}
    }
    @media only screen and (min-width: 900px) and (max-width: 999px) {
        /* styles for browsers larger than 1440px; */
		.imgtop {
			margin-top:-30px !important;
			width:100px;
			height:45px;
		}
		.custlogo{
			height:75%;
			width:75%;
			object-fit: 
			contain;padding:15px;
		}

    }
    @media only screen and (min-width: 800px) and (max-width: 899px) {
        /* for sumo sized (mac) screens */
		.imgtop {
			margin-top:-18px !important;
			width:100px;
			height:45px;
		}
		
		.custlogo{
			height:75%;
			width:75%;
			object-fit: 
			contain;padding:15px;
		}

    }
    @media only screen and (min-width: 700px) and (max-width: 799px) {
       /* styles for mobile browsers smaller than 700px; (iPhone) */
	   	.imgtop {
			margin-top:-20px !important;
			width:80px;
			height:40px;
		}
		
		.custlogo{
			height:75%;
			width:75%;
			object-fit: 
			contain;padding:15px;
		}
    }
    @media only screen and (min-width: 600px) and (max-width: 699px) {
       /* default iPad screens */
	   	.imgtop {
			margin-top:-25px !important;
			width:80px;
			height:40px;		
		}
		
		.custlogo{
			height:75%;
			width:75%;
			object-fit: 
			contain;padding:15px;
		}

    } 
	@media only screen and (min-width: 500px) and (max-width: 599px) {
       /* default iPad screens */
	   	.imgtop {
			margin-top:-5px !important;
		
		}
		.custlogo{
			margin-top:15%;
			height:100%;
			width:100%;
			object-fit: 
			contain;padding:15px;
		}

    }	
	@media only screen and (min-width: 400px) and (max-width: 499px) {
       /* default iPad screens */
	   	.imgtop {
			margin-top:-5px !important;		
		}
		.custlogo{
			margin-top:35%;
			height:100%;
			width:100%;
			object-fit: 
			contain;padding:15px;
		}

    }
	@media only screen and (min-width: 300px) and (max-width: 399px) {
       /* default iPad screens */
	   	.imgtop {
			margin-top:-5px !important;		
		}
		.custlogo{
			margin-top:50%;
			height:100%;
			width:100%;
			object-fit: 
			contain;padding:5px;
		}

    }
	@media only screen and (min-width: 200px) and (max-width: 299px) {
       /* default iPad screens */
	   	.imgtop {
			margin-top:-5px !important;		
		}
		.custlogo{
			height:75%;
			width:75%;
			object-fit: 
			contain;padding:15px;
		}

    }

	
  </style>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/nmc/css/font-awesome-fsz.min.css" />

</head>
<body style="background-color:#FFF;">

<!--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

-->


<div class="" onmouseout="openPage('',this , '')">
	


 <script src="assets/nmc/js/bootstrap-fte.bundle.min.js"></script>

<nav id="nav_bar" class="navbar navbar-expand-sm bg-body-tertiary small"  style="background-color:blue1 !important;">
	<div class="container-fluid p-2">
		<a class="nav-link" style="margin-right:10px;" href="#menu-top"><em>Skip to Main Content</em></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarScroll">
		  <ul class="navbar-nav me-auto my-1 my-sm-0">
		   <li class="nav-item1">
			  <a class="nav-link1 active1" aria-current="page" href="#"></a>
			</li>
			 <li class="nav-item">
			  <a class="nav-link" href="#"><strong>|</strong></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#"><em>Screen Reader Access</em></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#"><strong>|</strong></a>
			</li>   
			<li class="nav-item">
			  <a class="nav-link" href="#"><em>Select Theme</em></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#"><button id="blue" title="Blue Theme " class="btn4 top_blue" aria-label="true" onclick="fun3('')" style="height:15px;width:15px;background-color:rgba(248,249,250,1);border:1px solid black;" ></button></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#"><button id="blue" title="Blue Theme " class="btn4 top_blue" aria-label="true" onclick="fun3('#3457D5')" style="height:15px;width:15px;background-color:blue;border:0px;" ></button></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#"><button id="orange" title="Orange Theme " class="btn5 top_orange" aria-label="true" onclick="fun3('#e8751a')" style="height:15px;width:15px;background-color:orange;border:0px;" ></button></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#"><button id="red" title="Green Theme " class="btn6 top_green" aria-label="true" onclick="fun3('#388e3c')" style="height:15px;width:15px;background-color:green;border:0px;" ></button></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#"><strong>|</strong></a>
			</li>	
			
			
			
			<li class="nav-item text-left"> 
				<a class="nav-link  mybtn btn-cwhite " id="removeGrayscale" title="Default theme" onclick="fun2('mygrayscale','remove')">
				  <img alt="Default theme" src="assets/nmc/images/defualt_16X16.png">
				</a> 
			</li>
			
			<li class="nav-item text-left"> 
			  <a class="nav-link  mybtn btn-cblack " id="AddGrayscale" title="Grayscale" onclick="fun2('mygrayscale','add')">
				  <img alt="Grayscale" src="assets/nmc/images/gray-16X16.png">
				</a> 
			</li>
			
			
			<li class="nav-item">
			  <a class="nav-link" href="#"><strong>|</strong></a>
			</li>
					
			<li class="nav-item text-left"> 
				<a class="nav-link  mybtn" href="javascript:void(0)" id="plus1" onclick="setFontSize('increase')" title="Increase Font Size">
				  <span class="ms">A+</span>
				</a> 
			</li>
			<li class="nav-item text-left">
				<a class="nav-link  mybtn" href="javascript:void(0)" id="actual1" onclick="setFontSize('normal')" title="Actual Font Size">
				  <span class="ms">A</span>
				</a> 
			</li>
			<li class="nav-item text-left">
				<a class="nav-link  mybtn" href="javascript:void(0)" id="minus1" onclick="setFontSize('decrease')" title="Decrease Font Size">
				  <span class=" ms">A-</span>
				</a>
			</li>
			
			<li class="nav-item text-left">
		
				<a class="nav-link  mybtn" id="ttsPlay" href="javascript:void(0)" aria-label="Read page content">
				  🔊 Read
				</a>
			</li>	
			<li class="nav-item text-left">
				<a class="nav-link  mybtn" id="ttsStop" href="javascript:void(0)" aria-label="Stop reading">
				  ⏹ Stop
				</a>
			</li>
			
			
			<li class="nav-item">
			  <a class="nav-link" href="#"><strong>|</strong></a>
			</li>
			
			<?php if ($this->session->userdata('lang_Id') == 1) { ?>
				<li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>HomeController/changLanguage/2"><em>मराठी</em></a></li>
			<?php } else { ?>
				<li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>HomeController/changLanguage/1"><em>English</em></a></li>
			<?php } ?>

			
		  </ul>
		<form action="/search" method='post' class="d-flex" id="formid" role="search" >
			<input
			  class="form-control me-0"
			  type="search"
			  name="search_keyword"
			  id="search_keyword"
			  placeholder="Search"
			  aria-label="Search"
			  spellcheck="true"
			  autocorrect="on"
			  autocomplete="on"
			  style="
				font-style: italic;
				border-top: 1px solid grey;
				border-left: 1px solid grey;
				border-bottom: 1px solid grey;
				border-top-right-radius: 0;
				border-bottom-right-radius: 0;
			  "
			>

			<button class="btn btn-outline-dark bg-danger text-white d-flex align-items-center" type="button"
                id="micBtn"
                title="Speak"><i class="fa fa-microphone" ></i></button>
			<button class="btn btn-outline-dark bg-dark text-white d-flex align-items-center" type="submit"><i class="fa fa-search"></i></button>
		</form> 

		</div>
	</div>
</nav>
		
	
</div>

<div class="parent  " onmouseout="openPage('',this , '')">
	<div class="child pointer d-flex justify-content-center align-items-center" id="lg">
		<div style="display:block">
			<div class="" onclick="location.href='/'">
				<div>
					 <img src="assets/nmc/ngmc/Nagpur_logo.png" class="custom-logo custlogo"  />  
				</div>
			</div>
		</div>
	</div>
	<div class="child2 p-3 pointer" id="inpt">
		<div class="d-flex justify-content-start align-items-center">
			
			<div class="text-shadow custom-class speechContent" style="font-size:30px;font-weight:bold;margin-left:2px; font-family:Copperplate Gothic Light;">
				
				<?php if($this->session->userdata('lang_Id') == 1){ ?>
				Nagpur Municipal Corporation
				<?php }else{ ?>
				नागपूर महानगरपालिका
				<?php } ?>
				
			</div>
		</div>
		<div>
			<img src="assets/nmc/ngmc/smart-city.png" class="custom-logo2" style="padding:10px;object-fit: contain;margin-right:60px;" />	

		<?php 		
			include 'chatbotpage.php';
		?>
		
		</div>

	</div>
</div>

<style>
.marquee-container {
    overflow: hidden;
	width:100%;
    white-space: nowrap;
    position: relative;
}

.marquee-content {
    display: inline-block;
    padding-left: 100%;
    animation: marquee 20s linear infinite;
}

.marquee-container:hover .marquee-content {
    animation-play-state: paused;
}

@keyframes marquee {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-100%); }
}
</style>

<div class="parent2" onmouseout="openPage('',this , '')">
	<div class="child21 pointer pt-2" id="lg2">		
		<h6 class="speechContent">
			<?php if($this->session->userdata('lang_Id') == 1){ ?>
			Important Links
			<?php }else{ ?>
			महत्वाच्या लिंक्स
			<?php } ?>
		</h6>			
	</div>
	<div class="child22 pointer pt-2 " id="inpt2" style="background-color:#5c5cd6 !important;">
		<div class="marquee-container bg-dark1 text-white h6">
    <div class="marquee-content">
        <?php foreach($important_links as $key=>$value){ ?>
            <span onclick="window.open('<?php echo $value->url; ?>')" class="mx-5" style="cursor:pointer;">
                <?php echo $value->des; ?>
            </span>
        <?php } ?>
    </div>
</div>
	</div>
</div>

<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" onmouseout="openPage('',this , '')">
	<div class="carousel-inner">
		
		<?php 
		
		if(count($slides)){
			
			foreach($slides as $key=>$value ) { 
		
			?>
			
			<div class="carousel-item">
				<img src="<?php echo $value['thumbnail_path']; ?>" class="d-block w-100" style="width:100%;height:300px !important; aspect-ratio: 16 / 9;border-radius:none !important;" alt="<?php echo $value['hover_title']; ?>" title="<?php echo $value['hover_title']; ?>" />
				<div class="carousel-caption d-none d-md-block"  target="_blank" onclick="location.href='<?php echo $value['permalink']; ?>'">
					<a href="<?php echo $value['permalink']; ?>" style="text-decoration:none;" target="_blank"><h2><span><?php echo $value['content']; ?></span> </h2></a>
				</div>							   
			</div>	
			
			<?php 
			
			}
			
		}
				
		?>
		
			
		<div class="carousel-item active video-container">
				<video class="" autoplay loop muted  style=" height:300px !important;aspect-ratio: 16 / 9;" controls1>
				<source src="assets/nmc/ngmc/images/lv_0_20230428173812.mp4" type="video/mp4" />
			</video>
		</div>
		
	</div>
  
  
  

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
 
  
</div>

<?php $colorNames=[
0=>'red',
1=>'green',
2=>'blue',
3=>'orange',
4=>'pink',
];
$incr=0;
$flag=0;
?>

<div id="menu-top"  class="navbar navbar-expand-lg bg-light1 d-flex justify-content-center" style="background-color:#EEEEEE">
	<button class="btn tablink text-shadow" onclick="location.href='/'" onmouseout="openPage('',this , '')">Home</button>
	<?php foreach($mainmenus as $key=>$value) { 
			$pagename=str_replace(" ",'',$mainmenus[$key]['page_name']);
			
			if($mainmenus[$key]['is_target_blank']!=0){
				$mainmenuLink=$mainmenus[$key]['site_controller'];
			}else{
				$mainmenuLink="#";
			}
			
	?>
	<button class="btn tablink text-shadow" onmouseover="openPage('<?php echo $pagename;?>', this, '<?php echo $colorNames[$incr++]?>')"  onclick="window.open('<?php echo $mainmenuLink;?>', '_blank');"><?php echo $mainmenus[$key]['page_name'];?></button>
	<?php } ?>
	</div>
