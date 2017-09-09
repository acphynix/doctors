<?php
error_reporting(0);
 session_start();
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];

  if (!empty($_GET['q'])){
    $conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $success = false; $userid = "";
    $hash = $_GET['q'];
    $query1 = sprintf("select user_id from password_reset where reset_code='%s'",$hash);
    $userid = mysqli_query($conn,$query1)->fetch_assoc()['user_id'];
    if($userid){
        $success = true;
    }
  }

?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css"> 
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<!--<link rel="stylesheet" type="text/css" href="styles/date.css">--> 
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>
<title>Neolafia</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  $(document).ready(function(){
    $("#iform_reset").submit(function(e) {
        var isValid = true;
        $("#errorPr").html('');
		if(!$("#nPw").val() || $("#nPw").val()===""){
			$("#errorPr").append("<li><b class='text-danger'>Please enter your new password</b></li>");
			isValid = false;
		}
        if($("#nPw").val()){
			if($("#nPw").val().length < 8){
				$("#errorPr").append("<li><b class='text-danger'>New Password must be at least 8 characters long</b></li>");
				isValid = false;
			}
			if(!$("#cPw").val()){
				$("#errorPr").append("<li><b class='text-danger'>Please confirm new password</b></li>");
				isValid = false;
			}
			if($("#nPw").val().length>=8 && $("#cPw").val().length>0){
				if($("#nPw").val() !== $("#cPw").val()){
					$("#errorPr").append("<li><b class='text-danger'>New passwords do not match!</b></li>");
					isValid = false;
				}
			}
		}
        if(isValid === true){
            $("#errorPr").html("<li><b class='text-info'>Resetting password...</b></li>");
           $.ajax({
            type: "POST",
            url: "ajax/set_new_password.php",
            data: $("#iform_reset").serialize(),
            success: function(data){
                if(data === "Server Error"){
                    $("#errorPr").html("<b class='text-danger'>Oops! We could not process your request at this time. Please try again later</b>");
                }
                if(data === "Password Updated"){
                    $("#nPw, #cPw").val("");
                    $("#errorPr").html("<b class='text-success'>Password updated successfully! You can now login with your new password</b>");
                }
            },
            error: function(){
                //
            }
           });
        }
      e.preventDefault();
    });
  });
</script>
</head>
<body>
    <div class="full-page">
        <?php include 'navbar.php'; ?>
        <?php if($success===true):?>
            <div class="container-fluid simple-page">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Resetting Password...</h4>
                        </div>
                        <div class="col-sm-offset-2 col-sm-8 login-form">
                            <ul id='errorPr' class="pass-reset text-center"></ul>
                            <form class="contact-form" role = "form" id='iform_reset' method = "post">
                                <input type="hidden" name="userid" value="<?php echo $userid; ?>"/>
                                <div class="form-group">
                                    <input name="nPw" type="password" id="nPw" placeholder="New Password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input name="cPw" type="password" id="cPw" placeholder="Confirm Password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input name="passReset" type="submit"   value="Reset Password" class="btn btn-success pull-right"/>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-12">
                            <p class="text-center text-success">
                                Click <a href="/login.php">here</a> to login
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="container-fluid other-pages">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="text-warning">Oops!</h1>
                            <p>
                                This link is either invalid or has expired...
                                Kindly click <a href="/index.php" style="color: blue;">here</a> to go to
                                the home page
                            </p>
                            <p>Thank you</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php  include 'footer.php'; ?>
</body>
</html>