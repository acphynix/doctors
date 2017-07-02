var healthapp = angular.module('healthapp', []);

healthapp.controller('HealthController', function($scope){
  $scope.test = "this is a test";
  $scope.lcurrent_view='views/view_search.php';
  $scope.search_suggestions=['Ada', 'Java', 'JavaScript', 'Brainfuck', 'LOLCODE', 'Node.js', 'Ruby on Rails'];
  $scope.update_dropdown = function(){
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "https://restcountries.eu/rest/v1/lang/fr", true);
    ajax.onload = function() {
      var list = JSON.parse(ajax.responseText).map(function(i) { return i.name; });
      // new Awesomplete(document.querySelector("#ajax-example input"),{ list: list });
    };
    ajax.send();
  }
  // alert('hi!');
});
healthapp.controller('PatientAppointments', function($scope, $http){
  $scope.test = "this is a test";
  $scope.appointments=[{name:"John Smith"}];

  $scope.getAppointments = function(){
    $http({
      method: 'GET',
      url: 'ajax/get_patient_appointments.php'
    }).then(function (response) {
      $scope.appointments=data;
    }, function (response) {
       // code to execute in case of error
    });
  };
  // alert('hi!');
});
healthapp.controller('CreateAccount',function($scope,$http){
  $scope.isDoctor = true;
});