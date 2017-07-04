<?php
  /**
   * 
   *  Doctor request appointment, serviced by POST request.
   *  INPUT:  d=doctor_id, s=start_date, e=end_date
   *  OUTPUT:
   *    {'success':true}
   *    {'success':false,'msg':'<message>'}
   *  ACTION:
   *    a client requests to schedule an appointment with a doctor.
   *
   */

$date = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
echo $date->format('Y-m-d');

echo "{'success':'false','msg':'todo'}";

?>