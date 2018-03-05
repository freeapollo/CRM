inspinia.directive('searchbar', function() {
  return {
 	  scope:{
      showautocomplete:'=',
      searchlist:'=', 
      searchtext:'=',
      searchapi:'=',
      listclick:'&'
    },
    restrict: 'E',
    templateUrl: 'Directives/searchbar.html',
    link: function(scope, elem, attr,$timeout) { 
    

    },
  };
});