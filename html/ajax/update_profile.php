<?php
  /**
   * 
   *  Update profile as either user or doctor.
   *  INPUT: nature:string of {profile_picture,certification,}
   *         upload:FILE
   *  OUTPUT:
   *    {'success':true}
   *    {'success':false,'msg':'<message>'}
   *  ACTION:
   *    updates a particular field.
   *  SECURITY:
   *    verify that this profile is owned by the user.
   *
   */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/model/doctor.php');
import('/php/model/user.php');
import('/php/util/sanitize.php');
import('/php/util/auth.php');

// $params = json_decode(file_get_contents("php://input"), $assoc=true);
// $params = required_params($params, array('data','bounds'),array());
$params = $_POST;

class Upload{
  function __construct($nature, $size, $upload){
    $this->nature = $nature;
    $this->size   = $size;
    $this->upload = $upload;
  }
  function getErrors(){
    if(!$this->size || !$this->nature || !$this->upload){
      return '{"success":"false","msg":"invalid 1"}';
    }
    if($this->nature != 'profile_picture' &&
       $this->nature != 'certification'){
      return '{"success":"false","msg":"invalid 2"}';
    }
    if($this->size > 819200){
      return '{"success":"false","msg":"size"}';
    }
    return false;
  }
  function sql_nature(){
    if ($this->nature === 'profile_picture')return 'pfp';
    if ($this->nature === 'certification')return 'cfn';
    else return 'unk';
  }
  function get_save_path(){
    $dir = '/home/ashwin/repo/doctors/data/';
    if($this->nature === 'profile_picture'){
      $dir.='profile/';
    }
    if($this->nature === 'certification'){
      $dir.='certification/';
    }
    $newname = tempnam($dir, 'img');
    return $newname;
  }
  function store_sql($path){
    $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $params=array(
        'user_id'        => $_SESSION['user_id']
      , 'filesize'       => $this->size
      , 'filepath'       => $path
      , 'mimetype'       => $this->mimetype
      , 'nature'         => $this->sql_nature()
      , 'is_clean'       => 'yes'
      , 'is_relevant'    => 'pending'
    );
    $q = query_insert_into( 'uploads', $params);
    // echo $q;
    return mysqli_query( $database, $q);
  }
  function store_profile_img($destination){
    exec(sprintf('convert "%s" -resize 256x256 "%s.jpg"',$destination,$destination));
    $this->mimetype='image/jpeg';
    return $destination.".jpg";
  }
  function store_document($destination){
    exec(sprintf('convert "%s" "%s.pdf"',$destination,$destination));
    $this->mimetype='application/pdf';
    return $destination.".pdf";
  }
  function get_sanitized_path_of($destination){
    $destination = realpath($destination);
    move_uploaded_file($this->upload, $destination);
    $filetype=array();

    exec(sprintf('identify -quiet %s',$destination),$filetype);
    $filetype = explode(" ",$filetype[0])[1];

    if($filetype!='JPEG' && $filetype!='PDF' && filetype!='PNG' && $filetype!='BMP'){
      return false;
    }
    if($this->nature === 'profile_picture')
      return $this->store_profile_img($destination);
    if($this->nature === 'certification')
      return $this->store_document($destination);
  }
  function store(){
    $file = $this->get_save_path();
    $file = $this->get_sanitized_path_of($file);
    if(!$file)return -1;
    $this->store_sql($file);
    return false;
  }
}

session_start();

if(!$_SESSION['valid']){
  header( "HTTP/1.1 403 Forbidden ");
  return;
}
// var_dump($params);
// echo '~~~~~~~~~~~~~~~~~~~~';
// var_dump($_FILES);
// echo '~~~~~~~~~~~~~~~~~~~~';
// var_dump($_POST);
// echo '~~~~~~~~~~~~~~~~~~~~';
if(has_key($_FILES,'file') && has_key($params,'nature')){
  $upload = new Upload($params['nature'], $_FILES['file']['size'],$_FILES['file']['tmp_name']);
  if($err = $upload->getErrors()){
    // echo $err;
    // return;
  }
  if($upload->store()){
    // header( "HTTP/1.1 501 Internal Error ");
    // return;
  }
}

$user   = new User($_SESSION['user_id']);
$doctor = new Doctor($_SESSION['user_id']);
$user_fields =
  array(
    'address' => array('user_address')
  );
$doctor_fields =
  array(
    'location' => array('doctor_location')
  );

$users_insert = array();
foreach($user_fields as $field => $value){
  if(has_key($params,$field)){
    $array_insert[$value[0]] = sanitize_plaintext($params[$field]);
  }
}
$doctors_insert = array();
foreach($doctor_fields as $field => $value){
  if(has_key($params,$field)){
    $array_insert[$value[0]]  = sanitize_plaintext($params[$field]);
  }
}

query_insert_into( 'users'  , $users_insert   );
query_insert_into( 'doctors', $doctors_insert );

// var_dump ($user->vals);

echo '~~~~~~~~';

if(has_key($params,'pword_current') && has_key($params,'pword_new')){
  // echo 'password';
  // echo $user->vals[0]['user_password'];
  // echo password_hash(urlencode($params['pword_current']), PASSWORD_DEFAULT);
  // if(same_password($params['pword_current'],$user->vals[0]['user_password'])){
  //   echo 'MATCH!!!!!~~~~~';
  // }
  // if(same_password($_POST['pword_current'], $user->vals[0]['user_password'])){
    // echo 'login ~~~||~~~';
  // }
  // echo 'given '.$_POST['pword_current'].
  if(strlen($params['pword_new'])>=8 && same_password($params['pword_current'], $user->vals[0]['user_password'])){
    echo 'correct';
    $password  = urlencode($params['pword_new']);
    $password  = password_hash($password, PASSWORD_DEFAULT);
    query_update( 'users', array('user_password'=>$password), 'user_id = '.$_SESSION['user_id']);
  }else{
    echo 'incorrect';
  }
}



echo '{"success":"true","msg":""}';

?>