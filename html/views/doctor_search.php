<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
  import('php/util/sanitize.php');
  session_start();
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
  $query = sanitize_plaintext($_GET['q']);
?>
<head>
<title>Neolafia</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/ajs_modules/doctor_search.js"></script>

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
  window.query = { search: '<?php echo $query?>' };

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
      <div class='results-text'>
        We found {{result_list.length}} doctors matching your query.
      </div>
      <div class='results-entry clickme' style="display:table;clear:both;position:relative"
           ng-repeat='r in result_list' ng-click="r.show=!r.show; load_info(r)">
        <table class='clickme'>
          <tr>
            <td>
              <img src='https://ent.doctorondemand.com/wp-content/uploads/2016/09/DoctorHeadshot_ChristopherBailey.jpg' style='display:inline-block;height:6em;padding-right:2em;padding-bottom:1em' />
            </td>
            <td width='100%'>
              <h3>{{r.user_first_name}} {{r.user_last_name}}</h3>
                <h3>{{r.speciality_name}}</h3>
                Click for more details.
            </td>
          </tr>
        </table>
        <div ng-show='r.show'>
          <b>More details about {{r.user_first_name}}</b>
          <br /><br />
          Availabilities:
          <div ng-repeat='time in r.schedule'>
            {{to_date_string(time.s)}}
            <a href="/book_appointment.php?t={{time.s}}&q={{query.text}}&d={{r.user_id}}">Book an appointment</a>
          </div>
        </div>

      </div>

    </div>
  </div>
</body>
</html>