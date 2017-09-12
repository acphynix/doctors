<?php
error_reporting(0);
  session_start();
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
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<!--<link rel="stylesheet" type="text/css" href="styles/date.css">--> 
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>
<title>Neolafia | FAQ</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
<script>
    $(function(){
        var $pageTitle = $("#pageName").data('page-title');
        $("ul.navbar-nav li#"+$pageTitle).addClass("active");
    });
</script>
</head>
<body>
    <div class="full-page">
    <div id="pageName" data-page-title="faqPage"></div>
        <?php include 'navbar.php'; ?>
        <div class="container-fluid faq-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="page-title">Frequently Asked Questions</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="faq-type"><b>PATIENTS</b></h4>
                        <div class="panel-group" id="accordionP">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordionP" href="#faq1">
                                            How do I book an appointment?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faqP1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <p>
                                            To book an appointment make a search for a specialty, symptom, doctor's name or location
                                            of your chosen. The profile of one or more doctors matching your search criteria will be
                                            provided from which you can select. Click on "Click to book an appointment" to book 
                                            appointment with your desired doctor.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="faq-type"><b>DOCTORS</b></h4>
                        <div class="panel-group" id="accordionD">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordionD" href="#faq2">
                                            How do I use the Calendar?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faqD1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <ul>
                                            <li>
                                                <i class="text-success fa fa-list"></i> To create an appointment, click on the grid that falls
                                                between your desired hour of day and day of week presented in the 'week' calendar
                                            </li>
                                            <li>
                                                <i class="text-success fa fa-list"></i> Enter appointment fee and select currency on the dialog 
                                                box that appears; then click create
                                            </li>
                                            <li>
                                                <i class="text-success fa fa-list"></i> You can extend appointment time by hovering over the edge 
                                                of the blue box (which appeared after creating an appointment) till mouse pointer shape changes,
                                                then drag to the right or bottom
                                            </li>
                                            <li>
                                                <i class="text-success fa fa-list"></i> You can change appointment time by hovering around the middle
                                                of the blue box till mouse pointer changes, then drag and drop in desired hour-day grid
                                            </li>
                                            <li>
                                                <i class="text-success fa fa-list"></i> By clicking on any day on the 'month' calendar, whole week
                                                is highlighted and manifested on the 'week' calendar
                                            </li>
                                            <li>
                                                <i class="text-success fa fa-list"></i> Click on 'Done' at the top of the page to finish setting
                                                appointments
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-mgb"></div>
    <?php  include 'footer.php'; ?>
</body>
</html>