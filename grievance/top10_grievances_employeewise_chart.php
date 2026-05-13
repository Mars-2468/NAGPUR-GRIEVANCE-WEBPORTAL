<?php
// Capture date inputs from the form
$fdate = isset($_REQUEST['f_date']) ? $_REQUEST['f_date'] : '';
$tdate = isset($_REQUEST['t_date']) ? $_REQUEST['t_date'] : '';

//22-07-2024 $sql = "SELECT t.count, t.emp_name, t.cs_desc FROM ( SELECT COUNT(g.grievance_id) AS count, cm.emp_name, c.cs_desc FROM grievances g, grievances_transactions gt, cs_mst c, emp_mst cm WHERE g.grievance_id = gt.grievance_id and g.cat3_id = c.cs_id AND gt.emp_id = cm.emp_id GROUP BY cm.emp_name, c.cs_desc ) AS t JOIN ( SELECT emp_name, MAX(count) AS max_count FROM ( SELECT COUNT(g.grievance_id) AS count, emp_name, cs_desc FROM grievances g, grievances_transactions gt, cs_mst c, emp_mst cm WHERE g.grievance_id = gt.grievance_id and g.cat3_id = c.cs_id AND gt.emp_id = cm.emp_id GROUP BY cm.emp_name, c.cs_desc ) AS subquery GROUP BY emp_name ) AS max_counts ON t.emp_name = max_counts.emp_name AND t.count = max_counts.max_count ORDER BY count DESC limit 10;";

if ($fdate != '' && $tdate != '') {
    $sql = "SELECT t.count,t.emp_name,t.cs_desc FROM (SELECT COUNT(g.grievance_id) AS count, cm.emp_name, c.cs_desc FROM grievances g, grievances_transactions gt, cs_mst c, emp_mst cm WHERE g.grievance_id = gt.grievance_id AND g.cat3_id = c.cs_id AND gt.emp_id = cm.emp_id AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY cm.emp_name, c.cs_desc) AS t JOIN (SELECT emp_name, MAX(count) AS max_count FROM (SELECT COUNT(g.grievance_id) AS count, cm.emp_name, c.cs_desc FROM grievances g, grievances_transactions gt,cs_mst c, emp_mst cm WHERE g.grievance_id = gt.grievance_id AND g.cat3_id = c.cs_id AND gt.emp_id = cm.emp_id AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY cm.emp_name, c.cs_desc) AS subquery GROUP BY emp_name) AS max_counts ON t.emp_name = max_counts.emp_name AND t.count = max_counts.max_count ORDER BY t.count DESC LIMIT 10;";
} else {
    $sql = "SELECT t.count, t.emp_name, t.cs_desc FROM ( SELECT COUNT(g.grievance_id) AS count, cm.emp_name, c.cs_desc FROM grievances g, grievances_transactions gt, cs_mst c, emp_mst cm WHERE g.grievance_id = gt.grievance_id and g.cat3_id = c.cs_id AND gt.emp_id = cm.emp_id GROUP BY cm.emp_name, c.cs_desc ) AS t JOIN ( SELECT emp_name, MAX(count) AS max_count FROM ( SELECT COUNT(g.grievance_id) AS count, emp_name, cs_desc FROM grievances g, grievances_transactions gt, cs_mst c, emp_mst cm WHERE g.grievance_id = gt.grievance_id and g.cat3_id = c.cs_id AND gt.emp_id = cm.emp_id GROUP BY cm.emp_name, c.cs_desc ) AS subquery GROUP BY emp_name ) AS max_counts ON t.emp_name = max_counts.emp_name AND t.count = max_counts.max_count ORDER BY count DESC limit 10;";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {

    $values3[] = $row['count'];
    $categories3[] = $row['cs_desc'] . " - " . $row['emp_name'];
}

$jsonValues3 = json_encode($values3);
$jsonCategories3 = json_encode($categories3);

$sql = "SELECT * from emp_mst";
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
    $ward_list[$row['emp_id']]['emp_code'] = $row['emp_name'];
}
//echo $sql;
?>


<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-body text-center">
            <div id="chart3" style="height: 400px;width:100% !important"></div>
        </div>
    </div>
</div>
<script>
    var options = {
        series: [{
            data: <?php echo $jsonValues3; ?>
        }],
        chart: {
            type: 'bar',
            height: 500,
            width: 550
        },
        plotOptions: {
            bar: {
                barHeight: '100%',
                distributed: true,
                horizontal: true,
                dataLabels: {
                    position: 'bottom'
                },
            }
        },
        colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
            '#f48024', '#69d2e7'
        ],
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#000'],
                fontSize: 9
            },
            formatter: function(val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
            },
            offsetX: 0,
            dropShadow: {
                enabled: false
            }
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        xaxis: {
            categories: <?php echo $jsonCategories3; ?>,
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        title: {
            //24-07-2024 text: 'Top 10 Grievance Received Employee Wise',
            text: 'Top 10 Employees : Received Grievances',
            align: 'center',
            floating: true
        },
        subtitle: {
            text: '',
            align: 'center',
        },
        tooltip: {
            theme: 'dark',
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function() {
                        return ''
                    }
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart3"), options);
    chart.render();
</script>