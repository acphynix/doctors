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

require('../util/db_util.php');

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
    if (nature === 'profile_picture')return 'pfp';
    if (nature === 'certification')return 'cfn';
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
    $q = query_insert_into( $database, 'uploads', $params);
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
  echo '{"success":"false","msg":"permission"}';
  return;
}

$upload = new Upload($_POST['nature'], $_FILES['file']['size'],$_FILES['file']['tmp_name']);


if($err = $upload->getErrors()){
  echo $err;
  return;
}

if($upload->store()){
  echo '{"success":"false","msg":"invalid"}';
  return;
}

echo '{"success":"true","msg":""}';

?>