{include file='corp_header.tpl'}

{literal}
<style>
    .bash_heading {
        border-top: 1px solid #D5DDDF;
        text-align: left;
        padding: 10px !important;
        background-color: #fff;
        clear: both;
        font-weight: bold;
        font-size: 16px; /* FIXED (was 16x) */
        color: #000;
    }

    .geo_style a {
        padding: 6px;
        color: blue !important;
        font-size: 18px !important;
        font-weight: bold;
    }

    .report-btns {
        display: flex;
        justify-content: end;
        padding-top: 5px;
    }

    @media only screen and (max-width: 600px) {
        .report-btns {
            position: relative;
            right: 0px;
            flex-direction: column;
        }
    }
</style>

<!-- ✅ Google Charts (HTTPS FIX) -->
<script src="https://www.gstatic.com/charts/loader.js"></script>

<script>
let chartsReady = false;

// Load Google Charts ONLY ONCE
google.charts.load('current', { packages: ['corechart'] });

google.charts.setOnLoadCallback(function () {
    chartsReady = true;
});

$(document).ready(function() {

    loadDashboard();

    // ✅ Bootstrap 5 tab fix
    $('button[data-bs-toggle="tab"], a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        if (chartsReady) {
            triggerCharts();
        }
    });

});

// ✅ Common dashboard loader
function loadDashboard() {
    $("#loading").show();
    $("#result").html('');

    $.post('ajax_corp_complaint_dashboard.php', {}, function(data) {
        $("#loading").hide();
        $("#result").html(data);

        // ✅ Render charts after AJAX
        if (chartsReady) {
            triggerCharts();
        } else {
            setTimeout(triggerCharts, 500);
        }
    });
}

// ✅ Call all chart functions safely
function triggerCharts() {
    if (typeof drawCorpAllChart === "function") drawCorpAllChart();
    if (typeof drawBeyondSLAChart === "function") drawBeyondSLAChart();
    if (typeof drawWithinSLAChart === "function") drawWithinSLAChart();
}

// Existing functions (kept clean)

function get_dists(rdmaid) {
    $.post('ajax_getdists.php', { rdmaid: rdmaid }, function(data) {
        $("#distid").html(data);
    });
}

function get_ulbs(distid) {
    $.post('ajax_getulbs.php', { distid: distid }, function(data) {
        $("#ulbid").html(data);
    });
}

function fun12(user_type, ulbid) {
    $.post("ajax_reopened_report.php", {
        cat_id: 0,
        user_type: user_type,
        ulbid: ulbid
    }, function(data) {
        $("#result").html(data);
        $("#result").show();
        $("#tabsdata").hide();
    });
}

function get_charts() {
    var report_id = $("#graph_report_id").val();

    $("#loading_graph").show();
    $("#result_graph").html('');

    $.post('ajax_get_graphical_reports.php', {
        report_id: report_id
    }, function(data) {
        $("#loading_graph").hide();
        $("#result_graph").html(data);

        triggerCharts(); // ✅ important
    });
}

function fun1(app_type_id) {

    $("#loading").show();
    $("#result").html('');

    if (app_type_id == 1) {
        $.post('ajax_corp_complaint_dashboard.php', {}, function(data) {
            $("#loading").hide();
            $("#result").html(data);
            triggerCharts();
        });

    } else if (app_type_id == 3) {
        $.post('ajax_corp_originwisedashboard.php', {}, function(data) {
            $("#loading").hide();
            $("#result").html(data);
            triggerCharts();
        });
    }
}

function downloadPDF() {
    window.location.href = 'corp_user_manual_dept_script.php?download_pdf=true';
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}
</script>
{/literal}

<div class="row">

    <div class="nav-tabs-custom">
		 <ul class="navs nav-tabs panel-info" style="background-color: #ccf4ff;">
            <li class="active nav-item"><a href="#tab_1" data-toggle="tab" aria-expanded="true" onclick="fun1('1')">Complaints</a></li>
           	<li class="nav-item"><a href="#tab_3" data-toggle="tab" aria-expanded="false" onclick="fun1('3')">Origin Wise</a></li>
			<li class="geo_style1 nav-item" style="float:right !important;">
				<div class="report-btns1 d-flex justify-content-between align-items-center">
					<div class="p-1">
						<a href="corp_Zonalmapreports.php" class="btn btn-info"><i class="fa fa-file-alt"></i> Zonal Map Report</a>
					</div>
					<div class="p-1">
						<a href="corp_reports.php" class="btn btn-warning"><i class="far fa-file-alt"></i> Reports</a>
					</div>
					<div class="p-1">
						<a href="corp_graphical_rep_dashboard.php" class="btn btn-danger"><i class="fa fa-chart-pie"></i> Graphical Reports</a>
					</div>
					<div class="p-1">   
						<button class="btn btn-success" onclick="downloadPDF()"><i class="far fa-file-pdf"></i> User Manual</button>
					</div>
				</div>
				<!-- next items -->
			</li>
        </ul>
	
    </div>


    <div id="loading" style="display:none; text-align:center;">
        <div><img src="images/loading.gif"/></div>
        <h4>Please Wait..</h4>
    </div>

    <span id="result"></span>

</div>

{include file='corp_footer.tpl'}