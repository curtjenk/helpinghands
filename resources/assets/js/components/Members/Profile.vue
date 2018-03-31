<template>
<div class="">
  <div class="row my-2 mt-4">
    <div class="col-lg-8 col-md-8 order-lg-2 order-md-2 card">
      <div class="card-body">
        <ul class="nav nav-tabs nav-fill">
            <li class="nav-item">
                <button data-target="#personal" data-toggle="tab" class="nav-link active selected-tab">
                  <span class="fa fa-star" aria-hidden="true"></span>
                  <div class="hidden-xs">Personal</div>
                </button>
            </li>
            <li class="nav-item">
                <button data-target="#preferences" data-toggle="tab" class="nav-link btn">
                  <span class="fa fa-heart" aria-hidden="true"></span>
                  <div class="hidden-xs">Preferences</div>
                </button>
            </li>
            <li class="nav-item">
                <button data-target="#memberships" data-toggle="tab" class="nav-link btn btn-default">
                  <span class="fa fa-sitemap" aria-hidden="true"></span>
                  <div class="hidden-xs">Membership</div>
                </button>
            </li>
            <li class="nav-item">
                <button data-target="#credentials" data-toggle="tab" class="nav-link btn btn-default">
                  <span class="fa fa-key" aria-hidden="true"></span>
                  <div class="hidden-xs">Credentials</div>
                </button>
            </li>
        </ul>
        <div class="tab-content py-4">
          <div class="tab-pane active" id="personal">
            <div class="row">
              <div class=" mx-auto">
                <div class="alert alert-success alert-dismissable" v-if="updateSuccess" transition="expand">Your information was updated.</div>
                <div class="alert alert-danger alert-dismissable" v-if="updateFailed" transition="expand">
                    Sorry, unable to update your information at this time.
                </div>
              </div>
            </div>
            <form role="form">
              <div class="form-group row">
                  <label for="name" class="col-lg-3 col-md-3 col-form-label form-control-label">Name</label>
                  <div class="col-lg-8 col-md-8">
                      <input id="name" v-model="user.name" type="text" class="editInfo" name="name" maxlength="255">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="nickname" class="col-lg-3 col-md-3 col-form-label form-control-label">Nick Name</label>
                  <div class="col-lg-8 col-md-8">
                    <input id="nickname" v-model="user.nickname" type="text" class="editInfo" name="nickname" maxlength="255">
                  </div>
                </div>
              <div class="form-group row">
                  <label for="phone1" class="col-lg-3 col-md-3 col-form-label form-control-label">Phone 1</label>
                  <div class="col-lg-8 col-md-8">
                    <masked-input id="phone1" name="phone1" type="tel" class="editInfo"
                        v-model="user.homephone"
                        :mask="['(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]">
                    </masked-input>
                  </div>
              </div>
              <div class="form-group row">
                <label for="phone2" class="col-lg-3 col-md-3 col-form-label form-control-label">Phone 2</label>
                <div class="col-lg-8 col-md-8">
                  <masked-input id="phone2" name="phone2" type="tel" class="editInfo"
                        v-model="user.mobilephone"
                        :mask="['(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]">
                  </masked-input>
                </div>
              </div>
              <div class="row block text-center">
                <div class="col-md-offset-1 col-md-2">
                  <button type="submit" class="btn btn-primary" name="submit" @click.prevent="update">
                    <i class="fa fa-btn fa-check"></i> Update Information
                  </button>
                </div>.
                <div class="col-md-7"></div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="preferences">
            <div class="row">
              <div class=" mx-auto">
                <div class="alert alert-success alert-dismissable" v-if="updateSuccess" transition="expand">Your preferences were updated.</div>
                <div class="alert alert-danger alert-dismissable" v-if="updateFailed" transition="expand">
                    Sorry, unable to update your preferences at this time.
                </div>
              </div>
            </div>
            <div class="row">
              <toggle-button v-model="user.opt_receive_evite"
                :sync="true"
                :value="user.opt_show_email"
                :labels="{checked: 'Yes, send me invitations', unchecked: 'Please don\'t send invitations' }"
                :color="{checked: togOpts.colors.checked, unchecked: togOpts.colors.unchecked}"
                :height="togOpts.height"
                :width="togOpts.width"
              ></toggle-button>
            </div>
            <div class="row">
              <toggle-button v-model="user.opt_show_email"
                :sync="true"
                :value="user.opt_show_email"
                :labels="{checked: 'Show my email address', unchecked: 'Hide my email address' }"
                :color="{checked: togOpts.colors.checked, unchecked: togOpts.colors.unchecked}"
                :height="togOpts.height"
                :width="togOpts.width"
              ></toggle-button>
            </div>
            <div class="row">
              <toggle-button v-model="user.opt_show_mobilephone"
                :sync="true"
                :value="user.opt_show_mobilephone"
                :labels="{checked: 'Show my phone 1', unchecked: 'Hide my phone 1' }"
                :color="{checked: togOpts.colors.checked, unchecked: togOpts.colors.unchecked}"
                :height="togOpts.height"
                :width="togOpts.width"
              ></toggle-button>
            </div>
            <div class="row">
              <toggle-button v-model="user.opt_show_homephone"
                :sync="true"
                :value="user.opt_show_homephone"
                :labels="{checked: 'Show my phone 2', unchecked: 'Hide my phone 2'}"
                :color="{checked: togOpts.colors.checked, unchecked: togOpts.colors.unchecked}"
                :height="togOpts.height"
                :width="togOpts.width"
              ></toggle-button>
            </div>
            <div class="row mt-3">
              <div class="">
                <button type="submit" class="btn btn-primary" name="submit" @click="update">
                  <i class="fa fa-btn fa-check"></i> Update Preferences
                </button>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="memberships">
            <div class="row">
              <div class=" mx-auto">
                <div class="alert alert-success alert-dismissable" v-if="updateSuccess" transition="expand">Your memberships were updated.</div>
                <div class="alert alert-danger alert-dismissable" v-if="updateFailed" transition="expand">
                    Sorry, unable to update your memberships at this time.
                </div>
              </div>
            </div>
            <span v-for="org in this.orgData">
              <div class="row">
                <span v-if="org.teams.length" @click="org.editing = !org.editing">
                  <i class="fa fa-lg" :class="org.editing ? 'fa-minus-circle' : 'fa-plus-circle'">&nbsp;</i>
                </span>
                <span v-else>
                  <i class="fa fa-lg fa-circle-o">&nbsp;</i>
                </span>
                <div>
                  <input class="orgcheck" type="checkbox" :checked="org.checked" v-model="org.checked" @change="uncheckTeams(org)">
                </div>
                <div>
                  <span href="#" type="link" @click="org.editing = !org.editing">{{ org.name }}</span>
                  <span v-if="org.editing">
                    <template v-for="team in org.teams" >
                      <div>
                        <input class="teamcheck" type="checkbox" :checked="team.checked" v-model="team.checked" :disabled="!org.checked">{{ team.name}}
                      </div>
                    </template>
                  </span>
                </div>
              </div>
            </span>
            <div class="row mt-3">
              <div class="">
                <button type="submit" class="btn btn-primary" name="submit" @click="update">
                  <i class="fa fa-btn fa-check"></i> Update Membership
                </button>
              </div>.
            </div>
          </div>

          <div class="tab-pane" id="credentials">

        </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-3 order-lg-1 order-md-1 text-center">
      <img v-if="avatar_url" :src="avatar_url" class="mx-auto img-fluid img-circle d-block" alt="avatar">
      <img v-else src="//placehold.it/150" class="mx-auto img-fluid img-circle d-block" alt="avatar">
      <h6 class="mt-2">Upload a different photo</h6>
      <label class="custom-file">
        <b-form-file v-model="file" ref="fileinput" :name="newavatar"
          @change="filesChange($event.target.name, $event.target.files)"
          class="mt-2 custom-file-input" plain accept="image/*"
        ></b-form-file>
        <span class="custom-file-control btn btn-primary">Choose file</span>
      </label>
    </div>
  </div>
</div>
</template>

<script>
import MaskedInput from 'vue-text-mask';
import VuePassword from 'vue-password';
import VeeValidate from 'vee-validate';
import { Validator } from 'vee-validate';

// Vue.use(VeeValidate);
Vue.use(VeeValidate, {
  errorBagName: 'vErrors',
  fieldsBagName: 'vformFields'
})

const MESSAGE_DURATION = 2500;
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
  components: {
    MaskedInput, VuePassword
  },
  props: {
    user0: {
      type: Object,
      required: true
    },
    orgteams0: {
      type: Array,
      required: true
    },
    avatar0: {
      type: String
    }
  },
  data () {
    return {
      togOpts: {
        height:24,
        width:240,
        colors: {checked: '#7ed47e', unchecked: '#d06e6e'}
      },
      credential: '',
      credentialMessage: '',
      newEmail: '',
      oldPassword: '',
      newPassword: '',
      newPasswordConfirm: '',
      updateStatus: null,
      user: {},
      avatar_url: '',
      file: null,
      uploadedFiles: [],
      uploadError: null,
      currentStatus: null,
      newavatar: 'photo',
      orgData: [
        {id:1, name: 'Org 1', checked: true, editing: false,
            teams: [
                {id:1, name: 'Team 1', checked: false},
                {id:2, name: 'Team 2', checked: true}
            ]},
        {id:2, name: 'Org 2', checked: true, editing: false,
            teams: []},
        {id:3, name: 'Org 3', checked: false, editing: false,
            teams: [{id:1, name: 'Team 1', checked: false}]},
      ]
    }
  },
  mounted: function () {
    // this.$nextTick(function () {  // Code that will run only after the entire view has been rendered
    this.user = this.user0;
    this.avatar_url = this.avatar0;
    this.resetAvatar();
    this.orgData = [];

    this.orgteams0.forEach( org0 => {
        let teams = [];
        let userOrgCheckedItem=null;
        //look if the user is in this organization
        this.user.organizations.forEach( userOrgItem => {
          if (userOrgItem.id == org0.id) {
            userOrgCheckedItem=userOrgItem;
          }
        })
        org0.teams.forEach( team0 => {
          let isChecked=false;
          if (userOrgCheckedItem != null) {
            this.user.teams.forEach (userTeamItem => {
              if (userTeamItem.id == team0.id)
                isChecked = true;
            })
          }
          teams.push({id:team0.id, name:team0.name, checked: isChecked});
        })
        let isChecked = userOrgCheckedItem != null ? true: false;
        this.orgData.push({id: org0.id, name: org0.name,
            checked: isChecked, editing: false, teams: teams});
      });

    // })
  },
  computed: {
    isInitial() {
      return this.currentStatus === STATUS_INITIAL;
    },
    isSaving() {
      return this.currentStatus === STATUS_SAVING;
    },
    isSuccess() {
      return this.currentStatus === STATUS_SUCCESS;
    },
    isFailed() {
      return this.currentStatus === STATUS_FAILED;
    },
    updateSuccess() {
      return this.updateStatus === STATUS_SUCCESS;
    },
    updateFailed() {
      return this.updateStatus === STATUS_FAILED;
    }
  },
  watch: {
    // newPasswordConfirm () {
    //   console.log(this.newPasswordConfirm);
    // }
  },
  methods: {
    uncheckTeams (org) {
     if (!org.checked) {
        for (let i=0; i<org.teams.length; i++) {
          org.teams[i].checked = false;
        }
      }
    },
    resetAvatar() {
        // reset form to initial state
        this.currentStatus = STATUS_INITIAL;
        this.uploadedFiles = [];
        this.uploadError = null;
    },
    update() {
      var url = '/api/member/' + this.user.id;
      axios.put(url, {user: this.user, org: this.orgData})
      .then(  (response) => {
        // console.log(response)
        this.updateStatus = STATUS_SUCCESS;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
            // window.location.reload();
        }, MESSAGE_DURATION);
      }).catch((error) => {
        // console.log(error)
        this.updateStatus = STATUS_FAILED;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION + 1000);
      });
    },
    updateEmail() {
      this.credential = 'Email';
      var url = '/api/member/' + this.user.id + '/email';
      axios.put(url, {newEmail: this.newEmail})
      .then(  (response) => {
        // console.log(response)
        this.user.email = this.newEmail;
        this.newEmail = '';
        this.updateStatus = STATUS_SUCCESS;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION);
      }).catch((error) => {
        // console.log(error.response)
        if (error.response.data == 'unavailable') {
          this.credentialMessage = 'email already in use.  Try another email';
        } else {
          this.credentialMessage = 'unable to change your email. Try later';
        }
        this.updateStatus = STATUS_FAILED;

        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION + 1000);
      });
    },
    updatePassword() {
      this.credential = 'Password';
      var url = '/api/member/' + this.user.id + '/password';
      axios.put(url, {
        oldPassword: this.oldPassword,
        newPassword: this.newPassword,
        newPasswordConfirm: this.newPasswordConfirm,
        })
      .then(  (response) => {
        console.log(response)
        this.updateStatus = STATUS_SUCCESS;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION);
      }).catch((error) => {
        console.log(error.response)
        if (error.response.data == 'verify') {
          this.credentialMessage = 'please verify your input';
        } else {
          this.credentialMessage = 'unable to change your password. Try later';
        }
        this.updateStatus = STATUS_FAILED;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION + 1000);
      });
    },
    saveAvatar(formData) {
      // upload photo to the server
      this.currentStatus = STATUS_SAVING;
      var url = '/api/member/' + this.user.id  + '/avatar';
      axios.post(url, formData)
      .then(  (response) => {
        this.uploadedFiles = [].concat(response);
        this.currentStatus = STATUS_SUCCESS;
        window.location.reload();
      }).catch((error) => {
        this.uploadError = error.response;
        this.currentStatus = STATUS_FAILED;
        console.log(error)
      });
    },
    filesChange(fieldName, fileList) {
      // handle file changes
      // TODO: Now only doing single file upload.
      // This method can be simplified
      const formData = new FormData();

      if (!fileList.length) return;

      // append the files to FormData
      Array
        .from(Array(fileList.length).keys())
        .map(x => {
          formData.append(fieldName, fileList[x], fileList[x].name);
        });
      // save it
      this.saveAvatar(formData);

    },
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
.nav-tabs .nav-link.active {
  color: ghostwhite;
  background-color: #3D8AE9;
}
.vue-js-switch {
  font-size: 16px;
}
.orgcheck {
  margin-left: 1px;
  margin-right: 5px;
}
.teamcheck {
  margin-left: 5px;
  margin-right: 5px;
}
.orgbox {
  font-weight: bold;
  /* background: #efeded; */
  padding: 2px 2px;
}
.teambox {
  padding-left: 20px;
  background: white;
}
</style>
