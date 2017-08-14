<?php

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/util/sql.php');

function create_email( $user_id, $type ){
  query_insert_into( 'emails',
    array('user_id'    => $user_id,
          'email_type' => $type)
    );
}

function create_email_for_appt( $user_id, $type, $appt_id ){
  $appt = query_select_from_eq( 'appointments', array('doctor_id, patient_id'), "appointment_id={$appt_id}");
  $data = $appt_id . '|' . $appt[0]['doctor_id'] . '|' . $appt[0]['patient_id'];
  query_insert_into( 'emails',
    array('user_id'     => $user_id,
          'email_type'  => $type,
          'email_idata' => $data)
    );
}

?>