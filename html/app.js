var healthapp = angular.module('healthapp', []);

healthapp.controller('HealthController', function($scope){
  $scope.test = "this is a test";
  $scope.lcurrent_view='/views/view_patientappts.php';
  $scope.update_dropdown = function(){
    var ajax = new XMLHttpRequest();
    console.log('searching '+$scope.searchbox.value);
    ajax.open("GET", "ajax/get_keyword_suggestions.php?q='"+$scope.keyword_search+"'", true);
    ajax.onload = function() {
      var list = JSON.parse(ajax.responseText).map(function(i) { return i.keyword; });
      console.log(ajax.responseText);
      $scope.awesomplete.list = list;
      $scope.awesomplete.evaluate();
      // new Awesomplete(document.querySelector("#ajax-example input"),{ list: list });
    };
    ajax.send();
  }
  $scope.init_view=function(){
    if(window.location.hash) {
      view = (window.location.hash.substring(window.location.hash.lastIndexOf("#")+1));
      $scope.lcurrent_view='/views/'+view+'.php';
    }
  };
  $('#ilocation_search').attr('data-list',
    'Abia, Adamawa, Anambra, Akwa Ibom, Bauchi, Bayelsa, Benue, Borno, Cross River, Delta, Ebonyi, Enugu, Edo, Ekiti, Gombe, Imo, Jigawa, Kaduna, Kano, Katsina, Kebbi, Kogi, Kwara, Lagos, Nasarawa, Niger, Ogun, Ondo, Osun, Oyo, Plateau, Rivers, Sokoto, Taraba, Yobe, Zamfara'
  );
  $scope.searchbox   = document.getElementById("ikeyword_search");
  $scope.locationbox = document.getElementById('ilocation_search');
  if($scope.searchbox != null){
    $scope.awesomplete = new Awesomplete(document.getElementById("ikeyword_search"), { list: ["heartbreak"] }); 
    var loc_dropdown = new Awesomplete('#ilocation_search', { minChars: 0 });
  }
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
});
healthapp.controller('CreateAccount',function($scope,$http){
  $scope.isDoctor = true;
});

healthapp.controller('patient_appointments', function($scope, $http){
  $('#calendar').fullCalendar({
    width: 20
    // aspectRatio: 0.5
      // put your options and callbacks here
  });
  
  $scope.date_start = '2017-07-02 13:00';
  $scope.date_end   = '2017-07-02 14:30';
  $scope.date_value = 'open';

  $scope.schedule=[{name:"John Smith"},{name:"Pedro Garcia"},{name:"Jane Doe"},{name:"Alejandra Lopez"}];

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