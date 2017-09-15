<?php

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('php/util/sanitize.php');

  $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
  $db_1 = "select distinct keyword from keywords";

  $dq_1 = mysqli_query($database, $db_1);
  $dr_1 = [];
  $ds_1 = '';

  while ($row = $dq_1->fetch_assoc()) {
    array_push($dr_1, $row['keyword']);
  }
  $db_2 = "select * from users where user_is_doctor=1";
  $dq_2 = mysqli_query($database, $db_2);
  while ($row = $dq_2->fetch_assoc()) {
    $doc['keyword']=$row['user_first_name'].' '.$row['user_last_name'];
    array_push($dr_1, $doc['keyword']);
  }
  echo implode("__", $dr_1);
?>