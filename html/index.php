<?php
   ob_start();
   session_start();
   // if($_SESSION['valid']){
   //   header('Location: http://www.yoursite.com/new_page.html') ;
   // }
?>
<html ng-app="healthapp">
<head>
<title>Neolafia</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="app.js"></script>

<link rel="stylesheet" href="awesomplete/awesomplete.css" />
<script src="awesomplete/awesomplete.js" async></script>

<script>

function navView(page){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // alert(this.responseText);
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

$(document).ready(function(){

  $( "#ikeyword_search" ).on('update_dropdown',function(event) {
    // alert($('').text);
  });

  var input_plc = "Enter your symptoms, a doctor\'s name, or a medical speciality";

  $('#ikeyword_search')
    .attr('placeholder',input_plc);
    
});


</script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="forms.css"> 
<link rel="stylesheet" type="text/css" href="styles/styles.css"> 

</head>

<body ng-controller="HealthController" style="background: #97d23b">
  <span ng-init='init_view()' />
<?php if($_SESSION['valid']): ?>
  <div style="justify-content: center; margin:auto; width:80%; padding:10px; display:block; margin-left:auto; margin-right:auto; border:3px solid green; margin: 0 auto; background:#2a7aae; min-height:100% ">

  <div class="loggedinheader" style="">
    <div style="vertical-align:middle">
      <span>
      <img src="images/banner.jpg" style="width:120">
      </span>
      <span class="headeruname">
        <?php
          echo $_SESSION['displayname'];
        ?>
      </span>
      <div style="float:right">
      <a href="logout.php"> Sign out</a>
      </div>
    </div>
  </div>
  <hr>

  <table style="width:100%">
    <tr>
      <td class="sidepanel" style="">
        <div id="e_search" ng-click="lcurrent_view='views/view_search.php'"             class="panelentry clickme">Search</div>
        <div id="e_profile" ng-click="lcurrent_view='views/view_profile.php'"           class="panelentry clickme">My Profile</div>
        <div id="e_patientappts" ng-click="lcurrent_view='views/view_patientappts.php'" class="panelentry clickme">My Appointments (Pt)</div>
        <div id="e_doctorappts" ng-click="lcurrent_view='views/view_doctorappts.php'"   class="panelentry clickme">My Appointments (Dr)</div>
      </td>
    <td id="c_navpages" class="form-style-8" style="overflow:hidden">
      <ng-include src="lcurrent_view"> </ng-include>
    </td>
    </tr>
  </table>
  </div>
<?php else: ?>
  <div class='boat'>
    <h1 class='Neolafia'>
      <img src='../images/logo.png' style='height:1em;'/>
      Neolafia
    </h1>
    <div>
      <div class='question-container'>
        <div class='question'>
          <h2>Looking for a doctor?</h2>
          <form method='GET' action='views/doctor_search.php' class="form-style-8">
            <input name='q' id="ikeyword_search" type="text" ng-model="keyword_search"
                   autofocus ng-change='update_dropdown()' />
          </form>
        </div>
      </div>
    </div>  
  </div>
  <div class='frontpage-body'>
    <div class='frontpage-container'>
      <div class='frontpage-entry'>
        <h2 class='frontpage-heading'>Are you a Medical Professional?</h2>
        <div class='frontpage-text'>
        We could use your help! Make a difference around you by lorem ispum dolor sit amet!
        </div>
      </div>
      <div class='frontpage-entry'>
        <h2 class='frontpage-heading'>Connect with Medical Specialists near You</h2>
        <div class='frontpage-text'>
          Cough that just won't go away? Back pain keeping you up? We make finding
          a medical specialist easy. Lorem ipsum, sign up to try it out!
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
</body>
</html>