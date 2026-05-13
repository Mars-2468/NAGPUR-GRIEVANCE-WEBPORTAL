<?php
/// user satifaction
$data['satisfaction'] = 0;

if ($fdate != '' && $tdate != '') {
    $sql = "select COUNT(grievance_id) as count from rating_mst where DATE(ts) BETWEEN '$fdate' AND '$tdate'";
} else {
    // all feedback users
    $sql = "select COUNT(grievance_id) as count from rating_mst";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$total_ratings = $row['count'];

// total resolved complaints

if ($fdate != '' && $tdate != '') {
    $sql = "select COUNT(grievance_id) as count from grievances where grievance_status_id IN ('3','6','8','9','12','13') AND DATE(date_regd) BETWEEN '$fdate' AND '$tdate'";
} else {
    //03-06-24 $sql = "select COUNT(grievance_id) as count from grievances where grievance_status_id=9";
    $sql = "select COUNT(grievance_id) as count from grievances where grievance_status_id IN ('3','6','8','9','12','13')";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$total_complaints_resolved = $row['count'];


// satisaction

$data['total_feedback_avg'] = $total_ratings / $total_complaints_resolved;

$avg_feedback_received = $data['total_feedback_avg'] / 100 * 1;



?>
<div class="col-md-3 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="card-title mb-3">
                <h6 style="color:rgb(44,152,231)"><b>Feedback Received</b> </h6>
            </div>
            <div id="feedback"></div>
        </div>
    </div>
</div>
<script>
    var data = [{
            name: 'Feedback received',
            y: <?php echo $total_ratings; ?>,
            color: "#2C98E7",
            dataLabels: {
                enabled: false
            }
        },
        {
            name: 'Not received',
            y: <?php echo $total_complaints_resolved; ?>,
            color: "#dddddd",
            dataLabels: {
                enabled: false
            }
        }
    ];

    Highcharts.chart('feedback', {
        chart: {
            plotBorderWidth: 0,
            height: "200px",
            marginTop: 50
        },
        title: {
            text: '<?php echo $total_ratings; ?> / <?php echo $total_complaints_resolved; ?>',
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