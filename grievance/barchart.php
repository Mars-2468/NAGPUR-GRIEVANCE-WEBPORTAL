<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       <div id="dual_x_div" style="width: 900px; height: 500px;"></div>
	   
	   <script type="text/javascript">
	   
	         google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Galaxy', 'Distance'],
          ['Canis Major Dwarf', 8000],
          ['Sagittarius Dwarf', 24000],
          ['Ursa Major II Dwarf', 30000],
          ['Lg. Magellanic Cloud', 50000],
          ['Bootes I', 60000]
        ]);

        var options = {
          width: 800,
          chart: {
            title: 'Nearby galaxies',
            subtitle: 'distance on the left, brightness on the right'
          },
          bars: 'vertical', // Required for Material Bar Charts.
          series: {
            0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            x: {
              distance: {label: 'parsecs'}, // Bottom x-axis.
              brightness: {side: 'top', label: 'apparent magnitude'} // Top x-axis.
            }
          }
        };

      var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
      chart.draw(data, options);
    };
	
	</script>