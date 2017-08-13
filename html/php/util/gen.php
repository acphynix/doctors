<?php

require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
import('php/util/sql.php');


function gen_appt_code(){
  $generated = false;
  while(!$generated){
    $v='';
    for($i=0; $i<6; $i++){
      $c = random_int (0,34); // disallow '0'.
      if($c < 26){
        $c = chr(ord('A')+$c);
      }else{  // disallow '0'.
        $c = chr(ord('1')+$c-26);
      }
      $v .= $c;
    }
    $dbval = query_select_from_eq( 'appointments', array('apptcode'), "apptcode = '$v'");
    if(count($dbval) == 0){
      $generated = true;
    }
  }
  return $v;
}

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
