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
    formatPhoneNumber: function(input, formatMask)
    {
        // Strip non-numeric characters
        var digits = input.replace(/\D/g, '');
        // Replace each "X" with the next digit
        var count = 0;
        return formatMask.replace(/X/g, function() {
            return digits.charAt(count++);
        });
    },
    equalheight: function(container){
      /* Thanks to CSS Tricks for pointing out this bit of jQuery
      https://css-tricks.com/equal-height-blocks-in-rows/
      It's been modified into a function called at page load and then each time
      the page is resized. One large modification was to remove the set height
      before each new calculation. */
      let self = this;
      let currentTallest = 0
      let currentRowStart = 0
      let rowDivs = []
      let elem
      let topPosition = 0

      $(container).each(function() {
        elem = $(this);
        // console.log(elem);
        elem.height('auto');
        topPosition = elem.position().top;
        // console.log(rowDivs);
        if (currentRowStart != topPosition) {
          for (let currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest);
          }
          rowDivs.length = 0; // empty the array
          currentRowStart = topPosition;
          currentTallest = elem.height();
          rowDivs.push(elem);
        } else {
          rowDivs.push(elem);
          currentTallest = (currentTallest < elem.height()) ? (elem.height()) : (currentTallest);
        }
        console.log(currentTallest)
        for (let currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
         rowDivs[currentDiv].height(currentTallest);
        }
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