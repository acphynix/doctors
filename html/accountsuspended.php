<?php
  session_start();
  if($_SESSION['valid']){
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
<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css"> 
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<!--<link rel="stylesheet" type="text/css" href="styles/date.css">--> 
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>
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
                        <h1 class="text-success">Account Suspended!</h1>
                        <p>
                            We are sorry but this account is currently suspended...Kindly check back
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