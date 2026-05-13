<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  
  
  
  
  <style>
  



@media (min-width: 420px) and (max-width: 659px) {
  .container {
    grid-template-columns: repeat(2, 160px);
  }
}

@media (min-width: 660px) and (max-width: 899px) {
  .container {
    grid-template-columns: repeat(3, 160px);
  }
}

@media (min-width: 900px) {
  .container {
    grid-template-columns: repeat(4, 160px);
  }
}



  </style>
  
  
</head>
<body>

<div class="container mt-3">
  
  
  <div class="box">
    <div class="chart" data-percent="73" data-scale-color="#ffb400">73%</div>
    
  </div>
   
</div>




<script>
	$(function() {
  $('.chart').easyPieChart({
    size: 160,
    barColor: "#17d3e6",
    scaleLength: 0,
    lineWidth: 15,
    trackColor: "#373737",
    lineCap: "circle",
    animate: 2000,
  });
});
	
</script>



</body>
</html>
