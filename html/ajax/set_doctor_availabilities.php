<?php
  session_start();
  /**  -- POST --
   * 
   *  Doctor set availabilities
   *  INPUT:  s=start_datetime, e=end_datetime, t='open','closed'
   *  OUTPUT:
   *    {'success':true}
   *    {'success':false,'msg':'<message>'}
   *
   */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/model/doctor.php');
import('/php/model/user.php');
import('/php/util/sanitize.php');

$params = json_decode(file_get_contents("php://input"), $assoc=true);
$params = required_params($params, array('data','bounds'),array());



function get_timeslots_intersecting( $db, $start, $end){
  $sqlformat = 'Y-m-d H:i:s';
  $start_s = date_format($start, $sqlformat);
  $end_s = date_format($end, $sqlformat);

  $q_1 = "select * from timeslots where ".
         "  (start between '$start_s' and '$end_s') OR ".
         "  (end   between '$start_s' and '$end_s') OR ".
         "  ('$start_s' between start and end     )    ";

  // echo $q_1 . "\n\n";

  $slots = mysqli_query($db, $q_1);

  return $slots;
}

function insert_timeslot( $db, $start, $end , $price, $currency){
  $doctor = new Doctor($_SESSION['user_id']);
  $sqlformat = 'Y-m-d H:i:s';
  $start_s = date_format($start, $sqlformat);
  $end_s = date_format($end, $sqlformat);

  $params=array(
      'user_id'           => $_SESSION['user_id']
    , 'appointment_id'    => "0"
    , 'price'             => $price
    , 'currency'          => $currency
    , 'type'              => "open"
    , 'start'             => "$start_s"
    , 'end'               => "$end_s"
    , 'timeslot_location' => $doctor->vals[0]['doctor_location']
    , 'timeslot_address'  => $doctor->vals[0]['doctor_hospitals']
  );

  $q = query_insert_into( 'timeslots', $params);
  echo $q;
  // echo $q;
  $res = mysqli_query( $db, $q );
}
function set_timeslot( $db, $timeslot, $start, $end  ){
  $sqlformat = 'Y-m-d H:i:s';
  $start_s = date_format($start, $sqlformat);
  $end_s = date_format($end, $sqlformat);
  $q = "update timeslots set start='$start_s', end='$end_s' where timeslot_id=".$timeslot['timeslot_id'];
  mysqli_query($db, $q);
}
function copy_timeslot( $db, $timeslot, $start, $end ){
  $sqlformat = 'Y-m-d H:i:s';
  $timeslot['start'] = date_format($start, $sqlformat);
  $timeslot['end']   = date_format($end  , $sqlformat);
  unset($timeslot['timeslot_id']);
  $q = query_insert_into( 'timeslots', $timeslot);
  echo $q;
  mysqli_query($db, $q);
}
function delete_timeslot( $db, $timeslot_id){
  $q = "delete from timeslots where timeslot_id=$timeslot_id";
  mysqli_query($db, $q);
}
function delete_open_timeslots_between ( $db, $low, $high ){
  $query = "delete from timeslots where type='open' and start>='$low' and end <='$high'";
  // echo '~~~~~~~~~~~~~~~~~~~~~~~~~';
  // echo $query;
  mysqli_query( $db, $query );
}

// $_SESSION['user_id']
// var_dump($params);
$database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");

$format    = 'Y-m-d H:i';
$sqlformat = 'Y-m-d H:i:s';

$bound1 = DateTime::createFromFormat($format, $params['bounds']['0']);
$bound2 = DateTime::createFromFormat($format, $params['bounds']['1']);

delete_open_timeslots_between( $database, $bound1->format($sqlformat), $bound2->format($sqlformat) );

foreach ($params['data'] as $event){
  echo 'enter ' . $event['s'] . ' to ' . $event['e']."\n\n";
  $date1 = DateTime::createFromFormat($format, $event['s']);
  $date2 = DateTime::createFromFormat($format, $event['e']);
  $price =    sanitize_number($event['p']);
  $currency = sanitize_plaintext($event['c']);

  $type  = $event['t'];
  if(!$date1 ||
     !$date2 ||
     $date2 < $bound1 ||
     $date1 < $bound1 ||
     $date2 > $bound2 ||
     $date1 > $bound2 ||
     !($type=== 'open' || $type=== 'closed')){
    echo ("invalid\n\n");
    continue;
  }

  $conflicts_result = get_timeslots_intersecting($database, $date1, $date2);
  $conflicts = [];
  while ($row = $conflicts_result->fetch_assoc()) {
    array_push($conflicts, $row);
  }

  $should_add = true;
  foreach ($conflicts as $conflict){
    if($conflict['type'] === 'appt'){
      echo 'conflict: '.$conflict['start']. ' -- '.$conflict['end'];
      $should_add = false;
      break;
    }
    $cd1 = DateTime::createFromFormat($sqlformat, $conflict['start']);
    $cd2 = DateTime::createFromFormat($sqlformat, $conflict['end']  );
    if($cd1 < $date1){
      if ($cd2 <=  $date1){
        // do nothing.
      } else
      if ($cd2 > $date1 && $cd2 <= $date2){
        // snip right segment.
        set_timeslot($database, $conflict, $cd1,$date1);
      }
      else{
        // split.
        echo json_encode($conflict);
        copy_timeslot ($database, $conflict, $cd1,$date1);
        copy_timeslot ($database, $conflict, $date2,$cd2);
        delete_timeslot($database, $conflict['timeslot_id']);
      }
    }else{
      if ($cd2 <= $date2){
        // delete conflict. 
        delete_timeslot($database, $conflict['timeslot_id']);
      }
      else{
        // snip left segment. 
        set_timeslot($database, $conflict, $date2, $cd2);
      }
    }
  }
  if($should_add){
    echo "Adding ".$event['s'].' - ' . $event['e'];
    insert_timeslot($database, $date1, $date2, $price, $currency);
  }
}


?>