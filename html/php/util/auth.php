<?php

function same_password( $given, $stored ){
  return password_verify(urlencode($given), $stored);
}

?>