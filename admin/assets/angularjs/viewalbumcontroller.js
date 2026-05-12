viewAlbumsApp.controller('viewAlbumsController',function($scope,$http)
{
   
    $http({
        url:'ViewAlbumsController/getAlbumList',
        method : 'POST'
    }).then(function(response)
    {
        $scope.albumInfo=response.data.albumList;
    });
});;