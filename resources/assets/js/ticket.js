/**
 * This namespace includes tools related to users for the application
 * @namespace
 */
export const ticket = ticket || {};

// import { common } from './common';
// import { notification } from './notification';

/**
 * Initialization of events.
 */
$(function() {
  $( "#dateTicketStartPicker" ).datepicker();
  $( "#dateTicketEndPicker" ).datepicker();
  
  $('#deleteTicket').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    $('#deleteTicket h4').text('Delete ' + button.data('name'));
    $('#deleteTicket form').attr('action', 'ticket/' + button.data('id'));
  });
});
