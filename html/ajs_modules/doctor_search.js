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
  function goto(newpage){
    window.location.href = newpage
  }
  
  $scope.location_names=['Abia', 'Adamawa', 'Anambra', 'Akwa Ibom', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Enugu', 'Edo', 'Ekiti', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos: Agege', 'Lagos: Ajeromi-Ifelodun', 'Lagos: Alimosho', 'Lagos: Amuwo-Odofin', 'Lagos: Apapa', 'Lagos: Badagry', 'Lagos: Epe', 'Lagos: Eti-Osa', 'Lagos: Ibeju-Lekki', 'Lagos: Ifako-Ijaiye', 'Lagos: Ikeja', 'Lagos: Ikorodu', 'Lagos: Kosofe', 'Lagos: Lagos Island', 'Lagos: Lagos Mainland', 'Lagos: Mushin', 'Lagos: Ojo', 'Lagos: Oshodi-Isolo', 'Lagos: Somolu', 'Lagos: Surulere', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara', 'Abuja (FCT)'];
  $scope.location_name = function(val){
      return $scope.location_names[val];
  };
  
  $scope.update_dropdown = function(){
    var ajax = new XMLHttpRequest();
    console.log('searching '+$scope.searchbox.value);
    ajax.open("GET", "../ajax/get_keyword_suggestions.php?q='"+$scope.keyword_search+"'", true);
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
    $scope.awesomplete = new Awesomplete(document.getElementById("ikeyword_search"), { list: ["heartbreak"] });
  }
  
  $scope.book_appointment = function(doctor,time){
      $http({
        method: 'POST',
        url: '../ajax/post_request_appointment.php',
        data: { doctor: $scope.book.doctor.user_id, time: $scope.book.time },
        transformResponse: undefined
      }).then(function successCallback(response) {
        console.log('Response: ');
        console.log(response);
        window.location.href = 'home.php#!#view_patientappts';
        doctor.schedule=JSON.parse(response.data);
      }, function errorCallback(response) {
        console.log('Response: ');
        console.log(response);
      });
  }
  $scope.perform_search = function(){
    var ajax = new XMLHttpRequest();
    var loc_id = $("#loc_ent").val();
    ajax.open("GET", "../ajax/get_doctor_search_results.php?q="+$scope.keyword_search+"&c="+loc_id, true);
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
        doctor.schedule=JSON.parse(response.data);
        console.log(doctor.schedule);
        doctor.events = doctor.schedule.map(function(event){
          var e = {
            qry_t : event.s,
            start : moment.utc(event.s),
            end   : moment.utc(event.e),
			title : event.p+' '+event.c
            //title : event.p+' '+event.c + ' ('+event.l+')'
          };
          return e;
        });
        console.log(doctor.events);
        $("#calendar_"+doctor.user_id).fullCalendar({
          defaultView : 'listWeek',
          title       : false,
          height      : 300,
          events      : doctor.events,
          timezone    : 'local',
          eventClick  : function(event, jsEvent, view){
            goto('/book_appointment.php?t='+event.qry_t+'&q='+$scope.keyword_search+'&d='+doctor.user_id);
          }
        });
      }, function errorCallback(response) {
        console.log('Response: ');
      });
    }
  }
  $scope.month = function(n){
    if(n==1)return 'January';
    if(n==2)return 'February';
    if(n==3)return 'March';
    if(n==4)return 'April';
    if(n==5)return 'May';
    if(n==6)return 'June';
    if(n==7)return 'July';
    if(n==8)return 'August';
    if(n==9)return 'September';
    if(n==10)return 'October';
    if(n==11)return 'November';
    if(n==12)return 'December';
  }
  $scope.to_date_string = function(date){
    // alert(date);
    var comps = date.split(/[/\-: ]/);
    // console.log(comps);
    return comps[2]+" "+$scope.month(comps[1])+" "+comps[0]+" "+comps[3]+":"+comps[4];
  }
  $scope.keyword_search = $window.query.search;
  $scope.perform_search($scope.keyword_search);
});