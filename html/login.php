<?php
  session_start();
  if($_SESSION['valid']){
    header('Location: page/home.php') ;
  }
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="forms.css"> 
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  $(document).ready(function(){
    $("#iform_login").submit(function(e) {
      $.ajax({
            type: "POST",
            url: "ajax/login.php",
            data: $("#iform_login").serialize(),
            success: function(data){
              goto('index.php')
            },
            error: function(data){
              
            }
           });
      e.preventDefault();
    });
  });
</script>
<title>Neolafia</title>
</head>
<body>
<div class='noboat'>
  <a href='index.php'>
  <h1 class='Neolafia' style='position:relative'>
      <img src='../images/logo.png' style='height:1em;'/>
    
      Neolafia
    <!-- </a> -->
  </h1>
  </a>
  </div>
  <div class='frontpage-body'>
    <div class='frontpage-container'>
      <div class='frontpage-entry' style='height:100%'>
        <h2 class='soloheading'>Sign in to Neolafia</h2>
        <form class="form-style-8 borderless centered" role = "form" 
              id='iform_login' method = "post">
          <input name="uname" type="text"     ng-model="uname" placeholder="E-mail Address">
          <input name="pword" type="password" ng-model="pword" placeholder="Password">
          <input name="login" type="submit"   value="Sign in" />
        </form>
      </div>
    </div>
  </div>
</body>
</html>