var inspinia = angular.module('inspinia');
inspinia.controller('loginCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','crmconfig', function ($scope,$rootScope,$http,$q,API,$state,$timeout,crmconfig) {

	//console.log("crmConfig ",crmconfig);	
	$scope.loginUser = function(){
		var user = { userName: $scope.userEmail ,  userPassword : $scope.userPassword };
		
		API.loginUser(user).then(function(response){
			//console.log("registerUser",response);
			if(response.data.responce){
				$rootScope.userEmail = response.data.email;
				$rootScope.userName = response.data.name;
				$rootScope.userId = response.data.id;
				localStorage.setItem("userEmail",response.data.email);
				localStorage.setItem("userName",response.data.name);
				localStorage.setItem("userId",response.data.id);
				//localStorage.setItem("userUUID",response.data.responce);
				$rootScope.userProfilePic = crmconfig.serverDomainName +"/"+ response.data.profilePic;
				 $scope.$emit('initialiseChat', { initChat : true });
 					

				API.setAuth(response.data);
				$state.go("dashboards.home");

		
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