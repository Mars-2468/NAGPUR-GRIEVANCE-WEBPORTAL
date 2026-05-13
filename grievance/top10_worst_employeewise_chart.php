<?php

if ($fdate != '' && $tdate != '') {
    $sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as total_pending,gt.emp_id,e.emp_name,disposal_status,d.dept_desc FROM grievances g,grievances_transactions gt,emp_mst e,dept_mst d where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.ulbid='250' and 
	g.app_type_id='1' and gt.dept_id = d.dept_id and g.grievance_status_id IN('2') and g.sla_status=2 and gt.disposal_status NOT IN('5','13','11') and g.cat3_id !='0' and DATE(g.date_regd) BETWEEN '$fdate' and '$tdate' GROUP BY gt.emp_id,g.grievance_status_id ORDER BY total_pending DESC LIMIT 10";
} else {
    $sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as total_pending,gt.emp_id,e.emp_name,disposal_status,d.dept_desc FROM grievances g,grievances_transactions gt,emp_mst e,dept_mst d where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.ulbid='250' and 
	g.app_type_id='1' and gt.dept_id = d.dept_id and g.grievance_status_id IN('2') and g.sla_status=2 and gt.disposal_status NOT IN('5','13','11') and g.cat3_id !='0' GROUP BY gt.emp_id,g.grievance_status_id ORDER BY total_pending DESC LIMIT 10";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($rs)) {
    $values5[] = $row['total_pending'];
    $categories5[] = $row['emp_name'] . " - " . $row['dept_desc'];
}

$jsonValues5 = json_encode($values5);
$jsonCategories5 = json_encode($categories5);
?>

<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-body text-center">
            <div id="chart5" style="height: 400px;width:100% !important"></div>
        </div>
    </div>
</div>

<script>
    var options = {
        series: [{
            data: <?php echo $jsonValues5; ?>
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
        colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e', '#f48024', '#69d2e7'],
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#000'],
                fontSize: 9
            },
            formatter: function(val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + " - "  + " :  " + val ;
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
            categories: <?php echo $jsonCategories5; ?>,
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        title: {
            text: 'Bottom 10 Employees : Grievances Pending Beyond SLA',
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

    var chart = new ApexCharts(document.querySelector("#chart5"), options);
    chart.render();
</script>
