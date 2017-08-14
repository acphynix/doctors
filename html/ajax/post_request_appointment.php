<?php
  /**
   * 
   *  Patient request appointment, serviced by POST request.
   *  INPUT:  d=doctor_id, s=start_datetime, r=duration, c=should_create
   *  OUTPUT:
   *    {'success':true}
   *    {'success':false,'msg':'<message>'}
   *  ACTION:
   *    a client requests to schedule an appointment with a doctor.
   *    1. check if doctor is available
   *    2. check if patient is available
   *    3. perform payment
   *    4. add request to timeslots table.
   *
   */

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/model/doctor.php');
import('/php/model/user.php');
import('/php/util/gen.php');
import('/php/util/emails.php');

session_start();
$params             = json_decode(file_get_contents("php://input"), $assoc=true);


$t1 = DateTime::createFromFormat('Y-m-d H:i:s', $params['s']);
$t2 = DateTime::createFromFormat('Y-m-d H:i:s', $params['s']);
$min_appt_length = new DateInterval('PT1H'); // 1 hour.
$t2 = date_add($t2, $min_appt_length);

// echo $date->format('Y-m-d');

$database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
$user   = new User($_SESSION['user_id']);
$doctor = new User($params['d']);
if(!$_SESSION['valid']){
  header( "HTTP/1.1 403 Forbidden ");
   return;
}

$slots_all = array_merge($user->timeslots(), $doctor->timeslots());

$open      = false;
$booked    = false;
$take      = false;
$price     = false;
$currency  = false;

$output = '';

function new_slots_valid_with($t1, $t2, $allow_not_open, $slots){
  $open = false;
  $booked = false;
  $take = false;
  foreach($slots as $slot){
    $d1 = DateTime::createFromFormat('Y-m-d H:i:s', $slot['start']);
    $d2 = DateTime::createFromFormat('Y-m-d H:i:s', $slot['end']);
    if( ($t1<$d1  && $t2>$d1) ||
        ($t1<$d2  && $t2>$d2) ||
        ($t1>=$d1 && $t2<=$d2)){
      if($slot['type'] === 'open'){
        if($t1>=$d1 && $t2<=$d2){
          // if our request is contained fully within an opening, then we're good.
          $open     = true;
          $take     = $slot;
        }
      }else{
        // otherwise, we conflict with another slot.
        $booked = true;
      }
    }
  }
  if(($allow_not_open || $open) && !$booked){
    if($take == false)return true;
    else return $take;
  }else{
    return false;
  }
}

$valid_me =   new_slots_valid_with($t1, $t2, true, $user->timeslots());
$valid_them = new_slots_valid_with($t1, $t2, false, $doctor->timeslots());

if (!$valid_me || !$valid_them){
  header( "HTTP/1.1 409 Conflict ");
  exit;
}else{
  $take = $valid_them;
}

if(!array_key_exists('c', $params) || $params['c'] != 1){
  echo '{"price":'.$take['price'].',"currency":"'.$take['currency'].'"}';
  return;
}

$code = gen_appt_code();

$appt = query_insert_into('appointments',
          array(  
                  // 'price'      => $take['price']
                  // 'currency'   => $take['currency']
                  'doctor_id'  => $doctor->user_id
                , 'patient_id' => $user->user_id
                , 'status'     => 'pending'
                , 'appt_type'  => 'appointment'
                , 'apptcode'   => $code
                , 'notes'      => 'empty')
          );

create_email_for_appt( $doctor->user_id, 'doctor_appointment_pending',  $appt );
create_email_for_appt( $user->user_id,   'patient_appointment_pending', $appt );

$sqlformat = 'Y-m-d H:i:s';
query_insert_into('timeslots',
  array('user_id'           => $user->user_id,
        'appointment_id'    => $appt,
        'price'             => $take['price'],
        'currency'          => $take['currency'],
        'timeslot_location' => $take['timeslot_location'],
        'timeslot_address'  => $take['timeslot_address'],
        'type'              => 'appt',
        'start'             => date_format($t1, $sqlformat),
        'end'               => date_format($t2, $sqlformat)));

query_insert_into('timeslots',
  array('user_id'           => $doctor->user_id,
        'appointment_id'    => $appt,
        'price'             => $take['price'],
        'currency'          => $take['currency'],
        'timeslot_location' => $take['timeslot_location'],
        'timeslot_address'  => $take['timeslot_address'],
        'type'              => 'appt',
        'start'             => date_format($t1, $sqlformat),
        'end'               => date_format($t2, $sqlformat)));

echo sprintf('{"success":"true","code":"%s"}',$code);

// var_dump($appts_me);


// echo "{'success':'false','msg':'todo'}";

?>