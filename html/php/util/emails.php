<?php

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('/php/sql.php');

function send_email( $email_to, $user_id, $subject, $body, $nature ){
  query_insert_into( 'emails',
    array('user_id' => $user_id,
          'subject' => $subject,
          'user_email' => $email_to,
          'content' => $body,
          'nature' => $nature,
          'status' => 'queued',
          'times_sent' => '0')
    );
}




?>