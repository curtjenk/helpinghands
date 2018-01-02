/**
 * This namespace includes tools / common routines
 * @namespace
 */
export const common = common || {};

/**
 * Check if the session is still alive
 */
common.session_check = function() {
  axios({
    method: 'GET',
    url: '/ajax/session'
  }).then( (response) =>{
    // console.log(response);
    let str = response.data;
    if (parseInt(str) < 0) {
      window.location.reload();  //no activity timeout
    } else {
      common.session_timeout_helper();
    }
  }).catch( (error)=> {
    console.log(error.response);
    let status = error.response.status;
    let data = error.response.data;
    if (status == 401) {
      $('#errorModal div.modal-body').html(
          'Your session expired and it will close in 3 seconds.');
      setTimeout(function() {
        window.location.replace('/login');
      }, 3000);
    } else if (status == 403) {
      $('#errorModal div.modal-body').html(
          'You are not authorized. Contact your administrator.');
    } else {
      $('#errorModal div.modal-body').html(data);
    }
    $('#errorModal').modal('show');
  });
};


/**
 * Run setTimeout for session check
 * This function is to have things centralized, like the timeout time.
 */
common.session_timeout_helper = function() {
  setTimeout(function() {
    common.session_check();
  }, 120000);
};

/**
 * Fill-out the text of a tag with the result of converting to local time a UTC
 * time stored in a data attribute (named data-datetime).
 * @param {jQuery} obj - tag with the data-datetime attribute.
 */
common.convert_to_local_time = function(obj) {
  $(obj).html(moment.utc($(obj).data('datetime')).local()
      .format('l LTS'));
};
/**
 * Helper tool which goes over the children that need time convertion.
 * @param {jQuery} obj - tag with the data-datetime attribute.
 */
common.convert_descendants_to_local_time = function(obj) {
  $(obj).find('[data-datetime]').each(function() {
    common.convert_to_local_time(this);
  });
};

// common.change_organization = function(event)
// {
//   let orgid=$('#selected_org_id').val();
//   let url=$('#selected_org_id').parent().attr('data-url');
//   axios.post('/session', {
//       orgid: orgid
//   })
//   .then(function (response) {
//     // console.log(response.data);
//     window.location.href=url;
//   })
//   .catch(function (error) {
//     console.log(error);
//     console.log(error.response);
//     if (error.response.status===401) {
//       window.location.href = 'login';
//     }
//   });
// }
 /**
  * Initialization of events.
  */
 $(function() {
  if (window.location.pathname != '/login') {
    common.session_timeout_helper();
  } else {
    // If I'm on the login screen, refresh frequently to avoid
    // "session timeout" due to token expiration
    setTimeout(() => {
      location.reload();
    }, 14*60000);
  }
     // $('#selected_org_id').on('change', function(event) {
     //   common.change_organization(event);
     // });
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