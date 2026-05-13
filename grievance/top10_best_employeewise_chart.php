<?php

if ($fdate != '' && $tdate != '') {
    //25-07-204 Dept Name Not Display $sql = "SELECT ag.emp_id,ag.emp_name,ag.total_assigned,COALESCE(rg.total_resolved, 0) AS total_resolved,CASE WHEN ag.total_assigned > 0 THEN ROUND((COALESCE(rg.total_resolved, 0) / ag.total_assigned) * 100, 2)ELSE 0 END AS resolution_percentage FROM (SELECT gt.emp_id, e.emp_name, COUNT(DISTINCT g.grievance_id) AS total_assigned FROM grievances g JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id JOIN emp_mst e ON gt.emp_id = e.emp_id WHERE g.ulbid = '250' AND g.app_type_id = '1' AND g.cat3_id != '0' AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY gt.emp_id, e.emp_name) AS ag LEFT JOIN (SELECT gt.emp_id, COUNT(DISTINCT g.grievance_id) AS total_resolved FROM grievances g JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id WHERE g.ulbid = '250' AND g.app_type_id = '1' AND g.grievance_status_id IN ('3', '8', '9') AND g.sla_status = 1 AND g.cat3_id != '0' AND gt.is_escalated = 0 AND gt.disposal_status != 5 AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY gt.emp_id) AS rg ON ag.emp_id = rg.emp_id ORDER BY resolution_percentage DESC LIMIT 10";
    $sql = "SELECT ag.emp_id,ag.emp_name,ag.dept_desc,ag.total_assigned,COALESCE(rg.total_resolved, 0) AS total_resolved,CASE WHEN ag.total_assigned > 0 THEN ROUND((COALESCE(rg.total_resolved, 0) / ag.total_assigned) * 100, 2) ELSE 0 END AS resolution_percentage FROM (SELECT gt.emp_id, e.emp_name, gt.dept_id, d.dept_desc,COUNT(DISTINCT g.grievance_id) AS total_assigned FROM grievances g JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id JOIN emp_mst e ON gt.emp_id = e.emp_id JOIN dept_mst d ON gt.dept_id = d.dept_id WHERE g.ulbid = '250' AND g.app_type_id = '1' AND g.cat3_id != '0' AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY gt.emp_id, e.emp_name, gt.dept_id, d.dept_desc) AS ag LEFT JOIN (SELECT gt.emp_id, gt.dept_id, COUNT(DISTINCT g.grievance_id) AS total_resolved FROM grievances g JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id WHERE g.ulbid = '250' AND g.app_type_id = '1' AND g.grievance_status_id IN ('3', '8', '9') AND g.sla_status = 1 AND g.cat3_id != '0' AND gt.is_escalated = 0 AND gt.disposal_status != 5 AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY gt.emp_id, gt.dept_id) AS rg ON ag.emp_id = rg.emp_id AND ag.dept_id = rg.dept_id ORDER BY resolution_percentage DESC LIMIT 10";
} else {
    //25-07-204 Dept Name Not Display $sql = "SELECT ag.emp_id,ag.emp_name,ag.total_assigned,COALESCE(rg.total_resolved, 0) AS total_resolved,CASE WHEN ag.total_assigned > 0 THEN ROUND((COALESCE(rg.total_resolved, 0) / ag.total_assigned) * 100, 2)ELSE 0 END AS resolution_percentage FROM (SELECT gt.emp_id, e.emp_name, COUNT(DISTINCT g.grievance_id) AS total_assigned FROM grievances g JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id JOIN emp_mst e ON gt.emp_id = e.emp_id WHERE g.ulbid = '250' AND g.app_type_id = '1' AND g.cat3_id != '0' GROUP BY gt.emp_id, e.emp_name) AS ag LEFT JOIN (SELECT gt.emp_id, COUNT(DISTINCT g.grievance_id) AS total_resolved FROM grievances g JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id WHERE g.ulbid = '250' AND g.app_type_id = '1' AND g.grievance_status_id IN ('3', '8', '9') AND g.sla_status = 1 AND g.cat3_id != '0' AND gt.is_escalated = 0 AND gt.disposal_status != 5 GROUP BY gt.emp_id) AS rg ON ag.emp_id = rg.emp_id ORDER BY resolution_percentage DESC LIMIT 10";
    $sql = "SELECT ag.emp_id,ag.emp_name,ag.dept_desc,ag.total_assigned,COALESCE(rg.total_resolved, 0) AS total_resolved,CASE WHEN ag.total_assigned > 0 THEN ROUND((COALESCE(rg.total_resolved, 0) / ag.total_assigned) * 100, 2) ELSE 0 END AS resolution_percentage FROM (SELECT gt.emp_id, e.emp_name, gt.dept_id, d.dept_desc,COUNT(DISTINCT g.grievance_id) AS total_assigned FROM grievances g JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id JOIN emp_mst e ON gt.emp_id = e.emp_id JOIN dept_mst d ON gt.dept_id = d.dept_id WHERE g.ulbid = '250' AND g.app_type_id = '1' AND g.cat3_id != '0' GROUP BY gt.emp_id, e.emp_name, gt.dept_id, d.dept_desc) AS ag LEFT JOIN (SELECT gt.emp_id, gt.dept_id, COUNT(DISTINCT g.grievance_id) AS total_resolved FROM grievances g JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id WHERE g.ulbid = '250' AND g.app_type_id = '1' AND g.grievance_status_id IN ('3', '8', '9') AND g.sla_status = 1 AND g.cat3_id != '0' AND gt.is_escalated = 0 AND gt.disposal_status != 5 GROUP BY gt.emp_id, gt.dept_id) AS rg ON ag.emp_id = rg.emp_id AND ag.dept_id = rg.dept_id ORDER BY resolution_percentage DESC LIMIT 10";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {

    $values4[] = $row['resolution_percentage'];
    //25-07-2024 Dept Name Not Display $categories4[] = $row['emp_name'] . " - " . $row['total_resolved'];
    $categories4[] = $row['emp_name'] . " - " . $row['dept_desc'] . " - " .  "(". $row['total_resolved']."/".$row['total_assigned'].")";
    //24-07-2024 $categories4[] = $row['emp_name'];
}

$jsonValues4 = json_encode($values4);
$jsonCategories4 = json_encode($categories4);

/*24-07-2024 $sql = "SELECT * from emp_mst";
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
    $ward_list[$row['emp_id']]['emp_code'] = $row['emp_name'];
}*/
//echo $sql;
?>


<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-body text-center">
            <div id="chart4" style="height: 400px;width:100% !important"></div>
        </div>
    </div>
</div>
<script>
    var options = {
        series: [{
            data: <?php echo $jsonValues4; ?>
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
                //25-07-2024 return opt.w.globals.labels[opt.dataPointIndex] + " Resolved Grievances :  " + val + '%';
                return opt.w.globals.labels[opt.dataPointIndex] + "  :  " + val + '%';
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
            categories: <?php echo $jsonCategories4; ?>,
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        title: {
            //24-07-2024 text: 'Top 10 Best Performance Employees',
            text: 'Top 10 Employees : Grievances Resolved Within SLA',
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

    var chart = new ApexCharts(document.querySelector("#chart4"), options);
    chart.render();
</script>