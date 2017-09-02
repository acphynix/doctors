<?php

  if (!empty($_GET['q'])){
    $conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $success = false; $userid = "";
    $hash = $_GET['q'];
    $query1 = sprintf("select user_id from password_reset where reset_code='%s'",$hash);
    $userid = mysqli_query($conn,$query1)->fetch_assoc()['user_id'];
    if($userid){
      //$query2 = sprintf("select user_first_name from users where user_id='%s'",$userid);
      //$user   = mysqli_query($conn,$query2)->fetch_assoc()['user_first_name'];
      $success = true;
    }else{

    }
  }

?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"> 
<link rel="stylesheet" type="text/css" href="styles/styles.css"> 
<link rel="stylesheet" type="text/css" href="styles/date.css"> 
<link rel="stylesheet" type="text/css" href="forms.css"> 
<title>Neolafia</title>
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  $(document).ready(function(){
    $("#iform_reset").submit(function(e) {
        var isValid = true;
        $("#errorPr").html('');
		if(!$("#nPw").val() || $("#nPw").val()===""){
			$("#errorPr").append("<li>Please enter your new password</li>");
			isValid = false;
		}
        if($("#nPw").val()){
			if($("#nPw").val().length < 8){
				$("#errorPr").append("<li>New Password must be at least 8 characters long</li>");
				isValid = false;
			}
			if(!$("#cPw").val()){
				$("#errorPr").append("<li>Please confirm new password</li>");
				isValid = false;
			}
			if($("#nPw").val().length>=8 && $("#cPw").val().length>0){
				if($("#nPw").val() !== $("#cPw").val()){
					$("#errorPr").append("<li>New passwords do not match!</li>");
					isValid = false;
				}
			}
		}
        if(isValid === true){
            $("#errorPr").html('<li>Please wait...</li>').css({color:'inherit'});
           $.ajax({
            type: "POST",
            url: "ajax/set_new_password.php",
            data: $("#iform_reset").serialize(),
            success: function(data){
                $("#nPw, #cPw").val("");
                if(data === "Server Error"){
                    $("#errorPr").html("<li>Oops! We could not process your request at this time. Please try again later</li>")
                    .css({color:'red'});
                }
                if(data === "Password Updated"){
                    $("#errorPr").html("Password updated successfully! You can now login with your new password")
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
</head>
<body style='padding:0'>
<div class='noboat'>
  <a href='index.php'>
  <h1 class='Neolafia' style='position:relative'>
      <img src='images/logo.png' style='height:1em;'/>
    
      Neolafia
    <!-- </a> -->
  </h1>
  </a>
  </div>
  <div class='account-body'>
    <div class='account-container'>
      <div class='account-entry' style='height:100%'>
        <h2 class='soloheading'>Password Reset</h2>
		<div class="contact-page">
		
		<ul id='errorPr' style='list-style-type: none; font-style:italic;font-weight:bold;color:red;font-size: 1.2vw; text-align:center;'></ul>
            <?php if($success===true):?>
				<form class="form-style-8 borderless centered" role = "form" 
					  id='iform_reset' method = "post">
				  <input name="nPw" type="password" id="nPw" placeholder="New Password">
				  <input name="cPw" type="password" id="cPw" placeholder="Confirm Password">
				  <input type="hidden" name="userid" value="<?php echo $userid; ?>"/>
				  <input name="passReset" type="submit"   value="Reset Password" />
				</form>
				<p style="text-align: center">
					Click <a href="/login.php" style="color: blue; font-size: 1vw;">here</a> to login
				</p>
            <?php else: ?>
				<h1>Oops!</h1>
				</p>
					This link is either invalid or has expired
				</p>
				<p>
					Kindly click <a href="/index.php" style="color: blue;">here</a> to go to the home page
				</p>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>