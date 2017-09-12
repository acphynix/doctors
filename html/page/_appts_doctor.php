<div ng-show="is_show('appts.display')" class="row db-page">
    <div class="col-xs-12 p-title">
        <h4 class="text-center">
            <b>
                <i class="fa fa-calendar-check-o"></i> APPOINTMENTS
            </b>
        </h4>
        <div class="u-line"></div>
    </div>
    <div class="col-xs-12">
        <div class="alert alert-success doc-appt">
            <div ng-if="pendingAppts.length===0">
                <h4 class="text-success howmany">
                    <i class="fa fa-info-circle"></i> No appointments scheduled
                </h4>
            </div>
            <div ng-if="pendingAppts.length === 1">
                <h4 class="text-success howmany">
                    <i class="fa fa-info-circle"></i> You have {{pendingAppts.length}} pending appointment
                </h4>
            </div>
            <div ng-if="pendingAppts.length > 1">
                <h4  class="text-success howmany">
                    <i class="fa fa-info-circle"></i> You have {{pendingAppts.length}} pending appointments
                </h4>
            </div>
        </div>
    </div>
    <div class="col-sm-offset-2 col-sm-8">
        <div class='clickme' ng-click="set_view('appts.edit')">
            <button class="btn btn-warning center-block full-width mg-sc"><i class="fa fa-gears"></i> Manage Schedule</button>
        </div>
        <br/><br/>
        <div id='calendar'></div>
        <hr/>
    </div>
    <div class="col-xs-12 p-content">
        <div ng-init="get_schedule('doctor')">
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
                                    <h4>{{a.user_first_name}} {{a.user_last_name}}</h4>
                                    <hr/>
                                    <span>{{a.timeslot_address}}</span>
                                    <span>{{location_name(a.timeslot_location)}}</span>
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
                                    <b>Information:</b><br/>
                                    <div ng-if="a.status=='pending'">
                                        <span>
                                            The payment details of {{a.user_first_name}} {{a.user_last_name}} are now being verified.
                                            After this process is complete, you will be able to confirm their appointment.
                                        </span>
                                    </div>
                                    <div ng-if="a.status=='paid'">
                                        <span>
                                            {{a.user_first_name}} has submitted their payment. Please confirm this appointment so that
                                            {{a.user_first_name}} knows that you are able to meet at the specified time.
                                        </span>
                                        <br/><br/>
                                        <form ng-submit="appt_approve(a.appointment_id)">
                                            <input name='appt_id' type='hidden' ng-attr-value="{{a.appointment_id}}" />
                                            <button type='submit' class="btn btn-success">
                                                <i class="fa fa-calendar-plus-o"></i> Confirm Appointment
                                            </button>
                                        </form>
                                    </div>
                                    <div ng-if="a.status=='approved'">
                                        <span>
                                            You're good to go! At your appointment, ask {{a.user_first_name}} for their 6-letter 
                                            verification code and enter it in the box below to receive your payment.
                                        </span>
                                        <br/><br/>
                                        <div class="alert alert-warning">
                                            <span>
                                                <i class="fa fa-lightbulb-o"></i>
                                                Important: You will not receive {{a.user_first_name}}'s payment unless you enter their code below.
                                            </span>
                                        </div>
                                        <form class='validate' ng-attr-id="form-{{a.appointment_id}}" ng-submit="appt_complete(a.appointment_id)">
                                            <div class="form-group">
                                                <input name='code' type='text' class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary pull-right">
                                                    <i class="fa fa-check-circle"></i> Validate
                                                </button>
                                            </div>
                                            <b><p name='feedback' class="text-info"></p></b>
                                        </form>
                                    </div>
                                    <div ng-if="a.status=='completed'">
                                        <span>
                                            Your verification code is correct, and the consultation fee will be
                                            paid into your bank account shortly. Please contact us at
                                            <a href='mailto:neolafia@neolafia.com'>neolafia@neolafia.com</a>
                                            with any questions or requests. Thank you for using Neolafia!
                                        </span>
                                    </div>                                
                                    <div ng-if="a.status=='closed'">
                                        <span>
                                            We have deposited the price of this appointment into your
                                            bank account. Please contact us at
                                            <a href='mailto:neolafia@neolafia.com'>neolafia@neolafia.com</a>
                                            with any questions or requests. Thank you for using Neolafia!
                                        </span>
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

<div ng-show="is_show('appts.edit')" class="db-page">
    <div class="set-appt">
        <div class="col-xs-12 calendar-view">
            <div class="row">
                <div id='popup_appt_create' class="time-val">
                <h3>Enter appointment fee:</h3>
                    <div class="center-block">
                        <form>
                            <table>
                                <tr>
                                    <div class="row">
                                        <div class="col-xs-8">
                                            <input class="form-control" type='text' value='100' autofocus />
                                        </div>
                                        <div class="col-xs-4">
                                            <select class="form-control">
                                                <option value='USD'>USD</option>
                                                <option value='NGN'>NGN</option>
                                            </select>
                                        </div>
                                    </div>
                                </tr>
                                <br/>
                                <tr>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input class="btn btn-default full-width" type='button' value='CANCEL' name='cancel'/>
                                        </div>
                                        <div class="col-xs-6">
                                            <input class="btn btn-success full-width" type='submit' value='CREATE' />
                                        </div>
                                    </div>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <h4 class="txt-apt">Manage Schedule</h4>
                <div class="col-sm-12">
                    <div id='calendar'></div>
                    <div class='clickme' ng-click="set_view('appts.display')">
                        <a href="/faq.php" class="btn btn-warning to-faq">FAQs</a>
                        <button class="btn btn-success center-block full-width mg-sc">
                            <i class="fa fa-check-circle"></i> Done
                        </button>
                    </div>
                </div>
                <div class="col-md-4 col-sm-5">
                    <div id='calendar_map'></div>
                    <br/><br/>
                    <div class="row">
                        <div class="calen-faq">
                            <h4 class="text-center text-info">
                                <b>How to use the Calendar:</b>
                            </h4>
                            <ul>
                                <li>
                                    <i class="fa fa-hand-o-right text-info"></i>
                                    To create an appointment, click on the grid that falls between your desired hour of day and day of week
                                    presented in the 'week' calendar
                                </li>
                                <li>
                                    <i class="fa fa-hand-o-right text-info"></i>
                                    Enter appointment fee and select currency on the dialog box that appears; then click
                                    create
                                </li>
                                <li>
                                    <i class="fa fa-hand-o-right text-info"></i>
                                    You can extend appointment time by hovering over the edge of the blue box 
                                    (which appeared after creating an appointment) till mouse pointer shape changes,
                                    then drag to the right or bottom
                                </li>
                                <li>
                                    <i class="fa fa-hand-o-right text-info"></i>
                                    You can change appointment time by hovering around the middle of the blue box till mouse pointer changes,
                                    then drag and drop in desired hour-day grid
                                </li>
                                <li>
                                    <i class="fa fa-hand-o-right text-info"></i>
                                    By clicking on any day on the 'month' calendar, whole week is highlighted and 
                                    manifested on the 'week' calendar
                                </li>
                                <li>
                                    <i class="fa fa-hand-o-right text-info"></i>
                                    Click on 'Done' at the top of the page to finish setting appointments
                                </li>
                            </ul>
                            <p><b>Legend:</b></p>
                            <ul>
                                <li>
                                    Blue: Open appointment
                                </li>
                                <li>
                                    Orange: Booked appointment
                                </li>
                                <li>
                                    Green: Selected week
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-1 col-md-7 col-sm-7">
                    <div id='calendar_week'></div>
                </div>
            </div>
        </div>
    </div>
</div>