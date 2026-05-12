$(document).ready(function()
{
    Dropzone.options.imageUpload = {
				
				maxFilesize:120,
				
				acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG",
				
				success: function(){
				    doSomething();
				    
				   
					
					}
				
			};
    
});
	
function delGallery()
			{
				var chkArray = [];
				$(".chk:checked").each(function() {
					chkArray.push($(this).val());
				});
				
				if(confirm('Do you really want to delete files'))
				{
					
					$.post('LibraryController/deleteMultiple',{fList:chkArray},function(data){
						
						if(data=='1')
						{
							alert('Deleted successfully');
							location.reload();
						}
						else
						{
							alert('Unable to delete , Try again');
						}
					});
				}
			}
			
	function uncheckall()
			{
				
				
				$('.image-checkbox').removeClass('image-checkbox-checked');
				
				
			}
		
		
		function doSomething() {
			    var scope = angular.element(document.getElementById('ngbody')).scope();
			    scope.getAlbumData();
			
			}
			
			function delete_rec(slide_id)
			{
				
				if(confirm('Are sure you want to delete this record'))
				{
					$.post('CreatePhotoGalleryController/deleteContent',{slide_id:slide_id},function(data)
					{
						
						if(data=='1')
						{
							alert('Successfully deleted');
							location.reload();
						}
						else
						{
							alert('Unable deleted');
						}
					});
				}
			}
			
			function getsubmit()
			{
				
				$("#myform").submit();
			}
			
			
			function fun1
			{
				
				$('#myModal').modal('show');
				
			}
		
		
			function getUpload() {
			    
			    var scope = angular.element(document.getElementById('ngbody')).scope();
			    
				
				var albumid=scope.albumid;
				
				
				if(albumid > 0)
				{
					
					var checkboxes = document.getElementsByName('image[]');
					
					var checkList = [];
                    for (var i=0; i<checkboxes.length;i++) 
                    {
                        if (checkboxes[i].checked) 
                        {
                            
                            checkList.push(checkboxes[i].value);
						}
					}
                    
                    $.post('LibraryController/insertMediaFilestowidget',{checkList:checkList,albumid:albumid,table:1},function(data)
                    {
                        alert('Data inserted successfully');
                       
					});
					
					scope.getAlbumData();
				}
				else
				{
					alert('select album');
					return false;
				}
				
				
			}
		;