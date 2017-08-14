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
    <div style='width:80%;min-width:35em;display:inline-block;padding:4em'>
      <h1 style='margin-top:0;text-align:left'>Appointments</h1>
        <div style='width:100%;' ng-init=get_schedule('doctor')>
          <table class='schedule'>
          <tbody ng-repeat = 'a in appointments'>
            <tr style='font-family:Cabin;' class='clickme' ng-click='a.show=!a.show'>
              <td>{{a.status}}</td>
              <td style='width:0;padding:0;margin:0'>{{a.date_start.format("ddd")}}</td>
              <td style='width:0;padding:0;margin:0'>{{a.date_start.format("D MMMM YYYY")}}</td>
              <td style='width:0;padding:0;margin:0'>{{a.date_start.format("HH:mm")}}</td>
              <td style='width:0;padding:0;margin:0'>{{a.user_first_name}} {{a.user_last_name}}</td>
              <td style='width:0;padding:0;margin:0'>Click for Details</td>
            </tr>
            <tr ng-show='a.show'>
              <td colspan='6' style='margin-bottom:0.66em'>
                <div style='display:block;width:100%;padding:1em'>
                  <div style="border:2px black solid;background-image:url({{'/ajax/get_file.php?n=profile_picture&u='+a.user_id}});background-size:cover;width:4em;height:4em;margin-left:0;margin-right:1em;display:inline-block;float:left">
                  </div>
                  <div style='display:inline-block;margin-left:0'>
                    <div style='padding:0;margin:0;font-family:cabin;font-size:1.5em'>{{a.user_first_name}} {{a.user_last_name}}</div>
                    <div style='padding:0;margin:0;font-family:cabin'>{{a.timeslot_address}}</div>
                    <div style='padding:0;margin:0;font-family:cabin'>{{a.timeslot_location}}</div>
                  </div>
                </div>
                <div style='padding-right:0.5em;padding-left:1em;font-style:italic'>Appointment Notes:</div>
                <div style='padding:0.5em;padding-left:2em;'>
                  {{a.notes}}
                </div>
                <div style='padding-right:0.5em;padding-left:1em;font-style:italic'>Information:</div>
                <div style='padding:0.5em;padding-left:2em;'>
                  <div ng-if="a.status=='pending'">
                    The payment details of {{a.user_first_name}} {{a.user_last_name}} are now being verified.
                    After this process is complete, you will be able to confirm their appointment.
                  </div>
                  <div ng-if="a.status=='paid'">
                    {{a.user_first_name}} has submitted their payment. Please confirm this appointment so that
                    {{a.user_first_name}} knows that you are able to meet at the specified time.
                    <p class='buttons'>
                      <form ng-submit="appt_approve(a.appointment_id)">
                        <input name='appt_id' type='hidden' ng-attr-value="{{a.appointment_id}}" />
                        <input type='submit' value='Confirm Appointment' />
                      </form>
                    </p>
                  </div>
                  <div ng-if="a.status=='approved'">
                    You're good to go! At your appointment, ask {{a.user_first_name}} for their 6-letter verification code and
                    enter it in the box below to receive your payment. 

                    <i>Important: You will not receive {{a.user_first_name}}'s payment unless you enter their code below.</i>
                    <form class='validate' ng-attr-id="form-{{a.appointment_id}}" ng-submit="appt_complete(a.appointment_id)">
                        <input name='code' type='text'" />
                        <input type='submit' value='Validate' />
                        <br />
                        <p name='feedback'>
                        </p>
                    </form>
                  </div>
                  <div ng-if="a.status=='complete'">
                    Your verification code was correct, and the price of this appointment
                    will be funded into your bank account shortly. Please contact us at
                    <a href='mailto:neolafia@neolafia.com'>neolafia@neolafia.com</a>
                    with any questions or requests. Thank you for using Neolafia!
                  </div>
                </div>
                  <div ng-if="a.status=='closed'">
                    We have deposited the price of this appointment into your
                    bank account. Please contact us at
                    <a href='mailto:neolafia@neolafia.com'>neolafia@neolafia.com</a>
                    with any questions or requests. Thank you for using Neolafia!
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan='6' style='padding:0.1em'>&nbsp;</td>
            </tr>
          </tbody>
          </table>
<!--           <div style='text-align:left;background-color:#ddccaa;width:100%;margin-bottom:0.2em;padding:0.5em' ng-repeat="a in appointments">
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
            </div>
          </div> -->
        </div>
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