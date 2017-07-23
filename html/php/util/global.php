<?php

$GLOBALS['database'] = 'HealthTechSchema';

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

function import($file){
  require_once($_SERVER['DOCUMENT_ROOT'].'/'.$file);
}

?>