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
          <!-- <div class="row">
            <span v-if="modeShow">
              <div class="form-group">
                <label for="subject" class="col-md-3 col-sm-3 control-label">Subject</label>
                <div class="col-md-9">
                    <p id="subject" type="text" class="form-control-static">{{ event.subject }}></p>
                </div>
              </div>
            </span>
            <span v-else>
              <div class="pull-left">
                <label for="subject" class="col-md-2 control-label">Subject</label>
                <div class="col-md-9">
                    <input required name="subject" v-model="event.subject" type="text" class="" size="70" autofocus>
                </div>
              </div>
            </span>
          </div> -->
          <div class="row">


          </div>
        </div>
      </tab-content>
      <tab-content title="Description">
          My second tab content
      </tab-content>
      <tab-content title="Attachments">
         Yuhuuu! This seems pretty damn simple
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
      required: false
    }
  },
  data () {
    return {
      ready: false,
      errors: {},
      orgid: '',
      teamid: '',
      user: {},
      event: {
        subject:'',
        description:'',
        date_start:'',
        date_end:'',
        time_start: {hh: "08", mm: "00"},
        time_end: {hh: "08", mm: "00"},
        cost:'',
        type:'',
        signup_limit:'',
        status:''
      }
    }
  },
  mounted: function () {
    this.user = this.user0
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