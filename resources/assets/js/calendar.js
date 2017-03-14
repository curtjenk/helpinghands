/**
 * This namespace includes tools related to users for the application
 * @namespace
 */
export const calendar = calendar || {};


/**
 * Initialization of events.
 */
// $(function() {
 $.getScript('http://arshaw.com/js/fullcalendar-1.6.4/fullcalendar/fullcalendar.min.js',function(){

  var eventdates = JSON.parse($('input[name="eventdates"]').val());

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  var header = {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
    };
  var editable = true;
  var events = [];
  eventdates.forEach(function(d) {
      events.push({'title': d.subject,
      'url' : '/ticket/'+d.id, 
      'start' : d.date_start,
      'end' : d.date_end});
  });

  $('#calendar').fullCalendar({
    header: header,
    editable: editable,
    events: events
  });
})
// }
//
/*
events: [
     {
       title: 'All Day Event',
       start: new Date(y, m, 1)
     },
     {
       title: 'Long Event',
       start: new Date(y, m, d-5),
       end: new Date(y, m, d-2)
     },
     {
       id: 999,
       title: 'Repeating Event',
       start: new Date(y, m, d-3, 16, 0),
       allDay: false
     },
     {
       id: 999,
       title: 'Repeating Event',
       start: new Date(y, m, d+4, 16, 0),
       allDay: false
     },
     {
       title: 'Meeting',
       start: new Date(y, m, d, 10, 30),
       allDay: false
     },
     {
       title: 'Lunch',
       start: new Date(y, m, d, 12, 0),
       end: new Date(y, m, d, 14, 0),
       allDay: false
     },
     {
       title: 'Birthday Party',
       start: new Date(y, m, d+1, 19, 0),
       end: new Date(y, m, d+1, 22, 30),
       allDay: false
     },
     {
       title: 'Click for Google',
       start: new Date(y, m, 28),
       end: new Date(y, m, 29),
       url: 'http://google.com/'
     }
   ]

 */