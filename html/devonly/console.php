
<html>
<link rel="stylesheet" href="style.css" />
<body style='padding:2em;font-family:Courier'>
<?php
  session_start();
  if(isset($_POST['username']) && isset($_POST['password'])) {
    if($_POST['username'] == 'admin' && $_POST['password'] == 'password'){
      $_SESSION['developer']=1;
    }
  }
  $logged_in = isset($_SESSION['developer']) && $_SESSION['developer'] ==1;
  if(isset($_POST['logout'])){
    session_destroy();
    $logged_in = false;
  }
  if($logged_in){
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  $( document ).ready(function(){
    $('#form').submit(function(evt){
      var command = $('#entry').val();
      $('#console').val($('#console').val()+"\n$ " + command + "\n");
      $('#entry').val('');

      $.ajax({
        type: "POST",
        url: "exec.php",
        data: {q:command},
        success: function(data){
          $('#console').val($('#console').val()+ data + "\n");
        },
        errfor: function(data){ }
      });


      var console = $('#console');
      if(console.length)
        console.scrollTop(console[0].scrollHeight - console.height());

      evt.preventDefault();
      return false;
    });
  });
</script>

<form action='console.php' method='post'>
  <div>Log out</div>
  <input value='Log Out' name='logout' type='submit'>
</form>
<div style='padding:2em'>
    <textarea id='console' style='width:100%;height:80vh'>
      ~~ $ Neolafia Console. Type commands in the box underneath and press [enter] ~~

    </textarea>
  <form id='form'>
    <input name='q' id='entry' type='text' style='width:100%' placeholder='Enter Commands Here'/>
    <input type='submit' value='submit'>
  </form>
</div>
<div style='height:10vh'>
</div>

<?php
  } else {
?>
<form action='console.php' method='post'>
  <table>
    <tr>
      <td>
        Username:
        </td>
      <td>
        <input type='text' name='username' />
      </td>
      </tr>
    <tr>
      <td>
        Password:
      </td>
      <td>
        <input type='password' name='password' />
      </td>
    </tr>
  </table>
  <input type='submit'>
</form>

<?php } ?>

</body>
</html>
