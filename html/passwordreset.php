<?php
  session_start();
  if($_SESSION['valid']){
    header('Location: page/home.php') ;
  }
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="forms.css"> 
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  $(document).ready(function(){
    $("#iform_reset").submit(function(e) {
        var isValid = true;
        $("#error").text('');
        $.each($('#iform_reset input'), function(k,v){
            if(!$(this).val() || $(this).val()===""){
                isValid = false;
                $("#error").text("Please enter your email address").css({color:'red'});
            }
        });
        if(isValid === true){
            $("#error").text('Please wait...').css({color:'inherit'});
           $.ajax({
            type: "POST",
            url: "ajax/reset_password.php",
            data: $("#iform_reset").serialize(),
            success: function(data){
                if(data === "Server Error"){
                    $("#error").text("Oops! We could not process your request at this time. Please try again later")
                    .css({color:'red'});
                }
                if(data === "Invalid Email"){
                    $("#error").text("The email address you have supplied does not exist in our record")
                    .css({color:'red'});
                }
                if(data === "Reset Link"){
                    $("#error").text("Kindly click on the link in the email sent to you to continue your password change")
                    .css({color:'green'});
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
</head>
<body>
<div class='noboat'>
  <a href='index.php'>
  <h1 class='Neolafia' style='position:relative'>
      <img src='../images/logo.png' style='height:1em;'/>
    
      Neolafia
    <!-- </a> -->
  </h1>
  </a>
  </div>
  <div class='frontpage-body'>
    <div class='frontpage-container'>
      <div class='frontpage-entry' style='height:100%'>
        <h2 class='soloheading'>Password Reset</h2>
		<div id='error' style='font-style:italic;font-weight:bold;color:red;font-size: 1.25vw; text-align:center;'></div>
        <form class="form-style-8 borderless centered" role = "form" 
              id='iform_reset' method = "post">
          <input name="uname" type="text"     ng-model="uname" placeholder="E-mail Address">
          <input name="login" type="submit"   value="Send Reset Link" />
        </form>
		<p style="text-align: center">
            Click <a href="/login.php" style="color: blue; font-size: 1vw;">here</a> to login
        </p>
      </div>
    </div>
  </div>
</body>
</html>