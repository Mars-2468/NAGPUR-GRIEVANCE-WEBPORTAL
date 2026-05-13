<?php

// Grievances resolved percentage
if ($fdate != '' && $tdate != '') {
    $sql = "select * from grievances where DATE(date_regd) BETWEEN '$fdate' AND '$tdate' ";
} else {
    $sql = "select * from grievances";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
$nr = mysqli_num_rows($rs);
$data['total_grievances'] = $nr;
// Resolved grievances
if ($fdate != '' && $tdate != '') {
    $sql = "select * from grievances where grievance_status_id IN ('3','6','8','9','12') AND DATE(date_regd) BETWEEN '$fdate' AND '$tdate'";
} else {
    //03-06-2024 $sql ="select * from grievances where grievance_status_id=9";
    $sql = "select * from grievances where grievance_status_id IN ('3','6','8','9','12')";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
$nr = mysqli_num_rows($rs);
$data['total_grievances_resolved'] = $nr;

$data['gr_resolved_percent'] = round($data['total_grievances_resolved'] / $data['total_grievances'] * 100);
$percent  = $data['gr_resolved_percent'] / 100 * 1;
?>
<div class="col-md-3 mb-4">
    <div class="card" style="box-shadow:0px 0px 10px rgba(0,0,0,0.2)">
        <div class="card-body">
            <div class="card-title mb-3">
                <h6 style="color:rgb(240,204,12)"><b>% Of Grievances Resolved</b> </h6>
            </div>
            <div id="gr_resolved_percent"></div>
        </div>
    </div>
</div>

<script>
    var data = [{
            name: 'Resolved',
            y: <?php echo $data['total_grievances_resolved']; ?>,
            color: "#F0CC0C",
            dataLabels: {
                enabled: false
            }
        },
        {
            name: 'Pending',
            y: <?php echo $data['total_grievances'] - $data['total_grievances_resolved']; ?>,
            color: "#dddddd",
            dataLabels: {
                enabled: false
            }
        }
    ];

    Highcharts.chart('gr_resolved_percent', {
        chart: {
            plotBorderWidth: 0,
            height: "200px",
            marginTop: 50
        },
        title: {
            text: '<?php echo round($data['total_grievances_resolved'] / $data['total_grievances'] * 100, 0); ?> %',
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
            data: data
        }]
    });
</script>