<?php
  session_start();
  if(!$_SESSION['valid']){
    header('Location: ../index.php') ;
  }
?>
<html ng-app="dashboard">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>


<link rel="stylesheet" type="text/css" href="/lib/fullcalendar/fullcalendar.css">
<link rel="stylesheet" type="text/css" href="/styles/calendar.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
<script src='/lib/fullcalendar/fullcalendar.js'></script>
<script src='http://momentjs.com/downloads/moment.min.js'></script>

<script src="/awesomplete/awesomplete.js"></script>
<script src="/ajs_modules/dashboard.js"></script>

<script>
  function goto(newpage){
    window.location.href = newpage;
  }
  window.is_doctor = <?php echo $_SESSION['user_is_doctor']?'true':'false' ?>
</script>


<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="../forms.css"> 

<title>Neolafia</title>
</head>
<body ng-controller="navigation">
  <div class='noboat'>
    <h1 class='clickme Neolafia' style='position:relative;margin-bottom:0;padding-bottom:0' onclick="goto('../index.php')">
      <img src='../images/logo.png' style='height:1em;'/>
      Neolafia
      <span class='banner-button-container' >
        <a class='banner-button' href='../logout.php'>sign out</a>
      </span>
    </h1>
  </div>
  <div class='dashboard-container'>
    <div class='dashboard-topnav'>
      <div class='dashboard-navitem' onclick="goto('/views/doctor_search.php')"> search       </div>
      <div class='dashboard-navitem' ng-click="view='appts.display'"> appointments </div>
      <div class='dashboard-navitem' ng-click="view='profile'"> profile      </div>
      <div class='dashboard-navitem' ng-click="view='messages'"> messages     </div>
    </div>
  </div>
  <div class='dashboard-body' style='bottom:0px'>

    <div ng-show="is_show('appts')" style='width:100%;padding-top:0em'>

<?php
  if($_SESSION['user_is_doctor']){
    include('_appts_doctor.php');
  }
  else{
    include('_appts_patient.php');
  }
?>
    </div>

    <div ng-show="is_show('profile')">
      <div style='width:100%;text-align:center;margin-top:2em;margin:0'>
        <div style='width:80%;min-width:35em;display:inline-block;text-align:left'>
          <div style='display:block;width:100%;padding:2em'>
            <div style="border:2px black solid;background-image:url({{user.image}});background-size:cover;width:8em;height:8em;margin-left:0;margin-right:1em;display:inline-block;float:left">
            </div>
            <div style='display:inline-block;margin:2em;margin-left:0'>
              <div style='padding:0;margin:0;font-family:cabin;font-size:1.5em'>{{user.name}}</div>
              <div style='padding:0;margin:0;font-family:cabin'>{{user.email}}</div>
              <div style='padding:0;margin:0;font-family:cabin'>{{user.role}}</div>
            </div>
          </div>
          <div class='clickme' style='font-family:Cabin; font-weight:bold; font-size:1.125em;
               margin-top:0; text-align:left; width:100%; background-color:rgba(200,200,100,0.5);
               padding:1em;padding-left:1em;' ng-click="password=!password">
            Change Password
          </div>
          <div ng-show="password" style='width:100%; padding:1.125em; background-color:rgba(200,200,100,0.3)'>
            <form>
              
            </form>
          </div>
        </div>
      </div>
    </div>


    <div ng-show="is_show('messages')">
      messages
    </div>
  </div>
</body>
</html>