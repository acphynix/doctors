<?php
  session_start();
  if(!$_SESSION['valid']){
    header('Location: ../index.php') ;
  }
  
  $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
  $query = $_SESSION['user_id'];
  $db_1 = sprintf("select user_status from users where user_id = '%s'",$query);

  $dq_1 = mysqli_query($database, $db_1);

  while ($row = $dq_1->fetch_assoc()) {
    if($row['user_status']==='pending'){
        header('Location: ../verificationpending.php');
    }
    if($row['user_status']==='suspended'){
        header('Location: ../accountsuspended.php');
    }
  }
  
?>
<html ng-app="dashboard">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>


<link rel="stylesheet" type="text/css" href="/lib/fullcalendar/fullcalendar.css">
<link rel="stylesheet" type="text/css" href="/styles/calendar.css">
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
<script src='/lib/fullcalendar/fullcalendar.js'></script>
<script src='https://momentjs.com/downloads/moment.min.js'></script>

<script src="/awesomplete/awesomplete.js"></script>
<script src="/ajs_modules/dashboard.js"></script>

<script>
  function goto(newpage){
    window.location.href = newpage;
  }
  window.is_doctor = <?php echo $_SESSION['user_is_doctor']?'true':'false' ?>;
  window.user_id   = <?php echo $_SESSION['user_id']                       ?>;
</script>


<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="../forms.css"> 
<link rel="stylesheet" type="text/css" href="../../styles/home.css">

<title>Neolafia</title>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>
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
      <div class='dashboard-navitem' ng-class="{selected: is_show('appts')}" ng-click="view='appts.display'"> appointments </div>
      <div class='dashboard-navitem' ng-class="{selected: is_show('profile')}" ng-click="view='profile'"> profile      </div>
      <div class='dashboard-navitem' ng-class="{selected: is_show('messages')}" ng-click="view='messages'"> messages     </div>
    </div>
  </div>
  <div class='dashboard-body' style='bottom:0px'>
1
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
      <?php include('_profile.php'); ?>
    <div ng-show="is_show('messages')">
      messages
    </div>
  </div>
</body>
</html>