<?php
error_reporting(0);
  session_start();
  if($_SESSION['valid']){
    header('Location: page/home.php') ;
  }
  if($_SESSION['valid']){
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
      
      var $pageTitle = $("#pageName").data('page-title');
        $("ul.navbar-nav li#"+$pageTitle).addClass("active");
        
    $("#iform_login").submit(function(e) {
        var isValid = true;
        $("#error").html('');
        $.each($('#iform_login input'), function(k,v){
            if(!$(this).val() || $(this).val()===""){
                isValid = false;
                $("#error").html("Both Email address and password are required to sign in");
            }
        });
        if(isValid === true){
            $("#error").html('<b class="text-success">Getting you in...</b>');
            $.ajax({
            type: "POST",
            url: "ajax/login.php",
            data: $("#iform_login").serialize(),
            success: function(data){
              goto('index.php')
            },
            error: function(data){
                if(data.statusText === 'Internal Server Error'){
                    $("#error").html('<b class="text-danger">Oops! An error occured. Please try again later</b>');
                }
                if(data.statusText === 'Unauthorized'){
                    $("#error").html('<b class="text-danger">Incorrect Email address or password</b>');
                }
            }
           });
        }
      e.preventDefault();
    });
  });
</script>
<title>Neolafia | Sign in</title>
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
                        <h4>Sign in to Neolafia</h4>
                    </div>
                    <div class="col-sm-offset-2 col-sm-8 login-form">
                        <div id="error" class="text-danger text-center"></div>
                        <form role = "form" id='iform_login' method = "post" class="contact-form">
                            <div class="form-group">
                                <input name="uname" type="text" ng-model="uname" placeholder="E-mail Address" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="pword" type="password" ng-model="pword" placeholder="Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-right">
                                    <i class="fa fa-sign-in"></i> Sign in
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-12">
                        <p class="text-center text-success">
                            Forgot your password? Click 
                            <a href="/passwordreset.php">here</a>
                            to reset it
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  include 'footer.php'; ?>
</body>
</html>