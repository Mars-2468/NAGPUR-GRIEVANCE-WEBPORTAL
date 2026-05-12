<div ng-app="slierapp">
    <div ng-controller="slidercontroller">


<div class="container slider_style">
	<div id="transition-timer-carousel" class="carousel slide transition-timer-carousel" data-ride="carousel">
		
		<?php
		$class1="";
		$class2="";
		if($this->session->userdata('langId')=='2')
		{
		    $class1="slider_discription";
		    $class2="slider_content";
		}
		?>
		
        		
        		<div class="carousel-inner">
        	
        			<div class="item" ng-class="{ 'active' : $index  == 0 }" ng-repeat="x in slides">
        				<img src="http://municipalservices.in/sites/{{x.thumbnail_path}}" alt="{{x.alttext}}" title="{{x.title}}"/>
        				<div class="carousel-caption" style="right: 0;left: auto;text-align: left;background: rgba(0, 0, 0, 0.5);padding: 15px;bottom: 0%;width: 35%;">
        					<h3 class="carousel-caption-header <?php echo $class2; ?>">{{x.slide_heading}}</h3>
        					<div class="carousel-caption-text <?php echo $class1; ?> hidden-sm hidden-xs">
        						{{x.slide_desc}}
        					</div>
        				</div>
        			</div>
        			
        		</div>	
		
		
		<a class="left carousel-control" href="#transition-timer-carousel" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
		</a>
		<a class="right carousel-control" href="#transition-timer-carousel" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
		</a>
		
		
	</div>
</div>
</div>
</div>