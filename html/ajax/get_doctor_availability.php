<?php
  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  /**  -- GET --
   * 
   *  Get list of availabilities for a given doctor.
   *  INPUT:  u=user_id, s=start_date, e=end_date
   *    if u not specified, the current user is assumed.
   *    if either s or e is not specified, the most inclusive bounds are used.
   *  OUTPUT:
   *    returns a list of event objects for a particular user between specified
   *    start and end dates. An event is {start:datetime, end:datetime, data:DATA},
   *    with DATA either {type:open} OR {type:closed,patient:PATIENT}
   *    with PATIENT={user_id:int,name:string, ... }.
   *    Times which are not specified are assumed
   *          for doctors  to be unavailable,
   *      but for patients to be available
   *
   */
function sql_get_array_with( $db, $query ){
   $r  = mysqli_query($db, $query); 
   $rs = [];
   while ($row = $r->fetch_assoc()) {
    array_push($rs, $row);
   }
   return $rs;
}

$user = '';

if($_GET['u']){
  $user=$_GET['u'];
}
else{
  $user=$_SESSION['user_id'];
}

$database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");

$q1   = sprintf("select * from timeslots where user_id = %s",$user);
$evts = sql_get_array_with($database, $q1);

$availabilities = [];

$sqlformat = 'Y-m-d H:i:s';
$min_appt_length = new DateInterval('PT1H'); // 1 hour.


$unavailableSlots = [];
foreach ($evts as $evt){
    if($evt['type'] !== 'open'){
        array_push($unavailableSlots, $evt['user_id']."__".$evt['start']."__".$evt['end']);
    }
}

foreach ($evts as $evt){
  if($evt['type'] === 'open'){
    $start     = DateTime::createFromFormat($sqlformat, $evt['start']);
    $start_fwd = DateTime::createFromFormat($sqlformat, $evt['start']);
    $start_fwd = date_add($start_fwd, $min_appt_length);
    $end       = DateTime::createFromFormat($sqlformat, $evt['end']  );
    while($start_fwd <= $end){
      $start_s = date_format($start,     $sqlformat);
      $end_s   = date_format($start_fwd, $sqlformat);
      if(!in_array(($evt['user_id']."__".$start_s."__".$end_s), $unavailableSlots)){
          array_push($availabilities,
            array(  's'=>$start_s
                  , 'e'=>$end_s
                  , 'p'=>$evt['price']
                  , 'c'=>$evt['currency']
                  , 'l'=>$evt['timeslot_location']
          ));
      }
      $start =     date_add($start, $min_appt_length);
      $start_fwd = date_add($start_fwd, $min_appt_length);
    }
  }
}


// $result = array(
//   'sched' => $q1),
//   'appts' => sql_get_array_with($database, $q2)
// );
echo json_encode($availabilities);


?>