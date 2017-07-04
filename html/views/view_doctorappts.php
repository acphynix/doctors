<?php
  ob_start();
  session_start();
?>

<span ng-controller="patient_appointments">
<span id= "symptoms_list_container">
    <datalist id="symptoms_list"></datalist>
  </span>
  <span id= "specialities_list_container">
    <datalist id="specialities_list"></datalist>
</span>

<h2>My Appointments (Doctor Interface)</h2>

  {{schedule}}
<h3>Availabilities:</h3>
<table ng-init='get_schedule()' style='width:100%'>
  <tr><th>Start</th><th>End</th><th>Price</th><th>Type</th></tr>
  <tr ng-repeat="a in schedule.sched">
    <td>{{a.start}}</td>
    <td>{{a.end}}</td>
    <td>{{a.price}} {{a.currency}}</td>
    <td>{{a.type}}</td>
  </tr>
</table>
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