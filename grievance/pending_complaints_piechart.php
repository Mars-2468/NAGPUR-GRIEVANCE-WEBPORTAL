<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Grievances', 'Status'],
      //03-07-2024 ['Other Grievancs', <?php //echo $data[1]['total_received'] - $total_under_progress; ?>],
      ['Resolved Grievancs', <?php echo $data[1]['total_received'] - $total_under_progress; ?>],
      ['Grievancs Pending', <?php echo $total_under_progress; ?>],

    ]);

    var options = {
      title: 'Grievance Pending'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart4'));

    chart.draw(data, options);
  }
</script>
</head>

<div id="piechart4" style="width: 400px; height: 300px;"></div>