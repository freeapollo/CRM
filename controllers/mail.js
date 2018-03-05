//var inspinia = angular.module('inspinia');
inspinia.controller('mailCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$sce', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$sce) {
	
	$scope.isShowTemplate = false;




	API.getAllCampaigns().then(function(response){
		$scope.campaigns = response.data.camp;
	})

	API.getAllGroups().then(function(groupData){
		$scope.groups = groupData.data;    
		console.log("$scope.groups : ",$scope.groups)
	})


   var SMSdata =  {  
		   "from":"InfoSMS",
		   "to":"+918983485655",
		   "text":"My first Infobip SMS"
		};

	var multiSms = {
		"messages" : [
			{  
			   "from":"InfoSMS",
			   "to":"+918983485655",
			   "text":"Yoo Infobip SMS"
			}
			// {  
			//    "from":"FromShasahnk",
			//    "to":"+918989012123",
			//    "text":"Hello Anil how are You?"
			// },
			// {  
			//    "from":"FromShashank",
			//    "to":"+919589496829",
			//    "text":"Hello Jitu how are you?"
			// }
		]
	}
		

	$scope.sendSMS = function(groupObj){
		//console.log(groupObj);
		

		if(!groupObj || !groupObj.id) {
			alert("Please select group");
			return;
		}
		else if(groupObj.Members.length <=0) {
			alert("No Members in group");
		}
		else {
			
				var msgObj = { "messages" : [] };
				groupObj.Members.forEach(function(item){
					if(item && item.phone && item.phone.length >1) {
						item.phone = item.phone.trim();
						msgObj.messages.push({ "from" : $scope.smsSenderName , "to" : item.phone.charAt(0) !== "+" ? "+" + item.phone : item.phone  , "text" : $scope.smsText });
					}
				});

				if(msgObj.messages.length <= 0) {
					alert("No Phone Numbers attached to Members");
					return;
				}
			//	console.log(phNoArr);
				
				//var encoded = "VVBTQUlMMTpVMjQyODk3bA==";
				var encoded = "VVBTQUlsMTpVMjQyODk3bA==";
				$.ajax({
	  			type:"POST",
	  			//url:"https://api.infobip.com/sms/1/text/single",
	  			url:"https://api.infobip.com/sms/1/text/multi",
	  			headers:{
	  				"Authorization": "Basic "+encoded,
	  				"Content-Type":"application/json",
	  				"Accept":"application/json"			
	  			},
	  			data:JSON.stringify(msgObj),
	  			success:function(response){
	  				console.log("response",response);
	  				API.saveSmsCampaign({ data : response, groupid: groupObj.id, name: groupObj.name || "SMS" }).then(function(res){
	  					console.log("sms db save res",res);
	  				})
	  			}

	  		})
				
		}

return;



var data = JSON.stringify({
  "from": "InfoSMS",
  "to": "+918983485655",
  "text": "Test SMS."
});

var xhr = new XMLHttpRequest();
xhr.withCredentials = false;

xhr.addEventListener("readystatechange", function () {
  if (this.readyState === this.DONE) {
    console.log(this.responseText);
  }
});

xhr.open("POST", "https://api.infobip.com/sms/1/text/single");
xhr.setRequestHeader("authorization", "Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==");
xhr.setRequestHeader("content-type", "application/json");
xhr.setRequestHeader("accept", "application/json");

xhr.send(data);
	alert("Please wait until we provide you API key");
	}

	var mailData = {to:"shankie1990@gmail.com" , toName:"shashank Jaiswal" , subject : "testing MailChimp" };	

	$scope.sendMail = function () {

		API.sendMail(mailData).then(function(response){
			console.log(response);

		})

	}


	API.getTemplate().then(function(response){
		var templateStr = JSON.stringify(response.data).replace(/\r?\n|\r/g,'');
		var str = ((JSON.parse(templateStr)).replace(/\r?\n|\r/g,''));
		$scope.templateObj =JSON.parse(str);

		//var html = decodeHtml(htmlObj.templ[0].html);
		//$(html).children().find("#changeContent table > tbody > tr > td > p ").eq(1).html($scope.campaignMessage);
		//$scope.htmlTemplate = $sce.trustAsHtml(html);
		//console.log($scope.htmlTemplate);
	})


	$scope.previewTemplate = function(){
		
		$scope.isShowTemplate = true;
		//alert($scope.campaignMessage);
		var html = decodeHtml($scope.templateObj.templ[0].html);
		$scope.htmlTemplate = $sce.trustAsHtml(html);
		$timeout(function() {
          //  document.querySelectorAll("#changeContent table tr td")[0].children[2].innerHTML = '';
            document.querySelectorAll("#changeContent table tr td")[0].children[2].remove();
         //   document.querySelectorAll("#changeContent table tr td")[0].children[3].innerHTML = '';
            document.querySelectorAll("#changeContent table tr td")[0].children[2].remove();
            document.querySelectorAll("#changeContent table tr td")[0].children[2].remove();

            document.querySelectorAll("#changeContent table tr td")[0].children[1].innerHTML = $scope.campaignMessage || '';

				//	console.log(document.querySelectorAll("#changeContent table tr td")[0].children[1].innerHTML)
		}, 10);
		

	}

	$scope.hideTemplatePreview = function(){
		$scope.isShowTemplate = false;
	}
	
	function decodeHtml(html) {
	    var txt = document.createElement("textarea");
	    txt.innerHTML = html;
	    return txt.value;
	}

//	$scope.addCampaignSubmit();
	$scope.addCampaignSubmit = function(){

		if(!$scope.campaignName) {
			alert("Please Enter Campaign Name");
			return;
		}
		else if(!$scope.groupSelected.id) {
			alert("Please Select Group");
			return;
		}
		else if(!$scope.groupSelected.segId || $scope.groupSelected.segId.length == 0) {
			alert("Mailchimp Segment Id not created, Please create segment for this group by updating the group");
			return;
		}

		$scope.formData = new FormData();
		$scope.formData.append("groupId", $scope.groupSelected.id);
		$scope.formData.append("name", $scope.campaignName);
		$scope.formData.append("createdBy",$rootScope.userName || localStorage.getItem("userName") || "Admin");
		$scope.formData.append("emails", $rootScope.userEmail || localStorage.getItem("userName") || "shashanksmf@outlook.com" );
		$scope.formData.append("subject", $scope.campaignEmailSubject);
		$scope.formData.append("body", $scope.campaignMessage);
		$scope.formData.append("templateId", "2");
		$scope.formData.append("segId", $scope.groupSelected.segId);
		$scope.formData.append("dates", new Date());

		API.addCampaign($scope.formData).then(function(response){
			console.log(response);
			$scope.campaignId = response.data.id;

			console.log("run campaign")
			API.runCampaign($scope.campaignId).then(function(response){
				console.log(response);

				alert("campaign Successfully started");
//				location.reload();
			},
			    function(data) {
			  	alert("campaign Successfully started");
			        // Handle error here
//			  	location.reload();
			    })
		})
	
	}

}])

