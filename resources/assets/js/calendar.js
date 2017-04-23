/**
 * This namespace includes tools related to users for the application
 * @namespace
 */
export const calendar = calendar || {};


/**
 * Initialization of events.
 */

 /**
  * Initialization of events.
  */
 $(function() {
    //  console.log($('input[name="eventdates"]').val());
     if ($('input[name="eventdates"]').length) {
         var eventdates = JSON.parse($('input[name="eventdates"]').val());
         var header = {
           left: 'prev,next today',
           center: 'title',
           right: 'month,agendaWeek,agendaDay'
           };
         var editable = true;
         var events = [];
         eventdates.forEach(function(d) {
             events.push({'title': d.subject,
             'url' : '/event/'+d.id,
             'start' : d.date_start,
             'end' : d.date_end});
         });

         $('#calendar').fullCalendar({
           header: header,
           editable: editable,
           events: events
         });
    }
 });