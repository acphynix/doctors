<?php
  session_start();
  if($_SESSION['valid']){
    header('Location: page/home.php') ;
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>
<!--<script>
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
</script>-->
<title>Neolafia</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
</head>
<body>
    <div class="full-page">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid other-pages">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="text-success">Welcome to Neolafia!</h1>
                        <p>
                            Thank you for creating an account with Neolafia, and becoming
                            a part of one of the fastest-growing medical networks in Africa.
                            We have sent an email to <?php echo $_SESSION['user_email'] ?>
                            with instructions on how to verify your account.<br/>
                            <!--If you have not yet received this email, please click <a href="#">here</a>-->
                        </p>
                        <p>Thank you</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  include 'footer.php'; ?>
</body>
</html>