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
<title>Neolafia | About Us</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
<meta name="description" content="Neolafia makes it easy for you to book appointments with specialist doctors. A list of
      doctors are presented to you based on the symptoms, specialty, doctor's name or location that you enter"/>
<script>
    $(function(){
        var $pageTitle = $("#pageName").data('page-title');
        $("ul.navbar-nav li#"+$pageTitle).addClass("active");
    });
</script>
</head>
<body>
    <div class="full-page">
    <div id="pageName" data-page-title="aboutPage"></div>
        <?php include 'navbar.php'; ?>
        <div class="container-fluid simple-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>About Us</h4>
                        <p>
                            <b class="text-success">Neolafia</b> brings the very best doctors in various areas of speciality right to you. 
                            With just a click of a button,
                            search for doctors, speciality, symptoms or even location and book appointment with our doctors
                            in a moment.
                        </p>
                        <p>
                            All doctors are qualified and verified by us in the bid to bringing you top-notch service
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ms-mh"></div>
    <?php  include 'footer.php'; ?>
</body>
</html>