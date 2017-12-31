/**
 * This namespace includes tools / common routines
 * @namespace
 */
import * as consts from './constants';

export const commonMixins = {
  data() {
    return {
      currentStatus: '',
      currentMode: ''
    }
  },
  methods: {
    setMode: function(modeString) {
      this.currentMode = consts.MODES[modeString]
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

    formatPhoneNumber: function(input, formatMask)
    {
        // Strip non-numeric characters
        var digits = input.replace(/\D/g, '');
        // Replace each "X" with the next digit
        var count = 0;
        return formatMask.replace(/X/g, function() {
            return digits.charAt(count++);
        });
    }
  },
  computed: {
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
    }
  }
};