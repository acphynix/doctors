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


echo "{'success':'false','msg':'todo'}";

?>