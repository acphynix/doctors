var doctor_search = angular.module('doctor_search', []);

doctor_search.controller('search', function($scope, $window){
  $scope.test = "this is a test";
  $scope.lcurrent_view='views/view_search.php';
  $scope.search_suggestions=['Ada', 'Java', 'JavaScript', 'Brainfuck', 'LOLCODE', 'Node.js', 'Ruby on Rails'];
  $scope.perform_search = function(){
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "../ajax/get_doctor_search_results.php?q="+$scope.keyword_search, true);
    ajax.onload = function() {
      console.log(ajax.responseText);
      $scope.$apply(function(){
        $scope.result_list=JSON.parse(ajax.responseText);        
      });
    };
    ajax.send();
  }
  $scope.keyword_search = $window.query.search;
  $scope.perform_search($scope.keyword_search);
});