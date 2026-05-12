
			
			app.controller('contrGallery',function($scope,$http)
			{
			    
				
				
				$http({
					
					url:'http://municipalservices.in/sites/admin/CreatePhotoGalleryController/getAngularPhotoGalleryData',
					method:'POST',
					data:{
						
						albumid:14
					}
					
				}).then(function(response)
				{
					
					
					$scope.images=response.data;
				});
				
				// Loading abum list
				
    	       
				
				
			});
		;