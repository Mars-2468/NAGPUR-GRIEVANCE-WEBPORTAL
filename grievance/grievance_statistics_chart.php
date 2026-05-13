<?php


    //03-06-24 $sql = "SELECT w.ward_id, w.ward_desc, SUM(CASE WHEN g.grievance_status_id = 2 THEN 1 ELSE 0 END) AS count_status_2, SUM(CASE WHEN g.grievance_status_id <> 2 THEN 1 ELSE 0 END) AS count_other FROM grievances g JOIN ward_mst w ON g.ward_id = w.ward_id GROUP BY w.ward_id, w.ward_desc order by w.sortOrder";
    
    //23-07-2024 $sql = "SELECT w.ward_id, w.ward_desc, SUM(CASE WHEN g.grievance_status_id = 2 THEN 1 ELSE 0 END) AS count_status_2, SUM(CASE WHEN g.grievance_status_id IN ('3','6','8','9','12','13') THEN 1 ELSE 0 END) AS count_other FROM grievances g JOIN ward_mst w ON g.ward_id = w.ward_id GROUP BY w.ward_id, w.ward_desc order by w.sortOrder";
    
    if ($fdate != '' && $tdate != '') {
        $sql = "SELECT w.ward_id, w.ward_desc, SUM(CASE WHEN g.grievance_status_id = 2 THEN 1 ELSE 0 END) AS count_status_2, SUM(CASE WHEN g.grievance_status_id IN ('3','6','8','9','12','13') THEN 1 ELSE 0 END) AS count_other, SUM(CASE WHEN g.grievance_status_id IN ('2','3','6','8','9','12','13') THEN 1 ELSE 0 END) AS count_all FROM grievances g JOIN ward_mst w ON g.ward_id = w.ward_id AND DATE(g.date_regd) BETWEEN '$fdate' AND '$tdate' GROUP BY w.ward_id, w.ward_desc order by w.sortOrder";
    } else {
        $sql = "SELECT w.ward_id, w.ward_desc, SUM(CASE WHEN g.grievance_status_id = 2 THEN 1 ELSE 0 END) AS count_status_2, SUM(CASE WHEN g.grievance_status_id IN ('3','6','8','9','12','13') THEN 1 ELSE 0 END) AS count_other, SUM(CASE WHEN g.grievance_status_id IN ('2','3','6','8','9','12','13') THEN 1 ELSE 0 END) AS count_all  FROM grievances g JOIN ward_mst w ON g.ward_id = w.ward_id GROUP BY w.ward_id, w.ward_desc order by w.sortOrder";
    }
    //echo $sql;
    $rs = mysqli_query($conn, $sql);


    ?>
<style>
     #container {
         height: 400px;
     }

     .highcharts-figure,
     .highcharts-data-table table {
         min-width: 310px;
         max-width: 1000;
         margin: 1em auto;
     }

     #datatable {
         font-family: Verdana, sans-serif;
         border-collapse: collapse;
         border: 1px solid #ebebeb;
         margin: 10px auto;
         text-align: center;
         width: 100%;
         max-width: 500px;
     }

     #datatable caption {
         padding: 1em 0;
         font-size: 1.2em;
         color: #555;
     }

     #datatable th {
         font-weight: 600;
         padding: 0.5em;
     }

     #datatable td,
     #datatable th,
     #datatable caption {
         padding: 0.5em;
     }

     #datatable thead tr,
     #datatable tr:nth-child(even) {
         background: #f8f8f8;
     }

     #datatable tr:hover {
         background: #f1f7ff;
     }

     .highcharts-subtitle {
        display: none !important;
     }

     .highcharts-credits,
     .apexcharts-menu-icon,
     .highcharts-a11y-proxy-button {
         display: none !important;
     }
 </style>
 <div class="col-md-12 mb-5">
     <div class="card">
         <div class="card-body">
             <figure class="highcharts-figure">
                 <div id="container"></div>
                 <table id="datatable" style="display:none;">
                     <thead>
                         <tr>
                             <th></th>
                             <th>Received</th>
                             <th>Resolved</th>
                             <th>Pending</th>
                         </tr>
                     </thead>
                     <tbody>

                         <?php $pending = "[";
                            $received = "[";
                            $resolved = "[";
                            $string = "[";
                            $columnNames = array();
                            $total_received = 0;
                            $total_resolved = 0;
                            $total_pending = 0;
                            while ($row = mysqli_fetch_assoc($rs)) {

                                $columnNames[$row['ward_desc']] = $row['ward_desc'];

                                $string .= "'" . $row['ward_desc'] . "',";
                                $received .= "" . $row['count_all'] . ",";
                                $resolved .= "" . $row['count_other'] . ",";
                                $pending .= "" . $row['count_status_2'] . ",";
                                
                                $total_received += $row['count_all'];
                                $total_resolved += $row['count_status_2'];
                                $total_pending += $row['count_other'];

                            ?>
                             <tr>
                                <th><?php echo $row['ward_desc']; ?></th>
                                <td><?php echo $row['count_all']; ?></td>
                                <td><?php echo $row['count_other']; ?></td>
                                <td><?php echo $row['count_status_2']; ?></td>

                             </tr>
                         <?php }
                            $string .= "]"; 
                            $received .= "]"; 
                            $resolved .= "]";
                            $pending .= "]"; ?>



                     </tbody>
                 </table>
             </figure>
         </div>
     </div>

 </div>




 <script>
     Highcharts.setOptions({
         lang: {
             thousandsSep: ' '
         },
         // colors: [ '#1F8A70','#ff0000']
     })
     Highcharts.chart('container', {
         chart: {
             type: 'column',
             zoomType: 'y',
             //backgroundColor:"#FBFAE4"
         },
         title: {
             text: 'Grievance Statistics (Received / Resolved / Pending)'
         },
         subtitle: {
             text: ''
         },
         xAxis: {
             categories: <?php echo str_replace('(', '<br>(', $string); ?>,
             crosshair: true
         },
         yAxis: {
             min: 0,
             title: {
                 text: 'Grievances'
             }
         },
         tooltip: {
             headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                 '<td style="padding:0"><b>{point.y}</b></td></tr>',
             footerFormat: '</table>',
             shared: true,
             useHTML: true
         },
         plotOptions: {
             column: {
                 pointPadding: 0.1,
                 borderWidth: 0
             }
         },
         series: [{
             name: 'Received',
             data: <?php echo $received; ?>,
             color: "#546E7A"

         },{
             name: 'Resolved',
             data: <?php echo $resolved; ?>,
             color: "#1F8A70"

         }, {
             name: 'Pending',
             data: <?php echo $pending; ?>,
             color: "#ff0000"

         }],
         legend: {
             enabled: true
         }
     });
 </script>