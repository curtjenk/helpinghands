<template>
  <div class="col-lg-12 col-sm-12">
  <div class="col-md-4 col-sm-3">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" v-if="avatar_url" :src="avatar_url">
            <img class="card-bkimg" alt="" v-else src="http://lorempixel.com/150/150/people/3/">
        </div>
        <div class="useravatar">
            <img class="" alt="" v-if="avatar_url" :src="avatar_url">
            <img class="" alt="" v-else src="http://lorempixel.com/150/150/people/3/">
        </div>
    </div>
  </div>
  <div class="col-md-8 col-sm-9">
    <div class="btn-pref btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button v-on:click="changetab(0)" type="button" id="myinfo" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="fa fa-star" aria-hidden="true"></span>
                <div class="hidden-xs">Personal Information</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(1)" type="button" id="myprefs" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="fa fa-heart" aria-hidden="true"></span>
                <div class="hidden-xs">Preferences</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(2)" type="button" id="organizations" class="btn btn-default" href="#tab3" data-toggle="tab">
              <span class="fa fa-sitemap" aria-hidden="true"></span>
              <div class="hidden-xs">Membership</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(3)" type="button" id="mypswd" class="btn btn-default" href="#tab4" data-toggle="tab">
              <span class="fa fa-key" aria-hidden="true"></span>
              <div class="hidden-xs">Username/Password</div>
            </button>
        </div>
    </div>

    <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
          <div class="form-horizontal">
            <div class="row">
              <div class="alert alert-success" v-if="updateSuccess" transition="expand">Your information was updated.</div>
              <div class="alert alert-danger" v-if="updateFailed" transition="expand">
                  Sorry, unable to update your information at this time.
              </div>
            </div>
            <div class="row">
              <div class="col-md-5 col-sm-5">
                <div class="form-group">
                    <label for="name" class="col-md-3 col-sm-4 control-label">Name</label>
                    <div class="col-md-5 col-sm-6">
                        <input id="name" v-model="user.name" type="text" class="editInfo" name="name" maxlength="255">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nickname" class="col-md-3 col-sm-4 control-label">Nick Name</label>
                    <div class="col-md-5 col-sm-6">
                      <input id="nickname" v-model="user.nickname" type="text" class="editInfo" name="nickname" maxlength="255">
                    </div>
                  </div>
                <div class="form-group">
                    <label for="phone1" class="col-md-3 col-sm-4 control-label">Phone 1</label>
                    <div class="col-md-5 col-sm-6">
                      <input id="phone1" v-model="user.homephone" type="tel" v-mask="'(###) ###-####'"
                        placeholder="" class="editInfo" name="phone1">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone2" class="col-md-3 col-sm-4 control-label">Phone 2</label>
                    <div class="col-md-5 col-sm-6">
                      <input id="phone2" v-model="user.mobilephone" type="text" v-mask="'(###) ###-####'"
                        placeholder="" class="editInfo" name="phone2">
                    </div>
                  </div>
              </div>
              <div class="col-md-4 col-sm-5">
                <!-- <div class="form-group"> -->
                <!-- <form enctype="multipart/form-data" novalidate v-if="isInitial || isSaving"> -->
                <form enctype="multipart/form-data" novalidate>
                  <div class="dropbox">
                    <input id="newavatar" class="" :name="newavatar" :disabled="isSaving" type="file"
                        @change="filesChange($event.target.name, $event.target.files); fileCount=$event.target.files.length" accept="image/*"
                        class="input-file"/>
                    <p v-if="isInitial">
                        Drag your picture here <br />  or click to browse
                    </p>
                    <p v-if="isSaving">
                      Uploading {{ fileCount }} files...
                    </p>
                  </div>
                </form>
                <div v-if="isFailed">
                    <div>Upload Failed</div>
                    <pre>{{ uploadError }}</pre>
                </div>
              </div>
              <div class="col-md-4 col-sm-4"></div>
            </div>
            <br>
            <div class="row block text-center">
              <div class="col-md-offset-1 col-md-2">
                <button type="submit" class="btn btn-primary" name="submit" @click="update">
                  <i class="fa fa-btn fa-check"></i> Update Information
                </button>
              </div>.
              <div class="col-md-7"></div>
            </div>
          </div>
        </div>
        <!--End of tab1  -->
        <div class="tab-pane fade in" id="tab2">
          <!-- <div class="form-horizontal"> -->
            <div class="row">
              <div class="alert alert-success" v-if="updateSuccess" transition="expand">Your preferences were updated.</div>
              <div class="alert alert-danger" v-if="updateFailed" transition="expand">
                  Sorry, unable to update your preferences at this time.
              </div>
            </div>
            <div class="row">
              <div class="col-md-offset-2 col-sm-offset-2 col-md-4 col-sm-4">
                <!-- <toggle-button v-model="user.opt_receive_evite"
                  :sync="true"
                  :value="user.opt_receive_evite"
                  :labels="{checked: 'I want Evites', unchecked: 'I don\'t want Evites' }"
                  :width="150"
                ></toggle-button> -->
                <toggle-button v-model="user.opt_show_email"
                  :sync="true"
                  :value="user.opt_show_email"
                  :labels="{checked: 'Show My Email Address', unchecked: 'Hide My Email Address' }"
                  :width="150"
                ></toggle-button>

                <toggle-button v-model="user.opt_show_mobilephone"
                  :sync="true"
                  :value="user.opt_show_mobilephone"
                  :labels="{checked: 'Show My Phone 1', unchecked: 'Hide My Phone 1' }"
                  :width="150"
                ></toggle-button>
                <toggle-button v-model="user.opt_show_homephone"
                  :sync="true"
                  :value="user.opt_show_homephone"
                  :labels="{checked: 'Show My Phone 2', unchecked: 'Hide My Phone 2'}"
                  :width="150"
                ></toggle-button>

              </div>
              <div class="col-md-5 col-sm-5"></div>
            </div>
            <br>
            <div class="row block text-center">
              <div class="col-md-offset-1 col-md-5 col-sm-5">
                <button type="submit" class="btn btn-primary" name="submit" @click="update">
                  <i class="fa fa-btn fa-check"></i> Update Preferences
                </button>
              </div>
              <div class="col-md-6"></div>
            </div>
          <!-- </div> -->
        </div>
        <!--End of tab2  -->
        <div class="tab-pane fade in" id="tab3">
          <div class="row">
            <div class="alert alert-success" v-if="updateSuccess" transition="expand">Your memberships were updated.</div>
            <div class="alert alert-danger" v-if="updateFailed" transition="expand">
                Sorry, unable to update your memberships at this time.
            </div>
          </div>
          <div class="col-md-offset-1 col-sm-offset-1 orgbox" v-for="org in this.orgData">
              <i  v-if="org.teams.length" @click="org.editing = !org.editing" class="fa fa-lg" :class="org.editing ? 'fa-minus-circle' : 'fa-plus-circle'">&nbsp;</i>
              <i  v-else class="fa fa-lg fa-circle-o">&nbsp;</i>
              <input class="orgcheck" type="checkbox" :checked="org.checked" v-model="org.checked" @change="uncheckTeams(org)">
              <span @click="org.editing = !org.editing">{{ org.name }}</span>
              <div>
                <div v-for="team in org.teams" v-show="org.editing" class="teambox">
                  <input class="teamcheck" type="checkbox" :checked="team.checked" v-model="team.checked" :disabled="!org.checked">{{ team.name}}
                </div>
              </div>
          </div>
          <br>
          <div class="row block text-center">
            <div class="col-md-offset-1 col-sm-offset-2 col-md-2 col-sm-2">
              <button type="submit" class="btn btn-primary" name="submit" @click="update">
                <i class="fa fa-btn fa-check"></i> Update Membership
              </button>
            </div>.
            <div class="col-md-7 col-sm-7"></div>
          </div>
        </div>
        <div class="tab-pane fade in" id="tab4">
          <div class="form-horizontal">
            <div class="row">
              <div class="alert alert-success" v-if="updateSuccess" transition="expand">Your {{ credential }} was updated.</div>
              <div class="alert alert-danger" v-if="updateFailed" transition="expand">
                  <span>Sorry, {{ credentialMessage }}.</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label class="col-md-4 col-sm-4 control-label">Current Email</label>
                    <div class="col-md-7 col-sm-7">
                      <input type="text" class="editInfo" maxlength="255" :value="user.email" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 col-sm-4 control-label">New Email</label>
                    <div class="col-md-7 col-sm-7">
                        <input v-validate="'email'" id="email" v-model="newEmail" type="email" class="editInfo" name="email" maxlength="255">
                        <span v-show="vErrors.has('email')" class="alert alert-danger">{{ vErrors.first('email') }}</span>
                    </div>
                </div>
                <br>
                <div class="row block text-center">
                  <div class="col-md-offset-5 col-md-5">
                    <button type="submit" class="btn btn-primary" name="submit" @click="updateEmail">
                      <i class="fa fa-btn fa-check"></i> Change Username
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="oldpassword" class="col-md-4 col-sm-4 control-label">Old Password</label>
                    <div class="col-md-7 col-sm-7">
                      <input id="oldpassword" v-model="oldPassword" name="oldpassword" type="password" class="editInfo" maxlength="255">
                    </div>
                </div>
                <div class="form-group">
                    <label for="newpassword" class="col-md-4 col-sm-4 control-label">New Password</label>
                    <div class="col-md-7 col-sm-7">
                      <vue-password id="newpassword" v-model="newPassword" name="newpassword"
                        classes="bgInherit"
                        :user-inputs="[user.email]"
                        ></vue-password>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newpasswordconfirm" class="col-md-4 col-sm-4 control-label">Confirm Password</label>
                    <div class="col-md-7 col-sm-7">
                      <input v-validate="'required|confirmed:newpassword'" data-vv-as="password" id="newpasswordconfirm" v-model="newPasswordConfirm" name="newpasswordconfirm" type="password" class="editInfo" maxlength="255">
                      <span v-show="vErrors.has('newpasswordconfirm')" class="alert alert-danger">{{ vErrors.first('newpasswordconfirm') }}</span>
                    </div>
                </div>
                <br>
                <div class="row block text-center">
                  <div class="col-md-offset-5 col-md-5">
                    <button type="submit" class="btn btn-primary" name="submit" @click="updatePassword">
                      <i class="fa fa-btn fa-check"></i> Change Password
                    </button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
  </div>
</template>

<script>
import {TheMask} from 'vue-the-mask';
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
    TheMask, VuePassword
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
      credential: '',
      credentialMessage: '',
      newEmail: '',
      oldPassword: '',
      newPassword: '',
      newPasswordConfirm: '',
      updateStatus: null,
      user: {},
      avatar_url: '',
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
    // this.avatar_url = this.avatar0;
    this.$nextTick(function () {  // Code that will run only after the entire view has been rendered
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

    })
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
    changetab: function (ndx) {
      var tabs = $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
      for (var i=0; i<tabs.length; i++) {
        if (i===ndx) {
          $(tabs[i]).removeClass("btn-default").addClass("btn-primary");
          break;
        }
      }
    }//End changetab
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
.alert {
  padding: 0px;
}
.bgInherit {
  background-color: inherit !important;
}
.orgcheck {
  margin-left: 1px;
  margin-right: 5px;
}
.teamcheck {
  margin-left: 20px;
  margin-right: 5px;
}
.orgbox {
  font-weight: bold;
  background: #efeded;
  padding: 2px 2px;
}
.teambox {
  padding-left: 20px;
  background: white;
}
/*  file upload            */
.dropbox {
    outline: 2px dashed grey; /* the dash box */
    outline-offset: -10px;
    background: lightcyan;
    color: dimgray;
    padding: 2px 2px;
    min-height: 50px; /* minimum height */
    position: relative;
    cursor: pointer;
  }

  .input-file {
    opacity: 0; /* invisible but it's there! */
    width: 50%;
    height: 50px;
    position: absolute;
    cursor: pointer;
  }

  .dropbox:hover {
    background: lightblue; /* when mouse over to the drop zone, change color */
  }

  .dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 25px 0;
  }
/*   */
label {
  padding-left: 0px;
  padding-right:0px;
}
.cbSwitch {
  margin-top: 3px;
}
.editInfo {
  background-color: #f5f5f5;
}
.well {
  border-radius: 0px;
  font-size: 12px;
}
/* USER PROFILE PAGE */
 .card {
    margin-top: 5px;
    padding: 30px;
    background-color: rgba(214, 224, 226, 0.2);
    -webkit-border-top-left-radius:5px;
    -moz-border-top-left-radius:5px;
    border-top-left-radius:5px;
    -webkit-border-top-right-radius:5px;
    -moz-border-top-right-radius:5px;
    border-top-right-radius:5px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.card.hovercard {
    position: relative;
    padding-top: 0;
    overflow: hidden;
    text-align: center;
    background-color: #fff;
    background-color: rgba(255, 255, 255, 1);
}
.card.hovercard .card-background {
    height: 200px;
}
.card-background img {
    -webkit-filter: blur(25px);
    -moz-filter: blur(25px);
    -o-filter: blur(25px);
    -ms-filter: blur(25px);
    filter: blur(25px);
    margin-left: -100px;
    margin-top: -200px;
    min-width: 130%;
}
.card.hovercard .useravatar {
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
}
.card.hovercard .useravatar img {
    width: 200px;
    height: 200px;
    max-width: 200px;
    max-height: 200px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    border: 5px solid rgba(255, 255, 255, 0.5);
}
.card.hovercard .card-info {
    position: absolute;
    bottom: 14px;
    left: 0;
    right: 0;
}
.card.hovercard .card-info .card-title {
    padding:0 5px;
    font-size: 20px;
    line-height: 1;
    color: #262626;
    background-color: rgba(255, 255, 255, 0.1);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
.card.hovercard .card-info {
    overflow: hidden;
    font-size: 12px;
    line-height: 20px;
    color: #737373;
    text-overflow: ellipsis;
}
.card.hovercard .bottom {
    padding: 0 20px;
    margin-bottom: 17px;
}
.btn-pref .btn {
    -webkit-border-radius:0 !important;
}

</style>
