<?php
error_reporting(0);
  session_start();
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];
?>
<html ng-app="healthapp">
<head>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105319774-1', 'auto');
  ga('send', 'pageview');

</script>

<title>Neolafia | Home - Search for specialist doctors with ease</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
<meta name="description" content="Neolafia makes it easy for you to book appointments with specialist doctors. A list of
      doctors are presented to you based on the symptoms, specialty, doctor's name or location that you enter"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/app.js"></script>

<link rel="stylesheet" href="/awesomplete/awesomplete.css" />
<script src="/awesomplete/awesomplete.js"></script>

<script type="text/javascript" async>
  $( document ).ready(function() {
      
      var $pageTitle = $("#pageName").data('page-title');
      $("ul.navbar-nav li#"+$pageTitle).addClass("active");
      
    $(window).scrollTop(0);
//    var appFunPos = $("#mainView").position().top;
//    $(".carousel-caption .btn").click(function(){
//        $("html, body").animate({scrollTop:appFunPos}, 1000);
//    });
    
    var input_plc = "Enter your symptom, doctor's name, speciality";
    $('#ikeyword_search')
      .attr('placeholder',input_plc);
      
      var options = $('#ilocation_search').get(0).options;
    $.each(['Abia', 'Adamawa', 'Anambra', 'Akwa Ibom', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Enugu', 'Edo', 'Ekiti', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos: Agege', 'Lagos: Ajeromi-Ifelodun', 'Lagos: Alimosho', 'Lagos: Amuwo-Odofin', 'Lagos: Apapa', 'Lagos: Badagry', 'Lagos: Epe', 'Lagos: Eti-Osa', 'Lagos: Ibeju-Lekki', 'Lagos: Ifako-Ijaiye', 'Lagos: Ikeja', 'Lagos: Ikorodu', 'Lagos: Kosofe', 'Lagos: Lagos Island', 'Lagos: Lagos Mainland', 'Lagos: Mushin', 'Lagos: Ojo', 'Lagos: Oshodi-Isolo', 'Lagos: Somolu', 'Lagos: Surulere', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara', 'Abuja (FCT)'], function(key, value) {
      options[options.length] = new Option(value, key);
    });
	
	$("#searchDoc").click(function(e){
            $(this).attr('data-toggle', "");
            $(this).attr('data-target', "");
        if($("#ikeyword_search").val()==='' && $("#ilocation_search").val()===''){
            e.preventDefault();
            $(this).attr('data-toggle', "modal");
            $(this).attr('data-target', "#webModal");
        }
    });
    
//    var $ulText = $(".ul-text").text();
//    $(".ul-text").on("mouseover", function(){
//        if($ulText === "Are you a specialist doctor?"){
//            $(this).text("Click to continue");
//        }
//    });
//    $(".ul-text").on("mouseout", function(){
//        if($ulText === "Click to continue"){
//            $(this).text("Are you a specialist doctor?");
//        }            
//    });
    
  });
</script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin|Courgette" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>
</head>

<body ng-controller="HealthController">
    <div id="pageName" data-page-title="homePage"></div>
    <?php include 'navbar.php'; ?>
    <div id="webCarousel" class="carousel" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#webCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#webCarousel" data-slide-to="1"></li>
            <li data-target="#webCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active">
                <img src="images/slider/banner_1.jpg" alt="banner_1"/>
                <div class="carousel-caption">
                    <p>Save time by skipping the long queues at the hospital</p>
                    <a href="#startNow" class="btn btn-lg btn-warning">
                        START NOW
                    </a>
                </div>
            </div>
            <div class="item">
                <img src="images/slider/banner_2.jpg" alt="banner_2"/>
                <div class="carousel-caption">
                    <p>Save booking costs when you pay the consultation fee</p>
                    <a href="#startNow" class="btn btn-lg btn-warning">
                        START NOW
                    </a>
                </div>
            </div>
            <div class="item">
                <img src="images/slider/banner_3.jpg" alt="banner_3"/>
                <div class="carousel-caption">
                    <p>Get treated by specialist doctors only</p>
                    <a href="#startNow" class="btn btn-lg btn-warning">
                        START NOW
                    </a>
                </div>
            </div>
        </div>
        <a class="carousel-control left" href="#webCarousel" data-slide="prev">
            <i class="fa fa-caret-left"></i>
        </a>
        <a class="carousel-control right" href="#webCarousel" data-slide="next">
            <i class="fa fa-caret-right"></i>
        </a>
    </div>
    <span ng-init='init_view()'></span>
    <div class="container main-view" id="mainView">
        <div class="row">
            <div class="col-sm-5 question-user">
                <h4>Need to see a specialist doctor?</h4>
            </div>
            <div class="col-sm-7 search-doctor" id="startNow">
                <form method="GET" action="views/doctor_search.php">
                    <div class="form-group">
                        <label for="ikeyword_search" class="control-label bg-gray">
                            What are you looking for?
                        </label>
                        <input class="form-control" name="q" id="ikeyword_search" type="text"
                                ng-model="keyword_search" autofocus ng-keypress="update_dropdown()"
                                autocomplete="off" placeholder="Enter your symptom, doctor's name, speciality"/>
                    </div>
                    <div class="form-group">
                        <label for="ikeyword_search" class="control-label bg-gray">
                            Location
                        </label>
                        <select ng-required=true id='ilocation_search' name='c' class="form-control">
                            <option value=''>Choose Location</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="searchDoc" class="btn btn-lg btn-success pull-right"
                                data-toggle="" data-target="">Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid f-row">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 icon-view">
                    <div class="card bg-danger">
                        <h4 class="text-danger"><i class="fa fa-medkit"></i></h4>
                        <p class="text-danger">
                            Get treated by specialist doctors only - the most qualified in the medical profession
                        </p>
                    </div>
                </div>
                <div class="col-sm-4 icon-view">
                    <div class="card bg-white">
                        <h4><i class="fa fa-clock-o"></i></h4>
                        <p>Save time by skipping the long queues at the hospital</p>
                    </div>
                </div>
                <div class="col-sm-4 icon-view">
                    <div class="card bg-warning">
                        <h4 class="text-warning"><i class="fa fa-dollar"></i></h4>
                        <p class="text-warning">Save the booking costs when you pay the consultation fee</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <?php  include 'footer.php'; ?>
    <div class="modal fade" id="webModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 class="modal-title"><b>No Search Parameter Entered!</b></h4>
                </div>
                <div class="modal-body">
                <p>
                    Please enter a search parameter. You may search by:
                </p>
                <ol>
                    <li>Symptoms, Speciality or Doctor's name</li>
                    <li>Location</li>
                    <li>A combination of <b>1</b> and <b>2</b> above</li>
                </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>