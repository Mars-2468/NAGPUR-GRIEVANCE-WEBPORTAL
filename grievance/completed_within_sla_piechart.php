
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Grievances', 'Status'],
          // ['Total Resolved',     <?php echo $data[1]['resolved_within_sla']+$data[1]['resolved_beyond_sla']; ?>],
          ['Completed With In SLA',     <?php echo $data[1]['resolved_within_sla']; ?>],
          ['Completed Beyond SLA',     <?php echo $data[1]['resolved_beyond_sla']; ?>],
          
         
        ]);

        var options = {
          title: 'Grievance Resolved'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);
      }
    </script>
  </head>
  
    <div id="piechart2" style="width: 400px; height: 300px;"></div>
  
