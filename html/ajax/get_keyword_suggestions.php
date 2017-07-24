<?php
  /**
   * 
   *  Realtime keyword suggestion, serviced by GET request.
   *  INPUT:  q=search_term
   *  OUTPUT:
   *    List of all similar search keywords.
   *
   */

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('php/util/sanitize.php');

  $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
  $query = sanitize_plaintext($_GET['q']);
  $db_1 =
    sprintf("select distinct keyword from keywords where keyword like '%%%s%%'",$query);

  $dq_1 = mysqli_query($database, $db_1);
  $dr_1 = [];
  $ds_1 = '';

  while ($row = $dq_1->fetch_assoc()) {
    array_push($dr_1, $row);
  }
  echo json_encode($dr_1);
?>