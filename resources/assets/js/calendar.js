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
      events.push({'title': d.subject, 'start' : d.date_start, 'end' : d.date_end});
  });

  $('#calendar').fullCalendar({
    header: header,
    editable: editable,
    events: events
  });
})
// }