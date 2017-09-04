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
<script src="/createaccount.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="/styles/date.css"> 
<link rel="stylesheet" type="text/css" href="/forms.css">
<link rel="stylesheet" type="text/css" href="/styles/account-doctor.css">  
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  $(document).ready(function () {
      
    var phoneRegex = /^[0]{1}(\d){10}$/;
    var medIdRegex = /^\d{5}$/;
    $("#iUr").click(function () {
        var isValid = {};
        isValid.stat = true;
        $(".errorPhn, .errorPw").addClass('hide');
        $("#error,  #errorPw, #errorPhn").html('');
        $.each($('#form_req select'), function(k,v){
            if(!$(this).val() || $(this).val()===""){
                isValid.stat = false;
            }
        });
        $.each($('#form_req input'), function(k,v){
            if(!$(this).val() || $(this).val()===""){
                isValid.stat = false;
            }
        });
        if(isValid.stat === false){
            $("#error").html('Please enter all fields before submitting');
        }
        if($("#nPw").val()!=="" && $("#nPw").val().length < 8){
            $(".errorPw").removeClass('hide');
            $("#errorPw").html("Passwords must be minimum of 8 characters");
            isValid.stat = false;
        }
        if($("#nPw").val().length >= 8 && !$("#nPw2").val()){
            $(".errorPw").removeClass('hide');
            $("#errorPw").html("Please confirm password");
            isValid.stat = false;
        }
        if($("#nPw").val().length >= 8 && $("#nPw2").val()!=="" && $("#nPw").val()!==$("#nPw2").val()){
            $(".errorPw").removeClass('hide');
            $("#errorPw").html("Passwords do not match! (Passwords are case sensitive)");
            isValid.stat = false;
        }
        if($("#nPhn").val()!==""){
            if(!phoneRegex.test($("#nPhn").val())){
                $(".errorPhn").removeClass('hide');
                $("#errorPhn").html("Invalid phone number!");
                isValid.stat = false;
            }
        }
        if($("#iLi").val()!==""){
            if(!medIdRegex.test($("#iLi").val())){
                $(".errorMId").removeClass('hide')
                $("#errorMId").html("Invalid Id!");
                isValid.stat = false;
            }
        }
        
        if(isValid.stat === true){
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
                      $('#error').text(value.msg);
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
<title>Neolafia</title>
</head>
<body style='padding:0' ng-app="InputDOB" ng-controller="DateController">
  <div class='seg-title' style='background-color:green'>
    <div class='heading-container' style='padding:1em;padding-right:0;overflow:hidden;position:relative'>
      <span class='pane-heading clickme' style='float:left;position:inline-block;padding:1em;padding-left:3em' onclick="goto('/index.php')">
        <h1 class='title' style='padding:0;margin:0;font-size:6vw;color:white'>Neolafia</h1>
        <h2 class='title' style='color:gold;padding:0;margin:0;font-size:1.66vw;font-family:Cabin;font-style:italic'>Healthcare at your fingertips</h2>
      </span>
      <span class='right-container' style='float:right'>
        <span class='pane-options' style='position:absolute;right:0;height:100%;'>
          <div style='height:40px'></div>
          <a class='highlighter' href='/index.php' style='float:right;position:relative;right:0;background-color:orange;color:black;font-size:2vw;padding:0.25em 3.5em 0.25em 0.5em;'>
            Are you looking for a doctor?
          </a>
          <div class='options-small' style='position:absolute; bottom: 1vw;font-size:1.5vw;padding:1vw'>
            <?php if($login>0){ ?>
              <a href='/page/home.php' class='banner-button' style='padding-right:3vw'><?php echo $displayname ?></a>
              <a href='/logout.php' class='banner-button' style='padding-right:3vw'>Sign out</a>
            <?php }else{ ?>
              <a href='/createaccount.php' class='banner-button' style='padding-right:3vw'>Sign up </a>
              <a href='/login.php' class='banner-button' style='padding-right:3vw'>Log In </a>
            <?php } ?>
              <a href='/contactus.php' class='banner-button' style='padding-right:3vw'>Contact Us</a>
          </div>
        </span>
      </span>
    </div>
  </div>

  <div class='seg-bigsearch' style='background-color:white;overflow:hidden'>
    <table class='banner-sell-left' style='font-family:Cabin; font-size:2vw; padding:4vw 4vw 4vw 6vw;box-sizing: border-box;overflow:hidden; float:left; width: 40vw; height:34vh; background-color:lightgray; text-align:center'>
    <tr>
      <td>
        <img style='position:inline' src='/images/icon_clock.png' />
      </td>
      <td>
        <h3>We value your time</h3>
        <div>All appointments are paid for before service</div>
      </td>
    </tr>
    <tr>
      <td>
        <img style='position:inline' src='/images/icon_doctor.png' />
      </td>
      <td>
        <h3>We value your business</h3>
        <div>Expand your practice with access to more clients</div>
      </td>
    </tr>
    <tr>
      <td>
        <img style='position:inline' src='/images/icon_money_usd.png' />
      </td>
      <td>
        <h3>We make you money</h3>
        <div>Make some extra cash to supplement your practice</div>
      </td>
    </tr>
    </table>
	<h2 style=" font-size: 1.5vw;">&nbsp;New here? Enter details below to register right away</h2>
    <div class='answer' style='font-family:Cabin; font-size:4vw; padding:2vw 2vw 2vw 2vw;box-sizing: border-box;overflow:hidden; position:absolute; right:0; width: 60vw'>
      <form class='form-frontpage' id = "form_req" role = "form" ng-submit="form.$valid && false">
          <div id='error' style='font-style:italic;font-weight:bold;color:red;font-size: 1.25vw;' ></div>
        <!--<div style='font-style:italic;font-color:gray;font-family:Cabin;font-size:1.33vw;text-align:center;padding-bottom:0.33em'>Personal</div>-->
        <table>
          <tr>
            <td class='label'>Name</td>
            <td class='field'>
                <input ng-required='true' id="nFn" name='nFn' ng-model="nFn" type="text"
                   autofocus placeholder="First Name"/>
            </td>
            <td class='field'>
                <input ng-required='true' id="nLn" name='nLn' ng-model='nLn' type="text"
                   autofocus placeholder="Last Name"/>
            </td>
          </tr>
          <tr>
            <td class='label'>DOB</td>
            <td>
              <div id="dob-year" class="input-wrapper small-4 columns" style="padding-left: 0;">
                <select ng-required=true name="year" id="year" ng-model="year" ng-change="updateDate('year')" onchange="changeMe(this)" ng-required="true">
                  <option value='' disabled>Year</option>
                  <option ng-repeat="y in years" value="{{y}}">{{y}}</option>
                </select>
              </div>
              </td><td>
              <div id="dob-month" class="input-wrapper small-4 columns">
                <select ng-required=true name="month" id="month" ng-model="month" ng-change="updateDate('month')" onchange="changeMe(this)" ng-required="true">
                  <option value='' disabled>Month</option>
                  <option ng-repeat="m in months" value="{{m.id}}">{{m.name}}</option>
                </select>
              </div>
              </td><td>
              <div id="dob-day" class="input-wrapper small-4 columns" style="padding-right: 0;">
                <select ng-required=true name="day" id="day" ng-model="day" ng-change="updateDate('day')" onchange="changeMe(this)" required>
                  <option value='' disabled>Day</option>
                  <option ng-repeat="d in days | daysInMonth:year:month | validDays:year:month" value="{{d}}">{{d}}</option>
                </select>
              </div>  
            </td>
          </tr>
          <tr>
            <td class='label'>Sex</td>
            <td class='field'>
              <select ng-required=true id='iSx' name='nSx' style="width: 95%">
                <option value='' disabled selected>Choose Sex</option>
                <option value='F'>Female</option>
                <option value='M'>Male</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class='label'>Address</td>
            <td class='field'>
              <input name="nAd" id="nAd" ng-model="nAd" ng-required='true' name='q' type="text"
                   autofocus placeholder="Street Address"/>
            </td>
            <td class='field'>
              <input name="nAd2" id="nAd2" ng-model="nAd2" ng-required='true' name='q' type="text"
                   autofocus placeholder="City"/>
            </td>
            <td class='field'>
              <input name="nAd3" id="nAd3" ng-model="nAd3" ng-required='true' name='q' type="text"
                   autofocus placeholder="State"/>
            </td>
          </tr>
          <tr>
            <td class='label'>Phone</td>
            <td class='field'>
              <input name="nPhn" id="nPhn" ng-model="nPhn" ng-required='true' name='q' type="text"
                   autofocus placeholder="08012345678"/>
            </td>
          </tr>
          <tr>
              <td colspan="3" class="errorPhn hide">
                  <div id='errorPhn' style='font-style:italic;font-weight:bold;color:red;font-size: 1vw;'>
                      
                  </div>
              </td>
          </tr>

          <tr>
            <td class='label'>E-mail</td>
            <td class='field'>
              <input name="nEm" id="nEm" ng-model="nEm" ng-required='true' name='q' type="email"
                   autofocus placeholder="doctor@yahoo.com"/>
            </td>
          </tr>
          <tr>
              <td colspan="3" class="errorEm hide">
                  <div id='errorEm' style='font-style:italic;font-weight:bold;color:red;font-size: 1vw;'>
                      
                  </div>
              </td>
          </tr>
          <tr>
            <td class='label'>Password</td>
            <td class='field'>
              <input name="nPw" id="nPw" ng-model="pword" type='password' ng-required='true' placeholder="Password" autocomplete='off' ng-minlength='8'/>
            </td>
            <td class='field'>
              <input name="nPw" id="nPw2" ng-model="pword2" type='password' ng-required='true' placeholder="Retype Password" autocomplete='off' ng-minlength='8'/>
            </td>
          </tr>
          <tr class="errorPw hide">
              <td colspan="3">
                  <div id='errorPw' style='font-style:italic;font-weight:bold;color:red;font-size: 1vw;'>
                      
                  </div>
              </td>
          </tr>
        </table>
        <br />
        <!--<div style='font-style:italic;font-color:gray;font-family:Cabin;font-size:1.33vw;text-align:center;padding-bottom:0.33em'>Professional</div>-->
        <table>
          <tr>
            <td class='label'>Med ID</td>
            <td class='field'>
              <input name="nLi" ng-model="nLi" id="iLi" ng-required='true' name='q' type="text"
                   autofocus placeholder="Medical Registration Number"/>
            </td>
          </tr>
          <tr class="errorMId hide">
              <td colspan="3">
                  <div id='errorMId' style='font-style:italic;font-weight:bold;color:red;font-size: 1vw;'>
                      
                  </div>
              </td>
          </tr>
          <tr>
            <td class='label'>Speciality</td>
            <td class='field'>
              <select ng-required=true id='iSpc' name='nSpc' style="width: 95%">
                <option value='void' disabled selected>Choose Speciality</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class='label'>Location</td>
            <td class='field'>
              <select ng-required=true id='iLoc' name='nLoc' style="width: 95%">
                <option value='void' disabled selected>Choose Location</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class='label'>Hospital Name and Address</td>
            <td class='field'>
              <input name="nChs" ng-model="nChs" id="iChs" ng-required='true' name='q' type="text"
                   autofocus placeholder="Lagos University"/>
            </td>
          </tr>
          <tr>
            <td class='label'>Certifications</td>
            <td class='field'>
              <input name="nQct" ng-model="nQct" id="iQct" ng-required='true' name='q' type="text"
                   autofocus placeholder="Qualifications and Certifications"/>
            </td>
          </tr>
          <tr>
            <td class='label'>Professional Affilations</td>
            <td class='field'>
              <input name="nAff" ng-model="nAff" id="iAff" ng-required='true' name='q' type="text"
                   autofocus placeholder="Professional Affilations"/>
            </td>
          </tr>
        </table>
        <input type='hidden' name='nIsD' value='true' />

        <table class='line'>
          <tr><td style='white-space:nowrap;'>
            I verify that I am currently licensed to practice medicine in Nigeria:
          </td><td style='width:100%'>
            <input ng-required='true' name="nNig" ng-model="nNig" id="iNig" type="checkbox"><br /><br />
          </td></tr>
        </table>

        <div class='button-container'>
          <input ng-required='true' id="iUr" name='create' type='submit' value='Create Account' />
        </div>
      </form>
    </div>
  </div>

</body>
</html>