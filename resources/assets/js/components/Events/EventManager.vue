<template>
  <div>
    <div class="row">
      <div class="col-md-offset-2 col-sm-offset-2 text-center">
        <div class="alert alert-danger" v-if="statusFailed" transition="expand">
            <p><strong>Sorry, unable to {{ mode0 }} event</strong></p>
            <div v-for="msg in errors">
                {{ msg }}
            </div>
        </div>
      </div>
    </div>
    <form-wizard class="row"
      @on-complete="wizardOnComplete"
      color="#e67e22"
      title=""
      subtitle=""
      finishButtonText="Save Event"
    >

      <tab-content title="Organization/Team">
        <div class="mytab">
          <p class="text-center">
            <strong>Use the dropdowns to select the Organization and Team as applicable</strong>
          </p>
          <filter-memberships class="text-center"
              :userid="user0.id"
              :filterByTeam="true"
              @orgTeamSelected="setOrgTeam"
          ></filter-memberships>
        </div>
      </tab-content>


      <tab-content title="Details">
        <div class="mytab">
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
                <div class="form-group">
                  <label for="eventtype" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Type</label>
                  <div class="col-md-7">
                      <p id="eventtype" class="form-control-static">{{ event.type.name }}></p>
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
                <div class="form-group">
                  <label for="eventtype" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Type</label>
                  <div class="col-md-7">
                    <select v-model="event.type" name="type">
                      <option disabled value="">Select one</option>
                      <option v-for="etype in eventtypes0" v-bind:value="etype">
                        {{ etype.name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="cost" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Cost</label>
                  <div class="col-md-7">
                    <input name="cost" v-model="event.cost" type="text" class="" size="5">
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
                  <label for="limit" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Limit</label>
                  <div class="col-md-7">
                    <p id="limit" class="form-control-static">{{ event.limit }}></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="status" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Status</label>
                  <div class="col-md-7">
                    <p id="status" class="form-control-static">{{ event.status.name }}></p>
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
                  <label for="limit" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Limit</label>
                  <div class="col-md-9">
                    <input name="limit" v-model="event.limit" type="text" class="" size="3">
                  </div>
                </div>
                <div class="form-group">
                  <label for="status" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Status</label>
                  <div class="col-md-9">
                    <select v-model="event.status" name="status">
                      <option disabled value="">Select one</option>
                      <option v-for="stat in statuses0" v-bind:value="stat" >
                        {{ stat.name }}
                     </option>
                    </select>
                  </div>
                </div>
              </span>
            </div>
          </div>
        </div>
        </div>
      </tab-content>


      <tab-content title="Description">
        <div class="mytab">
          <quill-editor v-model="event.description"
                ref="myQuillEditor"
                :options="editorOption"
                @change="onEditorChange($event)"
                @blur="onEditorBlur($event)"
                @focus="onEditorFocus($event)"
                @ready="onEditorReady($event)">
          </quill-editor>
        </div>
      </tab-content>


      <tab-content title="Attachments">
         Yuhuuu! This seems pretty simple
        <div class="mytab">
        </div>
      </tab-content>

    </form-wizard>
  </div>
</template>

<script>

import {commonMixins} from '../../mixins/common';
import {MESSAGE_DURATION} from '../../mixins/constants';
// import FormError from '../FormError';
import {FormWizard, TabContent} from 'vue-form-wizard';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
import Datepicker from 'vuejs-datepicker';
import VueTimepicker from 'vue2-timepicker';
// quill require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'

export default {
  mixins: [commonMixins],
  components: {
    // FormError,
    FormWizard, TabContent, Datepicker, VueTimepicker, quillEditor
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
    event0: {
      type: Object,
      required: false
    }
  },
  data () {
    return {
      //use event.description instead of editorContent
      editorContent: '',
      editorOption: {
        // some quill options
      },
      ready: false,
      errors: [],
      orgid: '',
      teamid: '',
      selEventType: {},
      event: {
        subject:'',
        description: '',
        description_text: '',
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
      // this.equalheight('.mytab'); //call mixin to set equalheight tabs
    })
  },
  updated: function() {
    // console.log('dom updated')
  },
  computed: {
    editor() {
       return this.$refs.myQuillEditor.quill
    }
  },
  watch: {
  },
  methods: {
    onEditorBlur(quill) {
      // console.log('editor blur!', quill)
    },
    onEditorFocus(quill) {
      // console.log('editor focus!', quill)
    },
    onEditorReady(quill) {
      // console.log('editor ready!', quill)
    },
    onEditorChange({ quill, html, text }) {
      // console.log('editor change!', quill, html, text)
      // this.editorContent = html
      console.log(text)
      this.event.description_text = text;
    },
    setInitialEndTime: function(timePicker) {
      // console.log(timePicker)
      this.event.time_start.hh = timePicker.data.hh
      this.event.time_start.mm = timePicker.data.mm
      this.event.time_start.a = timePicker.data.a
      this.event.time_end = this.event.time_start

    },
    wizardOnComplete: function() {
      // alert('Yay. Done!')
      this.errors = [];
      axios({
        method: 'post',
        url: '/api/event',
        data: {
          auth_user_id: this.user0.id,
          organization_id: this.orgid,
          team_id: this.teamid,
          event: this.event
        }
      })
      .then(  (response) => {
        window.location.href = "/event";
      }).catch((error) => {
        this.setStatusFailed();
        if (error.response.status == 422) {
          let messages = error.response.data.errors;
          // console.log(messages)
          let self = this;
          $.each(messages, function(k,v){
            for(let i=0;i<v.length;i++){
              //console.log(v[i])
              self.errors.push(v[i]);
            }
          });
        }
        var self = this;
        setTimeout(function(){
            self.setStatusInitial();
        }, MESSAGE_DURATION + 1000);
      });
    },
    setOrgTeam: function(orgid, teamid) {
      this.orgid = orgid
      this.teamid = teamid
    }
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
.instruction {
  font-size: 16px;
}
.mytab {
  min-height: 200px;
}
</style>
