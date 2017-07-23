<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/util/global.php');
import('php/util/sql.php');

class User{
  function __construct($user_id){
    $this->vals = query_select_from_eq( 'users', array('user_is_doctor, user_first_name, user_last_name'), "user_id={$user_id}");
    $this->user_id = $user_id;
  }
  function timeslots(){
    return query_select_from_eq('timeslots', array('*'), "user_id={$this->user_id}");
  }
  function exists(){
    return ((sizeof($this->vals))>0);
  }
  var $user_id;
}
?>