<?php
  session_start();
  /**  -- POST --
   * 
   *  Doctor set availability
   *  INPUT:  s=start_datetime, e=end_datetime, t='open','closed'
   *  OUTPUT:
   *    {'success':true}
   *    {'success':false,'msg':'<message>'}
   *
   */

require('../util/db_util.php');


function get_timeslots_intersecting( $db, $start, $end){
  $sqlformat = 'Y-m-d H:i:s';
  $start_s = date_format($start, $sqlformat);
  $end_s = date_format($end, $sqlformat);

  $q_1 = "select * from timeslots where ".
         "  (start between '$start_s' and '$end_s') OR ".
         "  (end   between '$start_s' and '$end_s') OR ".
         "  ('$start_s' between start and '$end_s')    ";
  $slots = mysqli_query($db, $q_1);

  return $slots;
}

function insert_timeslot( $db, $start, $end ){
  $sqlformat = 'Y-m-d H:i:s';
  $start_s = date_format($start, $sqlformat);
  $end_s = date_format($end, $sqlformat);

  $params=array(
      'user_id'        => $_SESSION['user_id']
    , 'appointment_id' => "0"
    , 'price'          => "10000"
    , 'currency'       => "USD"
    , 'type'           => "open"
    , 'start'          => "$start_s"
    , 'end'            => "$end_s"
  );

  $q = query_insert_into( $db, 'timeslots', $params);
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
  $q = query_insert_into( $db, 'timeslots', $timeslot);
  echo $q;
  mysqli_query($db, $q);
}
function delete_timeslot( $db, $timeslot_id){
  $q = "delete from timeslots where timeslot_id=$timeslot_id";
  mysqli_query($db, $q);
}

$format    = 'Y-m-d H:i';
$sqlformat = 'Y-m-d H:i:s';

$date1 = DateTime::createFromFormat($format, $_GET['s']);
$date2 = DateTime::createFromFormat($format, $_GET['e']);
$type  = $_GET['t'];

if(!$date1){
  echo '{"success":"false","msg":"invalid format s"}';
  return;
}
if(!$date2){
  echo '{"success":"false","msg":"invalid format e"}';
  return;
}
if(!($type=== 'open' || $type=== 'closed')){
  echo '{"success":"false","msg":"invalid format t"}';
  return;
}

$database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");


$conflicts_result = get_timeslots_intersecting($database, $date1, $date2);
$conflicts = [];
while ($row = $conflicts_result->fetch_assoc()) {
  array_push($conflicts, $row);
}

foreach ($conflicts as $conflict){
  if($conflict['type'] === 'appt'){
  echo '{"success":"false","msg":"conflict with appt"}';
    return;
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

insert_timeslot($database, $date1, $date2);



// echo $date1->format($format);

// echo "{'success':'false','msg':'todo'}";


?>