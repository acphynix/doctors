<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
  import('php/util/sanitize.php');
  session_start();
  if(has_key($_SESSION,'valid') && $_SESSION['valid']){
    $login=1;
    $displayname = $_SESSION['displayname'];
  }else{
    $login=0;
  }
  $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
  if(has_key($_GET,'q')){
    $query = sanitize_plaintext($_GET['q']);
  }else $query = '';
?>
<head>
<title>Neolafia</title>

<link rel="stylesheet" type="text/css" href="/lib/fullcalendar/fullcalendar.css">
<link rel="stylesheet" type="text/css" href="/styles/calendar.css">
<link rel="stylesheet" href="/awesomplete/awesomplete.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
<script src='/lib/fullcalendar/fullcalendar.js'></script>
<script src='https://momentjs.com/downloads/moment.min.js'></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/ajs_modules/doctor_search.js"></script>

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
  window.query = { search: '<?php echo $query?>' };

</script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin|Courgette" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="/styles/doctor_search.css"> 

</head>

<body ng-app="doctor_search" ng-controller="search" style='margin:0'>
  <span ng-init='init_view()' />
  <div class='boat boat-smaller'>
    <span>
    <h1 class='Neolafia' style='position:relative'>
      <img src='../images/logo.png' style='height:1em;'/>
      Neolafia
      <span class='banner-button-container' >
        <?php if(isset($login) && $login>0){ ?>
          <a class='banner-welcome-text banner-button' href='/page/home.php'><?php echo $displayname ?></a>
          <a class='banner-button' href='logout.php'>sign out</a>
        <?php }else{ ?>
          <a class='banner-button' href='/createaccount.php'>sign up</a>
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
  <div class='results-body'>
    <div class='results-container'>
      <div class='results-text' ng-if='result_list.length>0'>
        Congratulations! We found {{result_list.length}} doctors matching your search criteria.
      </div>
      <div class='results-text' ng-if='result_list.length==0'>
        We could not find any doctors matching your search criteria. Try searching for speciality names instead!
      </div>
      <div class='results-entry' style="display:table;clear:both;position:relative"
           ng-repeat='r in result_list' ">
        <?php if($login){ ?>
          <table class='clickme' ng-click="r.show=!r.show; load_info(r)">
        <?php } else{ ?>
          <table>
        <?php } ?>
          <tr>
            <td style='text-align:center;border:solid black 1px;padding:0.5em;background-color:#333333'>
              <img ng-attr-src="{{'/ajax/get_file.php?n=profile_picture&u='+r.user_id}}" style='display:inline-block;max-height:8em;max-width:8em;border:solid white 1px' />
            </td>
            <td style='width:100%;padding:1em;padding-bottom:6em;position:relative;overflow:hidden'>
                <div style='position:absolute;top:0;height:100%;'>
                  <h3 style='font-size:1.33em;padding:0;margin:0;'>{{r.user_first_name}} {{r.user_last_name}}</h3>
                  <h3 style='font-weight:none;font-style:italic;color:gray;text-transform:capitalize;font-size:0.75em'>{{r.speciality_name}}</h3>
                  <div style='font-family:Cabin;padding-top:1em' ng-show='!r.show'>
                    <?php if($login){ ?>
                      Click to book an appointment.
                    <?php } else{ ?>
                      <a href='/login.php'>Sign in</a> or <a href='/createaccount.php'>Register</a> to view more details and book an appointment.
                    <?php } ?>
                  </div>
                </div>
            </td>
          </tr>
        </table>
        <div class='details' ng-show='r.show'>
          <h4>Qualifications and Certifications:</h4>
            <div class='text'>{{r.doctor_qualifications}}</div>
          <h4>Affiliations:</h4>
            <div class='text'>{{r.doctor_affiliations}}</div>
          <br />
          <h4>Availabilities:</h4>
          <div style='height:300px'>
            <div ng-attr-id="calendar_{{r.user_id}}"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>