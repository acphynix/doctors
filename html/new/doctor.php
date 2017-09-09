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
<!--<link rel="stylesheet" type="text/css" href="/styles/date.css">--> 
<link rel="stylesheet" type="text/css" href="/forms.css">
<link rel="stylesheet" type="text/css" href="/styles/account-doctor.css">   
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
      
    var phoneRegex = /^[0]{1}(\d){10}$/;
    var medIdRegex = /^\d{5}$/;
    var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var nameRegex = /^[a-zA-Z]+$/;
    $("#iUr").click(function () {
        var isValid = {};
        isValid.stat = true;
        $("#error, #errorPw, #errorPhn, #errorEm, #errorMId, #errorLic, \n\
            #errorAd, #errorNm, #errorQct, #errorChs, #errroAff").html('');
        $.each($('#form_req select'), function(k,v){
            if(!$(this).val() || $(this).val()===""){
                isValid.stat = false;
            }
        });
        $.each($('#form_req input'), function(k,v){
            if(!$(this).val().trim() || $(this).val().trim()===""){
                isValid.stat = false;
            }
        });
        if($("#nFn").val().trim()!=="" && $("#nLn").val().trim()!==""){
            if(!nameRegex.test($("#nFn").val().trim()) || $("#nFn").val().trim().length < 2 ||
                !nameRegex.test($("#nLn").val().trim()) || $("#nLn").val().trim().length < 2){
                isValid.stat = false;
                $("#errorNm").html("First and last names must be valid names");
            }
        }
        if($("#nPw").val()!=="" && $("#nPw").val().length < 8){
            $(".errorPw").removeClass('hide');
            $("#errorPw").html("Passwords must be minimum of 8 characters");
            isValid.stat = false;
        }
        if($("#nPw").val().length >= 8 && !$("#nPw2").val()){
            $("#errorPw").html("Please confirm password");
            isValid.stat = false;
        }
        if($("#nPw").val().length >= 8 && $("#nPw2").val()!=="" && $("#nPw").val()!==$("#nPw2").val()){
            $("#errorPw").html("Passwords do not match! (Passwords are case sensitive)");
            isValid.stat = false;
        }
        if($("#nPhn").val()!==""){
            if(!phoneRegex.test($("#nPhn").val())){
                $("#errorPhn").html("Invalid phone number!");
                isValid.stat = false;
            }
        }
        if($("#nEm").val()!==""){
            if(!emailRegex.test($("#nEm").val())){
                $("#errorEm").html("Invalid email address!");
                isValid.stat = false;
            }
        }
        if($("#iLi").val()!==""){
            if(!medIdRegex.test($("#iLi").val())){
                $("#errorMId").html("Invalid Id!");
                isValid.stat = false;
            }
        }
        if($("#nAd").val().trim()!=="" && $("#nAd2").val().trim()!=="" && $("#nAd3").val().trim()!==""){
            if($("#nAd").val().trim().length < 2 || $("#nAd2").val().trim().length < 2 || $("#nAd3").val().trim().length < 2){
                isValid = false;
                $("#errorAd").html("Please enter a valid address");
            }
        }
        if($("#iChs").val().trim()!==""){
            if($("#iChs").val().trim().length < 2){
                isValid.stat = false;
                $("#errorChs").html("Please enter a valid hospital name and address");
            }
        }
        if($("#iQct").val().trim()!==""){
            if($("#iQct").val().trim().length < 2){
                isValid.stat = false;
                $("#errorQct").html("Please enter valid qualifications and ceritifications");
            }
        }
        if($("#iAff").val().trim()!==""){
            if($("#iAff").val().trim().length < 2){
                isValid.stat = false;
                $("#errorAff").html("Please enter valid professional affiliations");
            }
        }
        if(!$("#iNig").is(":checked")){
            $("#errorLic").html("You must be licensed to register!");
            isValid.stat = false;
        }
        if(isValid.stat === false){
            $("#error").html('<b class="text-danger">Please correctly supply information for ALL fields before submitting</b>');
        }
        if(isValid.stat === true){
            $("#error").html('<b class="text-success">Getting you started...</b>');
            var formData = $("#form_req").serialize();
            $.ajax({
                type: "POST",
                url: "/ajax/try_create_account.php", //serverside
                data: formData,
                beforeSend: function () {
                    //show loading image
                },
                success: function (result) {
                    console.log(result); //use this to see the response from serverside
                    value = JSON.parse(result);
                    if(value.success == "true"){
                      location.href = '/index.php';
                    }
                    else{
                      console.log(value);
                      $('#error').html('<b class="text-danger">'+value.msg+'</b>');
                    }
                    console.log('done');
                },
                error: function (e) {
                    console.log(e); //use this to see an error in ajax request
                }
            });
        }
    });
    var options = $('#iSpc').get(0).options;
    function specialities(){
        return ['Cardiology', 'Clinical Heamatology', 'Dentistry', 'Dermatology', 'Endocrinology', 'ENT',
                'Family Medicine', 'Gastroenterology', 'General Suregry', 'Nephrology', 'Neurology',
                'Obstetrics & Gynaecology', 'Opthalmology', 'Orthopedics', 'Paediatrics', 'Plastic Surgery',
                'Respiratory medicine', 'Rheumatology', 'Urology'];
    }

    $.each(specialities(), function(key, value) {
      options[options.length] = new Option(value, value);
    });
    options = $('#iLoc').get(0).options;
    $.each(['Abia', 'Adamawa', 'Anambra', 'Akwa Ibom', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Enugu', 'Edo', 'Ekiti', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos: Agege', 'Lagos: Ajeromi-Ifelodun', 'Lagos: Alimosho', 'Lagos: Amuwo-Odofin', 'Lagos: Apapa', 'Lagos: Badagry', 'Lagos: Epe', 'Lagos: Eti-Osa', 'Lagos: Ibeju-Lekki', 'Lagos: Ifako-Ijaiye', 'Lagos: Ikeja', 'Lagos: Ikorodu', 'Lagos: Kosofe', 'Lagos: Lagos Island', 'Lagos: Lagos Mainland', 'Lagos: Mushin', 'Lagos: Ojo', 'Lagos: Oshodi-Isolo', 'Lagos: Somolu', 'Lagos: Surulere', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara', 'Abuja (FCT)'], function(key, value) {
      options[options.length] = new Option(value, key);
    });
});
</script>
<title>Neolafia | Doctor's Sign up</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
</head>
<body ng-app="InputDOB" ng-controller="DateController" ng-cloak>
    <div class="full-page">
    <div id="pageName" data-page-title="signupPage"></div>
        <?php include '../navbar.php'; ?>
        <div class="container-fluid simple-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Doctor's Registration</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 doc-signup">
                        <h4 class="text-orange"><b>New here? Enter details below to register right away</b></h4>
                        <form class='contact-form' id = "form_req" role = "form" ng-submit="form.$valid && false">
                            <input type='hidden' name='nIsD' value='true' />
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="control-label">Name: </label>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <input ng-required='true' id="nFn" name='nFn' ng-model="nFn" type="text"
                                           ng-app=""autofocus placeholder="First Name" class="form-control"/>
                                </div>
                                <div class="col-sm-5">
                                    <input ng-required='true' id="nLn" name='nLn' ng-model='nLn' type="text"
                                    autofocus placeholder="Last Name" class="form-control"/>
                                </div>
                                <div id='errorNm' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="control-label">DOB: </label>
                                </div>
                                <div id="dob-year" class="col-sm-3">
                                    <select ng-required=true name="year" id="year" ng-model="year" 
                                            ng-change="updateDate('year')" onchange="changeMe(this)" 
                                            ng-required="true" class="form-control">
                                        <option value='' disabled>Year</option>
                                        <option ng-repeat="y in years" value="{{y}}">{{y}}</option>
                                    </select>
                                </div>
                                <div id="dob-month" class="col-sm-3">
                                    <select ng-required=true name="month" id="month" ng-model="month" 
                                            ng-change="updateDate('month')" onchange="changeMe(this)" 
                                            ng-required="true" class="form-control">
                                        <option value='' disabled>Month</option>
                                        <option ng-repeat="m in months" value="{{m.id}}">{{m.name}}</option>
                                    </select>
                                </div>
                                <div id="dob-day" class="col-sm-3">
                                    <select ng-required=true name="day" id="day" ng-model="day" class="form-control"
                                            ng-change="updateDate('day')" onchange="changeMe(this)" 
                                            required>
                                        <option value='' disabled>Day</option>
                                        <option ng-repeat="d in days | daysInMonth:year:month | validDays:year:month" value="{{d}}">{{d}}</option>
                                    </select>
                                </div>
                                <!--<div id='errorDob' class="col-sm-offset-3 pad-left text-danger"></div>-->
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iSx" class="control-label">Sex: </label>
                                </div>
                                <div class="col-sm-9">
                                    <select ng-required=true id='iSx' name='nSx' class="form-control">
                                        <option value='' disabled selected>Choose Sex</option>
                                        <option value='F'>Female</option>
                                        <option value='M'>Male</option>
                                    </select>
                                </div>
                                <!--<div id='errorSx' class="col-sm-offset-3 pad-left text-danger"></div>-->
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="control-label">Address: </label>
                                </div>
                                <div class="col-sm-5">
                                    <input name="nAd" id="nAd" ng-model="nAd" ng-required='true' name='q' type="text"
                                            autofocus placeholder="Street Address" class="form-control"/>
                                </div>
                                <div class="col-sm-2">
                                    <input name="nAd2" id="nAd2" ng-model="nAd2" ng-required='true' name='q' type="text"
                                            autofocus placeholder="City" class="form-control"/>
                                </div>
                                <div class="col-sm-2">
                                    <input name="nAd3" id="nAd3" ng-model="nAd3" ng-required='true' name='q' type="text"
                                            autofocus placeholder="State" class="form-control"/>
                                </div>
                                <div id='errorAd' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="nPhn" class="control-label">Phone: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nPhn" id="nPhn" ng-model="nPhn" ng-required='true' name='q' type="text"
                                        autofocus placeholder="08012345678" class="form-control"/>
                                </div>
                                <div id='errorPhn' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="nEm" class="control-label">Email: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nEm" id="nEm" ng-model="nEm" ng-required='true' name='q' type="email"
                                        autofocus placeholder="doctor@yahoo.com" class="form-control"/>
                                </div>
                                <div id='errorEm' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="control-label">Password: </label>
                                </div>
                                <div class="col-sm-5">
                                    <input name="nPw" id="nPw" ng-model="pword" type='password' ng-required='true'
                                        placeholder="Password" autocomplete='off' ng-minlength='8' class="form-control"/>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <input name="nPw" id="nPw2" ng-model="pword2" type='password' ng-required='true'
                                           placeholder="Retype Password" autocomplete='off' ng-minlength='8' class="form-control"/>
                                </div>
                                <div id='errorPw' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <br/><hr/>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iLi" class="control-label">Med ID: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nLi" ng-model="nLi" id="iLi" ng-required='true' name='q' type="text"
                                           autofocus placeholder="Medical Registration Number" class="form-control"/>
                                </div>
                                <div id='errorMId' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iSpc" class="control-label">Speciality: </label>
                                </div>
                                <div class="col-sm-9">
                                    <select ng-required=true id='iSpc' name='nSpc' class="form-control">
                                        <option value='void' disabled selected>Choose Speciality</option>
                                    </select>
                                </div>
                                <!--<div id='errorMId' class="col-sm-offset-3 pad-left text-danger"></div>-->
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iLoc" class="control-label">Location: </label>
                                </div>
                                <div class="col-sm-9">
                                    <select ng-required=true id='iLoc' name='nLoc' class="form-control">
                                        <option value='void' disabled selected>Choose Location</option>
                                    </select>
                                </div>
                                <!--<div id='errorMId' class="col-sm-offset-3 pad-left text-danger"></div>-->
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iChs" class="control-label">Hospital Name and Address: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nChs" ng-model="nChs" id="iChs" ng-required='true' name='q' type="text"
                                           autofocus placeholder="Lagos University" class="form-control"/>
                                </div>
                                <div id='errorChs' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iQct" class="control-label">Certifications: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nQct" ng-model="nQct" id="iQct" ng-required='true' name='q' type="text"
                                           autofocus placeholder="Qualifications and Certifications" class="form-control"/>
                                </div>
                                <div id='errorQct' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="iAff" class="control-label">Professional Affilations: </label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="nAff" ng-model="nAff" id="iAff" ng-required='true' name='q' type="text"
                                           autofocus placeholder="Professional Affilations" class="form-control"/>
                                </div>
                                <div id='errorAff' class="col-sm-offset-3 pad-left text-danger"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <p class="help-block">
                                        I verify that I am currently licensed to practice medicine in Nigeria:
                                    </p>
                                    <input ng-required='true' name="nNig" ng-model="nNig" id="iNig" 
                                           type="checkbox" class="checkbox">
                                    <div id='errorLic' class="text-danger"></div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group row">
                                <div id='error'></div>
                                <div class="col-sm-12">
                                    <input ng-required='true' id="iUr" name='create' type='submit' value='Create Account'
                                           class="btn btn-success pull-right"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="visible-xs">
                        <br/><hr/>
                    </div>
                    <div class="col-sm-offset-1 col-sm-3 side-perks">
                        <div class="">
                            <div class="row">
                                <h4 class="text-info"><i class="fa fa-clock-o"></i></h4>
                                <p>
                                    <span class="text-info">We value your time</span><br/>
                                    All appointments are paid for before service
                                </p>
                            </div>
                            <hr/>
                            <div class="row">
                                <h4 class="text-danger"><i class="fa fa-medkit"></i></h4>
                                <p>
                                    <span class="text-danger">We value your business</span><br/>
                                    Expand your practice with access to more clients
                                </p>
                            </div>
                            <hr/>
                            <div class="row">
                                <h4 class="text-success"><i class="fa fa-dollar"></i></h4>
                                <p>
                                    <span class="text-success">We make you money</span><br/>
                                    Make some extra cash to supplement your practice
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  include '../footer.php'; ?>
</body>
</html>