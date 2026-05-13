<?php 

/*$sql ="SELECT count(`grievance_id`) as count , description,cat_id FROM `grievances` g, cs_mst c, category_mst cm where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id group by cat3_id order by count DESC limit 10";
        $rs = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($rs)){

        $values[] = $row['count'];
        $categories[] = $row['description'];

        }*/

/*22-07-2024 $sql = "SELECT t.count, t.description, t.cs_desc FROM ( SELECT COUNT(grievance_id) AS count, description, cs_desc,date_regd FROM grievances g, cs_mst c, category_mst cm WHERE g.cat3_id = c.cs_id AND c.cat_id = cm.cat_id GROUP BY description, cs_desc ) AS t JOIN ( SELECT description, MAX(count) AS max_count FROM ( SELECT COUNT(grievance_id) AS count, description, cs_desc FROM grievances g, cs_mst c, category_mst cm WHERE g.cat3_id = c.cs_id AND c.cat_id = cm.cat_id GROUP BY description, cs_desc ) AS subquery GROUP BY description ) AS max_counts ON t.description = max_counts.description AND t.count = max_counts.max_count ORDER BY count DESC limit 10;";*/

if ($fdate != '' && $tdate != '') {
    $sql = "SELECT t.count, t.description, t.cs_desc FROM (SELECT COUNT(grievance_id) AS count, description, cs_desc FROM grievances g, cs_mst c, category_mst cm WHERE g.cat3_id = c.cs_id AND c.cat_id = cm.cat_id AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY description, cs_desc) AS t,(SELECT description, MAX(count) AS max_count FROM (SELECT COUNT(grievance_id) AS count,description, cs_desc FROM grievances g, cs_mst c, category_mst cm WHERE g.cat3_id = c.cs_id AND c.cat_id = cm.cat_id AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY description, cs_desc) AS subquery GROUP BY description) AS max_counts WHERE t.description = max_counts.description AND t.count = max_counts.max_count ORDER BY t.count DESC LIMIT 10";
} else {
    $sql = "SELECT t.count, t.description, t.cs_desc FROM ( SELECT COUNT(grievance_id) AS count, description, cs_desc,date_regd FROM grievances g, cs_mst c, category_mst cm WHERE g.cat3_id = c.cs_id AND c.cat_id = cm.cat_id GROUP BY description, cs_desc ) AS t JOIN ( SELECT description, MAX(count) AS max_count FROM ( SELECT COUNT(grievance_id) AS count, description, cs_desc FROM grievances g, cs_mst c, category_mst cm WHERE g.cat3_id = c.cs_id AND c.cat_id = cm.cat_id GROUP BY description, cs_desc ) AS subquery GROUP BY description ) AS max_counts ON t.description = max_counts.description AND t.count = max_counts.max_count ORDER BY count DESC limit 10;";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {

    $values[] = $row['count'];
    $categories[] = $row['cs_desc'] . " - " . $row['description'];
}
$jsonValues = json_encode($values);
$jsonCategories = json_encode($categories);


$sql = "SELECT * from ward_mst order by sortOrder";
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
    $ward_list[$row['ward_id']]['ward_name'] = $row['ward_desc'];
}
?>


<style>
    .apexcharts-canvas {
        width: 90% !important;
        font-size: 10px;
        left: 0px;
        position: absolute;
    }

    .apexcharts-legend-text,
    .apexcharts-legend-marker {
        display: none !important;
    }
</style>
<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-body text-center">
            <div id="chart" style="height: 400px;width:100% !important"></div>
        </div>
    </div>
</div>
<script>
    var options = {
        series: [{
            data: <?php echo $jsonValues; ?>
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
            categories: <?php echo $jsonCategories; ?>,
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        title: {
            //24-07-2024 text: 'Top 10 Grievance Received Department Wise',
            text: 'Top 10 Departments : Received Grievances',
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

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>