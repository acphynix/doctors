<?php
require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/util/sanitize.php');


  $password  = urlencode($_POST['nPw']);
  $password  = password_hash($password, PASSWORD_DEFAULT);
  $userid = $_POST['userid'];
$conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
if ($conn->connect_error) {
	echo 'Server Error';
	return;
}
$query = sprintf("update users set user_password='$password' where user_id='%s'",$userid);
$query2 = sprintf("update password_reset set reset_code='' where user_id='%s'",$userid);
mysqli_query($conn,$query);
mysqli_query($conn,$query2);
echo "Password Updated";
return;
?>