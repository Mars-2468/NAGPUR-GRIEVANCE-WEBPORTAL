<style>
    .highcharts-button,
    .highcharts-contextbutton,
    .highcharts-button-normal {
        display: none !important;
    }

    .card {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1) !important;
        transition: 0.3s;
        overflow: hidden;
    }

    .card:hover {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3) !important;
        transition: 0.3s
    }
</style>
<?php


/// user satifaction
$data['satisfaction'] = 0;


if ($fdate != '' && $tdate != '') {
    $sql = "select COUNT(grievance_id) as count from rating_mst where rating_no >=3 AND DATE(ts) BETWEEN '$fdate' AND '$tdate'";
} else {
    // more than 3 stars users
    $sql = "select COUNT(grievance_id) as count from rating_mst where rating_no >=3";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$satisfied_citizens = $row['count'];

if ($fdate != '' && $tdate != '') {
    $sql = "select COUNT(grievance_id) as count from rating_mst where DATE(ts) BETWEEN '$fdate' AND '$tdate'";
} else {
    // all users
    $sql = "select COUNT(grievance_id) as count from rating_mst";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$total_citizens = $row['count'];


// satisaction

$data['satisfaction'] = $satisfied_citizens / $total_citizens;

$satisaction_percent = $data['satisfaction'] / 100 * 1;

?>
<div class="col-md-3 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="card-title mb-3">
                <h6 style="color:rgb(255,102,102)"><b>Citizen Satisfaction<?php // echo "fdate: ".$fdate." tdate: ".$tdate; ?> </b></h6>
            </div>
            <div id="Satisfaction"></div>


        </div>
    </div>
</div>
<script>
    var data1 = [{
            name: 'Satisfied',
            y: <?php echo $satisfied_citizens; ?>,
            color: "#ff6666",
            dataLabels: {
                enabled: false
            }
        },
        {
            name: 'Not satisfied',
            y: <?php echo $total_citizens - $satisfied_citizens ?>,
            color: "#dddddd",
            dataLabels: {
                enabled: false
            }
        }
    ];

    Highcharts.chart('Satisfaction', {
        chart: {
            plotBorderWidth: 0,
            height: "200px",
            marginTop: 50
        },
        title: {
            text: '<?php echo $satisfied_citizens; ?>/<?php echo $total_citizens; ?>',
            verticalAlign: 'middle'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: 0,
                    style: {
                        fontWeight: 'bold',
                        color: '#fff'
                    }
                },
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '50%'],
                size: "160%"
            }
        },
        series: [{
            type: 'pie',
            name: 'Value',
            innerSize: '75%',
            data: data1
        }],
    });
</script>