var inspinia = angular.module('inspinia');
inspinia.controller('companyInsertProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams) {

	var baseHttpUrl = 'http://jaiswaldevelopers.com/CRMV1/Service', domainName = 'http://jaiswaldevelopers.com/CRMV1/';
	$scope.imgsrc = 'img/default-avatar.png';
	$scope.hidespinner = false;

	$scope.cmpyProfileInfo = {};
	$scope.companyProfile = new FormData();
		

	$scope.browseEmplProfilePicAttach = function() {
		document.getElementsByClassName("emplInsertProfilePic")[0].value = '';
		document.getElementsByClassName("emplInsertProfilePic")[0].click();
	}

	$scope.attachCompanyProfilePic = function(event) {

		var files = event.target.files;
		$scope.companyProfile.append("image", files[0]);
		var reader = new FileReader();
        reader.onload = $scope.imageIsLoaded; 
        reader.readAsDataURL(files[0]);
				
	}

	$scope.saveCompany = function() {
		$scope.errorMsg = "";
		isValid = checkEmplFields($scope.cmpyProfileInfo);
		if(isValid) {
			$("#emplLoadingModal").modal('show');

			$scope.companyProfile.append("data",JSON.stringify($scope.cmpyProfileInfo));
			
			API.insertCompanyProfile($scope.companyProfile).then(function(response){
				//console.log("response empl Insert",response);
				if(response.data.result){
				    $scope.imgsrc = 'img/default-avatar.png';
                    $scope.errorMsg = "data uploaded";
					$scope.cmpyProfileInfo = {};
                    $scope.hasError = false;

				}else{
                    $scope.hasError = true;
					$timeout(function(){
						$scope.errorMsg = response.data.details;
					},100)
					//alert(response.data.details);
				}
                $scope.hidespinner = true;



            })

		}
	}

	$scope.imageIsLoaded = function(e){
        $scope.$apply(function() {
            $scope.imgsrc = e.target.result;
        });
    }

	function checkEmplFields(info) {
		//var info = $scope.emplProfileInfo;
		
		if(!info.name || !info.email){
			if(!info.name) {
				alert("please enter Your Name ");
				return false;
			}
			else if(!info.email) {
				alert("please enter email address");
				return false;
			}
		}
		else if(!info.phone){
			alert("please enter phone");
			return false;
		}

		else if(!validateEmail(info.email)){
			alert('Please enter valid email Id');
		}
		else {
			return true;
		}

	}

	function validateEmail(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(email);
	}

}]);