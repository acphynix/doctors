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
  $query = $query2 = '';
  if(has_key($_GET,'q')){
    $query = sanitize_plaintext($_GET['q']);
  }
  if(has_key($_GET,'c')){
    $query2 = sanitize_plaintext($_GET['c']);
  }
  $user_status = $userId = "";
	if(has_key($_SESSION,'user_id')){
      $userId = $_SESSION['user_id'];
    }
    $db_1 = sprintf("select user_status from users where user_id = '%s'",$userId);
    $dq_1 = mysqli_query($database, $db_1);
    while ($row = $dq_1->fetch_assoc()) {
        $user_status = $row['user_status'];
    }
  
 //else $query = '';
?>
<head>
<title>Neolafia | Search for specialist doctors</title>

<meta name="description" content="Neolafia makes it easy for you to book appointments with specialist doctors. A list of
      doctors are presented to you based on the symptoms, specialty, doctor's name or location that you have entered"/>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
<link rel="stylesheet" type="text/css" href="../lib/fullcalendar/fullcalendar.css">
<link rel="stylesheet" type="text/css" href="../styles/calendar.css">
<link rel="stylesheet" href="../awesomplete/awesomplete.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
<script src='/lib/fullcalendar/fullcalendar.js'></script>
<script src='https://momentjs.com/downloads/moment.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/ajs_modules/doctor_search.js"></script>

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
  });
  window.query = { search: '<?php echo $query?>' };

</script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin|Courgette" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="/styles/doctor_search.css"> 
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>

</head>

<body ng-app="doctor_search" ng-controller="search" ng-cloak>
    <div class="full-page">
        <?php include '../navbar.php'; ?>
        <span ng-init='init_view()'></span>
        <div>
            <div class="container-fluid doc-search">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <form method='GET' action='doctor_search.php' class="form-style-8 white banner_search">
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
            <div class="container-fluid dp-area">
                <div class='results-body'>
                    <div class='results-container'>
                        <div class='results-text' ng-if='result_list.length>1'>
                            <p class="text-success">Congratulations! We found {{result_list.length}} doctors matching your search criteria.</p>
                        </div>
                        <div class='results-text' ng-if='result_list.length==1'>
                            <p class="text-success">Congratulations! We found {{result_list.length}} doctor matching your search criteria.</p>
                        </div>
                        <div class='results-text' ng-if='result_list.length==0'>
                            <p class="text-danger">We could not find any doctor matching your search criteria.</p>
                        </div>
                        <div class='results-entry bg-success' ng-repeat='r in result_list'>
                          <?php if($login && $user_status==='verified'){ ?>
                          <table class='clickme' ng-click="r.show=!r.show; load_info(r)">
                          <?php } else{ ?>
                          <table>
                          <?php } ?>
                                <tr>
                                    <td class="doc-profile">
                                        <img ng-attr-src="{{'/ajax/get_file.php?n=profile_picture&u='+r.user_id}}"/>
                                    </td>
                                    <td class="doc-profile-2">
                                        <div class="doc-profile-2-div-1">
                                            <h3 class="doc-name">{{r.user_first_name}} {{r.user_last_name}}</h3>
                                            <h3 class="doc-spec">{{r.speciality_name}} | {{location_name(r.doctor_location)}}</h3>
                                            <div class="doc-profile-2-div-2" ng-show='!r.show'>
                                                <?php if($login && $user_status==='verified'){ ?>
                                                Click to book an appointment.
                                                <?php } elseif($login && $user_status!=='verified'){ ?>
                                                  Account authentication is needed to book appointment with this doctor
                                                <?php } else{ ?>
                                                  <form method="post" action="/login.php" class="in-line">
                                                      <input type="hidden" name="q_s" value="<?php echo $query ?>"/>
                                                      <input type="hidden" name="c_s" value="<?php echo $query2 ?>"/>
                                                      <button type="submit" class="btn btn-link">
                                                          <b>Sign in</b>
                                                      </button>
                                                  </form>
                                                  or <a href='/createaccount.php'>Register</a>
                                                  to view more details and book an appointment.
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
                                <div class="doc-availabilities">
                                  <div ng-attr-id="calendar_{{r.user_id}}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  include '../footer.php'; ?>
</body>
</html>