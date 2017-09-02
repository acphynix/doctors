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
  $(document).ready(function(){
    var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    $("#iform_feedback").submit(function(e) {
        var isValid = true;
        $("#status, #fnameErr, #emailadErr, #msgErr").html('');
        if(!$("#fname").val() || $("#fname").val()===""){
            isValid = false;
            $("#fnameErr").html("Please enter your first name").css({color:'red'});
        }
        if(!$("#emailad").val() || $("#emailad").val()===""){
            isValid = false;
            $("#emailadErr").html("Please enter your email adddress").css({color:'red'});
        }
        if($("#emailad").val()!==""){
            if(!emailRegex.test($("#emailad").val())){
                isValid = false;
                $("#emailadErr").html("Please enter a valid email address").css({color:'red'});
            }
        }
        if(!$("#msg").val() || $("#msg").val()===""){
            isValid = false;
            $("#msgErr").html("Please enter your message<br/><br/>").css({color:'red'});
        }
        if(isValid === true){
            $("#status").html('Please wait...').css({color:'inherit'});
            $.ajax({
            type: "POST",
            url: "ajax/user_feedback.php",
            data: $("#iform_login").serialize(),
            success: function(){
              $("#status").html("We have recieved your message. Thank you").css({color:'green'});
              $("#fname, #emailad, #msg").val('');
            },
            error: function(){
                $("#status").html('Oops! Please try again').css({color:'red'});
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
        <h2 class='soloheading'>Contact Us</h2>


        <div class="contact-page">
            <div style="width: 30%; float: left; margin-top: 120px;">
                <div class="contact">
                    <i class="fa fa-envelope"></i> <span>neolafia@neolafia.com</span>
                </div>
                <div class="contact">
                    <i class="fa fa-phone"></i> <span>+234 8034646465 (SMS only)</span>
                </div>
            </div>
            
            <div class='frontpage-entry' style='width: 55%; float: right;'>
                <div style="text-align: center; margin-top: -20px;">
                    <h4>We would like to here from you!</h4>
                    <p>Please use the form below to send us a feedback</p>
                </div>
            <div id='status' style='font-style:italic;font-weight:bold;color:green;font-size: 1vw; text-align:center;'></div>
            <form class="form-style-8 borderless centered" role = "form" 
                  id='iform_feedback' method = "post">
                <input name="fname" id="fname" type="text"     ng-model="fname" placeholder="First Name">
              <span style="font-size: 0.9vw; font-style: italic;" id="fnameErr"></span>
              <input name="emailad" id="emailad" type="text"     ng-model="emailad" placeholder="Email Address">
              <span style="font-size: 0.9vw; font-style: italic;"  id="emailadErr"></span>
              <textarea name="msg" id="msg" ng-model="msg" placeholder="Message"></textarea>
              <span style="font-size: 0.9vw; font-style: italic;"  id="msgErr"></span>
              <input name="login" type="submit"   value="Sign in" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>