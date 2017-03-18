
/**
 * This namespace
 * @namespace
 */
export const bswitch = bswitch || {};

$(function() {
    $("[name='opt_receive_evite']").bootstrapSwitch();
    $("[name='opt_show_homephone']").bootstrapSwitch();
    $("[name='opt_show_mobilephone']").bootstrapSwitch();
})
