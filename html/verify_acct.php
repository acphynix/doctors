<?php
  ob_start();
  session_start();
  
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];
  
   $userId = '';
    if($_SESSION['user_id']){
      $userId = $_SESSION['user_id'];
    }

  if (!empty($_GET['q'])){
    $conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $success = false;
    $hash = $_GET['q'];
    $query1 = sprintf("select user_id from email_verify where verify_code='%s'",$hash);
    $userid = mysqli_query($conn,$query1)->fetch_assoc()['user_id'];
    if($userid){
      $query2 = sprintf("select user_first_name from users where user_id='%s'",$userid);
      $user   = mysqli_query($conn,$query2)->fetch_assoc()['user_first_name'];
      //echo $user;
      $success = true;
      
      $query3 = sprintf("update users set user_status='verified' where user_id='%s'",$userid);
      $query4 = sprintf("update email_verify set verify_code='' where user_id='%s'",$userid);
      mysqli_query($conn,$query3);
      mysqli_query($conn,$query4);
    }else{

    }
  }

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
                        <?php if($success===true && $userId===""):?>
                        <h1 class="text-success">Welcome!</h1>
                        <p>
                            Thank you again for registering an account with Neolafia! Your account have now been
                            authenticated!
                        </p>
                        <p>
                            Kindly click <a href="/login.php">here</a> to login to your account
                        </p>
                        <?php elseif($success===true && $userId!==""):?>
                        <h1 class="text-success">Welcome!</h1>
                        <p>
                            Thank you again for registering an account with Neolafia! Your account have now been
                            authenticated!
                        </p>
                        <p>
                            Kindly click <a href="/page/home.php">here</a> to go to your
                            dashboard
                        </p>
                        <?php else: ?>
                        <h1 class="text-warning">Oops!</h1>
                        <p>
                            This link is either invalid or has expired
                        </p>
                        <p>
                            Kindly click <a href="/index.php">here</a> to go to the home page
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-mgb"></div>
    <?php  include 'footer.php'; ?>
</body>
</html>