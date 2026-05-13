
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Feedback', 'Status'],
          ['Received',     <?php echo $total_feedback_resolved; ?>],
          ['Not Received',      <?php echo $total_feedback_pending; ?>]
        
        ]);

        var options = {
          title: 'Feedback Received'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  
    <div id="piechart" style="width: 500px; height: 400px;"></div>
  
