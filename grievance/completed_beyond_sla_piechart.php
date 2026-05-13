
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Grievances', 'Status'],
		  ['Total Received',     <?php echo $data[1]['total_received']; ?>],
          ['Completed With In SLA',     <?php echo $data[1]['resolved_beyond_sla']; ?>],
          
         
        ]);

        var options = {
          title: 'Grievance Resolved Beyond SLA'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart3'));

        chart.draw(data, options);
      }
    </script>
  </head>
  
    <div id="piechart3" style="width: 500px; height: 400px;"></div>
  
