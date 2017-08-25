<?php
  session_start();
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];
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
    var input_plc = "symptoms or medical speciality";

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
  <div class='seg-title' style='background-color:green'>
    <div class='heading-container' style='padding:1em;padding-right:0;overflow:hidden;position:relative'>
      <span class='pane-heading' style='float:left;position:inline-block;padding:1em;padding-left:3em'>
        <h1 class='title' style='padding:0;margin:0;font-size:6vw;color:white'>Neolafia</h1>
        <h2 class='title' style='color:gold;padding:0;margin:0;font-size:1.66vw;font-family:Cabin;font-style:italic'>Healthcare at your fingertips</h2>
      </span>
      <span class='right-container' style='float:right'>
        <span class='pane-options' style='position:absolute;right:0;height:100%;'>
          <div style='height:40px'></div>
          <a class='highlighter' href='/new/doctor.php' style='float:right;position:relative;right:0;background-color:orange;color:black;font-size:2vw;padding:0.25em 3.5em 0.25em 0.5em;min-width:30vw'>
            <?php if($login>0){ ?>
              Welcome, <?php echo $displayname ?>!
            <?php }else{ ?>
              Are you a specialist doctor?
            <?php } ?>
          </a>
          <div class='options-small' style='position:absolute; bottom: 1vw;font-size:1.5vw;padding:1vw'>
            <?php if($login>0){ ?>
              <a href='/page/home.php' class='banner-button' style='padding-right:3vw'>Dashboard</a>
              <a href='/logout.php' class='banner-button' style='padding-right:3vw'>Sign out</a>
            <?php }else{ ?>
              <a href='/createaccount.php' class='banner-button' style='padding-right:3vw'>Sign up </a>
              <a href='/login.php' class='banner-button' style='padding-right:3vw'>Log In </a>
            <?php } ?>
              <a href='mailto:neolafia@neolafia.com' class='banner-button' style='padding-right:3vw'>Contact Us</a>
          </div>
        </span>
      </span>
    </div>
  </div>
  <div class='seg-bigsearch' style='background-color:white;overflow:hidden'>
    <div class='question' style='font-family:Cabin; font-size:4vw; padding:8vw;overflow:hidden; float:left; width: 34vw; height:30vh; text-align:center'>
      Need to see a specialist doctor?
    </div>
    <div class='answer' style='font-family:Cabin; font-size:4vw; padding:8vw 2vw 0vw 0vw;overflow:hidden; position:absolute; right:0; width: 46vw'>
      <form class='form-frontpage' method='GET' action='views/doctor_search.php' >
        <table>
          <tr>
            <td class='label'><div>What are you looking for</div></td>
            <td class='field'>
              <input name='q' id="ikeyword_search" type="text" ng-model="keyword_search"
                   autofocus ng-keypress='update_dropdown()' autocomplete="off" placeholder="symptoms, doctor's name, speciality"/>
            </td>
          </tr>
          <tr>
            <td class='label'><div>Location</div></td>
            <td class='field'>
              <input name='c' id="ilocation_search" type="text" ng-model="keyword_search"
                   autocomplete="off" placeholder="Eti-osa, Kosofe, Oshodi"/>
            </td>
          </tr>
        </table>
        <div class='button-container'>
          <input type='submit' value='Search' />
        </div>
      </form>
    </div>
  </div>
  <div class='marquee'>
    <table style='width:100%'>
      <tr>
      <td>
        <img style='position:inline' src='/images/icon_doctor.png' />
      </td>
      <td>
        <div>
          Get treated by specialist doctors only - the most qualified in the medical profession
        </div>
      </td>
      <td>
        <img style='position:inline' src='/images/icon_clock.png' />
      </td>
      <td>
        <div>
          Save time by skipping the long queues at the hospital
        </div>
      </td>
      <td>
        <img style='position:inline' src='/images/icon_money_usd.png' />
      </td>
      <td>
        <div>
          Save the booking costs when you pay the consultation fee
        </div>
      </td>
      </tr>
    </table>
  </div>
  <div class='seg-footer' style='background-color:#e1efd8'>
    <div style='text-align:center;font-family:Cabin;padding:1vw'>
      Copyright © 2017 Neolafia. All Rights Reserved. <br />
      neolafia@neolafia.com <br />
      +234.803.464.6465 <br />
    </div>
  </div>
<!--   <div class='boat'>
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
  </div> -->
<!--   <div class='frontpage-body'>
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
  </div> -->
</body>
</html>