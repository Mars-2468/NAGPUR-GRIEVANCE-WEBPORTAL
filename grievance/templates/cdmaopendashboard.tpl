{include file='openheader.tpl'}
<!--<meta http-equiv="Refresh" content="60"> -->

{literal}
<style>
	.bash_heading{
	border-top: 1px solid #D5DDDF;
    text-align: left;
    padding: 10px !important;
    background-color: #fff;
	clear:both;
	font-weight:bold;
	font-size:16x;
	color:#000;
	}
	.geo_style a {
	padding:6px;
	color:blue !important;
	font-size:18px !important;
	font-weight:bold;
	}
	
</style>
<script>
	$(document).ready(function(){
		myVar = setInterval("showTime()", 40000);
	});
    
    function showTime()
    {
        //$("#firstlink").hide();
        //$("#firstlink2").hide();
        $.post('timer.php',{},function(data)
        {
			if(data==1)
			{
				$("#loading").css('display','block');
				$("#result").html('');
				$.post('ajax_complaint_opn_dashboard.php',{},function(data)
				{
					
					$("#loading").css('display','none');
					$("#result").html(data);
					
				});
			}
			else (data==2)
			{
				$("#loading").css('display','block');
                $("#result").html('');
                $.post('ajax_service_opn_dashboard.php',{},function(data)
                {
                    $("#loading").css('display','none');
                    $("#result").html(data);
				});
			}
			/*else if(data==3)
			{
				$("#result").html('');
				$("#firstlink").show();
				$("#firstlink2").hide();
			}
			else if(data==4)
			{
				$("#result").html('');
				$("#firstlink").hide();
				$("#firstlink2").show();
			}*/
		});
	}
    
	$(document).ready(function()
	{
	   $.post('ajax_complaint_opn_dashboard.php',{},function(data)
        {
            $("#loading").css('display','none');
            $("#result").html(data);
		});
	});
	
</script>

{/literal}

<div class="row">
	<div>
		<div class="nav-tabs-custom">
			
			<div id="loading" style="display:none; text-align:center;">
				<!-- <div style="text-align:center;"><img src="images/loading.gif"/></div>-->
			    <h4>Please Wait.. </h4>
			</div>
			<span id="result"></span>
			
			<div class="row" id="firstlink" style="display:none;">
			    
				<iframe src="http://epaycdma.telangana.gov.in:8081/CommonDashboard/getStateWiseDashboardAppn.do"
				frameborder="0" 
				marginheight="0" 
				marginwidth="0" 
				width="100%" 
				height="900" 
				scrolling="auto" allow="fullscreen"> 
				</iframe> 
			</div>
            
			<div class="row" id="firstlink2" style="display:none;">
			    <iframe src="http://125.18.179.57:8080/CDMA_TS_Dashboard/dashboard/sroData.do"
				frameborder="0" 
				marginheight="0" 
				marginwidth="0" 
				width="100%" 
				height="900" 
				scrolling="auto"> 
				</iframe> 
			</div>
		</div>	
			
{include file='footer.tpl'}