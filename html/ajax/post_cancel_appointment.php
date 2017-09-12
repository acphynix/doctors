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

$params = required_params(collect_params(), array('a', 'd', 'p'),array());

$params['a'] = sanitize_plaintext($params['a']);
$params['d'] = sanitize_plaintext($params['d']);
$params['p'] = sanitize_plaintext($params['p']);

$user_id=$_SESSION['user_id'];

$database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
$getapptid = sprintf("select appointment_id, doctor_id, patient_id from appointments where appointment_id=%s",$params['a']);
$rg = mysqli_query($database, $getapptid);
while ($row=  mysqli_fetch_assoc($rg)){
    $appt_idata = $row['appointment_id'].'|'.$row['doctor_id'].'|'.$row['patient_id'];
}

create_email_for_appt( $params['d'], 'doctor_appointment_cancelled',  $params['a'] );
create_email_for_appt( $params['p'],   'patient_appointment_cancelled', $params['a'] );

$query1 = sprintf("delete from appointments where appointment_id=%s and status='pending'",$params['a']);
$query2 = sprintf("delete from timeslots where appointment_id=%s and type='appt'",$params['a']);
$query3 = sprintf("delete from emails where email_idata=%s",$appt_idata);
$result1 = mysqli_query($database, $query1);
$result2 = mysqli_query($database, $query2);
$result3 = mysqli_query($database, $query3);

echo "{'success':'true'}";

?>