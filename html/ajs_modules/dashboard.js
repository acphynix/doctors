var doctor_search = angular.module('dashboard', []);

doctor_search.controller('navigation', function($scope, $window, $http){
  $scope.view='appts.display';
  $scope.view='profile';
  $scope.edit_bounds = [undefined, undefined];
  $scope.is_show = function(show){
    return $scope.view.startsWith(show);
  }
  $scope.populate_form_fields=function(){
    $scope.profile_form_fields = [
      { heading : 'Personal Information',
        title   : 'Date of Birth',
        id      : 'dob',
        name    : 'dob',
        value   : $scope.user.dob,
        disabled: 'true',
        type    : 'text' },
      { heading : '',
        title   : 'Sex',
        id      : 'sex',
        name    : 'sex',
        value   : $scope.user.sex=='M'?'Male':'Female',
        disabled: 'true',
        type    : 'text' },
      { heading : '',
        title   : 'Address',
        id      : 'address',
        name    : 'address',
        value   : $scope.user.address,
        disabled: 'true',
        type    : 'text' },
      { heading : 'Account Information',
        title   : 'Account Status',
        id      : 'status',
        name    : 'status',
        value   : $scope.user.role,
        disabled: 'true',
        type    : 'text' },
      { heading : '',
        title   : 'Profile Picture',
        id      : 'picture',
        name    : 'picture',
        value   : 'value',
        disabled: 'false',
        type    : 'file' },
      { heading : 'Change Password',
        title   : 'Current Password',
        id      : 'pword_current',
        name    : 'pword_current',
        value   : '',
        disabled: 'false',
        type    : 'password' },
      { heading : '',
        title   : 'New Password',
        id      : 'pword_new',
        name    : 'pword_new',
        value   : '',
        disabled: 'false',
        type    : 'password' },
      { heading : '',
        title   : 'Confirm Password',
        id      : 'pword_confirm',
        name    : 'pword_confirm',
        value   : '',
        disabled: 'false',
        type    : 'password' },
    ];
    if($user.is_doctor){
      doctor_fields = [
        { heading : 'Medical Registration Information',
          title   : 'Registration',
          id      : 'registration',
          name    : 'registration',
          value   : $scope.user.registration,
          disabled: 'true',
          type    : 'text' }, 
        { heading : '',
          title   : 'Registration',
          id      : 'registration',
          name    : 'registration',
          value   : $scope.user.registration,
          disabled: 'true',
          type    : 'text' }, 
        { heading : '',
          title   : 'Speciality',
          id      : 'speciality',
          name    : 'speciality',
          value   : $scope.user.speciality,
          disabled: 'true',
          type    : 'text' },
        { heading : '',
          title   : 'Location',
          id      : 'location',
          name    : 'location',
          value   : $scope.user.location,
          disabled: 'true',
          type    : 'text' },
        { heading : '',
          title   : 'Hospital Affiliation',
          id      : 'hospital',
          name    : 'hospital',
          value   : $scope.user.hospital,
          disabled: 'true',
          type    : 'text' },
        { heading : '',
          title   : 'Qualifications',
          id      : 'qualifications',
          name    : 'qualifications',
          value   : $scope.user.qualification,
          disabled: 'true',
          type    : 'text' }
      ];
      $scope.profile_form_fields.push.apply($scope.profile_form_fields,doctor_fields);
    }
  };
  $scope.populate_user_info=function(){
    var ajax = new XMLHttpRequest();
    $.ajaxSetup({ cache: false });
    ajax.open("GET", "../ajax/user.php?q=fname lname email status dob address sex&rand="+Math.random(), true);
    ajax.onload = function() {
      $scope.$apply(function(){
        console.log('response: ');
        console.log(ajax.responseText);
        var res = JSON.parse(ajax.responseText);

        $scope.user =
          { image:'/ajax/get_file.php?n=profile_picture&u='+$window.user_id
          , name: res.fname+' '+res.lname
          , email: res.email
          , role: res.status==='verified'?'verified user':'unverified'
          , dob: res.dob
          , sex: res.sex
          , address: res.address
          ,
          };
        $scope.populate_form_fields();
      });
    };
    ajax.send();
  };
  $('#form_profile').submit(function(event){
    var file_data = $('input[name=picture]').prop('files')[0];   
    var form_data = new FormData();
    $.each($scope.profile_form_fields,function(k,v){
      console.log(v.name);
      console.log($('#'+v.id).val());
      form_data.append(v.name,$('#'+v.id).val());
    });
    form_data.append('file', file_data);
    // form_data.append('file2', file_data);
    form_data.append('nature','profile_picture'); 
    $.ajax({
      url: '/ajax/update_profile.php', // point to server-side PHP script 
      dataType: 'text',  // what to expect back from the PHP script, if anything
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,                         
      type: 'POST',
      success: function(php_script_response){
        console.log('rrr');
        console.log(JSON.stringify(php_script_response)); // display response from the PHP script, if any
        $scope.populate_form_fields();
      },
      error: function(data){
        console.log('rrr');
        console.log(JSON.stringify(data)); // display response from the PHP script, if any   
        $scope.populate_form_fields();     
      }
     });
  });
  $scope.populate_user_info();

  $scope.calendar_events = function(start, end, timezone, callback){
    console.log('pulling events');
    var events=[];
    if(typeof $scope.schedule !== 'undefined'){
      for(var i=0; i<$scope.schedule.length; ++i){
        var evt   = $scope.schedule[i];
        var title = evt.user_first_name + ' ' + $scope.schedule[i].user_last_name;
        var start = evt.date_start;
        var end   = evt.date_end;
        var color;
        if(evt.type == 'open'){
          color = 'gray';
          title = 'open';
        }else if(evt.type == 'pend'){
          color='orange';
        }else{
          color='auto';
        }
        events.push(
          { title : title
          , start : start
          , end   : end
          , color : color
          }
        );
      }
    }
    callback(events);
  }
  if($window.is_doctor){
    $('#calendar').fullCalendar({
      events: $scope.calendar_events,
      displayEventEnd:true,
      width: 20,
      timezone:'local',
      aspectRatio: 1
      // put your options and callbacks here
    });
    $('#calendar_map').fullCalendar({
      dayRender: function (date, cell) {
        if($scope.view_start!=undefined && $scope.view_end!=undefined){
          if(date >= $scope.view_start && date < $scope.view_end){
            cell.css('background-color','#e0f0ff');
          }else{
            cell.css('background-color','auto');
          }
        }else{
            // cell.css('background-color','#ffaaaa');
        }
        // cell.css("background-color", "lightgreen");
      },
      timezone:'local',
      selectable:true,
      displayEventEnd:true,
      events: function(start, end, timezone, callback) {
        callback($scope.selections);
      },
      select: function( tstart, tend, jsEvent, view) {
        // console.log(tstart.day());
        var reselect = false;
        if(tstart.day() != 0){
          tstart = tstart.subtract(tstart.day(),"days");
          reselect = true;
        }
        if(tend.day() != 0){
          tend = tend.add(7-tend.day(),"days");
          reselect = true;
        }
        if(reselect){
          $('#calendar_map').fullCalendar( 'select', tstart, tend );
        }
        else{
          console.log('set!');
          $scope.view_start = tstart;
          $scope.view_end   = tend;
          $('#calendar_week').fullCalendar('gotoDate', tstart);
          $('#calendar_map').fullCalendar('prev');
          $('#calendar_map').fullCalendar('next');
        }
      }
    });
    $scope.selections=[];

    update_edit_bounds = function(event){
      if(!$scope.edit_bounds[0]){
        $scope.edit_bounds[0] = event.start;
      }else{
        if($scope.edit_bounds[0]>event.start){
          $scope.edit_bounds[0]=event.start;
        }
      }
      if(!$scope.edit_bounds[1]){
        $scope.edit_bounds[1] = event.end;
      }else{
        if($scope.edit_bounds[1]<event.end){
          $scope.edit_bounds[1]=event.end;
        }
      }
      console.log('bounds: '+$scope.edit_bounds);
    }
    remove_event = function(event){
      update_edit_bounds(event);
      console.log('remove event');
      for(var i=0;i<$scope.selections.length;i++){
        // console.log(event.id);
        // console.log($scope.selections[i].id);
        if($scope.selections[i].id==event.id){
          $scope.selections.splice(i,1);
        }
      }
    }
    add_event = function(tstart, tend, jsEvent, view){
      evt = ({
        title  : 'open',
        start  : tstart,
        end    : tend,
        id     : tstart+tend
      });
      valid = true;
      merge = [undefined];
      $.each($scope.selections,(function(ix,el){
        // console.log(evt.start+", "+evt.end+" | "+el.start+", "+el.end);
        if((evt.start-el.end == 0) || (evt.end-el.start == 0)){
          merge = el;
          console.log('merge');
        }
        if(evt.start < el.start && evt.end > el.start){
          valid=false;
          console.log('1');
        }
        if(evt.start < el.end   && evt.end > el.end  ){
          valid=false;
          console.log(JSON.stringify(evt)+' conflicts with '+JSON.stringify(el));
        }
        if(evt.start > el.start && evt.end < el.end  ){
          valid=false;
          console.log('3');
        }
      }));
      if(valid){
        $('#popup_appt_create').css('visibility', 'visible');
        $('#popup_appt_create').css('left', Math.max(Math.min(jsEvent.pageX - 200,$(window).width()-400),0));
        $('#popup_appt_create').css('top' , jsEvent.pageY - 240);
        $('#popup_appt_create').css('z-index' , 10);
        $('#popup_appt_create input[type=text]').focus();
        $('#popup_appt_create input[name=cancel]').click(function(event){
          $('#popup_appt_create').css('visibility', 'hidden');
          $('#popup_appt_create form').unbind('submit');
        });
        $('#popup_appt_create form').unbind('submit').submit(function(event){
          $('#popup_appt_create').css('visibility', 'hidden');
          evt.price=$('#popup_appt_create input[type=text]').val();
          evt.currency=$('#popup_appt_create select').val();

          if(merge && merge.price == evt.price && merge.currency == evt.currency){
            if(evt.end-merge.start == 0){
              merge.start = evt.start;
            }
            if(evt.start-merge.end == 0){
              merge.end = evt.end;
            }
          }
          else{
            evt.title = evt.price+" "+evt.currency;
            $scope.selections.push(evt);
          }

          update_edit_bounds(evt);
          refresh_calendar();
          return false;
        });
      }
    }
    refresh_calendar = function(){
      $('#calendar_week').fullCalendar('prev');
      $('#calendar_week').fullCalendar('next');
      $('#calendar_map').fullCalendar('prev');
      $('#calendar_map').fullCalendar('next');
    }
    $('#calendar_week').fullCalendar({
      defaultView: 'agendaWeek',
      contentHeight: 700,
      selectable:true,
      slotDuration:'01:00:00',
      businessHours:true,
      timezone:'local',
      select: function( tstart, tend, jsEvent, view ) {
        add_event(tstart, tend, jsEvent, view);
      },
      events: function(start, end, timezone, callback) {
        callback($scope.selections);
      },
      eventClick: function(calEvent, jsEvent, view) {
        remove_event(calEvent);
        refresh_calendar();
      },
      editable: true,
      eventOverlap: false
    });
  }
  $scope.selected_as_payload = function(times){
    if(!$scope.edit_bounds[0] || !$scope.edit_bounds[0])return undefined;
    var payload =
    { data: times.map(function(elt){
          var load = {
            s: elt.start.utcOffset(0).format('YYYY-MM-DD HH:mm'),
            e: elt.end.utcOffset(0).format('YYYY-MM-DD HH:mm'),
            t: 'open',
            p: elt.price,
            c: elt.currency
          };
          return load;
        }),
      bounds: [
        $scope.edit_bounds[0].utcOffset(0).format('YYYY-MM-DD HH:mm'),
        $scope.edit_bounds[1].utcOffset(0).format('YYYY-MM-DD HH:mm')
      ]
    };
    return payload;
  }
  $scope.set_availabilities = function(times){
    var payload = $scope.selected_as_payload(times);
    if(!payload)return;
    $http({
      method: 'POST',
      url: '../ajax/set_doctor_availabilities.php',
      data: payload,
      transformResponse: undefined
    }).then(function successCallback(response) {
      $scope.get_schedule('doctor');
      // console.log('Response: ');
      // alert(JSON.stringify(response));
      // console.log(response);
    }, function errorCallback(response) {
      $scope.get_schedule('doctor');
      // console.log('Response: ');
      // alert(JSON.stringify(response));
      // console.log(response);
    });
  }
  $scope.set_view = function(new_view){
    if($scope.is_show('appts.edit') && !new_view.startsWith('appts.edit')){
      console.log('saving edits');
      $scope.set_availabilities($scope.selections);
    }
    if(new_view.startsWith('appts.edit')){
      refresh_calendar();
    }
    if(new_view.startsWith('appts.display')){
      $('#calendar').fullCalendar( 'refetchEvents' );
      $('#calendar').fullCalendar('prev');
      $('#calendar').fullCalendar('next');
      console.log('reeeefresh');
    }
    console.log(new_view);
    $scope.view = new_view;
  }
  $scope.get_schedule = function(show){
    var ajax = new XMLHttpRequest();
    $.ajaxSetup({ cache: false });
    ajax.open("GET", "../ajax/get_schedule.php?show="+show+"&rand="+Math.random(), true);
    ajax.onload = function() {
      console.log('ajax 1');
      // console.log(ajax.responseText);
      $scope.$apply(function(){
      console.log('ajax 2');
        console.log('response: ');
        // console.log(ajax.responseText);
        $scope.schedule=JSON.parse(ajax.responseText).sched;
        $scope.selections   = [];
        $scope.appointments = [];
        for(var i=0; i<$scope.schedule.length; ++i){
          $scope.schedule[i].date_start = moment.utc($scope.schedule[i].start.split(/-|\ |:/), 'YYYY-MM-DD HH:mm:ss');
          $scope.schedule[i].date_end = moment.utc($scope.schedule[i].end.split(/-|\ |:/), 'YYYY-MM-DD HH:mm:ss');
          cal_evt = {
            title    : $scope.schedule[i].price+" "+$scope.schedule[i].currency,
            start    : $scope.schedule[i].date_start,
            end      : $scope.schedule[i].date_end,
            id       : i,
            price    : $scope.schedule[i].price,
            currency : $scope.schedule[i].currency
          };
          $scope.selections.push(cal_evt);
          if($scope.schedule[i].type != 'open'){
            $scope.appointments.push($scope.schedule[i]);
          }
          // console.log($scope.schedule[i].date_start);
        }
        refresh_calendar();
        $('#calendar').fullCalendar('prev');
        $('#calendar').fullCalendar('next');
      });
    };
    ajax.send();
  }
});