<?php
  ob_start();
  session_start();
  
  $msg = '';
  $success = false;
  function same_password( $given, $stored ){
    return password_verify(urlencode($given), $stored);
  }
  function same_email( $given, $stored ){
    return $given === $stored;
  }
  $msg='';
  if (   isset($_POST['login'])
     && !empty($_POST['uname']) 
     && !empty($_POST['pword'])) {

    $conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");

    if ($conn->connect_error) {
      $msg='There was an error connecting to the server. Please try again later.';
      return;
    }
    $query = "SELECT user_first_name, user_last_name, user_id, user_email, ".
             "user_password, user_status FROM users WHERE ".
             "user_email='".$_POST['uname']."'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
      $msg='There was an error connecting to the server. Please try again later.';
      return;
    }
    $msg = 'Incorrect email or password';

    while ($row = mysqli_fetch_assoc($result)) {
      if(same_email   ($_POST['uname'], $row['user_email'   ]) &&
         same_password($_POST['pword'], $row['user_password'])){

        if(($row['user_status'] != 'verified')){
          $msg='Your account has not yet been verified.';
          return;
        }
        if(($row['user_status'] === 'verified')){
          $_SESSION['user_id']     = $row['user_id'];
          $_SESSION['valid']       = true;
          $_SESSION['timeout']     = time();
          $_SESSION['displayname'] = $row['user_first_name'] . ' ' . $row['user_last_name'];
          echo "<script> window.location.assign('index.php'); </script>";
          $success = true;
        }
      }
    }
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
                action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
                ?>" method = "post">
          <input name="uname" type="text" ng-model="uname" placeholder="Username">
          <input name="pword" type="password" ng-model="pword" placeholder="Password">
          <input name="login" type="submit" ng-click="update(user)" value="Sign in" />
        </form>
      </div>
    </div>
  </div>
</body>
</html>