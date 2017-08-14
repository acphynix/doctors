<?php
  /** -- POST -- 
   * 
   *  Doctor or patient confirm appointment
   *  INPUT:  aid = appointment ID
   *  OUTPUT:
   *    {'success':true}
   *    {'success':false,'msg':'<message>'}
   *  ACTION:
   *    if doctor:  a doctor approves a particular request to a patient.
   *    if patient: a patient approves or rejects the proposed paymen
   *  SECURITY:
   *    verify that this appointment is owned by the doctor.
   *
   */

session_start();
require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/model/doctor.php');
import('/php/model/user.php');
import('/php/util/emails.php');
import('/php/util/sanitize.php');
import('/php/util/sql.php');

$params = required_params(collect_params(), array('a','v'),array());

$user_id=$_SESSION['user_id'];

$params['v'] = sanitize_plaintext($params['v']);
$params['a'] = sanitize_plaintext($params['a']);

$appt = query_select_from_eq('appointments',array('1'),sprintf("appointment_id=%s and doctor_id=%s and apptcode='%s' and status='approved'", $params['a'], $user_id, $params['v']));
if(count($appt) == 0){
   header('HTTP/1.1 403 Forbidden');
   return;
}

query_update( 'appointments', array('status' => 'completed'), sprintf("appointment_id=%s",$params['a']));
create_email_for_appt( $user_id, 'completed', $params['a'] );

echo "{'success':'true'}";

?>