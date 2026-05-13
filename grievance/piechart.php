
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Grievances', 'Status'],
          ['Resolved',     <?php echo $total_resolved; ?>],
          ['Pending',      <?php echo $total_under_progress; ?>],
          ['Financial implications',  <?php echo $fin_implications; ?>],
          ['Reopened',    <?php echo $reopen_count; ?>],
          ['Reopened-underprogress',    <?php echo $reopen_under_progress; ?>],
          ['Reopened-completed',    <?php echo $reopened_completed; ?>]
        ]);

        var options = {
          title: 'Grievance Statistics'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

  
    <div id="piechart" style="width: 400px; height: 300px;"></div>
  
