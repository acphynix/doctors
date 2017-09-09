<?php
  
  require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
  import('/php/util/sanitize.php');

  session_start();
  $query = $query2 = "";
  if($_SESSION['valid']){
    $login=1;
    $displayname = $_SESSION['displayname'];
    $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $query   = sanitize_plaintext($_GET['q']);
    $query2   = sanitize_plaintext($_GET['c']);
    $qdoctor = sanitize_plaintext($_GET['d']);
    $apptime = $_GET['t'];
  }
  else{
    header('Location: /views/doctor_search.php');
  }
?>
<head>
<title>Neolafia | Booking appointments with specialist doctors just got easier</title>
<meta name="description" content="Book appointments with qualified and specialist doctors easily"/>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/ajs_modules/book_appointment.js"></script>

<link rel="stylesheet" href="/awesomplete/awesomplete.css" />
<script src="/awesomplete/awesomplete.js"></script>

<script type="text/javascript" async>
  function goto(newpage){
    window.location.href = newpage
  }

  $( document ).ready(function() {
    var input_plc = "Enter your symptoms, a doctor\'s name, or a medical speciality";
    
    var options = $('#loc_new').get(0).options;
    $.each(['Abia', 'Adamawa', 'Anambra', 'Akwa Ibom', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Enugu', 'Edo', 'Ekiti', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos: Agege', 'Lagos: Ajeromi-Ifelodun', 'Lagos: Alimosho', 'Lagos: Amuwo-Odofin', 'Lagos: Apapa', 'Lagos: Badagry', 'Lagos: Epe', 'Lagos: Eti-Osa', 'Lagos: Ibeju-Lekki', 'Lagos: Ifako-Ijaiye', 'Lagos: Ikeja', 'Lagos: Ikorodu', 'Lagos: Kosofe', 'Lagos: Lagos Island', 'Lagos: Lagos Mainland', 'Lagos: Mushin', 'Lagos: Ojo', 'Lagos: Oshodi-Isolo', 'Lagos: Somolu', 'Lagos: Surulere', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara', 'Abuja (FCT)'], function(key, value) {
      options[options.length] = new Option(value, key);
    });

    $('#ikeyword_search')
      .attr('placeholder',input_plc);
      
      $(".noteBut").click(function(){
         $(".apptReason").hide(); 
      });
  });
  window.query = { search: '<?php echo $query?>'    ,
                   time:   '<?php echo $apptime?>'  ,
                   doctor: '<?php echo $qdoctor?>'  };

 function adjust_textarea(h) {
    h.style.height = "45px";
    h.style.height = (h.scrollHeight)+"px";
  }

</script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin|Courgette" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" type="text/css" href="/styles/styles.css">  
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>

</head>

<body ng-app="doctor_search" ng-controller="search" ng-cloak>
    <div class="full-page">
        <?php include 'navbar.php'; ?>
        <span ng-init='init_view()'></span>
        <div>
            <div class="container-fluid doc-search book_appt">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <form method='GET' action='/views/doctor_search.php' class="form-style-8 white banner_search">
                                <div class="form-group">
                                    <input name='q' id="ikeyword_search" type="text" ng-model="keyword_search"
                                       autofocus ng-keypress='update_dropdown()' autocomplete="off" />
                                </div>
                                <div class="form-group loc-search">
                                    <input type="hidden" id="loc_ent" value="<?php echo $query2 ?>"/>
                                    <select id='loc_new' name='c' class="form-control">
                                        <option value=''>Choose Location</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="center-block btn btn-primary">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid cf-appt">
                <div class="container row-1">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="intro">
                                Confirm your Appointment with <span class="text-success">Dr. {{book.info.fname}} {{book.info.lname}}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="u-line"></div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p class="text-gray">You are booking an appointment with</p>
                        </div>
                        <div class="col-sm-8">
                            <table class="table table-responsive table-striped table-hover table-bordered">
                                <thead>
                                    <tr class="bg-info">
                                        <th>&nbsp;</th>
                                        <th>
                                            <span class="text-info">Dr. {{book.info.fname}} {{book.info.lname}}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right"><b>On:</b></td>
                                        <td><span>{{plus_one_hour(book.time)}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>In:</b></td>
                                        <td><span>{{location_name(book.info.location)}}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-8">
                            <p class="text-success"><b>Consultation fee: {{book.appt.price}} {{book.appt.currency}}</b></p>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-4 apptReason">
                            <p class="text-gray">Please describe the reason for your visit:</p>
                        </div>
                        <div class="col-sm-8">
                            <form ng-submit='book_appointment()' ng-show='!booked'>
                                <div class="form-group">
                                    <textarea ng-disabled='booked' ng-model="apptNote" class="form-control"
                                              rows="4" placeholder="Reason of visit"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-big pull-right noteBut">
                                        <i class="fa fa-check-circle"></i> Book
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-small pull-right noteBut">
                                        <i class="fa fa-check-circle"></i> Book
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="container row-2" ng-show='booked'>
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="text-orange">
                                <i class="fa fa-arrow-right"></i> You are only one step away from finally booking your appointment!
                            </p>
                            <p>
                                Your appointment request has been recorded but in order for your booking request to be
                                confirmed, you must pay the consultation fee of {{book.appt.price}} {{book.appt.currency}}
                                into the account specified below:
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <table class="table table-responsive table-striped table-hover table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="text-right"><b>Account Number:</b></td>
                                        <td><span>3004298963</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Bank:</b></td>
                                        <td><span>FIRST BANK NIGERIA</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Memo:</b></td>
                                        <td><span>{{apptcode}}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-8"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 bg-danger">
                            <h4 class="text-danger"><i class="fa fa-warning"></i> Important</h4>
                            <p>
                                Please ensure that you include the code <b>{{apptcode}}</b> with your payment. 
                                This is the code unique to this booking that would help us link your payment to your
                                booking.
                            </p>
                            <p>
                                You will receive an email confirmation when your payment has been processed.
                            </p>
                            <p>
                                We believe the instructions here are clear but should you have questions about payment,
                                please check the <a href="/faq.php">FAQs</a> or <a href="/contactus.php">Contact Us</a>.
                            </p>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-4">
                            <a href="page/home.php" class="btn btn-primary btn-lg center-block">
                                <i class="fa fa-calendar-plus-o"></i> View Appointments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  include 'footer.php'; ?>
</body>
</html>