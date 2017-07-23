<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/util/global.php');
import('php/util/sql.php');

class Appointment{
  function __construct($doctor_id, $patient_id){
    $this->vals = query_select_from_eq( 'appointments', array('appointment_id'), "doctor_id={$doctor_id} and patient_id={$patient_id}");
  }
  function exists(){
    return ((sizeof($this->vals))>0);
  }
}
?>