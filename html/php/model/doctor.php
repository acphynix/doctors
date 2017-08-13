<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/util/global.php');
import('php/util/sql.php');

class Doctor{
  function __construct($user_id){
    $this->vals = query_select_from_eq( 'doctors', array('doctor_speciality','doctor_suspension_status','doctor_location','doctor_hospitals'), "user_id={$user_id}");
    $this->user_id = $user_id;
  }
  var $user_id;
}
?>