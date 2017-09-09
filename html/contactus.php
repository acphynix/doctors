<?php
error_reporting(0);
  session_start();
  if($_SESSION['valid']){
    $login=1;
  }
  $displayname = $_SESSION['displayname'];
  $isdoctor = $_SESSION['user_is_doctor'];
  
    $userId = $userfirstname = $useremail = '';
    if($_SESSION['user_id']){
      $userId = $_SESSION['user_id'];
    }
    $conn = new mysqli("localhost", "ec2-user", "", "HealthTechSchema");
    $query = sprintf("select user_first_name, user_email from users where user_id='%s'",$userId);
    $result = mysqli_query($conn,$query);
    while ($row = mysqli_fetch_assoc($result)) {
        $userfirstname = $row['user_first_name'];
        $useremail = $row['user_email'];
    }

?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand|Zilla+Slab|Cabin" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/styles/styles.css"> 
<!--<link rel="stylesheet" type="text/css" href="styles/date.css">--> 
<link rel="stylesheet" type="text/css" href="/forms.css">  
<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/css/custom.css"/>
<title>Neolafia | Contact Us</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1"/>

<script>
  $(document).ready(function(){
      
      var $pageTitle = $("#pageName").data('page-title');
        $("ul.navbar-nav li#"+$pageTitle).addClass("active");
        
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
            data: $("#iform_feedback").serialize(),
            success: function(data){
				if(data==='Server Error'){
					$("#status").html("Oops! We could not process your request at this time. Please try again later")
                    .css({color:'red'});
				}
                if(data === "Feedback Saved"){
                    $("#status").html("Thank you for your message "+$("#fname").val()).css({color:'green'});
					$("#fname, #emailad, #msg").val('');
                }
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
<body>
    <div class="full-page">
    <div id="pageName" data-page-title="contactPage"></div>
        <?php include 'navbar.php'; ?>
        <div class="container-fluid simple-page">
            <div class="container contact-us">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Contact Us</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <p class="text-orange"><b>We would like to here from you!</b></p>
                        <p>Please use the form below to send us a feedback</p>
                        <form class="contact-form" role = "form" id='iform_feedback' method = "post">
                            <div class="form-group">
                                <input name="fname" id="fname" type="text" value="<?php echo $userfirstname; ?>"
                                       ng-model="fname" placeholder="First Name" class="form-control">
                                <span class="error" id="fnameErr"></span>
                            </div>
                            <div class="form-group">
                                <input name="emailad" id="emailad" type="text" value="<?php echo $useremail; ?>" 
                                       ng-model="emailad" placeholder="Email Address" class="form-control">
                                <span class="error" id="emailadErr"></span>
                            </div>
                            <div class="form-group">
                                <textarea name="msg" rows="7" id="msg" ng-model="msg" placeholder="Message"
                                          class="form-control"></textarea>
                                <span class="error"  id="msgErr"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-right">
                                    <i class="fa fa-location-arrow"></i> Send
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-offset-1 col-sm-4">
                        <div class="pull-right">
                            <p class="text-success">
                                <i class="fa fa-envelope"></i> <span>neolafia@neolafia.com</span>
                            </p>
                            <p class="text-success">
                                <i class="fa fa-phone"></i> <span>+234 8034646465 (9am - 6pm)</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  include 'footer.php'; ?>
</body>
</html>