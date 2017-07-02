<?php
    ob_start();
    session_start();
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="createaccount.js"></script>
<link rel="stylesheet" type="text/css" href="styles/date.css"> 
<link rel="stylesheet" type="text/css" href="forms.css"> 
<script>
  function goto(newpage){
    window.location.href = newpage
  }
  function submit_request_create(){
    console.log('hi');
    return false;
  }
  $(document).ready(function () {
    $("#iUr").click(function () {
        var formData = $("#form_req").serialize();
        $.ajax({
            type: "POST",
            url: "ajax/try_create_account.php", //serverside
            data: formData,
            beforeSend: function () {
                //show loading image
            },
            success: function (result) {
              console.log(result); //use this to see the response from serverside
            },
            error: function (e) {
                console.log(e); //use this to see an error in ajax request
            }
        });
    });
});
</script>
<title>Ekuojumo</title>
</head>
<body ng-app="InputDOB" ng-controller="DateController" style="background: #0a6a8e">
  <div style="justify-content: center; margin:auto; width:80%; padding:10px; display:block; margin-left:auto; margin-right:auto; border:3px solid black; margin: 0 auto; background:#2a7aae; min-height:100% ">
    <div class="form-style-8">
    <h2>Welcome!</h2>
    <div>
      We have sent a verification email to [email address]. Follow the instructions in the email
      to verify your account. Please allow up to 10 minutes to receive the email. To send it again,
      click <a style='color:blue'>here</a>.
    </div>
    </div>
  </div>
</body>
</html>