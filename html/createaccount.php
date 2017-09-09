<?php
    error_reporting(0);
  session_start();
  if($_SESSION['valid']){
    header("Location: http://".$_SERVER['HTTP_HOST'].'/page/home.php');
  }
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

<script src="/js/bootstrap.min.js"></script>
<script src="/createaccount.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="/styles/date.css"> 
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  $(document).ready(function () {
      
      var $pageTitle = $("#pageName").data('page-title');
        $("ul.navbar-nav li#"+$pageTitle).addClass("active");
      
    var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var nameRegex = /^[a-zA-Z]+$/;
    $("#iUr").click(function () {
        var isValid = true;
        $("#error, #errorFn, #errorLn, #errorEm, #errorPw, #errorPwc, #errorDob, #errorSx, #errorAd").html("");
        if(!$("#iFn").val().trim() || $("#iFn").val().trim()===""){
            isValid = false;
            $("#errorFn").html("Please enter your first name");
        }
        if($("#iFn").val().trim()!==""){
            if(!nameRegex.test($("#iFn").val().trim()) || $("#iFn").val().trim().length < 2){
                isValid = false;
                $("#errorFn").html("Please enter a valid name");
            }
        }
        if(!$("#iLn").val().trim() || $("#iLn").val().trim()===""){
            isValid = false;
            $("#errorLn").html("Please enter your surname");
        }
        if($("#iLn").val().trim()!==""){
            if(!nameRegex.test($("#iLn").val().trim()) || $("#iLn").val().trim().length < 2){
                isValid = false;
                $("#errorLn").html("Please enter a valid name");
            }
        }
        if(!$("#iEm").val() || $("#iEm").val()===""){
            isValid = false;
            $("#errorEm").html("Please enter your email address");
        }
        if($("#iEm").val()!==""){
            if(!emailRegex.test($("#iEm").val())){
                isValid = false;
                $("#errorEm").html("Please enter a valid email address");
            }
        }
        if(!$("#iPw").val() || $("#iPw").val()===""){
            isValid = false;
            $("#errorPw").html("Please enter your password");
        }
        if($("#iPw").val()!==""){
            if($("#iPw").val().length < 8){
                isValid = false;
                $("#errorPw").html("Password must be a minimum of 8 characters");
            }
        }
        if(!$("#cPw").val() || $("#cPw").val()===""){
            isValid = false;
            $("#errorPwc").html("Please confirm your password");
        }
        if($("#iPw").val()!=="" && $("#cPw").val()!==""){
            if($("#iPw").val()!==$("#cPw").val()){
                $("#errorPwc").html("Passwords do not match! (Passwords are case sensitive)");
                isValid = false;
            }
        }
        if(!$("#year").val() || !$("#month").val() || !$("#day").val() || $("#year").val()==="" || $("#month").val()==="" || $("#day").val()===""){
            isValid = false;
            $("#errorDob").html("Please choose your date of birth");
        }
        if(!$("#iSx").val() || $("#iSx").val()===""){
            isValid = false;
            $("#errorSx").html("Please choose your sex");
        }
        if($("#str").val().trim()==="" || $("#cit").val().trim()==="" || $("#sta").val().trim()===""){
            isValid = false;
            $("#errorAd").html("Please enter your full home address");
        }
        if($("#str").val().trim()!=="" && $("#cit").val().trim()!=="" && $("#sta").val().trim()!==""){
            if($("#str").val().trim().length < 2 || $("#cit").val().trim().length < 2 || $("#sta").val().trim().length < 2){
                isValid = false;
                $("#errorAd").html("Please enter a valid address");
            }
        }
        if(isValid===true){
            $('#error').html("<b class='text-success'>Getting you on board...</b><br/><br/>");
            var formData = {
                nFn:$("#iFn").val().trim(),
                nLn:$("#iLn").val().trim(),
                year:$("#year").val(),
                month:$("#month").val(),
                day:$("#day").val(),
                nSx:$("#iSx").val(),
                nAd:$("#str").val().trim(),
                nAd2:$("#cit").val().trim(),
                nAd3:$("#sta").val().trim(),
                nEm:$("#iEm").val(),
                nPw:$("#iPw").val(),
                nIsD:$("#nIsD").val()
            };
            $.ajax({
                type: "POST",
                url: "ajax/try_create_account.php", //serverside
                data: formData,
                beforeSend: function () {
                    //show loading image
                },
                success: function (result) {
                    //console.log(result); //use this to see the response from serverside
                    value = JSON.parse(result);
                    if(value.success == "true"){
                      goto('index.php');
                    }
                    else{
                      //console.log(value);
                      $('#error').html(value.msg);
                    }
                    //console.log('done');
                },
                error: function (e) {
                    //console.log(e); //use this to see an error in ajax request
                }
            });
        }
    });
    $("#toggle_regr_type").click(function (){
      // $scope.is_doctor = !$scope.is_doctor;
    });
});
</script>
<title>Neolafia | Sign up</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
</head>
<body ng-app="InputDOB" ng-controller="DateController" ng-cloak>
    <div class="full-page">
    <div id="pageName" data-page-title="signupPage"></div>
        <?php include 'navbar.php'; ?>
        <div class="container-fluid simple-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Create an Account</h4>
                    </div>
                    <div class="col-sm-offset-2 col-sm-8 login-form signup-form">
                        <div class="med-prof alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">
                                &times;
                            </button>
                            <p>Are you a medical professional? 
                                Click <a id="toggle_regr_type" href='new/doctor.php'>here</a>
                                to register as a doctor
                            </p>
                        </div>
                        <div id="error" class="text-danger text-center"></div>
                        <form class="contact-form" id = "form_req" role = "form" ng-submit="form.$valid && false">
                            <input type="hidden" name="nIsD" id="nIsD" value="false"  />
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iFn" class="control-label">First Name: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nFn" ng-model="nFn" id="iFn" type="text" placeholder="Andrew" 
                                       autocomplete="off" ng-required="true" ng-minlength="3" class="form-control">
                                </div>
                                <div id='errorFn' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iLn" class="control-label">Surname: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nLn" ng-model="nLn" id="iLn" type="text" placeholder="Smith" 
                                       ng-required="true" class="form-control">
                                </div>
                                <div id='errorLn' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iEm" class="control-label">Email Address: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nEm" ng-model="nEm" id="iEm" type="email" class="form-control"
                                       placeholder="andrew@mydomain.com" ng-required="true">
                                </div>
                                <div id='errorEm' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iPw" class="control-label">Password: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nPw" ng-model="nPw" id="iPw" type="password" ng-model="pword" class="form-control"
                                       placeholder="Password" autocomplete="off" ng-required="true" ng-minlength="8">
                                </div>
                                <div id='errorPw' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="cPw" class="control-label">Confirm Password: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="cPw" ng-model="cPw" id="cPw" type="password" ng-model="cpword" class="form-control"
                                       placeholder="Confirm Password" autocomplete="off" ng-required="true" ng-minlength="8">
                                </div>
                                <div id='errorPwc' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="control-label">Date of Birth: </label>
                                </div>
                                <div id="dob-year" class="col-sm-3">
                                    <select name="year" id="year" ng-model="year" ng-change="updateDate('year')"
                                            onchange="changeMe(this)" ng-required="true" class="form-control">
                                        <option value='' disabled>Year</option>
                                        <option ng-repeat="y in years" value="{{y}}">{{y}}</option>
                                    </select>
                                </div>
                                <div id="dob-month" class="col-sm-3">
                                    <select name="month" id="month" ng-model="month" ng-change="updateDate('month')"
                                            onchange="changeMe(this)" ng-required="true" class="form-control">
                                        <option value='' disabled>Month</option>
                                        <option ng-repeat="m in months" value="{{m.id}}">{{m.name}}</option>
                                    </select>
                                </div>
                                <div id="dob-day" class="col-sm-3">
                                    <select name="day" id="day" ng-model="day" ng-change="updateDate('day')"
                                            onchange="changeMe(this)" required class="form-control">
                                        <option value='' disabled>Day</option>
                                        <option ng-repeat="d in days | daysInMonth:year:month | validDays:year:month" value="{{d}}">{{d}}</option>
                                    </select>
                                </div>
                                <div id='errorDob' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iSx" class="control-label">Sex: </label>
                                </div>
                                <div class="col-sm-9">
                                    <select name="nSx" id="iSx" ng-model="nSx" class="form-control" required>
                                        <option value='' disabled>Choose Sex</option>
                                        <option value="F">Female</option>
                                        <option value="M">Male</option>
                                    </select>
                                </div>
                                <div id='errorSx' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="control-label">Home Address: </label>
                                </div>
                                <div class="col-sm-5">
                                    <input id="str" name="str" ng-model="str" type="text"  class="form-control"
                                           placeholder="1234 Some Street" ng-required="true">
                                </div>
                                <div class="col-sm-2">
                                    <input id="cit" name="cit" ng-model="cit" type="text" placeholder="City"
                                           ng-required="true" class="form-control">
                                </div>
                                <div class="col-sm-2">
                                    <input id="sta" name="sta" ng-model="sta" type="text" placeholder="State" 
                                           ng-required="true" class="form-control">
                                </div>
                                <div id='errorAd' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <br/>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input name="nUr" id="iUr" name="create" type="submit" value="Create Account"
                                       class="btn btn-success pull-right"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-12">
                        <p class="text-center text-success">
                            Already have an account? Click 
                            <a href="/login.php">here</a>
                            to sign in
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  include 'footer.php'; ?>
</body>
</html>