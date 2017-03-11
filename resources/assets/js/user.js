/**
 * This namespace includes tools related to users for the application
 * @namespace
 */
export const user = user || {};

// import { common } from './common';
// import { notification } from './notification';

/**
 * Initialization of events.
 */
$(function() {
  $('#deleteUser').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    $('#deleteUser h4').text('Delete ' + button.data('name'));
    $('#deleteUser form').attr('action', 'user/' + button.data('id'));
  });
});
