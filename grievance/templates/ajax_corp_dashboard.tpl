{include file='corp_header.tpl'}

{literal}
<style>
.bash_heading {
    border-top: 1px solid #D5DDDF;
    padding: 10px !important;
    background-color: #fff;
    font-weight: bold;
    font-size: 16px;
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
    justify-content: flex-end;
    gap: 10px;
}

@media only screen and (max-width: 600px) {
    .report-btns {
        flex-direction: column;
    }
}
</style>

<!-- Google Charts -->
<script src="https://www.gstatic.com/charts/loader.js"></script>

<script>
let chartsReady = false;
let dashboardCache = {}; // ✅ cache

google.charts.load('current', { packages: ['corechart'] });

google.charts.setOnLoadCallback(function () {
    chartsReady = true;
});

/* ---------------- INIT ---------------- */
$(document).ready(function() {

    loadDashboard('complaints');

    // Bootstrap 5 fix
    $(document).on('shown.bs.tab', '[data-bs-toggle="tab"]', function () {
        triggerCharts();
    });

});

/* ---------------- AJAX LOADER (OPTIMIZED) ---------------- */
function loadDashboard(type) {

    // ✅ Use cache (BIG SPEED BOOST)
    if (dashboardCache[type]) {
        $("#result").html(dashboardCache[type]);
        triggerCharts();
        return;
    }

    $("#loading").show();

    let url = (type === 'origin') 
        ? 'ajax_corp_originwisedashboard.php' 
        : 'ajax_corp_complaint_dashboard.php';

    $.ajax({
        url: url,
        type: "POST",
        success: function(data) {
            $("#loading").hide();
            $("#result").html(data);

            // ✅ store cache
            dashboardCache[type] = data;

            triggerCharts();
        },
        error: function() {
            $("#loading").hide();
            $("#result").html("<p style='color:red'>Failed to load data</p>");
        }
    });
}

/* ---------------- CHART HANDLER ---------------- */
function triggerCharts() {
    if (!chartsReady) return;

    if (typeof drawCorpAllChart === "function") drawCorpAllChart();
    if (typeof drawBeyondSLAChart === "function") drawBeyondSLAChart();
    if (typeof drawWithinSLAChart === "function") drawWithinSLAChart();
}

/* ---------------- OTHER FUNCTIONS ---------------- */

function get_dists(rdmaid) {
    $.post('ajax_getdists.php', { rdmaid }, data => $("#distid").html(data));
}

function get_ulbs(distid) {
    $.post('ajax_getulbs.php', { distid }, data => $("#ulbid").html(data));
}

function fun12(user_type, ulbid) {
    $("#loading").show();

    $.post("ajax_reopened_report.php", { cat_id:0, user_type, ulbid }, function(data) {
        $("#loading").hide();
        $("#result").html(data);
        $("#tabsdata").hide();
    });
}

function get_charts() {
    let report_id = $("#graph_report_id").val();

    $("#loading_graph").show();

    $.post('ajax_get_graphical_reports.php', { report_id }, function(data) {
        $("#loading_graph").hide();
        $("#result_graph").html(data);
        triggerCharts();
    });
}

/* ---------------- TAB SWITCH ---------------- */
function fun1(type) {
    if (type == 1) {
        loadDashboard('complaints');
    } else {
        loadDashboard('origin');
    }
}

/* ---------------- PDF ---------------- */
function downloadPDF() {
    window.location.href = 'corp_user_manual_dept_script.php?download_pdf=true';
}
</script>
{/literal}

<div class="row">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs panel-info" style="background-color: #ccf4ff;">
            
            <li class="nav-item active">
                <a href="#tab_1" data-bs-toggle="tab" onclick="fun1(1)">Complaints</a>
            </li>

            <li class="nav-item">
                <a href="#tab_3" data-bs-toggle="tab" onclick="fun1(3)">Origin Wise</a>
            </li>

            <li class="nav-item ms-auto">
                <div class="report-btns">
                    <a href="corp_Zonalmapreports.php" class="btn btn-info">
                        <i class="fa fa-file-alt"></i> Zonal Map
                    </a>

                    <a href="corp_reports.php" class="btn btn-warning">
                        <i class="far fa-file-alt"></i> Reports
                    </a>

                    <a href="corp_graphical_rep_dashboard.php" class="btn btn-danger">
                        <i class="fa fa-chart-pie"></i> Graph
                    </a>

                    <button class="btn btn-success" onclick="downloadPDF()">
                        <i class="far fa-file-pdf"></i> Manual
                    </button>
                </div>
            </li>

        </ul>
    </div>

    <!-- Loader -->
    <div id="loading" style="display:none; text-align:center;">
        <img src="images/loading.gif"/>
        <h4>Please Wait..</h4>
    </div>

    <!-- Result -->
    <div id="result"></div>

</div>

{include file='corp_footer.tpl'}