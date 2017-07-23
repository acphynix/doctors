<?php

function sanitize_plaintext($input){
  return preg_replace('/[^\p{Latin}\d\s]/u', '', $input);
}
function sanitize_number($input){
  return preg_replace('/[^\d]/u', '', $input);
}
function sanitize_registration_no($input){
  return preg_replace('/[^\p{Latin}\d\s]/u', '', $input);
}
function sanitize_email($input){
  return preg_replace('/[^\p{Latin}\d\s@.]/u', '', $input);
}

?>