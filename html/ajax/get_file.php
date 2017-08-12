<?php
  /** -- GET
  * 
  *  Get user's file.
  *  INPUT: n:string of {profile_picture,certification,...}
  *      u:int user id
  *  OUTPUT:
  *   HTTP response with file.
  *  SECURITY:
  *   verify that sensitive profile elements are owned by the user.
  */

require_once($_SERVER['DOCUMENT_ROOT'].'/php/util/sql.php');

session_start();

class FileDownloadRequest{
  function __construct($session, $nature, $uid){
    if(has_key($session, 'valid') && $session['valid']){
      $this->loggedin = $_SESSION['user_id'];
    }
    else $this->loggedin = false;
    $this->nature = $nature;
    $this->uid = $uid;

    $this->filepath = false;
    $this->mimetype = 0;
  }
  function get_filepath(){
    $sql_type = ($this->nature==='profile_picture')?'pfp':
                (($this->nature==='certification' )?'cfn':
                                'unk');
    $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $query = sprintf("select filepath,mimetype from uploads where user_id='%s' and nature='%s' and is_clean='yes' order by upload_id desc",$this->uid,$sql_type);
    $row = mysqli_query( $database, $query);
    $row = $row->fetch_assoc();
    if(!$row){
      return false;
    }
    $this->mimetype = $row['mimetype'];
    $this->filepath = $row['filepath'];
  }
  function serve_null(){
    header( "HTTP/1.0 404 Not Found");
  }
  function serve_content($filepath){
    header("Content-type: image/jpeg");
    header("Accept-Ranges: bytes");
    header('Content-Length: ' . filesize($this->filepath));
    header("Last-Modified: Fri, 03 Mar 2004 06:32:31 GMT");
    // echo $this->filepath;
    readfile($this->filepath);
  }
  function serve(){
// echo 'hi!11';
    $this->get_filepath();
    if(!$this->filepath){
      $this->filepath=$_SERVER['DOCUMENT_ROOT'].'/images/icon_blankuser.png';
      $this->mimetype='image/png';
      // $this->serve_null();
      // return;
    }
    $this->serve_content($this->filepath);
  }
}


$uid = $_GET['u'];
$nature = $_GET['n'];
if(!($nature==='profile_picture' || $nature==='certification')){
  header( "HTTP/1.0 404 Not Found ");
}
$request = new FileDownloadRequest($_SESSION, $nature, $uid);
$request->serve();


?>