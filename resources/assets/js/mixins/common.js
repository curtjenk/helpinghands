/**
 * This namespace includes tools / common routines
 * @namespace
 */
import * as consts from './constants';
import moment from 'moment';
export const commonMixins = {
  data() {
    return {
      currentStatus: '',
      currentMode: ''
    }
  },
  methods: {
    hasPermission (perm) {
      return this.permissions.includes(perm)
    },
    isObjectEmpty: function(obj) {
      if (obj === undefined || obj === null) {
        return true;
      }
      return Object.keys(obj).length === 0 && obj.constructor === Object
    },
    setMode: function(modeString) {
      this.currentMode = consts.MODES[modeString.toLowerCase()]
    },
    setModeCreate: function() {
      this.currentMode = consts.MODE_CREATE
    },
    setModeEdit: function() {
      this.currentMode = consts.MODE_EDIT
    },
    setModeShow: function() {
      this.currentMode = consts.MODE_SHOW
    },
    setStatus: function(statusString) {
      this.currentStatus = consts.STATUS[statusString]
    },
    setStatusInitial: function() {
      this.currentStatus = consts.STATUS_INITIAL;
    },
    setStatusInProgress: function() {
      this.currentStatus = consts.STATUS_INPROGRESS;
    },
    setStatusFailed: function() {
      this.currentStatus = consts.STATUS_FAILED;
    },
    setStatusSuccess: function() {
      this.currentStatus = consts.STATUS_SUCCESS;
    },
    setStatusSaving: function() {
      this.currentStatus = consts.STATUS_SAVING;
    },
    goToLocation(url) {
      window.location.href = url;
    },
    formatPhoneNumber: function(input, formatMask)
    {
      if (input == null) {
        return ''
      }
        // Strip non-numeric characters
      var digits = input.replace(/\D/g, '');
      // Replace each "X" with the next digit
      var count = 0;
      return formatMask.replace(/X/g, function() {
          return digits.charAt(count++);
      });
    },
    formatDate: function(input, formatMask = 'MM/DD/YYYY h:mm:ss a') {
      // console.log( moment(input).format(formatMask));
      return (input==null) ? '' : moment(input).format(formatMask);
    },
  },
  computed: {
    user () {
      return this.$store.getters.user;
    },
    roles () {
      return this.$store.getters.roles;
    },
    permissions () {
      return this.$store.getters.permissions;
    },
    statusInitial() {
      return this.currentStatus === consts.STATUS_INITIAL;
    },
    statusSuccess() {
      return this.currentStatus === consts.STATUS_SUCCESS;
    },
    statusFailed() {
      return this.currentStatus === consts.STATUS_FAILED;
    },
    statusInProgress() {
      return this.currentStatus === consts.STATUS_INPROGRESS;
    },
    modeEdit() {
      return this.currentMode == consts.MODE_EDIT;
    },
    modeShow() {
        return this.currentMode == consts.MODE_SHOW;
    },
    modeCreate() {
        return this.currentMode == consts.MODE_CREATE;
    },
    canAdminister() {
      return this.roles ? this.roles.includes('Site')||
                          this.roles.includes('Admin')||
                          this.roles.includes('Lead')
                        : false;
    },
    canListEvents() {
      return this.permissions ? this.permissions.includes('List events') : false;
    },
    canListMembers() {
      return this.permissions ? this.permissions.includes('List users') : false;
    },
    canCreateEvent() {
      return this.permissions ? this.permissions.includes('Create Event') : false;
    },
    isSuperUser() {
      return this.roles ? this.roles.includes('Site') : false;
    },
    isVisitor() {
      return this.roles ? this.roles.includes('Visitor') && this.roles.length===1 : false;
    }
  }
};