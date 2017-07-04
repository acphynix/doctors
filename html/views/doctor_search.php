<?php
  require('../util/sanitize.php');
  $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
  $query = sanitize_plaintext($_GET['q']);
  // $terms = (explode(" ",$query));
  // 1. find specialities associated with the search term.
  $db_1 =
    sprintf("select user_first_name, user_last_name,doctor_prof_picture,".
                    "doctor_speciality ".
      "from doctors,users where doctor_speciality in (select speciality from ".
      "speciality_keywords where keyword like 'lungs') ".
      "and doctors.user_id=users.user_id",$query);

  $dq_1 = mysqli_query($database, $db_1);
  $dr_1 = [];
  $ds_1 = '';

  while ($row = $dq_1->fetch_assoc()) {
    array_push($dr_1, $row);
  }
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="../ajs_modules/doctor_search.js"></script>


<link rel="stylesheet" type="text/css" href="../styles/date.css">
<link rel="stylesheet" type="text/css" href="../styles/layout.css"> 
<link rel="stylesheet" type="text/css" href="../forms.css"> 
<script>

window.query = { search: '<?php echo $query?>' };

</script>
<title>Ekuojumo</title>
</head>
<body ng-app="doctor_search" ng-controller="search" class='layout_fullpage'>
  <div class='layout_center'>
    <div class="form-style-8">
      <div id='panel_search' ng-show="action == 'search'">
        <h2>Search for a Doctor</h2>
        <form ng-submit='perform_search()'>
          <input name='q' id="ikeyword_search" type="text" ng-model="keyword_search"
            autofocus ng-change='update_dropdown()'
            placeholder="Enter your symptoms, a doctor's name, or a medical speciality"
            ng-init='<?php echo htmlspecialchars($query); ?>'
          />
          <input type="submit" ng-click="update(user)" value="SEARCH" />
        </form>
        
        <div class='clickme' ng-repeat='r in result_list'>
          <p class='clickme' style='background-color:lightgray' ng-click="r.show=!r.show; load_info(r)">
            {{r.user_first_name}} {{r.user_last_name}} <br />
            Speciality: {{r.speciality_name}} <br />
            Click for more details.
            <div ng-show='r.show'>
              <b>More details about {{r.user_first_name}}</b>
              <br /><br />
              Availabilities:
              <div ng-repeat='time in r.schedule'>
                {{to_date_string(time.s)}}
                <input type='button' value='make an appointment' ng-click="action_book(r, time)">
              </div>
            </div>
          </p>
        </div>
      </div>
      <div id='panel_book' ng-show="action == 'book'">
        <h2>Book Appointment</h2>
        <input type='button' value='search results' ng-click="action='search'">
        <br />
        <br />
        Confirm appointment with {{book.doctor.user_first_name}}
        {{book.doctor.user_last_name}} at {{book.time.s}} to {{book.time.e}}.
        <br />
        <input type="submit" ng-click="book_appointment()" value="SEARCH" />
      </div>
    </div>
  </div>
</body>
</html>