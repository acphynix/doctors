<?php
error_reporting(0);
  session_start();
  if(!$_SESSION['valid']){
    header('Location: ../index.php') ;
  }
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];
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
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
<script src="/js/touchpunch.js"></script>
<script>
    $("#widget").draggable();
</script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="../lib/fullcalendar/fullcalendar.css">
<link rel="stylesheet" type="text/css" href="../styles/calendar.css">
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
<script src='../lib/fullcalendar/fullcalendar.js'></script>
<script src='https://momentjs.com/downloads/moment.min.js'></script>

<script src="../awesomplete/awesomplete.js"></script>
<script src="../ajs_modules/dashboard.js"></script>

<script>
    $(function(){
        var $pageTitle = $("#pageName").data('page-title');
        $("ul.navbar-nav li#"+$pageTitle).addClass("active");
    });
  function goto(newpage){
    window.location.href = newpage;
  }
  window.is_doctor = <?php echo $_SESSION['user_is_doctor']?'true':'false' ?>;
  window.user_id   = <?php echo $_SESSION['user_id']                       ?>;
</script>


<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="../forms.css"> 
<link rel="stylesheet" type="text/css" href="../styles/home.css">
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>

<title>Neolafia | Dashboard</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
<meta name="description" content="Manage your doctor's appointment, profile, and book new
      appointments with our specialist doctors."/>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>
<body ng-controller="navigation" ng-cloak>
    
    <div class="full-page">
    <div id="pageName" data-page-title="dashboardPage"></div>
        <?php include '../navbar.php'; ?>
        <div class="container-fluid dashboard-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class='dashboard-container'>
                            <div class='dashboard-topnav'>
                              <div class='dashboard-navitem' onclick="goto('/views/doctor_search.php')">Search</div>
                              <div class='dashboard-navitem' ng-class="{selected: is_show('appts')}" ng-click="view='appts.display'">Appointments</div>
                              <div class='dashboard-navitem' ng-class="{selected: is_show('profile')}" ng-click="view='profile'">Profile</div>
                              <div class='dashboard-navitem' ng-class="{selected: is_show('messages')}" ng-click="view='messages'">Messages</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div ng-show="is_show('appts')">
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
                        </div>
                        <div ng-show="is_show('messages')">
                            <?php include('_messages.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-mgb"></div>
    <?php  include '../footer.php'; ?>
</body>
</html>