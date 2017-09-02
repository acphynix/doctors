<?php
  ob_start();
  session_start();
  
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
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"> 
<link rel="stylesheet" type="text/css" href="styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="styles/date.css"> 
<link rel="stylesheet" type="text/css" href="forms.css"> 
<title>Neolafia</title>
</head>
<body style='padding:0'>
<div class='noboat'>
  <a href='index.php'>
  <h1 class='Neolafia' style='position:relative'>
      <img src='images/logo.png' style='height:1em;'/>
    
      Neolafia
    <!-- </a> -->
  </h1>
  </a>
  </div>
  <div class='account-body'>
    <div class='account-container'>
      <div class='account-entry' style='height:100%'>
        <h2 class='soloheading'>Account Authenticated</h2>
		<div class="contact-page">
            <?php if($success===true && $userId===""):?>
            <h1>Welcome!</h1>
            </p>
                Thank you again for registering an account with Neolafia! Your account have now been authenticated!
            </p>
            <p>
                Kindly click <a href="/login.php" style="color: blue;">here</a> to login in to your account
            </p>
			<?php elseif($success===true && $userId!==""):?>
            <h1>Welcome!</h1>
            </p>
                Thank you again for registering an account with Neolafia! Your account have now been authenticated!
            </p>
            <p>
                Kindly click <a href="/page/home.php" style="color: blue;">here</a> to go to your dashboard
            </p>
            <?php else: ?>
            <h1>Oops!</h1>
            </p>
                This link is either invalid or has expired
            </p>
            <p>
                Kindly click <a href="/index.php" style="color: blue;">here</a> to go to the home page
            </p>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>