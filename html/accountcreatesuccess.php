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
            errfor: function(data){
              
            }
           });
      e.preventDefault();
    });
  });
</script>
<title>Neolafia</title>
</head>
<body style='padding:0'>
<div class='noboat'>
  <a href='index.php'>
  <h1 class='Neolafia' style='position:relative'>
      <img src='../images/logo.png' style='height:1em;'/>
      Neolafia
    <!-- </a> -->
  </h1>
  </a>
  </div>
  <div class='account-body'>
    <div class='account-container'>
      <div class='account-entry' style='height:100%;text-align:center'>
        <h2 class='soloheading'>Welcome to Neolafia!</h2>
        <div style='font-family:Cabin;font-size:1.2em;width:60%;display: inline-block;text-align:left'>
          Thank you for creating an account with Neolafia, and becoming
          a part of one of the fastest-growing medical networks in Africa.
          We have sent an email to <?php echo $_SESSION['user_email'] ?>
          with instructions on how to verify your account.
          <br /><br />
          If you have not yet received this email, please click <a style='color:blue'>here</a>.
        </div>
      </div>
    </div>
  </div>
</body>
</html>