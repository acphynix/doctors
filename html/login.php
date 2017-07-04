<?php
   ob_start();
   session_start();
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<link rel="stylesheet" type="text/css" href="forms.css"> 
<script>
  function goto(newpage){
    window.location.href = newpage
  }
</script>
<title>Ekuojumo</title>
</head>
<body style="background: #0a6a8e">

         <?php
            function console_log( $data ){
              echo '<script>';
              echo 'console.log('. json_encode( $data ) .')';
              echo '</script>';
            }
            $msg = '';
            $success = false;
            
            if (isset($_POST['login'])
               && !empty($_POST['uname']) 
               && !empty($_POST['pword'])
               ) {

              $conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");

              // Check connection
              if ($conn->connect_error) {
                $msg='There was an error connecting to the server. Please try again later.';
              }
              else{
                $query = "SELECT user_first_name, user_last_name, user_id, user_email, user_password, user_status FROM users WHERE user_email='".$_POST['uname']."'";
                console_log($query);
                if ($result = mysqli_query($conn, $query)) {
                  console_log($result);
                  $msg = 'Incorrect email or password';

                  /* fetch associative array */
                  while ($row = mysqli_fetch_assoc($result)) {
                    if(($row['user_email'] === $_POST['uname']) &&
                       (password_verify(urlencode($_POST['pword']), $row['user_password']))){
                        if(($row['user_status'] === 'verified')){
                          $_SESSION['user_id'] = $row['user_id'];
                          $_SESSION['valid'] = true;
                          $_SESSION['timeout'] = time();
                          $_SESSION['displayname'] = $row['user_first_name'] . ' ' . $row['user_last_name'];
                          echo "<script> window.location.assign('index.php'); </script>";
                          $success = true;
                        }else{
                          $msg='Your account has not yet been verified.';
                        }
                    }
                  }
                  mysqli_free_result($result);
                  
                } else {
                  
                }
              }
              // mysqli_close($conn);
            }
        ?>

  <div style="justify-content: center; margin:auto; width:80%; padding:10px; display:block; margin-left:auto; margin-right:auto; border:3px solid black; margin: 0 auto; background:#2a7aae; min-height:100% ">
    <div class="form-style-8">
    <h2>Sign In To Your Account</h2>
    <form role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
      <input name="uname" type="text" ng-model="uname" placeholder="Username">
      <input name="pword" type="password" ng-model="pword" placeholder="Password">
      <input name="login" type="submit" ng-click="update(user)" value="Sign in" />
    </form>
    <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
    </div>
  </div>
</body>
</html>