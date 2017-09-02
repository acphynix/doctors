<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
    import('/php/util/sanitize.php');
    import('/php/util/emails.php');

    $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    if ($database->connect_error) {
        echo 'Server Error';
        return;
    }
    $email = sanitize_email($_POST['uname']);
    $userid = mysqli_query($database,sprintf("select user_id from users where user_email='%s'",$email))->fetch_assoc()['user_id'];
    if(!$userid){
        echo 'Invalid Email';
        return;
    }
    
    $verify_str = bin2hex(random_bytes(10));
    $useridPr = 
            mysqli_query($database,
                    sprintf("select user_id from password_reset where user_id='%s' and reset_code=''",$userid))
            ->fetch_assoc()['user_id'];
    if($useridPr){
        $sql = sprintf("update password_reset set reset_code='%s' where user_id='%s'",$verify_str, $userid);
        $res = mysqli_query($database, $sql);
    }
    if(!$useridPr){
        $sql_addverify = sprintf("insert into password_reset (user_id, reset_code) values (%s,'%s')",$userid,$verify_str);
        $sres = mysqli_query($database, $sql_addverify);
    }
    
    create_email($userid, 'user_account_passwordreset');

    mysqli_close($database);
    echo 'Reset Link';
    return;
?>