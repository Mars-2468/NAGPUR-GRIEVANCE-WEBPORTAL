
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Grievances', 'Status'],
          // ['Total Resolved',     <?php echo ((int)$data['resolved_within_sla']+(int)$data['resolved_beyond_sla']); ?>],
          ['Completed With In SLA',     <?php echo $data['resolved_within_sla']; ?>],
          ['Completed Beyond SLA',     <?php echo $data['resolved_beyond_sla']; ?>],
          
         
        ]);

        var options = {
          title: 'Grievance Resolved'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);
      }
    </script>
  </head>
  
    <div id="piechart2" style="width: 350px; height: 300px;padding:10px;"></div>
  
