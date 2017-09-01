<?php
  /** -- POST --
   * 
   *  Doctor and patient cancel appointment
   *  INPUT:  aid = appointment ID
   *  OUTPUT:
   *    {'success':true}
   *    {'success':false,'msg':'<message>'}
   *
   *  ACTION:
   *    a doctor and patient can request to cancel an appointment.
   *    if (1) a cancellation request is performed before 72 hours
   *           of the appointment, OR
   *       (2) both doctor and patient request to cancel the same
   *           appointment,
   *
   *    then the appointment is cancelled.
   *
   *  SECURITY:
   *    verify that this appointment is owned by the doctor and patient.
   *
   */


//echo "{'success':'false','msg':'todo'}";

session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/model/doctor.php');
import('/php/model/user.php');
import('/php/util/emails.php');
import('/php/util/sanitize.php');
import('/php/util/sql.php');

$params = required_params(collect_params(), array('a'),array());

$params['a'] = sanitize_plaintext($params['a']);

$user_id=$_SESSION['user_id'];

$database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");

$query1 = sprintf("delete from appointments where appointment_id=%s and status='pending'",$params['a']);
$query2 = sprintf("delete from timeslots where appointment_id=%s and type='appt'",$params['a']);
$result1 = mysqli_query($database, $query1);
$result2 = mysqli_query($database, $query2);

echo "{'success':'true'}";

?>