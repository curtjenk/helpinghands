/**
 * This namespace includes tools related to users for the application
 * @namespace
 */
export const events = events || {};

// import { common } from './common';
// import { notification } from './notification';

events.preview_image = function(event)
{
 var total_file=$("#event_file")[0].files.length;
 $('#image_preview').html("");
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append('<div class="img-preview col-sm-1">'
    + "<img class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'>"
    + '</div>');
 }
}

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
  $('#event_file').on('change', function(event) {

    events.preview_image(event);
  });
});
