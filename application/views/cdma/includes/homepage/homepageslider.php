
<div ng-app="slierapp">
    <div ng-controller="slidercontroller">
<input type="hidden" id="ulbid" value="<?php echo $this->session->userdata('ulb_id');?>" ng-model="ulbid" ng-value="ulbid=<?php echo $this->session->userdata('ulb_id');?>">

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
		
		    
		
        		<!--<div class="carousel-inner">-->
        		<!--<?php $i=1;foreach($sliderdata->result() as $key=>$val){ if($i==1){$class="active";}else{$class="";}?>-->
        		<!--	<div class="item <?php echo $class; ?>">-->
        		<!--		<img src="<?php echo base_url().$val->thumbnail_path; ?>" width="100%" alt="<?php echo $val->alttext; ?>" title="<?php echo $val->title; ?>"/>-->
        		<!--		<div class="carousel-caption" style="right: 0;left: auto;text-align: left;background: rgba(0, 0, 0, 0.5);padding: 15px;bottom: 0%;width: 35%;">-->
        		<!--			<h3 class="carousel-caption-header <?php echo $class2; ?> "><?php echo $val->slide_heading; ?></h3>-->
        		<!--			<div class="carousel-caption-text <?php echo $class1; ?> hidden-sm hidden-xs">-->
        		<!--				<?php echo $val->slide_desc; ?>-->
        		<!--			</div>-->
        		<!--		</div>-->
        		<!--	</div>-->
        		<!--	<?php $i++;} ?>-->
        		<!--</div>	-->
        		
        		
        		
        		<div class="carousel-inner">
        	
        			<div class="item" ng-class="{ 'active' : $index  == 0 }" ng-repeat="x in slides">
        				<img src="http://municipalservices.in/sites/{{x.thumbnail_path}}"  alt="{{x.alttext}}" title="{{x.title}}"/>
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