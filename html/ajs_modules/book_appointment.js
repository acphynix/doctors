var doctor_search = angular.module('doctor_search', []);

doctor_search.controller('search', function($scope, $window, $http){

  $scope.test = "this is a test";
  $scope.lcurrent_view='views/view_search.php';
  $scope.search_suggestions=['Ada', 'Java', 'JavaScript', 'Brainfuck', 'LOLCODE', 'Node.js', 'Ruby on Rails'];
  $scope.action='search';
  $scope.action_book = function(doctor,time){
    $scope.action = 'book';
    $scope.book={'doctor':doctor,'time':time};
    console.log($scope.book);
  }
  $scope.check_appointment = function(){
    $http({
      method: 'POST',
      url: '../ajax/post_request_appointment.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      data: { d: $scope.book.doctor, s: $scope.book.time },
      transformResponse: undefined
    }).then(function successCallback(response) {
      console.log('Response: ');
      console.log(response);
      $scope.book.appt = JSON.parse(response.data);
      $scope.valid
    }, function errorCallback(response) {
      console.log('Response: ');
      console.log(response);
    });
  }
  $scope.get_information = function(){
    $http({
      method: 'GET',
      url: '/ajax/user.php?u='+$scope.book.doctor+'&q=fname%20lname%20location',
      transformResponse: undefined
    }).then(function successCallback(response) {
      console.log('Response: ');
      console.log(response);
      $scope.book.info = JSON.parse(response.data);
    }, function errorCallback(response) {
      console.log('Response: ');
      console.log(response);
    });
  }
  $scope.book_appointment = function(doctor,time){
      $http({
        method: 'POST',
        url: '../ajax/post_request_appointment.php',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        data: { d: $scope.book.doctor, s: $scope.book.time, c: '1' },
        transformResponse: undefined
      }).then(function successCallback(response) {
        console.log('Response: ');
        console.log(response);
        window.location.href = '/page/home.php#!#view_patientappts.php';
        // doctor.schedule=JSON.parse(response.data);
      }, function errorCallback(response) {
        console.log('Response: ');
        console.log(response);
      });
  }
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
  $scope.load_info = function(doctor){
    if(doctor.show){
      console.log(doctor);
      $http({
        method: 'GET',
        url: '../ajax/get_doctor_availability.php?u='+doctor.user_id,
        transformResponse: undefined
      }).then(function successCallback(response) {
        console.log('Response: ');
        console.log(response);
        doctor.schedule=JSON.parse(response.data);
      }, function errorCallback(response) {
        console.log('Response: ');
        console.log(response);
      });
    }
  }
  $scope.keyword_search = $window.query.search;
  $scope.book= {'doctor':$window.query.doctor,
                'time':  $window.query.time};
  $scope.check_appointment();
  $scope.get_information();
});