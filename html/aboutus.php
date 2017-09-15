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
<meta name="description" content="We find qualified specialist doctors in Nigeria, connect you to them,
      and help you to skip the queue by giving you the choice to book your appointment right away."/>
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
                        <p><b class="text-success text-uppercase">Who we are:</b></p>
                        <p>
                            Neolafia is a platform that connects patients to specialist doctors.
                        </p>
                        <br/><br/>
                        <p><b class="text-success text-uppercase">What we do:</b></p>
                        <p>
                            <i class="fa fa-list-ul text-success"></i> <b>Find qualified doctors: </b>
                            First, specialist doctors register with us. Then Neolafia verifies the information 
                            each doctor provides before listing the doctor on our website. As a patient, you 
                            can be rest assured that any doctor you find on Neolafia is certified to practice in
                            Nigeria in the specialty listed.
                        </p>
                        <p>
                            <i class="fa fa-list-ul text-success"></i> <b>Connect patients to doctors: </b>
                            Users can search for specialist doctors based on location, symptoms, doctor's name,
                            or the medical specialty. We will provide you with a list of doctors based on your
                            search criteria.
                        </p>
                        <p>
                            <i class="fa fa-list-ul text-success"></i> 
                            <b>Book an appointment with a doctor and skip the long line: </b>
                            Once you review the list of doctors, Neolafia shows you the times the doctor is 
                            available to see you and you can pick the time that works for you. This way you
                            skip long lines at the hospital.
                        </p>
                        <br/><br/>
                        <p><b class="text-success text-uppercase">Why should you use Neolafia?</b></p>
                        <p>
                            <b>
                                If any of the statements below describe you, Neolafia is where you need to be
                                for your medical needs:
                            </b>
                        </p>
                        <p>
                            <i class="fa fa-list-ul text-success"></i>
                            You don't like sharing your medical symptoms with the whole world in order for them
                            to help you find a doctor that can help you.
                        </p>
                        <p>
                            <i class="fa fa-list-ul text-success"></i>
                            You don't like to spend hours at the hospital waiting to see a doctor that may eventually
                            not get to see you due to the volume of patients. Time is money and yours is very precious.
                        </p>
                        <p>
                            <i class="fa fa-list-ul text-success"></i>
                            You don't like quack doctors. You like to know that the doctor attending to you is not only
                            qualified by the regulatory bodies but also has years of experience under his or her belt.
                        </p>
                        <p>
                            <i class="fa fa-list-ul text-success"></i>
                            Neolafia intentionally focuses on only this one thing - finding you specialist care. 
                            And we do it very well.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-mgb"></div>
    <?php  include 'footer.php'; ?>
</body>
</html>