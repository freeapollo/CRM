var inspinia = angular.module('inspinia');
inspinia.controller('companyProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams','crmconfig', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams,crmconfig) {

    var baseHttpUrl = crmconfig.servicePath, domainName = crmconfig.serverDomainName + '/';
    $scope.crmconfig = crmconfig;
    $scope.tabs = { summary:"summary" , attachment : "attachment" };
	$scope.activeTab = $scope.tabs.summary;
	$scope.profileEdit = false;
    
    var companyId = $stateParams.id;
     
    $scope.newUploadPic = false;

    API.getCompanyDetails(companyId).then(function(response){
        $scope.companyData = response.data.Users[0];
        $scope.companyData.id = companyId;
    })



    $scope.files = [];
    API.getCompanyAttachedFiles({ "companyId" : companyId }).then(function(response){

        if(response.data.result){
            if(response.data.details.length > 0) {
                $scope.files = response.data.details;
                console.log($scope.files)
            }
        }
        else {

        }

    });

      
    $scope.fileSelected = function (files) {

        var file = new FormData();
        file.append("image", files[0]);
     //   file.append("fileName",files[0].name);
        file.append("id", companyId);
        
        var reader = new FileReader();
        reader.onload = $scope.imageIsLoaded; 
        reader.readAsDataURL(files[0]);

        API.companyProfilePic(file).then(function(response) {
            console.log(response.data.responce);
            if(response.data.result){
               // alert("Picture successFully Uploaded")
                return;    
            }

            alert("server is down please try again");
            
        })
    };


    $scope.imageIsLoaded = function(e){
            $scope.$apply(function() {
                $scope.newUploadPic = true;
                $scope.imgsrc= e.target.result;
            });
    }

    
    $scope.changeProfileEdit = function(){
        $scope.profileEdit = true;
    }
    
    $scope.saveProfile = function(){
        //console.log("saveProfile clicked ",companyId);
        if(companyId){
            $scope.companyData.id = companyId;
            API.updateCompanyDetails($scope.companyData).then(function(response){
                //console.log("response API", response.data.responce);
                if(response.data.responce){
                  //  alert("company data saved successfully");
                     $scope.profileEdit = false;
                }
                else{
                    alert("server is down please try again");
                }
            })
        }
        
    }


    $scope.fileAttachment = function(event){

        var files = event.target.files;
        $scope.fileAttach = new FormData();
        $scope.fileAttach.append("image", files[0]);
        $scope.fileAttach.append("id", companyId);
        $scope.fileAttach.append("fileName", $scope.newFileName);

        $("#fileNameModal").modal("show");


    }

    $scope.uploadNewFileAttach = function (fileName) {

        if(!fileName || fileName.length < 0 ){
            	alert("Please Enter FileName");
            	return false;
        }

        $scope.fileAttach.append("fileName",fileName);

        uploadCompanyFile($scope.fileAttach).then(function(response) {

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

    $scope.clickCompanyChangePicture = function(){
        document.getElementsByClassName("companyPicUplaodInput")[0].value='';
        document.getElementsByClassName("companyPicUplaodInput")[0].click();
    }

    $scope.browseFileAttach = function() {
        $scope.progressbar = 0;
        try{
            document.getElementsByClassName("fileAttachmentInput")[0].value = '';
            document.getElementsByClassName("fileAttachmentInput")[0].click();
        }
        catch(ex){
            console.log(ex);
        }
    };


    function uploadCompanyFile (file){

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

        xhttp.open("POST",baseHttpUrl + '/uploadCompanyFiles.php',true);
        //xhttp.setRequestHeader("Content-Type", undefined);

        xhttp.send(file);

        return promise.promise;
    }
 
    
}]);