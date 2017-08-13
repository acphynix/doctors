<?php

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/util/sql.php');

function create_email( $user_id, $type ){
  query_insert_into( 'emails',
    array('user_id'    => $user_id,
          'email_type' => $type)
    );
}

?>