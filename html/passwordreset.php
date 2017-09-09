<?php
  session_start();
  if($_SESSION['valid']){
    header('Location: page/home.php') ;
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

<script src="/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="/forms.css"> 
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  $(document).ready(function(){
    $("#iform_reset").submit(function(e) {
        var isValid = true;
        $("#error").html('');
        $.each($('#iform_reset input'), function(k,v){
            if(!$(this).val() || $(this).val()===""){
                isValid = false;
                $("#error").html("<b class='text-danger'>Please enter your email address</b>");
            }
        });
        if(isValid === true){
            $("#error").html('<b class="text-info">Please wait...</b>');
           $.ajax({
            type: "POST",
            url: "ajax/reset_password.php",
            data: $("#iform_reset").serialize(),
            success: function(data){
				$("#uname").val("");
                if(data === "Server Error"){
                    $("#error").html("<b class='text-danger'>\n\
                        Oops! We could not process your request at this time. Please try again later</b>");
                }
                if(data === "Invalid Email"){
                    $("#error").html("<b class='text-danger'>\n\
                        The email address you have supplied does not exist in our record</b>");
                }
                if(data === "Reset Link"){
                    $("#error").html("<b class='text-success'>\n\
                        Kindly click on the link in the email sent to you to continue your password change</b>");
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
<title>Neolafia</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>
</head>
<body>
    <div class="full-page">
    <div id="pageName" data-page-title="signinPage"></div>
        <?php include 'navbar.php'; ?>
        <div class="container-fluid simple-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Password Reset</h4>
                    </div>
                    <div class="col-sm-offset-2 col-sm-8 login-form">
                        <div id="error" class="text-center"></div>
                        <form class="contact-form" role = "form"  id='iform_reset' method = "post">
                            <div class="form-group">
                                <input name="uname" type="text" class="form-control" id="uname" placeholder="E-mail Address">
                            </div>
                            <div class="form-group">
                                <input name="passreset" type="submit" value="Send Reset Link" 
                                       class="btn btn-success pull-right"/>
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
    </div>
    <?php  include 'footer.php'; ?>
</body>
</html>