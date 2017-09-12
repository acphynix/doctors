<div class="row db-page">
    <div class="col-xs-12 p-title">
        <h4 class="text-center">
            <b>
                <i class="fa fa-calendar-check-o"></i> APPOINTMENTS
            </b>
        </h4>
        <div class="u-line"></div>
    </div>
    <div class="col-xs-12 p-content">
        <div id='calendar'></div>
        <div ng-init="get_schedule('doctor')">
            <div ng-if="pendingAppts.length===0">
                <h4 class="text-success howmany">No appointments scheduled</h4>
            </div>
            <div ng-if="pendingAppts.length === 1">
                <h4 class="text-success howmany">You have {{pendingAppts.length}} pending appointment</h4>
            </div>
            <div ng-if="pendingAppts.length > 1">
                <h4  class="text-success howmany">You have {{pendingAppts.length}} pending appointments</h4>
            </div>
            
        <table class='schedule table table-responsive'>
            <tbody ng-repeat = 'a in appointments'>
                <tr class='clickme' ng-click='a.show=!a.show'>
                    <td>{{a.status}}</td>
                    <td class="sm-hide">{{a.date_start.format("ddd")}}</td>
                    <td class="sm-hide">{{a.date_start.format("D MMMM YYYY")}}</td>
                    <td class="sm-hide">{{(a.date_start.format("HH:mm"))}}</td>
                    <td>{{a.user_first_name}} {{a.user_last_name}}</td>
                    <td>Click for Details</td>
                </tr>
                <tr ng-show='a.show'>
                    <td colspan='6'>
                        <div class="col-sm-4 col-xs-6 appt-doc-info">
                            <img ng-src="{{'/ajax/get_file.php?n=profile_picture&u='+a.user_id}}"
                                 class="img-responsive" alt="image"/>
                            <div>
                                <h4>Dr. {{a.user_first_name}} {{a.user_last_name}}</h4>
                                <span ng-if="a.status!='pending'">{{a.timeslot_address}}</span>
                                <span><b>{{location_name(a.timeslot_location)}}</b></span>
                            </div>
                        </div>
                        <div class="col-xs-6 th-info">
                            <span>{{a.status}} appointment</span>
                            <span>{{a.date_start.format("ddd")}}, {{a.date_start.format("D MMMM YYYY")}}</span>
                            <span>{{(a.date_start.format("HH:mm"))}}</span>
                        </div>
                        <div class="col-sm-8 appt-info">
                            <div class="col-xs-12 grp">
                                <b>Appointment Notes:</b><br/>
                                {{a.notes}}
                            </div>
                            <div class="col-xs-12 grp">
                                <b>Required Tasks:</b><br/>
                                <div ng-if="a.status=='pending'">
                                  Please send your payment of {{a.price}} {{a.currency}} to:
                                    <table class="table table-responsive table-hover inner-table">
                                        <tr>
                                          <td>Account Number:</td>
                                          <td>3004298963</td>
                                        </tr>
                                        <tr>
                                          <td>Bank:</td>
                                          <td>FIRST BANK NIGERIA</td>
                                        </tr>
                                        <tr>
                                          <td>Memo:</td>
                                          <td>{{a.apptcode}}</td>
                                        </tr>
                                    </table>
                                    <span>
                                        Dr. {{a.user_first_name}} {{a.user_last_name}} will not be able to confirm your appointment
                                        until the payment has been processed. Make sure you enter the code <b>{{a.apptcode}}</b> in
                                        your transfer.
                                    </span>
                                </div>
                                <div ng-if="a.status=='paid'">
                                    <span>
                                        We have received your payment, and are waiting for Dr. {{a.user_first_name}} {{a.user_last_name}} to
                                        confirm your booking. If your booking is not confirmed within 7 days, it will be cancelled, and your
                                        payment will be refunded.
                                    </span>
                                </div>
                                <div ng-if="a.status=='approved'">
                                    <span>
                                        Your appointment has been approved. You have agreed to meet with Dr. {{a.user_first_name}} {{a.user_last_name}}
                                        on {{a.date_start.format("D MMMM")}} at {{(a.date_start.format("HH:mm"))}}. Be sure to provide your doctor
                                        with the code {{a.apptcode}} to verify that the appointment has taken place.
                                    </span>
                                </div>
                                <div ng-if="a.status=='completed'">
                                    <span>
                                        Dr. {{a.user_first_name}} {{a.user_last_name}} has confirmed that your appointment has taken place.
                                        Thank you for choosing to book your appointment with Neolafia!
                                    </span>
                                    <div class="patient-rating" ng-if="!a.patient_feedback">
                                        <span class="text-info" ng-show="pst1">
                                            <b>Please take moment to rate this doctor during this appointment...</b>
                                        </span>
                                        <div class="rating" ng-show="pst1">
                                            <span id="dp-rating"><b>Star: {{patient_rating}}</b></span><br/>
                                            <span ng-class="{'text-orange':patient_rating===1}" class="fa fa-star" ng-click="rg(1)"></span>
                                            <span ng-class="{'text-orange':patient_rating===2}" class="fa fa-star" ng-click="rg(2)"></span>
                                            <span ng-class="{'text-orange':patient_rating===3}" class="fa fa-star" ng-click="rg(3)"></span>
                                            <span ng-class="{'text-orange':patient_rating===4}" class="fa fa-star" ng-click="rg(4)"></span>
                                            <span ng-class="{'text-orange':patient_rating===5}" class="fa fa-star" ng-click="rg(5)"></span>
                                            <br/><br/>
                                            <button type="button" class="btn btn-success" ng-click="rApt(a.appointment_id)">
                                                Rate
                                            </button>
                                        </div>
                                        <div class="text-success" ng-show="pst2">
                                            <b><i class="fa fa-thumbs-up"></i> Thank you for your feedback</b>
                                        </div>
                                        <div class="text-warning" ng-show="pst3">
                                            <b><i class="fa fa-refresh"></i> Oops! Please try again later</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-if="a.status=='pending'" class="col-xs-12 grp">
                                <button type="button" class="btn btn-danger" 
                                        data-toggle="modal" data-target="#webModal{{a.appointment_id}}">
                                    <i class="fa fa-close"></i>
                                    Cancel this appointment
                                </button>
                            </div>
                            <div class="modal fade" id="webModal{{a.appointment_id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                &times;
                                            </button>
                                            <h4 class="modal-title"><b>Cancellation of Appointment</b></h4>
                                        </div>
                                        <div class="modal-body">
                                            <span>
                                                Are you sure you want to cancel this appointment?
                                            </span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" 
                                                    ng-click="appt_cancel(a.appointment_id+'__'+a.doctor_id+'__'+a.patient_id)">
                                                Yes
                                            </button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                No
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="distinct">
                    <td colspan="6"></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
</div>