<template>
  <div>
    <form-wizard
      @on-complete="wizardOnComplete"
      color="#e67e22"
      title=""
      subtitle=""
      finishButtonText="Save Event"
    >
      <tab-content title="Organization/Team">
        <div class="text-center">
          <p>
            Use the dropdowns to select the Organization and Team as applicable
          </p>
          <filter-memberships
              :userid="user0.id"
              :filterByTeam="true"
              @orgTeamSelected="setOrgTeam"
          ></filter-memberships>
        </div>
      </tab-content>
      <tab-content title="Details">
        <div class="form-horizontal">
          <div class="row">
            <div class="col-md-5 col-sm-5">
              <span v-if="modeShow">
                <div class="form-group">
                  <label for="subject" class="col-md-3 col-sm-3 control-label">Subject</label>
                  <div class="col-md-9">
                      <p id="subject" type="text" class="form-control-static">{{ event.subject }}></p>
                  </div>
                </div>
              </span>
              <span v-else>
                <div class="form-group">
                  <label for="subject" class="col-md-3 col-sm-3 control-label">Subject</label>
                  <div class="col-md-9 col-sm-9">
                      <input required name="subject" v-model="event.subject" type="text" class="" size="50" autofocus>
                  </div>
                </div>
              </span>
            </div>
            <div class="col-md-7 col-sm-7">
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5">
              <span v-if="modeShow">
                <div class="form-group">
                  <label for="datestart" class="col-md-3 col-sm-3 control-label">Start Date</label>
                  <div class="col-md-7 col-sm-7">
                      <p id="datestart" class="form-control-static">{{ event.date_start }}></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="dateend" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;End Date</label>
                  <div class="col-md-7 col-sm-7">
                      <p id="dateend" class="form-control-static">{{ event.date_end }}></p>
                  </div>
                </div>
              </span>
              <span v-else>
                <div class="form-group">
                  <label for="datestart" class="col-md-3 col-sm-3 control-label">Start Date</label>
                  <div class="col-md-7 col-sm-7">
                      <datepicker name="datestart" v-model="event.date_start"></datepicker>
                  </div>
                </div>
                <div class="form-group">
                  <label for="dateend" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;End Date</label>
                  <div class="col-md-7 col-sm-7">
                      <datepicker name="dateend" v-model="event.date_end"></datepicker>
                  </div>
                </div>
              </span>
            </div>
            <div class="col-md-6 col-sm-6">
              <span v-if="modeShow">
                <div class="form-group">
                  <label for="timestart" class="col-md-3 col-sm-3 control-label">Start Time</label>
                  <div class="col-md-9">
                      <p id="timestart" type="text" class="form-control-static">{{ event.time_start }}></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="timeend" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;End Time</label>
                  <div class="col-md-9">
                      <p id="timeend" type="text" class="form-control-static">{{ event.time_end }}></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="eventtype" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Type</label>
                  <div class="col-md-9">
                      <p id="eventtype" type="text" class="form-control-static">{{ event.type }}></p>
                  </div>
                </div>
              </span>
              <span v-else>
                <div class="form-group">
                  <label for="timestart" class="col-md-3 col-sm-3 control-label">Start Time</label>
                  <div class="col-md-9">
                      <vue-timepicker name="timestart"
                        v-model="event.time_start"
                        :time-value.sync="event.time_start"
                        format="hh:mm a"
                        :minute-interval="15"
                        @change="setInitialEndTime"
                      />
                  </div>
                </div>
                <div class="form-group">
                  <label for="timeend" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;End Time</label>
                  <div class="col-md-9">
                      <vue-timepicker name="timeend"
                        v-model="event.time_end"
                        :time-value.sync="event.time_end"
                        format="hh:mm a"
                        :minute-interval="15"
                      />
                  </div>
                </div>
                <div class="form-group">
                  <label for="eventtype" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Type</label>
                  <div class="col-md-9">
                    <select v-model="selEventType">
                      <option v-for="etype in eventtypes0" v-bind:value="etype">
                        {{ etype.name }}
                     </option>
                    </select>
                  </div>
                </div>
              </span>
            </div>

          </div>
        </div>
      </tab-content>
      <tab-content title="Description">
          My second tab content
      </tab-content>
      <tab-content title="Attachments">
         Yuhuuu! This seems pretty simple
      </tab-content>
    </form-wizard>
  </div>
</template>

<script>

import {commonMixins} from '../../mixins/common';
import {MESSAGE_DURATION} from '../../mixins/constants';
import FormError from '../FormError';
import {FormWizard, TabContent} from 'vue-form-wizard';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
import Datepicker from 'vuejs-datepicker';
import VueTimepicker from 'vue2-timepicker';

export default {
  mixins: [commonMixins],
  components: {
    FormError, FormWizard, TabContent, Datepicker, VueTimepicker
  },
  props: {
    mode0: {
      type: String,
      required: true
    },
    user0: {
      type: Object,
      required: true
    },
    eventtypes0: {
      type: Array,
      required: true
    },
    statuses0: {
      type: Array,
      required: true
    },
    eventtypes0: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      ready: false,
      errors: {},
      orgid: '',
      teamid: '',
      selEventType: {},
      event: {
        subject:'',
        description:'',
        date_start:'',
        date_end:'',
        time_start: {hh: "08", mm: "00", a: "am"},
        time_end: {hh: "08", mm: "00", a: "am"},
        cost:'',
        type:'',
        signup_limit:'',
        status:''
      }
    }
  },
  mounted: function () {
    this.setMode(this.mode0);
    this.$nextTick(function () {  // Code that will run only after the entire view has been rendered
      this.ready = true;
    })
  },
  updated: function() {
    // console.log('dom updated')
  },
  computed: {

  },
  watch: {
  },
  methods: {
    setInitialEndTime: function(timePicker) {
      // console.log(timePicker)
      this.event.time_start.hh = timePicker.data.hh
      this.event.time_start.mm = timePicker.data.mm
      this.event.time_start.a = timePicker.data.a
      this.event.time_end = this.event.time_start

    },
    wizardOnComplete: function() {
      alert('Yay. Done!')
    },
    setOrgTeam: function(orgid, teamid) {
      this.orgid = orgid
      this.teamid = teamid
    }
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
/* reduce column padding from 15 to 5px */
/* [class^='col-'], [class*=' col-']{
  padding: 0px 5px 0px 5px;
} */
input[type=text]{
   /* padding:0px; */
   /* margin-bottom:2px;  Reduced from whatever it currently is */
   /* margin-top:2px;  Reduced from whatever it currently is */
}
</style>
