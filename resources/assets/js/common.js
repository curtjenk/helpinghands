/**
 * This namespace includes tools / common routines
 * @namespace
 */
export const common = common || {};


common.change_organization = function(event)
{
  let orgid=$('#selected_org_id').val();
  let url=$('#selected_org_id').parent().attr('data-url');
  axios.post('/session', {
      orgid: orgid
  })
  .then(function (response) {
    // console.log(response.data);
    window.location.href=url;
  })
  .catch(function (error) {
    console.log(error);
  });
}
 /**
  * Initialization of events.
  */
 $(function() {
     $('#selected_org_id').on('change', function(event) {
       common.change_organization(event);
     });
 });
 /**
  * truncate a string and add ellipsis ... html compatible
  */
String.prototype.ellipsis =
  function(n){
      return this.substr(0,n-1)+(this.length>n?'&hellip;':'');
  };
/**
* truncate a string and add ellipsis ... text version
*/
String.prototype.ellipsisText =
  function(n){
     return this.substr(0,n-1)+(this.length>n?'...':'');
  };