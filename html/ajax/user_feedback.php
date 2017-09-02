<?php


ini_set('sendmail_path', '/usr/sbin/sendmail -t -i');

$firstname = $_POST['fname'];
$email = $_POST['emailad'];
$content = $_POST['msg'];

$to = "vjovict@gmail.com";
      $subject = "User Feedback!";

      $message = "
        <html>
          <head>
            <title>User Feedback</title>
          </head>
          <body>
            <p>
                A user, <b>".$firstname."</b> sent the following message on Neolafia. Please find below:
            </p>
            <p>
               ' ".$content." '
            </p>
            <p>
                Regards<br /><br />
            </p>
          </body>
        </html>
      ";

      // Always set content-type when sending HTML email
      $headers  = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers .= 'From: <'.$email.'>' . "\r\n";
      $headers .= 'X-Mailer: PHP/'.phpversion();
      mail($to,$subject,$message,$headers);

?>