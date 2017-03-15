/**
 * This namespace includes tools related to users for the application
 * @namespace
 */
export const user = user || {};

/**
 * Initialization of events.
 */
$(function() {
  $('#deleteOrganization').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    $('#deleteOrganization h4').text('Delete ' + button.data('name'));
    $('#deleteOrganization form').attr('action', 'organization/' + button.data('id'));
  });
});
