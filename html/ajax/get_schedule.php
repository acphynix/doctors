<?php
  session_start();
  /**  -- GET --
   * 
   *  User get schedule
   *  INPUT:  u=user_id, s=start_date, e=end_date, show={doctor, patient}
   *    if u not specified, the current user is assumed.
   *    if either s or e is not specified, the maximally inclusive bounds are used.
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

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/model/doctor.php');
import('/php/model/user.php');

if(!$_SESSION['valid']){
  header('HTTP/1.1 403 Forbidden');
  return;
}

// $params             = required_params(collect_params(), array('u','s','show'),array('u'=>false,'s'=>false,'show'=>'doctor'));
$GET = required_params($_GET, array('s','show'),array('s'=>false,'show'=>'doctor'));
$user_id = $_SESSION['user_id'];
$user = new User($user_id);
$show_as_doctor = $user->vals[0]['user_is_doctor'] && ($GET['show']==='doctor');
function sql_to_list( $db, $query ){
  // echo $query;
  $r  = mysqli_query($db, $query); 
  $rs = [];
  while ($row = $r->fetch_assoc()) {
   array_push($rs, $row);
  }
  return $rs;
}

$database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");

if($show_as_doctor){
  $q1  = sprintf("select * from timeslots left join (select "
              ."appointment_id,doctor_id,patient_id,status,appt_type,"
              ."notes from appointments) as pappts on "
              ."(timeslots.appointment_id = pappts.appointment_id and timeslots.user_id = pappts.doctor_id) "
              ."left join (select user_id, user_first_name, user_middle_name,"
              ."user_last_name from users) as pusers on "
              ."(pappts.patient_id = pusers.user_id) where timeslots.user_id=%s",$user_id);
}
else{
  $q1  = sprintf("select * from timeslots left join appointments on "
                ."(timeslots.appointment_id = appointments.appointment_id) "
                ."left join doctors on (appointments.doctor_id = doctors.user_id) "
                ."left join (select user_id, user_first_name, user_middle_name, "
                ."user_last_name from users) as pusers on (doctors.user_id = pusers.user_id) "
                ." where timeslots.user_id=%s",$user_id);
}
$result = array(
  'sched' => sql_to_list($database, $q1),
  'show'  => $GET['show']
);
echo json_encode($result);


?>