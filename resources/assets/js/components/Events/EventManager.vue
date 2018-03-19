<template>
  <div>
  <!-- :links="[{perm:'Create event', href:'/event/create', name:'Create Event', icon:'fa-plus'}]" -->
    <nav-top-2
        :title="navTitle"
        :links="navLinks"
    ></nav-top-2>

    <div class="row">
      <div class="col-md-offset-2 col-sm-offset-2 text-center">
        <div class="alert alert-danger" v-if="statusFailed" transition="expand">
            <p><strong>error_message</strong></p>
            <div v-for="msg in errors">
                {{ msg }}
            </div>
        </div>
      </div>
    </div>
    <b-card no-body>
      <b-tabs pills card v-model="tabIndex" ref="mytabs">
        <b-tab title="Let's Start">
          <b-row :no-gutters="true">
            <span v-if="modeShow">
              <div class="form-group row mb-2">
                <label for="orgteam" class="col-md-2 col-sm-2 control-label">Organization</label>
                <div class="col-md-9">
                    <p id="orgteam" type="text" class="form-control-static">{{ formatOrgTeam() }}</p>
                </div>
              </div>
              <div class="form-group row">
                <label for="subject" class="col-md-2 col-sm-2 control-label">Subject</label>
                <div class="col-md-9">
                    <p id="subject" type="text" class="form-control-static">{{ event.subject }}</p>
                </div>
              </div>
            </span>
            <span v-else>
              <div class="form-group row mb-3">
                <filter-memberships
                    :userid="user0.id"
                    :filterByTeam="true"
                    :organization="organization"
                    :team="team"
                    @org-team-selected="setOrgTeam"
                ></filter-memberships>
              </div>
              <div class="form-group row">
                <label for="subject" class="">Subject</label>
                <div class="ml-1">
                    <input required name="subject" class="" v-model="event.subject" type="text" size="70" autofocus>
                </div>
              </div>
            </span>
          </b-row>
          <!-- <b-row :no-gutters="true">
            <span v-if="modeShow">

            </span>
            <span v-else>

            </span>
          </b-row> -->
        </b-tab>
        <b-tab title="Date/Time">
          <div class="row no-gutters">
            <b-col>
              <span v-if="modeShow">
                <div class="form-group row">
                  <label for="datestart" class="col-md-3 col-sm-3 control-label">Start Date</label>
                  <div class="col-md-7 col-sm-7">
                      <p id="datestart" class="form-control-static">{{ formatDate(event.date_start, 'YYYY-MM-DD') }}</p>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="dateend" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;End Date</label>
                  <div class="col-md-7 col-sm-7">
                      <p id="dateend" class="form-control-static">{{formatDate(event.date_end, 'YYYY-MM-DD')}}</p>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="eventtype" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Type</label>
                  <div class="col-md-7">
                      <p id="eventtype" class="form-control-static">{{ eventTypeName }}</p>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="status" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Status</label>
                  <div class="col-md-7">
                    <p id="status" class="form-control-static">{{ statusName }}</p>
                  </div>
                </div>
              </span>
              <span v-else style="width: 100%;">
                <div class="form-group row no-gutters">
                  <label for="pdatestart" class="col-md-3 col-sm-3">Start Date</label>
                  <div class="col-sm-5">
                    <datepicker name="pdatestart"
                      :bootstrap-styling="true"
                      :value="formatDate(event.date_start)"
                      @selected=" d => {event.date_end = d; event.date_start = d;} " format="yyyy-MM-dd">
                    </datepicker>
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="pdateend" class="col-md-3 col-sm-3">End Date</label>
                  <div class="col-sm-5">
                    <datepicker name="pdateend"
                      :bootstrap-styling="true"
                      :value="formatDate(event.date_start)"
                      @selected=" d => {event.date_end = d;} " format="yyyy-MM-dd">
                    </datepicker>
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="eventtype" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Type</label>
                  <div class="col-sm-7">
                    <select v-model="event.event_type_id" name="type">
                      <option disabled value="">Select one</option>
                      <option v-for="etype in eventtypes0" v-bind:key="etype.id" v-bind:value="etype.id">
                        {{ etype.name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="status" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Status</label>
                  <div class="col-md-9">
                    <select v-model="event.status_id" name="status">
                      <option disabled value="">Select one</option>
                      <option v-for="stat in statuses0" v-bind:key="stat.id" v-bind:value="stat.id" >
                        {{ stat.name }}
                     </option>
                    </select>
                  </div>
                </div>
              </span>
            </b-col>
            <b-col>
              <span v-if="modeShow">
                <div class="form-group row no-gutters">
                  <label for="timestart" class="col-md-3 col-sm-3 control-label">Start Time</label>
                  <div class="col-md-9">
                      <p id="timestart" type="text" class="form-control-static">{{ formatTimePicker(event.time_start) }}</p>
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="timeend" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;End Time</label>
                  <div class="col-md-9">
                      <p id="timeend" type="text" class="form-control-static">{{ formatTimePicker(event.time_end) }}</p>
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="cost" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Cost</label>
                  <div class="col-md-7">
                      <p id="cost" class="form-control-static">{{ event.cost }}</p>
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="limit" class="col-md-3 col-sm-3 control-label">&nbsp;&nbsp;Limit</label>
                  <div class="col-md-7">
                    <p id="limit" class="form-control-static">{{ event.signup_limit }}</p>
                  </div>
                </div>
              </span>
              <span v-else>
                <div class="form-group row no-gutters">
                  <label for="timestart" class="col-md-3 col-sm-3 control-label">Start Time</label>
                  <div class="col-md-9">
                      <vue-timepicker name="timestart"
                        v-model="event.time_start"
                        format="hh:mm a"
                        :minute-interval="15"
                        @change="setInitialEndTime"
                      />
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="timeend" class="col-md-3 col-sm-3 control-label">End Time</label>
                  <div class="col-md-9">
                      <vue-timepicker name="timeend"
                        v-model="event.time_end"
                        format="hh:mm a"
                        :minute-interval="15"
                      />
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="cost" class="col-md-3 col-sm-3 control-label">Cost</label>
                  <div class="col-md-4">
                    <masked-input name="cost" type="text" size="10" width="10"
                        v-model="event.cost"
                        :mask="numberMask">
                    </masked-input>
                  </div>
                </div>
                <div class="form-group row no-gutters">
                  <label for="limit" class="col-md-3 col-sm-3 control-label">Limit</label>
                  <div class="col-md-4">
                    <masked-input name="limit" type="text" size="3" width="3"
                        v-model="event.signup_limit"
                        :mask="numberMaskLimit">
                    </masked-input>
                  </div>
                </div>
              </span>
            </b-col>
          </div>
        </b-tab>
        <b-tab title="Description">
          <quill-editor v-model="event.description"
                ref="myQuillEditor"
                :options="editorOption"
                @change="onEditorChange($event)"
                @blur="onEditorBlur($event)"
                @focus="onEditorFocus($event)"
                @ready="onEditorReady($event)">
          </quill-editor>
        </b-tab>
        <b-tab title="Attachments">
          <div class="">
              <span v-if="modeShow">
                <!--  -->
              </span>
              <span v-else>
                <div class="">
                  <span>Attachments</span>&nbsp;&nbsp;&nbsp;
                  <span v-if="!isAddingFile" v-tooltip.right="'Add Attachment'">
                    <a  href="#" type="button" class="text-success"
                      @click="toggleIsAddingFile()">
                      <i class="fa fa-plus fa-lg fa-fw text-success"></i>
                    </a>
                  </span>
                  <span v-else v-tooltip.right="'Done Adding'">
                    <a href="#" type="button" class="text-danger"
                      @click="toggleIsAddingFile()">
                      <i class="fa fa-minus fa-lg fa-fw"></i>
                    </a>
                  </span>
                </div>
                <div v-if="isAddingFile" class="card mt-3">
                  <div class="card-body">
                    <div class="form-group row no-gutters ">
                      <!-- <div class="col-md-4 col-sm-4"> -->
                        <input id="ntd" ref="fileInput" type="file" required  @change="processFile($event)"/>
                      <!-- </div> -->
                    </div>
                    <div class="form-group row no-gutters ">
                      <div class="col-md-4 col-sm-5">
                        <float-label>
                          <input id="ntn" v-model="new_file_description" type="text" required
                            class="editInfo" size="60" maxlength="255" placeholder="Description"/>
                        </float-label>
                      </div>
                      <div class="col-md-4">
                        <span v-tooltip.top="'Add'" class="">
                            <a href="#" type="button" class="text-primary"
                              @click="addFileToList()">
                              <i class="fa fa-floppy-o fa-lg fa-fw"></i>
                            </a>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </span>
              <table class="mt-3 table table-responsive table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="file in attachments">
                    <td>
                      {{ file.original_filename }}
                    </td>
                    <td>
                      {{ file.description }}
                    </td>
                    <td>
                      <span v-if="file.id != 0" v-tooltip.left="'View'" class="">
                        <a href="#" type="button" class="text-primary"
                              @click="viewFile(file)">
                          <i class="fa fa-eye fa-fw"></i>
                        </a>
                      </span>
                      <span v-tooltip.right="'Remove'" v-if="!modeShow" class="">
                        <a href="#" type="button" class="text-danger"
                              @click="removeFile(file)">
                          <i class="fa fa-trash-o fa-fw"></i>
                        </a>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
          </div>
        </b-tab>
      </b-tabs>
    </b-card>
    <!-- Control buttons-->
    <div class="text-center">
      <b-button-group class="mt-2">
        <b-btn @click="tabIndex--">Previous</b-btn>
        <span class="ml-2">
          <b-btn v-if="tabIndex < (tabCount - 1)"  @click="tabIndex++">Next</b-btn>
          <b-btn v-if="tabIndex == (tabCount - 1) && !modeShow" @click="wizardOnComplete">Submit</b-btn>
        </span>
      </b-button-group>
      <!-- <br>
      <span class="text-muted">Current Tab: {{tabIndex}}</span> -->
    </div>

  </div>
</template>

<script>
import { commonMixins } from "../../mixins/common";
import { MESSAGE_DURATION } from "../../mixins/constants";
import MaskedInput from "vue-text-mask";
import createNumberMask from "text-mask-addons/dist/createNumberMask"; //addon for vue-text-mask
// import FormError from '../FormError';
// import { FormWizard, TabContent } from "vue-form-wizard";
// import "vue-form-wizard/dist/vue-form-wizard.min.css";
import Datepicker from "vuejs-datepicker";
import VueTimepicker from "vue2-timepicker";
// quill require styles
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";

export default {
  mixins: [commonMixins],
  components: {
    // FormWizard,
    // TabContent,
    Datepicker,
    VueTimepicker,
    quillEditor,
    MaskedInput
  },
  props: {
    authorizations: { type: Object, required: true },
    mode0: { type: String, required: true },
    user0: { type: Object, required: true },
    eventtypes0: { type: Array, required: true },
    statuses0: { type: Array, required: true },
    event0: { type: Object, required: false },
    attachments0: { type: Array, required: false },
    organization0: { type: Object, required: false },
    team0: { type: Object, required: false },

    // user: {
    //   type: Object, default: null
    // },
    // roles: {
    //   type: Array, default: ()=>[]
    // },
    // permissions: {
    //   type: Array, default: ()=>[]
    // },
  },
  data() {
    return {
      navTitle: '',
      navLinks: [],
      tabIndex: 0,
      tabCount: 0,
      numberMask: createNumberMask({
        allowDecimal: true,
        integerLimit: 4,
        prefix: " $",
        suffix: ""
      }),
      numberMaskLimit: createNumberMask({
        allowDecimal: false,
        integerLimit: 3,
        prefix: "",
        suffix: ""
      }),
      isAddingFile: false,
      new_file: {},
      new_file_type: "",
      new_file_name: "",
      new_file_description: "",
      editorOption: {
        placeholder: "",
        readOnly: false,
        modules: {
          toolbar: [
            { header: [1, 2, 3, 4, false] },
            { 'size': ['small', false, 'large', 'huge'] },
            'bold', 'italic', 'underline', 'strike',
            {'list': 'ordered'}, { 'list': 'bullet' },
            { 'color': [] }, { 'background': [] },
            { 'indent': '-1'}, { 'indent': '+1' },
            { 'align': [] }
          ]
        }
      },
      ready: false,
      error_message: "",
      errors: [],
      organization: {},
      team: {},
      selEventType: {},
      event: {
        id: "",
        organization_id: "",
        team_id: "",
        subject: "",
        description: "",
        description_text: "",
        date_start: "",
        date_end: "",
        time_start: { hh: "08", mm: "00", a: "am" },
        time_end: { hh: "08", mm: "00", a: "am" },
        cost: "",
        event_type_id: "",
        limit: "",
        status_id: ""
      },
      attachments: [
        {
          id: "",
          file: {},
          type: "",
          original_filename: "",
          description: ""
        }
      ]
    };
  },
  mounted: function() {
    this.tabCount = this.$refs.mytabs.$children.length
    this.setMode(this.mode0);
    this.attachments = [];
    if (this.modeCreate) {
      this.navTitle = "Create Event"
      this.initialize();
    }
    if (this.modeShow) {
      this.navTitle = "View Event"
      this.editor.disable();
    }
    if (this.modeEdit) {
      this.navTitle = "Edit Event"
    }
    if (this.modeShow || this.modeEdit) {
      if (this.attachments0 != null && this.attachments0.length > 0) {
        this.attachments = this.attachments0;
      }
      if (!this.isObjectEmpty(this.event0)) {
        this.event.id = this.event0.id;
        this.event.subject = this.event0.subject;
        this.event.description = this.event0.description;
        this.event.description_text = this.event0.description_text;
        this.event.date_start = this.event0.date_start;
        this.event.date_end = this.event0.date_end;
        if (this.event0.time_start != null) {
          this.event.time_start = this.event0.time_start;
        }
        if (this.event0.time_end != null) {
          this.event.time_end = this.event0.time_end;
        }
        this.event.event_type_id = this.event0.event_type_id;
        this.event.status_id = this.event0.status_id;
        this.event.cost = this.event0.cost;
        this.event.signup_limit = this.event0.signup_limit;
        this.event.organization_id = this.event0.organization_id;
        this.event.team_id = this.event0.team_id;
      }
      if (!this.isObjectEmpty(this.organization0)) {
        this.organization = this.organization0;
        if (!this.isObjectEmpty(this.team0)) {
          this.team = this.team0;
        }
      }
    }
    this.$nextTick(function() {
      this.ready = true;
    });
  },
  updated: function() {
    // console.log('dom updated')
  },
  computed: {
    canCreateEvent() {
      return this.authorizations.can_create_event;
    },
    canShowEvent() {
      return this.authorizations.can_show_event;
    },
    canEditEvent() {
      return this.authorizations.can_update_event;
    },
    editor() {
      return this.$refs.myQuillEditor.quill;
    },
    eventTypeName() {
      let r = this.eventtypes0.find(x => {
        return x.id === this.event.event_type_id;
      });
      if (r) {
        return r.name;
      } else {
        return "";
      }
    },
    statusName() {
      let r = this.statuses0.find(x => {
        return x.id === this.event.status_id;
      });
      if (r) {
        return r.name;
      } else {
        return "";
      }
    }
  },
  watch: {
    currentMode() {
      this.mode_change();
    }
  },
  methods: {
    mode_change_create() {
      this.tabIndex = 0;
      this.setModeCreate();
      this.navTitle = "Create Event"
      this.editor.enable();
      this.initialize();
    },
    mode_change_edit() {
      this.setModeEdit();
      this.navTitle = "Edit Event"
      this.editor.enable()
    },
    mode_change_show() {
      this.setModeShow();
      this.navTitle = "View Event"
      this.editor.disable()
    },
    mode_change() {
      // <!-- :links="[{perm:'Create event', href:'/event/create', name:'Create Event', icon:'fa-plus'}]" -->
          if (this.modeShow) {
            this.navLinks = [
              {perm:'List events', href:'/event', click:null, name:'List', icon:'fa-list-ul fa-fw'},
              {perm:'Update event', href:'#', click:this.mode_change_edit, name:'Edit', icon:'fa-pencil-square-o fa-fw'},
              {perm:'Create event', href:'#', click:this.mode_change_create, name:'New', icon:'fa-plus-square-o fa-fw'}
            ]
          }
          if (this.modeEdit) {
            this.navLinks = [
              {perm:'Show event', href:'#', click:this.mode_change_show, name:'Cancel', icon:'fa-eye fa-fw'}
            ]
          }
          if (this.modeCreate) {
            this.navLinks = [
              {perm:'List events', href:'/event', click:null, name:'Cancel', icon:'fa-list-ul fa-fw'}
            ]
          }
    /*

    <template v-if="modeShow">
      <span v-tooltip.top="'List Events'" class="pull-right">
        <a  href="#" type="button" class="text-info"
          @click="goToLocation('/event')">
          <i class="fa fa-list-ul fa-3x fa-fw text-info"></i>
        </a>
      </span>
      <span v-show="canEditEvent" v-tooltip.top="'Edit Event'" class="pull-right">
        <a  href="#" type="button" class="text-warning"
          @click="setModeEdit(); editor.enable();">
          <i class="fa fa-pencil-square-o fa-3x fa-fw text-warning"></i>
        </a>
      </span>
      <span v-show="canCreateEvent" v-tooltip.top="'Create Event'" class="pull-right">
        <a  href="#" type="button" class="text-success"
          @click="setModeCreate(); editor.enable(); initialize();">
          <i class="fa fa-plus-square-o fa-3x fa-fw text-success"></i>
        </a>
      </span>
    </template>
    <template v-if="modeEdit">
      <span v-tooltip.top="'Cancel Edit'" class="pull-right">
        <a  href="#" type="button" class="text-success"
          @click="setModeShow(); editor.disable();">
          <i class="fa fa-eye fa-3x fa-fw text-success"></i>
        </a>
      </span>
    </template>
    <template v-if="modeCreate">
      <span v-tooltip.top="'Cancel Create'" class="pull-right">
        <a  href="#" type="button" class="text-success"
          @click="goToLocation('/event')">
          <i class="fa fa-list-ul fa-3x fa-fw text-danger"></i>
        </a>
      </span>
    </template>
     */
    },
    initialize() {
      // console.log("initialize");
      this.mode_change();
      this.attachments = [];
      this.event.id = 0;
      this.event.subject = "";
      this.event.description = "";
      this.event.description_text = "";
      this.event.date_start = new Date();
      this.event.date_end = new Date();
      this.event.event_type_id = 1;
      this.event.status_id = 1;
      this.event.cost = "";
      this.event.signup_limit = "";
    },
    formatOrgTeam() {
      let r = this.organization.name;
      if (this.team.name) {
        r += " / " + this.team.name;
      }
      return r;
    },
    formatTimePicker(timePickerString) {
      return (
        timePickerString.hh +
        ":" +
        timePickerString.mm +
        " " +
        timePickerString.a
      );
    },
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
      // console.log(text)
      this.event.description_text = text;
    },
    toggleIsAddingFile() {
      this.isAddingFile = !this.isAddingFile;
      this.new_file = null;
      this.new_file_type = "";
      this.new_file_name = "";
      this.new_file_description = "";
    },
    processFile: function() {
      // let reader = new FileReader();
      // let vm = this;
      // reader.onload = (e) => {
      //   vm.new_file = e.target.result;
      // };
      // reader.readAsDataURL(event.target.files[0]);
      // console.log(event.target.files[0]);
      this.new_file = event.target.files[0];
      this.new_file_name = event.target.files[0].name;
      this.new_file_type = event.target.files[0].type;
      // console.log(this.new_file_name)
    },
    addFileToList: function() {
      //add file to list of attachments
      // this.isAddingFile = false;
      if (!this.new_file) {
        return;
      }
      this.attachments.push({
        id: 0,
        file: this.new_file,
        type: this.new_file_type,
        original_filename: this.new_file_name,
        description: this.new_file_description
      });
      //Reset input type="file".
      const input = this.$refs.fileInput;
      input.type = "text";
      input.type = "file";
      this.new_file = null;
    },
    removeFile: function(file) {
      let message = "<i>Delete Attachment?</i>";
      this.$dialog
        .confirm(message, {})
        .then(dialog => {
          axios({
            method: "delete",
            url: "/api/document/" + file.id
          })
            .then(response => {
              dialog.close();
              this.attachments = this.attachments.filter(e => {
                return !(
                  e.original_filename == file.original_filename &&
                  e.description == file.description
                );
              });
            })
            .catch(error => {
              this.error_message = "Error trying to delete attachment";
              dialog.close();
              console.log(error);
              var self = this;
              setTimeout(function() {
                self.setStatusInitial();
              }, MESSAGE_DURATION + 1000);
            });
        })
        .catch(() => {
          //console.log('Clicked on cancel')
        });
    },
    setInitialEndTime: function(timePicker) {
      // console.log(timePicker)
      this.event.time_start.hh = timePicker.data.hh;
      this.event.time_start.mm = timePicker.data.mm;
      this.event.time_start.a = timePicker.data.a;
      this.event.time_end = this.event.time_start;
    },
    wizardOnComplete: function() {
      if (this.modeShow) {
        return;
      }
      this.errors = [];
      let message = "<i>Confirm saving this event</i>";
      this.$dialog
        .confirm(message, {})
        .then(dialog => {
          this.sendData();
          dialog.close();
        })
        .catch(() => {
          //console.log('Clicked on cancel')
        });
    },
    sendData: function() {
      this.tabIndex = 0;
      let method = "post";
      let url = "/api/event";
      if (this.modeShow) {
        return; //shouldn't be here at all
      } else if (this.modeEdit) {
        method = "put";
        url += "/" + this.event.id;
      }
      let data = {
        auth_user_id: this.user0.id,
        organization_id: this.event.organization_id,
        event: this.event
      };
      if (this.event.team_id != undefined && this.event.team_id != null) {
        data.team_id = this.event.team_id;
      }
      axios({
        method: method,
        url: url,
        data: data
      })
        .then(response => {
          this.event.id = response.data.id;
          let promises = [];
          for (let x = 0; x < this.attachments.length; x++) {
            let a = this.attachments[x];
            if (a.id === 0) {
              //newly added file
              promises.push(this.uploadFile(a, x));
            }
          }
          // console.log("promises", promises);
          if (promises === undefined || promises === null) {
            this.mode_change_show();
            // this.$refs.form_wizard.changeTab(2, 0);
          } else {
            axios
              .all(promises)
              .then(response => {
                // console.log("all good", response);
                response.forEach(r => {
                  let id = r.data.id;
                  let ndx = parseInt(r.data.echo);
                  this.attachments[ndx].id = id;
                  this.attachments[ndx].file = {};
                });
                this.mode_change_show();
                // this.$refs.form_wizard.changeTab(2, 0);
              })
              .catch(e => {
                throw e;
              });
          }
        })
        .catch(error => {
          console.log(error);
          this.event.id = 0; //also indicates an error occurred
          this.setStatusFailed();
          if (error.response.status == 422) {
            let messages = error.response.data.errors;
            let self = this;
            $.each(messages, function(k, v) {
              for (let i = 0; i < v.length; i++) {
                self.errors.push(v[i]);
              }
            });
          } else {
            this.errors.push(error.response.data);
            console.log(error.response.data);
          }
          var self = this;
          setTimeout(function() {
            self.setStatusInitial();
          }, MESSAGE_DURATION + 1000);
        });
    },
    viewFile: function(attachment) {
      window.open("/api/document/" + attachment.id, "_blank");
      return;
    },
    uploadFile: function(attachment, index) {
      let formData = new FormData();
      formData.append("auth_user_id", this.user0.id);
      formData.append("organization_id", this.event.organization_id);
      if (this.event.team_id != undefined && this.event.team_id != null) {
        //optional field
        formData.append("team_id", this.event.team_id);
      }
      formData.append("event_id", this.event.id);
      formData.append(
        "attachment",
        attachment.file,
        attachment.original_filename
      );
      formData.append("description", attachment.description);
      formData.append("echo", index);
      return axios({
        method: "post",
        url: "/api/document",
        data: formData
      });
    },
    setOrgTeam: function(orgid, teamid, organization, team) {
      // console.log('setOrgTeam orgid', orgid)
      // console.log('setOrgTeam teamid', teamid)
      // console.log('setOrgTeam organization', organization)
      // console.log('setOrgTeam team', team)
      this.event.organization_id = orgid;
      this.event.team_id = teamid;
      this.organization = organization;
      this.team = team;
    }
  } //End of methods
}; //End of export
</script>

<style lang="css" scoped>
.instruction {
  font-size: 16px;
}
label {
  padding: 0px;
  margin: 0px;
}
input {
  padding-left: 0;
  width: 100%;
}
.vdp-datepicker .form-control[readonly] {
    background-color: white;
    opacity: 1;
}
span {
  width: 100%;
}
.mytab {
  min-height: 230px;
}
select {
  margin-top: 5px;
}
</style>
