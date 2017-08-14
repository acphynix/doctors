<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/util/global.php');

$GLOBALS['database'] = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");

function sql_to_assoc( $db, $query ){
   $r  = mysqli_query($GLOBALS['database'], $query); 
   $rs = [];
   while ($row = $r->fetch_assoc()) {
    array_push($rs, $row);
   }
   return $rs;
}
function sql_get_insert( $db, $query){
  mysqli_query($GLOBALS['database'], $query); 
  return $GLOBALS['database']->insert_id;
}
function map_to_arrays($map){
  $first = true;
  $keys = '';
  $vals = '';
  foreach($map as $key => $value) {
    if ($first){
      $keys = $key;
      $vals = "'".$value."'";
      $first = false;
    }
    else{
      $keys .= ',' . $key;
      $vals .= ',' . "'".$value."'";  
    } 
  }
  return [ 'keys'=>$keys, 'vals'=>$vals ];
}
function update_string($map){
  $clauses = array();
  foreach($map as $key => $value) {
    array_push($clauses, "$key = '$value'"); 
  }
  return implode(', ', $clauses);
}
function query_insert_into( $table, $values){
  $query_terms = map_to_arrays($values);
  $query = sprintf("insert into $table (%s) values (%s)",$query_terms['keys'],$query_terms['vals']);
  // echo $query;
  return sql_get_insert('HealthTechSchema', $query);
}
function query_update( $table, $values, $where){
  $query_terms = update_string($values);
  $query = "update $table set $query_terms where $where";
  // echo $query;
  return sql_get_insert('HealthTechSchema', $query);
}
function query_select_from_eq( $table, $values, $where, $verbose=false){
  $query_terms = map_to_arrays($values);
  $query = sprintf("select %s from %s where %s", join(', ',$values), $table, $where);
  if($verbose){
    echo $query;
  }
  return sql_to_assoc('HealthTechSchema', $query);
}

?>