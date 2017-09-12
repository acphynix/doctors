var doctor_search = angular.module('doctor_search', []);

doctor_search.controller('search', function($scope, $window, $http){

  $scope.test = "this is a test";
  $scope.lcurrent_view='views/view_search.php';
  $scope.search_suggestions=['Ada', 'Java', 'JavaScript', 'Brainfuck', 'LOLCODE', 'Node.js', 'Ruby on Rails'];
  $scope.location_names=['Abia', 'Adamawa', 'Anambra', 'Akwa Ibom', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Enugu', 'Edo', 'Ekiti', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos: Agege', 'Lagos: Ajeromi-Ifelodun', 'Lagos: Alimosho', 'Lagos: Amuwo-Odofin', 'Lagos: Apapa', 'Lagos: Badagry', 'Lagos: Epe', 'Lagos: Eti-Osa', 'Lagos: Ibeju-Lekki', 'Lagos: Ifako-Ijaiye', 'Lagos: Ikeja', 'Lagos: Ikorodu', 'Lagos: Kosofe', 'Lagos: Lagos Island', 'Lagos: Lagos Mainland', 'Lagos: Mushin', 'Lagos: Ojo', 'Lagos: Oshodi-Isolo', 'Lagos: Somolu', 'Lagos: Surulere', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara', 'Abuja (FCT)'];
  $scope.location_name = function(val){
      return $scope.location_names[val];
  };
  $scope.year_months=['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  $scope.plus_one_hour = function(datetime){
      var datetimeArr = datetime.split(" ");
      var dateArr = datetimeArr[0].split("-");
      var year = dateArr[0];
      var monthIndex = dateArr[1] - 1;
      var month = $scope.year_months[monthIndex];
      var day = dateArr[2];
      var timeArr = datetimeArr[1].split(":");
      var hour = +timeArr[0] + 1;
      var h, a;
      if(hour>12){
          h = hour-12;
          (h===12)?a='am':a='pm';
      }
      if(hour===12){
          h = hour;
          a = 'noon';
      }
      if(hour<12){
          h = hour;
          a = 'am';
      }
      var min = timeArr[1];
      return month+' '+day+', '+year+' @ '+h+':'+min+a;      
  };
  $scope.good_time = function(datetime){
      var datetimeArr = datetime.split(" ");
      var dateArr = datetimeArr[0].split("-");
      var year = dateArr[0];
      var monthIndex = dateArr[1] - 1;
      var month = $scope.year_months[monthIndex];
      var day = dateArr[2];
      var timeArr = datetimeArr[1].split(":");
      var hour = +timeArr[0];
      var h, a;
      if(hour>12){
          h = hour-12;
          (h===12)?a='am':a='pm';
      }
      if(hour===12){
          h = hour;
          a = 'noon';
      }
      if(hour<12){
          h = hour;
          a = 'am';
      }
      var min = timeArr[1];
      return month+' '+day+', '+year+' @ '+h+':'+min+a;      
  };
  $scope.action='search';
  $scope.action_book = function(doctor,time){
    $scope.action = 'book';
    $scope.book={'doctor':doctor,'time':time};
    console.log($scope.book);
  }
  $scope.update_dropdown = function(){
    var ajax = new XMLHttpRequest();
    console.log('searching '+$scope.searchbox.value);
    ajax.open("GET", "../ajax/get_keyword_suggestions.php?q=''", true);
    ajax.onload = function() {
      var list = JSON.parse(ajax.responseText).map(function(i) { return i.keyword; });
      console.log(ajax.responseText);
      $scope.awesomplete.list = list;
      $scope.awesomplete.evaluate();
      // new Awesomplete(document.querySelector("#ajax-example input"),{ list: list });
    };
    ajax.send();
  }
  $scope.searchbox   = document.getElementById("ikeyword_search");
  if($scope.searchbox !== null){
    $scope.awesomplete = new Awesomplete(document.getElementById("ikeyword_search"), { list: [] });
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
      $scope.valid = true;
    }, function errorCallback(response) {
      $scope.valid = false;
      window.location.href = '/views/doctor_search.php?q='+$scope.keyword_search;
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
      var apptnote;
      ($scope.apptNote)?apptnote=$scope.apptNote:apptnote='Empty';
      $http({
        method: 'POST',
        url: '../ajax/post_request_appointment.php',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        data: { d: $scope.book.doctor, s: $scope.book.time, c: '1', n:apptnote },
        transformResponse: undefined
      }).then(function successCallback(resp) {
        console.log('Response: ');
        console.log(resp);
        response = JSON.parse(resp.data);
        console.log(response);
        $scope.booked = true;
        $scope.apptcode=response.code;
        //$scope.accountno = '12345678';
        //$scope.routingno = '22446688';
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