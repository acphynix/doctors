<?php
  ob_start();
  session_start();

  if (!empty($_GET['q'])){
    $conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $success = false;
    $hash = $_GET['q'];
    $query1 = sprintf("select user_id from email_verify where verify_code='%s'",$hash);
    echo $query1;
    $userid = mysqli_query($conn,$query1)->fetch_assoc()['user_id'];
    echo '.' . $userid;
    if($userid){
      $query2 = sprintf("select user_first_name from users where user_id='%s'",$userid);
      $user   = mysqli_query($conn,$query2)->fetch_assoc()['user_first_name'];
      echo $user;
      $success = true;
      
      $query3 = sprintf("update users set user_status='verified' where user_id=%s",$userid);
      mysqli_query($conn,$query3);
    }else{
      
    }
  }

  header('Location: /index.php');

?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="createaccount.js"></script>
<link rel="stylesheet" type="text/css" href="styles/date.css"> 
<link rel="stylesheet" type="text/css" href="forms.css"> 
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  
  $(document).ready(function () {

  });
</script>
<title>Ekuojumo</title>
</head>
<body style="background: #0a6a8e">
  <div style="justify-content: center; margin:auto; width:80%; padding:10px; display:block; margin-left:auto; margin-right:auto; border:3px solid black; margin: 0 auto; background:#2a7aae; min-height:100% ">
    <div class="form-style-8">
    <?php if($success): ?>
        <h2>Welcome!</h2>
        <div>
          Thank you, <?php echo $user?>. Your accounts has been validated. Please click <a href='login.php'>here</a> to log in to your account.
        </div>
        </div>
    <?php else: ?>
        <h2>Validation Error</h2>
        <div>
            The validation link is invalid or does not exist.
        </div>
        </div>
    <?php endif; ?>
  </div>
</body>
</html>