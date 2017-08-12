<?php
  /** -- GET
  * 
  *  Get data about user.
  *  INPUT: u: user id
  *         q: space separated list of fields requested.
  *  OUTPUT:
  *   JSON response.
  *  SECURITY:
  *   verify that sensitive profile elements are owned by the user.
  */

function require_param_in( $parm, $array, $msg ){
  if(!array_key_exists($parm, $array)){
    header($msg);
    exit;
  }
}

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/model/doctor.php');
import('/php/model/user.php');
import('/php/util/sanitize.php');

session_start();
$params = json_decode(file_get_contents("php://input"), $assoc=true);

require_param_in('q', $_GET, 'HTTP/1.1 400 Bad Request');

if(!$_SESSION['valid']){
  header('HTTP/1.1 403 Forbidden');
  return;
}

$user = new User($_SESSION['user_id']);
if(has_key($_GET,'u')){
  $want = new User(sanitize_number($_GET['u']));
}else{
  $want = new User($_SESSION['user_id']);
}

if(!$want->exists()){
  header('HTTP/1.1 403 Forbidden');
  return;
}

// don't allow patients to see other patients' information.
if(    !$want->vals[0]['user_is_doctor']
    && !$user->vals[0]['user_is_doctor']
    &&  $user->user_id != $want->user_id){

  header('HTTP/1.1 403 Forbidden');
  return;
}

$asking = explode(' ',$_GET['q']);
$output = array();
foreach($asking as $term){
  if($term =='fname'){
    $output[$term] = $want->vals[0]['user_first_name'];
  }
  if($term =='lname'){
    $output[$term] = $want->vals[0]['user_last_name'];
  }
  if($want->vals[0]['user_is_doctor']){
    $want_dr = new Doctor(sanitize_number($_GET['u']));
    if($term == 'location'){
      $output[$term] = $want_dr->vals[0]['doctor_location'];
    }
  }
  // sensitive information, only allow self to see.
  if($user->user_id == $want->user_id){
    if($term =='email'){
      $output[$term] = $user->vals[0]['user_email'];
    }
    if($term =='status'){
      $output[$term] = $user->vals[0]['user_status'];
    }
    if($term =='dob'){
      $output[$term] = $user->vals[0]['user_dob'];
    }
    if($term =='address'){
      $output[$term] = $user->vals[0]['user_address'];
    }
    if($term =='sex'){
      $output[$term] = $user->vals[0]['user_sex'];
    }
  }
}

echo json_encode($output);

// echo $req;
// echo($user->exists());
// echo 'and';
// echo($want->exists());

// $uid = $_GET['u'];
// $nature = $_GET['n'];
// if(!($nature==='profile_picture' || $nature==='certification')){
//   header( "HTTP/1.0 404 Not Found ");
// }
// $request = new FileDownloadRequest($_SESSION, $nature, $uid);
// $request->serve();


?>