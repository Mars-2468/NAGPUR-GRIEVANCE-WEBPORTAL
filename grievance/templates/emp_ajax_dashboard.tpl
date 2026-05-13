{include file='header.tpl'}

{literal}
<style>
    .bash_heading {
        border-top: 1px solid #D5DDDF;
        text-align: left;
        padding: 10px !important;
        background-color: #fff;
        clear: both;
        font-weight: bold;
        font-size: 16x;
        color: #000;
    }

    .geo_style a {
        padding: 6px;
        color: blue !important;
        font-size: 18px !important;
        font-weight: bold;
    }

    .report-btns {
        /* position: absolute; */
		display:flex;
		justify-content:end;
        right: 20px;
        padding-top: 5px;
    }


    @media only screen and (max-width: 600px) {
        .report-btns {
            position: relative;
            right: 0px;
            display: flex;
            flex-direction: column;
        }
    }
</style>


<script>
    $(document).ready(function() {

        var user_type = $("#user_type").val();

        //alert(user_type);
        $("#loading").css('display', 'block');
        if (user_type == 'M') {
            $.post('ajax_complaint_mepmadashboard.php', {}, function(data) {
                //alert(data);
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        } else if (user_type == 'CS') {
            $.post('ajax_complaint_supervisordashboard.php', {}, function(data) {
                //alert(data);
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        } else if (user_type == 'C') {
            $.post('ajax_complaint_callcenterdashboard.php', {}, function(data) {
                //alert(data);
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        } else if (user_type == 'AG') {

            $.post('ajax_complaint_agentdashboard.php', {}, function(data) {
                //alert(data);
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        } else {

            $.post('ajax_complaint_dashboard.php', {}, function(data) {
                //alert(data);
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        }
    });

    function get_dists(rdmaid) {
        $.post('ajax_getdists.php', {
            rdmaid: rdmaid
        }, function(data) {
            $("#distid").html(data);
        });
    }


    function get_ulbs(distid) {
        $.post('ajax_getulbs.php', {
            distid: distid
        }, function(data) {
            $("#ulbid").html(data);
        });
    }

    function fun12(user_type, ulbid) {


        $.post("ajax_reopened_report.php", {
            cat_id: 0,
            user_type: user_type,
            ulbid: ulbid
        }, function(data) {
            //alert(data);
            $("#result").html(data);
            $("#result").css('display', 'block');
            $("#tabsdata").css('display', 'none');
        });
    }


    function get_charts() {

        var report_id = $("#graph_report_id").val();
        $("#loading_graph").css('display', 'block');
        $("#result_graph").html('');


        $.post('ajax_get_graphical_reports.php', {
            report_id: report_id
        }, function(data) {

            $("#loading_graph").css('display', 'none');
            $("#result_graph").html(data);
        });
    }

    function fun1(app_type_id) {

        if (app_type_id == 1) {
            $("#loading").css('display', 'block');
            $("#result").html('');
            $.post('ajax_complaint_dashboard.php', {}, function(data) {
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        } else if (app_type_id == 2) {

            $("#loading").css('display', 'block');
            $("#result").html('');
            $.post('ajax_graphical_reports.php', {}, function(data) {
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        } else if (app_type_id == 3) {

            $("#loading").css('display', 'block');
            $("#result").html('');
            $.post('ajax_originwisedashboard.php', {}, function(data) {
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        } else if (app_type_id == 4) {
            //alert();
            $("#loading").css('display', 'block');
            $("#result").html('');
            $.post('ajax_total_dashboard.php', {}, function(data) {
                $("#loading").css('display', 'none');
                $("#result").html(data);
            });
        }
    }

    function downloadPDF() {
        // Redirect to the PHP script to trigger download
        window.location.href = 'user_manual_dept_script.php?download_pdf=true';

        // Refresh the current page after a short delay
        setTimeout(function() {
            window.location.reload();
        }, 1000); // 1000 milliseconds = 1 second
    }
</script>
<script type="text/javascript" src="http://www.gstatic.com/charts/loader.js"></script>

{/literal}

{if $user_type eq 'A' || $user_type eq 'U' || $user_type eq 'E' || $user_type eq 'R' || $user_type eq 'M' || $user_type eq 'CS' || $user_type eq 'C' || $user_type eq 'AG'}

<div class="row">
  <!--   {if $user_type eq 'U' }

    <div class="report-btns">
        <a href="Zonalmapreports.php" class="btn btn-info p-1"><i class="fa fa-file-alt"></i> Zonal Map Report</a>

        <a href="reports.php" class="btn btn-warning p-1"><i class="far fa-file-alt"></i> Reports</a>

        <a href="graphical_rep_dashboard.php" class="btn btn-danger p-1"><i class="fa fa-chart-pie"></i> Graphical Reports</a>
        
        <button class="btn btn-success p-1" onclick="downloadPDF()"><i class="fa fa-file-pdf-o"></i> User Manual</button>
		
        <button class="btn btn-success p-1" onclick="downloadPDF()"><i class="far fa-file-pdf"></i> User Manual</button>
    </div>

    {/if}-->

    {if $user_type eq 'E'}

    <div class="report-btns">


        {if 'reports'|in_array:$assigned_services}
        {if $num_rows_dept_map gt 0}
        <a href="ajax_dashboard_dept.php" class="btn btn-info"><i class="fas fa-tachometer-alt"></i> Dept Dashboard</a>
        {/if}
		{if $smarty.session.hod_status eq 1}
		
			<a href="Zonalmapreports.php" class="btn btn-primary"><i class="fa fa-file-alt"></i> Zonal Map Report</a>

		{/if}

        {if $num_rows_ward_map gt 0}
        <a href="ajax_dashboard_zone.php" class="btn btn-info"><i class="fas fa-tachometer-alt"></i>Zone Dashboard</a>
        {/if}
        {if $num_rows_dept_map gt 0}
        <a href="reports.php" class="btn btn-warning"><i class="fa fa-file-alt"></i> Reports</a>
        {/if}
        <button class="btn btn-success" onclick="downloadPDF()"><i class="far fa-file-pdf"></i> User Manual</button>
        {/if}


    </div>

    {/if}
    <div class="nav-tabs-custom">
        <ul class="navs nav-tabs panel-info" style="background-color: #ccf4ff;">
            <li class="active nav-item"><a href="#tab_1" data-toggle="tab" aria-expanded="true" onclick="fun1('1')">Complaints</a></li>
            {if $uid neq 'mepma'}
            {if $user_type neq 'C' && $user_type neq 'AG' && $user_type neq 'CS'}
            <!--<li class="nav-item"><a href="#tab_2" data-toggle="tab" aria-expanded="false" onclick="fun1('2')">Graphical Reports</a></li>-->
            <li class="nav-item"><a href="#tab_3" data-toggle="tab" aria-expanded="false" onclick="fun1('3')">Origin Wise</a></li>
            <!--<li class="nav-item"><a href="#" data-toggle="tab" aria-expanded="false" onclick="fun12('{$user_type}','{$ulb}')">Re-opened report</a></li>
				<li class="nav-item"><a href="old_dashboard.php">Old Dashboard</a></li>-->
            {/if}
            {/if}

            {if $uid eq 'mepma'}
            <!--<li class="geo_style nav-item" style="float:right !important;"><a href="http://tsurbandashboard.in/ulb_basic_info.php?sub_cat_id=575" target="_blank">Geographical Dashboard</a></li>-->
            {/if}
            {if $user_type eq 'A'}

            <!--<li class="nav-item"><a href="#tab_4" data-toggle="tab" aria-expanded="false" onclick="fun1('4')">Total </a></li>-->

            {/if}

<li class="geo_style1 nav-item" style="float:right !important;">


	{if $user_type eq 'U' }
		<div class="report-btns1 d-flex justify-content-between align-items-center">
			<div class="p-1">
				<a href="Zonalmapreports.php" class="btn btn-info"><i class="fa fa-file-alt"></i> Zonal Map Report</a>
			</div>
			<div class="p-1">
				<a href="reports.php" class="btn btn-warning"><i class="far fa-file-alt"></i> Reports</a>
			</div>
			<div class="p-1">
				<a href="graphical_rep_dashboard.php" class="btn btn-danger"><i class="fa fa-chart-pie"></i> Graphical Reports</a>
			</div>
			<div class="p-1">   
				<button class="btn btn-success" onclick="downloadPDF()"><i class="far fa-file-pdf"></i> User Manual</button>
			</div>
		</div>

    {/if}
	
	<!-- next items -->
</li>



        </ul>
        </div>

        <div id="loading" style="display:none; text-align:center;">
            <!-- <div style="text-align:center;"><img src="images/loading.gif"/></div>-->
            <h4>Please Wait.. </h4>

        </div>



        <span id="result"></span>
        <input type="hidden" id="user_type" value="{$user_type}">




        {if $tanker_enable_status eq '1' && $user_type eq 'U'}


        <div class="boxed">

            <!-- Title Bart Start -->
            <div class="title-bar blue">
                <h4>Tanker Request Status</h4>

            </div>
            <!-- Title Bart End -->
            <div class="inner no-radius" style="background-color:#F2F7FF;">

                <div class="col-md-12">
                    <div class="col-sm-3">
                        <section class="panel panel-box">
                            <div class="panel-top bg-success">
                                <div class="divider divider"></div>
                                <i class="size-h1"><img src="images/tanker_icon4.png" /></i>
                                <div class="divider divider"></div>
                            </div>
                            <div class="list-justified-container">
                                <ul class="list-justified text-center">
                                    <li>
                                        <p class="size-h1" style="color:#000;">{if $tankertot eq ''}0{else}{$tankertot}{/if}</p>
                                        <p class="text-muted" style="color:#000;">Received</p>
                                    </li>

                                </ul>
                            </div>
                        </section>
                    </div>

                    <div class="col-sm-3">
                        <section class="panel panel-box">
                            <div class="panel-top  bg-danger">
                                <div class="divider divider"></div>
                                <i class="size-h1"><img src="images/tanker_icon2.png" /></i>
                                <div class="divider divider"></div>
                            </div>
                            <div class="list-justified-container">
                                <ul class="list-justified text-center">
                                    <li>
                                        <p class="size-h1" style="color:#000;">{if $tankers_list[0] eq ''}0{else}{$tankers_list[0]}{/if}</p>
                                        <p class="text-muted" style="color:#000;">Pending</p>
                                    </li>

                                </ul>
                            </div>
                        </section>
                    </div>

                    <div class="col-sm-3">
                        <section class="panel panel-box">
                            <div class="panel-top bg-lovender">
                                <div class="divider divider"></div>
                                <i class="size-h1"><img src="images/tanker_icon3.png" /></i>
                                <div class="divider divider"></div>
                            </div>
                            <div class="list-justified-container">
                                <ul class="list-justified text-center">
                                    <li>
                                        <p class="size-h1" style="color:#000;">{if $tankers_list[1] eq ''}0{else}{$tankers_list[1]}{/if}</p>
                                        <p class="text-muted" style="color:#000;">Assigned</p>
                                    </li>

                                </ul>
                            </div>
                        </section>
                    </div>

                    <div class="col-sm-3">
                        <section class="panel panel-box">
                            <div class="panel-top bg-vimeo">
                                <div class="divider divider"></div>
                                <i class="size-h1"><img src="images/tanker_icon.png" /></i>
                                <div class="divider divider"></div>
                            </div>
                            <div class="list-justified-container">
                                <ul class="list-justified text-center">
                                    <li>
                                        <p class="size-h1" style="color:#000;">{if $tankers_list[2] eq ''}0{else}{$tankers_list[2]}{/if}</p>
                                        <p class="text-muted" style="color:#000;">Completed</p>
                                    </li>

                                </ul>
                            </div>
                        </section>
                    </div>




                </div>


            </div>

        </div>

        {/if}

        <br><br><br>
        {/if}
        <div id="myModal" class="modal fade mt-5">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Collect Property Tax</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Now collect Property Tax from Citizen Service Center of your ULB. </p>
                        <div class="row p-3 justify-content-center" style="background-color:#8efaff; ">
                            Click on below link to collect and generate Report
                            <br>
                            <a href="https://cdma.cgg.gov.in/CDMA_ARBS" style="color:#105ce7;" target="_blank">https://cdma.cgg.gov.in/CDMA_ARBS</a>
                        </div>
                        <br>
                        For login information <br>
                        please call <strong> CGG Support number <span style="color:red;">04023120410</span></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{include file='footer.tpl'}