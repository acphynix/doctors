<div style='width:100%;text-align:center;padding-top:2em;padding-bottom:2em;margin:0'>
  <div style='max-width:35em;display:inline-block;text-align:center;margin:0'>
    <div id='calendar'></div>
    <!-- hello -->
  </div> 
</div>
<div style='width:100%;text-align:center;margin-top:2em'>
  <div style='width:80%;min-width:35em;display:inline-block'>
    <h1 style='margin-top:0;text-align:left'>Upcoming Appointments</h1>
      <div style='width:100%;' ng-init="get_schedule('doctor')">
        <div style='text-align:left;background-color:#ddccaa;width:100%;margin-bottom:0.2em;padding:0.5em' ng-repeat="a in schedule">
          <div class='clickme' ng-click="a.show=!a.show">
            <h3 style='display:inline-block;margin:0;margin-left:2em;padding:0'>{{a.date_start.format("dddd, D MMMM YYYY")}}</h3>
            <h3 style='display:inline-block;margin:0;padding:0;padding-left:2em;padding-right:1em'> {{a.date_start.format("HH:mm")}}</h3>
            <span style='float:right;padding-right:0.5em;font-style:italic;color:gray'>Click to see details</span>
          </div>
          <div style='padding:1em' ng-show='a.show'>
            <div style='display:block;width:100%;padding:1em'>
              <div style="border:2px black solid;background-image:url({{user.image}});background-size:cover;width:4em;height:4em;margin-left:0;margin-right:1em;display:inline-block;float:left">
              </div>
              <div style='display:inline-block;margin-left:0'>
                <div style='padding:0;margin:0;font-family:cabin;font-size:1.5em'>Dr. {{a.user_first_name}} {{a.user_last_name}}</div>
                <div style='padding:0;margin:0;font-family:cabin'>{{a.timeslot_address}}</div>
                <div style='padding:0;margin:0;font-family:cabin'>{{a.timeslot_location}}</div>
              </div>
            </div>
            <div style='padding-right:0.5em;padding-left:1em;font-style:italic'>Appointment Notes:</div>
            <div style='padding:0.5em;padding-left:2em'>
              {{a.notes}}
            </div>
            <div style='padding-right:0.5em;padding-left:1em;font-style:italic'>Code:</div>
            <div style='padding:0.5em;padding-left:2em'>
              Make sure to provide this code to your doctor at your appointment: {{a.apptcode}}
            </div>
          </div>
        </div>
      </div>
    <h1 style='margin-top:0;text-align:left'>Past Appointments</h1>
  </div>
</div>