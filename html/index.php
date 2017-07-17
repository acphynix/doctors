<?php
  session_start();
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
?>
<html ng-app="healthapp">
<head>
<title>Neolafia</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="app.js"></script>

<link rel="stylesheet" href="awesomplete/awesomplete.css" />
<script src="awesomplete/awesomplete.js"></script>

<script type="text/javascript" async>
  $( document ).ready(function() {
    var input_plc = "Enter your symptoms, a doctor\'s name, or a medical speciality";

    $('#ikeyword_search')
      .attr('placeholder',input_plc);
  });
</script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin|Courgette" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="forms.css"> 
<link rel="stylesheet" type="text/css" href="styles/styles.css"> 

</head>

<body ng-controller="HealthController" style='margin:0'>
  <span ng-init='init_view()' />
  <div class='boat'>
    <span>
    <h1 class='Neolafia' style='position:relative'>
      <img src='../images/logo.png' style='height:1em;'/>
      Neolafia
      <span class='banner-button-container' >
        <?php if($login>0){ ?>
          <a class='banner-welcome-text banner-button' href='page/home.php'><?php echo $displayname ?></a>
          <a class='banner-button' href='logout.php'>sign out</a>
        <?php }else{ ?>
          <a class='banner-button' href='createaccount.php'>sign up</a>
          <a class='banner-button' href='login.php'>sign in</a>
        <?php } ?>
      </span>
    </h1>
    <div>
      <div class='question-container'>
        <div class='question'>
          <h2>Looking for a doctor?</h2>
          <form method='GET' action='views/doctor_search.php' class="form-style-8 white banner_search">
            <input name='q' id="ikeyword_search" type="text" ng-model="keyword_search"
                   autofocus ng-keypress='update_dropdown()' autocomplete="off" />
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