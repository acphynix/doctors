<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/php/util/global.php");
    import('/php/util/sanitize.php');
    import('/php/util/emails.php');
	
	$firstname = sanitize_plaintext($_POST['fname']);
	$email = sanitize_email($_POST['emailad']);
	$content = sanitize_plaintext($_POST['msg']);

    $database = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    if ($database->connect_error) {
        echo 'Server Error';
        return;
    }
	
	$query = "select * from users_feedback";
	$qres = mysqli_query($database, $query);
        if(mysqli_num_rows($qres)==0){
            $stat = 987654321;
        }
        else{
            while ($row = mysqli_fetch_assoc($qres)) {
                $stat = $row['user_feedback_id'] + 1;
            }
        }
        echo $stat;
    
    $sql = sprintf("insert into users_feedback (user_feedback_id, user_first_name, user_email, content) values (%s, '%s','%s','%s')",$stat, $firstname,$email,$content);
	$sres = mysqli_query($database, $sql);
    
    create_email($stat, 'app_user_feedback');

    mysqli_close($database);
    echo 'Feedback Saved';
    return;
?>
