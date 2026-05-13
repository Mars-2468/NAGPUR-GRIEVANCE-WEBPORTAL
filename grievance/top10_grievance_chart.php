<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       <div id="dual_x_div" style="width:100px; height: 500px;"></div>
	   
	   <script type="text/javascript">
	   
	         google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Departments', 'Complaints Received'],
		  
		  <?php foreach($max_comp_details as $cs_id=>$val){?>
          ['<?php echo $cs_list[$val['cat3_id']]; ?>', <?php echo $tot[$val['cat3_id']]['total'] ?>],
		  
		  <?php }?>
		  
		  
		 
        ]);

        var options = {
          width: 1000,
          chart: {
            title: 'Top 10 Grievance Department wise ',
            subtitle: ''
          },
          bars: 'horizontal', // Required for Material Bar Charts.
          series: {
            0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            x: {
              distance: {label: 'Complaints Received'}, // Bottom x-axis.
              brightness: {side: 'top', label: 'Average Rating'} // Top x-axis.
            }
          }
        };

      var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
      chart.draw(data, options);
    };
	
	</script>