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

  $('#deleteevent').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    $('#deleteevent h4').text('Delete ' + button.data('name'));
    $('#deleteevent form').attr('action', 'event/' + button.data('id'));
  });
  $('#eventnotify').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    $('#eventnotify h4').text('Send notification ');
    $('#eventnotify form').attr('action', 'event/notify/' + button.data('id'));
  });
  $('#eventevite').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    $('#eventevite h4').text('Send evites ');
    $('#eventevite form').attr('action', 'evite' + button.data('id'));
  });
});
