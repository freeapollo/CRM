var inspinia = angular.module('inspinia');
inspinia.controller('userProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams','crmconfig', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams,crmconfig) {

	var baseHttpUrl = crmconfig.servicePath, domainName = crmconfig.serverDomainName + '/';
	$scope.tabs = { summary:"summary" , attachment : "attachment" };
	$scope.activeTab = $scope.tabs.summary;
	$scope.profileEdit = false;
	$scope.userProfileInfo = {};
	$scope.formData = {};

	//console.log("$stateParams",$stateParams)
	$scope.emplId = $stateParams.id;
	
	//emplProPicSeleted
	API.getAllComapnies().then(function(response){
		$scope.companies = response.data.details;
	})

	$scope.changeProfileEdit = function (){
		
		console.log("$scope.userProfileInfo",$scope.userProfileInfo)
		$scope.profileEdit = !$scope.profileEdit;
	}
	
	$scope.submit = function() {
        $scope.userProfileInfo.imgUrl = $scope.profilePicUploadedResUrl || $scope.userProfileInfo.imgUrl;
        
        try {
		   	$scope.companies.forEach(function(company){
		   		if(company.id == $scope.userProfileInfo.companyId) {
		   			$scope.userProfileInfo.Company.name = company.name;
		   		}
		   	})
	   } catch(ex) {
	   	console.log(ex);
	   }

	    API.updateUserProfile($scope.userProfileInfo).then(function(response){
	    	if(response.data.responce){
	    		//alert("profileUpdated");
	    		$scope.profileEdit = !$scope.profileEdit;
	    	}
	    	else{
	    		alert("Network Problem Please Try Again");	
	    	}
	    	
	    })

   
	};


	
    
    var userObj = { userId : $scope.emplId };
    API.getUserProfile(userObj).then(function(response){
        $scope.userProfileInfo = response.data.Employees[0];
        $scope.imgsrc = domainName + response.data.Employees[0].imgUrl;
    	try {
		   	$scope.companies.forEach(function(company){
		   		if(company.id == $scope.userProfileInfo.companyId) {
		   			$scope.userProfileInfo.Company.name = company.name;
		   		}
		   	})
	   } catch(ex) {
	   	console.log(ex);
	   }
    })


	$scope.browseFileAttach = function() {
		$scope.progressbar = 0;
		try{
		document.getElementsByClassName("fileAttachmentInput")[0].value = '';
		document.getElementsByClassName("fileAttachmentInput")[0].click();
		}
		catch(ex){
			console.log(ex);
		}
	}


	$scope.fileAttach = function(event){

		var files = event.target.files;
		$scope.fileAttach = new FormData();
		$scope.fileAttach.append("image", files[0]);
		$scope.fileAttach.append("id", $scope.emplId);
		$scope.fileAttach.append("fileName", $scope.newFileName);
		
		$("#fileNameModal").modal("show");


	}

	function progressFun(event){
		console.log("event : ",event);
	}

	$scope.uploadNewFileAttach = function (fileName) {

		if(!fileName || fileName.length < 0 ){
			alert("Please Enter FileName");
			return false;
		}

		$scope.fileAttach.append("fileName",fileName);
		
	    	uploadEmplFile($scope.fileAttach).then(function(response) {
	    	
	    	//alert("file successFully Uploaded")
	    	 response = JSON.parse(response);
	    	 console.log(response);
	    	 if(response.result) {
	    		//alert("file successFully Uploaded");
	    		$("#fileNameModal").modal("hide");
	    		$scope.fileAttach = '';
	    	 }
	    	 else {
	    	 	alert("Network problem Please Try Again");
	    	 }

	    	
	    	$timeout(function() {
				$scope.files.push({checked:false,"name":response.details.fileName,"date":response.details.date,id:response.details.id,filesize:response.details.filesize,isactive:'1'})
				//console.log($scope.files);
			}, 500);	

	    })


	} 


	$scope.files = [];
	API.getAttachedFiles({userId: $scope.emplId}).then(function(response){

		if(response.data.result){ 
			if(response.data.details.length > 0) {
				$scope.files = response.data.details;	
				console.log($scope.files)
			}
		} 
		else {

		}

	});
	

    function uploadEmplFile (file){

        var xhttp = new XMLHttpRequest();
        var promise = $q.defer();

        xhttp.upload.addEventListener("progress",function (e) {
        //    console.log("progress ",e); 
            var progress = Math.ceil(((e.loaded) / e.total) * 100);
            $timeout(function(){
            	$scope.progressbar = progress;
            },10);
            
         //   console.log(progress);
            //promise.notify(e);
        });
        // xhttp.upload.addEventListener("load",function (e) {
        //     promise.resolve(e);
        // });

        xhttp.onreadystatechange=function() {
         //   alert(xhttp.readyState + " " + xhttp.status);
            if (xhttp.readyState==4 && xhttp.status==200) {
                console.log(xhttp.responseText);
             // document.getElementById("captcha_error").innerHTML=xmlhttp.responseText;
              promise.resolve(xhttp.responseText);
              //return false;
            }
        }

        xhttp.upload.addEventListener("error",function (e) {
            promise.reject(e);
        });

        xhttp.open("POST",baseHttpUrl + '/uploadEmplFiles.php',true);
        //xhttp.setRequestHeader("Content-Type", undefined);
    
        xhttp.send(file);

        return promise.promise;
    }

    $scope.deleteEmplFile = function(fileId,index) {
    	var fileObj = { emplId : $scope.emplId , fileId : fileId };
    	API.deleteEmplFile(fileObj).then(function(response){
	    	 if(response.data.result){
	    	 	$scope.files[index].isactive = 0;	
	    	 }
    	})
    }



   // below code for uppdate profile Pic

   // when user click on choose file for emplyee profile pic
   $scope.emplProPicSeleted = function(files) {

   	  	var file = new FormData();
        file.append("image", files[0]);
        file.append("fileName",files[0].name);
        file.append("id", $scope.emplId);
        
        var reader = new FileReader();
        reader.onload = $scope.imageIsLoaded; 
        reader.readAsDataURL(files[0]);
        try{
        	document.getElementsByClassName("emplpropicfileinput")[0].value = '';
        }
        catch(ex){
        	console.log(ex);
        }
        //var url = "http://jaiswaldevelopers.com/CRMV1/files/index.php";
        API.uploadEmplProfilePic(file).then(function(response) {
        	if(response.data.result){
	        //	console.log("upload emplyee pro pic response",response);
	            //alert("Picture successFully Uploaded");
                $scope.profilePicUploadedResUrl = response.data.details.imageUrl;
			}
        })	

   }

    $scope.imageIsLoaded = function(e){
        $scope.$apply(function() {
            $scope.imgsrc = e.target.result;
        });
    }
    
     $scope.clickUserChangePicture = function(){
        document.getElementsByClassName("emplpropicfileinput")[0].value = ''; 
        document.getElementsByClassName("emplpropicfileinput")[0].click();
    }





	// $scope.files = [
	// 	{
	// 		"id":"1",
	// 		"name":"x-man pdf",
	// 		"date":"02/05/2012",
	// 		"checked":false
	// 	},
	// 	{
	// 		"id":"2",
	// 		"name":"The Economic Policy pdf",
	// 		"date":"02/05/2012",
	// 		"checked":false
	// 	},
	// 	{
	// 		"id":"3",
	// 		"name":"tail Head Png",
	// 		"date":"02/05/2012",
	// 		"checked":false
	// 	}
	// ]


}]);	



inspinia.directive('customOnChange', function() {
  return {
    restrict: 'A',
    link: function (scope, element, attrs) {
      var onChangeHandler = scope.$eval(attrs.customOnChange);
      element.bind('change', onChangeHandler);
    }
  };
});