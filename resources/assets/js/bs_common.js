
/**
 * This namespace contains common bootstrap stuff
 * @namespace
 */
export const bs_common = bs_common || {};

$(function() {
  $("[name='opt_receive_evite']").bootstrapSwitch();
  $("[name='opt_show_homephone']").bootstrapSwitch();
  $("[name='opt_show_mobilephone']").bootstrapSwitch();

  $("[name='switcher']").bootstrapSwitch();
  $("[data-toggle='tooltip']").tooltip({container: 'body'});
})