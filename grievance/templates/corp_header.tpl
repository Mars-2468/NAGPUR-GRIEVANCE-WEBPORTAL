<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<html lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="REGISTER COMPLAINT / SERVICE,  Trade License , Water tax payment , Dharani Citizen Registration , e-office , Swachta App Statistics, Application Management, E-News, App Masters, Council ,Social Connect, Important Contacts, Media Coverage, Notifications, Smart Ideas Box, Citizen buddy,  Online Water Tap Application , Online Trade Application, Online Advertisement Application, Property Tax Self Assessment, Property Tax Calculator, Municipal Council" />
	<link rel="icon" href="http://localhost:8081/grievance/images/G20.png" type="image/x-icon">
	<title>Grievance Redressal System </title>
	<link rel="stylesheet" type="text/css" href="css/corp_styles.css"><!-- Tempalet Skeleton CSS -->
	<link rel="stylesheet" type="text/css" href="assets/pickers/daterange-picker/daterangepicker-bs3.css" />
	
   <!-- Bootstrap CSS -->
    <link href="css/bootstrap-fte.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="css/bootstrap-datepicker-oozz.min.css">
	
    <!-- jQuery -->
    <script src="js/jquery-tso.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	
	<script src="js/modernizr.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/fontawesome/css/fontawesome.min.css">
	
	
	<link rel="stylesheet" href="css/jquery-oozot.dataTables.min.css">
	
	<link rel="stylesheet" href="css/fontawesome/css/all.css">
	
	{literal}
	<script language="javascript">
		function printdiv(printpage) {
			var headstr = "<html><head><title></title></head><body>";
			var footstr = "</body>";
			var newstr = document.all.item(printpage).innerHTML;
			var oldstr = document.body.innerHTML;
			document.body.innerHTML = headstr + newstr + footstr;
			window.print();
			document.body.innerHTML = oldstr;
			return false;
		}
	</script>
	<script language='javascript'>
		var tableToExcel = (function() {
			var uri = 'data:application/vnd.ms-excel;base64,',
				template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
				base64 = function(s) {
					return window.btoa(unescape(encodeURIComponent(s)))
				},
				format = function(s, c) {
					return s.replace(/{(\w+)}/g, function(m, p) {
						return c[p];
					})
				}
			return function(table, name) {
				if (!table.nodeType) table = document.getElementById(table)
				var ctx = {
					worksheet: name || 'Worksheet',
					table: table.innerHTML
				}
				window.location.href = uri + base64(format(template, ctx))
			}
		})()
	</script>

	<style>
		.sidebar .menu li a {
			text-decoration: none !important;
		}
		

table thead tr th {
    background-color: #2c3e50 !important;
    color: #fff; /* optional for readability */
}
</style>
	<style>
		.ui-datepicker-title {
			color: #000;
		}

		.header-bar {
			padding-top: 0px !important;
		}

		.fa-android:before {
			font-family: 'FontAwesome' !important;
		}

		@media only screen and (max-width: 784px) {
			img {
				width: 100%;
			}
		}

		@media print {
			a[href]:after {
				content: none !important;
			}
		}
	</style>
	<script type="text/javascript" language="javascript" class="init">
		$(document).ready(function() {
			//$('#data-table').DataTable();

		});
	</script>
	{/literal}
</head>


<body>

	<section class="content">

		<!-- Sidebar Start -->
		<div class="sidebar">

			<div class="responsive-menu">
				<a href="#"><i class="fa fa-bars"></i></a>
			</div>
			<!-- Sidebar User Profile End -->

			<ul class="menu"><!-- dpms.php-->

				<li class=" pink"><a href="ajax_corp_dashboard.php"><span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Dashboard</span></a></li>

				{foreach from=$services item=row key=service_type}
				<li class="parent marine">
					<a href='#'>
						<span class="menu-icon"><i class="icon-large {$main_icons[$service_type].main_icon}"></i></span>
						<span class="menu-text">{$service_type}</span></a>
					</a>
					<ul class="child">
						<li class="nav-header"></li>
						{foreach from=$row item=service_name key=service_id}
						{if $service_id neq 'category3_mst'}
						<li><a href="{$service_id}.php"><span>{$service_name}</span></a></li>
						{/if}
						{/foreach}
					</ul>
				</li>
				{/foreach}
					
				<li class=" pink"><a href="logout.php"><span class="menu-icon"><i class="fa fa-power-off"></i></span><span class="menu-text">Logout</span></a></li>
			</ul>
			<!-- Menu End 
			<div style="color:#0054a6;">Powered by - VMax</div>-->
		</div>
		<!-- Sidebar End -->

		<div class="content-liquid-full">
			<div class="container">

				<!-- Header Bar Start -->
				<div class="row header-bar m-b20" style="display:flex;flex-wrap:wrap;align-items:center;">
				<div class="col-md-6">
						<img src="{$banner}" />
					</div>
					<div class="col-md-6">
						{if $uid eq 'mepma'}
						<img src="images/mepma_Street.png" style="margin-left:auto;">
						{/if}
					</div>
				</div>

				<ul class="breadcrumbs m-b20">
					<div style="display:flex; justify-content:space-between;align-items:center">
						<div>
							<div style="display:flex; justify-content:space-between;align-items:center">
								<div>
								
									<li><a href="ajax_corp_dashboard.php"><i class="fa fa-home"></i></a></li>
									
								</div>
								<div>
								Welcome : <span class="badge badge-primary p-2">Corporator</span> {$smarty.session.user_name}    
								</div>
								
								<div>
								 &nbsp;&nbsp;<span class="badge badge-primary p-2">Zone</span> : {$smarty.session.zone_name}  
								</div>
								
								<div>
								&nbsp;&nbsp;<span class="badge badge-primary p-2">Ward</span> : {$smarty.session.ward_name}  
								</div>
							</div>
						</div>	

						<div>
							<div style="display:flex; justify-content:space-between;align-items:space-between">
							
								<div>
									<li>
										
										<a href="corp_warning_notice.php" style="text-decoration:none">
											<b>Warning Notice : <span style="font-size:14px;margin-right:0px;font-weight:bold;color:#0a0a0a;">{$smarty.session.warning_id}</span> (<span class="menu-icon"><i class="fa fa-bell" style="color:orange;{$notice_color};font-size:14px;margin-right:0px;"></i></span>)</b>
										</a>
										
										<a href="corp_show_cause_notice.php" style="text-decoration:none">
											<b>Show Cause Notice : <span style="font-size:14px;margin-right:0px;font-weight:bold;color:#0a0a0a;">{$smarty.session.showcause_id}</span> (<span class="menu-icon"><i class="fa fa-exclamation-triangle" style="color:red;{$notice_color};font-size:14px;margin-right:0px;"></i></span>)</b>
										</a>
									</li>
								</div>
								
							</div>

						</div>						
					</div>
				</ul>
				<!-- Header Bar End -->