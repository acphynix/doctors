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

// if($user->vals[0]['user_is_doctor'] == '1'){
  // header( "HTTP/1.1 401 Unauthorized ");
  // return;
// }
$slots_all = array_merge($user->timeslots(), $doctor->timeslots());

$open      = false;
$booked    = false;
$take      = false;
$price     = false;
$currency  = false;

$output = '';

foreach ($slots_all as $slot){
  $d1 = DateTime::createFromFormat('Y-m-d H:i:s', $slot['start']);
  $d2 = DateTime::createFromFormat('Y-m-d H:i:s', $slot['end']);
  if( ($t1<=$d1 && $t2>=$d1) ||
      ($t1<=$d2 && $t2>=$d2) ||
      ($t1>=$d1 && $t2<=$d2)){
    // there is a conflict. see if it matters.
      // $output .= $slot['type'];
    if($slot['type'] === 'open'){
      if($t1>=$d1 && $t2<=$d2){
        $open     = true;
        $take     = $slot;
        $price    = $slot['price'];
        $currency = $slot['currency'];
      }
    }else if($slot['type'] === 'open'){
      if($t1==$d1 && $t2==$d2 && $slot['user_id'] == $user->user_id){
        $booked=true;
      }
    }else{
      if($t1>=$d1 && $t2<=$d2){
        $booked=true;
      }
    }
  }
}
if( $booked || !$open ){
  header( "HTTP/1.1 409 Conflict ");
  exit;
}

if(!array_key_exists('c', $params) || $params['c'] != 1){
  echo '{"price":'.$price.',"currency":"'.$currency.'"}';
  return;
}
$appt = query_insert_into('appointments',
          array('price'      => $take['price'],
                'currency'   => $take['currency'],
                'doctor_id'  => $doctor->user_id,
                'patient_id' => $user->user_id,
                'status'     => 'pending',
                'type'       => 'appointment',
                'notes'      => 'empty')
          );

$sqlformat = 'Y-m-d H:i:s';
query_insert_into('timeslots',
  array('user_id'        => $user->user_id,
        'appointment_id' => $appt,
        'price'          => $take['price'],
        'currency'       => $take['currency'],
        'type'           => 'pend',
        'start'          => date_format($t1, $sqlformat),
        'end'            => date_format($t2, $sqlformat)));

echo '{"success":"true"}';

// var_dump($appts_me);


// echo "{'success':'false','msg':'todo'}";

?>