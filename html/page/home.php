<?php
  session_start();
  if(!$_SESSION['valid']){
    header('Location: ../index.php') ;
  }
?>
<html ng-app="healthapp">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/awesomplete/awesomplete.js"></script>
<script src="../app.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="../forms.css"> 
<script>
  function navView(page){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var result = $('<div />').append(this.responseText).html();
        $('#c_navpage').html(result);
      }
      else{
        
      }
    };
    xmlhttp.open("GET", "views/"+page+".php", true);
    xmlhttp.send();
  }

  function goto(newpage){
    window.location.href = newpage
  }
</script>
<title>Neolafia</title>
</head>
<body ng-controller="HealthController">
<div class='noboat'>
    <h1 class='clickme Neolafia' style='position:relative' onclick="goto('../index.php')">
      <img src='../images/logo.png' style='height:1em;'/>
      Neolafia
      <span class='banner-button-container' >
        <a class='banner-button' href='../logout.php'>sign out</a>
      </span>
    </h1>
  </div>
  <div class='frontpage-body'>
    <div class='frontpage-container'>
        <table style="width:100%">
          <tr>
            <td class="sidepanel" style="width:1%;white-space:nowrap;">
              <div id="e_search" ng-click="lcurrent_view='../views/view_search.php'"             class="panelentry clickme">Search</div>
              <div id="e_profile" ng-click="lcurrent_view='../views/view_profile.php'"           class="panelentry clickme">My Profile</div>
              <div id="e_profile" ng-click="lcurrent_view='../views/view_profile.php'"           class="panelentry clickme">Dashboard</div>
              <div id="e_patientappts" ng-click="lcurrent_view='../views/view_patientappts.php'" class="panelentry clickme">My Appointments (Pt)</div>
              <div id="e_doctorappts" ng-click="lcurrent_view='../views/view_doctorappts.php'"   class="panelentry clickme">My Appointments (Dr)</div>
              <div id="e_profile" ng-click="lcurrent_view='../views/view_profile.php'"           class="panelentry clickme">My Doctors</div>
              <div id="e_profile" ng-click="lcurrent_view='../views/view_profile.php'"           class="panelentry clickme">Messages</div>
            </td>
          <td id="c_navpages" class="form-style-8" style="overflow:hidden">
            <ng-include src="lcurrent_view"> </ng-include>
          </td>
          </tr>
        </table>
    </div>
  </div>
</body>
</html>