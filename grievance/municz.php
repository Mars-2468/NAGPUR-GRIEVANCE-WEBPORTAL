<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>KBU Research</title>
		<link rel="icon"  href="inc/img/icon-16.ico" sizes="16x16">
		<link rel="icon"  href="inc/img/icon-32.ico" sizes="32x32">
		<link rel="icon"  href="inc/img/icon-48.ico" sizes="48x48">
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: GOOGLE FONTS -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- end: GOOGLE FONTS -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<!-- start: CLIP-TWO CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		<!-- end: CLIP-TWO CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link href="vendor/DataTables/css/DT_bootstrap.css" rel="stylesheet" media="screen">
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<body>
		<div id="app">
			<!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
				<div class="sidebar-container perfect-scrollbar">
					<nav>
						<!-- start: SEARCH FORM -->
						<div class="search-form">
							<a class="s-open" href="#">
								<i class="ti-search"></i>
							</a>
							<form class="navbar-form" role="search" action="search.php" method="get">
								<a class="s-remove" href="#" target=".navbar-form">
									<i class="ti-close"></i>
								</a>
								<div class="form-group">
									<input type="text" name="search_keyword" id="search_keyword" class="form-control" placeholder="ค้นหางานวิจัย หรือ บุคคลากร ...">
									<button class="btn search-button" type="submit">
										<i class="ti-search"></i>
									</button>
								</div>
							</form>
						</div>
						<!-- end: SEARCH FORM -->
						<!-- start: MAIN NAVIGATION MENU -->
						<div class="navbar-title">
							<span>เมนู</span>
						</div>
						<ul class="main-navigation-menu">
							<li>
								<a href="index.php">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-stats-up"></i>
										</div>
										<div class="item-inner">
											<span class="title">ภาพรวม </span>
										</div>
									</div>
								</a>
							</li>

							<li>
								<a href="javascript:void(0)">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-book"></i>
										</div>
										<div class="item-inner">
											<span class="title">ผลงาน</span><i class="icon-arrow"></i>
										</div>
									</div>
								</a>
								<ul class="sub-menu">

									<li>
										<a href="re_show.php?type=1">
											<span class="title">งานวิจัย</span>
										</a>
									</li>
									<li>
										<a  href="re_show.php?type=2">
											<span class="title">งานสร้างสรรค์</span>
										</a>
									</li>
								    <li>
										<a  href="pub_show.php">
											<span class="title">บทความ</span>
										</a>
									</li>

								</ul>
							</li>
							<!--<li class="active open">-->

							<!--
							 <li>
								<a href="javascript:void(0)">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-book"></i>
										</div>
										<div class="item-inner">
											<span class="title"> วิจัย </span><i class="icon-arrow"></i>
										</div>
									</div>
								</a>
								<ul class="sub-menu">
									<li>
										<a href="re_show.php">
											<span class="title">งานวิจัย</span>
										</a>
									</li>
									<li>
										<a href="#">
											<span class="title">งานวิจัยที่ตีพิมพ์</span>
										</a>
									</li>
									<li>
										<a href="#">
											<span class="title">สิทธิบัตร/อนุสิทธิบัตร</span>
										</a>
									</li>
								</ul>
							</li>
							-->
							<li>
								<a href="javascript:void(0)">
									<div class="item-content">
										<div class="item-media">
											<i class="fa fa-graduation-cap"></i>
										</div>
										<div class="item-inner">
											<span class="title"> คณะ </span><i class="icon-arrow"></i>
										</div>
									</div>
								</a>
								<ul class="sub-menu">
																	<li>
										<a href="faculty.php?fac_code=037 ">
											<span class="title">คณะนิติศาสตร์</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=038 ">
											<span class="title">คณะนิเทศศาสตร์</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=039 ">
											<span class="title">คณะบริหารธุรกิจ</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=083 ">
											<span class="title">คณะวิทยาศาสตร์และเทคโนโลยี</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=088 ">
											<span class="title">คณะวิศวกรรมศาสตร์</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=096 ">
											<span class="title">คณะศิลปศาสตร์</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=132 ">
											<span class="title">บัณฑิตวิทยาลัย</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=180 ">
											<span class="title">คณะสถาปัตยกรรมศาสตร์</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=353 ">
											<span class="title">มหาวิทยาลัยเกษมบัณฑิต</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=356 ">
											<span class="title">สำนักวิจัย</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=395 ">
											<span class="title">คณะจิตวิทยา</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=722 ">
											<span class="title">โครงการหลักสูตรบริหารธุรกิจบัณฑิต (หลักสูตรนานาชาติ)</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=906 ">
											<span class="title">สำนักวิชาศึกษาทั่วไป</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=U-209 ">
											<span class="title">คณะพยาบาลศาสตร์</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=U-29 ">
											<span class="title">คณะวิทยาศาสตร์การกีฬา</span>
										</a>
									</li>
							   									<li>
										<a href="faculty.php?fac_code=U-30 ">
											<span class="title">สถาบันพัฒนาบุคลากรการบิน</span>
										</a>
									</li>
							   								</ul>
							</li>
							<li>
								<a href="javascript:void(0)">
									<div class="item-content">
										<div class="item-media">
											<i class="fa fa-sitemap"></i>
										</div>
										<div class="item-inner">
											<span class="title"> สาขา </span><i class="icon-arrow"></i>
										</div>
									</div>
								</a>
								<ul class="sub-menu">
																	<li>
										<a href="javascript:;">
											<span>คณะนิติศาสตร์</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=037-00                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=037-02                                                ">
													หลักสูตรนิติศาสตรมหาบัณฑิต												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=037-01                                                ">
													สาขาวิชานิติศาสตร์												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะนิเทศศาสตร์</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=038-03                                                ">
													สาขาวิชาวารสารศาสตร์และสื่อใหม่												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=038-02                                                ">
													สาขาวิชาการประชาสัมพันธ์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=038-01                                                ">
													สาขาวิชาการโฆษณา												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=038-00                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=038-05                                                ">
													สาขาวิชาวิทยุและโทรทัศน์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=038-06                                                ">
													สาขาวิชาสื่อสารการแสดงร่วมสมัย												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=038-07                                                ">
													หลักสูตรนิเทศศาสตรมหาบัณฑิต สาขาวิชาการบริหารการสื่อสาร												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=038-04                                                ">
													สาขาวิชาการภาพยนตร์และสื่อดิจิตอล												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะบริหารธุรกิจ</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=039-05                                                ">
													สาขาวิชาคอมพิวเตอร์ธุรกิจ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=039-01                                                ">
													สาขาวิชาการบัญชี												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=039-04                                                ">
													สาขาวิชาการจัดการ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=039-07                                                ">
													สาขาวิชาการจัดการทรัพยากรมนุษย์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=039-06                                                ">
													สาขาวิชาการขนส่งระหว่างประเทศ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=039-03                                                ">
													สาขาวิชาการเงินการธนาคาร												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=039-02                                                ">
													สาขาวิชาการตลาด												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=039-00                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะวิทยาศาสตร์และเทคโนโลยี</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=083-00                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=083-01                                                ">
													สาขาวิชาวิทยาการคอมพิวเตอร์												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะวิศวกรรมศาสตร์</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=088-05                                                ">
													สาขาวิชาวิศวกรรมเครื่องกล												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=088-03                                                ">
													สาขาวิชาวิศวกรรมอุตสาหการ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=088-07                                                ">
													สาขาวิชาวิศวกรรมโยธา												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=088-10                                                ">
													สาขาวิชาเทคโนโลยีวิศวกรรมอุตสาหการ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=088-00                                                ">
													สำนักคณบดี												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=088-04                                                ">
													สาขาวิชาวิศวกรรมอิเล็กทรอนิกส์และโทรคมนาคม												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=088-02                                                ">
													สาขาวิชาวิศวกรรมคอมพิวเตอร์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=088-06                                                ">
													สาขาวิชาวิศวกรรมไฟฟ้า												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=088-01                                                ">
													หมวดวิชาคณิตศาสตร์และวิทยาศาสตร์สำหรับวิศวกร												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะศิลปศาสตร์</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=096-03                                                ">
													สาขาวิชาการจัดการโรงแรม (นานาชาติ)												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=096-01                                                ">
													สำนักงานคณบดี คณะศิลป์ศาสตร์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=096-04                                                ">
													สาขาวิชาการจัดการท่องเที่ยว												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=096-02                                                ">
													สาขาวิชาการจัดการโรงแรม												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=096-07                                                ">
													สาขาวิชาออกแบบแฟชั่น												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=096-05                                                ">
													สาขาวิชาภาษาไทยสำหรับชาวต่างประเทศ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=096-06                                                ">
													สาขาวิชาภาษาอังกฤษเพื่อการสื่อสาร												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>บัณฑิตวิทยาลัย</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=132-12                                                ">
													สาขาวิศวกรรมโยธา												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-10                                                ">
													สาขาวิชานานาชาติ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-03                                                ">
													สาขาวิชาการจัดการอุตสาหกรรมบริการและการท่องเที่ยว												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-04                                                ">
													สาขาวิชาจิตวิทยา												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-06                                                ">
													สาขาวิชาการจัดการงานวิศวกรรม												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-00                                                ">
													สำนักงานคณบดี												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-07                                                ">
													หลักสูตรบริหารธุรกิจมหาบัณฑิต												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-05                                                ">
													สาขาวิชาจิตวิทยาเพื่อการพัฒนามนุษย์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-09                                                ">
													สาขาวิชาการภาพยนตร์-วีดิทัศน์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-02                                                ">
													สาขาวิชาภูมิสารสนเทศศาสตร์เพื่อการจัดการ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-11                                                ">
													สาขาวิชานโยบายสาธารณะและการจัดการ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=132-08                                                ">
													หลักสูตรรัฐประศาสนศาสตรมหาบัณฑิต												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะสถาปัตยกรรมศาสตร์</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=180-00                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=180-04                                                ">
													สาขาวิชาการออกแบบผลิตภัณฑ์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=180-01                                                ">
													สาขาวิชาสถาปัตยกรรมศาสตร์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=180-02                                                ">
													สาขาวิชาออกแบบภายใน												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=180-03                                                ">
													สาขาวิชาการออกแบบนิเทศศิลป์												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>มหาวิทยาลัยเกษมบัณฑิต</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=353-00                                                ">
													มหาวิทยาลัยเกษมบัณฑิต												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>สำนักวิจัย</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=356-00                                                ">
													สำนักงานสำนักวิจัย												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะจิตวิทยา</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=395-01                                                ">
													สาขาวิชาจิตวิทยา												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=395-00                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>โครงการหลักสูตรบริหารธุรกิจบัณฑิต (หลักสูตรนานาชาติ)</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=722-03                                                ">
													สาขาวิชาคอมพิวเตอร์ธุรกิจ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=722-02                                                ">
													สาขาวิชาการตลาด												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=722-01                                                ">
													สาขาวิชาการจัดการ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=722-00                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>สำนักวิชาศึกษาทั่วไป</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=906-00                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=906-01                                                ">
													ส่วนงานบริหารงาน												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=906-02                                                ">
													ส่วนงานกลุ่มวิชาสังคมศาสตร์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=906-06                                                ">
													ส่วนงานกลุ่มวิชาพลานามัย												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=906-05                                                ">
													ส่วนงานกลุ่มวิชาวิทยาศาสตร์และคณิตศาสตร์												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=906-04                                                ">
													ส่วนงานกลุ่มวิชาภาษา												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=906-03                                                ">
													ส่วนงานกลุ่มวิชามนุษยศาสตร์												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะพยาบาลศาสตร์</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=U-209-02                                                ">
													สาขาวิชาพยาบาล												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=U-209-00                                                ">
													สำนักคณบดี												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=U-209-01                                                ">
													สำนักงานเลขานุการคณะ												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>คณะวิทยาศาสตร์การกีฬา</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=u-29-02                                                ">
													การจัดการกีฬาและนันทนาการเพื่อสุขภาพ												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=u-29-01                                                ">
													วิทยาศาสตร์การกีฬา												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>สถาบันพัฒนาบุคลากรการบิน</span> <i class="icon-arrow"></i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="department.php?dep_code=U-30-02                                                ">
													สาขาวิชาการจัดการอุตสาหกรรมการบิน (หลักสูตรนานาชาติ)												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=U-30-01                                                ">
													สาขาวิชาธุรกิจการบิน												</a>
											</li>


									
											<li>
												<a href="department.php?dep_code=U-30-03                                                ">
													การจัดการการบิน												</a>
											</li>


																		</ul>
									</li>
																	</ul>
							</li>


							<li>
								<a href="javascript:void(0)">
									<div class="item-content">
										<div class="item-media">
											<i class="fa fa-star-o"></i>
										</div>
										<div class="item-inner">
											<span class="title"> ความเชียวชาญ </span><i class="icon-arrow"></i>
										</div>
									</div>
								</a>
								<ul class="sub-menu">
																	<li>
										<a href="javascript:;">
											<span>วิทยาศาสตร์กายภาพและคณิตศาสตร์</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=1">
													คณิตศาสตร์และสถิติ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=2">
													ฟิสิกส์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=3">
													ดาราศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=4">
													วิทยาศาสตร์เกี่ยวกับโลกและอวกาศ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=5">
													ธรณีวิทยา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=6">
													อุทกวิทยา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=7">
													สมุทรศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=8">
													อุตุนิยมวิทยา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=9">
													ฟิสิกส์ของสิ่งแวดล้อม												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>วิทยาศาสตร์การแพทย์</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=10">
													วิทยาศาสตร์การแพทย์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=11">
													แพทยศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=12">
													สาธารณสุข												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=13">
													เทคนิคการแพทย์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=14">
													พยาบาลศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=15">
													ทันตแพทยศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=16">
													สังคมศาสตร์การแพทย์												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>วิทยาศาสตร์เคมีและเภสัช</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=17">
													อนินทรีย์เคมี												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=18">
													อินทรีย์เคมี												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=19">
													ชีวเคมี												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=20">
													เคมีอุตสาหกรรม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=21">
													อาหารเคมี												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=22">
													เคมีโพลิเมอร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=23">
													เคมีวิเคราะห์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=24">
													ปิโตรเคมี												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=25">
													เคมีสิ่งแวดล้อม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=26">
													เคมีเทคนิค												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=27">
													นิวเคลียร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=28">
													เคมีเชิงฟิสิกส์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=29">
													เคมีชีวภาพ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=30">
													เภสัชเคมี												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=31">
													เภสัชวิเคราะห์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=32">
													เภสัชอุตสาหกรรม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=33">
													เภสัชกรรม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=34">
													เภสัชวิทยาและพิษวิทยา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=35">
													เครื่องสำอาง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=36">
													เภสัชเวท												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=37">
													เภสัชชีวภาพ												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>เกษตรศาสตร์และชีววิทยา</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=38">
													ทรัพยากรพืช												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=39">
													การป้องกันกำจัดศัตรูพืช												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=40">
													ทรัพยากรสัตว์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=41">
													ทรัพยากรประมง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=42">
													ทรัพยากรป่าไม้												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=43">
													ทรัพยากรน้ำเพื่อการเกษตรอุตสาหกรรมเกษตร												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=44">
													ระบบเกษตร												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=45">
													ทรัพยากรดิน												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=46">
													ธุรกิจการเกษตร												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=47">
													วิศวกรรมและเครื่องจักรกลการเกษตร												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=48">
													สิ่งแวดล้อมทางการเกษตร												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=49">
													วิทยาศาสตร์ชีวภาพ												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>วิศวกรรมศาสตร์และอุตสาหกรรมวิจัย</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=50">
													พื้นฐานทางวิศวกรรมศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=51">
													วิศวกรรมอุตสาหกรรมวิจัย												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=116">
													วิทยาศาสตร์และเทคโนโลยี												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>ปรัชญา</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=52">
													ปรัชญา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=53">
													ประวัติศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=54">
													โบราณคดี												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=55">
													วรรณคดี												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=56">
													ศิลปกรรม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=57">
													ภาษา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=58">
													สถาปัตยกรรม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=59">
													ศาสนา												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>นิติศาสตร์</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=60">
													กฎหมายมหาชน												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=61">
													กฎหมายเอกชน												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=62">
													กฏหมายอาญา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=63">
													กฎหมายเศรษฐกิจ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=64">
													กฎหมายธุรกิจ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=65">
													กฎหมายระหว่างประเทศ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=66">
													กฎหมายวิธีพิจารณาความ												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>รัฐศาสตร์และรัฐประศาสนศาสตร์</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=67">
													ความสัมพันธ์ระหว่างประเทศ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=68">
													นโยบายศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=69">
													อุดมการณ์ทางการเมือง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=70">
													สถาบันทางการเมือง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=71">
													ชีวิตทางการเมือง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=72">
													สังคมวิทยาการทางการเมือง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=73">
													ระบบการเมือง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=74">
													ทฤษฎีการเมือง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=75">
													รัฐประศาสนศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=76">
													มติสาธารณะ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=77">
													ยุทธศาสตร์เพื่อความมั่นคง												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=78">
													เศรษฐกิจการเมือง												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>เศรษฐศาสตร์</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=79">
													เศรษฐศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=80">
													พาณิชยศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=81">
													บริหารธุรกิจ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=82">
													การบัญชี												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>สังคมวิทยา</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=83">
													สังคมวิทยา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=84">
													ประชากรศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=85">
													มานุษยวิทยา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=86">
													จิตวิทยาสังคม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=87">
													ปัญหาสังคมและสังคมสังเคราะห์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=88">
													อาชญาวิทยา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=89">
													กระบวนการยุติธรรม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=90">
													มนุษย์นิเวศ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=91">
													วิทยาและนิเวศวิทยาสังคม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=92">
													พัฒนาสังคม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=93">
													ภูมิปัญญาท้องถิ่น												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=94">
													ภูมิศาสตร์สังคม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=95">
													การศึกษาความเสมอภาคระหว่างเพศ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=96">
													คติชนวิทยา												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>เทคโนโลยีสารสนเทศและนิเทศศาสตร์</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=97">
													วิทยาการคอมพิวเตอร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=98">
													โทรคมนาคม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=99">
													การสื่อสารด้วยดาวเทียม												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=100">
													การสื่อสารเครือข่าย												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=101">
													การสำรวจและรับรู้จากระยะไกล												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=102">
													ระบบสารสนเทศภูมิศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=103">
													สารสนเทศศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=104">
													นิเทศศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=105">
													บรรณารักษศาสตร์												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=106">
													เทคนิคพิพิธภัณฑ์และภัณฑาคาร												</a>
											</li>


																		</ul>
									</li>
																		<li>
										<a href="javascript:;">
											<span>การศึกษา</span> </i>
										</a>
									<ul class="sub-menu">
                                
											<li>
												<a href="skill.php?skills_id=107">
													พื้นฐานการศึกษา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=108">
													หลักสูตรและการสอน												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=109">
													การวัดและการประเมินผลการศึกษา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=110">
													เทคโนโลยีการศึกษา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=111">
													บริหารการศึกษา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=112">
													จิตวิทยาและการแนะแนวการศึกษา												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=113">
													การศึกษานอกโรงเรียน												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=114">
													การศึกษาพิเศษ												</a>
											</li>


									
											<li>
												<a href="skill.php?skills_id=115">
													ผลการศึกษา												</a>
											</li>


																		</ul>
									</li>
																	</ul>
							</li>


						</ul>










												<div class="navbar-title">
							<span>การจัดการ</span>
						</div>
						<ul class="folders">
							<li>
								<a href="login.php">
									<div class="item-content">
										<div class="item-media">
											<span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-sign-in fa-stack-1x fa-inverse"></i> </span>
										</div>
										<div class="item-inner">
											<span class="title"> เข้าสู่ระบบ </span>
										</div>
									</div>
								</a>
							</li>
						</ul>


						
						<!-- start: CORE FEATURES -->
												<!-- end: MAIN NAVIGATION MENU -->

						<!-- start: DOCUMENTATION BUTTON
						<div class="wrapper">
							<a href="documentation.html" class="button-o">
								<i class="ti-help"></i>
								<span>Documentation</span>
							</a>
						</div>
						end: DOCUMENTATION BUTTON -->
					</nav>
				</div>
			</div>
			<!-- / sidebar -->
			<div class="app-content">
				<!-- start: TOP NAVBAR -->
				<header class="navbar navbar-default navbar-static-top">
					<!-- start: NAVBAR HEADER -->
					<div class="navbar-header">
						<a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
							<i class="ti-align-justify"></i>
						</a>
						<a class="navbar-brand" href="index.php">
							<img src="assets/images/logo.png" alt="K-Research"/>
						</a>
						<a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
							<i class="ti-align-justify"></i>
						</a>
						<a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<i class="ti-view-grid"></i>
						</a>
					</div>
					<!-- end: NAVBAR HEADER -->
					<!-- start: NAVBAR COLLAPSE -->
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-right">
							<!-- start: MESSAGES DROPDOWN -->
							<li class="dropdown">
								<a href class="dropdown-toggle" data-toggle="dropdown">
									<!--<span class="dot-badge partition-red"></span>--> <i class="ti-comment"></i> <span>ประกาศจากระบบ</span>
								</a>
								<ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large">
									<li>
										<span class="dropdown-header"> ประกาศ </span>
									</li>
									<li>
										<div class="drop-down-wrapper ps-container">
											<ul>
																							<li>
													<a href="news_detail.php?news_id=1">
														<div class="clearfix">
															<div class="thread-image">
																<img src="./assets/images/avatar-1.jpg" alt="">
															</div>
															<div class="thread-content">
																<span class="author">Update 1.4.1</span>
																<span class="preview">รายการอัพเดท</span>
																<span class="time">2020-10-29</span>
															</div>
														</div>
													</a>
												</li>
																						</ul>
										</div>
									</li>
								<!--	<li class="view-all">
										<a href="news.php">
											อ่านทั้งหมด
										</a>
									</li> -->
								</ul>
							</li>

							<!-- start: USER OPTIONS DROPDOWN -->
							<li class="dropdown current-user">
								<a href class="dropdown-toggle" data-toggle="dropdown">
									<img src="assets/images/avatar-1.jpg"> <span class="username">
									Guest									<i class="ti-angle-down"></i></i></span>
								</a>
								<ul class="dropdown-menu dropdown-dark">
																	<li>
										<a href="login.php">
											เข้าสู่ระบบ
										</a>
									</li>
																</ul>
							</li>
							<!-- end: USER OPTIONS DROPDOWN -->
						</ul>
						<!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
						<div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<div class="arrow-left"></div>
							<div class="arrow-right"></div>
						</div>
						<!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
					</div>
					<a class="dropdown-off-sidebar" data-toggle-class="app-offsidebar-open" data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">
						&nbsp;
					</a>
					<!-- end: NAVBAR COLLAPSE -->
				</header>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">สรุปงานวิจัยและงานสร้างสรรค์ปีการศึกษา 2564</h1>
									<span class="mainDescription">
									1 มิถุนายน 2564 ถึง 31 พฤษภาคม 2565</span>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>
										<a href="index.php?year=2563"><button type="button" class="btn btn-primary btn-wide btn-scroll btn-scroll-top fa fa-chevron-left">
										<span>2563</span>
										</button></a></span>

																		<span>	<a href="index.php?year=2565"><button type="button" class="btn btn-primary btn-wide btn-scroll btn-scroll-top fa fa-chevron-right">
												<span>2565</span>
										</button></a></span>
																	</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: YOUR CONTENT HERE -->
						<!-- start: FIRST SECTION -->
						<div class="container-fluid container-fullw padding-bottom-10">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-md-7 col-lg-8">
											<div class="panel panel-white no-radius" id="totalmoney">
												<div class="panel-heading border-light">
													<h4 class="panel-title"> จำนวนชิ้นงานวิจัยและงานสร้างสรรค์ </h4>
													<ul class="panel-heading-tabs border-light">

														<li>
															<div class="rate">
																<span class="value">0</span><span class="percentage">ผลงาน</span>
															</div>
														</li>
													</ul>
												</div>
												<div collapse="totalmoney" class="panel-wrapper">
													<div class="panel-body">
														<div class="height-350">
															<canvas id="chart1" class="full-width"></canvas>
															<div class="margin-top-20">
																<div class="inline pull-left">
																	<div id="chart1Legend" class="chart-legend"></div>
																</div>
															</div>
														</div>
													</div>
												</div>

												
												บทความวิจัย : 0 ชิ้น <BR> บทความวิชาการ : 0 ชิ้น <BR> การนำเสนอ : 0 ชิ้น


											</div>
										</div>

							<div class="col-md-5 col-lg-4">
									<div class="panel panel-white no-radius">
										<div class="panel-heading border-bottom">
											<h4 class="panel-title">ความสำเร็จของงานวิจัยและงานสร้างสรรค์</h4>
										</div>
										<div class="panel-body">
											<div class="text-center">
												<span class="mini-pie"> <canvas id="chart3" class="full-width"></canvas> <span>0</span> </span>
												<span class="inline text-large no-wrap">งานวิจัยและงานสร้างสรรค์</span>
											</div>
											<div class="margin-top-20 text-center legend-xs inline">
												<div id="chart3Legend" class="chart-legend"></div>
											</div>
										</div>
										<div class="panel-footer">
											<div class="clearfix padding-5 space5">
												<div class="col-xs-4 text-center no-padding">
													<div class="border-right border-dark">
														<span class="text-bold block text-extra-large">

                              0%</span>
														<span class="text-light">เสร็จสิ้น</span>
													</div>
												</div>
												<div class="col-xs-4 text-center no-padding">
													<div class="border-right border-dark">
														<span class="text-bold block text-extra-large">                              0%</span>
														<span class="text-light">กำลังวิจัย</span>
													</div>
												</div>
												<div class="col-xs-4 text-center no-padding">
													<span class="text-bold block text-extra-large">                              0%</span>
													<span class="text-light">เลยกำหนด</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
						<!-- end: FIRST SECTION -->
<!-- start: SECOND SECTION -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-sm-8">
									<div class="panel panel-white no-radius">
										<div class="panel-heading border-bottom">
											<h4 class="panel-title">งบประมาณ</h4>
										</div>
										<div class="panel-body">
											<canvas id="chart4" class="full-width"></canvas>
											<div class="margin-top-20 padding-bottom-5 inline">
												<div id="chart4Legend" class="chart-legend"></div>
											</div>
										</div>
										<div class="panel-footer">
											<div class="clearfix padding-5 space5">
												<div class="col-xs-6 text-center no-padding">
													<div class="border-right border-dark">
														<span class="text-bold block text-extra-large">0%</span>
														<span class="text-light">งบประมาณภายใน</span>
													</div>
												</div>
												<div class="col-xs-6 text-center no-padding">

														<span class="text-bold block text-extra-large">
                              0
                              %</span>
														<span class="text-light">งบประมาณภายนอก</span>

												</div>

											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-4">
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-white no-radius">
												<div class="panel-body padding-20 text-center">
													<div class="space10">
														<h5 class="text-dark no-margin">งบประมาณทั้งหมด</h5>
														<h2 class="no-margin">0.00<small>฿</small></h2>
														<span class="badge badge-success margin-top-10">0 ผลงาน</span>
													</div>
													<div class="sparkline-4 space10">
														<span ></span>
													</div>
													<span class="text-white-transparent"><i class="fa fa-clock-o"></i> </span>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="panel panel-white no-radius">
												<div class="panel-body padding-20 text-center">
													<div class="space10">
														<h5 class="text-dark no-margin">งบภายใน</h5>
														<h2 class="no-margin">0.00<small>฿</small></h2>
														<span class="badge badge-success margin-top-10">0 ผลงาน</span>
													</div>
													<div class="sparkline-5 space10">
														<span ></span>
													</div>
													<span class="text-white-transparent"><i class="fa fa-clock-o"></i> </span>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="panel panel-white no-radius">
												<div class="panel-body padding-20 text-center">
													<div class="space10">
														<h5 class="text-dark no-margin">งบภายนอก</h5>
														<h2 class="no-margin">0.00<small>฿</small></h2>
														<span class="badge badge-success margin-top-10">0 ผลงาน</span>
													</div>
													<div class="sparkline-6 space10">
														<span ></span>
													</div>
													<span class="text-white-transparent"><i class="fa fa-clock-o"></i></span>
												</div>
											</div>
										</div>
									</div>
									</div>
							</div>
						</div>

						<!-- end: SECOND SECTION -->
						<!-- end: YOUR CONTENT HERE -->
					</div>
				</div>
			</div>

			<footer>
				<div class="footer-inner">
					<div class="pull-left">
						&copy; <span class="current-year"></span><span class="text-bold"> Developer By </span><span>Saharat Ongsuwan</span>
					</div>
					<div class="pull-right">
						<span class="go-top"><i class="ti-angle-up"></i></span>
					</div>
				</div>
			</footer>
			<!-- end: FOOTER -->
			<!-- start: OFF-SIDEBAR -->
			<div id="off-sidebar" class="sidebar">
				<div class="sidebar-wrapper">
					<ul class="nav nav-tabs nav-justified">
						<li class="active">
							<a href="#off-users" aria-controls="off-users" role="tab" data-toggle="tab">
								<i class="ti-comments"></i>
							</a>
						</li>

					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="off-users">
							<div id="users" toggleable active-class="chat-open">
								<div class="users-list">
									<div class="sidebar-content perfect-scrollbar">
										<h5 class="sidebar-title">ผู้พัฒนา</h5>
										<ul class="media-list">
											<li class="media">
												<a href="mailto:saharat.ong@kbu.ac.th">
													<img alt="..." src="assets/images/avatar-2.jpg" class="media-object">
													<div class="media-body">
														<h4 class="media-heading">Saharat Ongsuwan</h4>
														<span> ผู้พัฒนานะบบ KBU Research </span>
													</div>
												</a>
											</li>
											
										</ul>	
									</div>
								</div>					
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end: OFF-SIDEBAR -->
			<!-- start: SETTINGS -->
			<div class="settings panel panel-default hidden-xs hidden-sm" id="settings">
				<button ct-toggle="toggle" data-toggle-class="active" data-toggle-target="#settings" class="btn btn-default">
					<i class="fa fa-spin fa-gear"></i>
				</button>
				<div class="panel-heading">
					ปรับสี
				</div>
				<div class="panel-body">
					<!-- start: THEME SWITCHER -->
					<div class="colors-row setting-box">
						<div class="color-theme theme-1">
							<div class="color-layout">
								<label>
									<input type="radio" name="setting-theme" value="theme-1">
									<span class="ti-check"></span>
									<span class="split header"> <span class="color th-header"></span> <span class="color th-collapse"></span> </span>
									<span class="split"> <span class="color th-sidebar"><i class="element"></i></span> <span class="color th-body"></span> </span>
								</label>
							</div>
						</div>
						<div class="color-theme theme-2">
							<div class="color-layout">
								<label>
									<input type="radio" name="setting-theme" value="theme-2">
									<span class="ti-check"></span>
									<span class="split header"> <span class="color th-header"></span> <span class="color th-collapse"></span> </span>
									<span class="split"> <span class="color th-sidebar"><i class="element"></i></span> <span class="color th-body"></span> </span>
								</label>
							</div>
						</div>
					</div>
					<div class="colors-row setting-box">
						<div class="color-theme theme-3">
							<div class="color-layout">
								<label>
									<input type="radio" name="setting-theme" value="theme-3">
									<span class="ti-check"></span>
									<span class="split header"> <span class="color th-header"></span> <span class="color th-collapse"></span> </span>
									<span class="split"> <span class="color th-sidebar"><i class="element"></i></span> <span class="color th-body"></span> </span>
								</label>
							</div>
						</div>
						<div class="color-theme theme-4">
							<div class="color-layout">
								<label>
									<input type="radio" name="setting-theme" value="theme-4">
									<span class="ti-check"></span>
									<span class="split header"> <span class="color th-header"></span> <span class="color th-collapse"></span> </span>
									<span class="split"> <span class="color th-sidebar"><i class="element"></i></span> <span class="color th-body"></span> </span>
								</label>
							</div>
						</div>
					</div>
					<div class="colors-row setting-box">
						<div class="color-theme theme-5">
							<div class="color-layout">
								<label>
									<input type="radio" name="setting-theme" value="theme-5">
									<span class="ti-check"></span>
									<span class="split header"> <span class="color th-header"></span> <span class="color th-collapse"></span> </span>
									<span class="split"> <span class="color th-sidebar"><i class="element"></i></span> <span class="color th-body"></span> </span>
								</label>
							</div>
						</div>
						<div class="color-theme theme-6">
							<div class="color-layout">
								<label>
									<input type="radio" name="setting-theme" value="theme-6">
									<span class="ti-check"></span>
									<span class="split header"> <span class="color th-header"></span> <span class="color th-collapse"></span> </span>
									<span class="split"> <span class="color th-sidebar"><i class="element"></i></span> <span class="color th-body"></span> </span>
								</label>
							</div>
						</div>
					</div>
					<!-- end: THEME SWITCHER -->
				</div>
			</div>
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/Chart.js/Chart.min.js"></script>
		<script src="vendor/jquery.sparkline/jquery.sparkline.min.js"></script>
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/index.js"></script>
		<script>
		var jsonObject = $.parseJSON('{"labels":["\u0e21\u0e34.\u0e22. 2564","\u0e01.\u0e04. 2564","\u0e2a.\u0e04. 2564","\u0e01.\u0e22. 2564","\u0e15.\u0e04. 2564","\u0e1e.\u0e22. 2564","\u0e18.\u0e04. 2564","\u0e21.\u0e04. 2565","\u0e01.\u0e1e. 2565","\u0e21\u0e35.\u0e04 2565","\u0e40\u0e21.\u0e22 2565","\u0e1e.\u0e04. 2565"],"datasets":[{"label":"\u0e07\u0e32\u0e19\u0e27\u0e34\u0e08\u0e31\u0e22\u0e41\u0e25\u0e30\u0e07\u0e32\u0e19\u0e2a\u0e23\u0e49\u0e32\u0e07\u0e2a\u0e23\u0e23\u0e04\u0e4c","fillColor":"rgba(151,187,205,0.2)","strokeColor":"rgba(151,187,205,1)","pointColor":"rgba(151,187,205,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(151,187,205,1)","data":[0,0,0,0,0,0,0,0,0,0,0,0,0]}]}');
        var jsonObject2 = $.parseJSON('[{"value":0,"color":"#46BFBD","highlight":"#5AD3D1","label":"\u0e40\u0e2a\u0e23\u0e47\u0e08\u0e2a\u0e34\u0e49\u0e19"},{"value":0,"color":"#FDB45C","highlight":"#FFC870","label":"\u0e01\u0e33\u0e25\u0e31\u0e07\u0e27\u0e34\u0e08\u0e31\u0e22"},{"value":0,"color":"#F7464A","highlight":"#FF5A5E","label":"\u0e40\u0e25\u0e22\u0e01\u0e33\u0e2b\u0e19\u0e14\u0e40\u0e2a\u0e23\u0e47\u0e08"}]');
		var jsonObject3 = $.parseJSON('{"labels":["\u0e04\u0e13\u0e30\u0e19\u0e34\u0e15\u0e34\u0e28\u0e32\u0e2a\u0e15\u0e23\u0e4c","\u0e04\u0e13\u0e30\u0e19\u0e34\u0e40\u0e17\u0e28\u0e28\u0e32\u0e2a\u0e15\u0e23\u0e4c","\u0e04\u0e13\u0e30\u0e1a\u0e23\u0e34\u0e2b\u0e32\u0e23\u0e18\u0e38\u0e23\u0e01\u0e34\u0e08","\u0e04\u0e13\u0e30\u0e27\u0e34\u0e17\u0e22\u0e32\u0e28\u0e32\u0e2a\u0e15\u0e23\u0e4c\u0e41\u0e25\u0e30\u0e40\u0e17\u0e04\u0e42\u0e19\u0e42\u0e25\u0e22\u0e35","\u0e04\u0e13\u0e30\u0e27\u0e34\u0e28\u0e27\u0e01\u0e23\u0e23\u0e21\u0e28\u0e32\u0e2a\u0e15\u0e23\u0e4c","\u0e04\u0e13\u0e30\u0e28\u0e34\u0e25\u0e1b\u0e28\u0e32\u0e2a\u0e15\u0e23\u0e4c","\u0e1a\u0e31\u0e13\u0e11\u0e34\u0e15\u0e27\u0e34\u0e17\u0e22\u0e32\u0e25\u0e31\u0e22","\u0e04\u0e13\u0e30\u0e2a\u0e16\u0e32\u0e1b\u0e31\u0e15\u0e22\u0e01\u0e23\u0e23\u0e21\u0e28\u0e32\u0e2a\u0e15\u0e23\u0e4c","\u0e21\u0e2b\u0e32\u0e27\u0e34\u0e17\u0e22\u0e32\u0e25\u0e31\u0e22\u0e40\u0e01\u0e29\u0e21\u0e1a\u0e31\u0e13\u0e11\u0e34\u0e15","\u0e2a\u0e33\u0e19\u0e31\u0e01\u0e27\u0e34\u0e08\u0e31\u0e22","\u0e04\u0e13\u0e30\u0e08\u0e34\u0e15\u0e27\u0e34\u0e17\u0e22\u0e32","\u0e42\u0e04\u0e23\u0e07\u0e01\u0e32\u0e23\u0e2b\u0e25\u0e31\u0e01\u0e2a\u0e39\u0e15\u0e23\u0e1a\u0e23\u0e34\u0e2b\u0e32\u0e23\u0e18\u0e38\u0e23\u0e01\u0e34\u0e08\u0e1a\u0e31\u0e13\u0e11\u0e34\u0e15 (\u0e2b\u0e25\u0e31\u0e01\u0e2a\u0e39\u0e15\u0e23\u0e19\u0e32\u0e19\u0e32\u0e0a\u0e32\u0e15\u0e34)","\u0e2a\u0e33\u0e19\u0e31\u0e01\u0e27\u0e34\u0e0a\u0e32\u0e28\u0e36\u0e01\u0e29\u0e32\u0e17\u0e31\u0e48\u0e27\u0e44\u0e1b","\u0e04\u0e13\u0e30\u0e1e\u0e22\u0e32\u0e1a\u0e32\u0e25\u0e28\u0e32\u0e2a\u0e15\u0e23\u0e4c","\u0e04\u0e13\u0e30\u0e27\u0e34\u0e17\u0e22\u0e32\u0e28\u0e32\u0e2a\u0e15\u0e23\u0e4c\u0e01\u0e32\u0e23\u0e01\u0e35\u0e2c\u0e32","\u0e2a\u0e16\u0e32\u0e1a\u0e31\u0e19\u0e1e\u0e31\u0e12\u0e19\u0e32\u0e1a\u0e38\u0e04\u0e25\u0e32\u0e01\u0e23\u0e01\u0e32\u0e23\u0e1a\u0e34\u0e19"],"datasets":[{"data":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],"label":"\u0e40\u0e07\u0e34\u0e19\u0e20\u0e32\u0e22\u0e43\u0e19","fillColor":"rgba(151,187,205,0.2)","strokeColor":"rgba(151,187,205,1)","pointColor":"rgba(151,187,205,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(151,187,205,1)"},{"data":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],"fillColor":"rgba(220,220,220,0.2)","strokeColor":"rgba(220,220,220,1)","pointColor":"rgba(220,220,220,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(220,220,220,1)","label":"\u0e40\u0e07\u0e34\u0e19\u0e20\u0e32\u0e22\u0e19\u0e2d\u0e01"}]}');
		var jsonObject456 = $.parseJSON('{"tooltipValueLookups":{"names":["\u0e21\u0e34.\u0e22. 2564","\u0e01.\u0e04. 2564","\u0e2a.\u0e04. 2564","\u0e01.\u0e22. 2564","\u0e15.\u0e04. 2564","\u0e1e.\u0e22. 2564","\u0e18.\u0e04. 2564","\u0e21.\u0e04. 2565","\u0e01.\u0e1e. 2565","\u0e21\u0e35.\u0e04 2565","\u0e40\u0e21.\u0e22 2565","\u0e1e.\u0e04. 2565"]},"type":"line","lineColor":"#8e8e93","width":"80%","height":47,"fillColor":"","spotRadius":4,"lineWidth":1,"resize":"true","spotColor":"#ffffff","minSpotColor":"#D9534F","maxSpotColor":"#5CB85C","highlightSpotColor":"#CE4641","highlightLineColor":"#c2c2c5","tooltipFormat":"<span style=\\\"color: {{color}}\\\">&#9679;<\/span> {{offset:names}}: {{y:val}}"}');
		var jsonObject4 = $.parseJSON('[0,0,0,0,0,0,0,0,0,0,0,0]');
		var jsonObject5 = $.parseJSON('[0,0,0,0,0,0,0,0,0,0,0,0]');
		var jsonObject6 = $.parseJSON('[0,0,0,0,0,0,0,0,0,0,0,0]');

			jQuery(document).ready(function() {
				Main.init();
				Index.init(jsonObject,jsonObject2,jsonObject3,jsonObject456,jsonObject4,jsonObject5,jsonObject6);
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
