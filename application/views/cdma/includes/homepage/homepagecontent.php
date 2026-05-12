
<div ng-app="homecontentApp">
    <div ng-controller="homecontentcontroller">
        <div style="overflow: hidden;text-overflow: ellipsis;height: 550px;">
        <div ng-repeat="x in homecontent" >

            <div class="content5">{{x.page_name}}</div>
    		<div class="content6" ng-bind-html="x.content">{{x.content}}</div>
    		
    		
    		
    		
    	</div>
    	<div class="pull-right"><button class="btn btn-xs btn-success">Read More</button></div>
    	</div>
    	<!--<div class="pull-right"><button class="btn btn-xs btn-success">Read More</button></div>-->
    	
    		
</div><!-- controller end -->
</div><!-- ng app end -->

		