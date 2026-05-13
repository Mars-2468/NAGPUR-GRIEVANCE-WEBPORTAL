<?php

//22-07-2024 $sql = "SELECT t.count, t.ward_desc, t.cs_desc FROM ( SELECT COUNT(grievance_id) AS count, ward_desc, cs_desc FROM grievances g, cs_mst c, ward_mst cm WHERE g.cat3_id = c.cs_id AND g.ward_id = cm.ward_id GROUP BY ward_desc, cs_desc ) AS t JOIN ( SELECT ward_desc, MAX(count) AS max_count FROM ( SELECT COUNT(grievance_id) AS count, ward_desc, cs_desc FROM grievances g, cs_mst c, ward_mst cm WHERE g.cat3_id = c.cs_id AND g.ward_id = cm.ward_id GROUP BY ward_desc, cs_desc ) AS subquery GROUP BY ward_desc ) AS max_counts ON t.ward_desc = max_counts.ward_desc AND t.count = max_counts.max_count ORDER BY count DESC limit 10;";

if ($fdate != '' && $tdate != '') {
    $sql = "SELECT t.count, t.ward_desc, t.cs_desc FROM (SELECT COUNT(grievance_id) AS count, ward_desc, cs_desc FROM grievances g, cs_mst c, ward_mst cm WHERE g.cat3_id = c.cs_id AND g.ward_id = cm.ward_id AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY ward_desc, cs_desc) AS t,(SELECT ward_desc, MAX(count) AS max_count FROM (SELECT COUNT(grievance_id) AS count, ward_desc, cs_desc FROM grievances g, cs_mst c, ward_mst cm WHERE g.cat3_id = c.cs_id AND g.ward_id = cm.ward_id AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY ward_desc, cs_desc) AS subquery GROUP BY ward_desc) AS max_counts WHERE t.ward_desc = max_counts.ward_desc AND t.count = max_counts.max_count ORDER BY t.count DESC LIMIT 10";
} else {
    $sql = "SELECT t.count, t.ward_desc, t.cs_desc FROM ( SELECT COUNT(grievance_id) AS count, ward_desc, cs_desc FROM grievances g, cs_mst c, ward_mst cm WHERE g.cat3_id = c.cs_id AND g.ward_id = cm.ward_id GROUP BY ward_desc, cs_desc ) AS t JOIN ( SELECT ward_desc, MAX(count) AS max_count FROM ( SELECT COUNT(grievance_id) AS count, ward_desc, cs_desc FROM grievances g, cs_mst c, ward_mst cm WHERE g.cat3_id = c.cs_id AND g.ward_id = cm.ward_id GROUP BY ward_desc, cs_desc ) AS subquery GROUP BY ward_desc ) AS max_counts ON t.ward_desc = max_counts.ward_desc AND t.count = max_counts.max_count ORDER BY count DESC LIMIT 10;";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {

    $values2[] = $row['count'];
    $categories2[] = $row['cs_desc'] . " - " . $row['ward_desc'];
}

$jsonValues2 = json_encode($values2);
$jsonCategories2 = json_encode($categories2);

$sql = "SELECT * from ward_mst order by sortOrder";
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
    $ward_list[$row['ward_id']]['ward_name'] = $row['ward_desc'];
}
//echo $sql;
?>


<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-body text-center">
            <div id="chart2" style="height: 400px;width:100% !important"></div>
        </div>
    </div>
</div>
<script>
    var options = {
        series: [{
            data: <?php echo $jsonValues2; ?>
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
            categories: <?php echo $jsonCategories2; ?>,
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        title: {
            //24-07-2024 text: 'Top 10 Grievance Received Zone Wise',
            text: 'Top 10 Zone : Received Grievances',
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

    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();
</script>