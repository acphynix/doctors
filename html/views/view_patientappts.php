<?php
  ob_start();
  session_start();
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script>
  var healthapp = angular.module('healthapp', []);
  healthapp.controller('PatientAppointments', function($scope){
    $scope.appointments=[{name:"John Smith"},{name:"Pedro Garcia"},{name:"Jane Doe"},{name:"Alejandra Lopez"}];
  });
  $(document).ready(function() {
    alert('yo');
    $('#calendar').text('hello!');
  });
</script>

<span ng-controller="patient_appointments">
<span ng-app="healthapp">
<span id= "symptoms_list_container">
    <datalist id="symptoms_list"></datalist>
  </span>
  <span id= "specialities_list_container">
    <datalist id="specialities_list"></datalist>
</span>

<h2>My Appointments (Patient Interface)</h2>

<table>
  <tr><th>Row number</th></tr>
  <tr ng-repeat="a in appointments"><td>{{a.name}}</td></tr>
</table>


<div id='calendar' width='30%'></div> 

</span>
</span>