<?php
  /**
   * 
   *  Semantically similar keywords, serviced by GET request.
   *  INPUT:  q=search_term
   *  OUTPUT:
   *    List of all similar search keywords.
   *
   */

  require('../util/sanitize.php');
  $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
  $query = sanitize_plaintext($_GET['q']);
  $db_1 =
    sprintf("select keyword from keywords where eq_class in (select eq_class from keywords where keyword='%s');",$query);

  $dq_1 = mysqli_query($database, $db_1);
  $dr_1 = [];
  $ds_1 = '';

  while ($row = $dq_1->fetch_assoc()) {
    array_push($dr_1, $row);
  }
  echo json_encode($dr_1);
?>