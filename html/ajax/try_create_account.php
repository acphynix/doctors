<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
    import('/php/util/sanitize.php');
    import('/php/util/emails.php');

    function send_email($address, $validate_hash){
      $to = $address;
      $subject = "Welcome to Neolafia!";

      $message = "
        <html>
          <head>
            <title>Welcome!</title>
          </head>
          <body>
            <p>
                Thank you for registering with Neolafia!
            </p><p>
                Your account has been created, and now all
                you have to do is click <a href='neolafia.com/verify_acct.php?q={$validate_hash}'>here</a> to verify
                your account information.
            </p>
            <p>
                Regards, <br /><br />
                <i>The entire Neolafia team</i>
            </p>
          </body>
        </html>
      ";

      // Always set content-type when sending HTML email
      $headers  = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers .= 'From: <webmaster@neolafia.com>' . "\r\n";
      mail($to,$subject,$message,$headers);
    }
    function console_log( $data ){
      // echo '<script>';
      // echo 'console.log('. json_encode( $data ) .')';
      // echo '</script>';
    }
    function verify_fields_populated($fields, $inarray){
      foreach($fields as $field){
        if(!array_key_exists($field, $inarray)){
          return false;
        }
      }
      return true;
    }

    function map_to_arrays_plain($map){
      $first = true;
      $keys = '';
      $vals = '';
      foreach($map as $key => $value) {
          if ($first){
            $keys = $key;
            $vals = $value;
            $first = false;
          }
          else{
            $keys .= ',' . $key;
            $vals .= ',' . $value;  
          } 
      }
      return ['keys'=>$keys, 'vals'=>$vals];
    }
    function verify_can_build_doctor_query(){
      return verify_fields_populated(['nLi','nSpc','nLoc','nChs','nQct','nAff','nNig'],$_POST);
    }
    function get_speciality_id($speciality, $db){
      // echo '~~~~~ ~~ ~ getting speciality: '.$speciality;
      $text = sanitize_plaintext($speciality);
      $db_1 = sprintf("select speciality from specialities where speciality_name='%s'",$speciality);
      $dq_1 = mysqli_query($db, $db_1);

      if(!$dq_1) return 0;
      return $dq_1->fetch_assoc()['speciality'];
    }
    function build_doctor_query($userid, $db){
      if(!verify_can_build_doctor_query())return false;

      $sql_insert = array(
          'user_id'        => "'${userid}'",
          'doctor_prof_picture'        => "''"
        , 'doctor_cert_status'         => "''"
        , 'doctor_registration_number' => "'".sanitize_registration_no($_POST['nLi'])."'"
        , 'doctor_suspension_status'   => "''"
        , 'doctor_speciality'          => "'". get_speciality_id($_POST['nSpc'],$db)."'"
        , 'doctor_location'            => "'".sanitize_plaintext($_POST['nLoc'])."'"
        , 'doctor_hospitals'           => "'".sanitize_plaintext($_POST['nChs'])."'"
        , 'doctor_qualifications'      => "'".sanitize_plaintext($_POST['nQct'])."'"
        , 'doctor_affiliations'        => "'".sanitize_plaintext($_POST['nAff'])."'"
        );

      $query_terms = map_to_arrays_plain($sql_insert);
      $query = sprintf("insert into doctors (%s) values (%s)",$query_terms['keys'],$query_terms['vals']);
      return $query;
    }
    function does_user_exist_by_email($email){

    }
    function build_user_query(){
      if(!verify_fields_populated(['nFn','nLn','nEm','nPw','year','month','day','nSx','nAd'],$_POST))return false;
      $firstname = sanitize_plaintext($_POST['nFn']);
      $lastname  = sanitize_plaintext($_POST['nLn']);
      $year      = sanitize_plaintext($_POST['year']);
      $month     = sanitize_plaintext($_POST['month']);
      $day       = sanitize_plaintext($_POST['day']);
      $sex       = sanitize_plaintext($_POST['nSx']);
      $address   = sanitize_plaintext($_POST['nAd']);
      $email     = sanitize_email    ($_POST['nEm']);
      $password  = urlencode($_POST['nPw']);
      $password  = password_hash($password, PASSWORD_DEFAULT);

      $sql_insert = array(
         'user_password'               => "'".$password."'"
       , 'user_first_name'             => "'".$firstname."'"
       , 'user_middle_name'            => "''"
       , 'user_last_name'              => "'".$lastname."'"
       , 'user_dob'                    => "'".$year.'-'.$month.'-'.$day."'"
       , 'user_address'                => "'".$address."'"
       , 'user_sex'                    => "'".$sex."'"
       , 'user_status'                 => "'pending'"
       , 'user_is_doctor'              => '0'
       , 'user_preexisting_conditions' => "''"
       , 'user_email'                  => "'".$email."'"
      );
      $query_terms = map_to_arrays_plain($sql_insert);
      $query = sprintf("insert into users (%s) values (%s)",$query_terms['keys'],$query_terms['vals']);
      return $query;
    }

    /*****************
      BEGIN HANDLER
    *****************/

    ob_start();

    // try to build a doctor
    $isdoctor = ($_POST['nIsD'] === 'true');
    $query_user = build_user_query();
    $query_doctor = false;

    // var_dump($_POST);

    if(!$query_user){
      echo '{"success":"false","msg":"Please enter all fields before submitting"}';
      return;
    }
    if($isdoctor && !verify_can_build_doctor_query()){
      echo '{"success":"false","msg":"Please enter all fields before submitting"}';
      return;
    }

    // connect to sql server.
    $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    if ($database->connect_error) {
      echo '{"success":"false","msg":"We are currently unable to process your request. Please try again later."}';
      return;
    }
    // perform user query.
    $result = mysqli_query($database, $query_user);
    if (!$result) {
      echo '{"success":"false","msg":"An account already exists with this email address."}';
      return;
    }
    // get new user id.
    $email = sanitize_email($_POST['nEm']);
    $userid = mysqli_query($database,sprintf("select user_id from users where user_email='%s'",$email))->fetch_assoc()['user_id'];
    // doctor query
    if($isdoctor){
      // construct doctor query
      $query_doctor = build_doctor_query($userid, $database);
      if(!$query_doctor){
        echo '{"success":"false","msg":"Please enter all fields before submitting"}';
        return;
      }
      // perform doctor query.
      $docres = mysqli_query($database, $query_doctor);
      $docres = mysqli_query($database, sprintf("update users set user_is_doctor='1' where user_id = %s", $userid));
      // echo $query_doctor;
      // echo $query_doctor;
      if (!$docres) {
        echo '{"success":"false","msg":"We are currently unable to process your request. Please try again later."}';
        return;
      }
    }

    $verify_str = bin2hex(random_bytes(10));
    $sql_addverify = sprintf("insert into email_verify (user_id, verify_code) values (%s,'%s')",$userid,$verify_str);
    $sres = mysqli_query($database, $sql_addverify);
    
    if($isdoctor){
      create_email($userid, 'doctor_account_new');
    }else{
      create_email($userid, 'patient_account_new');
    }

    // send_email($email,$verify_str);

    session_start();
    $_SESSION['user_email']  = $email;
    $_SESSION['user_id']     = $userid;
    $_SESSION['user_is_doctor']     = $query_doctor;
    $_SESSION['valid']       = true;
    $_SESSION['timeout']     = time();
    $_SESSION['displayname'] = sanitize_plaintext($_POST['nFn']) . ' ' . sanitize_plaintext($_POST['nLn']);

    mysqli_close($database);
    ob_end_flush();
    echo '{"success":"true","msg":"Success"}';
    // echo "<script> alert('".$sql."') </script>";
?>