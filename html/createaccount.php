<?php
  session_start();
  if($_SESSION['valid']){
    header("Location: http://".$_SERVER['HTTP_HOST'].'/page/home.php');
  }
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="createaccount.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="/styles/date.css"> 
<link rel="stylesheet" type="text/css" href="forms.css"> 
<script>
  function goto(newpage){
    window.location.href = newpage
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
                if(value.success == "true"){
                  goto('/index.php');
                }
                else{
                  console.log(value);
                  $('#error').text(value.msg);
                }
                console.log('done');
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
<title>Neolafia</title>
</head>
<body style='padding:0' ng-app="InputDOB" ng-controller="DateController">
<div class='noboat'>
  <a href='index.php'>
  <h1 class='Neolafia' style='position:relative'>
      <img src='../images/logo.png' style='height:1em;'/>
    
      Neolafia
    <!-- </a> -->
  </h1>
  </a>
  </div>
  <div class='account-body'>
    <div class='account-container'>
      <div class='account-entry' style='height:100%'>
        <h2 class='soloheading'>Create An Account</h2>


        <form class="account-form borderless centered"
              id = "form_req" role = "form" ng-submit="form.$valid && false">
            
          <div id='error' style='font-style:italic;font-weight:bold;color:red' ></div>
          <table style='width:100%;'>
            <tr><td style='white-space:nowrap;'>
              First Name:
            </td><td style='width:100%'>
              <input name="nFn" ng-model="nFn" id="iFn" type="text" placeholder="Andrew" autocomplete="off" ng-required="true" ng-minlength="3">
            </td></tr>
            <tr><td style='white-space:nowrap;'>
              Surname:
            </td><td style='width:100%'>
              <input name="nLn" ng-model="nLn" id="iLn" type="text" placeholder="Smith" ng-required="true">
            </td></tr>
            <tr><td style='white-space:nowrap;'>
              E-mail Address:
            </td><td style='width:100%'>
              <input name="nEm" ng-model="nEm" id="iEm" type="email" placeholder="andrew@mydomain.com" ng-required="true">
            </td></tr>
            <tr><td style='white-space:nowrap;'>
              Password:
            </td><td style='width:100%'>
              <input name="nPw" ng-model="nPw" id="iPw" type="password" ng-model="pword" placeholder="Password" autocomplete="off" ng-required="true" ng-minlength="8">
            </td></tr>
            <tr><td style='white-space:nowrap;'>
              Date of Birth:
            </td><td style='width:100%'>
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
            </td></tr>
            <tr><td style='white-space:nowrap;'>
              Sex:
            </td><td style='width:100%'>
              <select name="nSx" id="iSx" ng-model="nSx" required>
                <option value='' disabled>Choose Sex</option>
                <option value="F">Female</option>
                <option value="M">Male</option>
              </select>
            </td></tr>
            <tr><td style='white-space:nowrap;'>
              Home Address:
            </td><td style='width:100%'>
              <input name="nAd" id="nAd" ng-model="nAd" type="text" placeholder="1234 Some Street" ng-required="true">
            </td></tr>
          </table>
          <br />
        
        <div style='text-align:center'>
          <a style='color:green' class="clickme unselectable" id="toggle_regr_type" style="color:blue;" href='/new/doctor.php'>
            <div style='display:block;padding:1em;width:97%;background-color:rgba(100,255,50,0.1)'>Are you a medical professional? Click here to register as a doctor.</div>
          </a> 
        </div>

          <input type="hidden" name="nIsD" value="false"  />
          <br />
          <input name="nUr" id="iUr" name="create" type="submit" value="Create Account" />

        </form>
      </div>
    </div>
  </div>
</body>
</html>