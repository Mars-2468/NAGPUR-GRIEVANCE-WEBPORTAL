<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/css/pausingscroller.css">
 <script  src="<?php echo base_url(); ?>assets/<?php echo $theme; ?>/js/pausingscroller.js"></script>
    
    <script type="text/javascript">

/*Example message arrays for the two demo scrollers*/

// newsApp=angular.module('newsApp',[]);
// newsApp.controller('newsController',function($scope,$http)
// {
//     console.log('newsController is initialized');
// });



var pausecontent=new Array()
pausecontent[0]='<a href="http://www.javascriptkit.com">JavaScript Kit</a><br />Comprehensive JavaScript tutorials and over 400+ free scripts!'
pausecontent[1]='<a href="http://www.dynamicdrive.com">Dynamic Drive</a><br />Free, original JavaScript and CSS codes to instantly add interactive features to your site!'
pausecontent[2]='<a href="http://www.cssdrive.com" target="_new">CSS Drive</a><br />Categorized CSS gallery and examples.'

var pausecontent2=new Array()

<?php $i=0;  foreach($headerNews as $key=>$val){ 
    
    ?>

pausecontent2[<?php echo $i; ?>]='<a href="<?php echo base_url().$val['site_controller']?>" target="_blank"><?php echo $val['page_name'];?></a>'

<?php $i++;}?>

</script>

<style>
    
    
/* Demo CSS for Pausing Scrollers */

#pscroller1{
	width: 100%;
	max-width: 400px;
	height: 100px;
	border: 1px solid black;
	background-color: lightyellow;
	margin-bottom: 1em;
}

#pscroller1 > div.innerDiv{
	padding: 8px;
}


#pscroller2{
	/*width: 100%;*/
	width: 350px;
	height: 28px;
	border: 0px solid black;
	white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

#pscroller2 > div.innerDiv{
	padding: 4px;
}

#pscroller2 a{
	text-decoration: none;
}

</style>
<!--<div ng-app="newsApp">
<div ng-controller="newsController">-->

	<div class="new_text fadeOutUp">
					    
					    <div id="pscroller2" class="pausescroller"></div> 
					   
                            <script type="text/javascript">
                           
                            
                           
                            var scroller2 = new pausescroller(pausecontent2, "pscroller2", 2000, 500)
                            
                            </script>
					    
					</div>
<!--</div>news controller is end
</div>news app end -->				