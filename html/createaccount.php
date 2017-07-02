<?php
    ob_start();
    session_start();
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="createaccount.js"></script>
<link rel="stylesheet" type="text/css" href="styles/date.css"> 
<link rel="stylesheet" type="text/css" href="forms.css"> 
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  function submit_request_create(){
    console.log('hi');
    return false;
  }
  $(document).ready(function () {
    $("#iUr").click(function () {
        var formData = $("#form_req").serialize();
        $.ajax({
            type: "POST",
            url: "ajax/try_create_account.php", //serverside
            data: formData,
            beforeSend: function () {
                //show loading image
            },
            success: function (result) {
                console.log(result); //use this to see the response from serverside
                value = JSON.parse(result);
                // if(value.success == "true")location.href = 'accountcreatesuccess.php'
            },
            error: function (e) {
                console.log(e); //use this to see an error in ajax request
            }
        });
    });
    $("#toggle_regr_type").click(function (){
      // $scope.is_doctor = !$scope.is_doctor;
    });
});
</script>
<title>Ekuojumo</title>
</head>
<body ng-app="InputDOB" ng-controller="DateController" style="background: #0a6a8e">
  <div style="justify-content: center; margin:auto; width:80%; padding:10px; display:block; margin-left:auto; margin-right:auto; border:3px solid black; margin: 0 auto; background:{{is_doctor?'#3a5aae':'#2a7aae'}}; min-height:100% ">
    <div class="form-style-8">
    <h2>Create an Account</h2>
    <a class="clickme" ng-show="is_doctor" id="toggle_regr_type" style="color:blue;" ng-click="is_doctor=false">Not a doctor? Click here to register as a patient. 
    <a class="clickme" ng-show="!is_doctor" id="toggle_regr_type" style="color:blue;" ng-click="is_doctor=true">Are you a medical professional? Click here to register as a provider.</a>
    <br />
    <br />
    <form id = "form_req" role = "form" ng-submit="form.$valid && false">
      Given Name:
      <input name="nFn" ng-model="nFn" id="iFn" type="text" placeholder="Michael" autocomplete="off" ng-required="true" ng-minlength="3">
      
      Surname:
      <input name="nLn" ng-model="nLn" id="iLn" type="text" placeholder="Smith" ng-required="true">
      
      E-mail Address:
      <input name="nEm" ng-model="nEm" id="iEm" type="email" placeholder="michael@mydomain.com" ng-required="true">
      
      Password:
      <input name="nPw" ng-model="nPw" id="iPw" type="password" ng-model="pword" placeholder="Password" autocomplete="off" ng-required="true" ng-minlength="8">

      Date of Birth:
      <table><tr><td>
      <div id="dob-year" class="input-wrapper small-4 columns" style="padding-left: 0;">
        <select name="year" id="year" ng-model="year" ng-change="updateDate('year')" onchange="changeMe(this)" ng-required="true">
          <option value='' disabled>Year</option>
          <option ng-repeat="y in years" value="{{y}}">{{y}}</option>
        </select>
      </div>
      </td><td>
      <div id="dob-month" class="input-wrapper small-4 columns">
        <select name="month" id="month" ng-model="month" ng-change="updateDate('month')" onchange="changeMe(this)" ng-required="true">
          <option value='' disabled>Month</option>
          <option ng-repeat="m in months" value="{{m.id}}">{{m.name}}</option>
        </select>
      </div>
      </td><td>
      <div id="dob-day" class="input-wrapper small-4 columns" style="padding-right: 0;">
        <select name="day" id="day" ng-model="day" ng-change="updateDate('day')" onchange="changeMe(this)" required>
          <option value='' disabled>Day</option>
          <option ng-repeat="d in days | daysInMonth:year:month | validDays:year:month" value="{{d}}">{{d}}</option>
        </select>
      </div>  
      </td></tr></table> 

      Sex:
      <select name="nSx" id="iSx" ng-model="nSx" required>
        <option value='' disabled>Choose Sex</option>
        <option value="F">Female</option>
        <option value="M">Male</option>
      </select>

      Address:
      <input name="nAd" id="nAd" ng-model="nAd" type="text" placeholder="1234 Some Street" ng-required="true">
      
      <span ng-show="is_doctor">
        Medical Registration Number:
        <input name="nLi" ng-model="nLi" id="iLi" type="text" placeholder="XXX-XXX-XXXX" ng-required="is_doctor">

        Clinical Speciality
        <input name="nSpc" ng-model="nSpc" id="iSpc" type="text" ng-required="is_doctor" placeholder="Cardiology">
        Location
        <input name="nLoc" ng-model="nLoc" id="iLoc" type="text" ng-required="is_doctor" placeholder="Ibadan">
        Covered Hospitals
        <textarea name="nChs" ng-model="nChs" id="iChs" rows=6 width="100%" ng-required="is_doctor" placeholder="Lagos University"></textarea>
        Qualifications &amp; Certifications
        <textarea name="nQct" ng-model="nQct" id="iQct" rows=6 width="100%" ng-required="is_doctor" placeholder="[placeholder]"></textarea>
        Professional Affiliations
        <textarea name="nAff" ng-model="nAff" id="iAff" rows=6 width="100%" ng-required="is_doctor" placeholder="[placeholder]"></textarea>
        I verify that I am currently licensed to practice medicine in Nigeria.
        <input name="nNig" ng-model="nNig" id="iNig" type="checkbox"><br /><br />
      </span>
      <input type="hidden" name="nIsD" value="{{is_doctor}}"  />

      <input name="nUr" id="iUr" name="create" type="submit" value="Create Account" />
    </form>
    </div>
  </div>
</body>
</html>