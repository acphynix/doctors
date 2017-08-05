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
      header( "HTTP/1.1 500 Internal Server Error ");
      return;
    }
    $query = "SELECT user_first_name, user_last_name, user_id, user_email, ".
             "user_password, user_status, user_is_doctor FROM users WHERE ".
             "user_email='".$_POST['uname']."'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
      header( "HTTP/1.1 401 Unauthorized ");
      return;
    }
    $msg = 'Incorrect email or password';

    while ($row = mysqli_fetch_assoc($result)) {
      if(same_email   ($_POST['uname'], $row['user_email'   ]) &&
         same_password($_POST['pword'], $row['user_password'])){

        $_SESSION['user_id']         = $row['user_id'];
        $_SESSION['user_email']      = $row['user_email'];
        $_SESSION['user_is_doctor']  = $row['user_is_doctor'];
        $_SESSION['valid']           = true;
        $_SESSION['timeout']         = time();
        $_SESSION['displayname']     = $row['user_first_name'] . ' ' . $row['user_last_name'];
        echo '{"success":"true","msg":"success"}';
        return;
      }
    }
    header( "HTTP/1.1 401 Unauthorized ");
    return;
  } 
  header( "HTTP/1.1 401 Unauthorized ");
  return;
?>