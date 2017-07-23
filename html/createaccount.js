var app = angular.module('InputDOB', []);
app.controller('DateController', ['$scope', function ($scope) {

  $scope.fieldValues = {
    dateOfBirth: ""
  };
  $scope.validateSex = function(sex){
    console.log("valid?");
    return sex=="M" || sex=="F";
  };

  $scope.toggle_isdoctor = function(){
    $scope.is_doctor = !$scope.is_doctor;
  }



  /*Date Of Birth*/
  
  $scope.days = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
  $scope.months = [{id: 1, name:"January"},
           {id: 2, name:"February"},
           {id: 3, name:"March"},
           {id: 4, name:"April"},
           {id: 5, name:"May"},
           {id: 6, name:"June"},
           {id: 7, name:"July"},
           {id: 8, name:"August"},
           {id: 9, name:"September"},
           {id: 10, name:"October"},
           {id: 11, name:"November"},
           {id: 12, name:"December"}
          ];
  $scope.years = [];
  var d = new Date();
  for (var i = (d.getFullYear() - 1); i > (d.getFullYear() - 100); i--) {
    $scope.years.push(i+'');
  }
  
  $scope.year = "";
  $scope.month = "";
  $scope.day = "";
  
  $scope.updateDate = function (input){ 
    if (input == "year"){
      $scope.month = "";
      $scope.day = "";
    }
    else if (input == "month"){
      $scope.day = "";
    }
    if ($scope.year && $scope.month && $scope.day){
      $scope.fieldValues.dateOfBirth = new Date($scope.year, $scope.month.id - 1, $scope.day);
    }
  };
  
}]);

app.filter('validMonths', function () {
    return function (months, year) {
        var filtered = [];
    var now = new Date();
    var over18Month = now.getUTCMonth() + 1;
    var over18Year = now.getUTCFullYear() - 18;
    if(year != ""){
      if(year == over18Year){
        angular.forEach(months, function (month) {
          if (month.id <= over18Month) {
            filtered.push(month);
          }
        });
      }
      else{
        angular.forEach(months, function (month) {
            filtered.push(month);
        });
      }
    }
        return filtered;
    };
});

app.filter('daysInMonth', function () {
    return function (days, year, month) {
        var filtered = [];
        angular.forEach(days, function (day) {
          if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
            filtered.push(day);
          }
          else if ((month == 4 || month == 6 || month == 9 || month == 11) && day <= 30){
            filtered.push(day);
          }
          else if (month == 2){
            if (year % 4 == 0 && day <= 29){
              filtered.push(day);
            }
            else if (day <= 28){
              filtered.push(day);
            }
          }
        });
        return filtered;
    };
});

app.filter('validDays', function () {
    return function (days, year, month) {
        var filtered = [];
    var now = new Date();
    var over18Day = now.getUTCDate();
    var over18Month = now.getUTCMonth() + 1;
    var over18Year = now.getUTCFullYear() - 18;
    if(year == over18Year && month.id == over18Month){
      angular.forEach(days, function (day) {
        if (day <= over18Day) {
          filtered.push(day);
        }
      });
    }
    else{
      angular.forEach(days, function (day) {
          filtered.push(day);
      });
    }
        return filtered;
    };
});

function changeMe(sel)
{
  sel.style.color = "#000";            
}