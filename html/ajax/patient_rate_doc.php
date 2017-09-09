<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/model/doctor.php');
import('/php/model/user.php');
import('/php/util/emails.php');
import('/php/util/sanitize.php');
import('/php/util/sql.php');

$params = required_params(collect_params(), array('a', 'f'),array());

$params['a'] = sanitize_number($params['a']);
$params['f'] = sanitize_number($params['f']);

$user_id=$_SESSION['user_id'];

$database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
if ($database->connect_error) {
	echo 'Server Error';
	return;
}

$query = sprintf("update appointments set patient_feedback = %s where appointment_id=%s",$params['f'], $params['a']);
$result = mysqli_query($database, $query);

echo "Done";
return;

?>