/**
 * This namespace includes tools related to users for the application
 * @namespace
 */
export const event = event || {};

// import { common } from './common';
// import { notification } from './notification';

/**
 * Initialization of events.
 */
$(function() {
  $( "#dateEventStartPicker" ).datepicker();
  $( "#dateEventEndPicker" ).datepicker();

  $('#deleteTicket').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    $('#deleteTicket h4').text('Delete ' + button.data('name'));
    $('#deleteTicket form').attr('action', 'event/' + button.data('id'));
  });
});
