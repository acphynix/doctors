<?php
   ob_start();
   session_start();
   // if($_SESSION['valid']){
   //   header('Location: http://www.yoursite.com/new_page.html') ;
   // }
?>
<html ng-app="healthapp">
<head>
<title>Eku Ojumo</title>

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
  if(window.location.hash) {
    view = (window.location.hash.substring(window.location.hash.lastIndexOf("#")+1));
    // alert(view);
    navView(view);
  } else {

  }
  $( "#ikeyword_search" ).on('update_dropdown',function(event) {
    // alert($('').text);
  });

  var input_plc = "Enter your symptoms, a doctor\'s name, or a medical speciality";

  $('#ikeyword_search')
    .attr('placeholder',input_plc);
    
  var input= $('#ikeyword_search')[0];
  var searchbox = new Awesomplete(input, {
    list: ["Ada", "Java", "JavaScript", "Brainfuck", "LOLCODE", "Node.js", "Ruby on Rails"]
  });
});


</script>
<link rel="stylesheet" type="text/css" href="forms.css"> 

</head>

<body ng-controller="HealthController" style="background: #0a6a8e">
  <div style="justify-content: center; margin:auto; width:80%; padding:10px; display:block; margin-left:auto; margin-right:auto; border:3px solid green; margin: 0 auto; background:#2a7aae; min-height:100% ">
<?php if($_SESSION['valid']): ?>

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
  </table>

<?php else: ?>
    <div style="text-align:right">
      <a href="login.php"> Sign In</a>
    </div>
    <div class=boat style="height:600px">
      <div style="height:20%">
      </div>
      <div class="banner" style="width:90%">
        <div style="opacity:2.0">

           <h1>
            Eku Ojumo!
          </h1>
          <h1>
            Good Morning!
          </h1>

        </div>
      </div>
    </div>
    <div class="form-style-8">
    <h2>Are you looking for a doctor?</h2>
    <form method='GET' action='views/doctor_search.php'>

    <input name='q' id="ikeyword_search" type="text" ng-model="keyword_search"
      autofocus ng-change='update_dropdown()'
    />
    <div ng-model="keyword_search">{{keyword_search}}</div>
    <input type="submit" ng-click="update(user)" value="SEARCH" />

    </form>
    <h2>Are you a member?</h2>
    <form>
      <input type="button" onClick="goto('login.php')" value="Sign In" />
      <div style="float:left; overflow:hidden; width:20px"></div>
      <input type="button" onClick="goto('createaccount.php')" value="Create an Account" />
    </form>
    </div>
<?php endif; ?>
  </div>
</body>
</html>