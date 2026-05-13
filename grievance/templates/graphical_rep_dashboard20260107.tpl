{include file='header_chart.tpl'}
<html>
{literal}

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    /*22-07-2024 $('document').ready(function() {
      $("#loading").css('display', 'block');
      $.get('ajax_chart_dashboard.php', {}, function(data) {
        $("#loading").css('display', 'none');
        $("#dync_content").html(data);
      });
    });*/

    $(document).ready(function() {
      $(".datepicker").datepicker({
        maxDate: +2000,
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
      });

      function loadReports(fdate = '', tdate = '') {
        $("#loading").css('display', 'block');
        $.get('ajax_chart_dashboard.php', {
          f_date: fdate,
          t_date: tdate
        }, function(data) {
          $("#loading").css('display', 'none');
          $("#dync_content").html(data);
        });
      }

      // Load all reports initially
      loadReports();

      $("form").on("submit", function(event) {
        event.preventDefault();
        let fdate = $("input[name='f_date']").val();
        let tdate = $("input[name='t_date']").val();
        loadReports(fdate, tdate);
      });
    });
  </script>

  <style>
    .chart,
    .chart1,
    .chart2 {
      display: inline-block;
      height: 200px;
      width: 200px;
      margin: auto;
    }

    .chart-wrap {
      position: relative;
      display: inline-block;
    }

    .score-stat {
      display: inline-block;
      position: absolute;
      left: 72px;
      top: 76px;
    }

    .chart-wrap span {
      font-size: 18px;
    }

    .chart-wrap span i {
      font-weight: bold;
    }

    .chart-wrap span p {
      display: block;
      font-weight: bold;
      text-align: center;
    }
    
    .halfdonut-progress {
      width: 20rem;
      aspect-ratio: 2/1;
      overflow: hidden;
      position: relative;
      display: grid;
      place-items: end center;
      padding: 0;
      margin: auto;
    }

    .halfdonut-progress::before {
      --fill-hue-min: 0deg;
      --fill-hue-max: 100deg;
      --fill-hue: calc(var(--fill-hue-min) + ((var(--fill-hue-max) - var(--fill-hue-min))) * var(--val));
      --fill-color: hsl(var(--fill-hue) 100% 50%);
      --track-color: hsl(0 0% 50% / .5);

      content: "";
      position: absolute;
      width: 100%;
      top: 0;
      left: 0;
      aspect-ratio: 1/1;
      border-radius: 50%;

      background-image: conic-gradient(from 90deg, var(--fill-color) 180deg, var(--track-color) 0);
      --mask-image: radial-gradient(100% 100%, transparent calc(30% - 1px), black 30%);
      -webkit-mask-image: var(--mask-image);
      mask-image: var(--mask-image);
      transform: rotate(calc(180deg * var(--val)));
      animation: speedometerRotateIn 2s ease;
    }

    @keyframes speedometerRotateIn {
      from {
        transform: rotate(0deg)
      }
    }

    .halfdonut-progress2 {
      width: 20rem;
      aspect-ratio: 2/1;
      overflow: hidden;
      position: relative;
      display: grid;
      place-items: end center;
      padding: 0;
      margin: auto;
    }

    .halfdonut-progress2::before {
      --fill-hue-min: 0deg;
      --fill-hue-max: 100deg;
      --fill-hue: calc(var(--fill-hue-min) + ((var(--fill-hue-max) - var(--fill-hue-min))) * var(--val));
      --fill-color: hsl(var(--fill-hue) 100% 50%);
      --track-color: hsl(0 0% 50% / .5);

      content: "";
      position: absolute;
      width: 100%;
      top: 0;
      left: 0;
      aspect-ratio: 1/1;
      border-radius: 50%;

      background-image: conic-gradient(from 90deg, var(--fill-color) 180deg, var(--track-color) 0);
      --mask-image: radial-gradient(100% 100%, transparent calc(30% - 1px), black 30%);
      -webkit-mask-image: var(--mask-image);
      mask-image: var(--mask-image);
      transform: rotate(calc(180deg * var(--val)));
      animation: speedometerRotateIn 2s ease;
    }

    @keyframes speedometerRotateIn {
      from {
        transform: rotate(0deg)
      }
    }
  </style>
</head>
{/literal}

<body>

  <div class="" style="margin-top: -45px;">
    <form method="POST" class="form-horizontal">
      <div class="boxed">
        <div class="title-bar blue"></div>
        <div class="inner no-radius">
          <div class="col-md-3" style="margin-right:15px;">
            <div class="form-group">
              <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
              <input type="text" class="phone-group form-control datepicker" name="f_date" placeholder="Select Date" autocomplete="off">
            </div>
          </div>
          <div class="col-md-3" style="margin-right:15px;">
            <div class="form-group">
              <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
              <input type="text" class="phone-group form-control datepicker" name="t_date" placeholder="Select Date" autocomplete="off">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group" style="margin-top:31px;">
              <input name="search" type="submit" class="btn btn-success" value="SEARCH">
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="title-bar blue d-flex align-items-center justify-content-between mb-0">
      <h4></h4>
      <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>
  </div>

  <div class="container mt-3">

    <div class="row">

      <div id="dync_content"></div>


      <div id="loading" style="font-size:20px;">
        <center><strong>LOADING..</strong></center>
      </div>


      <div class="col-md-6 mb-3">



      </div>

    </div>

  </div>

  </div>

  </div>

  {literal}


  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/data.js"></script>
  <script src="https://code.highcharts.com/modules/drilldown.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>

  <script src="https://code.highcharts.com/stock/highstock.js"></script>
  <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <script src="https://rendro.github.io/easy-pie-chart/javascripts/jquery.easy-pie-chart.js"></script>
  <script>
    $(function() {
      $('.chart').easyPieChart({
        scaleColor: false,
        lineWidth: 10,
        lineCap: 'round',
        barColor: '#333',
        size: 150,
        animate: 500
      });
    });
  </script>

  {/literal}
  {include file='footer.tpl'}