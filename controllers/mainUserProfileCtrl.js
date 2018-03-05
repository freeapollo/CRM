var inspinia = angular.module('inspinia');
inspinia.controller('mainUserProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams) {

$scope.isUserProfileEdit = false;    
    
var userId = $rootScope.userId || localStorage.getItem("userId");
     API.getUserInfo(userId).then(function(response) {
         if(response.data.result) {
             $scope.mainUserInfo = response.data.details;
         }
    });
    
$scope.saveMainUserProfile = function() {
    $scope.isUserProfileEdit = false;
    var userInfoObj = $scope.mainUserInfo;
    API.updateMainUserProfile(userInfoObj).then(function(response){
        console.log("update main user profile response",response);
    });
}

$scope.allowEditProfile = function(){
 $scope.isUserProfileEdit = true;   
}


}]);	
