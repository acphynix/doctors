<?php

session_start();
$logged_in = isset($_SESSION['developer']) && $_SESSION['developer'] ==1;

if(!$logged_in){
  header('HTTP/1.1 403 Forbidden');
  return;
}

else{
  $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
  $q = $_POST['q'];
  $res = mysqli_query($database,$q);

  while ($row = $res->fetch_assoc()) { 
    foreach($row as $k => $v){
      echo $k;
      echo '=';
      echo $v;
      echo '; ';
    }
    echo "\n";
  }
  // var_dump($res);
}


?>