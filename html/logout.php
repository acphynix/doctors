<?php
// logout. destroy session and return to homepage.
session_start();
session_destroy();
header( 'Location: index.php' ) ;
?>