{include file='header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="all">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .activ_column {
        background-color: #7ac18a;
        color: white !important;
    }

    .activ_column a {
        /*background-color: #54B435;*/
        color: #FFF !important;
        /*text-shadow: 0 0 3px #FFFF;*/
        text-decoration: underline #1C82AD;
    }

    a {
        color: blue;
        text-decoration: none;
    }
    
    .icon{
        position: absolute;
        right: 15px;
        bottom: 15px;
        color: rgba(255,255,255,0.3);
        font-size: 60px;
    }

</style>

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
<script>
    function print_div() {
        var divContents = $("#area").html();
        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
    }

</script>



<script>
    $(document).ready(function() {
        $(".datepick").datepicker({
            maxDate: +2000,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });

    });

</script>
{/literal}




<div class="boxed">
    <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
        <h4>Pending Grievances &#60; 7 and &#62; 30 </h4>        
        <!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
        <p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>
    

    <div id="area">
        <div class="row dashboard-stats">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card bg-success">
                    <div class="card-body p-4">
                        <p class="text-white"><b>Complaints &#60; 7 Days</b></p>
                        <h1 class="countdown_first">
                            <!--01-04-24 <b><a href="grievance_month_inner_report.php?status=1" class="text-white" style="text-decoration: none">{$data['last_week_records']}</a></b> -->
                            <b><a href="grievance_month_inner_report.php?status=109" class="text-white" style="text-decoration: none">{$data['last_week_records']}</a></b>
                        </h1>
                        <div class="icon">
                            <i class="fa fa-file-alt"></i>
                        </div>
                    </div>
<!--
                    <div class="panel-right panel-icon bg-reverse">
                        <p class="size-h1 no-margin countdown_first"><a href="services.php?aptid=1&status=0&user_type={$user_type}&sla=0">{$data[1].total_received}</a></p>                        
                        <p class="text-muted no-margin"><span style="color:#000;"> </span></p>
                    </div>
-->
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card bg-info">
                    <div class="card-body p-4">
                        <p class="text-white"><b>Complaints &#62; 30 Days</b></p>
                        <h1 class="countdown_first">
                            <!--01-04-24 <b><a href="grievance_month_inner_report.php?status=2" class="text-white" style="text-decoration: none">{$data['greater_30days_records']}</a></b> -->
                            <b><a href="grievance_month_inner_report.php?status=110" class="text-white" style="text-decoration: none">{$data['greater_30days_records']}</a></b>
                        </h1>
                        
                        <div class="icon">
                            <i class="fa fa-file-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            


<!--
            <div class="col-lg-6 col-md-6 col-sm-6">
                <section class="panel panel-box">
                    <div class="panel-left panel-icon bg-info">
                        <br>
                        Complaints >30 Days
                    </div>
                    <div class="panel-right panel-icon bg-reverse">
                        <p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=2&user_type={$user_type}">{$data[1].resolved_beyond_sla}</a></p>
                        <p class="size-h1 no-margin countdown_first">
                            <a href="grievance_month_inner_report.php?status=2">{$data['greater_30days_records']}</a>
                        </p>
                        <p class="text-muted no-margin"><span style="color:#000;"> </span></p>
                    </div>
                </section>
            </div>
-->
            
            
        </div>
        <br>
        <div>
        </div>

        <br>




        <div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
        {include file='footer.tpl'}


        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script>
            $(function() {
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true
                });
            });
        </script>
