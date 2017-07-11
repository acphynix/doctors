<?php
  ob_start();
  session_start();
?>
<script>

$('#upload').on('click', function() {
    var file_data = $('#sortpicture').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('nature','profile_picture');
    alert(form_data);                             
    $.ajax({
                url: '../ajax/update_profile.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    alert(php_script_response); // display response from the PHP script, if any
                }
     });
});

</script>
<span ng-controller="patient_appointments">
<span id= "symptoms_list_container">
    <datalist id="symptoms_list"></datalist>
  </span>
  <span id= "specialities_list_container">
    <datalist id="specialities_list"></datalist>
</span>

<h2>My Profile</h2>

  {{schedule}}
<h3>Set Profile Picture</h3>
<!-- <form id="file-form" method="POST">
  <input type="file" id="file-select" name="photos[]" multiple/>
  <button type="submit" id="upload-button">Upload</button>
</form> -->
<form>
<input id="sortpicture" type="file" name="sortpic" />
<button id="upload">Upload</button>
</form>

<h3>Requested Appointments:</h3>
<br />
<h3>Add Availability:</h3>
<form ng-submit='set_schedule(date_start,date_end,date_value)'>
  Start Date/Time:
  <input ng-model='date_start' type='text'>
  End Date/Time:
  <input ng-model='date_end'   type='text'>
  Type:
  <input ng-model='date_value' type='text'>
  <input type='submit' value='submit'>
</form>

<div style="font-weight:bold">
  
</div>
</span>
</span>