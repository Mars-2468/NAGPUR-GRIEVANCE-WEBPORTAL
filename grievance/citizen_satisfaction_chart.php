
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       <div id="dual_x_div" style="width:100px; height: 2000px;"></div>
	   
	   <script type="text/javascript">
	   
	         google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Departments', '5 Star', '4 Star','3 Star','2 Star','1 Star'],
		  
		  <?php foreach($cs_list as $cs_id=>$val){?>
          ['<?php echo $val; ?>', <?php echo $ratings[$cs_id][5]['rating_no']; ?>, <?php echo $ratings[$cs_id][4]['rating_no']; ?>,<?php echo $ratings[$cs_id][3]['rating_no']; ?>,<?php echo $ratings[$cs_id][2]['rating_no']; ?>,<?php echo $ratings[$cs_id][1]['rating_no']; ?>],
		  
		  <?php }?>
		  
		  
		 
        ]);

        var options = {
          width: 1000,
          chart: {
            title: 'Citizen Satisfaction',
            subtitle: ''
          },
          bars: 'horizontal', // Required for Material Bar Charts.
          series: {
            0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            x: {
              distance: {label: 'Ratings'}, // Bottom x-axis.
              brightness: {side: 'top', label: 'Ratings'} // Top x-axis.
            }
          }
        };

      var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
      chart.draw(data, options);
    };
	
	</script>