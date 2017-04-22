/**
 * This namespace includes tools / common routines
 * @namespace
 */
export const common = common || {};


/**
 * Initialization of events.
 */

 /**
  * Initialization of events.
  */
 $(function() {

 });
 /**
  * truncate a string and add ellipsis
  */
 String.prototype.ellipsis =
      function(n){
          return this.substr(0,n-1)+(this.length>n?'&hellip;':'');
      };