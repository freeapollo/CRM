var inspinia = angular.module('inspinia');
inspinia.controller('registerCtrl', ['$scope','$http','$q','API','$state','$timeout', function ($scope,$http,$q,API,$state,$timeout) {
	
	$scope.registerUser = function(){
		var user = { userName: $scope.userName , userEmail : $scope.userEmail , userPassword : $scope.userPassword };
		
		API.registerUser(user).then(function(response){
		//	console.log("registerUser",response);
			if(response.data.responce){
				$state.go("login");
			}
			else{
				$scope.error = response.data;
				$timeout(function(){
					$scope.error.responce = true;
				},10000)
			}
		})
		

	}


}])