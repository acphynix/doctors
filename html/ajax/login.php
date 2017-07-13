<?php
  /**     POST
   *
   * INPUT: uname:string; pword:string
   * OUTPUT: {success:bool,msg:string}
   *
   *
   */

  session_start();
  if($_SESSION['valid']){
    echo '{"success":"true","msg":"logged in"}';
    return;
  }
  
  $msg = '';
  $success = false;
  function same_password( $given, $stored ){
    return password_verify(urlencode($given), $stored);
  }
  function same_email( $given, $stored ){
    return $given === $stored;
  }
  $msg='';
  if (  !empty($_POST['uname']) 
     && !empty($_POST['pword'])) {
  $msg = $_POST['uname'] . $_POST['pword'];

    $conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");

    if ($conn->connect_error) {
      echo '{"success":"false","msg":"bad"}';
      return;
    }
    $query = "SELECT user_first_name, user_last_name, user_id, user_email, ".
             "user_password, user_status FROM users WHERE ".
             "user_email='".$_POST['uname']."'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
      echo '{"success":"false","msg":"bad"}';
      return;
    }
    $msg = 'Incorrect email or password';

    while ($row = mysqli_fetch_assoc($result)) {
      if(same_email   ($_POST['uname'], $row['user_email'   ]) &&
         same_password($_POST['pword'], $row['user_password'])){

        if(($row['user_status'] != 'verified')){
          echo '{"success":"false","msg":"unverified"}';
          return;
        }
        if(($row['user_status'] === 'verified')){
          $_SESSION['user_id']     = $row['user_id'];
          // $_SESSION['isdoctor']    = $row['user_id'];
          $_SESSION['valid']       = true;
          $_SESSION['timeout']     = time();
          $_SESSION['displayname'] = $row['user_first_name'] . ' ' . $row['user_last_name'];
          // echo "<script> window.location.assign('index.php'); </script>";
          echo '{"success":"true","msg":"success"}';
          return;
        }
      }
    }
    echo '{"success":"false","msg":"bad"}';
    return;
  } 
  echo '{"success":"false","msg":"bad"';
  return;
?>