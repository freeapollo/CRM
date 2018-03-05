inspinia.directive('chatbox', function($rootScope) {
  return {
 	
    restrict: 'E',
    templateUrl: 'Directives/chatbox.html',
    link: function(scope, elem, attr,$timeout,$rootScope) { 
    	
      var chatBoxHt = elem.find('div.msg_container_base')[0];
    //  var chatLength = find('div.msg_container_base').children().length;
      scope.scrollDown = function() {    
        setTimeout(function(){ 
      		scope.$apply(function(){
      			chatBoxHt.scrollTop = chatBoxHt.scrollHeight;
      			console.log(chatBoxHt);		
      		})
      		
      	}, 1000);
    	}
      
      scope.scrollDown();
      
       scope.$watch(function(){return scope.chat.chatDetail;}, function(newChat,oldChat) {
        if(newChat.length > oldChat.length) {
          scope.scrollDown();
        }
      }, true);

      

    	 
    },
  };
});