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
  $scope.init_view=function(){
    if(window.location.hash) {
      view = (window.location.hash.substring(window.location.hash.lastIndexOf("#")+1));
      $scope.lcurrent_view='views/'+view+'.php';
    }
  };
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

healthapp.controller('patient_appointments', function($scope, $http){
  // todo: remove this.

  $scope.date_start = '2017-07-02 13:00';
  $scope.date_end   = '2017-07-02 14:30';
  $scope.date_value = 'open';

  $scope.schedule=[{name:"John Smith"},{name:"Pedro Garcia"},{name:"Jane Doe"},{name:"Alejandra Lopez"}];
  $scope.get_schedule = function(){
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "../ajax/get_schedule.php", true);
    ajax.onload = function() {
      console.log(ajax.responseText);
      $scope.$apply(function(){
        console.log('response: ');
        console.log(ajax.responseText);
        $scope.schedule=JSON.parse(ajax.responseText);        
      });
    };
    ajax.send();
  }
  $scope.set_schedule = function(start,end,value){
    console.log('Submit: '+start+', '+end+', '+value);
    $http({
      method: 'GET',
      url: 'ajax/set_doctor_availability.php?s='+start+'&e='+end+'&t='+value,
      transformResponse: undefined
    }).then(function successCallback(response) {
      console.log('set response:');
      console.log(response);
      console.log(JSON.stringify(response.data));
      $scope.get_schedule();
    }, function errorCallback(response) {
      console.log(response);
      alert('error '+response);
    });
  }
});