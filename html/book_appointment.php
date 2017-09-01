<?php
  
  require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
  import('/php/util/sanitize.php');

  session_start();
  if($_SESSION['valid']){
    $login=1;
    $displayname = $_SESSION['displayname'];
    $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $query   = sanitize_plaintext($_GET['q']);
    $qdoctor = sanitize_plaintext($_GET['d']);
    $apptime = $_GET['t'];
  }
  else{
    header('Location: /views/doctor_search.php');
  }
?>
<head>
<title>Neolafia</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/ajs_modules/book_appointment.js"></script>

<link rel="stylesheet" href="/awesomplete/awesomplete.css" />
<script src="/awesomplete/awesomplete.js"></script>

<script type="text/javascript" async>
  function goto(newpage){
    window.location.href = newpage
  }

  $( document ).ready(function() {
    var input_plc = "Enter your symptoms, a doctor\'s name, or a medical speciality";

    $('#ikeyword_search')
      .attr('placeholder',input_plc);
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

</head>

<body ng-app="doctor_search" ng-controller="search" style='margin:0'>
  <span ng-init='init_view()' />
  <div class='boat boat-smaller'>
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
          <a class='banner-button' href='/login.php'>sign in</a>
        <?php } ?>
      </span>
    </h1>
    <div>
      <div class='question-container'>
        <div class='question'>
          <form method='GET' action='/views/doctor_search.php' class="form-style-8 white banner_search">
            <input name='q' id="ikeyword_search" type="text" ng-model="keyword_search"
                   autofocus ng-keypress='update_dropdown()' autocomplete="off" />
          </form>
        </div> 
      </div>
    </div>  
  </div>
  <div class='results-body-confirm'>
      <h2 style='text-align:center; margin-top:0;padding-top:1em'>
        Confirm your Appointment with <span style='color:gray'>Dr. {{book.info.fname}} {{book.info.lname}}</span>
      </h2>
      <br />
      <div style='width:80%;margin-left:20%;margin-right:20%;font-family:Cabin;font-size:1.2em;'>
        You are booking an appointment with <br />
        <table style='margin:1em; padding-left:2em'>
        <tr>
          <td style='padding-bottom:1em;width:2%;min-width:4em'></td>
          <td style='padding-bottom:1em;font-weight:bold'>
            Dr. {{book.info.fname}} {{book.info.lname}}
          </td>
        </tr>
        <tr>
          <td style='padding-bottom:1em'>On</td>
          <td style='padding-bottom:1em;font-weight:bold'>
            {{plus_one_hour(book.time)}}
          </td>
        </tr>
        <tr>
          <td>In</td>
          <td style='font-weight:bold'>{{location_name(book.info.location)}}</td>
        </tr>
        </table>
        <i style='font-size:0.8em'>Consultation fee: {{book.appt.price}} {{book.appt.currency}}.</i>
        <br /><br />
        
        Please describe the reason for your visit.
        <br />
        <textarea style='padding:1em;margin:1em 1em 0 1em' ng-disabled='booked' onkeyup='adjust_textarea(this)'></textarea>

        <form style='margin:0;padding:0' ng-submit='book_appointment()' ng-show='!booked'>
          <input class='page-form' type='submit'>
        </form>

        <div ng-show='booked'>
          <p>
            Your appointment request has been recorded. In order for your booking request to be fulfilled, you must directly deposit a sum of {{book.appt.price}} {{book.appt.currency}} into the account specified below:
          </p>
          <table style='padding-left:4vw;margin-bottom:2em;width:30em;border-bottom:solid black 1px'>
            <tr>
              <td>Account Number:</td>
              <td>12345678</td>
            </tr>
            <tr>
              <td>Routing Number:</td>
              <td>22446688</td>
            </tr>
            <tr>
              <td>Memo:</td>
              <td>{{apptcode}}</td>
            </tr>
          </table>
          <p>
            <span style='color:red;font-weight:bold'>
              Important:&nbsp;
            </span>
            Ensure that you include the code <b>{{apptcode}}</b> with your payment. If you do not, your appointment may not be booked.
          </p>
          <p>
            After you complete the transaction, you will receive an email confirmation when your payment has been processed.
          </p>
          <p style='padding-left:10vw'>
            <a style='color:blue' href='/page/home.php'>View Appointments</a>
          </p>
        </div>
      </div>
  </div>
</body>
</html>