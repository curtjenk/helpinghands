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
});
