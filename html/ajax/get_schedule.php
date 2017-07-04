<?php
  session_start();
  /**  -- GET --
   * 
   *  User get schedule
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
function sql_get_json_with( $db, $query ){
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

$q1  = sprintf("select * from timeslots    where user_id   = %s",$user);
$q2  = sprintf("select * from appointments where doctor_id = %s",$user);
$result = array(
  'sched' => sql_get_json_with($database, $q1),
  'appts' => sql_get_json_with($database, $q2)
);
echo json_encode($result);


?>