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
  function goto(newpage){
    window.location.href = newpage
  }
  function submit_request_create(){
    console.log('hi');
    return false;
  }
  $(document).ready(function () {
    $("#iUr").click(function () {
        var formData = $("#form_req").serialize();
        $.ajax({
            type: "POST",
            url: "ajax/try_create_account.php", //serverside
            data: formData,
            beforeSend: function () {
                //show loading image
            },
            success: function (result) {
                console.log(result); //use this to see the response from serverside
                value = JSON.parse(result);
                // if(value.success == "true")location.href = 'accountcreatesuccess.php'
            },
            error: function (e) {
                console.log(e); //use this to see an error in ajax request
            }
        });
    });
    $("#toggle_regr_type").click(function (){
      // $scope.is_doctor = !$scope.is_doctor;
    });
});
</script>
<title>Ekuojumo</title>
</head>
<body ng-app="doctor_search" ng-controller="search" class='layout_fullpage'>
  <div class='layout_center'>
    <div class="form-style-8">
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
      <p class='clickme' style='background-color:lightgray'>
      {{r.user_first_name}} {{r.user_last_name}} <br />
      Speciality: {{r.speciality_name}} <br />
    </div>

    <br />

    </div>
  </div>
</body>
</html>