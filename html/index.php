<?php
  session_start();
  if($_SESSION['valid']){
    // header('Location: page/home.php') ;
  }
?>
<html ng-app="healthapp">
<head>
<title>Neolafia</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="app.js"></script>

<link rel="stylesheet" href="awesomplete/awesomplete.css" />
<script src="awesomplete/awesomplete.js" async></script>

<script>

function navView(page){

$(document).ready(function(){

  $( "#ikeyword_search" ).on('update_dropdown',function(event) {
    // alert($('').text);
  });

  var input_plc = "Enter your symptoms, a doctor\'s name, or a medical speciality";

  $('#ikeyword_search')
    .attr('placeholder',input_plc);
    
});


</script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="forms.css"> 
<link rel="stylesheet" type="text/css" href="styles/styles.css"> 

</head>

<body ng-controller="HealthController">
  <span ng-init='init_view()' />
  <div class='boat'>
    <span>
    <h1 class='Neolafia' style='position:relative'>
      <img src='../images/logo.png' style='height:1em;'/>
      Neolafia
      <span class='banner-button-container' >
        <a class='banner-button' href='createaccount.php'>sign up</a>
        <a class='banner-button' href='login.php'>sign in</a>
      </span>
    </h1>
    <div>
      <div class='question-container'>
        <div class='question'>
          <h2>Looking for a doctor?</h2>
          <form method='GET' action='views/doctor_search.php' class="form-style-8 white">
            <input name='q' id="ikeyword_search" type="text" ng-model="keyword_search"
                   autofocus ng-change='update_dropdown()' />
          </form>
        </div>
      </div>
    </div>  
  </div>
  <div class='frontpage-body'>
    <div class='frontpage-container'>
      <div class='frontpage-entry'>
        <h2 class='frontpage-heading'>Are you a Medical Professional?</h2>
        <div class='frontpage-text'>
        We could use your help! Make a difference around you by lorem ispum dolor sit amet!
        </div>
      </div>
      <div class='frontpage-entry'>
        <h2 class='frontpage-heading'>Connect with Medical Specialists near You</h2>
        <div class='frontpage-text'>
          Cough that just won't go away? Back pain keeping you up? We make finding
          a medical specialist easy. Lorem ipsum, sign up to try it out!
        </div>
      </div>
    </div>
  </div>
</body>
</html>