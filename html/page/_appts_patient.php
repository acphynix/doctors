<div style='width:100%;text-align:center;padding-top:2em;padding-bottom:2em;margin:0'>
  <div style='max-width:35em;display:inline-block;text-align:center;margin:0'>
    <div id='calendar'></div>
    <!-- hello -->
  </div> 
</div>
<div style='width:100%;text-align:center;margin-top:2em'>
  <div style='width:80%;min-width:35em;display:inline-block'>
    <h1 style='margin-top:0;text-align:left'>Appointments</h1>
      <div style='width:100%;padding:2em' ng-init="get_schedule('doctor')">
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
          <tr ng-show='a.show' ng-init='a.show=true'>
            <td colspan='6' style='margin-bottom:0.66em'>
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
              <div style='padding:0.5em;padding-left:2em;'>
                {{a.notes}}
              </div>
              <div style='padding-right:0.5em;padding-left:1em;font-style:italic'>Required Tasks:</div>
              <div style='padding:0.5em;padding-left:2em;'>
                <div ng-if="a.status=='pending'">
                  Please send your payment of {{a.price}} {{a.currency}} to:
                    <table style='padding-left:4vw;margin-bottom:2em;width:30em;border-bottom:solid black 1px'>
                      <tr>
                        <td>Account Number:</td>
                        <td>12345678</td>
                      </tr>
                      <tr>
                        <td>Routing Number:</td>
                        <td>22446688</td>
                      </tr>
                      <tr>
                        <td>Memo:</td>
                        <td>{{a.apptcode}}</td>
                      </tr>
                    </table>
                  Dr. {{a.user_first_name}} {{a.user_last_name}} name will not be able to confirm your appointment
                  until the payment has been processed. Make sure you enter the code <b>{{a.apptcode}}</b> in
                  your transfer.
                </div>
                <div ng-if="a.status=='paid'">
                  We have received your payment, and are waiting for Dr. {{a.user_first_name}} {{a.user_last_name}} to
                  confirm your booking. If your booking is not confirmed within 7 days, it will be cancelled, and your
                  payment will be refunded.
                </div>
                <div ng-if="a.status=='approved'">
                  Your appointment has been approved. You have agreed to meet with Dr. {{a.user_first_name}} {{a.user_last_name}}
                  on {{a.date_start.format("D MMMM")}} at {{a.date_start.format("HH:mm")}}. Be sure to provide your doctor
                  with the code {{a.apptcode}} to verify that the appointment has taken place.
                </div>
                <div ng-if="a.status=='complete'">
                  Dr. {{a.user_first_name}} {{a.user_last_name}} has confirmed that your appointment has taken place.
                  Thank you for choosing to book your appointment with Neolafia!
                </div>
              </div>
              <!-- <div style='padding-right:0.5em;padding-left:1em;font-style:italic'>Code:</div> -->
              <p class='buttons'>
                <a> Request Cancellation </a>
                <a> Confirm Appointment  </a>
              </p>
            </td>
          </tr>
          <tr>
            <td colspan='6' style='padding:0.1em'>&nbsp;</td>
          </tr>
        </tbody>
        </table>
      </div>
  </div>
</div>