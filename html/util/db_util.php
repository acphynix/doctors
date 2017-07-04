<?php
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
  function query_insert_into( $db, $table, $values){
    $query_terms = map_to_arrays($values);
    $query = sprintf("insert into $table (%s) values (%s)",$query_terms['keys'],$query_terms['vals']);
    return $query;
  }
?>