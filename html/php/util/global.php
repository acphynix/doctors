<?php

$GLOBALS['database'] = 'HealthTechSchema';

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

function import($file){
  require_once($_SERVER['DOCUMENT_ROOT'].'/'.$file);
}

function collect_params(){
  return json_decode(file_get_contents("php://input"), $assoc=true);
}
function has_key( $params, $key ){
  if(!$params)return false;
  return array_key_exists($key, $params);
}
function missing_params( $params, $required ){
  $missing = array();
  foreach($required as $field){
    if(!has_key($params, $field)){
      array_push($missing, $field);
    }
  }
  return $missing;
}
function required_params( $params, $required, $defaults ){
  $missing = array();
  $out = array();
  foreach($required as $field){
    if(!has_key($params, $field)){
      if(!has_key($defaults, $field)){
        array_push($missing, $field);
      }else{
        $out[$field] = $defaults[$field];
      }
    }else{
      $out[$field] = $params[$field];
    }
  }
  if(!empty($missing)){
    header( "HTTP/1.1 400 Bad Request " . join(", ", $missing)); 
    exit;
  }
  return $out;
}

?>