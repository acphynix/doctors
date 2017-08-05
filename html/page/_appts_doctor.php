<div ng-show="is_show('appts.display')">
  <div style='width:100%;text-align:center;padding-top:2em;padding-bottom:1em;margin:0'>
    <div style='max-width:35em;display:inline-block;text-align:center;margin:0'>
      <div id='calendar'></div>
      <!-- hello -->
    </div>
  </div>
  <div style='width:100%;text-align:center;display:inline-block'>
    <div class='clickme' style='display:inline-block;width:35em;text-align:center;margin:0;font-size:1em;background-color:#fff0d0;font-family:Cabin;padding:0.33em;font-weight:bold' ng-click="view='appts.edit'">
      <span style='font-size:1.33em'>
      Manage Schedule
      </span>
    </div>
  </div>
  <div style='width:100%;text-align:center;margin-top:2em'>
    <div style='width:80%;min-width:35em;display:inline-block'>
      <h1 style='margin-top:0;text-align:left'>Upcoming Appointments</h1>
        <div style='width:100%;' ng-init=get_schedule('doctor')>
          <div style='text-align:left;background-color:#ddccaa;width:100%;margin-bottom:0.2em;padding:0.5em' ng-repeat="a in appointments">
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
                You must provide this code to your doctor during your visit: {{a.patientcode}}
              </div>
            </div>
          </div>
        </div>
      <h1 style='margin-top:0;text-align:left'>Past Appointments</h1>
    </div>
  </div>
</div>
<div ng-show="is_show('appts.edit')" style='background-color:rgba(255,200,0,0.05)'>

  <div style='padding-bottom:1em;margin:0'>
    <div id='popup_appt_create' style='font-family:Cabin;width:360px;height:160px;background-color:rgba(255,255,230,0.95);position:absolute;border:2px solid black;padding:20px;visibility:hidden'>
      <h3 style='padding-bottom:1em;margin:0;text-align:center'>Enter appointment fee:</h3>
      <div style='text-align:center'>
        <form>
          <table>
            <tr>
              <input  style='display:inline-block;width:100px;padding:5px;margin:20px;' type='text' value='100' autofocus />
              <select style='display:inline-block;padding:5px;margin:20px;background-color:rgba(235,220,180,1)' >
                <option value='USD'>USD</option>
                <option value='NGN'>NGN</option>
              </select>
            </tr>
            <tr>
              <div>
                <input style='display:inline;width:90px;padding:5px;font-family:Cabin;background-color:rgba(235,220,180,1)'
                       type='button' value='CANCEL' name='cancel'/>  
                <input style='display:inline;width:90px;padding:5px;font-family:Cabin;background-color:rgba(235,220,180,1)' type='submit' value='CREATE' />
              </div>
            </tr>
          </table>
        </form>
      </div>
    </div>

<h1 style='margin-top:0;text-align:center;padding-top:2em'>Manage Schedule</h1>
  <div style='width:100%;text-align:center;display:inline-block'>
    <div class='clickme' style='display:inline-block;width:100%;text-align:center;margin:0;font-size:1em;background-color:#fff0d0;font-family:Cabin;padding:0.33em;font-weight:bold' ng-click="set_view('appts.display')">
      <span style='font-size:1.33em'>
      Done
      </span>
    </div>
  </div>
    <div style='float:left;max-width:30em;padding:1em'>
      <div id='calendar_map'></div>
      <!-- hello -->
    </div>
    <div style='overflow:hidden;max-width:105em;min-width:34em;padding:1em'>
      <div id='calendar_week'></div>
      <!-- hello -->
    </div>
  </div>
  <br />
  <br />
  <br />
  <br />
  <br />
</div>