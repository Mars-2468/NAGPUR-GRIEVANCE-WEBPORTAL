
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Grievances', 'Status'],
          ['Resolved',     <?php echo $data['total_resolved']; ?>],
          ['Pending',      <?php echo ((int)$data['under_progress_with_sla']+(int)$data['under_progress_beyond_sla']); ?>],
          ['Financial implications',  <?php echo $data['fin']; ?>],
          ['Reopened',    <?php echo $data['reopened_count']; ?>],
          ['Reopened-underprogress',    <?php echo $data['reopened_under_progress']; ?>],
          ['Reopened-completed',    <?php echo $data['reopened_completed']; ?>]
        ]);

        var options = {
          title: 'Grievance Statistics'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

  
    <div id="piechart" style="width: 350px; height: 300px;padding:10px;"></div>
  
